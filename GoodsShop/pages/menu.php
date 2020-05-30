<?php
$page=$_GET['page'];
?>
<div class="container-fluid" id="myNavbar">
  <ul class="nav navbar-nav">

  <li class="nav-item">
    <a <?php echo($page==1)?"class='nav-link active'":"class='nav-link'"?> href="index.php?page=1">Catalog</a>
  </li>
  <li class="nav-item">
    <a <?php echo($page==2)?"class='nav-link active'":"class='nav-link'"?> href="index.php?page=2">Cart</a>
  </li>
  <li class="nav-item">
    <a <?php echo($page==3)?"class='nav-link active'":"class='nav-link'"?> href="index.php?page=3">Registration</a>
  </li>  
  <li class="nav-item">
    <a <?php echo($page==4)?"class='nav-link active'":"class='nav-link'"?> href="index.php?page=4">Admin Forms</a>
  </li>  
 <?php
/* if(isset($_SESSION['registered_admin'])){
  if($page==6)
    $c='active';
  else
    $c='';
  echo '<li class="nav-item"><a class="nav-link '.$c.'"href="index.php?page=6">Private</a></li>';
 }*/
  ?>
</ul>
<ul class="nav navbar-nav navbar-right">
 <?php
  include_once('pages/login.php');
  ?>
 
</form>
  </ul>
</div>
<style type="text/css">
  div{
    margin-top: 1%;
  }
  a:hover{
    color: white;
    font-weight: bold;
  
  }
  ul{    
    height: 50px;   
       
  }
  li{    
    font-weight: bold;
    font-size:20px;
    width: 150px;
  
  } 
  input{
    margin:3px;
  } 
 
</style>