<?php
include_once("header.html");
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="scripts/js/useful_function.js"></script>
<?php
include_once("nav_bar.php");
?>
<script type="text/javascript" src="scripts/js/states.js"></script>

<?php
$state = "";
$beach = "";
if (!isset($_GET['state'])) {
?>
<script type="text/javascript">
<!--
    window.location = ".";
// -->
</script>
<?php
} else {
    $state = $_GET['state'];

    if (!isset($_GET['beach'])) {
        $beach = "All Beaches";
    } else {
        $beach = $_GET['beach'];
    }
?>
<script type="text/javascript">
<!--
    google.load('visualization', '1.0', {'packages' : ['table']});
    google.setOnLoadCallback(loadResponse);

    /**
     * The function that is called when the Google Visualization libraries are
     * loaded. This function builds the queries to construct the drop-down
     * menu and the table.
     */
    function loadResponse() {
        var state = "<?php echo $state; ?>";
        var beach = ("<?php echo $beach; ?>" == "All Beaches") ? -1 : "<?php echo $beach; ?>";
        var query = new google.visualization.Query(createDataUrl("Master"));

        var selectQuery = new google.visualization.Query(createDataUrl("Master"));
        selectQuery.setQuery("Select A, C, F, G, H, I, J, L Where B = '" 
                             + state + "'");

        if (beach == -1) {
            query.setQuery("Select A, C, F, G, H, I, J, L Where B = '" + state 
                           + "' Order by A")
        } else {
            query.setQuery("Select A, C, F, G, H, I, J, L Where A = '" + beach 
                           + "' and B = '" + state + "' Order by A");
        }
        
        query.send(createTable);
        selectQuery.send(createSelect);
    }

    /**
     * Creates the table for the page. This table also calls the getTotals
     * function, that way the query only has to be sent once.
     *
     * @param response the results from the query
     */
    function createTable(response) {
        var lengthColumn    = 4;
        var volumeColumn    = lengthColumn + 1;
        var costColumn      = volumeColumn + 1;
        var cost2010Column  = costColumn + 1;

        if (response.isError()) {
            alert("Error in query: " + response.getMessage() + " " +
                  response.getDetailedMessage());
            return;
        }

        var data = response.getDataTable();
        for (var i = 0; i < data.getNumberOfRows(); i++) {
            for (var j = 0; j < data.getNumberOfColumns(); j++) {
                data.setProperty(i, j, "style", "text-align: right;");
            }
        }
        if (data.getNumberOfRows() > 20) {
            var div = document.getElementById('table_container');
            div.style.overflow = 'auto';
            div.style.width    = '880px';
            div.style.height   = '450px';
        }
        var visualization = new google.visualization.Table(
                                        document.getElementById('data_table'));

        visualization.draw(data, {
                                    showRowNumber: true,
                                    allowHtml: true,
                                    cssClassNames: {
                                        headerRow: 'table-header'
                                    }
                                 });

        getTotals(data);
    }

    /**
     * Creates the selects (drop-down menu) on the page. This function is
     * called seperately from the createTable function because the data
     * required to construct the drop-down menu is different from teh data
     * needed for the table.
     *
     * @param response the results from the query
     */
    function createSelect(response) {
        if (response.isError()) {
            alert("Error in query: " + response.getMessage() + " " +
                  response.getDetailedMessage());
            return;
        }

        var data       = response.getDataTable();
        var beaches    = new Array();
        var beachNames = data.getDistinctValues(0);
        
        for (var i = 0; i < beachNames.length; i++) {
            var beach = trim(beachNames[i]);
            if (beach.length > 0 && 
               (beaches.indexOf(beach) == -1)) {
                beaches.push(beach);
                var select = document.getElementById('perpage');
                var option = document.createElement('option');

                option.id    = beach;
                option.text  = beach;
                option.value = "table?state=<?php echo $state; ?>&beach=" + 
                               beach;
                select.appendChild(option);
            }
        }
    }

    /**
     * Gets the totals of the beaches in the table. This function populates
     * an array that contains the totals for use later on.
     *
     * @param data the data received from query and formatted into a table
     */
    function getTotals(data) {
        var totals      = new Object();
        totals.cost     = 0;
        totals.cost2010 = 0;
        totals.episodes = 0;
        totals.len      = 0;
        totals.volume   = 0;

        var lengthColumn    = 4;
        var volumeColumn    = lengthColumn + 1;
        var costColumn      = volumeColumn + 1;
        var cost2010Column  = costColumn + 1;

        for (var i = 0; i < data.getNumberOfRows(); i++) {
            beach = trim(data.getValue(i, 0));
            if (beach == '<?php echo $beach; ?>') {
                totals.episodes++;
                totals.cost     += data.getValue(i, costColumn);
                totals.cost2010 += data.getValue(i, cost2010Column);
                totals.len      += data.getValue(i, lengthColumn);
                totals.volume   += data.getValue(i, volumeColumn);
            }
        }

        document.getElementById('total_episodes').value = 
                                           numberWithCommas(totals.episodes);
        document.getElementById('total_cost').value = '$' 
                                           + numberWithCommas(
                                           Math.round(totals.cost));
        document.getElementById('total_2010cost').value = '$' 
                                           + numberWithCommas(
                                           Math.round(totals.cost2010));
        document.getElementById('total_volume').value = 
                                           numberWithCommas(totals.volume);
        document.getElementById('total_length').value = 
                                           numberWithCommas(totals.len);
        document.getElementById('totals').style.visibility = 'visible';
    }
//-->
</script>

  <div id="body_div" class="body-container drop-shadow"> 
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
      <table cols="2">
        <tr>
          <td width="500px">
            <table cols="1">
              <tr>
                <td>
                  <h3><?php echo $beach; ?>, <?php echo $state; ?></h3>
                </td>
              </tr>
              <tr>
                <td>
                  <select id="perpage" onChange="window.open(
                                       this.options[this.selectedIndex].value, 
                                       '_top');">
                    <option value="visualization.php?state=<?php echo $state; ?>?beach=<?php echo $beach; ?>">
                      Select another beach
                    </option>
                    <option value="visualization.php?state=<?php echo $state; ?>">
                      All
                    </option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>
                  <select name="states" id="states"
                          onChange="window.open(this.options[this.selectedIndex].
                                                         value, '_top');">
                    <option value=".">
                      Select another state
                    </option>
                    <option value=".">
                      Home
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
            </table>
          </td>
          <td width="400px" align="right">
            <table cols="3" id="totals" style="visibility: hidden;">
              <tr>
                <td align="right">
                  <b>Beach Totals:</b>
                </td>
                <td width="150px">
                  <font size="2px">Episodes:</font>
                </td>
                <td align="left">
                  <input type="text" id="total_episodes" class="textBox" 
                         style="font-size: 12px; text-align: right;" 
                         size="15" readonly />
                </td>
              </tr>
              <tr>
                <td>
                </td>
                <td>
                  <font size="2px">Cost:</font>
                </td>
                <td align="left">
                  <input type="text" id="total_cost" class="textBox" 
                         style="font-size: 12px; text-align: right;" 
                         size="15" readonly />
                </td>
              </tr>
              <tr>
                <td>
                </td>
                <td>
                  <font size="2px">Cost (in 2012 dollars):</font>
                </td>
                <td align="left">
                  <input type="text" id="total_2010cost" class="textBox" 
                         style="font-size: 12px; text-align: right;" 
                         size="15" readonly />
                </td>
              </tr>
              <tr>
                <td>
                </td>
                <td>
                  <font size="2px">Volume (cubic yards):</font>
                </td>
                <td align="left">
                  <input type="text" id="total_volume" class="textBox" 
                         style="font-size: 12px; text-align: right;" 
                         size="15" readonly />
                </td>
              </tr>
              <tr>
                <td>
                </td>
                <td>
                  <font size="2px">Length (feet):</font>
                </td>
                <td align="left">
                  <input type="text" id="total_length" class="textBox" 
                         style="font-size: 12px; text-align: right;" 
                         size="15" readonly />
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <div id="table_container" class="table-container">
        <table style="border-spacing: 10px 5px; font-size: 12px;" rules="all"
               id="data_table">
        </table>
      </div>
      <table cols="3" style="border-spacing: 10px 5px;" width="75%" 
             align="center">
        <tr>
          <td>
            <a href="visualization.php?state=<?php echo $state; ?>&beach=<?php echo $beach; ?>">Return</a>
            to the previous page
          </td>
          <td>
            <a href="results.php?state=<?php echo $state; ?>">Return</a>
            to the State Map page
          </td>
          <td>
            <a href=".">Return</a> to the Home page
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
</body>
</html>
<?php
}
?>
