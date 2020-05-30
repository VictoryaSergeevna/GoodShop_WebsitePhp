 <?php
$_GET['page'] = 4;
if(isset($_SESSION['registered_admin']))
{
?>
 <form action="index.php?page=4" method="POST" enctype='multipart/form-data'>
  <h1>CATALOG</h1> 
  <div class="form-group">
   <label>Категории:
   <select name="catId" class="form-control">  
    <option value=0>Select category...</option>
 <?php
 $pdo=Tools::connect();
 $res=$pdo->prepare('SELECT * FROM categories');
 $res->execute();
 $row=$res->fetch();    
 while($row=$res->fetch()){
 	echo'<option  value="'.$row["id"].'">'.$row["categoryName"].'</option>';
 }
 ?>
  </select> 
  </label>    
  </div>
  <div class="form-group">
    <label>Название товара:
    <input type="text" class="form-control" name="itemName" required>
    </label>
  </div>
  <div class="form-group">
    <label>Price In:
    <input type="text" class="form-control"  name="priceIn" required>
    </label>
     <label>Price Sale:
    <input type="text" class="form-control"  name="priceSale" required>
    </label>
  </div>
   <label> Описание товара: </label> 
  <div class="form-inline">   
    <textarea class="form-control  mr-sm-2" rows="5" cols="45" maxlength="500" name="info"></textarea>     
  </div>
   <div class="form-group">
   	<label>Выберите картинку:</label> 
   <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
   <input type="file" name="file" class="form-control-file"   accept="images/*">   
 <div>
 <input type="submit" name="add" value="Загрузить" class="btn btn-outline-success my-2 my-sm-0">  
</form>
<?php
if(isset($_POST['add'])){
 $catId=$_POST['catId'];
 $itemName=$_POST['itemName'];
 $priceIn =$_POST['priceIn'];
 $priceSale=$_POST['priceSale'];
 $info =$_POST['info']; 
      
     if ($_FILES && $_FILES['file']['error']== UPLOAD_ERR_OK)
    { 
      $name = $_FILES['file']['name'];
      $imagepath='images/'.$name;
      move_uploaded_file($_FILES['file']['tmp_name'], $imagepath);
  
  $item=new Item($itemName, $catId, $priceIn, $priceSale, $info,$imagepath,$rate=0,$action=0,$id=0);     

   $item->intoDb();   	
      echo '<script>';
      echo 'window.location=document.URL;';
      echo '</script>';   
   
    
     
     }

   }
   }
else
   {
  echo "<h3><font color=red font face='arial' size='20pt'>Только для админа!</font></h3>";
  exit();
  }

?>
