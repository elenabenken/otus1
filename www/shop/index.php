<?php

include ('model/class_Users.php');
include ('model/class_Goods.php');
$good_obj = new Goods();
$user_obj = new Users();
$method = $_SERVER['REQUEST_METHOD'];

$URI = explode('/', $_SERVER['REQUEST_URI']);
// echo $URI[1], $URI[2];
 // $URI[1]  содержит строку, которая идет после первого слеша, это будет имя таблицы
// $URI[2] содержит строку после второго слеша, там имя метода
if($URI[1] !== "users" && $URI[1] !== "goods") {
	echo "Укажите имя таблицы: users или goods";
	exit;
}
$params = explode("?", $URI[2]); // $params[0] содержит имя метода $params[1] - все параметры
// print_r($params);
// print_r($_POST);
if($params[0]!== "login" && $params[0] !== "logout" && $params[0] !== "register" && $params[0] !== "list" && $params[0] !== "delete" && $params[0] !== "insert" && $params[0] !== "update") {
	echo "Укажите имя метода: login, logout, register, list, delete, insert, update";
	exit;
}

$newp = explode("&", $params[1]);
$rr = [];
foreach ($newp as $param) {
$p = explode("=",$param);
 $rr[$p[0]]= $p[1];
}
// $rr - это ассоциативный массив параметров

if(count($params) <2 ) {
	if($URI[2] != "list" && !$_POST) {		
		echo "Ну хоть какие-нибудь параметры укажите!";
		exit;
	}
}

if($URI[1]=="goods" && $params[0]=="insert") {
	$otvet = $good_obj->insert_good ($_POST['name'], $_POST['price'], $_POST['category']);
	echo $otvet;
}
	
if($URI[1]=="goods" && $params[0]=="delete") {
	$otvet = $good_obj->delete_good ($_POST['name']);
	echo $otvet;
}

if($URI[1]=="goods" && $params[0]=="update") { 
	$otvet = $good_obj->update_good ($_POST['name'], $_POST['price'], $_POST['category']);
	echo $otvet;
}

if(isset($URI[1])  && $URI[2]){
	//Вывод списка товаров. Таблица - goods, метод -  list 
if($URI[1]=="goods" && $URI[2]=="list") {	
	$otvet = $good_obj->list_goods();
	print_r(json_encode($otvet));
			
}
}
if($URI[1]=="users" && $params[0]=="login") {
	$otvet = $user_obj->login_record($_POST['name'], $_POST['password']);
	echo $otvet;
	
}
if($URI[1]=="users" && $params[0]=="register") {
	$otvet = $user_obj->insert_record($_POST['name'], $_POST['password'], $_POST['email']);
	echo $otvet;
}
	
if($URI[1]=="users" && $params[0]=="logout") {
	if($_POST['name']!== "") {
		$otvet = $user_obj->logout_record($_POST['name']);
		echo $otvet;
	}
	else { echo "Для выхода из системы надо указать имя пользователя";}
}
if($URI[1]=="migration" && $params[0]=="make") {
	$otvet = $user_obj->logout_record($_POST['name']);
	echo $otvet;
}
	