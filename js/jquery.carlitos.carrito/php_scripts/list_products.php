<?php
if (isset($_POST['modxCMS'])){
	if($_POST['modxCMS']=='true'){
		require_once ($_SERVER["DOCUMENT_ROOT"] . '/manager/includes/config.inc.php');$_SERVER["DOCUMENT_ROOT"] . 
		startCMSSession();
	}
} else {
		session_start();
}


if (isset($_SESSION['carlitosCarrito'])){
	
	$list='';
	
	if (isset($_POST['currencySymbol'])){
		$currencySymbol=$_POST['currencySymbol'];
	} else { $currencySymbol='€';	}
	
	if (isset($_POST['removefromCartSelector'])){
		$removefromCartSelector=str_replace('.', '', $_POST['removefromCartSelector']);
		$removefromCartSelector=str_replace('#','',$removefromCartSelector);
	} 

	foreach ($_SESSION['carlitosCarrito'] as $key => $value){
		
		$list.='
			<div class="cartListProd" prodId='.$value['id'].'>
			<div class="cartListProdmainInfo">
				<div class="cartListProdName">Nombre prod</div>
				<div class="cartListProdPrice"><span class="listAmount">'.$value['price'].'</span>'.$currencySymbol.'</div>
			</div>
		';
		
		if (isset($value['options'])){
			
			$list.='<div class="listOptions">';
			
			foreach($value['options'] as $keyOpt => $valueOpt){
				
				$list.='
					<div class="ListOpt">
						<span class="label">'.$keyOpt.'</span> 
						<span class="separator"> : </span>
						<span class="value">'.$valueOpt.'</span>
					</div>
				';
				
			}
			
			$list.='</div>';
		}
		
		
		$list.='<div class="'.$removefromCartSelector.'">Remove</div>';
				
		$list.='</div>
		';
		
		//var_dump($value);
	}

	echo $list;

}


?>