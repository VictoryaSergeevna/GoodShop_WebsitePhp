<?php
session_start();
include_once('pages/classes.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Shops</title>	
<link  href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="row">
			<header class="col-sm-12 col-md-12 col-lg-12">
			  
			</header>
		</div>

		<div class="row">
		<nav  class="navbar navbar-dark bg-dark col-sm-12 col-md-12 col-lg-12">		
				<?php
				 include_once('pages/menu.php');	 
				 ?>		 
		</nav>
		</div>

		<div class="row">
			<section class="col-sm-12 col-md-12 col-lg-12">
			<?php
			if(isset($_GET['page'])){
				$page=$_GET['page'];
				if($page==1) include_once('pages/catalog.php');
				if($page==2) include_once('pages/card.php');
				if($page==3) include_once('pages/registration.php');
				if($page==4) include_once('pages/admin.php');
				/*if($page==6&&isset($_SESSION['registered_admin']))include_once('pages/private.php');				*/				
			}
			?>	
			</section>
		</div>
		
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
