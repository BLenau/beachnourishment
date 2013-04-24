<?php
$new_path = "scripts/zend/library";
include_once("header.html");
include_once("nav_bar.php");

session_start();

if (!(isset($_SESSION['first_load'])) || $_SESSION['first_load'] == true) {
    $_SESSION['first_load'] = false;
?>
<script type="text/javascript" src="scripts/js/browser_detect.js"></script>
<script type="text/javascript">
<!--
    
    /**
     * This block of code checks to see what browser version the user if
     * currently using.  If the version they are using is not within atleast at
     * the version that this site was developed for, then the user is prompted
     * with a suggestion to update.
     */
    BrowserDetect.init();

    if (BrowserDetect.browser == "Explorer" && BrowserDetect.version < 9) {
        alert("You are not currently using the most recent version of Internet"
              + " Explorer. Please update to version 9 or higher.");
    }
    
    if (BrowserDetect.browser == "Firefox" && BrowserDetect.version < 4) {
        alert("You are not currently using the most recent version of Mozilla"
              + " Firefox. Please update to version 4 or higher.");
    }
    
    if (BrowserDetect.browser == "Chrome" && BrowserDetect.version < 9) {
        alert("You are not currently using the most recent version of Google" 
              + " Chrome. Please update to version 9 or higher.");
    }
//-->
</script>
<?php
}
?>
<script type="text/javascript">
<!--
    jQuery(document).ready(function() {
        jQuery("#nav-home").attr("class", "active");
    });
// -->
</script>

  <div class="body-container drop-shadow" style="height: 600px;">
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
    </div>
  </div>
</div>
</body>
</html>
