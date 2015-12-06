<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="expires" content="0">
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
<body>

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
          //the example.csv and the colors.csv must have the same colors defined!
          $ncurrentColors = 0;
          if (($handle = fopen("example.csv", "r")) !== FALSE) {
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
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
              <tbody>
            <?php

            for ($color=0; $color < $nColors; $color++) {
              //new table row and data
              //echo "<tr><td> \n";
              //printing the card with background-color and font color from csv file.
              echo "<tr style=\"color:"  . $globalConfig[$color][2] . "; background-color:" . $globalConfig[$color][3] . "; \" > <td> \n";
              //printing the colorName string
              echo $globalConfig[$color][4] . "\n";
              echo "<input class=\"mdl-slider mdl-js-slider\" type=\"range\" name=\"" . $globalConfig[$color][0] . "\" min=\"0\" max=\"1000\" step=\"1\" value=\"";
              //check for every color because we dont know how theyre ordered
              $colorBrightnessKey = 0;
              //we'll search for the right currentBrightness with the primary key colorCode
              //i dont know why but we have to use strncmp otherwise it can't detect if the variables are the same or not.
              //if its not the matching currentBrightness we'll look for the next one (therefore increase colorBrightnessKey)
              while(strncmp($globalConfig[$color][0] , $colorBrightness[$colorBrightnessKey][0], 1)!=0) {
                $colorBrightnessKey++;
              }
              //then write current brightness as value
              echo $colorBrightness[$colorBrightnessKey][1]  . "\">\n";
              //and close the div container
              //echo "</div>\n";
              echo "</td></tr> \n";
            }
            //end of table row and data

             ?>
          </tbody>
        </table>

                <div class="mdl-card__actions ">
                     <div class="mdl-grid ">
                         <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col-tablet mdl-cell--3-col-phone">
                           <!-- Accent-colored raised button with ripple -->
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                                LEDs schalten
                            </button>
                         </div>

          </div>
        </div>
        </form>
      </div>
    </div>
  </div>


</body>
