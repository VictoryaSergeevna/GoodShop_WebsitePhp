<?php
$_GET['page'] = 1;
?>
 <h1 style="color:green;font-size:25px;">Каталог товаров</h1>
  <form action="index.php?page=1" method="POST"> 
  <div class="row"> 
  <select name="CatId"  onchange="getItemsCat(this.value)" class="pull-right" style="margin-left:20px;">  
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
</div>
<div class="row" style="margin-right:10px;" id="catid">
<?php  
  $items=Item::GetItems();
  if($items==null)exit();
foreach($items as $item)
{ 
 $item->Draw();
}
?>
  </div>
</form>

<script type="text/javascript"> 

 function getItemsCat(value)
 {
 	if (value=='0'){
 	document.getElementById("catid").innerHTML="";
 	}
 
  if(window.XMLHttpRequest){
    ao=new XMLHttpRequest();
  }
  
  else{
    ao=new ActiveXObject('Microsoft.XMLHTTP');
  }
if(ao.readyState == 4 || ao.readyState == 0)
 {  
  ao.open("POST","pages/list.php", true);
  ao.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 ao.onreadystatechange = function()
{
if(ao.readyState == 4 && ao.status == 200)
{
resp = ao.responseText;
document.getElementById("catid").innerHTML = resp;
} 
}  
 ao.send("cat="+value);
} 
}

function createCookie(uname,id)
{
var date = new Date(new Date().getTime() + 60 *1000 * 30);
document.cookie = uname+"="+id+"; path=/; expires=" + date.toUTCString();
}

</script>