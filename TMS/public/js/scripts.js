function checksavemode(mode){
	if(document.getElementById('submitButton')){
		//alert($('#submitButton').attr('disabled'));
		if (!$('#submitButton').attr('disabled') && mode == '' ) {
		    alert ('Changes have been made! Please hit Save or Cancel button to proceed.');
		    return false;
		}else{
			App.initblockUI();
			return true;
		}
	}else{
		App.initblockUI();
		return true;
	}
  	
}