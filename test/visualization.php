<?php
include_once("header.html");

$state = "";
$beach = "";
if (isset($_GET['state'])) {
    $state = $_GET['state'];
} else {
    $state = "";
}

if (isset($_GET['beach'])) {
    $beach = $_GET['beach'];
} else {
    $beach = "All Beaches";
}
?>
<script type="text/javascript" src="scripts/js/states.js"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript" src="scripts/js/useful_function.js"></script>
<script type="text/javascript">
<!--
    /** Determines how you're going to order the graphs by. */
    var orderBy = 'date';

    google.load('visualization', '1.0', {'packages' : ['corechart']});
    google.setOnLoadCallback(createPageElements);

    /**
     * Creates the various page elements from the data recieved from the query.
     * This function is called as soon as Google Visualization libraries are
     * loaded.
     */
    function createPageElements() {
        var state = "<?php echo $state; ?>";
        var beach = ("<?php echo $beach; ?>" == "All Beaches") ? -1 : "<?php echo $beach; ?>";
        var costQuery = new google.visualization.Query(createDataUrl("Master"));
        var volumeQuery = new google.visualization.Query(createDataUrl("Master"));
        var totalsQuery = new google.visualization.Query(createDataUrl("Master"));

        totalsQuery.setQuery("Select A, H, I, J, L Where B = '" + state + "' Order by A");
        totalsQuery.send(getTotalsAndCreateSelect);

        if (beach == -1) {
            costQuery.setQuery("Select C, J Where B = '" + state + "'"
                               + " Order By C");
            volumeQuery.setQuery("Select C, I Where B = '" + state + "'"
                                 + " Order By C");
        } else {
            costQuery.setQuery("Select C, J Where A = '" + beach + 
                               "' and B = '" + state + "' Order by C");
            volumeQuery.setQuery("Select C, I Where A = '" + beach + 
                                 "' and B = '" + state + "' Order by C");
        }
        
        costQuery.send(createCostVisualization);
        volumeQuery.send(createVolumeVisualization);
    }

    /**
     * Create the cost visualization graph. This function is called when a
     * call to query.send is called with this function passed in as the
     * parameter.
     *
     * @param response the response that is returned from the query
     */
    function createCostVisualization(response) {
        if (response.isError()) {
            alert("Error in query: " + response.getMessage() + " " +
                  response.getDetailedMessage());
            return;
        }

        var data          = response.getDataTable();
        var visualization = new google.visualization.ColumnChart(
                                        document.getElementById('cost_canvas'));
        var hAxisOptions;
        if (orderBy == 'date') {
            hAxisOptions = {slantedText: 'true'};
        } else {
            hAxisOptions = {slantedText: 'true', textPosition: 'none'};
        }

        visualization.draw(data, {
                                  title: 'Cost',
                                  titleTextStyle: {fontSize: 16,
                                      fontName: "Times New Roman"},
                                  legend: 'none',
                                  backgroundColor: 'transparent',
                                  hAxis: hAxisOptions,
                                  vAxis: {format: '$###,###,###.##'}
                                 });
    }

    /**
     * Creates the volume visualization graph. This function is called when a
     * call to query.send is called with this function passed in as the
     * parameter.
     *
     * @param response the response that is returned from the query
     */
    function createVolumeVisualization(response) {
        if (response.isError()) {
            alert("Error in query: " + response.getMessage() + " " +
                  response.getDetailedMessage());
            return;
        }

        var data          = response.getDataTable();
        var visualization = new google.visualization.ColumnChart(
                                        document.getElementById('volume_canvas'));
        var hAxisOptions;
        if (orderBy == 'date') {
            hAxisOptions = {slantedText: 'true'};
        } else {
            hAxisOptions = {slantedText: 'true', textPosition: 'none'};
        }

        visualization.draw(data, {
                                  title: 'Volume',
                                  titleTextStyle: {fontSize: 16,
                                      fontName: "Times New Roman"},
                                  legend: 'none',
                                  backgroundColor: 'transparent',
                                  colors: ['#FF3F42'],
                                  hAxis: hAxisOptions
                                 });
    }

    /**
     * Gets the totals for the beaches and creates the select (drop-down menu)
     * for the page.  This function is seperate from the two other create
     * functions because the data needed for these is different from the other
     * two functions.
     *
     * @param response the response that is returned from the query
     */
    function getTotalsAndCreateSelect(response) {
        var data    = response.getDataTable();
        var beaches = new Array();
        var totals  = new Object();
        totals.cost     = 0;
        totals.cost2010 = 0;
        totals.episodes = 0;
        totals.len      = 0;
        totals.volume   = 0;

        var lengthColumn    = 1;
        var volumeColumn    = lengthColumn + 1;
        var costColumn      = volumeColumn + 1;
        var cost2010Column  = costColumn + 1;
        
        for (var i = 0; i < data.getNumberOfRows(); i++) {
            beach = trim(data.getValue(i, 0));
            if (beach.length > 0 && (beaches.indexOf(beach) == -1)) {
                beaches.push(beach);

                var select = document.getElementById('perpage');
                var option = document.createElement('option');

                option.id    = beach;
                option.text  = beach;
                option.value = "visualization.php?state=<?php echo $state; ?>&beach=" + 
                               beach;
                select.appendChild(option);
            }
            if (beach == '<?php echo $beach; ?>') {
                totals.episodes ++;
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
                                           numberWithCommas(
                                           Math.round(totals.volume));
        document.getElementById('total_length').value = 
                                           numberWithCommas(
                                           Math.round(totals.len));
        document.getElementById('totals').style.visibility = 'visible';
    }

    
    /**
     * Redraws the visualizations (graphs) when a new method of sorting is
     * selected (by means of the bullet buttons).
     *
     * @param sortBy the means by which to sort the graph
     */
    function redrawVisualization(sortBy) {
        orderBy = sortBy;
        var volumeQuery = new google.visualization.Query(createDataUrl("Master"));
        var costQuery = new google.visualization.Query(createDataUrl("Master"));

        if ('<?php echo $beach; ?>' == 'All Beaches') {
            if (orderBy == 'date') {
                costQuery.setQuery("Select C, J Order by C")
                volumeQuery.setQuery("Select C, I Order by C");
            } else {
                costQuery.setQuery("Select C, J Order by J")
                volumeQuery.setQuery("Select C, I Order by I");
            }
        } else {
            if (orderBy == 'date') {
                costQuery.setQuery("Select C, J Where A = '<?php echo $beach; ?>'" + 
                                   " Order by C");
                volumeQuery.setQuery("Select C, I Where A = '<?php echo $beach; ?>'" + 
                                     " Order by C");
            } else {
                costQuery.setQuery("Select C, J Where A = '<?php echo $beach; ?>'" + 
                                   " Order by J");
                volumeQuery.setQuery("Select C, I Where A = '<?php echo $beach; ?>'" + 
                                     " Order by I");
            }
        }

        costQuery.send(createCostVisualization);
        volumeQuery.send(createVolumeVisualization);
    }
//-->
</script>
<?php
include_once("nav_bar.php");
if ($state == "") {
?>
<script type="text/javascript">
    window.location = ".";
</script>
<?php
} else {
?>
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
          <td width="400px">
            <table cols="1">
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
              <tr>
                <td>
                  <table cols="2">
                    <tr>
                      <td>
                        Sort by:
                      </td>
                      <form name="selects">
                        <td>
                          <label for="date">
                            <input type="radio" id="date" name="sortby" 
                                   value="date" checked
                                   onClick="redrawVisualization(this.value);" />Date
                          </label>
                          <label for="cv">
                            <input type="radio" id="cv" name="sortby" 
                                   value="cv"
                                   onClick="redrawVisualization(this.value);" />
                             Cost/Volume
                          </label>
                        </td>
                      </form>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
          <td width="520px" align="right">
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
      <table cols="1" align="center">
        <tr>
          <td>
            <div id="map_canvas" style="height: 430px;">
              <h2><center><?php echo $beach; ?>, <?php echo $state; ?></center></h2>
              <div id="cost_canvas" style="z-index: 1;"></div>
              <div id="volume_canvas" style="z-index: 1;"></div>
              <div style="margin: 0; padding: 0; z-index: 10;">
                <a href="beach_tables.php?state=<?php echo $state; ?>&beach=<?php echo $beach; ?>">View</a>
                the table representation of this graph
              </div>
            </div>
          </td>
        </tr>
      </table>
      <table cols="2" style="border-spacing: 10px 5px;" width="50%" 
             align="center">
        <tr>
          <td>
            <a href="results.php?state=<?php echo $state; ?>">Return</a>
            to the state map page
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
