<?php
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
          <img src="images/banner.png" style="position: relative; top: -10px;" />
        </div>
        <div class="content-right">
          <table id="logos-table" cols="2" align="center"
                 style="border-spacing: 0px 0px;" cellspacing="10px">
            <tr>
              <td>
                <a href="http://www.facebook.com/pages/Program-for-the-Study-of-Developed-Shorelines/178055929458"
                   target="new_"><div class="facebook-logo"></div></a>
              </td>
              <td>
                <a href="http://www.wcu.edu"
                   target="new"><div class="wcu-logo"></div></a>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="clear"></div>
      <hr class="h1" />
      <h3>Click on the state of interest or select it from the list:</h3>
      <table cols="1" align="center" style="position: relative;">
        <tr>
          <td>
            <select name="states" id="states"
                    onChange="window.open(this.options[this.selectedIndex].
                                                   value, '_top');">
              <option value=".">
                Select a state
              </option>
              <option value="results.php?state=AL">
                Alabama
              </option>
              <option value="results.php?state=CA">
                California
              </option>
              <option value="results.php?state=CT">
                Connecticut
              </option>
              <option value="results.php?state=DE">
                Delaware
              </option>
              <option value="results.php?state=FL">
                Florida
              </option>
              <option value="results.php?state=GA">
                Georgia
              </option>
              <option value="results.php?state=LA">
                Louisiana
              </option>
              <option value="results.php?state=MA">
                Massachusetts
              </option>
              <option value="results.php?state=MD">
                Maryland
              </option>
              <option value="results.php?state=ME">
                Maine
              </option>
              <option value="results.php?state=MS">
                Mississippi
              </option>
              <option value="results.php?state=NC">
                North Carolina
              </option>
              <option value="results.php?state=NJ">
                New Jersey
              </option>
              <option value="results.php?state=NY">
                New York
              </option>
              <option value="results.php?state=RI">
                Rhode Island
              </option>
              <option value="results.php?state=SC">
                South Carolina
              </option>
              <option value="results.php?state=TX">
                Texas
              </option>
              <option value="results.php?state=VA">
                Virginia
              </option>
              <option value="results.php?state=WA">
                Washington
              </option>
            </select>
          </td>
        </tr>
        <tr>
          <td align="center">
            <img src="images/new_map.png" alt="US_map" usemap="#us_map" 
                 ismap="ismap" style="border: 5px solid #80c2d0; border-radius: 5px;"/>
            <map name="us_map">

              <area shape="poly" 
                    coords="521, 243, 554, 243, 560, 296, 529, 295, 530, 306, 518, 307, 521, 243"
                    title="Alabama" href="results.php?state=AL" />

              <area shape="poly" 
                    coords="58, 141, 111, 141, 111, 184, 179, 242, 186, 252, 180, 274, 148, 276, 114, 254, 64, 186, 58, 141"
                    title="California" href="results.php?state=CA" />

              <area shape="poly" 
                    coords="726, 156, 708, 162, 705, 149, 726, 152, 726, 156"
                    title="Connecticut" href="results.php?state=CT" />

              <area shape="poly" 
                    coords="680, 174, 687, 173, 692, 192, 682, 193, 680, 175"
                    title="Delaware" href="results.php?state=DE" />

              <area shape="poly" 
                    coords="609, 293, 629, 346, 624, 365, 616, 377, 602, 380, 579, 313, 532, 306, 531, 296, 609, 293"
                    title="Florida" href="results.php?state=FL" />
              
              <area shape="poly" 
                    coords="554, 243, 580, 243, 608, 275, 612, 282, 610, 293, 564, 300, 554, 243"
                    title="Georgia" href="results.php?state=GA" />
              
              <area shape="poly" 
                    coords="445, 271, 482, 271, 485, 279, 477, 297, 500, 297, 505, 316, 487, 324, 448, 314, 449, 304, 452, 296, 445, 271"
                    title="Louisiana" href="results.php?state=LA" />
              
              <area shape="poly" 
                    coords="712, 129, 748, 129, 760, 138, 755, 151, 742, 149, 741, 138, 710, 140, 712, 129"
                    title="Massachusetts" href="results.php?state=MA" />
              
              <area shape="poly" 
                    coords="634, 174, 680, 174, 681, 194, 686, 200, 661, 193, 665, 185, 634, 181, 634, 171"
                    title="Maryland" href="results.php?state=MD" />
              
              <area shape="poly" 
                    coords="794, 97, 747, 119, 742, 118, 742, 88, 764, 54, 783, 60, 783, 82, 794, 97"
                    title="Maine" href="results.php?state=ME" />
              
              <area shape="poly" 
                    coords="521, 243, 517, 307, 504, 309, 500, 297, 477, 297, 486, 279, 482, 262, 494, 244, 521, 243"
                    title="Mississippi" href="results.php?state=MS" />

              <area shape="poly" 
                    coords="606, 221, 679, 221, 685, 218, 684, 238, 646, 258, 642, 249, 571, 242, 606, 221"
                    title="North Carolina" href="results.php?state=NC" />
              
              <area shape="poly" 
                    coords="694, 150, 707, 161, 694, 182, 689, 175, 692, 168, 688, 159, 694, 150"
                    title="New Jersey" href="results.php?state=NJ" />
              
              <area shape="poly" 
                    coords="741, 89, 742, 118, 747, 119, 748, 129, 723, 130, 737, 89, 741, 89"
                    title="New Hampshire" href="results.php?state=NJ" />

              <area shape="poly" 
                    coords="711, 93, 709, 144, 706, 147, 709, 153, 727, 150, 727, 155, 707, 161, 704, 152, 682, 140, 629, 138, 692, 95, 711, 93"
                    title="New York" href="results.php?state=NY" />
              
              <area shape="poly" 
                    coords="747, 148, 747, 138, 759, 139, 778, 142, 778, 153, 758, 154, 747, 148"
                    title="Rhode Island" href="results.php?state=RI" />

              <area shape="poly" 
                    coords="590, 249, 611, 241, 617, 245, 643, 251, 643, 258, 615, 283, 608, 274, 590, 249"
                    title="South Carolina" href="results.php?state=SC" />
              
              <area shape="poly" 
                    coords="330, 221, 269, 221, 369, 248, 445, 262, 445, 282, 447, 312, 406, 341, 405, 362, 379, 356, 356, 318, 333, 314, 329, 323, 310, 313, 305, 301, 284, 284, 330, 284, 330, 221"
                    title="Texas" href="results.php?state=TX" />
              
              <area shape="poly" 
                    coords="581, 220, 593, 212, 620, 208, 649, 180, 663, 187, 663, 194, 680, 219, 581, 220"
                    title="Virginia" href="results.php?state=VA" />
              
              <area shape="poly" 
                    coords="149, 27, 150, 77, 79, 83, 73, 75, 59, 72, 51, 36, 70, 26, 149, 27"
                    title="Washington" href="results.php?state=WA" />
            </map>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
</body>
</html>
