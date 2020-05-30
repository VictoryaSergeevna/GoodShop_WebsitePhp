<?php
class Customer
{
	public $id;
	public $login;
	public $pass;
	public $roleId;
	public $discount;
	public $total;
	public $imagepath;
	function __construct($login, $pass, $imagepath, $id=0){
		$this->login=$login;
		$this->pass=$pass;
		$this->imagepath=$imagepath;	
		$this->id=$id;
		$this->discount=0;
		$this->total=0;
		$this->roleId=2;
	}
	function intoDb(){
		try{
			$pdo=Tools::connect();
			$ps=$pdo->prepare('INSERT INTO customers(login,pass,roleId,discount,total,imagepath) values (:login, :pass, :roleId, :discount, :total, :imagepath)');
			$ar=(array)$this;
			array_shift($ar);
			$ps->execute($ar);

		}
		catch(PDOException $e)
       {
        $err=$e->getMessage();
       if(substr($err,0,strrpos($err,":"))=='SQLSTATE[23000]:Integrity constraint violation')
       return 1062;
       else
       return $e->getMessage();
       }

	}
	public static function fromDb($id){
       $customer=null;
     try{
     	$pdo=Tools::connect();
     	$ps=$pdo->prepare('SELECT * FROM customers WHERE id=?');
     	$res=$ps->execute(array($id));
     	$row=$res->fetch();
     	$customer=new Customer($row['login'], $row['pass'],$row['imagepath'],$row['id']);
     	return $customer;
     }
     catch(PDOException $e)
       {
        $err=$e->getMessage();
        return false;
       }

   }
   public static function fromDbLogin($id=0, $login="", $pass=""){
    $pdo = Tools::connect();

    try
    {
      if($login=="" && $pass=="")
      $ps = ($id==0)? $pdo->query("SELECT * FROM customers"): $pdo->query("SELECT * FROM customers where id=".$id);

      else
        $ps = $pdo->query("SELECT * FROM customers where login='".$login."' && pass='".$pass."'");    
      
      return $ps;
    } 

    catch (Exception $e) { echo $e->getMessage();}

  }

  public static function authorization($login,$pass){
 
    $res=Customer::fromDbLogin(0, $login, $pass); 
   
    if ($row=$res->fetch())
      {
   
    if($row["roleId"]==1) {
    $_SESSION['registered_admin'] = $login;         
    return true;
    } 
    else{
    $_SESSION['registered_user'] = $login;
    return true;    
    }
    }
    else {
        echo ' <script>window.location = "index.php?page=3";</script>';
        return false;
      }
    
    
  }
}

class Tools
{	
	

	public static function createDb($dbname)
	{
		$database = new self();
		$database->dbname=$dbname;
		return $database;
	}

	public static function connect($host="localhost",$user="root",$pass="",$dbname="shop")
	{
    $cs='mysql:host='.$host.';dbname='.$dbname.';charset=utf8;';
    $options=array(
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'
    ); 
   try
   {
   $pdo=new PDO($cs,$user,$pass,$options);
   return $pdo;
   }
  catch(PDOException $e)
  {
  echo $e->getMessage();
  return false;
  }		
}

/*public static function authorization($login,$pass){
  $customer=null; 
	$login=trim($login);
	$pass=trim($pass);  
	$pdo=Tools::connect();
    $ps=$pdo->prepare("SELECT * FROM customers WHERE login='$login' and pass='$pass'");
    $res=$ps->execute();
    /*$res=$ps->execute(array($login,$pass));*/
   /* $row=$res->fetch(); 
    if($row>0){
    $roleid=1; 
    if($row["roleId"]==$roleid) {
    $_SESSION['registered_admin'] = $login;         
    return true;
    } 
    else{
    $_SESSION['registered_user'] = $login;
    return true;    
    }
    }
    else {
        echo ' <script>window.location = "index.php?page=3";</script>';
        return false;
      }*/
    
    
 /* }*/



public static function registration($login,$pass,$imagepath)
{	
	$login=trim($login);
  $pass=trim($pass);
  $pass=trim($imagepath);
if($login==""||$pass==""){
	echo "<h3><span style='color:red;'>Заполните все обязательные поля!</span></h3>";
	return false;
}

if((strlen($login) < 3 || strlen($login) > 30) || (strlen($pass) < 3 || strlen($pass) > 30)){

echo "<h3><span style='color:red;'>Длина значений должна быть от 3 до 30!</span></h3>";
	return false;
}

Tools::connect();
$customer=new Customer($login,$pass,$imagepath);
$err=$customer->intoDb();
if($err){
	if($err=1062)
		echo"<h3><span style='color:red;'>Такой логин уже занят!</span></h3>";
	else
	echo"<h3><span style='color:red;'>Err code:".$err."</span></h3>";
	return false;	
}
return true;
}

}

 class Item
{
 	public $id;
 	public $itemName;
 	public $categoryId;
 	public $priceIn;
 	public $priceSale;
 	public $info;
 	public $rate;
 	public $imagepath;
 	public $action;

 	function __construct($itemName,$categoryId, $priceIn, $priceSale, $info, $imagepath, $rate=0, $action=0,$id=0)
  {
 		$this->id=$id;
 		$this->itemName=$itemName;
 		$this->categoryId=$categoryId;
 		$this->priceIn=$priceIn;
 		$this->priceSale=$priceSale;
 		$this->info=$info;
    $this->rate=$rate;
 		$this->imagepath=$imagepath; 		
 		$this->action=$action;
 	}

 	function intoDb()
  {
 		try{
			$pdo=Tools::connect();
			$ps=$pdo->prepare("INSERT INTO items(itemName,categoryId, priceIn, priceSale, info,rate,imagepath,action) values(:itemName,:categoryId, :priceIn, :priceSale, :info,:rate,:imagepath, :action)");
			$ar=(array)$this;
			array_shift($ar);
			$ps->execute($ar);

		}
		catch(PDOException $e)
       {
        
       return $e->getMessage();
       }
 	}

 	static function fromDb($id)
  {
 		$item=null;
 		try{
         $pdo=Tools::connect();
         $ps=$pdo->prepare('SELECT * FROM items WHERE id=?');
         $ps->execute(array($id));
         $row=$ps->fetch();          
         $item=new Item($row['itemName'],$row['categoryId'], $row['priceIn'],$row['priceSale'],$row['info'],$row['imagepath'],$row['rate'],$row['action'],$row['id']);
        /* echo'fromDB';*/
         return $item;
 		  }
 		catch(PDOException $e)
       {
        $err=$e->getMessage();
        return false;
       }
 	}
 	static function GetItems($categoryId=0)
  {
 		$ps=null;
 		$items=null;
 		try{
         $pdo=Tools::connect();
        
         if($categoryId==0)
         {
         $ps=$pdo->prepare('SELECT * FROM items it');
         $ps->execute();         
         }
         else
         {
         $ps=$pdo->prepare('SELECT * FROM items where categoryId=?');
         $ps->execute(array($categoryId));        
         }
         while( $row=$ps->fetch())
         {
         $item=new Item($row['itemName'],$row['categoryId'], $row['priceIn'],$row['priceSale'],$row['info'],$row['imagepath'],$row['rate'], $row['action'],$row['id']);
          $items[]=$item;
         }
        
        return $items;
 		  }
 		catch(PDOException $e)
       {
        $err=$e->getMessage();
        return false;
       }

 	}
    function Draw(){      
      echo '<div class="col-sm-3 col-md-3 col-lg-3 container" style="height:320px; margin:0;">';

      echo '<div class="row" style="margin:5px; background:rgba(114, 244, 114, 0.8);">';      
       echo '<a href="pages/itemInfo.php?id='.$this->id.'" class="pull-left" style="margin-left:10px;" target="_blank">';
       echo $this->itemName;
       echo '</a>';
       echo '<span class="pull-right" style="margin-left:90px; margin-right:10px;">';
       echo $this->rate. "&nbsp;rate";
       echo '</span>';       
      echo'</div>';

      echo'<div class="row" style="height:100px; margin:5px;">';       
       echo '<img src="'.$this->imagepath.'"/>';
       echo '<span class="pull-right" style="margin-left:10px; color:red; font-size:20px; font-weight:bold;">';
       echo "$&nbsp;".$this->priceSale;
       echo '</span>';      
      echo'</div>';

      echo'<div class="row" style="margin:5px;">';
       echo '<p class="text-left col-xs-12">';        
       echo $this->info;           
        echo'</p>';
      echo'</div>';

       echo'<div class="row" style="margin-top:5px;">';
       echo'</div>';

      echo'<div class="row"  style="margin-top:5px;">';      
      $ruser='';
    if(!isset($_SESSION['registered_user']) || $_SESSION['registered_user'] =="")
    {
      $ruser="cart_".$this->id;
    }
    else
    {
      $ruser=$_SESSION['registered_user']."_".$this->id;
    }
     echo "<button class='btn btn-success col-xs-offset-1 col-xs-10' style='margin-left:50px;'
      onclick=createCookie('".$ruser."','".$this->id."')>Добавить в корзину</button>";     
     echo'</div>';     

      echo'</div>';           
    } 
 function itemInfo(){
echo '<h1>ОПИСАНИЕ ТОВАРА</h1>';
echo '<table class="table table-dark">
    <thead>
    <tr>
    <th>Название товара</th>    
    <th>Цена товара</th>
    <th>Рейтинг</th>
    <th>Описание</th>    
    </tr>
    </thead>
    <tbody>';
 echo '<tr>';
 echo '<td>'.$this->itemName.'</td>';
 echo '<td>'.$this->priceSale.'</td>';
 echo '<td>'.$this->rate.'</td>';
 echo '<td>'.$this->info.'</td>'; 
 echo '</tr>'; 
 echo '</tbody></table>';
 }
    function DrawForCard()
    {        
    echo "<div class='row' style='margin:5px;'>";

    echo "<img src='".$this->imagepath."' width='50px' 
      class='col-sm-1 col-md-1 col-lg-1'/>";

    echo "<span style='margin-right:10px;background-color:#ddeeaa; color:blue;font-size:16pt; font-weight:bold;' class='col-sm-2 col-md-2 col-lg-2'>";
    echo $this->itemName;
    echo "</span>";

    echo "<span style='margin-left:10px;color:red;font-size:16pt; background-color:#ddeeaa;' class='col-sm-2 col-md-2 col-lg-2' >";
    echo "$&nbsp;".$this->priceSale;
    echo "</span>";
    $ruser='';
    if(!isset($_SESSION['registered_user']) || $_SESSION['registered_user'] =="")
    {
      $ruser="cart_".$this->id;
    }
    else
    {
      $ruser=$_SESSION['registered_user']."_".$this->id;
    }
    echo "<button class='btn btn-sm btn-danger'
      style='margin-left:10px;' onclick=deleteCookie('".$ruser."')>x</button>";
        
    echo "</div>";
     
    }

    function Sale()
    {
     try{
         $pdo=Tools::connect();
         $ruser='cart';
          if(isset($_SESSION['registered_user']) || $_SESSION['registered_user'] !="")
         {
        $ruser=$_SESSION['registered_user'];
         }
      $upd='UPDATE customers SET total=total+? WHERE login=?';
      $ps=$pdo->prepare($upd);
      $ps->execute(array($this->priceSale,$ruser));
      $ins='INSERT INTO sales(customerName, itemName,priceIn,priceSale,dateSale) values(?,?,?,?,?)';
      $ps=$pdo->prepare($ins);
      $ps->execute(array($ruser, $this->itemName, $this->priceIn, $this->priceSale, @date("Y/m/d H:i:s")));
      $del='DELETE FROM items WHERE id=?';
      $ps=$pdo->prepare($del);
      $ps->execute(array($this->id));
      }
      catch(PDOException $e)
      {
       $err=$e->getMessage();
        return false; 
      }
    }

 }
?>

<style type="text/css">
  img{
    height:100px;
     }

  p{
    background-color:lightblue;
    font-weight: bold;   
    padding-left:10px;
    height: 30px;
    width:250px;
  }
  table {
  margin:3%;
font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
font-size: 14px;
border-radius: 10px;
border-spacing: 0;
text-align: center;
}
th {
background: #BCEBDD;
color: white;
text-shadow: 0 1px 1px #2D2020;
padding: 10px 20px;
}
th, td {
border-style: solid;
border-width: 0 1px 1px 0;
border-color: white;
}
th:first-child, td:first-child {
text-align: left;
}
th:first-child {
border-top-left-radius: 10px;
}
th:last-child {
border-top-right-radius: 10px;
border-right: none;
}
td {
padding: 10px 20px;
background: #F8E391;
}
tr:last-child td:first-child {
border-radius: 0 0 0 10px;
}
tr:last-child td:last-child {
border-radius: 0 0 10px 0;
}
tr td:last-child {
border-right: none;
}
h1{
  margin-left:10%;
}
  </style>

 

