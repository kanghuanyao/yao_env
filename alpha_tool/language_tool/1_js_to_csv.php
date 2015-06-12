<?php
/*
This is the PHP file which can get all .js file (language) and transform them to csv.

*/

/* handle one .js file */
function handle_language($lang_name, $lang)
{
	global $language_index, $very_large_array; 
	echo "Starting processing $lang_name...";
	//var_dump($lang);
	
	$very_large_array[0][$language_index] = $lang_name;
	
	for ($i=0;$i<count($lang);$i++)
	{
		$oneline = $lang[$i];
		if (strstr($oneline, "//") || strstr($oneline, "{") || strstr($oneline, "}"))	//skip some lines.
		{ continue; }
		
		$oneline_ary = explode(":",$oneline);
		if (count($oneline_ary) != 2)	// Something error in the line. needs to skip it.
		{ continue; }
		
		$ary_index = trim($oneline_ary[0], " \t\n\r\0\x0B\"");
		$ary_value = trim($oneline_ary[1]," \t\n\r\0\x0B,");	// remove the last ","
		$ary_value = trim($ary_value, " \t\n\r\0\x0B\"");
		$ary_index = stripslashes($ary_index);
		$ary_value = stripslashes($ary_value);

		// find the index is already exist in the very large array.
		$found = 0;
		for($j=0;$j<count($very_large_array);$j++)
		{
			if ($ary_index == $very_large_array[$j][0])
			{
				// Found
				$very_large_array[$j][$language_index] = $ary_value;
				$found = 1;
				
				break;
			}
		}

		// Not found, needs to add the new index.
		if ($found == 0)
		{
			$new_location = count($very_large_array);
			$very_large_array[$new_location][0] = $ary_index;
			$very_large_array[$new_location][$language_index] = $ary_value;
		}
	}
	
	echo " done.\n";

}


/* Write the very large array to .csv file */
function write2file($filename)
{
	global $very_large_array;
	echo "Starting write result to $filename...";
	
	$handle = fopen($filename, "w");
	if ($handle == FALSE)
	{
		echo "Error when opening $filename\n";
		return ;
	}
	
	// Write the UTF-8 bom to identify this file needs process with UTF-8
	$utf8_with_bom = chr(239) . chr(187) . chr(191);
	fwrite($handle,$utf8_with_bom);
	
	for ($i=0;$i<count($very_large_array);$i++)
	{
		$line = $very_large_array[$i];
		// Fill un-translated words.
		for ($j=1;$j<count($very_large_array[0]);$j++)
		{
			if (!isset($line[$j]))
				$line[$j] = "";
		}
		
		// resort by key. otherwise it will put empty words at last.
		ksort($line);
		if (false === fputcsv($handle, $line))
		{
			echo "Error while writing the csv.\n";
			var_dump($very_large_array[$i]);
			exit ;
		}
	}
	fclose($handle);
	echo " done.\n";
}



// Check the excel file is exist or not.
$csv_filename = "res.csv";
if (file_exists($csv_filename) == TRUE)
{
	if (unlink($csv_filename) == FALSE)
	{
		echo "Cannot delete $csv_filename\n";
		exit ;
	}
}

// Open the .js folder.
$localization_dir = 'localization/';
$localization_handle = opendir($localization_dir);
if ($localization_handle == FALSE) 
{
	echo "Cannot open path\n";
	exit ;
}
$very_large_array = array();
$very_large_array[0][0] = "str_index";
$language_index = 1;

// Scan the js folder.
while (false !== ($lang_name = readdir($localization_handle))) 
{
	if (preg_match("/^.*[.]js$/", $lang_name))
	{
		// read the js file to an array.
		$lang = file($localization_dir.$lang_name, FILE_SKIP_EMPTY_LINES);
		handle_language($lang_name, $lang);
		$language_index ++;
	}
}

closedir($localization_handle);
//var_dump($very_large_array);

write2file($csv_filename);


//show memory usage.
function convert($size)
 {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
 }
echo convert(memory_get_usage(true)); // 123 kb

?>
