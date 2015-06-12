This is a tool for 2013 GUI language.

Prepare:
	1. Install the regular PHP in PC, not xmldbc PHP. The recommanded PHP for Windows is EasyPHP. It can be downloaded from "http://www.easyphp.org/". After installing, rebooting computer may be required.
	2. Copy rootfs/htdocs/web to the directory of the php file.

Capture all strings that call I18N function in *.html and *.js
	1. Execute "php 0_scan_web.php" and it will scan all .html and .js files, and put the caputred string to "web/js/localization/0_index.js". 

Convert the all language js files and the scanned string to .csv file
	1. Execute "php 1_js_to_csv.php" and it will scan all .js file in "web/js/localization" and merge the language strings to "res.csv".
	2. Open the "res.csv" with Excel. Here is the all language strings. You may edit this csv file to change the translation in easy way.
	
Convert "res.csv" to .js file
	1. If there is a directory named with "language" in php directory, delete it.
	2. Execute "php 2_csv_to_js.php" and it will read "res.csv" and output the language string to "language/*.js" 

	
	