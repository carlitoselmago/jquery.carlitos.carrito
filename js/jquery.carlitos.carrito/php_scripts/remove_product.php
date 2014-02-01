<?php
if($_POST['modxCMS']){
	require_once ($_SERVER["DOCUMENT_ROOT"] . '/manager/includes/config.inc.php');$_SERVER["DOCUMENT_ROOT"] . 
	startCMSSession();
} else {
	session_start();
}

$id_to_delete=$_POST['productId'];
$productOptions=$_POST['productOptions'];
$deletefound=false;

foreach ($_SESSION['carlitosCarrito'] as $key => $value){

	if ($value['id']==$id_to_delete){
		
		if ($value['options']==$productOptions){
			//SI COINCIDE LAS OPCIONES DE PRODUCTO BORRAMOS ITEM DE CARRITO
			if (!$deletefound){
				$deleteKey=$key;
				$deletefound=true;
			}
		} else {
			
		}
		
		
	
	}

}

//DELETE IF CRITERIA MATCHES
unset($_SESSION['carlitosCarrito'][$deleteKey]);
$updating_text ="...";

echo $updating_text;

?>