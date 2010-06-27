<?php
include('pxl/pixel.php');

$DateNow = date("d/m/Y");
$updated = "01/01/1900";
$articles = articles();
$articles = array_slice($articles, 0, 10);
foreach ($articles as $article) {
	$post = get_post('','','','',$article.'.txt');
	if ($post[2] <= date("d/m/Y")) {
		$blogPost[] = $post;
	}
	if ($post[2] > $updated) {
		$updated = $post[2];
	}
	$temp = explode("/", $updated);
	$updated = $temp[2]."-".$temp[1]."-".$temp[0];
}
?>
<?php header("Content-type: text/xml"); ?>
<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; ?>
<feed xmlns="http://www.w3.org/2005/Atom">
<channel>
	<title><?php echo $blog_title; ?></title>
	<link href="<?php echo URL; ?>" />
	<id><?php echo URL; ?></id>
	<updated><?php echo $updated; ?>T00:00Z</updated>
<?php foreach ($blogPost as $item) { ?>
	<entry>
		<title><?php echo htmlentities($item[0]) ?></title>
		<?php $temp = explode("/", $item[2]); $date = $temp[2]."-".$temp[1]."-".$temp[0]; ?>
		<updated><?php echo $date; ?>T00:00Z</updated>
		<link><?php echo URL.$item[4] ?></link>
		<id><?php echo URL.$item[4] ?></id>
		<content type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><?php echo $item[3] ?></div></content>
	</entry>
<?php } ?>
</channel>
</feed>
