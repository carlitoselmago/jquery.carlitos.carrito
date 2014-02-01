<?php
// if($_POST['modxCMS']){
	// require_once ($_SERVER["DOCUMENT_ROOT"] . '/manager/includes/config.inc.php');$_SERVER["DOCUMENT_ROOT"] . 
	// startCMSSession();
// } else {
	// session_start();
// }


if (isset($_SESSION['carlitosCarrito'])){
	
} else {
	
}

$PRINT='
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="payPalForm">';

//LET'S CREATE THE LIST OF PRODUCTS

//COMMON CONFIG
$PRINT.='<input type="hidden" name="charset" value="utf-8"> 
<input type="hidden" name="upload" value="1">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="business" value="'.$paypal_data["paypal_account"].'">
<input type="hidden" name="return" value="'.$paypal_data["return_page"].'">
<input type="hidden" name="currency_code" value="'.$paypal_data["currency"].'">
';
$PRINT.='<input type="hidden" name="item_number_1" value="1">
<input name="amount_1" type="hidden" id="amount_1"  value="'.$precio_envio.'">
<input name="item_name_1" type="hidden" id="item_name_1"  value="Gastos de envío ('.$paypal_data["destino"].')">';

$x=1;
foreach($_SESSION['carlitosCarrito'] as $key => $value){
	
	$x++;
	$nombre_producto=$modx->runSnippet("getField", array('docid'=>$value['id'],'field' =>'pagetitle'));
	
	
    if($value['options']['is_digital']=="true"){
		$precio_item=$modx->runSnippet("getField", array('docid'=>$value['id'],'field' =>'precio_digital'));
		$nombre_producto+=" (versión digital)";
    } else {
        $precio_item=$modx->runSnippet("getField", array('docid'=>$value['id'],'field' =>'precio_impreso'));
    }
	
	if ($descuento!=''){
		$precio_item =($descuento * $precio_item)/100;
	}
	
	$PRINT.='<input type="hidden" name="item_number_'.$x.'" value="'.$x.'">
	<input name="amount_'.$x.'" type="hidden" id="amount_'.$x.'"  value="'.$precio_item.'">
	<input name="item_name_'.$x.'" type="hidden" id="item_name_'.$x.'"  value="'.$nombre_producto.'">';
	
	
}

//$PRINT.='<input type="submit" name="Submit" >
$PRINT.='<input type="submit" class="boton_carrito" value="Continuar">';
$PRINT.='</form>
';

echo $PRINT;
?>