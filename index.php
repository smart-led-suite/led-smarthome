<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="expires" content="0">
    <!-- Chrome, Firefox OS and Opera -->
		<meta name="theme-color" content="#3f51b5">
		<!-- Windows Phone -->
		<meta name="msapplication-navbutton-color" content="#3f51b5">
		<!-- iOS Safari -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="blue-translucent">
    <title>(beta) LED Steuerung @ Home</title>
    <link rel="icon"
          type="image/ico"
          href="favicon.ico">
     <!-- import google material design apis -->
     <link rel="stylesheet" href="https://storage.googleapis.com/code.getmdl.io/1.0.6/material.indigo-blue.min.css" />
    <script src="https://storage.googleapis.com/code.getmdl.io/1.0.6/material.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- import custom stylesheet -->
    <link rel="stylesheet" media="screen" href="newdesign.css">
    <!-- add background -->
    <style>
        .led-layout {
           bgcolor:#d6d6d6;
        }
    </style>

</head>
<body  bgcolor="#d6d6d6">
        <!-- Simple header with fixed tabs. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header led-layout ">
        <header class="mdl-layout__header mdl-layout__header--scroll">
          <div class="mdl-layout-icon">favicon.ico</div>
            <div class="mdl-layout__header-row">
                <!-- Title -->
                <span class="mdl-layout-title">LED Control Panel</span>
                <div class="mdl-layout-spacer"></div>
                <!-- Navigation. We hide it in small screens. -->
                <nav class="mdl-navigation mdl-layout--large-screen-only">
                  <a class="mdl-navigation__link" href="configurator.php">Konfiguration</a>
                  <a class="mdl-navigation__link" href="wecker.php">Wecker (beta)</a>
                  <a class="mdl-navigation__link" href="index-oldhtml.html">alte Fadeseite</a>
                </nav>
            </div>
        </header>
       <!-- drawer -->
        <div class="mdl-layout__drawer">
            <span class="mdl-layout-title">LED Control Panel</span>
            <nav class="mdl-navigation">
              <a class="mdl-navigation__link" href="configurator.php">Konfiguration</a>
              <a class="mdl-navigation__link" href="wecker.php">Wecker (beta)</a>
              <a class="mdl-navigation__link" href="index-oldhtml.html">alte Fadeseite</a>
           </nav>
        </div>


     <main class="mdl-layout__content"  >
          <div class="page-content">
    <!-- Steady lighting is the former index.html with the sliders -->

              <div class="mdl-grid ">
                <div class="mdl-cell mdl-cell--middle  mdl-cell--stretch mdl-cell--6-col mdl-cell--4-col-phone mdl-cell--8-col-tablet ">
                    <div class="mdl-card mdl-shadow--4dp steady_lighting-card">
                     <?php
                      //read the config file and save results in array
                      //the configfiles layout is like that:
                      //      colorCode;  pin;  font-color; background-color; colorName
                      //e.g.  w           17    black       whitesmoke        weiß
                      $nColors = 0;
                      if (($handle = fopen("colors.csv", "r")) !== FALSE) {
                        while (($colorConfig = fgetcsv($handle, 1000, ";")) !== FALSE) {
                          $num = count($colorConfig);
                          for ($c=0; $c < $num; $c++) {
                            $globalConfig[$nColors][$c]=$colorConfig[$c];
                          }
                        $nColors++;

                        }
                        fclose($handle);
                      }
                      //read the current brightness file
                      //the brightness.csv and the colors.csv must have the same colors defined!
                      $ncurrentColors = 0;
                      if (($handle = fopen("brightness.csv", "r")) !== FALSE) {
                        while (($brightness = fgetcsv($handle, 1000, ";")) !== FALSE) {
                          $num = count($brightness);
                          for ($c=0; $c < $num; $c++) {
                             $colorBrightness[$ncurrentColors][$c]=$brightness[$c];
                          }
                        $ncurrentColors++;

                        }
                        fclose($handle);
                      }
                      ?>
                      <div class="mdl-card__title">
                          <h2 class="mdl-card__title-text">Farben einstellen</h2>
                      </div>
                      <form action="fade.php" method="get">
                        <input type="hidden" name="url" value="<?php echo $_SERVER['PHP_SELF'] ?>" />
                        <?php

                        for ($color=0; $color < $nColors; $color++) {
                          //printing the card with background-color and font color from csv file.
                          echo "<div class=\"mdl-card__actions mdl-card--border\" style=\"color:"  . $globalConfig[$color][2] . "; background-color:" . $globalConfig[$color][3] . "; \" > \n";
                          //printing the colorName string
                          echo $globalConfig[$color][4] . "\n";
                          echo "<input class=\"mdl-slider mdl-js-slider\" type=\"range\" name=\"" . $globalConfig[$color][0] . "\" min=\"0\" max=\"1000\" step=\"4\" value=\"";
                          //check for every color because we dont know how theyre ordered
                          $colorBrightnessKey = 0;
                          //we'll search for the right currentBrightness with the primary key colorCode
                          //i dont know why but we have to use strncmp otherwise it can't detect if the variables are the same or not.
                          //if its not the matching currentBrightness we'll look for the next one (therefore increase colorBrightnessKey)
                          while(strcmp($globalConfig[$color][0] , $colorBrightness[$colorBrightnessKey][0])!=0) {
                            $colorBrightnessKey++;
                          }
                          //then write current brightness as value
                          echo $colorBrightness[$colorBrightnessKey][1]  . "\">\n";
                          //and close the div container
                          echo "</div>\n";
                        }
                        //end of table row and data

                         ?>


                            <div class="mdl-card__actions ">
                                 <div class="mdl-grid ">
                                     <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col-tablet mdl-cell--3-col-phone">
                                       <!-- Accent-colored raised button with ripple -->
                                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                                            LEDs schalten
                                        </button>
                                     </div>
                                     </form>




                                     <div class="mdl-cell mdl-cell--5-col-desktop mdl-cell--3-col-tablet mdl-cell--3-col-phone">
                                        <form action="fade.php" method="get">
                                        	<input type="hidden" name="url" value="<?php echo $_SERVER['PHP_SELF'] ?>" />

                                            <input type="hidden" name="w" value="0">
                                            <input type="hidden" name="r" value="0">
                                            <input type="hidden" name="g" value="0">
                                            <input type="hidden" name="b" value="0">
                                            <input type="hidden" name="mode" value="0">
                                           <!-- Accent-colored raised button with ripple -->
                                            <button  onclick="showFadingInfo()" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                                                ALLES AUS
                                            </button>
                                        </form>

                                     </div>
                                </div>
                            </div>
                          </div>
                </div>
                <div class="mdl-cell  mdl-cell--col mdl-cell--3-col-desktop  mdl-cell--4-col-tablet mdl-cell--top">
                    <!-- mdl-cell--3-col-desktop  mdl-cell--2-col-tablet -->
                 <div class="mdl-card  mdl-shadow--4dp steady_lighting-card">
                    <div class="mdl-card__title">
                            <h2 class="mdl-card__title-text">Mode wählen</h2>
                    </div>
                    <form action="fade.php" method="get">
                    	<input type="hidden" name="url" value="<?php echo $_SERVER['PHP_SELF'] ?>" />

                        <div class="mdl-card__actions mdl-card--border">
                            <b> zusätzliche Modi</b>: <br><br>
                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
                                <input type="radio" id="option-1" class="mdl-radio__button" name="mode" value="0" checked>
                                <span class="mdl-radio__label">Mode 0</span>
                            </label>
                            feste Farben, die unter "Farben einstellen" eingestellt werden <br>
                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
                                <input type="radio" id="option-2" class="mdl-radio__button" name="mode" value="1">
                                <span class="mdl-radio__label">Mode 1</span>
                            </label>
                            Fade zu zufällig generierten Farben
                            <br>
                            <!-- Accent-colored raised button with ripple -->
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                                Mode wählen
                             </button>
                         </div>
                    </form>
                 </div>
                </div>
                <div class="mdl-cell mdl-cell--3col mdl-cell--3-col-desktop  mdl-cell--4-col-tablet mdl-cell--top ">
                    <div class="mdl-card mdl-shadow--4dp steady_lighting-card">
                        <div class="mdl-card__title">
                              <h2 class="mdl-card__title-text">Fadezeit einstellen</h2>
                        </div>
                        <div class="mdl-card__actions mdl-card--border">
                        <form action="fade.php" method="get">
                        	<input type="hidden" name="url" value="<?php echo $_SERVER['PHP_SELF'] ?>" />

                             Dauer zum Anschalten der LEDs bestimmen: <br>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" type="number" pattern="-?[0-9]*(\.[0-9]+)?" id="timebox" size="10" name="a_time" min="200" max="1000000">
                                <label class="mdl-textfield__label" for="timebox">Fadezeit</label>
                                <span class="mdl-textfield__error">Zahl zwischen 200 und 1 Mio. eingeben!</span>
                            </div>

                           <br>  oder mit dem Slider auswählen (200-5'000)
                             <input class="mdl-slider mdl-js-slider" type="range" name="time" min="200" max="5000" step="1" value="0">
                             <!-- Accent-colored raised button with ripple -->
                             <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                                 Fadezeit ändern
                             </button>
                        </form>
                        </div>
                    </div>
                                <!-- empty cell so the design looks good on every screen (so the center card is centered    -->
                </div>
            </div>
        </div>
    </main>
</div>
<script>
  function showFadingInfo() {
    window.alert("leds are fading");
  }

</script>
</body>
</html>
