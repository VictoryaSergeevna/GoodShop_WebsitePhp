 <?php 
 include_once('classes.php'); 
 $page=$_GET['page'];
if($_SESSION['registered_user'])
{
echo '<form action="index.php';
if(isset($_GET['page'])) echo '?page='.$_GET['page'].'" ';
echo 'class="form-inline float-right" method="post">';
echo '<h4 style="color:blueviolet;font-weight:bold;">Здраствуйте: <span>'.$_SESSION['registered_user'].'!</span>&nbsp;';
echo '<input type="submit" style="color:palegreen;font-weight:bold;" value="Logout" id="ex" name="ex" class="btn btn-default btn-xs"></h4>';
echo '</form>';
if($_POST['ex'])
{
	unset($_SESSION['registered_user']);
	echo ' <script>window.location.reload()</script>';

}
}
else if($_SESSION['registered_admin'])
{
	echo '<form action="index.php';
if(isset($_GET['page'])) echo '?page='.$_GET['page'].'" ';
echo 'class="form-inline float-right" method="post">';
echo '<h4 style="color:firebrick;font-weight:bold;">Здраствуйте: <span>'.$_SESSION['registered_admin'].'!</span>&nbsp;';
echo '<input type="submit" type="submit" style="color:palegreen;font-weight:bold;" value="Logout" id="ex" name="ex" class="btn btn-default btn-xs"></h4>';
echo '</form>';
if($_POST['ex'])
{
	unset($_SESSION['registered_admin']);
	echo ' <script>window.location.reload()</script>';

}
}


else
{
	if(!isset($_POST['input']))
	{
	   	
   echo '<form action="index.php';
  if(isset($_GET['page'])) echo '?page='.$_GET['page'].'" ';
echo 'class="navbar-form navbar-left" method="post">';
echo '<div class="form-group">';
echo '<input class="input-sm" type="text" placeholder="логин"  name="auth_log">
      <input class="input-sm" type="pass" placeholder="пароль"  name="auth_pas">
      <input class="btn btn-sm  btn-outline-light" type="submit" name="input">';
echo   '</div>';
 echo   '</form>';
    
	}
   else
	{
	
    if(Customer::authorization($_POST['auth_log'],$_POST['auth_pas'])){
	  echo ' <script>window.location.reload()</script>';
	 }
		
	}
}
?>



 




