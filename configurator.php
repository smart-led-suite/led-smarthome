<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="expires" content="0">
    <title>Konfigurator von LED Steuerung @ Home</title>
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
                    <a class="mdl-navigation__link" href="index.php">Fadeseite</a>
                    <a class="mdl-navigation__link" href="wecker.php">Wecker (beta)</a>
                    <a class="mdl-navigation__link" href="index-oldhtml.html">alte Fadeseite</a>
                  </nav>
              </div>
          </header>
         <!-- drawer -->
          <div class="mdl-layout__drawer">
              <span class="mdl-layout-title">LED Control Panel</span>
              <nav class="mdl-navigation">
                <a class="mdl-navigation__link" href="index.php">Fadeseite</a>
                <a class="mdl-navigation__link" href="wecker.php">Wecker (beta)</a>
                <a class="mdl-navigation__link" href="index-oldhtml.html">alte Fadeseite</a>
             </nav>
          </div>


       <main class="mdl-layout__content"  >
            <div class="page-content">
      <!-- Steady lighting is the former index.html with the sliders -->

                <div class="mdl-grid ">
                  <div class="mdl-cell  mdl-cell--3-col-desktop mdl-cell--hide-phone mdl-cell--1-col-tablet">
                                  <!-- empty cell so the design looks good on every screen (so the center card is centered    -->
                  </div>

    <div class="mdl-cell mdl-cell--middle  mdl-cell--stretch mdl-cell--6-col mdl-cell--4-col-phone mdl-cell--8-col-tablet ">
        <div class="mdl-card mdl-shadow--4dp steady_lighting-card">

          <div class="mdl-card__title">
              <h2 class="mdl-card__title-text">Konfiguration</h2>
          </div>
          <?php



           //*** IF THERE HAS BEEN USER INPUT WRITE THAT TO THE FILE***
           //WRITING TO CONFIG FILE
           //if we have received any new messages
           if ($_POST)
           {
             //variables
             //ordered in the way they are written into csv file.
             $code = $_POST['code'];
             $pin = $_POST['pin'];
             $textColor = $_POST['textColor'];
             $displayColor = $_POST['color'];
             $name = $_POST['name'];
             //open config file in write mode
             if (($file = fopen("colors.csv", "w")) !== FALSE) {
                 for ($color=0; $color < count($code); $color++) {
                   $config = $code[$color] . ";" . $pin[$color] . ";" . $textColor[$color] . ";" . $displayColor[$color] . ";" . $name[$color] . "\n";
                   fwrite($file, $config);
                 }
                 echo
                 "<div class=\"mdl-card__title\">
                     <h2 class=\"mdl-card__title-text\" style=\"color:green\">    writing to file successful </h2> </div>";
                 fclose($file);
             }
              else
             {
               echo
               "<div class=\"mdl-card__title\">
               <h2 class=\"mdl-card__title-text\" style=\"color:red\"> settings couldn't be saved :( </h2></div>";
             }

           }

           //NOW OPEN THE CONFIG FILE IN READ MODE
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
           ?>
          <form action="" method="post">
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
              <thead>
                <tr>
                  <th class="mdl-data-table__cell--non-numeric">Name</th>
                  <th class="mdl-data-table__cell--non-numeric" style="width:auto;" >Code</th>
                  <th class="mdl-data-table__cell--non-numeric" style="width:auto;" >Pin</th>
                  <th class="mdl-data-table__cell--non-numeric" style="width:auto;" >Farbe</th>
                  <th class="mdl-data-table__cell--non-numeric" style="width:auto;" >Text</th>
                </tr>
              </thead>
              <tbody>

                  <?php
                  for ($color=0; $color < $nColors; $color++) {
                    echo "<tr style=\"color:black\"> \n"; //new table row
                    //NAME (5th row in colors.csv -> value of 4 in multidimensional array)
                    echo "<td> \n"; //new table data, Name field
                    //create new textfield
                    echo " <div class=\"mdl-textfield mdl-js-textfield mdl-textfield--floating-label\" style=\"width:auto;\" > \n";
                    //fill in textfield
                    echo "<input class=\"mdl-textfield__input\" type=\"text\" id=\"name" . $globalConfig[$color][0] . "\" ";
                    echo " name=\"name[]\" value=\"". $globalConfig[$color][4] . "\"> \n";
                    //generate label
                    echo "<label class=\"mdl-textfield__label\" for=\"name" . $globalConfig[$color][0] . "\">Name</label> \n";
                    echo "</div> \n"; //end of div container
                    echo "</td>  \n"; //end of this data part
                    //CODE
                    echo "<td> \n"; //new table data, Code field
                    //create new textfield
                    echo " <div class=\"mdl-textfield mdl-js-textfield mdl-textfield--floating-label\" style=\"width:auto;\"> \n";
                    //fill in textfield
                    echo "<input class=\"mdl-textfield__input\" type=\"text\" id=\"code" . $globalConfig[$color][0] . "\" ";
                    echo " name=\"code[]\" value=\"". $globalConfig[$color][0] . "\"> \n";
                    //generate label
                    echo "<label class=\"mdl-textfield__label\" for=\"code" . $globalConfig[$color][0] . "\">Code</label> \n";
                    echo "</div> \n"; //end of div container
                    echo "</td>  \n"; //end of this data part
                    //PIN
                    echo "<td> \n"; //new table data, Code field
                    //create new textfield
                    echo " <div class=\"mdl-textfield mdl-js-textfield mdl-textfield--floating-label\" style=\"width:auto;\"> \n";
                    //fill in textfield
                    echo "<input class=\"mdl-textfield__input\" type=\"number\" id=\"pin" . $globalConfig[$color][0] . "\" ";
                    echo " name=\"pin[]\" value=\"". $globalConfig[$color][1] . "\"> \n";
                    //generate label
                    echo "<label class=\"mdl-textfield__label\" for=\"pin" . $globalConfig[$color][0] . "\">Pin</label> \n";
                    echo "</div> \n"; //end of div container
                    echo "</td>  \n"; //end of this data part
                    //FARBE / COLOR
                    echo "<td> \n"; //new table data, Code field
                    echo "<br>\n"; //add a new line so it is at the same height as the other input fields
                    //new color input field
                    echo "<input class=\"mdl-textfield__input\" type=\"color\" ";
                    echo " name=\"color[]\" value=\"". $globalConfig[$color][3] . "\"> \n";
                    echo "</td>  \n"; //end of this data part
                    //FARBE / COLOR
                    echo "<td> \n"; //new table data, Code field
                    echo "<br>\n"; //add a new line so it is at the same height as the other input fields
                    //new color input field
                    echo "<input class=\"mdl-textfield__input\" type=\"color\" ";
                    echo " name=\"textColor[]\" value=\"". $globalConfig[$color][2] . "\"> \n";
                    echo "</td>  \n"; //end of this data part

                  }
                  echo "</tr> \n";
                   ?>
                <!--   <tr>
                  <td>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"style="width:auto;">
                     <input class="mdl-textfield__input" type="text" id="name1" name="code" value="weiß">
                     <label class="mdl-textfield__label" for="name1">Name</label>
                    </div>
                  </td>
                  <td>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:auto;">
                     <input class="mdl-textfield__input" type="text" id="name1" name="code" value="w">
                     <label class="mdl-textfield__label" for="name1">Code</label>
                    </div>
                  </td>
                  <td>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:auto;">
                     <input class="mdl-textfield__input" type="number" id="pin1" name="pin1" value="w">
                     <label class="mdl-textfield__label" for="pin1"> Pin</label>
                    </div>
                  </td>
                  <td><br><input class="mdl-textfield__input" type='color' name='color' /></td>
                  <td><br><input class="mdl-textfield__input" style="align-content:center" type='color' name='color' /></td>
                </tr> -->
              </tbody>
            </table>


            <?php

             ?>
                <div class="mdl-card__actions ">
                     <div class="mdl-grid ">
                         <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col-tablet mdl-cell--3-col-phone">
                           <!-- Accent-colored raised button with ripple -->
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                              Konfigurieren
                            </button>
                         </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
