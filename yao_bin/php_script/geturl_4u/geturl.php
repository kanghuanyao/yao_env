<?php

/*
if (!isset($_GET['url']))
{ exit(0);}
$url = $_GET['url'];

if ( $url == "")
{ exit(0);}
*/
	
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

/*
	phase 1: Get the torrent file in the blog.
*/
function phase1($url)
{
	$content_full = getHtml($url);


	$str_start = '<p><b>BitTorrent File</b><br><a href="';
	$str_end = '" target="_blank"';
	$content_url = strstr($content_full, $str_start);
	$content_url = strstr($content_url, $str_end, true);

	$content_url = substr($content_url, strlen($str_start), strlen($content_url) - strlen($str_start));
	return $content_url;
}	

function phase2($url)
{
	$content_full = getHtml($url);
	echo $content_full;
}



$url_list_fp = fopen("url.txt", "r");

for ($i=0;!feof($url_list_fp);$i++)
{
	$url_list[$i] = fgets($url_list_fp);
	$url_phase1 = phase1($url_list[$i]);
	echo $url_phase1;
}





//phase2('http://l.jav4you.com/RynX1A');






?>
