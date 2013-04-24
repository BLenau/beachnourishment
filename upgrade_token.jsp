<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page import="java.net.URL" %>
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
 * @version 8/22
 * @author  Russel Gaskey
 * @author  Cristina Korb
 * @author  Brian M. Lenau
 */

/** The array that holds all of the cookies. */
Cookie[] cookieArray = request.getCookies();

/** The cookie that contains the access token. */
Cookie accessTokenCookie = null;

/** The cookie that contains the access token secret. */
Cookie accessSecretCookie = null;

if (cookieArray != null) {
    for (Cookie c : cookieArray) {
        if (c.getName().equals("beachAccessToken")) {
            accessTokenCookie = c;
        } else if (c.getName().equals("beachAccessSecret")) {
            accessSecretCookie = c;
        }
    }
}

String CONSUMER_KEY    = request.getServerName();
String CONSUMER_SECRET = "rWwoyDP2xRUc-fJsHN71DUkh";

GoogleOAuthParameters oauthParameters = new GoogleOAuthParameters();
oauthParameters.setOAuthConsumerKey(CONSUMER_KEY);
oauthParameters.setOAuthConsumerSecret(CONSUMER_SECRET);

GoogleOAuthHelper oauthHelper = new GoogleOAuthHelper(
                                                  new OAuthHmacSha1Signer());
oauthHelper.getOAuthParametersFromCallback(request.getQueryString(),
                                           oauthParameters);

String accessToken       = oauthHelper.getAccessToken(oauthParameters);
String accessTokenSecret = oauthParameters.getOAuthTokenSecret();

oauthParameters.setOAuthToken(accessToken);
oauthParameters.setOAuthTokenSecret(accessTokenSecret);

if (accessTokenCookie == null) {
    accessTokenCookie = new Cookie("beachAccessToken", accessToken);
    response.addCookie(accessTokenCookie);
} else {
    accessTokenCookie.setValue(accessToken);
} 
if (accessSecretCookie != null) {
    accessSecretCookie.setValue(accessTokenSecret);
} else {
    accessSecretCookie = new Cookie("beachAccessSecret", accessTokenSecret);
    response.addCookie(accessSecretCookie);
}

%>
<script type="text/javascript">
  window.location = "download-spreadsheet";
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
    </div>
  </div>
</div>
</body>
</html>
