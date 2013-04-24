  </head>
<body>
<div id="outer">
  <div id="logo" class="drop-shadow">
    <div id="featured">
      <img src="images/slider_images/slider_1.png" data-thumb="slider_1.png" />
      <!--
      <img src="images/slider_images/slider_2.png" data-thumb="slider_2.png" />
      <img src="images/slider_images/slider_3.png" data-thumb="slider_3.png" />
      <img src="images/slider_images/slider_4.png" data-thumb="slider_4.png" />
      -->
    </div>
  </div>
  <script type="text/javascript">
  <!--
      jQuery(window).load(function() {
          jQuery('#featured').orbit({
              animation: 'fade',
              animationSpeed: 1000,
              timer: true,
              advanceSpeed: 5000,
              pauseOnHover: true,
              startClockOnMouseOut: true,
              startClockOnMouseOutAfter: 0,
              directionalNav: false
          });
      });
  //-->
  </script>

  <!-- The navigation bar that is used in all the pages of the site. -->
  <div id="nav">
    <ul>
      <a href="."><li id="nav-home"><b>home</b></li></a>
    <?php
    if (isset($_COOKIE['state'])) {
    ?>
      <a href="results.php?state=<?php echo $_COOKIE['state'] ?>"><li id="nav-results"><b>results</b></li></a>
    <?php
    }
    ?>
      <a href="http://www.wcu.edu/1037.asp" target="_new"><li id="nav-psds"><b>psds website</b></li></a>
      <a href="http://psds.shutterfly.com" target="_new"><li id="nav-noaa"><b>psds images</b></li></a>
      <a href="about.php"><li id="nav-about"><b>about</b></li></a>
    </ul>
  </div>
