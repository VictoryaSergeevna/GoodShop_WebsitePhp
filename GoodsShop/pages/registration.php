<?php
$_GET['page'] = 3;
?>
	<form action="index.php?page=3" method="POST" enctype='multipart/form-data'>
	<h1>Регестрация</h1> 
 <div class="form-group">
    <label for="InputLogin">Введите логин:</label>
    <input type="text" class="form-control" placeholder="Логин должен содержать 3-30 символов" name="login" > 
    <div id="res"></div>   
  </div>
  <div class="form-group">
    <label for="InputPassword">Пароль:</label>
    <input type="password" class="form-control" id="InputPassword" placeholder="Введите пароль" name="pass"  required>
  </div>
  <div class="form-group">
    <label for="InputRepeat_Pas">Повторите пароль:</label>
    <input type="password" class="form-control" id="InputRepeat_Pas" placeholder="Пароли должны совпадать" name="repeat_pas" required>
  </div>
   <div class="form-group">
   <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
   <input type="file" name="file" class="form-control-file"   accept="images/*"><br> 
 <div>
 <input type="submit" name="save" value="Загрузить" class="btn btn-outline-success my-2 my-sm-0">
</form>
<?php
if(isset($_POST['save'])){
 $login=$_POST['login'];
 $pass =$_POST['pass'];
 $repeat_pas =$_POST['repeat_pas']; 
  if($pass == $repeat_pas)
  {       
     if ($_FILES && $_FILES['file']['error']== UPLOAD_ERR_OK)
    { 
      $name = $_FILES['file']['name'];
      $imagepath='images/'.$name;
      move_uploaded_file($_FILES['file']['tmp_name'], $imagepath);
  
     
     if(Tools::registration($_POST['login'],$_POST['pass'],$imagepath))  {   
     echo "<h3/><span style='color:green;'>
      Новый пользователь добавлен!</span><h3/>";
     }

     else {
      echo "<h3/><span style='color:red;'>
     Новый пользователь НЕ добавлен!</span><h3/>";
     }

   }
  }
else
    {
        echo "<h3><font color=red font face='arial' size='20pt'>Пароли не совпадают!</font></h3>";
     }
}
?>
