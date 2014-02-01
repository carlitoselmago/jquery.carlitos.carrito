<?php
if($_POST['modxCMS']=='true'){
	require_once ($_SERVER["DOCUMENT_ROOT"] . '/manager/includes/config.inc.php');$_SERVER["DOCUMENT_ROOT"] . 
	startCMSSession();
} else {
	session_start();
}


if (isset($_SESSION['carlitosCarrito'])){
	$productCount = count($_SESSION['carlitosCarrito']);
} else {
	$productCount= 0;
}

echo $productCount;

?>