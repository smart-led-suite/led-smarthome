# led-smarthome

open source "smarthome"

it is basically a webinterface for the led-blaster with many functions

#Installation
 1. Install an apache2 webserver. There are many tutorials out there.
 2. Go to the directory where you have to place the websites so they can be accessed via the browser (this is usually `/var/www` or `/var/www/html/`)
 3. clone this repository into the directory: e.g. `git clone https://github-com/led-smarthome /var/www/html`  
   If you have other webpages running it may be a good idea to move led-smarthome into a led/ directory inside html/ (or www/ or whatever).  
   you can access your files via `[your-ip]/led` or `[your-ip]/your_folder_name`.  

#Usage  
##Main Page  
the main page is `[your-ip]/index.php` or `[your-ip]/your_folder_name/index.php`. Alternatively you can also use: `[your-ip]/your_folder_name/` without any specific file.
The user-interface is probably pretty intuitive.  
###Fading to Brightness
You can use the sliders to fade the colors/leds to any brightness you want. Then click `LEDs schalten`. If you want to turn all LEDs off, click `ALLES AUS`.  
###Using modes
You can select either Mode 0 or Mode 1 and click `Mode wählen` to enter this mode
###Fadetime
You can also change the time needed for a fade.  
##Configuration
If you open the Menu on the left and click on `Konfiguration` you'll be redirected to the configuration page.  
There you can change the Name, ColorCode, Pin, The color which is connected to that pin and the color of the Text in the Main Page.    
You can save the configuration with a click on `Konfigurieren` which should display a success message. Otherwise you may have to give write permission to all users for the file colors.csv.
