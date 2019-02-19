<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $pageTitle; ?></title>
	<link rel="stylesheet" href="css/styles.css" type="text/css">
</head>
<body>

 <div class="topnav">
  <a href="#services">Услуги</a>
  <a href="#gallery">Галерия</a>
  <a class="<?php if ($section == "contact") { echo "active"; } ?>" href="contact.php">Връзка</a>
  <a class="<?php if ($section == "home") { echo "active"; } ?>" href="index.php">Начало</a>
  <a class="topnav-brand" href="index.php">Metimpex</a>
</div> 
   