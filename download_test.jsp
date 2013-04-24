<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page import="com.google.gdata.client.*" %>
<%@ page import="com.google.gdata.client.docs.*" %>
<%@ page import="com.google.gdata.client.authn.oauth.*" %>
<%@ page import="com.google.gdata.data.MediaContent" %>
<%@ page import="com.google.gdata.data.acl.*" %>
<%@ page import="com.google.gdata.data.docs.*" %>
<%@ page import="com.google.gdata.data.extensions.*" %>
<%@ page import="com.google.gdata.util.*" %>
<%
/**
 * index.jsp
 *
 * @version 8/22
 * @author  Russel Gaskey
 * @author  Cristina Korb
 * @author  Brian M. Lenau
 *
 * This file contains all of the logic that is used to create the index page
 * for the website.
 */

Cookie[] cookieArray = request.getCookies();
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

/**
 * Creates the parameters for the OAuth process.
 */
GoogleOAuthParameters oauthParameters = new GoogleOAuthParameters();

/**
 * Sets the Consumer key and secret for OAuth euthentication.
 */
oauthParameters.setOAuthConsumerKey(CONSUMER_KEY);
oauthParameters.setOAuthConsumerSecret(CONSUMER_SECRET);

/**
 * Sets the scope of use that the user will agree to allow the site to access.
 */
oauthParameters.setScope("https://docs.google.com/feeds/default/private/full "
                       + "https://spreadsheets.google.com/feeds");

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

if (token != null && tokenSecret != null) {
%>
<script type="text/javascript">
    window.location = "download-spreadsheet";
</script>
<%
} else {
    /**
     * Creates the helper that will be used to authenticate the tokens.
     */
    GoogleOAuthHelper oauthHelper = new GoogleOAuthHelper(
                                                    new OAuthHmacSha1Signer());
    
    /**
     * Retrieves a request token to be authorized by the user.
     */
    oauthHelper.getUnauthorizedRequestToken(oauthParameters);
    
    /**
     * The request token and secret that was generated for authentication.
     */
    token       = oauthParameters.getOAuthToken();
    tokenSecret = oauthParameters.getOAuthTokenSecret();
    
    /**
     * Sets the callback URL that the user is redirected to once they have agreed
     * to give the site access to their Google Docs.
     *
     * Note: "http://" must be appended to the URL or else it won't work.
     */
    oauthParameters.setOAuthCallback("http://" + CONSUMER_KEY + "/upgrade-token" 
                                   + "?oauth_token_secret=" + tokenSecret);

    String approvalPageUrl = oauthHelper.createUserAuthorizationUrl(
                                                              oauthParameters);

%>
  <script type="text/javascript">
  <!--
  window.location = "<%= approvalPageUrl %>";
  //-->
  </script>
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
      Click: <a href="<%= approvalPageUrl %>" target="_new">approve</a>
    </div>
  </div>
</div>
</body>
</html>
<%
}
%>
