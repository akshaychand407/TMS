var QuickSearch = function () {

    var Contractor = function(baseurl,App,url='') {

        //
        //console.log('contactor',baseurl);
        var contractors = new Bloodhound({
            datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '',
            limit: 1000,
            remote: {
              url: baseurl+'/contractor/GetList?qry=%QUERY',
              wildcard: '%QUERY',
              filter: function(list) {
                        return $.map(list, function(contractor) { return { name: contractor.name , id : contractor.id}; });
                    }
            }
        });
        contractors.initialize();
        $('#contractor_list_global').typeahead(null, {
            name: 'contractors',
            display: 'name',
            source: contractors.ttAdapter()
        });
		
      
        $('#contractor_list_global').on('typeahead:selected', function (e, datum) {   
            //AJAX CALL TO STORE SELECTED CONTRACTOR ID INTO SESSION
            //selectedContractor(datum.id,baseurl,App,true);
            $('#popuup_div').hide();
            if(url == 'contractor/personalinfo'){

                var dataObj = {'ContractorId' : datum.id,'sts':1};
                showContractDetails(e,dataObj,1);                                             
            }else{
                $('#CONTRACTORID').val(datum.id);alert(CONTRACTORID);
                OnTabSubmitForm(url);
                alert(CONTRACTORID);
            } 
            
        });

        $('#contractor_list_global').on('typeahead:Mouseover', function (e, datum) {   
            if(url == 'contractor/personalinfo'){
                var dataObj = {'ContractorId' : datum.id};
                showContractDetails(e,dataObj);
            }
        });
		

    }

    var selectedContractor = function(contractorId,baseurl,App,reLoad) { 
	
	      if(reLoad)        
		        App.initblockUI();
	
        $.ajax({
            url:        baseurl+'/contractor/SelectContractor',
            type:       'POST',
            //dataType:   'json',
            async:      true,
            data: { id: contractorId},
            success: function(data, status){			
                //$('#contractor_list_global').val(data);				    	
				if(reLoad){
					location.reload();
				}			
            },
            error : function(xhr, textStatus, errorThrown) {
                if (xhr.status === 0) {
                    alert('Not connected. Verify Network.');
                } else if (xhr.status == 404) {
                    alert('Requested page not found. [404]');
                } else if (xhr.status == 500) {
                    alert('Server Error [500].');
                } else if (errorThrown === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (errorThrown === 'timeout') {
                    alert('Time out error.');
                } else if (errorThrown === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('Remote sever unavailable. Please try later');
                }
            }
        });    
    }
     var ContractorSimple = function(baseurl,prm='') {
        var contractors = new Bloodhound({
    			datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
    			queryTokenizer: Bloodhound.tokenizers.whitespace,
    			prefetch: '',
    			limit: 1000,
    			remote: {
    				url: baseurl+'/contractor/GetList?qry=%QUERY',
    				wildcard: '%QUERY',
    				filter: function(list) {
                	   	return $.map(list, function(contractor) { return { name: contractor.name , id : contractor.id}; });
                	}
    			}
    		});
    
    		contractors.initialize();
    			
    		$('#contractor_list').typeahead(null, {
    			name: 'contractors',
    			display: 'name',
    			source: contractors.ttAdapter()
    		});
    
    		$('#contractor_list').on('typeahead:selected', function (e, datum) {   
    			//alert(datum.id);
    			$('#contractor_list_error').html('');
    			$('#contractor_list_error').hide();
            if(prm == 'DMS'){
                QuickFindSelectContractor(datum.id);
            }else if(prm == 'referer'){
                $('#hiddenRefererId').val(datum.id);
                $('#refererName').html(datum.name);

            }else if(prm == 'referered'){
                $('#hiddenRefereredId').val(datum.id);
            }else{
                $('#ContractorId').val(datum.id);
            }
        });
       
    } 

    var contractorReferered = function(baseurl,prm='') {
        var contractors = new Bloodhound({
                datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: '',
                limit: 1000,
                remote: {
                    url: baseurl+'/contractor/GetListRefer?qry=%QUERY',
                    wildcard: '%QUERY',
                    filter: function(list) {
                        return $.map(list, function(contractor) { return { name: contractor.name , id : contractor.id}; });
                    }
                }
            });
    
            contractors.initialize();
                
            $('#contractorReferered').typeahead(null, {
                name: 'contractors',
                display: 'name',
                source: contractors.ttAdapter()
            });
    
            $('#contractorReferered').on('typeahead:selected', function (e, datum) {   
                //alert(datum.id);
                $('#contractor_list_error').html('');
                $('#contractor_list_error').hide();
            if(prm == 'DMS'){
                QuickFindSelectContractor(datum.id);
            }else if(prm == 'referer'){
                $('#hiddenRefererId').val(datum.id);
            }else if(prm == 'referered'){
                $('#hiddenRefereredId').val(datum.id);
                $('#newcontractorName').html(datum.name);
            }else{
                $('#ContractorId').val(datum.id);
            }
        });
       
    }


    var contractorReferer = function(baseurl,prm='') {
        var contractors = new Bloodhound({
                datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: '',
                limit: 1000,
                remote: {
                    url: baseurl+'/contractor/GetListRefer?qry=%QUERY',
                    wildcard: '%QUERY',
                    filter: function(list) {
                        return $.map(list, function(contractor) { return { name: contractor.name , id : contractor.id}; });
                    }
                }
            });
    
            contractors.initialize();
                
            $('#contractor_list').typeahead(null, {
                name: 'contractors',
                display: 'name',
                source: contractors.ttAdapter()
            });
    
            $('#contractor_list').on('typeahead:selected', function (e, datum) {   
                //alert(datum.id);
                $('#contractor_list_error').html('');
                $('#contractor_list_error').hide();
            if(prm == 'DMS'){
                QuickFindSelectContractor(datum.id);
            }else if(prm == 'referer'){
                $('#hiddenRefererId').val(datum.id);
                $('#refererName').html(datum.name);
            }else if(prm == 'referered'){
                $('#hiddenRefererId').val(datum.id);
                $('#refererName').html(datum.name);
            }else{
                $('#ContractorId').val(datum.id);
            }
        });
       
    } 
    var Company = function(baseurl,prm='') {
        var companies = new Bloodhound({
    			datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
    			queryTokenizer: Bloodhound.tokenizers.whitespace,
    			prefetch: '',
    			limit: 1000,
    			remote: {
    				url: baseurl+'company/GetList?qry=%QUERY',
    				wildcard: '%QUERY',
    				filter: function(list) {
                	   	return $.map(list, function(company) { return { name: company.name , id : company.id}; });
                	}
    			}
    		});
    
    		companies.initialize();
    			
    		$('#company_list').typeahead(null, {
    			name: 'companies',
    			display: 'name',
    			source: companies.ttAdapter()
    		});
    
    		$('#company_list').on('typeahead:selected', function (e, datum) {   
    			//alert(datum.id);
    			$('#company_list_error').html('');
    			$('#company_list_error').hide();
          if(prm == 'DMS')
            $('#dmsCompanyId').val(datum.id);
          else
    			$('#CompanyId').val(datum.id);
        });
    }   
    var ClientCompany = function(baseurl) { 
        var clientcompanies = new Bloodhound({
    			datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
    			queryTokenizer: Bloodhound.tokenizers.whitespace,
    			prefetch: '',
    			limit: 1000,
    			remote: {
    				url: baseurl+'company/EndClientGetList?qry=%QUERY',
    				wildcard: '%QUERY',
    				filter: function(list) { 
                	   	return $.map(list, function(clientcompany) { return { name: clientcompany.name , id : clientcompany.id}; });
                	}
    			}
    		});
    
    		clientcompanies.initialize();
    			
    		$('#client_company_list').typeahead(null, {
    			name: 'clientcompanies',
    			display: 'name',
    			source: clientcompanies.ttAdapter()
    		});
    
    		$('#client_company_list').on('typeahead:selected', function (e, datum) {   
    			//alert(datum.id);
    			$('#client_company_list_error').html('');
    			$('#client_company_list_error').hide();
    			$('#ClientCompanyId').val(datum.id);
        });
    }  
     var Agency = function(type,baseurl,App,prm='') {
          var agencies = new Bloodhound({
      			datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
      			queryTokenizer: Bloodhound.tokenizers.whitespace,
      			prefetch: '',
      			limit: 1000,
      			remote: {
      				url: baseurl+'agent/GetList?qry=%QUERY',
      				wildcard: '%QUERY',
      				filter: function(list) {
                  	   	return $.map(list, function(agency) { return { name: agency.name , id : agency.id}; });
                  	}
      			}
      		});      
      		agencies.initialize();      			
      		$('#agency_list').typeahead(null, {
      			name: 'agencies',
      			display: 'name',
      			source: agencies.ttAdapter()
      		});
      		
      		$('#agency_list').on('typeahead:selected', function (e, datum) {   

      			$('#agency_list_error').html('');
      			$('#agency_list_error').hide();
             if(prm == 'DMS')
              $('#dmsAgentId').val(datum.id);
            else {
      			$('#ContractAgency').val(datum.id);
             App.initblockUI(); 
            }

      			if(type == 'contract'){
                	getAgentContacts(datum.id,0,baseurl,App,'ContractAgentContactId');
                    getAgentContacts(datum.id,0,baseurl,App,'AgentPayrollContactId');
                }
                if(type == 'agentContactSummary'){
                    $('#AgentId').val(datum.id);
                    $('#AgentName').val(datum.name);
                    OnTabSubmitForm('agent/contactSummary')
                }
          });
    }
    var AgencyModal =  function(type,baseurl,App) {

        var agencies = new Bloodhound({
                datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: '',
                limit: 1000,
                remote: {
                    url: baseurl+'agent/GetList?qry=%QUERY',
                    wildcard: '%QUERY',
                    filter: function(list) {
                        return $.map(list, function(agency) { return { name: agency.name , id : agency.id}; });
                    }
                }
            });      
            agencies.initialize();                  
            $('#agency_list_modal').typeahead(null, {
                name: 'agencies',
                display: 'name',
                source: agencies.ttAdapter()
            });
            
            $('#agency_list_modal').on('typeahead:selected', function (e, datum) {   
                $('#AgentId').val(datum.id);
            });
    }
    var getAgentContacts = function(agentId,agentContactId,baseurl,App,fieldId) { 
        
    	$.ajax({

            url:        baseurl+'/contract/getAgentContract',
            type:       'POST',
            //dataType:   'json',
            async:      true,
            data: { agentId: agentId,fieldId: fieldId},
            success: function(data, status){
                $('#'+fieldId+'_div').html(data);
                $('#'+fieldId).val(agentContactId);
		
                App.initunblockUI();
            },
            error : function(xhr, textStatus, errorThrown) {
                App.initunblockUI();
                if (xhr.status === 0) {
                    alert('Not connected. Verify Network.');
                } else if (xhr.status == 404) {
                    alert('Requested page not found. [404]');
                } else if (xhr.status == 500) {
                    alert('Server Error [500].');
                } else if (errorThrown === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (errorThrown === 'timeout') {
                    alert('Time out error.');
                } else if (errorThrown === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('Remote sever unavailable. Please try later');
                }
            }
        });

    }



     var queryContractor = function(baseurl,inputId,setIdToInput) {
        var contractorsSuggestion = new Bloodhound({
                datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: '',
                limit: 1000,
                remote: {
                    url: baseurl+'/contractor/GetList?qry=%QUERY',
                    wildcard: '%QUERY',
                    filter: function(list) {
                        return $.map(list, function(contractor) { return { name: contractor.name , id : contractor.id}; });
                    }
                }
            });
    
            contractorsSuggestion.initialize();
                
           $(inputId).typeahead(null, {
                name: 'contractors',
                display: 'name',
                source: contractorsSuggestion.ttAdapter()
            });
    
          $(inputId).on('typeahead:selected', function (e, datum) {  
           
               $(inputId).val(datum.name);
               $(setIdToInput).val(datum.id);
        });
       
    } 
          
    return {
        //main function to initiate the module
        initContractor: function (baseurl,App,url='contractor/personalinfo') {
            Contractor(baseurl,App,url);
        },
        initSimpleContractor: function (baseurl,prm = '') {
            ContractorSimple(baseurl,prm);
        },
        initcontractorReferered: function (baseurl,prm = '') {
            contractorReferered(baseurl,prm);
        },
        initcontractorReferer: function (baseurl,prm = '') {
            contractorReferer(baseurl,prm);
        },
        initCompany: function (baseurl,prm = '') {
            Company(baseurl,prm);
        },
	      initClientCompany: function (baseurl) {
            ClientCompany(baseurl);
        },
         initAgency: function (type,baseurl,App,prm = '') {
            Agency(type,baseurl,App,prm);
        },
        initAgencyModal : function (type,baseurl,App) {
            AgencyModal(type,baseurl,App);
        },
        initSetAgentContacts: function (agentId,agentContactId,baseurl,App,fieldId) { 
            getAgentContacts(agentId,agentContactId,baseurl,App,fieldId);
        }, 
		initSelectedContractor: function (contractorId,baseurl,App,reLoad) {
            selectedContractor(contractorId,baseurl,App,reLoad);
        } ,
        queryContractorInfo: function (baseurl,inputId,setIdToInput) {
            queryContractor(baseurl,inputId,setIdToInput);
        } 

    };
}();
