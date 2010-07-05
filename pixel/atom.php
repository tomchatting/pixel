<?php
include('pxl/pixel.php');

$DateNow = date("d/m/Y");
$updated = "01/01/1900";
$articles = articles('posts', 10);
foreach ($articles as $article) {
	$post = get_post('','','','',$article.'.txt');
	if (strtotime(date("Y-m-d",$post[2])) <= strtotime(date("Y-m-d"))) {
		$blogPost[] = $post;
	}
	if (strtotime(date("Y-m-d",$post[2])) > $updated) {
		$updated = date("Y-m-d",$post[2]);
	}
}
$temp = explode("/", $updated);
$updated = $temp[2]."-".$temp[1]."-".$temp[0];
?>
<?php header("Content-type: text/xml"); ?>
<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>".PHP_EOL; ?>
<feed xmlns='http://www.w3.org/2005/Atom' xmlns:openSearch='http://a9.com/-/spec/opensearchrss/1.0/' xmlns:georss='http://www.georss.org/georss' xmlns:thr='http://purl.org/syndication/thread/1.0'>
	<title><?php echo $blog_title; ?></title>
	<link href="<?php echo str_replace("atom.php", "", URL); ?>" />
	<id><?php echo str_replace("atom.php", "", URL); ?></id>
	<updated><?php echo $updated; ?>T00:00:00Z</updated>
<?php foreach ($blogPost as $item) { ?>
	<entry>
		<title><?php echo htmlentities($item[0]) ?></title>
		<author><name><?php if (!empty($array[1])) { echo $array[1]; } else { echo author(); } ?></name></author>
		<?php $temp = explode("/", $item[2]); $date = $temp[2]."-".$temp[1]."-".$temp[0]; ?>
		<updated><?php echo $date; ?>T00:00:00Z</updated>
		<link href="<?php echo URL.$item[4] ?>" />
		<id><?php echo URL.$item[4] ?></id>
		<content type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><?php echo $item[3] ?></div></content>
	</entry>
<?php } ?>
</feed>