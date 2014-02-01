(function($){
return $.fn.carlitosCarrito = function(options) { 
	
	//DEFAULT EVENT CALLBACKS
	var DefaultonaddtoCartClick =function(){
		console.log("Product add launched");
	}
	var DefaultonaddtoCartSucces =function(){
		console.log("Product added to cart succesfully");
	}
	var DefaultonUpdateCartLaunch =function(){
		console.log("Update cart launched");
	}
	var DefaultonUpdateCartSuccess =function(){
		console.log("Cart Updated succesfully");
	}
	var DefaultonremoveFromCartLaunch =function(){
		console.log("Product remove launched");
	}
	var DefaultonremoveFromCartsuccess =function(){
		console.log("Product removed from card succesfully");
	}
	var DefaultonlistProductsLaunch =function(){
		console.log("Product list launched");
	}
	
	// set up default options 
	var defaults = {
	
		phpscriptsRelativeFolder: 'js/carlitos.carrito/php_scripts/',
		addtoCartSelector: '.addtoCart',
		removefromCartSelector: '.remove',
		cartCounterSelector: '#totalAmount',
		splitSimbol: ',',
		currencySymbol: '&euro;',
		listProductsClickSelector: '#listCart',
		listProductsLoadSelector: '#CartList',
		
		onaddtoCartClick:  DefaultonaddtoCartClick,
		onaddtoCartSucces: DefaultonaddtoCartSucces,
		onUpdateCartLaunch: DefaultonUpdateCartLaunch,
		onUpdateCartSuccess: DefaultonUpdateCartSuccess,
		onremoveFromCartLaunch: DefaultonremoveFromCartLaunch,
		onremoveFromCartsuccess: DefaultonremoveFromCartsuccess,
		onlistProductsLaunch: DefaultonlistProductsLaunch,
		
		modxCMS:false //MODX evo integration support switch to true to store the items in the MODX session
	}; 

	// Overwrite default options 
	// with user provided ones 
	// and merge them into "options". 
	var options = $.extend({}, defaults, options); 

	//INITIAL ACTIONS
	if ($(options.cartCounterSelector)){
		updateCarlitosCarrito();
	}
	
	//ADD TO CART
	$(options.addtoCartSelector).click(function(e) {
		var productId=$(this).attr('productId');
		var productPrice=$(this).attr('productPrice');
		
		options.onaddtoCartClick.call();
		
		if ($(this).attr('productOptions')){
			var productOptionlabels = explodeArray($(this).attr('productOptionlabels'),options.splitSimbol); 
			var productOptions = explodeArray($(this).attr('productOptions'),options.splitSimbol); 
			var prodductOptionsObject=combineObject(productOptionlabels, productOptions);
		}
		
		//We launch the add_product php script and store the item in the session var carlitosCarrito
		$(options.cartCounterSelector).load(options.phpscriptsRelativeFolder+'add_product.php', {'productId': productId,'productPrice':productPrice, 'productOptions': prodductOptionsObject, 'modxCMS': options.modxCMS }, function() {
			options.onaddtoCartSucces.call();
			updateCarlitosCarrito();
		});
		
	});
	
	//REMOVE FROM CART
	$(options.removefromCartSelector).click(function(e) {
	
		var productId=$(this).attr('productId');
		
		options.onremoveFromCartLaunch.call();
		
		if ($(this).attr('productOptions')){
			var productOptionlabels = explodeArray($(this).attr('productOptionlabels'),options.splitSimbol); 
			var productOptions = explodeArray($(this).attr('productOptions'),options.splitSimbol); 
			var prodductOptionsObject=combineObject(productOptionlabels, productOptions);
		}
		
		//We launch the remove_product php script and if Options are set just the ones who match the criteria will be deleted
		$(options.cartCounterSelector).load(options.phpscriptsRelativeFolder+'remove_product.php', {'productId': productId, 'productOptions': prodductOptionsObject, 'modxCMS': options.modxCMS }, function() {
			options.onremoveFromCartsuccess.call();
			updateCarlitosCarrito();
		});
		
	});
	
	//LIST CART
	$(options.listProductsClickSelector).click(function(e) {
		options.onlistProductsLaunch.call();
		$(options.listProductsLoadSelector).load(options.phpscriptsRelativeFolder+'list_products.php',{'currencySymbol':options.currencySymbol, 'removefromCartSelector':options.removefromCartSelector} ,function(){
			
		});
	
	});

	return this.each(function() { 
		/* Now you can use 
		 "options.colWidth", etc. */ 
	});
	

	
	//FUNCTIONS

	function updateCarlitosCarrito(){
		options.onUpdateCartLaunch.call();
		$(options.cartCounterSelector).load(options.phpscriptsRelativeFolder+'count_products.php',{'modxCMS': options.modxCMS}, function() {
			//DONE
			options.onUpdateCartSuccess.call();
		});
	}
  
	function explodeArray(item,delimiter) { 
		tempArray=new Array(1); 
		var Count=0; 
		var tempString=new String(item);

		while (tempString.indexOf(delimiter)>0) { 
			tempArray[Count]=tempString.substr(0,tempString.indexOf(delimiter)); 
			tempString=tempString.substr(tempString.indexOf(delimiter)+1,tempString.length-tempString.indexOf(delimiter)+1); 
			Count=Count+1 
		}

		tempArray[Count]=tempString; 
		return tempArray; 
	}
	
	function combineObject( keys, values) {
		var obj = {};
		if ( keys.length != values.length)
		   return null;
		for (var index in keys)
			obj[keys[index]] = values[index];
		 return obj;
	}
  };
})(jQuery);