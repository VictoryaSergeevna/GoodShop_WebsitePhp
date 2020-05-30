<?php
include_once('classes.php');
$cat=$_POST['cat'];
$pdo=Tools::connect();
$items=Item::GetItems($cat);
if($items==null)exit();
foreach($items as $item)
{
 $item->Draw();
}
?>
