<?php
$_GET['page'] = 2;
?>
	<form action="index.php?page=2" method="POST">
	<h1 style="color:green;font-size:30px;">Корзина</h1> 
<?php
 $ruser='';
    if(!isset($_SESSION['registered_user']) || $_SESSION['registered_user'] =="")
    {
      $ruser="cart";
    }
    else
    {
      $ruser=$_SESSION['registered_user'];
    }
    $total=0;
    foreach ($_COOKIE as $k => $v) {
    	$pos=strpos($k,"_");
    	if(substr($k,0,$pos)==$ruser){
    		$id=substr($k,$pos+1);       
    		$item=Item::fromDb($id);
    		$total+=$item->priceSale;
    		$item->DrawForCard();
    	}
    }
      
     echo '<hr/>';
     echo '<span style="margin-left:100px; color:darkgreen; font-size:20px; font-weight:bold; background:rgba(114, 244, 114, 0.8);">Total cost:</span>';
   
    echo '<span style="margin-left:100px; color:red; font-size:20px; font-weight:bold; background:lightgrey;">'.$total.'</span>';
    echo '<button class="btn btn-success" style="margin-left:150px;" name="order" onclick=deleteCookie("'.$ruser.'")>заказ на покупку</button>'; 
     ?> 	
</form>
<?php
if(isset($_POST['order']))
{
    foreach($_COOKIE as $k => $v)
    {
        $pos=strpos($k,"_");
        if(substr($k,0,$pos) == $ruser)
        {
           
            $id=substr($k,$pos+1);            
            $item=Item::fromDb($id);            
            $item->Sale();
        }
    }
}
?>

<script type="text/javascript">
function createCookie(uname,id)
    {
        var date = new Date(new Date().getTime() + 60 * 1000 * 30);
        document.cookie = uname+"="+id+"; path=/; expires=" + date.toUTCString();
    }
    
    function deleteCookie(uname) 
    {
        var theCookies = document.cookie.split(';');
    for (var i = 1 ; i <= theCookies.length; i++) 
    {
        
      if(theCookies[i-1].indexOf(uname) === 1)
      {
        var theCookie=theCookies[i-1].split('=');
        
        var date = new Date(new Date().getTime() - 60 * 1000 * 30);
        document.cookie = theCookie[0]+"="+"id"+"; path=/; expires=" + 
            date.toUTCString();
      }
    }
    }
</script>