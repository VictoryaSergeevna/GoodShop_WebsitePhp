<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link  href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php 
include ("classes.php");	
if(isset($_GET['id'])){
 $id=$_GET['id'];
 $pdo=Tools::connect();
 $item=Item::fromDb($id);
 $item->itemInfo(); 
}

 ?>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>