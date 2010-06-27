<?php require('pxl/pixel.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title><?php page_title(); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="<?php style_url(); ?>" />
	
	<?php pixel_meta(); ?>
</head>
<body>
<div class="wrapper">
	<div class="content">
		<h1 class="header"><a href="<?php blog_url(); ?>"><?php blog_title(); ?></a></h1>
		<?php pixel_content(); ?>
		<?php $round = 5;$m_time = explode(" ",microtime()); $m_time = $m_time[0] + $m_time[1]; $endtime = $m_time; $totaltime = ($endtime - $starttime); ?>
		<p class="footer"><em><?php echo "Page loaded in ". round($totaltime,$round) ." seconds"; ?></em></p>
	</div>
	<div class="sidebar">
		<h1>Huh?</h1>
		<p>This is <?php blog_title(); ?>, a blog by <?php author();?> and best described as &ldquo;<?php blog_desc(); ?>&rdquo;.</p>
		<p>You can subscribe to this blog in your favourite feed reader by clicking <a href="<?php url("feed"); ?>">here</a> or feeding it <a href="<?php url("feed"); ?>">this</a> URL.</p>
		<p>This blog is powered by <a href="http://spoolio.co.cc/p/pixel">Pixel</a> version <?php echo VERSION; ?>.</p>
	</div>
</div>
</body>
</html>