// page Desvription <All client sid validation are wriiten here.>
//  *  Last modified by Nithin on 14/11/2019
// Tested by Nithin on 23/07/2019

$(document).ready(function(){ 
	// Place ID's of all required fields here.
	//required = ["ExpenseKMS","ExpenseDate","ExpenseType","ExpenseAmount","ExpenseEngineSize","SubsistenceExpenseSubsistence"];
	// required1 = ["password"];
	// required2 = ["name","email","dob","place","bloodgroup","state","dist"];
	// If using an ID other than #email or #error then replace it here
	verification = $("#captcha");
	captchaerror = "Enter Code.";
	phone 		 = $("#phone");
	email 		 = $("#email");
	uname 		 = $("#uname");
	errornotice  = $("#error");
	
	// The text to show up within a field when it is incorrect
	emptyerror = "Please fill out this field.";
	numerror   = "Please enter a valid number.";
	emailerror = "Please enter a valid e-mail.";

	// Clears any fields in the form when the user clicks on them
	$(":input").focus(function(){		
	   if ($(this).hasClass("error") ) {
			//$(this).val("");
			$(this).removeClass("error");
			$(this).removeAttr("placeholder");
	   }
	});
	//App.initblockUI();
});	

/********** Vatt Rate Form Validation ********/
function validateFileds(nextForm){	

	$('input').removeClass('error');
	$('select').removeClass('error');
	//Validate required fields
	required = '';

	if(nextForm == 3){ 
 		required 		= ["ContractorFirstName","ContractorLastName","ContractorEmail","ContractorDOB"];
 		requiredemail 	= ["ContractorEmail"];
 	}else if(nextForm == 4){
 		required = ["ContractorAddress1","ContractorCountry"];
 	}else if(nextForm == 5){
 		required = ["ContractorMaritual","ContractorPhone"];
 	}else if(nextForm == 6){
 		required = ["ContractorSocialWelfare"];
 	}else if(nextForm == 7){
 		required = ["ContractorBankType"];
 		if ($("#ContractorBankUnavailable").val() == 0) {
 			required.push("ContractorBankIBAN","ContractorBankBIC","ContractorPreviousBank");
 		}else{
 			$("#ContractorBankIBAN").removeClass("error");
 			$("#ContractorBankBIC").removeClass("error");
 			$("#ContractorPreviousBank").removeClass("error");
 			$("#ContractorBankIBAN").attr("placeholder", "");
 			$("#ContractorBankBIC").attr("placeholder", "");
 			$("#ContractorPreviousBank").attr("placeholder", "");
 		}
 	}else if(nextForm == 8){
 		required = ["ContractorSector","ContractorJobTitle","ContractorProject","ContractorWorkingCompany"];
 	}else if(nextForm == 9){
 		required = ["ContractorProjectLength","ContractorPreviousRate","ContractorPreviousRateType"];
 	}else if(nextForm == 10){
 		//required 		= ["ContractorRecruitAgency","ContractorRecruitAgencyEmail"]; 
 		//requiredemail 	= ["ContractorRecruitAgencyEmail"];		
 		
 		required 		= ["ContractorRecruitAgency"]; 	//MEN-639
 	}else if(nextForm == 11){
 		required = ["ContractorCompanyType","ContractorReturningStatus"];
 	}else if(nextForm == 12){
 		required = ["ContractorSwitchingStatus","ContractorHearAbout"];
 		if($("#ContractorSwitchingStatus").val() == 1){
 			required.push("ContractorPreviousSolution");
 		} 
 		if($("#ContractorHearAbout").val() == 'Recommendation from Friend Colleague'){
 			required.push("ContractorReferredFriend");
 		} 		
 	}

 	

	for (i=0;i<required.length;i++) {
		var input = $('#'+required[i]);
		if ((input.val() == "") || (input.val() == emptyerror)) {
			input.addClass("error");
			input.attr("placeholder", emptyerror);
		} else {
			input.removeClass("error");

		}
	}		

	// Validate the e-mail.
	var eflag 	= 0;	
	for (i=0;i<requiredemail.length;i++) {
		var email = $('#'+requiredemail[i]);
		if (!/^([a-zA-Z0-9_\.\'\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email.val()) && email.val()!= '') {
			email.addClass("error");
			eflag = 1;
			email.attr("placeholder", emailerror);
		}
	}
	if(eflag > 0){
		toastr.error("Not a valid email", 'Error');
	}
	//if any inputs on the page have the class 'error' the form will not submit
	if ($(":input").hasClass("error")) {
		return false;
	} else {
		
		errornotice.hide();
		//App.In
		return true;
	}
}
