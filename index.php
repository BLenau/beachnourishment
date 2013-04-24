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

  <div class="body-container drop-shadow" style="height: 670px;">
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
            <img src="images/index_map.png" alt="US_map" usemap="#us_map" 
                 ismap="ismap" style="border: 5px solid #80c2d0; border-radius: 5px; margin-left: -7px;"/>
            <map name="us_map">

              <area shape="poly" 
                    coords="616,262, 610,314, 612,340, 626,337, 628,332, 626,330, 624,327, 664,326, 667,395, 657,262, 616,262"
                    title="Alabama" href="results.php?state=AL" />

              <area shape="poly" 
                    coords="23,148, 20,174, 84,270, 137,302, 184,297, 188,272, 92,195, 93,148, 23,148"
                    title="California" href="results.php?state=CA" />

              <area shape="poly" 
                    coords="856,147, 855,161, 880,162, 884,147, 856,147"
                    title="Connecticut" href="results.php?state=CT" />

              <area shape="poly" 
                    coords="818,184, 819,203, 834,203, 823,189, 823,182, 820,182, 818,184"
                    title="Delaware" href="results.php?state=DE" />

              <area shape="poly" 
                    coords="624,327, 624,329, 627,333, 630,341, 650,341, 660,350, 670,350, 683,341, 703,361, 699,372, 717,435, 742,429, 751,413, 752,391, 728,330, 716,329, 716,336, 713,337, 712,333, 669,331, 667,326, 624,327"
                    title="Florida" href="results.php?state=FL" />
              
              <area shape="poly" 
                    coords="657,261, 668,306, 667,326, 669,331, 712,333, 713,337, 716,336, 716,330, 729,327, 730,303, 694,266, 698,261, 657,261"
                    title="Georgia" href="results.php?state=GA" />
              
              <area shape="poly" 
                    coords="519,293, 518,310, 527,325, 522,348, 555,352, 571,362, 601,358, 593,351, 599,343, 588,332, 589,326, 559,326, 570,306, 595,293, 519,293"
                    title="Louisiana" href="results.php?state=LA" />
              
              <area shape="poly" 
                    coords="860,134, 856,146, 890,146, 898,160, 915,160, 917,149, 906,146, 906,134, 860,134"
                    title="Massachusetts" href="results.php?state=MA" />
              
              <area shape="poly" 
                    coords="758,184, 758,192, 781,185, 799,198, 792,206, 808,209, 815,227, 833,208, 819,204, 817,184, 758,184"
                    title="Maryland" href="results.php?state=MD" />
              
              <area shape="poly" 
                    coords="897,93, 898,125, 905,128, 912,120, 963,101, 950,86, 950,64, 930,61, 926,57, 897,93"
                    title="Maine" href="results.php?state=ME" />
              
              <area shape="poly" 
                    coords="582,261, 567,285, 571,305, 558,326, 588,327, 588,332, 592,340, 610,339, 615,262, 582,261"
                    title="Mississippi" href="results.php?state=MS" />

              <area shape="poly" 
                    coords="722,236, 678,260, 698,260, 709,258, 732,258, 737,263, 755,264, 774,283, 826,259, 818,237, 722,236"
                    title="North Carolina" href="results.php?state=NC" />
              
              <area shape="poly" 
                    coords="835,157, 829,164, 829,170, 834,175, 823,184, 833,199, 851,174, 848,164, 835,157"
                    title="New Jersey" href="results.php?state=NJ" />
              
              <area shape="poly" 
                    coords="891,93, 880,108, 872,134, 892,135, 897,131, 895,94, 891,93"
                    title="New Hampshire" href="results.php?state=NJ" />

              <area shape="poly" 
                    coords="753,146, 825,147, 853,165, 859,135, 858,97, 834,97, 809,112, 811,122, 765,126, 768,133, 753,142, 753,146"
                    title="New York" href="results.php?state=NY" />
              
              <area shape="poly" 
                    coords="884,147, 885,162, 894,157, 890,148, 884,147"
                    title="Rhode Island" href="results.php?state=RI" />

              <area shape="poly" 
                    coords="695,266, 702,296, 726,301, 731,311, 771,281, 755,265, 736,264, 732,259, 708,258, 695,266"
                    title="South Carolina" href="results.php?state=SC" />
              
              <area shape="poly" 
                    coords="371,237, 370,310, 312,311, 340,334, 366,360, 378,347, 397,347, 435,401, 467,411, 465,385, 521,348, 519,285, 421,267, 420,236, 371,237"
                    title="Texas" href="results.php?state=TX" />
              
              <area shape="poly" 
                    coords="689,235, 814,235, 810,215, 793,206, 796,198, 775,189, 743,219, 719,225, 716,220, 689,235"
                    title="Virginia" href="results.php?state=VA" />
              
              <area shape="poly" 
                    coords="16,44, 27,78, 45,80, 46,87, 142,81, 141,33, 47,32, 16,44"
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
