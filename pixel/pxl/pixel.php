<?php
ob_start();
$m_time = explode(" ",microtime());
$m_time = $m_time[0] + $m_time[1];
$starttime = $m_time;

/*
	Pixel Version 0

	Desc:    Pixel is currently nothing more than glorified a technical demo
	Author:  http://spoolio.co.cc/
	Build:   0015
*/

// CONFIG

// Some nice and easy variables
$blog_title = "Pixel";				// Your blog title
$blog_tag	= "A fantastic Pixel powered blog!";	// A short description of your blog
$htaccess	= true;					// Whether your domain has .htaccess support or not
$author		= "Thomas Chatting";	// The default author for posting when not specified

// Leave this alone (unless you know what you're doing)
define('DOMAIN', 	preg_replace('#^www\.#', '', $_SERVER['SERVER_NAME']));
define('URL', 		str_replace('index.php', '', 'http://'.DOMAIN.$_SERVER['SCRIPT_NAME']));
define( 'VERSION', '0.3' );

$parsed = parse_pixel_url();

// FUNCTIONS
if ($_GET["delete"]) {
	if(is_admin()){
		$date = explode("/", $_GET["delete"]);
		$uri = $date[0].'/'.$date[1].'-'.$date[2].'-'.$date[3].'-'.$date[4];
		if (file_exists($uri.'.txt')) {
			rename($uri.'.txt', $uri.'.old');
			header("Location: ./");
		}
	}
}

function author() {
	global $author;
	echo $author;
}

function blog_desc() {
	global $blog_tag;
	echo $blog_tag;
}

function page_title() {
	global $parsed;
	echo $parsed[0];
}

function blog_title() {
	global $blog_title;
	echo $blog_title;
}

function articles($start_dir = 'posts') {
	// returns an array of files in $start_dir (not recursive)
	$files = array();
	$dir = opendir($start_dir);
	while(($myfile = readdir($dir)) !== false) {
		if($myfile != '.' && $myfile != '..' && !is_file($myfile) && end(explode(".", $myfile)) == 'txt' && end(explode(".", $myfile)) != "old" ) {
			$myfile = substr($myfile, 0, strlen($myfile)-4);
			$files[] = $myfile;
		}
	}
	closedir($dir);
	array_multisort($files,SORT_DESC);
	
	return $files;
}

function unbound() {
	$bound = themer(file_get_contents('template/bound.html'));
	$bound = explode("<pixel:page />", $bound);
	return $bound;
}

function pixel_content() {
	global $array;
	$ring = parse_pixel_url();
	$call = $ring[1];
	if ($call == "index") {
		$articles = articles();
		$articles = array_slice($articles, 0, 5);
		foreach ($articles as $article) {
			$post = get_post('','','','',$article.'.txt');
			if ($post[2] <= date("d/m/Y")) {
				print_post($post);
			}
		}
		echo '<hr /><p class="archive">Missing something? Check the <a href="'; url("archive"); echo'">Archive</a></p>';
	}
	if ($call == "post") {
		$array = get_post('','','','',$ring[2]);
		print_post($array);
	}
	if ($call == "archive") {
		print_archive();
	}
}

function print_post($array) {
	global $htaccess;
	if (!$htaccess) { $ht = "?/"; }
	echo "<div class='article'><h1><a href=\"$ht$array[4]\">$array[0]</a></h1>";
	echo "<p class=\"meta\">";
	if (!empty($array[1])) { echo "By ".$array[1].", "; } else { echo "By "; author(); echo ", "; }
	if (!empty($array[2])) { echo " published on ".$array[2]; }
	echo "</p>";
	echo $array[3];
	echo "</div>";
}

function blog_url() {
	echo URL;
}

function get_post($year = '', $month = '', $day = '', $title = '', $url = '') {
	if (!isset($url)) {
		$url = 'posts/'.$year.'-'.$month.'-'.$day.'-'.$title.'.txt';
	} else {
		$url = 'posts/'.$url;
	}
	
	if (file_exists($url)){
		$handle = @fopen($url, "r");
		if ($handle) {
		while (!feof($handle)) {
			$buffer = fgets($handle, 4096);
			if (substr($buffer,0,6)=="title:") {
				$array[0]=trim(substr($buffer,6));
			} else {
				if (substr($buffer,0,7)=="author:"){
					$array[1]=trim(substr($buffer,7));
				} else {
					if (substr($buffer,0,5)=="date:"){
						$array[2]=trim(substr($buffer,5));
					} else {
						$array[3].=$buffer;
					}
				}
			}
		}
		fclose($handle);
		
		$dateArray = explode("/", $array[2]);
		$slug = str_replace('posts/', '', $url);
		$slug = str_replace('.txt', '', $slug);
		$slug = str_replace($dateArray[2].'-'.$dateArray[1].'-'.$dateArray[0].'-', '', $slug);
		$array[4] = 'posts/'.$dateArray[2].'/'.$dateArray[1].'/'.$dateArray[0].'/'.$slug;
		return $array;
		}
	} else {
		return array("404", "", "", "The page you requested could not be found");
	}
}

function parse_pixel_url() {
	global $blog_title;
	
	$uri = $_SERVER['REQUEST_URI'];
	$uri = preg_replace('#\?\/#','',$uri); // Strip the ? from the URL (handling weird configs in Apache)
	$temp = str_replace('/index.php', '', $_SERVER['PHP_SELF']);
	$uri = str_replace($temp, '', $uri);
	if ($uri[0] == '/') {
		$uri = substr($uri, 1); // If the first character of input is "/" this might break our array
	}
	$input = explode('/',$uri); // Creates an array

	if ($uri[0] == '/') {
		$uri = substr($uri, 1); // If the first character of input is "/" this might break our array
	}
	$input = explode('/',$uri); // Creates an array
	
	switch ($input[0]) {
		case "posts":
			$input = implode("-", $input);
			$input = substr($input, 6);
			$url = $input.'.txt';
			$page_title = $blog_title.$post_array[0];
			return array($page_title, "post", $url);
			break;
		case "archive":
			return array($blog_title.' - Archive', "archive");
			break;
		default:
			return array($blog_title.' - Home', "index");
	}
}

function print_archive() {
	echo "<h2>Archive</h2>";
	$articles = articles();
	foreach ($articles as $article) {
		$post = get_post('','','','',$article.'.txt');
		$post_array[end(explode("/", $post[2]))][] = array(date_published => $post[2], title => $post[0], uri => $post[4]);
	}
	echo '<div class="archives">';
	foreach(array_keys($post_array) as $year) {
		echo '<div class="year">'.$year.'</div>';
		echo '<div class="posts">';
		foreach($post_array[$year] as $item) {
			echo '<p><a href="'.$item['uri'].'">'.$item['title'].'</a></p>'; 
		}
		echo "</div>";
	}
	echo '</div>';
}

function pixel_meta() {
	echo '<link rel="alternate" href="'; blog_url(); echo '" title="'; page_title(); echo '" type="application/atom+xml" />'.PHP_EOL;
	echo '<meta name="description" content="'; blog_desc(); echo '" />';
}

function url($type) {
	global $htaccess;
	$url = URL;
	if (!$htaccess) {
		$url .= "?/";
	}
	switch($type) {
		case "archive":
			echo $url."archive";
			break;
		case "feed":
			echo URL."atom.php";
			break;
		default:
			echo URL;
	}
}

function style_url() {
	echo URL.'pxl/style.css';
}