<?php
/*
Convert the .csv to *.js
*/
function generate_js_header()
{
	$var = "";
	$var = $var."//This java script is generated automatically.\r\n";
	$var = $var."{\r\n";
	
	return $var;
}

function generate_js_footer()
{
	$var = "";
//	$var = $var."//This java script is generate automatically.\r\n";
	$var = $var."}\r\n";
	
	return $var;
}

$output_dir = "language/";
if (is_dir($output_dir))
{
	echo "The output directory $outputdir existed. Exiting. \n";
	exit;
}

// open the csv file and save to very large array.
$csv_filename = "res.csv";
$fread_tmp = file($csv_filename);
$index_number = count($fread_tmp);
//for ($j=0;$j<10;$j++)	// for debug.
for ($j=0;$j<$index_number;$j++)
{
	$very_large_array[$j] = str_getcsv ($fread_tmp[$j]);
}

$language_list = $very_large_array[0];
$language_number = count($language_list);
mkdir ($output_dir);

// Start writing .js files.
//for ($i=1;$i<2;$i++)
for ($i=1;$i<$language_number;$i++)
{
	$current_language = trim($language_list[$i]);
	if ($current_language == "")
	{ continue; }
	
	echo "language_list[$i] = ".$current_language."\n";
	
	$handle = fopen($output_dir.$current_language, "w");
	if ($handle == false)
	{
		echo __FILE__.":".__LINE__.":Cannot write $output_dir$current_language\n";
		exit;
	}
	// Write the UTF-8 bom to identify this file needs process with UTF-8
	$utf8_with_bom = chr(239) . chr(187) . chr(191);
	fwrite($handle,$utf8_with_bom);

	fwrite($handle, generate_js_header());
	
//	for ($j=1;$j<20;$j++)	// for debug.
	for ($j=1;$j<$index_number;$j++)
	{
		$str_index = $very_large_array[$j][0];
		$str_value = $very_large_array[$j][$i];
		$str = "";
		
		$str = $str.'"'.addcslashes($str_index,'"').'"'.":".'"'.addcslashes($str_value,'"').'"';
		if ($j != $index_number -1)
		{ $str = $str.","; }
		$str = $str."\r\n";
//		echo $str;
		fwrite($handle, $str);
	}
	
	fwrite($handle, generate_js_footer());
	fclose($handle);
}
?>