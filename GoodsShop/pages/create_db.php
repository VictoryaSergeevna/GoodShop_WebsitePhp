<?php
include_once('classes.php');
$pdo=Tools::connect();
$ct1='create table categories(
id int not null auto_increment primary key,
categoryName varchar(64) unique
)default charset="utf8"';

$ct2='create table sales(
id int not null auto_increment primary key,
customerName varchar(64),
itemName varchar(64),
priceIn double,
priceSale double,
dateSale date
)default charset="utf8"';

$ct3='create table items(
id int not null auto_increment primary key,
itemName varchar(64),
categoryId int,
foreign key(categoryId) references categories(id)
on delete cascade, 
priceIn double,
priceSale double,
info varchar(1024),
rate int,
imagepath varchar(128),
action int
)default charset="utf8"';

$ct4='create table images(
id int not null auto_increment primary key,
itemId int,
foreign key(itemId) references items(id)
on delete cascade, 
imagepath varchar(128)
)default charset="utf8"';

$ct5='create table roles(
id int not null auto_increment primary key,
role varchar(128)
)default charset="utf8"';

$ct6='create table customers(
id int not null auto_increment primary key,
login varchar(128) unique,
pass varchar(128) not null,
roleId int,
foreign key(roleId) references roles(id)
on delete cascade,
discount double,
total double,
imagepath varchar(128)
)default charset="utf8"';

$ct7='create table carts(
id int not null auto_increment primary key,
customerId int,
foreign key(customerId) references customers(id)
on delete cascade,
itemId int,
foreign key(itemId) references items(id)
on delete cascade,
price double
)default charset="utf8"';

$ct8='create table orders(
id int not null auto_increment primary key,
customerId int,
foreign key(customerId) references customers(id)
on delete cascade,
itemId int,
foreign key(itemId) references items(id)
on delete cascade,
dataIn date,
orderName varchar(128),
price double
)default charset="utf8"';

/*$ps1=$pdo->query($ct1);
$err=$pdo->errorCode();
if($err){
	echo 'Error code 1:' .$err.'<br>';
	exit();
}*/
/*$ps2=$pdo->query($ct2);
$err=$pdo->errorCode();
if($err){
	echo 'Error code 2:' .$err.'<br>';
	exit();
}*/
/*$ps3=$pdo->query($ct3);
$err=$pdo->errorCode();
if($err){
	echo 'Error code 3:' .$err.'<br>';
	exit();
}*/
/*$ps4=$pdo->query($ct4);
$err=$pdo->errorCode();
if($err){
	echo 'Error code 4:' .$err.'<br>';
	exit();
}*/
/*$ps5=$pdo->query($ct5);
$err=$pdo->errorCode();
if($err){
	echo 'Error code 5:' .$err.'<br>';
	exit();
}*/

/*$ps6=$pdo->query($ct6);
$err=$pdo->errorCode();
if($err){
	echo 'Error code 6:' .$err.'<br>';
	exit();
}*/
/*$ps7=$pdo->query($ct7);
$err=$pdo->errorCode();
if($err){
	echo 'Error code 7:' .$err.'<br>';
	exit();
}*/

$ps8=$pdo->query($ct8);
$err=$pdo->errorCode();
if($err){
	echo 'Error code 8:' .$err.'<br>';
	exit();
}
?>