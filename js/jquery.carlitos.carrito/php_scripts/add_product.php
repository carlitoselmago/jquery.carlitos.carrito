<?php
if($_POST['modxCMS']=='true'){
	require_once ($_SERVER["DOCUMENT_ROOT"] . '/manager/includes/config.inc.php');$_SERVER["DOCUMENT_ROOT"] . 
	startCMSSession();
} else {
	session_start();
}

if (isset($_POST['productOptions'])){
	$productOptions=$_POST['productOptions'];
	$new_product=array('id'=>$_POST['productId'],'price'=>$_POST['productPrice'],'options'=>$productOptions);
} else {
	$new_product=array('id'=>$_POST['productId'],'price'=>$_POST['productPrice']);
}

if (isset($_SESSION['carlitosCarrito'])) {
	array_push($_SESSION['carlitosCarrito'], $new_product);
} else {
	$_SESSION['carlitosCarrito']=array();
	array_push($_SESSION['carlitosCarrito'], $new_product);
}

$updating_text ="...";

echo $updating_text;
?>