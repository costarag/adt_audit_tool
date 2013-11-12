<?php
header('Content-Type: text/html; charset=iso-8859-1');
require_once 'include.php';
Util::requireLogin();
?>

<html>
<head>
<title>ADT Tool - AIESEC in Brazil</title>

<link rel="stylesheet" type="text/css" href="res/css/smoothness/jquery-ui-1.9.1.custom.css" />
<link rel="stylesheet" type="text/css" href="res/css/header.css" />
<link rel="stylesheet" type="text/css" href="res/css/styles.css" />

<script src="res/js/jquery-1.8.2.js"></script>
<script src="res/js/jquery-ui-1.9.1.custom.min.js"></script>

<script src="res/js/jquery.noty.js"></script>
<script src="res/js/jquery.noty.top.js"></script>
<script src="res/js/jquery.noty.default.js"></script>

<script src="res/js/FixedColumns.js"></script>
<script src="res/js/jquery.dataTables.js"></script>

<script src="res/js/jquery.dateFormat.js"></script>

<script src="res/js/jquery.jeditable.js"></script>
<script src="res/js/jquery.jeditable.ajaxupload.js"></script>
<script src="res/js/jquery.ajaxfileupload.js"></script>

<script src="res/js/extended.js"></script>

</head>
<body>
	<?php include("header.php"); ?>
	<div class="container" style="display: none">
		<br />
		<div id="result" align="center"></div>

		<div id="tabs" style="padding: 15px">
			<ul>
				<li id="li_summary"><a href="#summary"><span>Summary</span> </a></li>
				<li id="li_gcdpo"><a href="#gcdpo"><span>GCDPo</span> </a></li>
				<li id="li_gcdpi"><a href="#gcdpi"><span>GCDPi</span> </a></li>
				<li id="li_gipo"><a href="#gipo"><span>GIPo</span> </a></li>
				<li id="li_gipi"><a href="#gipi"><span>GIPi</span> </a></li>
				<li id="li_term"><a href="#term"><span>Terms</span> </a></li>
				<li id="li_legal"><a href="#legal"><span>Legal</span> </a></li>
				<!-- li><a href="#conclusion"><span>Conclusions</span> </a>
				</li  -->
			</ul>
			<div id="summary">
				<div style="float: right" id='right'></div>
				<div style="float: left" id='left'></div>
			</div>
			<div id="gcdpi" align="center"></div>
			<div id="gipi" align="center"></div>
			<div id="gcdpo" align="center"></div>
			<div id="gipo" align="center"></div>
			<div id="term" align="center"></div>
			<div id="legal" align="center"></div>
			<!-- 
			<div id="conclusion" align="left" height="500px">
				<p class="formfield">
					<label for="conc">Conclusions:</label>
					<textarea id="conc" rows="5" cols="50"></textarea>
				</p>
				<p class="formfield">
					<label for="melhoria">Opportunities:</label>
					<textarea id="melhoria" rows="5" cols="50"></textarea>
				</p>
				<p class="formfield">
					<label for="atencao">Attention:</label>
					<textarea id="atencao" rows="5" cols="50"></textarea>
				</p>
				<p>
					<input type="button" value="Save" id="saveConclusions" />
				</p>
			</div>
			 -->
		</div>

		<div id="loadingBox">
			<br />
			<div align="center" id="status"></div>
			<br />
			<div id="loadingIcon" align="center">
				<img src="res/img/loading.gif" />
			</div>
		</div>

		<div id="history" width="100%">
			<br />
			<div align="center" id="historyText"></div>
			<br />
		</div>

		<div id="editStatusLegal"
			style="padding: 5px; border: 1px solid black; position: absolute; width: 300px; height: 200px; background: #fff; display: none;">
			<h3 id="editStatusLegal_name"></h3>
			<form id="editStatusLegalForm">
				<table>
					<tr>
						<td>Status:</td>
						<td style="text-align: left;"><select name="status"
							id="editStatusLegal_status">
								<option value="0">- Select -</option>
						</select>
						</td>
					</tr>
					<tr>
						<td>Comment:</td>
						<td><textarea style="width: 200px; height: 50px;"
								id="editStatusLegal_comment" name="editStatusLegal_comment"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="Update"
							id="submitEditStatusLegal" /> <input type="button"
							id="closeEditStatusLegal" value="Cancel" /> <input type="button"
							id="showHistoryLegal" value="Show history" /> <input
							type="hidden" value="1" id="editStatusLegal_updated" /> <br />
						</td>
					</tr>

				</table>
			</form>
		</div>
		
		<div id="editStatusTerm"
			style="padding: 5px; border: 1px solid black; position: absolute; width: 300px; height: 200px; background: #fff; display: none;">
			<h3 id="editStatusTerm_name"></h3>
			<form id="editStatusTermForm">
				<table>
					<tr>
						<td>Status:</td>
						<td style="text-align: left;"><select name="status"
							id="editStatusTerm_status">
								<option value="0">- Select -</option>
						</select>
						</td>
					</tr>
					<tr>
						<td>Comment:</td>
						<td><textarea style="width: 200px; height: 50px;"
								id="editStatusTerm_comment" name="editStatusTerm_comment"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="Update"
							id="submitEditStatusTerm" /> <input type="button"
							id="closeEditStatusTerm" value="Cancel" /> <input type="button"
							id="showHistoryTerm" value="Show history" /> <input
							type="hidden" value="1" id="editStatusTerm_updated" /> <br />
						</td>
					</tr>

				</table>
			</form>
		</div>

		<div id="editStatusGCDPI"
			style="padding: 5px; border: 1px solid black; position: absolute; width: 300px; height: 200px; background: #fff; display: none;">
			<h3 id="editStatusGCDPI_name"></h3>
			<form id="editStatusGCDPIForm">
				<table>
					<tr>
						<td>Status:</td>
						<td style="text-align: left;"><select name="status"
							id="editStatusGCDPI_status">
								<option value="0">- Select -</option>
						</select>
						</td>
					</tr>
					<tr>
						<td>Comment:</td>
						<td><textarea style="width: 200px; height: 50px;"
								id="editStatusGCDPI_comment" name="editStatusGCDPI_comment"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="Update"
							id="submiteditStatusGCDPI" /> <input type="button"
							id="closeeditStatusGCDPI" value="Cancel" /> <input type="button"
							id="showHistoryGCDPI" value="Show history" /> <input
							type="hidden" value="1" id="editStatusGCDPI_updated" /> <br />
						</td>
					</tr>

				</table>
			</form>
		</div>

		<div id="editStatusGIPI"
			style="padding: 5px; border: 1px solid black; position: absolute; width: 300px; height: 200px; background: #fff; display: none;">
			<h3 id="editStatusGIPI_name"></h3>
			<form id="editStatusGIPIForm">
				<table>
					<tr>
						<td>Status:</td>
						<td style="text-align: left;"><select name="status"
							id="editStatusGIPI_status">
								<option value="0">- Select -</option>
						</select>
						</td>
					</tr>
					<tr>
						<td>Comment:</td>
						<td><textarea style="width: 200px; height: 50px;"
								id="editStatusGIPI_comment" name="editStatusGIPI_comment"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="Update"
							id="submiteditStatusGIPI" /> <input type="button"
							id="closeeditStatusGIPI" value="Cancel" /> <input type="button"
							id="showHistoryGIPI" value="Show history" /> <input type="hidden"
							value="1" id="editStatusGIPI_updated" /> <br />
						</td>
					</tr>

				</table>
			</form>
		</div>

		<div id="editStatusGCDPO"
			style="padding: 5px; border: 1px solid black; position: absolute; width: 300px; height: 200px; background: #fff; display: none;">
			<h3 id="editStatusGCDPO_name"></h3>
			<form id="editStatusGCDPOForm">
				<table>
					<tr>
						<td>Status:</td>
						<td style="text-align: left;"><select name="status"
							id="editStatusGCDPO_status">
								<option value="0">- Select -</option>
						</select>
						</td>
					</tr>
					<tr>
						<td>Comment:</td>
						<td><textarea style="width: 200px; height: 50px;"
								id="editStatusGCDPO_comment" name="editStatusGCDPO_comment"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="Update"
							id="submiteditStatusGCDPO" /> <input type="button"
							id="closeeditStatusGCDPO" value="Cancel" /> <input type="button"
							id="showHistoryGCDPO" value="Show history" /> <input
							type="hidden" value="1" id="editStatusGCDPO_updated" /> <br />
						</td>
					</tr>

				</table>
			</form>
		</div>

		<div id="editStatusGIPO"
			style="padding: 5px; border: 1px solid black; position: absolute; width: 300px; height: 200px; background: #fff; display: none;">
			<h3 id="editStatusGIPO_name"></h3>
			<form id="editStatusGIPOForm">
				<table>
					<tr>
						<td>Status:</td>
						<td style="text-align: left;"><select name="status"
							id="editStatusGIPO_status">
								<option value="0">- Select -</option>
						</select>
						</td>
					</tr>
					<tr>
						<td>Comment:</td>
						<td><textarea style="width: 200px; height: 50px;"
								id="editStatusGIPO_comment" name="editStatusGIPO_comment"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="Update"
							id="submiteditStatusGIPO" /> <input type="button"
							id="closeeditStatusGIPO" value="Cancel" /> <input type="button"
							id="showHistoryGIPO" value="Show history" /> <input type="hidden"
							value="1" id="editStatusGIPO_updated" /> <br />
						</td>
					</tr>

				</table>
			</form>
		</div>

		<br /> <br />
		<div class="footer"></div>
		<script>
$(document).ready(function() {

	var from = "";
	var to= "";

	var isMonthly = 1; // Default is Monthly.
	
	var doc_types = new Array();
	var audit_status_types = new Array();

	var reloading = false;

	var isAuditor = 0;

	$('#loadingIcon').hide();
	$("#tabs").tabs();
	$("#tabs").hide();

	function registerHover(program){
		$("."+program).hover(
			function () {
				var comment = $(this).attr('meta-comment');
				//alert(comment);
				$(this).attr('title',comment);
				$(this).css('border', '1px solid #00f');
				$(this).css('font-weight', 'bold');
				//$(this).css("background","#EEE9E9");
			}, 
			function () {
				$(this).css('border', '1px solid #000');
				$(this).css('font-weight', 'normal');
				//$(this).css("background","");
			}
		);
	}

	$.getJSON("actions/startup.php", function(result) {
	    var options = $("#clId");
	    $.each(result.cls, function() {
	        options.append($("<option />").val(this.clID).text(this.name));
	    });
	    
	    var options = $("#periodId");
	    $.each(result.periods, function() {
	        options.append($("<option />").val(this.id).text(this.period));
	    });
	    
	    //alert(result.isAuditor);
	    isAuditor = result.isAuditor;

	    if (!isAuditor){
	    	$('#saveConclusions').remove();

	    	$("#conc").attr("disabled", "disabled");
	    	$("#melhoria").attr("disabled", "disabled");
	    	$("#atencao").attr("disabled", "disabled");
	    }

	    var optionsGCDPI = $("#editStatusGCDPI_status");
	    var optionsGIPI = $("#editStatusGIPI_status");
	    var optionsGCDPO = $("#editStatusGCDPO_status");
	    var optionsGIPO = $("#editStatusGIPO_status");
	    var optionsTerm = $("#editStatusTerm_status");
	    var optionsLegal = $("#editStatusLegal_status");
	    
	    $.each(result.docStatus, function() {
	        optionsGCDPI.append($("<option style=\'background:"+this.color+"\'/>").val(this.id).text(this.status));
	        optionsGIPI.append($("<option style=\'background:"+this.color+"\'/>").val(this.id).text(this.status));
	        optionsGCDPO.append($("<option style=\'background:"+this.color+"\'/>").val(this.id).text(this.status));
	        optionsGIPO.append($("<option style=\'background:"+this.color+"\'/>").val(this.id).text(this.status));
	        optionsTerm.append($("<option style=\'background:"+this.color+"\'/>").val(this.id).text(this.status));
	        optionsLegal.append($("<option style=\'background:"+this.color+"\'/>").val(this.id).text(this.status));
	        doc_types[this.status] = this.id;
	    });

	    /*
	    var optionsAuditStatus = $("#editAuditStatus");
	    
	    $.each(result.auditStatus, function() {
	        optionsAuditStatus.append($("<option style=\'background:"+this.colour+"\'/>").val(this.id).text(this.desc));
	        audit_status_types[this.desc] = this.id;
	    });
	    */
	});


	//Summary
	$( "#ui-id-1" ).click(function() {
		$('#editStatusGCDPO').hide();	
		$('.taskStatusGCDPO').css('border', '1px solid #000');
		
		$('#editStatusGIPI').hide();	
		$('.taskStatusGIPI').css('border', '1px solid #000');
		
		$('#editStatusGIPO').hide();	
		$('.taskStatusGIPO').css('border', '1px solid #000');
		
		$('#editStatusGCDPI').hide();	
		$('.taskStatusGCDPI').css('border', '1px solid #000');
		
		prepareLoadSummary();
	} );
	
	//GCDPI
	$( "#ui-id-2" ).click(function() {
		$('#editStatusGCDPO').hide();	
		$('.taskStatusGCDPO').css('border', '1px solid #000');
		
		$('#editStatusGIPI').hide();	
		$('.taskStatusGIPI').css('border', '1px solid #000');
		
		$('#editStatusGIPO').hide();	
		$('.taskStatusGIPO').css('border', '1px solid #000');
		
		//prepareLoadSummary();
	} );

	//GIPI
	$( "#ui-id-3" ).click(function() {
		$('#editStatusGCDPI').hide();	
		$('.taskStatusGCDPI').css('border', '1px solid #000');
		
		$('#editStatusGCDPO').hide();	
		$('.taskStatusGCDPO').css('border', '1px solid #000');
		
		$('#editStatusGIPO').hide();	
		$('.taskStatusGIPO').css('border', '1px solid #000');
	});

	//GCDPo
	$( "#ui-id-4" ).click(function() {
		$('#editStatusGCDPI').hide();	
		$('.taskStatusGCDPI').css('border', '1px solid #000');
		
		$('#editStatusGIPI').hide();	
		$('.taskStatusGIPI').css('border', '1px solid #000');
		
		$('#editStatusGIPO').hide();	
		$('.taskStatusGIPO').css('border', '1px solid #000');
	});

	//GIPo
	$( "#ui-id-5" ).click(function() {
		$('#editStatusGCDPI').hide();	
		$('.taskStatusGCDPI').css('border', '1px solid #000');
		
		$('#editStatusGCDPO').hide();	
		$('.taskStatusGCDPO').css('border', '1px solid #000');
		
		$('#editStatusGIPI').hide();	
		$('.taskStatusGIPI').css('border', '1px solid #000');
	});

	$("#bot").click(function() {
		if (validateShowForms()){
   			loadForms();
		}
	});

	function formatDate(val) {
	    val = $.trim(val);
	    if (val == undefined || val == ''){
		    return "";
	    }else{ 
	    	var dt = new Date(val);
	    	return $.format.date(dt, 'dd-MMM-yy');
		    return ;
	    }
	}

	function formatDateTime(val) {
	    val = $.trim(val);
	    if (val == undefined || val == ''){
		    return "";
	    }else{ 
	    	var dt = new Date(val);
	    	return $.format.date(dt, 'dd-MMM-yy HH:mm:ss');
		    return ;
	    }
	}
	
	function checkNull(val) {
	    val = $.trim(val);
	    return (val == undefined || val == '') ? "" : val;
	}
	
	function addDays(dt, days) {
	    var val = $.trim(dt);
	    if (val == undefined || val == ''){
		     return "";
	    }else{
	    	var dt = new Date(val);
	    	var dtStr = new Date(dt.getTime() + days*24*60*60*1000);
	    	return $.format.date(dtStr, 'dd-MMM-yy');
	    }
	}
	
	function calculateFUDate(dtRE,dtEND,days) {

		//=SE(dtRE="";"";SE(dtRE+75<=dtInicio;dtRE+75;SE(dtRE+75>dtEND;"X";SE(dtRE+75>=dtRE;dtRE+75))))
		//TODO: Implement it.
		return "-";
		
	    var val = $.trim(dtRE);
	    if (val == undefined || val == ''){
		     return "";
	    }

	    val = $.trim(dtEND);
	    if (val == undefined || val == ''){
		     return "";
	    }
	    
    	var dateRE = new Date(dtRE);
    	var dateEND = new Date(dtEND);
    	
    	var dtStr = new Date(dt.getTime() + days*24*60*60*1000);
    	return $.format.date(dtStr, 'dd-MMM-yy');
	}

	function hasText(val) {
	    val = $.trim(val);
	    return (val == undefined || val == '') ? false : true;
	}
	
	function formatNum(val) {
	    val = $.trim(val);
	    return (val == undefined || val == '') ? 0 : val;
	}

	function prepareLoadSummary() {
		console.log("Reloading summary..");
		
		reloading = true;
		
		$("#loadingBox").dialog({
			title: "ADT - AuDit Tool",
	        modal: true,
	        resizable : false,
	        draggable: false
		});
		
        $('#loadingIcon').show();
        
        $('#status').text("Reloading summary...");

		//alert(isMonthly);
        
        if(isMonthly == 1){
        	loadSummaryMonthly();
        }else{
			loadSummary();
        }
		
	}

	function loadSummaryMonthly(){
		console.log("Loading Summary...");

		$("#left").html("");
		$("#right").html("");
		
		$.getJSON("actions/loadSummary.php?cl=" + $("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
			var summary = String(data);
			if(summary != ""){
				var summary =  '<table id="summarytable" style="float:left;">';
				summary += '<thead>';
				summary += '<tr>';
				summary += '<td><b>Audit</b></td>';
				summary += '<td><b>Requested</b></td>';
				summary += '<td><b>Delivered</b></td>';
				summary += '<td><b>% del.</b></td>';
				summary += '<td><b>Correct</b></td>';
				summary += '<td><b>% cor.</b></td>';
				summary += '<td><b>Fee</b></td>';
				summary += '<td><b>RD</b></td>';
				summary += '</tr>';
				summary += '</thead>';
				summary += '<tbody>';

				var totalSolicitadosRD = 0;
				var totalOKRD = 0;
				var totalSolicitados = 0;
				var totalEntregues = 0;
				var totalAceitos = 0;
				var totalMulta = 0;

				var totalNE = 0;
				var totalNE2 = 0;
				var totalNA = 0;
				var totalNA2 = 0;
				var totalOK = 0;
				var totalOK2 = 0;

				var multa = 0;

				var isFirstLine = true;

			 	$.each(data, function(type, item) {

					var table = '<div style="clear:both"><table id="'+type+'summarytable" class=\'collapsible\' style="float:right;">';
					table += '<thead>';
					table += '<tr class="head">';
					table += '<td width="350px" colspan="7"><b>'+type+'</b> (click to show details)</td>';
					table += '</tr>';
					table += '<tr class="child">';
					table += '<td>doc</td>';
					table += '<td class=\'ne\'>NE</td>';
					table += '<td class=\'ne2\'>NE2</td>';
					table += '<td class=\'na\'>NA</td>';
					table += '<td class=\'na2\'>NA2</td>';
					table += '<td class=\'ok\'>OK</td>';
					table += '<td class=\'ok2\'>OK2</td>';
					table += '</tr>';
					table += '</thead>';
					table += '<tbody>';

					multa = 0;
					totalNE = 0;
			        $.each(data[type].ne, function(index, item) { 
				        //alert(item[0]);
			        	table +='<tr class="child">';
			            table +='<td>' + item[0] + '</td>';
			            table +='<td class=\'ne\'>' + formatNum(item[1]) + '</td>';
			            table +='<td id=\''+item[0]+'_ne2_'+type+'\' class=\'ne\'></td>';
			            table +='<td id=\''+item[0]+'_na_'+type+'\' class=\'na\'></td>';
			            table +='<td id=\''+item[0]+'_na2_'+type+'\' class=\'na\'></td>';
			            table +='<td id=\''+item[0]+'_ok_'+type+'\' class=\'ok\'></td>';
			            table +='<td id=\''+item[0]+'_ok2_'+type+'\' class=\'ok2\'></td>';
			            table +='</tr>';
			            totalNE += parseInt(formatNum(item[1]));
			            multa += parseInt(formatNum(item[2]));
			        });
					table += '<tr class="child">';
					table += '<td><b>total</b></td>';
					table += '<td class=\'ne\'><b>'+totalNE+'</b></td>';
					table += '<td id=\'total_ne2_'+type+'\' class=\'ne\'></td>';
					table += '<td id=\'total_na_'+type+'\' class=\'na\'></td>';
					table += '<td id=\'total_na2_'+type+'\' class=\'na\'></td>';
					table += '<td id=\'total_ok_'+type+'\' class=\'ok\'></td>';
					table += '<td id=\'total_ok2_'+type+'\' class=\'ok2\'></td>';
					
					table += '</tr>';
					
					table += '</tbody>';
			        table += '</table></div>'; 
			        //alert(table);
		        
			        $("#right").append(table);

					totalNE2 = 0;
			        $.each(data[type].ne2, function(index, item) {
				        $('#'+item[0]+'_ne2_'+type).text(formatNum(item[1])); 
				        totalNE2 += parseInt(formatNum(item[1]));
				        multa += parseInt(formatNum(item[2]));
			        });
			        $('#total_ne2_'+type).html('<b>'+totalNE2+'</b>');
			         
					totalNA = 0;
			        $.each(data[type].na, function(index, item) {
				        $('#'+item[0]+'_na_'+type).text(formatNum(item[1])); 
				        totalNA += parseInt(formatNum(item[1]));
				        multa += parseInt(formatNum(item[2]));
			        });
			        $('#total_na_'+type).html('<b>'+totalNA+'</b>');
			         
					totalNA2 = 0;
			        $.each(data[type].na2, function(index, item) {
				        $('#'+item[0]+'_na2_'+type).text(formatNum(item[1])); 
				        totalNA2 += parseInt(formatNum(item[1]));
				        multa += parseInt(formatNum(item[2]));
			        });
			        $('#total_na2_'+type).html('<b>'+totalNA2+'</b>'); 
			        
					totalOK = 0;
			        $.each(data[type].ok, function(index, item) {
				        $('#'+item[0]+'_ok_'+type).text(formatNum(item[1])); 
				        totalOK += parseInt(formatNum(item[1]));
			        });
			        $('#total_ok_'+type).html('<b>'+totalOK+'</b>');
			        
					totalOK2 = 0;
			        $.each(data[type].ok2, function(index, item) {
				        $('#'+item[0]+'_ok2_'+type).text(formatNum(item[1])); 
				        totalOK2 += parseInt(formatNum(item[1]));
			        });
			        $('#total_ok2_'+type).html('<b>'+totalOK2+'</b>');

					var solicitados = 0;
					var entregues = 0;
					var percEntr = 0;
					var percOK = 0;
										
			 		solicitados 	= totalNE + totalNE2 + totalNA + + totalNA2 + totalOK + totalOK2;
			 		solicitadosRD 	= totalNE + totalNA + totalOK;
			 		
					entregues 	= totalOK + totalOK2 + totalNA + totalNA2;
					entreguesOK = totalOK + totalOK2;
					
					percEntr =  solicitados == 0 ? 0 : ((entregues / solicitados) * 100).toFixed(2);
					percOK 	 =  solicitados == 0 ? 0 : (( entreguesOK / solicitados) * 100).toFixed(2);

					//We dont calculate RD for area (GCDPI, GIPI, etc.). If necessary, just uncomment line below.
					//percRD = ((totalOK / (totalNE + totalNA + totalOK)) * 100).toFixed(2);
					
					totalSolicitados 	+= solicitados;
					totalSolicitadosRD 	+= solicitadosRD;
					totalOKRD 			+= totalOK;
					totalEntregues 		+= entregues;
					totalAceitos 		+= entreguesOK;
					totalMulta 			+= parseFloat(multa);

					summary +='<tr>';
					summary +='<td>' + type + '</td>';
					summary +='<td>' + solicitados + '</td>';
					summary +='<td>' + entregues + '</td>';
					summary +='<td>' + percEntr + '%</td>';
					summary +='<td>' + entreguesOK + '</td>';
					summary +='<td>' + percOK + '%</b></td>';
					summary +='<td>' + multa + '</td>';

					//Do only add total_rd element if listing first line. Avoid table break. 
					if (isFirstLine){
						summary +='<td width="50px" id=\'total_rd\' rowspan="5"></td>';
					}
					isFirstLine = false;
						
					summary +='</tr>';
			 	});

			 	var totalPercEntr = totalSolicitados == 0 ? 0 : ((totalEntregues / totalSolicitados) * 100).toFixed(2);
				var totalPercOK = totalSolicitados == 0 ? 0 : ((totalAceitos / totalSolicitados) * 100).toFixed(2);
				var totalPercRD = totalSolicitadosRD == 0 ? 0 : ((totalOKRD / totalSolicitadosRD) * 100).toFixed(2);

				summary +='<tr>';
				summary +='<td><b>Total</b></td>';
				summary +='<td><b>' + totalSolicitados + '</b></td>';
				summary +='<td><b>' + totalEntregues + '</b></td>';
				summary +='<td><b>' + totalPercEntr + '%</b></td>';
				summary +='<td><b>' + totalAceitos + '</b></td>';
				summary +='<td><b>' + totalPercOK + '%</b></td>';
				summary +='<td><b>R$ ' + totalMulta + '</b></td>';
				// summary +='<td><b> ' + totalPercRD + '%</td>';
				summary +='</tr>';
			 	
				summary += '</tbody>';
	            summary += '</table></div>';


	            summary += '<div style="clear:both;align:left;font-size:10px"><br/>';
	            summary += '<b>Legenda:</b> <br />';
	            summary += 'Requested - Todos docs cobrados (NE + NE2 + NA + NA2 + OK + OK2)<br />';		
	            summary += 'Delivered - Todos docs entregues (NA + NA2 + OK + OK2)<br />';		
	            summary += '% del. - Proporção de entregues por cobrados (delivered/requested)<br />';		
	            summary += 'Correct - Documentos entregues corretos (OK + OK2)<br />';		
	            summary += '% del. - Proporção de corretos por cobrados (correct/requested)<br />';
	            summary += 'Fee - R$ 10 para cada documento ou R$ 5 para follow up não entregue/aceito. <br />';
	            summary += 'RD - Proporção de entregues corretos pela 1a vez por cobrados pela 1a vez (OK / (NE + NA + OK))<br />';
	            			
	            summary += '<br /><b>Aceites:</b> <br />';
	            summary += 'OK- Aceito<br />';		
	            summary += 'NA - Não aceito<br />';		
	            summary += 'NE - Não entregue<br />';		
	            summary += 'S  - Já entregue e aceito<br />';		
	            //summary += '-  - Não cobrado<br />';		
	            summary += 'NE2 - Não entregue pela 2a vez<br />';		
	            summary += 'NA2 - Não aceito pela 2a vez<br />';		
	            summary += 'OK2 - Aceito na 2a vez<br />';		
	            summary += '</div>';
	             
				$("#left").append(summary);

				$('#total_rd').html('<b><span style=\'font-size:14px\'>'+totalPercRD + '%</span></b>');

				handleCollapse();

				if (reloading){
					$('#loadingIcon').hide();
					$('#loadingBox').dialog("close");

					reloading = false;
				}

	        }else{
		        alert("No summary data.");
			}
		});
	}

	function loadSummary(){
		console.log("Loading Summary...");

		$("#left").html("");
		$("#right").html("");
		
		$.getJSON("actions/loadSummaryConference.php?cl=" + $("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
			var summary = String(data);
			//alert(summary);
			if(summary != ""){
				var summary =  '<table id="summarytable" style="float:left;">';
				summary += '<thead>';
				summary += '<tr>';
				summary += '<td><b>Audit</b></td>';
				summary += '<td><b>Requested</b></td>';
				summary += '<td><b>Delivered</b></td>';
				summary += '<td><b>% del.</b></td>';
				summary += '<td><b>Correct</b></td>';
				summary += '<td><b>% cor.</b></td>';
				summary += '<td><b>Fee</b></td>';
				summary += '</tr>';
				summary += '</thead>';
				summary += '<tbody>';

				var totalSolicitados = 0;
				var totalEntregues = 0;
				var totalAceitos = 0;
				var totalMulta = 0;

				var totalNE = 0;
				var totalNE2 = 0;
				var totalNA = 0;
				var totalNA2 = 0;
				var totalOK = 0;
				var totalOK2 = 0;

				var multa = 0;

			 	$.each(data, function(type, item) {

			 		if(type == 'term'){
						valor_multa = 5;
						totalNE = parseInt(data[type]['ne']);  	
						totalNE2 = parseInt(data[type]['ne2']);  	
						totalNA = parseInt(data[type]['na']); 	
						totalNA2 = parseInt(data[type]['na2']); 	
						totalOK = parseInt(data[type]['ok']);
						totalOK2 = parseInt(data[type]['ok2']);

						solicitados = totalNE + totalNE2 + totalNA + totalNA2 + totalOK + totalOK2;
						entregues = totalOK + totalOK2 + totalNA + totalNA2;
						entreguesOK = totalOK + totalOK2;
						percEntr =  solicitados == 0 ? 0 : ((entregues / solicitados) * 100).toFixed(2);
						percOK 	 =  solicitados == 0 ? 0 : (( entreguesOK / solicitados) * 100).toFixed(2);
						multa = (( valor_multa * (totalNE + totalNA + totalNE2 + totalNA2))).toFixed(2);
						
						totalSolicitados += solicitados;
						totalEntregues += entregues;
						totalAceitos += totalOK;
						totalMulta = parseFloat(totalMulta) + parseFloat(multa);
				 	}
				 	
			 		if(type == 'legal'){
						valor_multa = 10;
						valor_mc_fee = 228.73;
						totalNE = parseInt(data[type]['ne']);  	
						totalNE2 = parseInt(data[type]['ne2']);  	
						totalNA = parseInt(data[type]['na']); 	
						totalNA2 = parseInt(data[type]['na2']); 	
						totalOK = parseInt(data[type]['ok']);
						totalOK2 = parseInt(data[type]['ok2']);

						solicitados = totalNE + totalNE2 + totalNA + totalNA2 + totalOK + totalOK2;
						entregues = totalOK + totalOK2 + totalNA + totalNA2;
						entreguesOK = totalOK + totalOK2;
						percEntr =  solicitados == 0 ? 0 : ((entregues / solicitados) * 100).toFixed(2);
						percOK 	 =  solicitados == 0 ? 0 : (( entreguesOK / solicitados) * 100).toFixed(2);
						multa = (( valor_multa * (totalNE + totalNA) + valor_mc_fee * (totalNE2 + totalNA2))).toFixed(2);
						
						totalSolicitados += solicitados;
						totalEntregues += entregues;
						totalAceitos += totalOK;
						totalMulta = parseFloat(totalMulta) + parseFloat(multa);
				 	}
					summary +='<tr>';
					summary +='<td>' + type + '</td>';
					summary +='<td>' + solicitados + '</td>';
					summary +='<td>' + entregues + '</td>';
					summary +='<td>' + percEntr + '%</td>';
					summary +='<td>' + entreguesOK + '</td>';
					summary +='<td>' + percOK + '%</b></td>';
					summary +='<td>' + multa + '</td>';
					summary +='</tr>';
			 	});

			 	var totalPercEntr = totalSolicitados == 0 ? 0 : ((totalEntregues / totalSolicitados) * 100).toFixed(2);
				var totalPercOK = totalSolicitados == 0 ? 0 : ((totalAceitos / totalSolicitados) * 100).toFixed(2);

				summary +='<tr>';
				summary +='<td><b>Total</b></td>';
				summary +='<td><b>' + totalSolicitados + '</b></td>';
				summary +='<td><b>' + totalEntregues + '</b></td>';
				summary +='<td><b>' + totalPercEntr + '%</b></td>';
				summary +='<td><b>' + totalAceitos + '</b></td>';
				summary +='<td><b>' + totalPercOK + '%</b></td>';
				summary +='<td><b>R$ ' + totalMulta + '</b></td>';
				summary +='</tr>';
			 	
				summary += '</tbody>';
	            summary += '</table></div>';


	            summary += '<div style="clear:both;align:left;font-size:10px"><br/>';
	            summary += '<b>Legenda:</b> <br />';
	            summary += 'Requested - Todos docs cobrados (NE + NE2 + NA + NA2 + OK + OK2)<br />';		
	            summary += 'Delivered - Todos docs entregues (NA + NA2 + OK + OK2)<br />';		
	            summary += '% del. - Proporção de entregues por cobrados (delivered/requested)<br />';		
	            summary += 'Correct - Documentos entregues corretos (OK + OK2)<br />';		
	            summary += '% del. - Proporção de corretos por cobrados (correct/requested)<br />';
	            summary += 'Fee - Termos: R$ 5. Legal: Primeira Vez: R$ 10,00. Reincidência: 1 MC FEE por cada vez.<br />';
	            			
	            summary += '<br /><b>Aceites:</b> <br />';
	            summary += 'OK- Aceito<br />';		
	            summary += 'NA - Não aceito<br />';		
	            summary += 'NE - Não entregue<br />';		
	            summary += 'S  - Já entregue e aceito<br />';		
	            //summary += '-  - Não cobrado<br />';		
	            summary += 'NE2 - Não entregue pela 2a vez<br />';		
	            summary += 'NA2 - Não aceito pela 2a vez<br />';		
	            summary += 'OK2 - Aceito na 2a vez<br />';		
	            summary += '</div>';
	             
				$("#left").append(summary);

				if (reloading){
					$('#loadingIcon').hide();
					$('#loadingBox').dialog("close");

					reloading = false;
				}

	        }else{
		        //alert("No summary data.");
			}
		});
	}

	function handleCollapse(){
		$("table.collapsible").parent().find("tbody").slideUp();
	    $("table.collapsible").parent().find("thead .child").slideUp();
	    
		$("table.collapsible").click(function (event) { 
		    //$("table.collapsible > tbody", $(this).parent()).slideToggle("fast");
		    //$("table.collapsible > thead > tr.child", $(this).parent()).slideToggle("fast");
		    
		    $("table.collapsible").parent().find("tbody").slideUp();
		    $("table.collapsible").parent().find("thead .child").slideUp();
		    
		    $(this).parent().find("tbody").slideToggle("fast");
		    $(this).parent().find("thead .child").slideToggle("fast");
	    });
	}

	function loadGCDPi(data){

        console.log("Loading GCDPi...");

		var tns = String(data);
		if(tns != ""){
				var table = '<table id="gcdpi_table">';
				table += '<thead>';
				table += '<tr>';
				table += '<th rowspan="2">TN Id</th>';
				table += '<th rowspan="2">Organisation name</th>';
				table += '<th rowspan="2">Type</th>';
				table += '<th rowspan="2">Status</th>';
				table += '<th rowspan="2">RA</th>';
				table += '<th rowspan="2">MA</th>';
				table += '<th rowspan="2">RE</th>';
				table += '<th rowspan="2">End</th>';
				table += '<th rowspan="2">Contract</th>';
				table += '<th rowspan="2">&nbsp;EP_AN&nbsp;</th>';
				table += '<th rowspan="2">&nbsp;TN_AN&nbsp;</th>';
				table += '<th rowspan="2">RNE</th>';
				table += '<th rowspan="2">TR Checklist</th>';
				table += '<th colspan="4">Follow-up</th>';
				table += '<th rowspan="2">Visita fechamento</th>';
				table += '<th rowspan="2">EP Id</th>';
				table += '<th rowspan="2">EP</th>';
				table += '</tr>';

				table += '<tr>';
				table += '<th colspan="2">1st week</th>';
				table += '<th colspan="2">3rd week</th>';
				table += '</tr>';
				table += '</tr></thead>';
											
				table += '<tbody>';
		        $.each(data, function(index, item) { /* add to html string started above*/
		        	//table += '<tr><td class=\'form fixed\' align="center"><a href=\'http://www.myaiesec.net/exchange/viewtn.do?operation=executeAction&tnId='+item.formId+'\' target="_blank">'+ item.id +'<a/></td>';
		            table +='<tr><td><b>' + item.id + '</b></td>';
		            table +='<td><b>' + item.name + '</b></td>';
		            table +='<td class=\'extype '+item.type+'\'>' + item.type + '</td>';
		            table +='<td class=\'extype '+item.status+'\'>' + item.status + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtRA) + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtMA) + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtRE) + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtEND) + '</td>';

		            //CONTRACT
		            table +='<td id=\"'+$.trim(item.id)+'_contract\" style="min-width: 85px;" class=\'taskStatusGCDPI '+item.contract+' ';
		            if(hasText(item.comment_contract)){
		            	table +='comment\' ';
		            }
		            table +='meta-comment=\''+checkNull(item.comment_contract)+'\' meta-form=\''+$.trim(item.id)+'\' meta-doc=\'contract\' meta-type=\'icx_gcdp\'>' + checkNull(item.contract) + '</td>';

		            //SAN
		            table +='<td id=\"'+$.trim(item.id)+'_san\" class=\'taskStatusGCDPI '+item.san+' ';
		            if(hasText(item.comment_san)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_san)+'\' meta-doc=\'san\' meta-type=\'icx_gcdp\'>' + checkNull(item.san) + '</td>';

		            //CAN
		            table +='<td id=\"'+$.trim(item.id)+'_can\" class=\'taskStatusGCDPI '+item.can+' ';
		            if(hasText(item.comment_can)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_can)+'\' meta-doc=\'can\' meta-type=\'icx_gcdp\'>' + checkNull(item.can) + '</td>';

					//RNE			            
		            table +='<td id=\"'+$.trim(item.id)+'_rne\" class=\'taskStatusGCDPI '+item.rne+' ';
		            if(hasText(item.comment_rne)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_rne)+'\' meta-doc=\'rne\' meta-type=\'icx_gcdp\'>' + checkNull(item.rne) + '</td>';

		            //TR Checklist
		            table +='<td id=\"'+$.trim(item.id)+'_tr_checklist\" class=\'taskStatusGCDPI '+item.tr_checklist+' ';
		            if(hasText(item.comment_tr_checklist)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_tr_checklist)+'\' meta-doc=\'tr_checklist\' meta-type=\'icx_gcdp\'>' + checkNull(item.tr_checklist) + '</td>';

		            //Follow up 1st week
		            table +='<td class="dtForm">' + addDays(item.dtRE,7) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_1st\" class=\'taskStatusGCDPI '+item.fu_1st+' ';
		            if(hasText(item.comment_fu_1st)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_1st)+'\' meta-doc=\'fu_1st\' meta-type=\'icx_gcdp\'>' + checkNull(item.fu_1st) + '</td>';
		            
		            //Follow up 3rd week
		            table +='<td class="dtForm">' + addDays(item.dtRE,21) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_3rd\" class=\'taskStatusGCDPI '+item.fu_3rd+' ';
		            if(hasText(item.comment_fu_3rd)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_3rd)+'\' meta-doc=\'fu_3rd\' meta-type=\'icx_gcdp\'>' + checkNull(item.fu_3rd) + '</td>';

			        //Visita fechamento
		            table +='<td id=\"'+$.trim(item.id)+'_visita_fechamento\" class=\'taskStatusGCDPI '+item.visita_fechamento+' ';
		            if(hasText(item.comment_visita_fechamento)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\'  meta-comment=\''+item.comment_visita_fechamento+'\' meta-doc=\'visita_fechamento\' meta-type=\'icx_gcdp\'>' + checkNull(item.visita_fechamento) + '</td>';

		            table +='<td class=\'form\'>' +  checkNull(item.formMAId) + '</td>';
		            table +='<td>' +  checkNull(item.formMAName) + '</td>';
		            table +='</tr>';
		        });
				table += '</tbody>';
		        table += '</table>';

		        //$('.container').show(); 
		        //$("#tabs").show();
		        $("#gcdpi").html(table);

		        registerHover('taskStatusGCDPI');

		        if(isAuditor === 1){ 

			    	$('.taskStatusGCDPI').click(function(){
				 		// icx_gcdp, icx_gip, ..
				 		metaType = $(this).attr('meta-type');
				 		// SAN, CAN, ...
				 		metaDoc = $(this).attr('meta-doc');
				 		metaComment = $(this).attr('meta-comment');
				 		metaForm = $(this).attr('meta-form');
				 		
				 		$('.taskStatusGCDPI').css('border', '1px solid #000');
				 		
				 		var offset = $(this).offset();
				 		
				 		$('#editStatusGCDPI_name').text(""+metaForm +': ' + (""+metaDoc).toUpperCase());
				 		
				 		var id = '#' + metaForm + '_' + metaDoc;
				 		
				 		$('#editStatusGCDPI_comment').val(metaComment);
				 		
				 		$('#editStatusGCDPI_status').val(doc_types[$(id).text()]);
				 		$('#editStatusGCDPI_status').css('background', $('#editStatusGCDPI_status').find('option:selected').css('background'));

				 		offset.left += 100;
				 		if (offset.left > 900) offset.left = offset.left - 400;
				 		
				 		$('#editStatusGCDPI').css('top', offset.top + "px");
				 		$('#editStatusGCDPI').css('left', offset.left + "px");
				 		$('#editStatusGCDPI').show();
				    });

			 		$('#editStatusGCDPI_status').change(function(){
			 			$('#editStatusGCDPI_status').css('background', $('#editStatusGCDPI_status').find('option:selected').css('background'));
			 		});

					$("#closeeditStatusGCDPI").click(function(){
						$('#editStatusGCDPI').hide();
						$('.taskStatusGCDPI').css('border', '1px solid #000');
					});

					$("#showHistoryGCDPI").click(function(){

						$.getJSON("actions/loadHistory.php?type=" + metaType+"&doc=" + metaDoc+"&form="+metaForm+"&cl="+$("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
							
							$("#history").dialog({
								title: "History - "+metaForm +': ' + (""+metaDoc).toUpperCase(),
						        modal: true,
						        position: ['center', 'center'],
						        resizable : false,
						        draggable: true,
						        width:'auto'
							});

							if(data.length == 0){
								$('#historyText').text("No results.");
								return;
							}
					
						   	var table = '<table id="historytable">';
							table += '<thead>';
							table += '<th>Date</th>';
							table += '<th>User</th>';
							table += '<th>Status</th>';
							table += '<th>Comment</th>';
							table += '</thead>';

							table += '<tbody>';
							$.each(data, function(index, item) { 
						    	table +='<tr><td>' + formatDateTime(item.datetime) + '</td>';
						    	table +='<td>' + item.user + '</td>';
						    	table +='<td class='+item.status+'>' + item.status + '</td>';
						    	table +='<td>' + item.comment + '</td>';
						        table +='</tr>';
					        });
					        
							table += '</tbody>';
						    table += '</table>';

							$('#historyText').html(table);
						});
					});
						

					$("#submiteditStatusGCDPI").click(function(){
						var value 	= $('#editStatusGCDPI_status').val();

						$('.taskStatusGCDPI').css('border', '1px solid #000');
						$.ajax({
							   type: "POST",
							   url: "actions/updateForm.php?type=" + metaType+"&doc=" + metaDoc+"&form="+metaForm+"&status="+value+"&period="+ $("#periodId").val(),
							   data: $('#editStatusGCDPIForm').serialize(),
							   success: function(data){
									$('#editStatusGCDPI_status').val(0);
									$('#editStatusGCDPI_comment').val('');
									$('#editStatusGCDPI').hide();

									var id = '#' + $.trim(metaForm) + '_' + $.trim(metaDoc);
									var obj = jQuery.parseJSON(data);
									
									$(id).attr('meta-comment',obj.comment);
									$(id).text(obj.status);
									$(id).removeClass();
									$(id).addClass('taskStatusGCDPI');
									$(id).addClass(obj.status);

									$(id).attr('title', obj.comment);
									
									if(hasText(obj.comment)){
										$(id).addClass('comment');
									}

									noty({
										type: 'success',
										text: 'Form <strong>'+metaForm+'</strong> updated successfully.',
										timeout: '2000', 
									});
							   },
							   error : function(request, status, error) {

								   noty({
										type: 'error',
										text: request.responseText,
										timeout: '2000', 
									});
									$('#editStatusGCDPI').hide();
								}
							 });
					});
		        }else{
			        //TODO: Implement CLs view.
		        }
		}else{
			$('#loadingIcon').hide();
			$('#loadingBox').dialog("close");
			$("#gcdpi").html("<p>No results found.</p>");
		}

    	//GIPi
        //loadGIPi(gipi);
	}
	
	function normalizeString(s){
                    var r=s.toLowerCase();
                    r = r.replace(new RegExp("\\s", 'g')," ");
                    r = r.replace(new RegExp("[àáâãäå]", 'g'),"a");
                    r = r.replace(new RegExp("æ", 'g'),"ae");
                    r = r.replace(new RegExp("ç", 'g'),"c");
                    r = r.replace(new RegExp("[èéêë]", 'g'),"e");
                    r = r.replace(new RegExp("[ìíîï]", 'g'),"i");
                    r = r.replace(new RegExp("ñ", 'g'),"n");                            
                    r = r.replace(new RegExp("[òóôõö]", 'g'),"o");
                    r = r.replace(new RegExp("œ", 'g'),"oe");
                    r = r.replace(new RegExp("[ùúûü]", 'g'),"u");
                    r = r.replace(new RegExp("[ýÿ]", 'g'),"y");
					r = r.replace(new RegExp("\\W", 'g')," ");
		return r;  
	}
	
	
	function loadGIPo(data){

        console.log("Loading GIPo...");

		var tns = String(data);
		if(tns != ""){
				var table = '<table id="gipo_table">';
				table += '<thead><tr>';
				table += '<th rowspan="2">EP Id</th>';
				table += '<th rowspan="2">Name</th>';
				table += '<th rowspan="2">Type</th>';
				table += '<th rowspan="2">Status</th>';
				table += '<th rowspan="2">RA</th>';
				table += '<th rowspan="2">MA</th>';
				table += '<th rowspan="2">RE</th>';
				table += '<th rowspan="2">End</th>';
				table += '<th rowspan="2">Contract</th>';
				table += '<th rowspan="2">&nbsp;EP_AN&nbsp;</th>';
				table += '<th rowspan="2">&nbsp;TN_AN&nbsp;</th>';
				table += '<th rowspan="2">EP Checklist</th>';
				table += '<th colspan="20">Follow-up</th>';
				table += '<th rowspan="2">TN Id</th>';
				table += '<th rowspan="2">TN</th>';
				table += '</tr>';

				table += '<tr>';
				table += '<th colspan="2">1st week</th>';
				table += '<th colspan="2">1st month</th>';
				table += '<th colspan="2">plus 45 days</th>';
				table += '<th colspan="2">plus 90 days</th>';
				table += '<th colspan="2">plus 135 days</th>';
				table += '<th colspan="2">plus 180 days</th>';
				table += '<th colspan="2">plus 225 days</th>';
				table += '<th colspan="2">plus 270 days</th>';
				table += '<th colspan="2">plus 315 days</th>';
				table += '<th colspan="2">plus 360 days</th>';
				table += '</tr>';
				table += '</tr></thead>';
											
				table += '<tbody>';
		        $.each(data, function(index, item) { /* add to html string started above*/
		        	//table += '<tr><td class=\'form fixed\' align="center"><a href=\'http://www.myaiesec.net/exchange/viewtn.do?operation=executeAction&tnId='+item.formId+'\' target="_blank">'+ item.id +'<a/></td>';
		            table +='<td><b>' + item.id + '</b></td>';
		            table +='<td><b>' + item.name + '</b></td>';
		            table +='<td class=\'extype '+item.type+'\'>' + item.type + '</td>';
		            table +='<td class=\'extype '+item.status+'\'>' + item.status + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtRA) + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtMA) + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtRE) + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtEND) + '</td>';

		            //CONTRACT
		            table +='<td id=\"'+$.trim(item.id)+'_contract\" style="min-width: 85px;" class=\'taskStatusGIPO '+item.contract+' ';
		            if(hasText(item.comment_contract)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-comment=\''+checkNull(item.comment_contract)+'\' meta-form=\''+$.trim(item.id)+'\' meta-doc=\'contract\' meta-type=\'ogx_gip\'>' + checkNull(item.contract) + '</td>';

		            //SAN
		            table +='<td id=\"'+$.trim(item.id)+'_san\" class=\'taskStatusGIPO '+item.san+' ';
		            if(hasText(item.comment_san)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_san)+'\' meta-doc=\'san\' meta-type=\'ogx_gip\'>' + checkNull(item.san) + '</td>';

		            //CAN
		            table +='<td id=\"'+$.trim(item.id)+'_can\" class=\'taskStatusGIPO '+item.can+' ';
		            if(hasText(item.comment_can)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_can)+'\' meta-doc=\'can\' meta-type=\'ogx_gip\'>' + checkNull(item.can) + '</td>';

		            //EP Checklist
		            table +='<td id=\"'+$.trim(item.id)+'_tr_checklist\" class=\'taskStatusGIPO '+item.ep_checklist+' ';
		            if(hasText(item.comment_ep_checklist)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_ep_checklist)+'\' meta-doc=\'ep_checklist\' meta-type=\'ogx_gip\'>' + checkNull(item.ep_checklist) + '</td>';

		            //Follow up 1st week
		            table +='<td class="dtForm">' + addDays(item.dtRE,7) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_1st_week\" class=\'taskStatusGIPO '+item.fu_1st_week+' ';
		            if(hasText(item.comment_fu_1st_week)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_1st_week)+'\' meta-doc=\'fu_1st_week\' meta-type=\'ogx_gip\'>' + checkNull(item.fu_1st_week) + '</td>';
		            
		            //Follow up 1st month
		            table +='<td class="dtForm">' + addDays(item.dtRE,30) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_1st_month\" class=\'taskStatusGIPO '+item.fu_1st_month+' ';
		            if(hasText(item.comment_fu_1st_month)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_1st_month)+'\' meta-doc=\'fu_1st_month\' meta-type=\'ogx_gip\'>' + checkNull(item.fu_1st_month) + '</td>';
		            
		            //Follow up plus 45 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,45) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_45\" class=\'taskStatusGIPO '+item.fu_plus_45+' ';
		            if(hasText(item.comment_fu_plus_45)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_45)+'\' meta-doc=\'fu_plus_45\' meta-type=\'ogx_gip\'>' + checkNull(item.fu_plus_45) + '</td>';
		            
		            //Follow up plus 90 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,90) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_90\" class=\'taskStatusGIPO '+item.fu_plus_90+' ';
		            if(hasText(item.comment_fu_plus_90)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_90)+'\' meta-doc=\'fu_plus_90\' meta-type=\'ogx_gip\'>' + checkNull(item.fu_plus_90) + '</td>';
		            
		            //Follow up plus 135 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,135) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_135\" class=\'taskStatusGIPO '+item.fu_plus_135+' ';
		            if(hasText(item.comment_fu_plus_135)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_135)+'\' meta-doc=\'fu_plus_135\' meta-type=\'ogx_gip\'>' + checkNull(item.fu_plus_135) + '</td>';
		            
		            //Follow up plus 180 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,180) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_180\" class=\'taskStatusGIPO '+item.fu_plus_180+' ';
		            if(hasText(item.comment_fu_plus_180)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_180)+'\' meta-doc=\'fu_plus_180\' meta-type=\'ogx_gip\'>' + checkNull(item.fu_plus_180) + '</td>';
		            
		            //Follow up plus 225 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,225) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_225\" class=\'taskStatusGIPO '+item.fu_plus_225+' ';
		            if(hasText(item.comment_fu_plus_225)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_225)+'\' meta-doc=\'fu_plus_225\' meta-type=\'ogx_gip\'>' + checkNull(item.fu_plus_225) + '</td>';
		            
		            //Follow up plus 270 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,270) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_270\" class=\'taskStatusGIPO '+item.fu_plus_270+' ';
		            if(hasText(item.comment_fu_plus_270)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_270)+'\' meta-doc=\'fu_plus_270\' meta-type=\'ogx_gip\'>' + checkNull(item.fu_plus_270) + '</td>';
		            
		            //Follow up plus 315 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,315) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_315\" class=\'taskStatusGIPO '+item.fu_plus_315+' ';
		            if(hasText(item.comment_fu_plus_315)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_315)+'\' meta-doc=\'fu_plus_315\' meta-type=\'ogx_gip\'>' + checkNull(item.fu_plus_315) + '</td>';
		            
		            //Follow up plus 360 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,360) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_360\" class=\'taskStatusGIPO '+item.fu_plus_360+' ';
		            if(hasText(item.comment_fu_plus_360)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_360)+'\' meta-doc=\'fu_plus_360\' meta-type=\'ogx_gip\'>' + checkNull(item.fu_plus_360) + '</td>';

		            /*
		            * FIM FOLLOW-UPs
		            */

		            table +='<td class=\'form\'>' +  checkNull(item.formMAId) + '</td>';
		            table +='<td>' +  checkNull(item.formMAName) + '</td>';
		            table +='</tr>';
		        });
				table += '</tbody>';
		        table += '</table>';

		        //$('.container').show(); 
		        //$("#tabs").show();
		        $("#gipo").html(table);

		        registerHover('taskStatusGIPO');

		        if(isAuditor === 1){ //Temp. disabling edit

			    	$('.taskStatusGIPO').click(function(){
				 		metaType = $(this).attr('meta-type');
				 		// SAN, CAN, ...
				 		metaDoc = $(this).attr('meta-doc');
				 		metaComment = $(this).attr('meta-comment');
				 		metaForm = $(this).attr('meta-form');
				 		
				 		$('.taskStatusGIPO').css('border', '1px solid #000');
				 		$(this).css('border', '2px solid #00f');
				 		
				 		var offset = $(this).offset();
				 		
				 		$('#editStatusGIPO_name').text(""+metaForm +': ' + (""+metaDoc).toUpperCase());
				 		
				 		var id = '#' + metaForm + '_' + metaDoc;
				 		
				 		$('#editStatusGIPO_comment').val(metaComment);
				 		
				 		$('#editStatusGIPO_status').val(doc_types[$(id).text()]);
				 		$('#editStatusGIPO_status').css('background', $('#editStatusGIPO_status').find('option:selected').css('background'));

				 		offset.left += 100;
				 		if (offset.left > 900) offset.left = offset.left - 400;
				 		
				 		$('#editStatusGIPO').css('top', offset.top + "px");
				 		$('#editStatusGIPO').css('left', offset.left + "px");
				 		$('#editStatusGIPO').show();
				    });

			 		$('#editStatusGIPO_status').change(function(){
			 			$('#editStatusGIPO_status').css('background', $('#editStatusGIPO_status').find('option:selected').css('background'));
			 		});

					$("#closeeditStatusGIPO").click(function(){
						$('#editStatusGIPO').hide();
						$('.taskStatusGIPO').css('border', '1px solid #000');
					});

					$("#showHistoryGIPO").click(function(){

						$.getJSON("actions/loadHistory.php?type=" + metaType+"&doc=" + metaDoc+"&form="+metaForm+"&cl="+$("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
							
							$("#history").dialog({
								title: "History - "+metaForm +': ' + (""+metaDoc).toUpperCase(),
						        modal: true,
						        position: ['center', 'center'],
						        resizable : false,
						        draggable: true,
						        width:'auto'
							});

							if(data.length == 0){
								$('#historyText').text("No results.");
								return;
							}
					
						   	var table = '<table id="historytable">';
							table += '<thead>';
							table += '<th>Date</th>';
							table += '<th>User</th>';
							table += '<th>Status</th>';
							table += '<th>Comment</th>';
							table += '</thead>';

							table += '<tbody>';
							$.each(data, function(index, item) { 
						    	table +='<tr><td>' + formatDateTime(item.datetime) + '</td>';
						    	table +='<td>' + item.user + '</td>';
						    	table +='<td class='+item.status+'>' + item.status + '</td>';
						    	table +='<td>' + item.comment + '</td>';
						        table +='</tr>';
					        });
					        
							table += '</tbody>';
						    table += '</table>';

							$('#historyText').html(table);
						});
					});
						

					$("#submiteditStatusGIPO").click(function(){
						var value 	= $('#editStatusGIPO_status').val();

						$('.taskStatusGIPO').css('border', '1px solid #000');
						$.ajax({
							   type: "POST",
							   url: "actions/updateForm.php?type=" + metaType+"&doc=" + metaDoc+"&form="+metaForm+"&status="+value+"&period="+ $("#periodId").val(),
							   data: $('#editStatusGIPOForm').serialize(),
							   success: function(data){
									$('#editStatusGIPO_status').val(0);
									$('#editStatusGIPO_comment').val('');
									$('#editStatusGIPO').hide();

									var id = '#' + $.trim(metaForm) + '_' + $.trim(metaDoc);
									var obj = jQuery.parseJSON(data);
									
									$(id).attr('meta-comment',obj.comment);
									$(id).text(obj.status);
									$(id).removeClass();
									$(id).addClass('taskStatusGIPO');
									$(id).addClass(obj.status);

									$(id).attr('title', obj.comment);
									
									if(hasText(obj.comment)){
										$(id).addClass('comment');
									}

									noty({
										type: 'success',
										text: 'Form <strong>'+metaForm+'</strong> updated successfully.',
										timeout: '2000', 
									});
							   },
							   error : function(request, status, error) {

								   noty({
										type: 'error',
										text: request.responseText,
										timeout: '2000', 
									});
									$('#editStatusGIPO').hide();
								}
							 });
					});
		        }else{
			        //TODO: Implement CLs view.
		        }
		}else{
			$('#loadingIcon').hide();
			$('#loadingBox').dialog("close");
			$("#gipo").html("<p>No results found.</p>");
		}

        $('#loadingIcon').hide();
		$('#loadingBox').dialog("close");
	}
	
	
	function loadGIPi(data){

        console.log("Loading GIPi...");

		var tns = String(data);
		if(tns != ""){
				var table = '<table id="gipi_table">';
				table += '<thead><tr>';
				table += '<th rowspan="2">TN Id</th>';
				table += '<th rowspan="2">Organisation name</th>';
				table += '<th rowspan="2">Type</th>';
				table += '<th rowspan="2">Status</th>';
				table += '<th rowspan="2">RA</th>';
				table += '<th rowspan="2">MA</th>';
				table += '<th rowspan="2">RE</th>';
				table += '<th rowspan="2">End</th>';
				table += '<th rowspan="2">Contract</th>';
				table += '<th rowspan="2">&nbsp;EP_AN&nbsp;</th>';
				table += '<th rowspan="2">&nbsp;TN_AN&nbsp;</th>';
				table += '<th rowspan="2">RNE</th>';
				table += '<th rowspan="2">TR Checklist</th>';
				table += '<th colspan="20">Follow-up</th>';
				table += '<th rowspan="2">Visita fechamento</th>';
				table += '<th rowspan="2">EP Id</th>';
				table += '<th rowspan="2">EP</th>';
				table += '</tr>';

				table += '<tr>';
				table += '<th colspan="2">1st week</th>';
				table += '<th colspan="2">1st month</th>';
				table += '<th colspan="2">plus 45 days</th>';
				table += '<th colspan="2">plus 90 days</th>';
				table += '<th colspan="2">plus 135 days</th>';
				table += '<th colspan="2">plus 180 days</th>';
				table += '<th colspan="2">plus 225 days</th>';
				table += '<th colspan="2">plus 270 days</th>';
				table += '<th colspan="2">plus 315 days</th>';
				table += '<th colspan="2">plus 360 days</th>';
				table += '</tr>';
				table += '</tr></thead>';
											
				table += '<tbody>';
		        $.each(data, function(index, item) { /* add to html string started above*/
		        	//table += '<tr><td class=\'form fixed\' align="center"><a href=\'http://www.myaiesec.net/exchange/viewtn.do?operation=executeAction&tnId='+item.formId+'\' target="_blank">'+ item.id +'<a/></td>';
		            table +='<td><b>' + item.id + '</b></td>';
		            table +='<td><b>' + item.name + '</b></td>';
		            table +='<td class=\'extype '+item.type+'\'>' + item.type + '</td>';
		            table +='<td class=\'extype '+item.status+'\'>' + item.status + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtRA) + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtMA) + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtRE) + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtEND) + '</td>';

		            //CONTRACT
		            table +='<td id=\"'+$.trim(item.id)+'_contract\" style="min-width: 85px;" class=\'taskStatusGIPI '+item.contract+' ';
		            if(hasText(item.comment_contract)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-comment=\''+checkNull(item.comment_contract)+'\' meta-form=\''+$.trim(item.id)+'\' meta-doc=\'contract\' meta-type=\'icx_gip\'>' + checkNull(item.contract) + '</td>';

		            //SAN
		            table +='<td id=\"'+$.trim(item.id)+'_san\" class=\'taskStatusGIPI '+item.san+' ';
		            if(hasText(item.comment_san)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_san)+'\' meta-doc=\'san\' meta-type=\'icx_gip\'>' + checkNull(item.san) + '</td>';

		            //CAN
		            table +='<td id=\"'+$.trim(item.id)+'_can\" class=\'taskStatusGIPI '+item.can+' ';
		            if(hasText(item.comment_can)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_can)+'\' meta-doc=\'can\' meta-type=\'icx_gip\'>' + checkNull(item.can) + '</td>';

					//RNE			            
		            table +='<td id=\"'+$.trim(item.id)+'_rne\" class=\'taskStatusGIPI '+item.rne+' ';
		            if(hasText(item.comment_rne)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_rne)+'\' meta-doc=\'rne\' meta-type=\'icx_gip\'>' + checkNull(item.rne) + '</td>';

		            //TR Checklist
		            table +='<td id=\"'+$.trim(item.id)+'_tr_checklist\" class=\'taskStatusGIPI '+item.tr_checklist+' ';
		            if(hasText(item.comment_tr_checklist)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_tr_checklist)+'\' meta-doc=\'tr_checklist\' meta-type=\'icx_gip\'>' + checkNull(item.tr_checklist) + '</td>';

		            //Follow up 1st week
		            table +='<td class="dtForm">' + addDays(item.dtRE,7) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_1st_week\" class=\'taskStatusGIPI '+item.fu_1st_week+' ';
		            if(hasText(item.comment_fu_1st_week)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_1st_week)+'\' meta-doc=\'fu_1st_week\' meta-type=\'icx_gip\'>' + checkNull(item.fu_1st_week) + '</td>';
		            
		            //Follow up 1st month
		            table +='<td class="dtForm">' + addDays(item.dtRE,30) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_1st_month\" class=\'taskStatusGIPI '+item.fu_1st_month+' ';
		            if(hasText(item.comment_fu_1st_month)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_1st_month)+'\' meta-doc=\'fu_1st_month\' meta-type=\'icx_gip\'>' + checkNull(item.fu_1st_month) + '</td>';
		            
		            //Follow up plus 45 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,45) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_45\" class=\'taskStatusGIPI '+item.fu_plus_45+' ';
		            if(hasText(item.comment_fu_plus_45)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_45)+'\' meta-doc=\'fu_plus_45\' meta-type=\'icx_gip\'>' + checkNull(item.fu_plus_45) + '</td>';
		            
		            //Follow up plus 90 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,90) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_90\" class=\'taskStatusGIPI '+item.fu_plus_90+' ';
		            if(hasText(item.comment_fu_plus_90)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_90)+'\' meta-doc=\'fu_plus_90\' meta-type=\'icx_gip\'>' + checkNull(item.fu_plus_90) + '</td>';
		            
		            //Follow up plus 135 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,135) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_135\" class=\'taskStatusGIPI '+item.fu_plus_135+' ';
		            if(hasText(item.comment_fu_plus_135)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_135)+'\' meta-doc=\'fu_plus_135\' meta-type=\'icx_gip\'>' + checkNull(item.fu_plus_135) + '</td>';
		            
		            //Follow up plus 180 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,180) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_180\" class=\'taskStatusGIPI '+item.fu_plus_180+' ';
		            if(hasText(item.comment_fu_plus_180)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_180)+'\' meta-doc=\'fu_plus_180\' meta-type=\'icx_gip\'>' + checkNull(item.fu_plus_180) + '</td>';
		            
		            //Follow up plus 225 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,225) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_225\" class=\'taskStatusGIPI '+item.fu_plus_225+' ';
		            if(hasText(item.comment_fu_plus_225)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_225)+'\' meta-doc=\'fu_plus_225\' meta-type=\'icx_gip\'>' + checkNull(item.fu_plus_225) + '</td>';
		            
		            //Follow up plus 270 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,270) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_270\" class=\'taskStatusGIPI '+item.fu_plus_270+' ';
		            if(hasText(item.comment_fu_plus_270)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_270)+'\' meta-doc=\'fu_plus_270\' meta-type=\'icx_gip\'>' + checkNull(item.fu_plus_270) + '</td>';
		            
		            //Follow up plus 315 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,315) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_315\" class=\'taskStatusGIPI '+item.fu_plus_315+' ';
		            if(hasText(item.comment_fu_plus_315)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_315)+'\' meta-doc=\'fu_plus_315\' meta-type=\'icx_gip\'>' + checkNull(item.fu_plus_315) + '</td>';
		            
		            //Follow up plus 360 days
		            table +='<td class="dtForm">' + calculateFUDate(item.dtRE,360) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_plus_360\" class=\'taskStatusGIPI '+item.fu_plus_360+' ';
		            if(hasText(item.comment_fu_plus_360)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_plus_360)+'\' meta-doc=\'fu_plus_360\' meta-type=\'icx_gip\'>' + checkNull(item.fu_plus_360) + '</td>';

		            /*
		            * FIM FOLLOW-UPs
		            */

			        //Visita fechamento
		            table +='<td id=\"'+$.trim(item.id)+'_visita_fechamento\" class=\'taskStatusGIPI '+item.visita_fechamento+' ';
		            if(hasText(item.comment_visita_fechamento)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+item.comment_visita_fechamento+'\' meta-doc=\'visita_fechamento\' meta-type=\'icx_gip\'>' + checkNull(item.visita_fechamento) + '</td>';

		            table +='<td class=\'form\'>' +  checkNull(item.formMAId) + '</td>';
		            table +='<td>' +  checkNull(item.formMAName) + '</td>';
		            table +='</tr>';
		        });
				table += '</tbody>';
		        table += '</table>';

		        //$('.container').show(); 
		        //$("#tabs").show();
		        $("#gipi").html(table);

		        registerHover('taskStatusGIPI');

		        if(isAuditor === 1){ //Temp. disabling edit

			    	$('.taskStatusGIPI').click(function(){
				 		metaType = $(this).attr('meta-type');
				 		// SAN, CAN, ...
				 		metaDoc = $(this).attr('meta-doc');
				 		metaComment = $(this).attr('meta-comment');
				 		metaForm = $(this).attr('meta-form');
				 		
				 		$('.taskStatusGIPI').css('border', '1px solid #000');
				 		$(this).css('border', '2px solid #00f');
				 		
				 		var offset = $(this).offset();
				 		
				 		$('#editStatusGIPI_name').text(""+metaForm +': ' + (""+metaDoc).toUpperCase());
				 		
				 		var id = '#' + metaForm + '_' + metaDoc;
				 		
				 		$('#editStatusGIPI_comment').val(metaComment);
				 		
				 		$('#editStatusGIPI_status').val(doc_types[$(id).text()]);
				 		$('#editStatusGIPI_status').css('background', $('#editStatusGIPI_status').find('option:selected').css('background'));

				 		offset.left += 100;
				 		if (offset.left > 900) offset.left = offset.left - 400;
				 		
				 		$('#editStatusGIPI').css('top', offset.top + "px");
				 		$('#editStatusGIPI').css('left', offset.left + "px");
				 		$('#editStatusGIPI').show();
				    });

			 		$('#editStatusGIPI_status').change(function(){
			 			$('#editStatusGIPI_status').css('background', $('#editStatusGIPI_status').find('option:selected').css('background'));
			 		});

					$("#closeeditStatusGIPI").click(function(){
						$('#editStatusGIPI').hide();
						$('.taskStatusGIPI').css('border', '1px solid #000');
					});

					$("#showHistoryGIPI").click(function(){

						$.getJSON("actions/loadHistory.php?type=" + metaType+"&doc=" + metaDoc+"&form="+metaForm+"&cl="+$("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
							
							$("#history").dialog({
								title: "History - "+metaForm +': ' + (""+metaDoc).toUpperCase(),
						        modal: true,
						        position: ['center', 'center'],
						        resizable : false,
						        draggable: true,
						        width:'auto'
							});

							if(data.length == 0){
								$('#historyText').text("No results.");
								return;
							}
					
						   	var table = '<table id="historytable">';
							table += '<thead>';
							table += '<th>Date</th>';
							table += '<th>User</th>';
							table += '<th>Status</th>';
							table += '<th>Comment</th>';
							table += '</thead>';

							table += '<tbody>';
							$.each(data, function(index, item) { 
						    	table +='<tr><td>' + formatDateTime(item.datetime) + '</td>';
						    	table +='<td>' + item.user + '</td>';
						    	table +='<td class='+item.status+'>' + item.status + '</td>';
						    	table +='<td>' + item.comment + '</td>';
						        table +='</tr>';
					        });
					        
							table += '</tbody>';
						    table += '</table>';

							$('#historyText').html(table);
						});
					});
						

					$("#submiteditStatusGIPI").click(function(){
						var value 	= $('#editStatusGIPI_status').val();

						$('.taskStatusGIPI').css('border', '1px solid #000');
						$.ajax({
							   type: "POST",
							   url: "actions/updateForm.php?type=" + metaType+"&doc=" + metaDoc+"&form="+metaForm+"&status="+value+"&period="+ $("#periodId").val(),
							   data: $('#editStatusGIPIForm').serialize(),
							   success: function(data){
									$('#editStatusGIPI_status').val(0);
									$('#editStatusGIPI_comment').val('');
									$('#editStatusGIPI').hide();

									var id = '#' + $.trim(metaForm) + '_' + $.trim(metaDoc);
									var obj = jQuery.parseJSON(data);
									
									$(id).attr('meta-comment',obj.comment);
									$(id).text(obj.status);
									$(id).removeClass();
									$(id).addClass('taskStatusGIPI');
									$(id).addClass(obj.status);

									$(id).attr('title', obj.comment);
									
									if(hasText(obj.comment)){
										$(id).addClass('comment');
									}

									noty({
										type: 'success',
										text: 'Form <strong>'+metaForm+'</strong> updated successfully.',
										timeout: '2000', 
									});
							   },
							   error : function(request, status, error) {

								   noty({
										type: 'error',
										text: request.responseText,
										timeout: '2000', 
									});
									$('#editStatusGIPI').hide();
								}
							 });
					});
		        }else{
			        //TODO: Implement CLs view.
		        }
		}else{
			$('#loadingIcon').hide();
			$('#loadingBox').dialog("close");
			$("#gipi").html("<p>No results found.</p>");
		}

		 //GCDPo
        //loadGCDPo(gcdpo);
	}
	
	function loadGCDPo(data){

        console.log("Loading GCDPo...");

		var tns = String(data);
		if(tns != ""){
				var table = '<table id="gcdpo_table">';
				table += '<thead><tr>';
				table += '<th rowspan="2">EP Id</th>';
				table += '<th rowspan="2">Name</th>';
				table += '<th rowspan="2">Type</th>';
				table += '<th rowspan="2">Status</th>';
				table += '<th rowspan="2">RA</th>';
				table += '<th rowspan="2">MA</th>';
				table += '<th rowspan="2">RE</th>';
				table += '<th rowspan="2">End</th>';
				table += '<th rowspan="2">Contract</th>';
				table += '<th rowspan="2">&nbsp;EP_AN&nbsp;</th>';
				table += '<th rowspan="2">&nbsp;TN_AN&nbsp;</th>';
				table += '<th rowspan="2">EP Checklist</th>';
				table += '<th colspan="4">Follow-up</th>';
				table += '<th rowspan="2">TN Id</th>';
				table += '<th rowspan="2">TN</th>';
				table += '</tr>';

				table += '<tr>';
				table += '<th colspan="2">1st week</th>';
				table += '<th colspan="2">3rd week</th>';
				table += '</tr>';
				table += '</tr></thead>';
											
				table += '<tbody>';
		        $.each(data, function(index, item) { /* add to html string started above*/
		        	// table += '<tr><td class=\'form fixed\' align="center"><a href=\'http://http://www.myaiesec.net/exchange/viewep.do?operation=executeAction&epId='+item.formId+'\' target="_blank">'+ item.id +'<a/></td>';
		            table +='<td><b>' + item.id + '</b></td>';
		            table +='<td><b>' + item.name + '</b></td>';
		            table +='<td class=\'extype '+item.type+'\'>' + item.type + '</td>';
		            table +='<td class=\'extype '+item.status+'\'>' + item.status + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtRA) + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtMA) + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtRE) + '</td>';
		            table +='<td class="dtForm">' + formatDate(item.dtEND) + '</td>';

		            //CONTRACT
		            table +='<td id=\"'+$.trim(item.id)+'_contract\" style="min-width: 85px;" class=\'taskStatusGCDPO '+item.contract+' ';
		            if(hasText(item.comment_contract)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-comment=\''+checkNull(item.comment_contract)+'\' meta-form=\''+$.trim(item.id)+'\' meta-doc=\'contract\' meta-type=\'ogx_gcdp\'>' +  checkNull(item.contract) + '</td>';

		            //SAN
		            table +='<td id=\"'+$.trim(item.id)+'_san\" class=\'taskStatusGCDPO '+item.san+' ';
		            if(hasText(item.comment_san)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_san)+'\' meta-doc=\'san\' meta-type=\'ogx_gcdp\'>' +  checkNull(item.san) + '</td>';

		            //CAN
		            table +='<td id=\"'+$.trim(item.id)+'_can\" class=\'taskStatusGCDPO '+item.can+' ';
		            if(hasText(item.comment_can)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_can)+'\' meta-doc=\'can\' meta-type=\'ogx_gcdp\'>' +  checkNull(item.can) + '</td>';

		            //EP Checklist
		            table +='<td id=\"'+$.trim(item.id)+'_ep_checklist\" class=\'taskStatusGCDPO '+item.ep_checklist+' ';
		            if(hasText(item.comment_ep_checklist)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_ep_checklist)+'\' meta-doc=\'ep_checklist\' meta-type=\'ogx_gcdp\'>' +  checkNull(item.ep_checklist) + '</td>';

		            //Follow up 1st week
		            table +='<td class="dtForm">' + addDays(item.dtRE,7) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_1st\" class=\'taskStatusGCDPO '+item.fu_1st+' ';
		            if(hasText(item.comment_fu_1st)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_1st)+'\' meta-doc=\'fu_1st\' meta-type=\'ogx_gcdp\'>' +  checkNull(item.fu_1st) + '</td>';
		            
		            //Follow up 3rd week
		            table +='<td class="dtForm">' + addDays(item.dtRE,21) + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_fu_3rd\" class=\'taskStatusGCDPO '+item.fu_3rd+' ';
		            if(hasText(item.comment_fu_3rd)){
		            	table +='comment';
		            }
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+checkNull(item.comment_fu_3rd)+'\' meta-doc=\'fu_3rd\' meta-type=\'ogx_gcdp\'>' +  checkNull(item.fu_3rd) + '</td>';

		            table +='<td class=\'form\'>' +  checkNull(item.formMAId) + '</td>';
		            table +='<td>' +  checkNull(item.formMAName) + '</td>';
		            table +='</tr>';
		        });
				table += '</tbody>';
		        table += '</table>';

		        //$('.container').show(); 
		        //$("#tabs").show();
		        $("#gcdpo").html(table);

		        registerHover('taskStatusGCDPO');

		        if(isAuditor === 1){ //Temp. disabling edit

			    	$('.taskStatusGCDPO').click(function(){
				 		metaType = $(this).attr('meta-type');
				 		// SAN, CAN, ...
				 		metaDoc = $(this).attr('meta-doc');
				 		metaComment = $(this).attr('meta-comment');
				 		metaForm = $(this).attr('meta-form');
				 		
				 		$('.taskStatusGCDPO').css('border', '1px solid #000');
				 		$(this).css('border', '2px solid #00f');
				 		
				 		var offset = $(this).offset();
				 		
				 		$('#editStatusGCDPO_name').text(""+metaForm +': ' + (""+metaDoc).toUpperCase());
				 		
				 		var id = '#' + metaForm + '_' + metaDoc;
				 		
				 		$('#editStatusGCDPO_comment').val(metaComment);
				 		
				 		$('#editStatusGCDPO_status').val(doc_types[$(id).text()]);
				 		$('#editStatusGCDPO_status').css('background', $('#editStatusGCDPO_status').find('option:selected').css('background'));

				 		offset.left += 100;
				 		if (offset.left > 900) offset.left = offset.left - 400;
				 		
				 		$('#editStatusGCDPO').css('top', offset.top + "px");
				 		$('#editStatusGCDPO').css('left', offset.left + "px");
				 		$('#editStatusGCDPO').show();
				    });

			 		$('#editStatusGCDPO_status').change(function(){
			 			$('#editStatusGCDPO_status').css('background', $('#editStatusGCDPO_status').find('option:selected').css('background'));
			 		});

					$("#closeeditStatusGCDPO").click(function(){
						$('#editStatusGCDPO').hide();
						$('.taskStatusGCDPO').css('border', '1px solid #000');
					});

					$("#showHistoryGCDPO").click(function(){

						$.getJSON("actions/loadHistory.php?type=" + metaType+"&doc=" + metaDoc+"&form="+metaForm+"&cl="+$("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
							
							$("#history").dialog({
								title: "History - "+metaForm +': ' + (""+metaDoc).toUpperCase(),
						        modal: true,
						        position: ['center', 'center'],
						        resizable : false,
						        draggable: true,
						        width:'auto'
							});

							if(data.length == 0){
								$('#historyText').text("No results.");
								return;
							}
					
						   	var table = '<table id="historytable">';
							table += '<thead>';
							table += '<th>Date</th>';
							table += '<th>User</th>';
							table += '<th>Status</th>';
							table += '<th>Comment</th>';
							table += '</thead>';

							table += '<tbody>';
							$.each(data, function(index, item) { 
						    	table +='<tr><td>' + formatDateTime(item.datetime) + '</td>';
						    	table +='<td>' + item.user + '</td>';
						    	table +='<td class='+item.status+'>' + item.status + '</td>';
						    	table +='<td>' + item.comment + '</td>';
						        table +='</tr>';
					        });
					        
							table += '</tbody>';
						    table += '</table>';

							$('#historyText').html(table);
						});
					});
						

					$("#submiteditStatusGCDPO").click(function(){
						var value 	= $('#editStatusGCDPO_status').val();

						$('.taskStatusGCDPO').css('border', '1px solid #000');
						$.ajax({
							   type: "POST",
							   url: "actions/updateForm.php?type=" + metaType+"&doc=" + metaDoc+"&form="+metaForm+"&status="+value+"&period="+ $("#periodId").val(),
							   data: $('#editStatusGCDPOForm').serialize(),
							   success: function(data){
									$('#editStatusGCDPO_status').val(0);
									$('#editStatusGCDPO_comment').val('');
									$('#editStatusGCDPO').hide();

									var id = '#' + $.trim(metaForm) + '_' + $.trim(metaDoc);
									var obj = jQuery.parseJSON(data);
									
									$(id).attr('meta-comment',obj.comment);
									$(id).text(obj.status);
									$(id).removeClass();
									$(id).addClass('taskStatusGCDPO');
									$(id).addClass(obj.status);

									$(id).attr('title', obj.comment);
									
									if(hasText(obj.comment)){
										$(id).addClass('comment');
									}

									noty({
										type: 'success',
										text: 'Form <strong>'+metaForm+'</strong> updated successfully.',
										timeout: '2000', 
									});
							   },
							   error : function(request, status, error) {

								   noty({
										type: 'error',
										text: request.responseText,
										timeout: '2000', 
									});
									$('#editStatusGCDPO').hide();
								}
							 });
					});
		        }else{
			        //TODO: Implement CLs view.
		        }
		}else{
			$('#loadingIcon').hide();
			$('#loadingBox').dialog("close");
			$("#gcdpo").html("<p>No results found.</p>");
		}
	}
	
	function loadLegal(data){
		console.log("Loading Legal...");

		var tns = String(data);
		if(tns != ""){
			var table = '<table id="legaltable">';
			table += '<thead>';
			table += '<th>Item</th>';
			table += '<th>Status</th>';
			table += '</thead>';
			table += '<tbody>';
			$.each(data, function(index, item) { 
				table +='<tr><td>' + item.name + '</td>';
				table +='<td id=\"'+$.trim(item.id)+'_statusLegal\" class=\'taskStatusLegal '+item.status+' ';
				if(hasText(item.comment)){
					table +='comment';
				}	
				table += '\' '; 
				table +='meta-form=\''+item.name+'\' meta-comment=\''+checkNull(item.comment)+'\' meta-doc=\'status\' meta-type=\'status\'>' + item.status + '</td>';
				table +='</tr>';
			});
			table += '</tbody>';
			table += '</table>'; 
			$("#legal").html(table);

			registerHover('taskStatusLegal');

			if(isAuditor === 1){

				$('.taskStatusLegal').click(function(){
					metaId = $(this).attr('id');
					metaType = $(this).attr('meta-type');
					metaComment = $(this).attr('meta-comment');
					metaDoc = $(this).attr('meta-doc');
					//alert("metaDoc: "+metaDoc);
					metaForm = $(this).attr('meta-form');
					//alert(metaForm);
					
					$('.taskStatusLegal').css('border', '1px solid #000');
					$(this).css('border', '2px solid #00f');
					
					var offset = $(this).offset();

					$('#editStatusLegal_comment').val(metaComment);
					
					$('#editStatusLegal_name').text(""+metaForm +': ' + (""+metaDoc).toUpperCase());

					var id="#"+metaId;

					$('#editStatusLegal_status').val(doc_types[$(id).text()]);
					$('#editStatusLegal_status').css('background', $('#editStatusLegal_status').find('option:selected').css('background'));

					offset.left += 100;
					if (offset.left > 900) offset.left = offset.left - 400;
					
					$('#editStatusLegal').css('top', offset.top + "px");
					$('#editStatusLegal').css('left', offset.left + "px");
					$('#editStatusLegal').show();
				});

				$('#editStatusLegal_status').change(function(){
					$('#editStatusLegal_status').css('background', $('#editStatusLegal_status').find('option:selected').css('background'));
				});

				$("#closeEditStatusLegal").click(function(){
					$('#editStatusLegal').hide();
					$('.taskStatusLegal').css('border', '1px solid #000');
				});

				$("#showHistoryLegal").click(function(){

					$.getJSON("actions/loadHistoryLegal.php?type=" + metaType+"&doc=" + metaDoc+"&form="+metaForm+"&cl="+$("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
						
						$("#history").dialog({
							title: "History - "+metaForm +': ' + (""+metaDoc).toUpperCase(),
							modal: true,
							position: ['center', 'center'],
							resizable : false,
							draggable: true,
							width:'auto'
						});

						if(data.length == 0){
							$('#historyText').text("No results.");
							return;
						}
				
						var table = '<table id="historytable">';
						table += '<thead>';
						table += '<th>Date</th>';
						table += '<th>User</th>';
						table += '<th>Status</th>';
						table += '<th>Comment</th>';
						table += '</thead>';

						table += '<tbody>';
						$.each(data, function(index, item) { 
							table +='<tr><td>' + item.datetime + '</td>';
							table +='<td>' + item.user + '</td>';
							table +='<td class='+item.status+'>' + item.status + '</td>';
							table +='<td>' + item.comment + '</td>';
							table +='</tr>';
						});
						
						table += '</tbody>';
						table += '</table>'; 
						$('#historyText').html(table);
					});
				});
					
				$("#submitEditStatusLegal").click(function(){
					var value = $('#editStatusLegal_status').val();

					$('.taskStatusLegal').css('border', '1px solid #000');
					$.ajax({
						   type: "POST",
						   url: "updateLegal.php?type=" + metaType+"&doc=" + metaDoc+"&form="+metaForm+"&status="+value+"&cl="+$("#clId").val() +"&period="+ $("#periodId").val(),
						   data: $('#editStatusLegalForm').serialize(),
						   success: function(data){
								$('#editStatusLegal_status').val(0);
								$('#editStatusLegal_comment').val('');
								$('#editStatusLegal').hide();

								//var id = '#' + metaForm + '_' + metaDoc;
								var id="#"+metaId;

								var obj = jQuery.parseJSON(data);

								$(id).attr('meta-comment', obj.comment);
								$(id).attr('title', obj.comment);
								$(id).text(obj.status);
								$(id).removeClass();
								$(id).addClass('taskStatusLegal');
								$(id).addClass(obj.status);
								
								if(hasText(obj.comment)){
									$(id).addClass('comment');
								}

								noty({
									type: 'success',
									text: 'Form <strong>'+metaForm+'</strong> updated successfully.',
									timeout: '4000', 
								});
						   },
						   error : function(request, status, error) {

							   noty({
									type: 'error',
									text: request.responseText,
									timeout: '2000', 
								});
								$('#editStatus').hide();
							}
						 });
					});
				}else{
					//TODO: Implement CLs View.
					//alert("Implement CLs View. Legal.");
				}
		}else{
			$('#loadingIcon').hide();
			$('#loadingBox').dialog("close");
			$("#legal").html("<p>No results found.</p>");
		}
	}

	function loadTerms(data){

		console.log("Loading Terms...");

		var tns = String(data);
		if(tns != ""){
			var table = '<table class="datatableThin" id="termstable">';
			table += '<thead>';
			table += '<th>Name</th>';
			table += '<th>Status</th>';
			table += '</thead>';
			table += '<tbody>';
				$.each(data, function(index, item) {
					table +='<tr><td>' + item.name + '</td>';
					table +='<td id=\"'+$.trim(item.id)+'_statusTerm\" class=\'taskStatusTerm '+item.status+' ';

					if(hasText(item.comment)){
						table +='comment';
					}
					
					table += '\' '; //Closing class attr.
					
					table +='meta-form=\''+item.name+'\' meta-comment=\''+checkNull(item.comment)+'\' meta-doc=\'status\' meta-type=\'status\'>' + item.status + '</td>';
					table +='</tr>';
				});
				table += '</tbody>';
				table += '</table>'; 
				$("#term").html(table);

				$('.comment').mouseover(function(){
					metaComment = $(this).attr('meta-comment');

					$(".comment").attr("title", metaComment).tooltip({
						showURL: false,
						fixPNG: true,
						track:true,
						delay:0
					});
				});

				if(isAuditor === 1){

					$('.taskStatusTerm').click(function(){
						metaId = $(this).attr('id');
						metaType = $(this).attr('meta-type');
						metaComment = $(this).attr('meta-comment');
						// SAN, CAN, ...
						metaDoc = $(this).attr('meta-doc');
						metaForm = $(this).attr('meta-form');
						
						$('.taskStatusTerm').css('border', '1px solid #000');
						$(this).css('border', '2px solid #00f');
						
						var offset = $(this).offset();

						$('#editStatusTerm_comment').val(metaComment);
						
						$('#editStatusTerm_name').text(""+metaForm +': ' + (""+metaDoc).toUpperCase());
						
						//var id = '#' + metaForm + '_' + metaDoc;
						var id="#"+metaId;

						$('#editStatusTerm_status').val(doc_types[$(id).text()]);
						$('#editStatusTerm_status').css('background', $('#editStatusTerm_status').find('option:selected').css('background'));
						
						offset.left += 100;
						if (offset.left > 900) offset.left = offset.left - 400;
						
						$('#editStatusTerm').css('top', offset.top + "px");
						$('#editStatusTerm').css('left', offset.left + "px");
						$('#editStatusTerm').show();
					});

					$('#editStatusTerm_status').change(function(){
						$('#editStatusTerm_status').css('background', $('#editStatusTerm_status').find('option:selected').css('background'));
					});

					$("#closeEditStatusTerm").click(function(){
						$('#editStatusTerm').hide();
						$('.taskStatusTerm').css('border', '1px solid #000');
					});

					$("#showHistoryTerm").click(function(){

						$.getJSON("actions/loadHistoryTerm.php?type=" + metaType+"&form="+metaForm+"&cl="+$("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
							
							$("#history").dialog({
								title: "History - "+metaForm,
								modal: true,
								position: ['center', 'center'],
								resizable : false,
								draggable: true,
								width:'auto'
							});

							if(data.length == 0){
								$('#historyText').text("No results.");
								return;
							}
					
							var table = '<table id="historytable">';
							table += '<thead>';
							table += '<th>Date</th>';
							table += '<th>User</th>';
							table += '<th>Status</th>';
							table += '<th>Comment</th>';
							table += '</thead>';

							table += '<tbody>';
							$.each(data, function(index, item) {
								table +='<tr><td>' + item.datetime + '</td>';
								table +='<td>' + item.user + '</td>';
								table +='<td class='+item.status+'>' + item.status + '</td>';
								table +='<td>' + item.comment + '</td>';
								table +='</tr>';
							});
							table += '</tbody>';
							
							table += '</table>'; 
							$('#historyText').html(table);
						});
					});

					$("#submitEditStatusTerm").click(function(){
						var value = $('#editStatusTerm_status').val();

						$('.taskStatusTerm').css('border', '1px solid #000');
						$.ajax({
							   type: "POST",
							   url: "updateTerm.php?type=" + metaType+"&doc=" + metaDoc+"&form="+normalizeString(metaForm)+"&status="+value+"&cl="+$("#clId").val() +"&period="+ $("#periodId").val(),
							   data: '', 
							   success: function(data){
									$('#editStatusTerm_status').val(0);
									$('#editStatusTerm_comment').val('');
									$('#editStatusTerm').hide();

									//var id = '#' + metaForm + '_' + metaDoc;
									var id="#"+metaId;

									var obj = jQuery.parseJSON(data);

									$(id).attr('meta-comment',obj.comment);
									$(id).text(obj.status);
									$(id).removeClass();
									$(id).addClass('taskStatusTerm');
									$(id).addClass(obj.status);

									$(id).attr('title', obj.comment);
									
									if(hasText(obj.comment)){
										$(id).addClass('comment');
									}

									noty({
										type: 'success',
										text: 'Form <strong>'+metaForm+'</strong> updated successfully.',
										timeout: '4000', 
									});
							   },
							   error : function(request, status, error) {

								   noty({
										type: 'error',
										text: request.responseText,
										timeout: '2000', 
									});
									$('#editStatus').hide();
								}
							 });
						});
					}else{
						//TODO: Implement CLs View.
						//alert("Implement CLs View. Legal.");
					}
			}else{
				$("#term").html("<p>No results found.</p>");
			}

			//Set datatables
			
			var tables = new Array();
			$('.datatable').each(function(n){
				//alert(this + " "+this.id +" "+n);
				tables[n] = $(this).dataTable( {
					"sScrollX": "100%",
					"sScrollXInner": "150%",
					"bScrollCollapse": true,
					"bPaginate": true
				});

				//new FixedHeader( tables[n] );

				//new FixedColumns( tables[0] );
			});
			
			var tablesThin = new Array();
			$('.datatableThin').each(function(n){
				//alert(this + " "+this.id +" "+n);
				tablesThin[n] = $(this).dataTable( {
					"bPaginate": false
				});
			});

			$('#loadingIcon').hide();
			$('#loadingBox').dialog("close");
	}
	
	function loadForms(){
		$("#tabs").tabs('select', 0);

		$('#result').text("");

		$("#loadingBox").dialog({
			title: "ADT - AuDit Tool",
	        modal: true,
	        resizable : false,
	        draggable: false
		});
		
        $('#loadingIcon').show();
        
        $('#status').text("Loading details...");

        //loadConclusions();
         
        $.getJSON("actions/loadForms.php?cl=" + $("#clId").val() +"&period="+ $("#periodId").val(), function(data) {

        	isMonthly = data.isMonthly;
        	
        	if(data.isMonthly == 1){
        		loadSummaryMonthly();
				loadGCDPi(data.gcdpi);
	            loadGCDPo(data.gcdpo);
	            loadGIPi(data.gipi);
	            loadGIPo(data.gipo);
	            
            	$('#li_gcdpo').show();
            	$('#li_gcdpi').show();
            	$('#li_gipo').show();
            	$('#li_gipi').show();
            	$('#li_term').hide();
            	$('#li_legal').hide();
        	}else{
            	$('#li_gcdpo').hide();
            	$('#li_gcdpi').hide();
            	$('#li_gipo').hide();
            	$('#li_gipi').hide();
            	$('#li_term').show();
            	$('#li_legal').show();
            	//TODO: Implement a different loadSummary
        		loadSummary();
            	loadTerms(data.terms);
            	loadLegal(data.legal);
        	}

        	$('.container').show(); 
	        $("#tabs").show();
		});
	}

	function validateShowForms(){
		if($("#clId").val() == 0 || $("#periodId").val() == 0){
			alert("Oops.. Select a CL and period before Go, dude.");
			return false;
		}
		
	    return true;
    }
	
});
			
</script>

</body>
</html>
