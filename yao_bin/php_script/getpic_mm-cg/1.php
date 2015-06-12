<?php 

function getHtml($url, $post = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    if(!empty($post)) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    } 
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function download_remote_file_with_curl($file_url, $save_to) 
{ 
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_POST, 0); 
	curl_setopt($ch,CURLOPT_URL,$file_url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$file_content = curl_exec($ch); 
	curl_close($ch);   
	$downloaded_file = fopen($save_to, 'w'); 
	fwrite($downloaded_file, $file_content); 
	fclose($downloaded_file);   
} 

$url = "http://18h.mm-cg.com/18H_2281.html";

$ch = getHtml($url);

// Use regular expression to get all the jpeg link.
$pattern = "/Large_cgurl[\[][0-9]+[\]][ ]= \"http:\/\/.*\.jpg\"/";
preg_match_all($pattern, $ch, $matches);

//var_dump($matches);

for ($i=0;$i<count($matches[0]);$i++)
{
	$str = $matches[0][$i];
//	echo "step 1: $i -> <$str>\n" ;

	// Get URL.
	$str = strstr($str,"=");
	$str = substr($str, 2, 100);
//	echo "step 2: $i -> <$str>\n" ;
	$str = trim($str, " \t\n\r\0\x0B\"");
//	echo "step 3: $i -> <$str>\n" ;

	$jpeg_url = $str;

	// Get the filename.
	$filename = strrchr($str, "/");
	$filename = substr($filename, 1, 100);
//	echo "step 4: $i -> <$filename>\n" ;

	//download the image file.
	download_remote_file_with_curl($jpeg_url, $filename);

}

?>