<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link rel="stylesheet" type="text/css" href="/web/css/normalize.css" />
<?php 
foreach ($data['stylesheets'] as $stylesheet)
	echo '<link rel="stylesheet" type="text/css" href="' . $stylesheet . '" />' . PHP_EOL;;
?>

<script src="/web/js/jquery-1.8.3.min.js"></script>
<?php
foreach ($data['javascripts'] as $script)
	echo '<script src="' . $script . '"></script>' . PHP_EOL;;
?>
  
</head>

<body>

<!-- Flash message, move to whereever you want it to be. -->
<?php if ($data['flash']): ?>
<div id="flash">
	<div><?php echo $data['flash']; ?></div>
</div>
<?php endif; ?>
<!-- End flash message -->
