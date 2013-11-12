<?php
session_start();

require_once("./util/request.php");
require_once("./util/myaiesec.php");
?>

<html>
<head>
<title>
	ADT Tool (alpha) - AIESEC in Brazil</div>
</title>
<link href="css/smoothness/jquery-ui-1.9.1.custom.css" rel="stylesheet">
<script src="js/jquery-1.8.2.js"></script>
<script src="js/jquery-ui-1.9.1.custom.js"></script>

<link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>
<body>
<script>
$(document).ready(function() {

	var from = "";
	var to= "";
	var types = "";
	
	$('#loadingIcon').hide();
	$("#tabs").tabs();
	$("#tabs").hide();

	$("#formSearch").click(function() {
		if(!$("#form").val()){
			alert("Oops.. Fill up the field before Go, dude.");
		}else{
			loadFormData($("#form").val());
		}
	});
	
	$("#formsSearch").click(function() {
		if(!$("#forms").val()){
			alert("Oops.. Fill up the field before Go, dude.");
		}else{
			loadFormData($("#forms").val());
		}
	});

	function loadFormData(forms){

		$("#tabs").hide();

		$("#loadingBox").dialog({
			title: "TNA Portal",
            modal: true,
            resizable : false,
            draggable: false
		});
		$('#loadingIcon').show();

		var type = String(forms).substring(0,2).toUpperCase();

		var amount = forms.indexOf(",") ? forms.split(",").length : 1;
		if (amount >= 20)
        	$('#status').html("Loading <b>"+amount+"</b> "+type+" form(s). Wow. Grab a coffee and wait...");
		else
			$('#status').html("Loading <b>"+amount+"</b> "+type+" form(s). Wait a bit...");
        
		//$('#result').load("getFormsDetails.php?form=" + $("#form").val());
		$.getJSON("getFormDetails.php?form=" +forms , function(data) {

			var type = String(forms).substring(0,2).toUpperCase();
			var typeName = "";
			var matchedId = "";
			var matchedName = "";
			var period = "";
			var link = "";
			if (type == "TN"){
				typeName = "Organisation name"; 
				matchedId = "EP";
				matchedName = "EP name"; 
				period = "1 third";
				link = "http://www.myaiesec.net/exchange/viewtn.do?operation=executeAction&tnId"; 
			}else {
				typeName = "EP name";
				matchedId = "TN";
				matchedName = "Organisation name";
				period = "Mid";
				link = "http://www.myaiesec.net/exchange/viewep.do?operation=executeAction&epId"; 
			}

			var table = '<table id="icxtable" cellpadding="2" cellspacing="0" border="1">'; 
			table += '<th>'+type+' Id</th>';
			table += '<th>'+typeName+'</th>';
			table += '<th>'+matchedId+' Id</th>';
			table += '<th>'+matchedName+'</th>';
			table += '<th>GIP/GCDP</th>';
			table += '<th>Status</th>';
			table += '<th>RA Date</th>';
			table += '<th>MA Date</th>';
			table += '<th>RE Date</th>';
			table += '<th>End Date</th>';

	        $.each(data, function(index, item) { /* add to html string started above*/
	        	table += '<tr><td><a href=\''+link+'='+item.formId+'\' target="_blank">'+ item.id +'<a/></td>';
	            table +='<td>' + item.name + '</td>';
	            table +='<td>' + item.formMAId + '</td>';
	            table +='<td>' + item.formMAName + '</td>';
	            table +='<td class=\'extype '+item.type+'\'>' + item.type + '</td>';
	            table +='<td class=\'extype '+item.status+'\'>' + item.status + '</td>';
	            table +='<td>' + item.dtRA + '</td>';
	            table +='<td>' + item.dtMA + '</td>';
	            table +='<td>' + item.dtRE + '</td>';
	            table +='<td>' + item.dtEND + '</td></tr>';
	        });
	        
	        table += '</table>'; /* insert the html string*/
	        $('#result').html(table);
	        $('#loadingIcon').hide();
			$('#loadingBox').dialog("close");
		});
	}
	
	$("#botMonth").click(function() {
		if (validateShowForms()){
			var arr = $.map($('input:checkbox:checked'), function(e, i) {
		        return +e.value;
		    });
   			types = arr.join(',');

   			var lastDay = new Date($("#month").val().split('.')[1], $("#month").val().split('.')[0], 0).getDate();
   			from = "01."+$("#month").val();
   			to = ""+lastDay+"."+$("#month").val();

   			loadForms();
		}
	});
		
	$("#bot").click(function() {
		if (validateShowForms()){
			var arr = $.map($('input:checkbox:checked'), function(e, i) {
		        return +e.value;
		    });
   			types = arr.join(',');

			from = $("#from").val();
			to = $("#to").val();
			
   			loadForms();
		}
	});

	function loadForms(){

		var tns = "";
		
		$("#loadingBox").dialog({
			title: "TNA Portal",
            modal: true,
            resizable : false,
            draggable: false
		});

		$('#result').text("");
		
        $('#loadingIcon').show();
        $('#status').text("Connecting to My@...");

        $.getJSON("getTNs.php?cl=" + $("#cmtId").val() +"&from="+from+"&to="+to+"&types="+types, function(data) {
			var tns = String(data);
			if(tns != ""){
				var forms = tns.indexOf(",") ? tns.split(",").length : 1;

				if (forms >= 20)
	            	$('#status').html("Loading <b>"+forms+"</b> TN form(s). Wow. Grab a coffee and wait...");
				else
					$('#status').html("Loading <b>"+forms+"</b> TN form(s). Wait a bit...");
			
				$.getJSON("getFormDetails.php?form="+data, function(data2) {
					var table = '<table cellpadding="2" cellspacing="0" border="1">'; 
					table += '<th>TN Id</th>';
					table += '<th>Organisation name</th>';
					table += '<th>EP Id</th>';
					table += '<th>EP Name</th>';
					table += '<th>GIP/GCDP</th>';
					table += '<th>Status</th>';
					table += '<th>RA Date</th>';
					table += '<th>MA Date</th>';
					table += '<th>RE Date</th>';
					table += '<th>End Date</th>';
							
			        $.each(data2, function(index, item) { /* add to html string started above*/
			        	table += '<tr><td><a href=\'http://www.myaiesec.net/exchange/viewtn.do?operation=executeAction&tnId='+item.formId+'\' target="_blank">'+ item.id +'<a/></td>';
			            table +='<td>' + item.name + '</td>';
			            table +='<td>' + item.formMAId + '</td>';
			            table +='<td>' + item.formMAName + '</td>';
			            table +='<td class=\'extype '+item.type+'\'>' + item.type + '</td>';
			            table +='<td class=\'extype '+item.status+'\'>' + item.status + '</td>';
			            table +='<td>' + item.dtRA + '</td>';
			            table +='<td>' + item.dtMA + '</td>';
			            table +='<td>' + item.dtRE + '</td>';
			            table +='<td>' + item.dtEND + '</td></tr>';
			        });
			        table += '</table>'; 
			        $("#tabs").show();
			        $("#icx").html(table);

					loadOGX();
				});
			}else{
				//$('#loadingIcon').hide();
				//$('#loadingBox').dialog("close");
				$("#icx").html("<p>No results found.</p>");
				loadOGX();
			}
		});
	}

	function loadOGX(){

		var arr = $.map($('input:checkbox:checked'), function(e, i) {
	        return +e.value;
	    });

		var types = arr.join(',');

		$.getJSON("getEPs.php?cl=" + $("#cmtId").val() +"&from="+from+"&to="+to+"&types="+types, function(data3) {
			var tns = String(data3);
			if(tns != ""){
				var forms = tns.indexOf(",") ? tns.split(",").length : 1;

				if (forms >= 20)
	            	$('#status').html("Loading <b>"+forms+"</b> EP form(s). Wow. Grab a coffee and wait...");
				else
					$('#status').html("Loading <b>"+forms+"</b> EP form(s). Wait a bit...");
			
				$.getJSON("getFormDetails.php?form="+data3, function(data4) {
					var table= '<table id="ogxtable" cellpadding="2" cellspacing="0" border="1">'; 
					table += '<th>EP Id</th>';
					table += '<th>EP Name</th>';
					table += '<th>TN Id</th>';
					table += '<th>Organisation name</th>';
					table += '<th>GIP/GCDP</th>';
					table += '<th>Status</th>';
					table += '<th>RA Date</th>';
					table += '<th>MA Date</th>';
					table += '<th>RE Date</th>';
					table += '<th>End Date</th>';
							
			        $.each(data4, function(index, item) { /* add to html string started above*/
			        	table += '<tr><td><a href=\'http://www.myaiesec.net/exchange/viewep.do?operation=executeAction&epId='+item.formId+'\' target="_blank">'+ item.id +'<a/></td>';
			            table +='<td>' + item.name + '</td>';
			            table +='<td>' + item.formMAId + '</td>';
			            table +='<td>' + item.formMAName + '</td>';
			            table +='<td class=\'extype '+item.type+'\'>' + item.type + '</td>';
			            table +='<td class=\'extype '+item.status+'\'>' + item.status + '</td>';
			            table +='<td>' + item.dtRA + '</td>';
			            table +='<td>' + item.dtMA + '</td>';
			            table +='<td>' + item.dtRE + '</td>';
			            table +='<td>' + item.dtEND + '</td></tr>';
			        });
			        $('#loadingIcon').hide();
					$('#loadingBox').dialog("close");
					table+= '</table>'; 
			        $("#tabs").show();
			        //alert(ogxtable);
			        $("#ogx").html(table);
			        //$('#result').html(table);
				});
			}else{
				$('#loadingIcon').hide();
				$('#loadingBox').dialog("close");
				$("#ogx").html("<p>No results found.</p>");
			}
		});
	}

	function validateShowForms(){
		if($("#cmtId").val() == 0){
			alert("Oops.. Select a CL and month before Go, dude!");
			return false;
		}

		//Improve validation
		if($("#from").val() == ''){
			alert("Oops.. Date from is empty or invalid, dude!");
			return false;
		}

		//Improve validation
		if($("#to").val() == ''){
			alert("Oops.. Date to is empty or invalid, dude!");
			return false;
		}

		var arr = $.map($('input:checkbox:checked'), function(e, i) {
	        return +e.value;
	    });

	    if(arr.length == 0){
	    	alert("Oops.. Select at least one status, dude!");
			return false;
	    }

	    return true;
    }
	

	$('#from').datepicker({
		dateFormat: 'dd.mm.yy'
	});

	$('#from').val('01.07.2012');
	
	$('#to').datepicker({
		dateFormat: 'dd.mm.yy'
	});

	$('#to').val('30.09.2012');

	$('#month').datepicker({
		dateFormat: 'mm.yy',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,

		onClose: function(dateText, inst) {
			var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			$(this).val($.datepicker.formatDate('mm.yy', new Date(year, month, 1)));
		}
	});
	
	$("#month").focus(function () {
		$(".ui-datepicker-calendar").hide();
		$("#ui-datepicker-div").position({
			my: "center top",
			at: "center bottom",
			of: $(this)
		});
	});

	var today = new Date();
	$('#month').val($.datepicker.formatDate('mm.yy', new Date(today.getFullYear(), today.getMonth()-1, 1)));
});
			
</script>

<div class="container">
	<div class="header">
		<img src="img/tna_logo_mini.png" />
		ADT Tool - v0.1 (alpha)
	</div>
	<div class="searchbox">
		<div class="left">
			<h4>&rsaquo;&rsaquo; Search TNs/EPs by LC and RA Date</h4>
			<label>LC: </label> <select name="cmtId" id="cmtId"
				class="">
				<option value="0">Select LC</option>
				<option value="13428806">Belo Horizonte</option>
				<option value="13428546">Brasilia</option>
				<option value="29807363">Campinas</option>
				<option value="1000000260">Chapeco</option>
				<option value="13429161">Curitiba</option>
				<option value="1000000062">ESPM</option>
				<option value="13430128">Florianopolis</option>
				<option value="1000000257">Fortaleza</option>
				<option value="1000000259">Franca</option>
				<option value="13430363">GV</option>
				<option value="1000000064">Goiania</option>
				<option value="1000000313">INSPER</option>
				<option value="13428206">ITA</option>
				<option value="1000000012">Itajuba</option>
				<option value="1000000314">Joinville</option>
				<option value="1000000254">Juiz de Fora</option>
				<option value="1000000061">Londrina</option>
				<option value="1000000315">Manaus</option>
				<option value="13431474">Maringa</option>
				<option value="1000000402">Pelotas</option>
				<option value="1000000404">Ponta Grossa</option>
				<option value="13430813">Porto Alegre</option>
				<option value="1000000255">PUC SP</option>
				<option value="44383183">Recife</option>
				<option value="1000000024">Ribeirao Preto</option>
				<option value="13431203">Rio de Janeiro</option>
				<option value="13429446">Salvador</option>
				<option value="1000000258">Sta Cruz do Sul</option>
				<option value="13430288">Santa Maria</option>
				<option value="1000000063">Sao Carlos</option>
				<option value="1000000403">Sao Luis</option>
				<option value="1000000316">Sorocaba</option>
				<option value="1000000256">Uberlandia</option>
				<option value="13430047">USP</option>
				<option value="13430533">Vitoria</option>
			</select>
			<br /> 
			<span class="light"> <b>by</b> </span>
			<br />
			<label>Month: </label> <input type="text"
				name="month" id="month" size="6" />
			<button type="submit" id="botMonth">Go</button>
			<br />
			<span class="light"> <b>or</b> </span>
			<br />
			<label>From: </label> <input type="text" name="from" id="from" size="8" />
			<label> to </label> <input type="text" name="to" id="to" size="8" /> 
			<button type="submit" id="bot">Go</button>
			<br />
			<br />
			<div style="float:left;">
				<label>Status: </label>
			</div>
			<div style="float:left;width: 80px">
				<input type="checkbox" name="types[]" value="4" checked>New<br>
				<input type="checkbox" name="types[]" value="6" checked>Realized<br>
				<input type="checkbox" name="types[]" value="1">Accepted<br>
			</div>
			<div style="float:left;width: 80px">
				<input type="checkbox" name="types[]" value="9" checked>Available<br>
				<input type="checkbox" name="types[]" value="5">On Hold<br>
				<input type="checkbox" name="types[]" value="7">Rejected<br>
			</div>
			<div style="float:left;width: 100px">
				<input type="checkbox" name="types[]" value="3" checked>Matched<br>
				<input type="checkbox" name="types[]" value="11">Pending<br>
				<input type="checkbox" name="types[]" value="12">Incomplete<br>
			</div>
		</div>
		<div class="right">
			<div class="top">
				<h4>&rsaquo;&rsaquo; Search single EP/TN Form</h4>
				<label>EP/TN Id: </label> <input type="text" id="form"></input>
				<button type="submit" id="formSearch">Go</button>
			</div>
			<div class="bottom">
				<h4>&rsaquo;&rsaquo; Search multiple EP/TN Forms (use commas to separate forms)</h4>
				<label for="forms">EP/TN Ids: </label> 
				<textarea style="resize: none; overflow-y: hidden; vertical-align: middle;" id="forms" rows="5" cols="50"></textarea>
				<button type="submit" id="formsSearch">Go</button>
			</div>
		</div>
	</div>
	<br />
	<div id="result" align="center"></div>
	
	<div id="tabs">
		<ul>
			<li><a href="#icx"><span>ICX</span></a></li>
			<li><a href="#ogx"><span>OGX</span></a></li>
		</ul>
		<div id="icx" align="center"></div>
		<div id="ogx" align="center"></div>
	</div>
	
	<div id="loadingBox">
		<br />
		<div align="center" id="status"></div>
		<br />
		<div id="loadingIcon" align="center"><img src="img/loading.gif" /></div>
	</div>
	<br />
	<br />
	<div class="footer"></div>
	<script type="text/javascript">
	
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-36213444-1']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>
</body>
</html>