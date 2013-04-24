<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page import="beach_nourishment.PSDSToken" %>
<%@ page import="com.google.gdata.client.*" %>
<%@ page import="com.google.gdata.client.docs.*" %>
<%@ page import="com.google.gdata.client.spreadsheet.*" %>
<%@ page import="com.google.gdata.client.authn.oauth.*" %>
<%@ page import="com.google.gdata.data.MediaContent" %>
<%@ page import="com.google.gdata.data.PlainTextConstruct" %>
<%@ page import="com.google.gdata.data.acl.*" %>
<%@ page import="com.google.gdata.data.docs.DocumentListEntry" %>
<%@ page import="com.google.gdata.data.docs.DocumentListFeed" %>
<%@ page import="com.google.gdata.data.spreadsheet.*" %>
<%@ page import="com.google.gdata.data.extensions.*" %>
<%@ page import="com.google.gdata.util.*" %>
<%@ page import="java.net.URL" %>
<%@ page import="java.util.Calendar" %>
<%@ page import="java.text.SimpleDateFormat" %>
<%
/**
 * @version 8/22
 * @author  Russel Gaskey
 * @author  Cristina Korb
 * @author  Brian M. Lenau
 *
 * This file contains all of the logic that is used to create the index page
 * for the website.
 */

Calendar         calendar = Calendar.getInstance();
SimpleDateFormat sdf      = new SimpleDateFormat("yyyy-MM-dd");
String           date     = sdf.format(calendar.getTime());

Cookie[] cookieArray = request.getCookies();

String token       = null;
String tokenSecret = null;

if (cookieArray != null) {
    for (Cookie c : cookieArray) {
        if (c.getName().equals("beachAccessToken")) {
            token = c.getValue();
        } else if (c.getName().equals("beachAccessSecret")) {
            tokenSecret = c.getValue();
        }
    }
}
if (token == null || tokenSecret == null || cookieArray == null) {  
%>
<script type="text/javascript">
  window.location = "index";
</script>
<%
} else {
    /** 
     * The URL where the server is located that is used as the consumer secret
     * for the Google authentication.
     */
    String CONSUMER_KEY = request.getServerName();
    
    /**
     * The string that was supplied by Google when the server was registered to be
     * used with Google authentication.
     */
    String CONSUMER_SECRET = "rWwoyDP2xRUc-fJsHN71DUkh";
    
    GoogleOAuthParameters oauthParameters = new GoogleOAuthParameters();
    GoogleOAuthParameters psdsOAuthParameters = new GoogleOAuthParameters();
    
    /*
     * Initialize the OAuth parameters with the information needed to authenticate
     * it.
     */
    oauthParameters.setOAuthConsumerKey(CONSUMER_KEY);
    oauthParameters.setOAuthConsumerSecret(CONSUMER_SECRET);
    oauthParameters.setOAuthToken(token);
    oauthParameters.setOAuthTokenSecret(tokenSecret);
    
    psdsOAuthParameters.setOAuthConsumerKey(CONSUMER_KEY);
    psdsOAuthParameters.setOAuthConsumerSecret(CONSUMER_SECRET);
    psdsOAuthParameters.setOAuthToken(PSDSToken.psdsToken);
    psdsOAuthParameters.setOAuthTokenSecret(PSDSToken.psdsTokenSecret);

    SpreadsheetService service = new SpreadsheetService(
                                                  "psds-beach-nourishment-v1");
    
    SpreadsheetService psdsService = new SpreadsheetService(
                                                  "psds-beach-nourishment-v1");

    service.setOAuthCredentials(oauthParameters, new OAuthHmacSha1Signer());
    psdsService.setOAuthCredentials(psdsOAuthParameters, 
                                                    new OAuthHmacSha1Signer());
    
    URL metafeedUrl = new URL(
            "https://spreadsheets.google.com/feeds/spreadsheets/private/full");
    
    SpreadsheetFeed feed = service.getFeed(metafeedUrl, SpreadsheetFeed.class);
    SpreadsheetFeed psdsFeed = psdsService.getFeed(metafeedUrl, 
                                                        SpreadsheetFeed.class);
    
    String downloadLink = "";
    boolean sheetFound = false;
    for (SpreadsheetEntry entry : feed.getEntries()) {
        if (entry.getTitle().getPlainText().equals("beach-nourishment-" 
                                                 + date)) {
            sheetFound = true;
            String spreadsheetLink = entry.getHtmlLink().getHref();
            String key = spreadsheetLink.substring(spreadsheetLink.indexOf('=') 
                                                   + 1);
            downloadLink = "https://spreadsheets.google.com/feeds/download/"
                         + "spreadsheets/Export?key=" + key
                         + "&exportFormat=xls";
        }
    }
    
    if (sheetFound) {
    %>
<script type="text/javascript">
  <!--
  window.location = "<%= downloadLink %>";
  //-->
</script>
    <%
    } else {    
    
        DocsService client = new DocsService("psds-beach-nourishment-v1");
        client.setOAuthCredentials(oauthParameters, new OAuthHmacSha1Signer());
        
        URL feedUrl = new URL("https://docs.google.com/feeds/default/private/"
                            + "full");
        DocumentListEntry createdEntry = 
                             new com.google.gdata.data.docs.SpreadsheetEntry();
        createdEntry.setTitle(new PlainTextConstruct("beach-nourishment-" 
                                                   + date));
        
        client.insert(feedUrl, createdEntry);

        SpreadsheetEntry spreadsheetEntry = null;
        feed = service.getFeed(metafeedUrl, SpreadsheetFeed.class);

        for (SpreadsheetEntry entry : feed.getEntries()) {
            if (entry.getTitle().getPlainText().equals("beach-nourishment-"
                                                     + date)) {
                spreadsheetEntry = entry;
            }
        }

        URL worksheetFeedUrl = spreadsheetEntry.getWorksheetFeedUrl();
                
        for (SpreadsheetEntry entry : psdsFeed.getEntries()) {
            for (WorksheetEntry worksheet : entry.getWorksheets()) {
                WorksheetEntry newSheet = service.insert(worksheetFeedUrl, 
                                                         worksheet);

                URL newCellFeedUrl = newSheet.getCellFeedUrl();
                URL cellFeedUrl    = worksheet.getCellFeedUrl();
                //CellFeed cellFeed  = psdsService.getFeed(cellFeedUrl,
                //                                               CellFeed.class);
                //for (CellEntry cell : cellFeed.getEntries()) {
                //    Cell      thisCell  = cell.getCell();
                //    CellEntry cellEntry = new CellEntry(thisCell.getRow(),
                //                                        thisCell.getCol(),
                //                                        thisCell.getValue());
                //    service.insert(newCellFeedUrl, cellEntry);
                //}

                CellQuery query = new CellQuery(cellFeedUrl);
                query.setMinimumRow(0);
                query.setMaximumRow(1);
                query.setMinimumCol(0);
                query.setMaximumCol(worksheet.getColCount());
                CellFeed cellFeed = psdsService.query(query, CellFeed.class);

                int i = 1;
                for (CellEntry cellEntry : cellFeed.getEntries()) {
                    CellEntry newCellEntry = new CellEntry(1, i, 
                                               cellEntry.getCell().getValue());
                    service.insert(newCellFeedUrl, newCellEntry);
                    i++;
                }

                URL newListFeedUrl = newSheet.getListFeedUrl();
                URL listFeedUrl    = worksheet.getListFeedUrl();
                ListFeed listFeed  = psdsService.getFeed(listFeedUrl,    
                                                         ListFeed.class);
                for (ListEntry row : listFeed.getEntries()) {
                    ListEntry newRow = new ListEntry();

                    newRow.getCustomElements().replaceWithLocal(
                                                      row.getCustomElements());
                    
                    service.insert(newListFeedUrl, newRow);
                }
            }
        }

        worksheetFeedUrl = spreadsheetEntry.getWorksheetFeedUrl();
        WorksheetFeed worksheetFeed = service.getFeed(worksheetFeedUrl,
                                                          WorksheetFeed.class);

        for (WorksheetEntry worksheet : worksheetFeed.getEntries()) {
            if (worksheet.getTitle().getPlainText().equals("Sheet 1")) {
                worksheet.delete();
            }
        }

    %>
<%@ include file="header.html" %>
<%@ include file="nav_bar.jsp" %>
  <div class="body-container drop-shadow" style="height: 575px;">
    <div id="content">
      <div class="section-title">
        <div class="content-left">
          <h2>The US Beach Nourishment Experience</h2>
          <p>
            Explore the US Beach Nourishment Experience using our easy-to-use,
            interactive maps below. Just click a state below to get started:
          </p>
        </div>
        <div class="content-right">
          <table id="logos-table" cols="2" align="center"
                 style="border-spacing: 20px 0px;" cellspacing="10px">
            <tr>
              <td>
                <div class="psds-logo"></div>
              </td>
              <td>
                <div class="wcu-logo"></div>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="clear"></div>
      <hr class="h1" />
    </div>
  </div>
</div>
</body>
</html>
<%
    }
}
%>
