<?php
header('Content-Type: text/html; charset=utf-8');

require_once 'include.php';

Util::requireLogin();

?>

<html>
<head>
<title>ADT Tool (alpha) - AIESEC in Brazil</title>

<link rel="stylesheet" type="text/css" href="res/css/demo_table.css" />
<link rel="stylesheet" type="text/css" href="res/css/demo_page.css" />
<link rel="stylesheet" type="text/css" href="res/css/header.ccss.css" />
<link rel="stylesheet" type="text/css"
	href="res/css/smoothness/jquery-ui-1.9.1.custom.css" />
<link rel="stylesheet" type="text/css" href="res/css/header.css" />
<link rel="stylesheet" type="text/css" href="res/css/styles.css" />

<script src="res/js/jquery-1.8.2.js"></script>
<script src="res/js/jquery-ui-1.9.1.custom.js"></script>
<!-- script src="res/js/jquery.simplemodal.1.4.4.min.js"></script -->

<script src="res/js/jquery.noty.js"></script>
<script src="res/js/jquery.noty.top.js"></script>
<script src="res/js/jquery.noty.default.js"></script>

<script src="res/js/FixedColumns.js"></script>

<script src="res/js/jquery.jeditable.js"></script>
<script src="res/js/jquery.dataTables.js"></script>
<script src="res/js/jquery.jeditable.ajaxupload.js"></script>
<script src="res/js/jquery.ajaxfileupload.js"></script>

<script src="res/js/extended.js"></script>

</head>
<body>
	<?php include("header.php"); ?>
	<div class="container" style="display:none">
		<br />
		<div id="result" align="center"></div>

		<div id="tabs" style="padding: 15px">
			<ul>
				<li><a href="#summary"><span>Summary</span> </a>
				</li>
				<li><a href="#icx"><span>ICX</span> </a>
				</li>
				<li><a href="#ogx"><span>OGX</span> </a>
				</li>
				<li><a href="#legal"><span>Legal</span> </a>
				</li>
				<li><a href="#term"><span>Terms</span> </a>
				</li>
				<!-- li><a href="#evaluation"><span>Evaluations</span> </a>
				</li -->
				<li><a href="#conclusion"><span>Conclusions</span> </a>
				</li>
			</ul>
			<div id="summary" align="center"></div>
			<div id="icx" align="center"></div>
			<div id="ogx" align="center"></div>
			<div id="legal" align="center"></div>
			<div id="term" align="center"></div>
			<!-- div id="evaluation" align="center"></div -->
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

		<div id="editStatus"
			style="padding: 5px; border: 1px solid black; position: absolute; width: 300px; height: 200px; background: #fff; display: none;">
			<h3 id="editStatus_name"></h3>
			<form id="editStatusForm">
				<table>
					<tr>
						<td>Status:</td>
						<td style="text-align: left;"><select name="status"
							id="editStatus_status">
								<option value="0">- Select -</option>
						</select>
						</td>
					</tr>
					<tr>
						<td>Comment:</td>
						<td><textarea style="width: 200px; height: 50px;"
								id="editStatus_comment" name="editStatus_comment"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="Update"
							id="submiteditStatus" /> <input type="button"
							id="closeeditStatus" value="Cancel" /> <input type="button"
							id="showHistory" value="Show history" /> <input type="hidden"
							value="1" id="editStatus_updated" /> <br /> <!-- a href=""
							target="_blank" style="float: left;" id="historylink">Show
								history</a -->
						</td>
					</tr>

				</table>
			</form>
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
								name="editStatusLegal_comment" id="editStatusLegal_comment"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="Update"
							id="submitEditStatusLegal" /> <input type="button"
							id="closeEditStatusLegal" value="Cancel" /> <input type="button"
							id="showHistoryLegal" value="Show history" /> <input type="hidden"
							value="1" id="editStatusLegal_updated" /> <br /> 
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
								name="editStatusTerm_comment" id="editStatusTerm_comment"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="Update"
							id="submitEditStatusTerm" /> <input type="button"
							id="closeEditStatusTerm" value="Cancel" />  <input type="button"
							id="showHistoryTerm" value="Show history" /> <input type="hidden"
							value="1" id="editStatusTerm_updated" /> <br /> <!-- a href=""
							target="_blank" style="float: left;" id="historylink">Show
								history</a -->
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
	var doc_types = new Array();

	var reloading = false;

	var isAuditor = 0;

	$('#loadingIcon').hide();
	$("#tabs").tabs();
	$("#tabs").hide();

	$.getJSON("startupNPM.php", function(result) {
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
		    

	    var options = $("#editStatus_status");
	    var optionsLegal = $("#editStatusLegal_status");
	    var optionsTerm = $("#editStatusTerm_status");
	    $.each(result.docStatus, function() {
	        options.append($("<option style=\'background:"+this.color+"\'/>").val(this.id).text(this.status));
	        optionsLegal.append($("<option style=\'background:"+this.color+"\'/>").val(this.id).text(this.status));
	        optionsTerm.append($("<option style=\'background:"+this.color+"\'/>").val(this.id).text(this.status));
	        doc_types[this.status] = this.id;
	    });
	});

	$( "#ui-id-1" ).click(function() {
		$('#editStatus').hide();	
		$('.taskStatusICX').css('border', '1px solid #000');
		$('.taskStatusOGX').css('border', '1px solid #000');
		
		$('#editStatusLegal').hide();
		$('.taskStatusLegal').css('border', '1px solid #000');

		$('#editStatusTerm').hide();	
		$('.taskStatusTerm').css('border', '1px solid #000');
		
		prepareLoadSummary();
	} );

	//ICX
	$( "#ui-id-2" ).click(function() {
		$('#editStatusLegal').hide();
		$('.taskStatusLegal').css('border', '1px solid #000');
			
		$('#editStatusTerm').hide();	
		$('.taskStatusTerm').css('border', '1px solid #000');
	});

	//OGX
	$( "#ui-id-3" ).click(function() {
		$('#editStatusLegal').hide();
		$('.taskStatusLegal').css('border', '1px solid #000');
			
		$('#editStatusTerm').hide();
		$('.taskStatusTerm').css('border', '1px solid #000');	
	});

	//Legal
	$( "#ui-id-4" ).click(function() {
		$('#editStatus').hide();
		$('.taskStatus').css('border', '1px solid #000');
			
		$('#editStatusTerm').hide();
		$('.taskStatusTerm').css('border', '1px solid #000');	
	});

	//Term
	$( "#ui-id-5" ).click(function() {
		$('#editStatus').hide();	
		$('.taskStatus').css('border', '1px solid #000');
		
		$('#editStatusLegal').hide();
		$('.taskStatusLegal').css('border', '1px solid #000');	
	});
	
	//Conclusions
	$( "#ui-id-6" ).click(function() {
		$('#editStatus').hide();	
		$('.taskStatus').css('border', '1px solid #000');
		
		$('#editStatusLegal').hide();
		$('.taskStatusLegal').css('border', '1px solid #000');

		$('#editStatusTerm').hide();	
		$('.taskStatusTerm').css('border', '1px solid #000');

		//prepareLoadConc();	
	});

	$("#bot").click(function() {
		if (validateShowForms()){
   			loadForms();
		}
	});

	function formatDate(val) {
	    val = $.trim(val);
	    return (val == undefined || val == '') ? "" : val;
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
		
		loadSummary();
	}
	
	function prepareLoadConc() {
		console.log("Reloading conclusions..");
		
		reloading = true;
		
		$("#loadingBox").dialog({
			title: "ADT - AuDit Tool",
	        modal: true,
	        resizable : false,
	        draggable: false
		});
		
        $('#loadingIcon').show();
        
        $('#status').text("Reloading conclusions...");
		
        loadConclusions();
	}

	$("#saveConclusions").click(function(){
		var conclusao = $('#conc').val();
		var melhoria = $('#melhoria').val();
		var atencao = $('#atencao').val();

		$.ajax({
			   type: "POST",
			   url: "updateConc.php?conclusao=" + conclusao+"&melhoria=" + melhoria+"&atencao="+atencao+"&cl="+$("#clId").val() +"&period="+ $("#periodId").val(),
			   success: function(data){
					noty({
						type: 'success',
						text: 'Conclusions updated successfully.',
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
	
	function loadEvaluations(){

		$("#evaluation").html("");

		console.log("Loading Evaluation...");
		
		$.getJSON("loadEvaluations.php?cl=" + $("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
			var summary = String(data);
			//alert(data.ne);
			if(summary != ""){

				 	$.each(data, function(type, item) {
	
						var table = '<div align="left"><table id="'+type+'summarytable">';
						table += '<thead>';
						table += '<tr>';
						table += '<td colspan="2"><b>'+type.toUpperCase()+'</b></td>';
						table += '</tr>';
						table += '<tr>';
						table += '<td>form</td>';
						table += '<td>name</td>';
						table += '</tr>';
						table += '</thead>';
						table += '<tbody>';
	
				        $.each(data[type], function(index, item) { 
					        //alert(item[0]);
				        	table +='<tr>';
				            table +='<td>' + item[0] + '</td>';
				            table +='<td>' + item[1] + '</td>';
				            table +='</tr>';
				        });
						table += '</tbody>';
				        table += '</table></div>'; 
				        //alert(table);
			        
				        $("#evaluation").append(table);
				        
				 	});
	        }else{
		        //alert("No summary data.");
			}
		});
	}
	function loadSummary(){

		$("#summary").html("");

		console.log("Loading Summary...");
		
		$.getJSON("loadSummary.php?cl=" + $("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
			var summary = String(data);
			//alert(data.ne);
			if(summary != ""){

					var summary = '<table id="summarytable" style="float:left;">';
					summary += '<thead>';
					summary += '<tr>';
					summary += '<td><b>Audit</b></td>';
					summary += '<td><b>Requested</b></td>';
					summary += '<td><b>Delivered</b></td>';
					summary += '<td><b>%</b></td>';
					summary += '<td><b>Correct</b></td>';
					summary += '<td><b>%</b></td>';
					summary += '<td><b>Fee</b></td>';
					summary += '</tr>';
					summary += '</thead>';
					summary += '<tbody>';

					var totalSolicitados = 0;
					var totalEntregues = 0;
					var totalAceitos = 0;
					var totalMulta = 0;

					var totalNE = 0;
					var totalNA = 0;
					var totalOK = 0;

					var valor_multa = 10;
					
				 	$.each(data, function(type, item) {

					 	if (type == 'icx' || type == 'ogx'){
							var table = '<table id="'+type+'summarytable" style="float:right;">';
							table += '<thead>';
							table += '<tr>';
							table += '<td colspan="4"><b>'+type.toUpperCase()+'</b></td>';
							table += '</tr>';
							table += '<tr>';
							table += '<td>doc</td>';
							table += '<td class=\'ne\'>NE</td>';
							table += '<td class=\'na\'>NA</td>';
							table += '<td class=\'ok\'>OK</td>';
							table += '</tr>';
							table += '</thead>';
							table += '<tbody>';
		
							totalNE = 0;
					        $.each(data[type].ne, function(index, item) { 
						        //alert(item[0]);
					        	table +='<tr>';
					            table +='<td>' + item[0] + '</td>';
					            table +='<td class=\'ne\'>' + formatNum(item[1]) + '</td>';
					            table +='<td id=\''+item[0]+'_na_'+type+'\' class=\'na\'></td>';
					            table +='<td id=\''+item[0]+'_ok_'+type+'\' class=\'ok\'></td>';
					            table +='</tr>';
					            totalNE += parseInt(formatNum(item[1]));
					        });
							table += '<tr>';
							table += '<td><b>total</b></td>';
							table += '<td class=\'ne\'><b>'+totalNE+'</b></td>';
							table += '<td id=\'total_na_'+type+'\' class=\'na\'></td>';
							table += '<td id=\'total_ok_'+type+'\' class=\'ok\'></td>';
							
							table += '</tr>';
							
							table += '</tbody>';
					        table += '</table>'; 
					        //alert(table);
				        
					        $("#summary").append(table);
	
							totalNA = 0;
					        $.each(data[type].na, function(index, item) {
						        $('#'+item[0]+'_na_'+type).text(formatNum(item[1])); 
						        totalNA += parseInt(formatNum(item[1]));
					        });
					        $('#total_na_'+type).html('<b>'+totalNA+'</b>'); 
					        
							totalOK = 0;
					        $.each(data[type].ok, function(index, item) {
						        $('#'+item[0]+'_ok_'+type).text(formatNum(item[1])); 
						        totalOK += parseInt(formatNum(item[1]));
					        });
					        $('#total_ok_'+type).html('<b>'+totalOK+'</b>');
						}

						if(type == 'term'){
							valor_multa = 5;
							totalNE = parseInt(data[type]['ne']);  	
							totalNA = parseInt(data[type]['na']); 	
							totalOK = parseInt(data[type]['ok']);
					 	}

						var solicitados = 0;
						var entregues = 0;
						var percEntr = 0;
						var percOK = 0;
						var multa = 0;
						
						totalSolicitados += solicitados;
						totalEntregues += entregues;
						totalAceitos += totalOK;
						totalMulta += multa;
						
					 	if (type == 'icx' || type == 'ogx' || type == 'term'){
					 		solicitados = totalNE + totalNA + totalOK;
							entregues = totalOK + totalNA;
							percEntr = ((entregues / solicitados) * 100).toFixed(2);
							percOK = ((totalOK / solicitados) * 100).toFixed(2);
							multa = valor_multa * (totalNE + totalNA).toFixed(2);
							
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

							solicitados = totalNE + totalNE2 + totalNA + totalNA2 + totalOK;
							entregues = totalOK + totalNA + totalNA2;
							percEntr = ((entregues / solicitados) * 100).toFixed(2);
							percOK = ((totalOK / solicitados) * 100).toFixed(2);
							multa = (( valor_multa * (totalNE + totalNA) + valor_mc_fee * (totalNE2 + totalNA2))).toFixed(2);
							
							totalSolicitados += solicitados;
							totalEntregues += entregues;
							totalAceitos += totalOK;
							totalMulta = parseFloat(totalMulta) + parseFloat(multa);
					 	}

						summary +='<tr>';
						summary +='<td><b>' + type.toUpperCase() + '</b></td>';
						summary +='<td>' + solicitados + '</td>';
						summary +='<td>' + entregues + '</td>';
						summary +='<td>' + percEntr + '%</td>';
						summary +='<td><b>' + totalOK + '</b></td>';
						summary +='<td><b>' + percOK + '%</b></td>';
						summary +='<td>R$ ' + multa + '</td>';
						summary +='</tr>';
				        
				 	});

				 	var totalPercEntr = ((totalEntregues / totalSolicitados) * 100).toFixed(2);
					var totalPercOK = ((totalAceitos / totalSolicitados) * 100).toFixed(2);

					summary +='<tr>';
					summary +='<td><b>Total</b></td>';
					summary +='<td>' + totalSolicitados + '</td>';
					summary +='<td>' + totalEntregues + '</td>';
					summary +='<td>' + totalPercEntr + '%</td>';
					summary +='<td><b>' + totalAceitos + '</b></td>';
					summary +='<td><b>' + totalPercOK + '%</b></td>';
					summary +='<td><b>R$ ' + totalMulta + '</b></td>';
					summary +='</tr>';
				 	
					summary += '</tbody>';
		            summary += '</table>';
		             
					$("#summary").append(summary);

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
	
	function loadTerms(){

		console.log("Loading Terms...");

        $.getJSON("loadTerm.php?cl=" + $("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
			var tns = String(data);
			//alert(tns);
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
		            
		            table +='meta-form=\''+item.name+'\' meta-comment=\''+formatDate(item.comment)+'\' meta-doc=\'status\' meta-type=\'status\'>' + item.status + '</td>';
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
				 		// EP or TN
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

				 		//TODO: Fix it...
				 		//$('#historylink').attr('href', 'index.php?page=checklist_history&bus=' + truckid + '&taskid=' + taskid);
				 		
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

						$.getJSON("loadHistoryTerm.php?type=" + metaType+"&form="+metaForm+"&cl="+$("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
							
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
							   url: "updateTerm.php?type=" + metaType+"&doc=" + metaDoc+"&form="+metaForm+"&status="+value+"&cl="+$("#clId").val() +"&period="+ $("#periodId").val(),
							   data: $('#editStatusTermForm').serialize(),
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
		});
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

        //Load Summary
        loadSummary();

        //Load conclusions
        loadConclusions(); 

        //Load Evaluations
        //loadEvaluations();

        //Load terms();
        //loadTerms();

        $.getJSON("loadTNs.php?cl=" + $("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
			var tns = String(data);
			if(tns != ""){
					var table = '<table class="datatable" id="icxtable">';
					table += '<thead>';
					table += '<th>TN Id</th>';
					table += '<th>Organisation name</th>';
					table += '<th>Type</th>';
					table += '<th>Status</th>';
					table += '<th>RA</th>';
					table += '<th>MA</th>';
					table += '<th>RE</th>';
					table += '<th>End</th>';
					table += '<th>Contract</th>';
					table += '<th>SAN</th>';
					table += '<th>CAN</th>';
					table += '<th>RNE</th>';
					table += '<th>TN1</th>';
					table += '<th>TN2</th>';
					table += '<th>TN3</th>';
					table += '<th>TR1</th>';
					table += '<th>TR2</th>';
					table += '<th>TR3</th>';
					table += '<th>EP Id</th>';
					table += '<th>EP</th>';
					table += '</thead>';
												
					table += '<tbody>';
			        $.each(data, function(index, item) { /* add to html string started above*/
			        	table += '<tr><td class=\'form\' align="center"><a href=\'http://www.myaiesec.net/exchange/viewtn.do?operation=executeAction&tnId='+item.formId+'\' target="_blank">'+ item.id +'<a/></td>';
			            table +='<td>' + item.name + '</td>';
			            table +='<td class=\'extype '+item.type+'\'>' + item.type + '</td>';
			            table +='<td class=\'extype '+item.status+'\'>' + item.status + '</td>';
			            table +='<td class="dtForm">' + formatDate(item.dtRA) + '</td>';
			            table +='<td class="dtForm">' + formatDate(item.dtMA) + '</td>';
			            table +='<td class="dtForm">' + formatDate(item.dtRE) + '</td>';
			            table +='<td class="dtForm">' + formatDate(item.dtEND) + '</td>';

			            //CONTRACT
			            table +='<td id=\"'+$.trim(item.id)+'_contract\" style="min-width: 85px;" class=\'taskStatusICX '+item.contract+' ';
			            if(hasText(item.comment_contract)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.
			            table +='meta-comment=\''+formatDate(item.comment_contract)+'\' meta-form=\''+$.trim(item.id)+'\' meta-doc=\'contract\' meta-type=\'tn\'>' + item.contract + '</td>';

			            //SAN
			            table +='<td id=\"'+$.trim(item.id)+'_san\" class=\'taskStatusICX '+item.san+' ';
			            if(hasText(item.comment_san)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.
			            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+formatDate(item.comment_san)+'\' meta-doc=\'san\' meta-type=\'tn\'>' + item.san + '</td>';

			            //CAN
			            table +='<td id=\"'+$.trim(item.id)+'_can\" class=\'taskStatusICX '+item.can+' ';
			            if(hasText(item.comment_can)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.
			            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+formatDate(item.comment_can)+'\' meta-doc=\'can\' meta-type=\'tn\'>' + item.can + '</td>';

						//RNE			            
			            table +='<td id=\"'+$.trim(item.id)+'_rne\" class=\'taskStatusICX '+item.rne+' ';
			            if(hasText(item.comment_rne)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.
			            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+formatDate(item.comment_rne)+'\' meta-doc=\'rne\' meta-type=\'tn\'>' + item.rne + '</td>';

			            //TN1
			            table +='<td id=\"'+$.trim(item.id)+'_tn1\" class=\'taskStatusICX '+item.tn1+' ';
			            if(hasText(item.comment_tn1)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.
			            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+formatDate(item.comment_tn1)+'\' meta-doc=\'tn1\' meta-type=\'tn\'>' + item.tn1 + '</td>';

				        //TN2
			            table +='<td id=\"'+$.trim(item.id)+'_tn2\" class=\'taskStatusICX '+item.tn2+' ';
			            if(hasText(item.comment_tn2)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.
			            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+formatDate(item.comment_tn2)+'\' meta-doc=\'tn2\' meta-type=\'tn\'>' + item.tn2 + '</td>';
			            
				        //TN3
			            table +='<td id=\"'+$.trim(item.id)+'_tn3\" class=\'taskStatusICX '+item.tn3+' ';
			            if(hasText(item.comment_tn3)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.
			            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+formatDate(item.comment_tn3)+'\' meta-doc=\'tn3\' meta-type=\'tn\'>' + item.tn3 + '</td>';

			            //TR1
			            table +='<td id=\"'+$.trim(item.id)+'_tr1\" class=\'taskStatusICX '+item.tr1+' ';
			            if(hasText(item.comment_tr1)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.
			            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+formatDate(item.comment_tr1)+'\' meta-doc=\'tr1\' meta-type=\'tn\'>' + item.tr1 + '</td>';

				        //TR2
			            table +='<td id=\"'+$.trim(item.id)+'_tr2\" class=\'taskStatusICX '+item.tr2+' ';
			            if(hasText(item.comment_tr2)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.
			            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+formatDate(item.comment_tr2)+'\' meta-doc=\'tr2\' meta-type=\'tn\'>' + item.tr2 + '</td>';
			            
				        //TR3
			            table +='<td id=\"'+$.trim(item.id)+'_tr3\" class=\'taskStatusICX '+item.tr3+' ';
			            if(hasText(item.comment_tr3)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.
			            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+formatDate(item.comment_tr3)+'\' meta-doc=\'tr3\' meta-type=\'tn\'>' + item.tr3 + '</td>';
			            
			            
			            table +='<td class=\'form\'>' + item.formMAId + '</td>';
			            table +='<td>' + item.formMAName + '</td>';
			            table +='</tr>';
			        });
					table += '</tbody>';
			        table += '</table>';

			        $('.container').show(); 
			        $("#tabs").show();
			        $("#icx").html(table);

			        if(isAuditor === 1){

				    	$('.taskStatusICX').click(function(){
					 		// EP or TN
					 		metaType = $(this).attr('meta-type');
					 		// SAN, CAN, ...
					 		metaDoc = $(this).attr('meta-doc');
					 		metaComment = $(this).attr('meta-comment');
					 		metaForm = $(this).attr('meta-form');
					 		
					 		$('.taskStatusICX').css('border', '1px solid #000');
					 		$(this).css('border', '2px solid #00f');
					 		
					 		var offset = $(this).offset();
					 		
					 		$('#editStatus_name').text(""+metaForm +': ' + (""+metaDoc).toUpperCase());
					 		
					 		var id = '#' + metaForm + '_' + metaDoc;
					 		
					 		$('#editStatus_comment').val(metaComment);
					 		
					 		$('#editStatus_status').val(doc_types[$(id).text()]);
					 		$('#editStatus_status').css('background', $('#editStatus_status').find('option:selected').css('background'));
	
					 		//TODO: Fix it...
					 		//$('#historylink').attr('href', 'index.php?page=checklist_history&bus=' + truckid + '&taskid=' + taskid);
					 		
					 		offset.left += 100;
					 		if (offset.left > 900) offset.left = offset.left - 400;
					 		
					 		$('#editStatus').css('top', offset.top + "px");
					 		$('#editStatus').css('left', offset.left + "px");
					 		$('#editStatus').show();
					    });
	
				 		$('#editStatus_status').change(function(){
				 			$('#editStatus_status').css('background', $('#editStatus_status').find('option:selected').css('background'));
				 		});
	
						$("#closeeditStatus").click(function(){
							$('#editStatus').hide();
							$('.taskStatusICX').css('border', '1px solid #000');
						});

						$("#showHistory").click(function(){

							$.getJSON("loadHistory.php?type=" + metaType+"&doc=" + metaDoc+"&form="+metaForm+"&cl="+$("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
								
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
							
	
						$("#submiteditStatus").click(function(){
							var value 	= $('#editStatus_status').val();
	
							$('.taskStatusICX').css('border', '1px solid #000');
							$.ajax({
								   type: "POST",
								   url: "updateForm.php?type=" + metaType+"&doc=" + metaDoc+"&form="+metaForm+"&status="+value+"&period="+ $("#periodId").val(),
								   data: $('#editStatusForm').serialize(),
								   success: function(data){
										$('#editStatus_status').val(0);
										$('#editStatus_comment').val('');
										$('#editStatus').hide();
	
										var id = '#' + $.trim(metaForm) + '_' + $.trim(metaDoc);
										var obj = jQuery.parseJSON(data);
										
										$(id).attr('meta-comment',obj.comment);
										$(id).text(obj.status);
										$(id).removeClass();
										$(id).addClass('taskStatusICX');
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
				        //TODO: Implement CLs view.
			        }
			        
				    
			 		//$('.ajaxupload', oTable.fnGetNodes()).editable('dropbox/util/uploadFile.php', { 
				     //   indicator : "<img src='res/img/saving.gif'>",
				     //  type      : 'ajaxupload',
				     //   submit    : 'Upload',
				     //   cancel    : 'Cancel',
				     //   tooltip   : "Click to upload..."
				    //});

			}else{
				$('#loadingIcon').hide();
				$('#loadingBox').dialog("close");
				$("#icx").html("<p>No results found.</p>");
			}
			
			loadOGX();
		});
	}

	function loadConclusions(){
		console.log("Loading Conclusions...");

		$.getJSON("loadConc.php?cl=" + $("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
			var tns = String(data);
			if(tns != ""){
				//alert('Will update');
				$.each(data, function(index, item) { 
					//alert(item.conclusao);
					//alert(item.atencao);
					//alert(item.melhoria);
					$('#conc').text(item.conclusao);
					$('#melhoria').text(item.melhoria);
					$('#atencao').text(item.atencao);
				});
			}else{
				//alert('empty');
				$('#conc').text('');
				$('#conc').val('');
				$('#melhoria').text('');
				$('#melhoria').val('');
				$('#atencao').text('');
				$('#atencao').val('');
			}

			if (reloading){
				$('#loadingIcon').hide();
				$('#loadingBox').dialog("close");

				reloading = false;
			}
	
        });
		
	}

	function loadOGX(){

		console.log("Loading OGX...");

        $.getJSON("loadEPs.php?cl=" + $("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
			var tns = String(data);
			if(tns != ""){
					var table = '<table class="datatable" id="ogxtable">';
					table += '<thead>';
					table += '<th>EP Id</th>';
					table += '<th>Name</th>';
					table += '<th>Type</th>';
					table += '<th>Status</th>';
					table += '<th>RA</th>';
					table += '<th>MA</th>';
					table += '<th>RE</th>';
					table += '<th>End</th>';
					table += '<th>Contract</th>';
					table += '<th>SAN</th>';
					table += '<th>CAN</th>';
					table += '<th>EP1</th>';
					table += '<th>EP2</th>';
					table += '<th>EP3</th>';
					table += '<th>TN Id</th>';
					table += '<th>TN</th>';
					table += '</thead>';
												
					table += '<tbody>';
			        $.each(data, function(index, item) { /* add to html string started above*/
			        	table += '<tr><td class=\'form\' align="center"><a href=\'http://www.myaiesec.net/exchange/viewtn.do?operation=executeAction&tnId='+item.formId+'\' target="_blank">'+ item.id +'<a/></td>';
			            table +='<td>' + item.name + '</td>';
			            table +='<td class=\'extype '+item.type+'\'>' + item.type + '</td>';
			            table +='<td class=\'extype '+item.status+'\'>' + item.status + '</td>';
			            table +='<td class="dtForm">' + formatDate(item.dtRA) + '</td>';
			            table +='<td class="dtForm">' + formatDate(item.dtMA) + '</td>';
			            table +='<td class="dtForm">' + formatDate(item.dtRE) + '</td>';
			            table +='<td class="dtForm">' + formatDate(item.dtEND) + '</td>';

			            // Contract
			            table +='<td id=\"'+$.trim(item.id)+'_contract\" style="min-width: 85px;" class=\'taskStatusOGX '+item.contract+' ';
			            if(hasText(item.comment_contract)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.			            
			            table +='meta-form=\''+$.trim(item.id)+'\' meta-comment=\''+formatDate(item.comment_contract)+'\' meta-doc=\'contract\' meta-formtype=\'ep\'>' + item.contract + '</td>';

						//SAN			            
			            table +='<td id=\"'+$.trim(item.id)+'_san\" class=\'taskStatusOGX '+item.san+' ';
			            if(hasText(item.comment_san)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.			            
			            table +='meta-form=\''+$.trim(item.id)+'\' meta-doc=\'san\' meta-comment=\''+formatDate(item.comment_san)+'\' meta-formtype=\'ep\'>' + item.san + '</td>';
			            
						//CAN			            
			            table +='<td id=\"'+$.trim(item.id)+'_can\" class=\'taskStatusOGX '+item.can+' ';
			            if(hasText(item.comment_can)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.			            
			            table +='meta-form=\''+$.trim(item.id)+'\' meta-doc=\'can\' meta-comment=\''+formatDate(item.comment_can)+'\' meta-formtype=\'ep\'>' + item.can + '</td>';
			            
						//EP1			            
			            table +='<td id=\"'+$.trim(item.id)+'_ep1\" class=\'taskStatusOGX '+item.ep1+' ';
			            if(hasText(item.comment_ep1)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.			            
			            table +='meta-form=\''+$.trim(item.id)+'\' meta-doc=\'ep1\' meta-comment=\''+formatDate(item.comment_ep1)+'\' meta-formtype=\'ep\'>' + item.ep1 + '</td>';
			            
						//EP2			            
			            table +='<td id=\"'+$.trim(item.id)+'_ep2\" class=\'taskStatusOGX '+item.ep2+' ';
			            if(hasText(item.comment_ep2)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.			            
			            table +='meta-form=\''+$.trim(item.id)+'\' meta-doc=\'ep2\' meta-comment=\''+formatDate(item.comment_ep2)+'\' meta-formtype=\'ep\'>' + item.ep2 + '</td>';
			            
						//EP3	            
			            table +='<td id=\"'+$.trim(item.id)+'_ep3\" class=\'taskStatusOGX '+item.ep3+' ';
			            if(hasText(item.comment_ep3)){
			            	table +='comment';
			            }
			            table += '\' '; //Closing class attr.			            
			            table +='meta-form=\''+$.trim(item.id)+'\' meta-doc=\'ep3\' meta-comment=\''+formatDate(item.comment_ep3)+'\' meta-formtype=\'ep\'>' + item.ep3 + '</td>';
			            
			            table +='<td class=\'form\'>' + item.formMAId + '</td>';
			            table +='<td>' + item.formMAName + '</td>';
			            table +='</tr>';
			        });
					table += '</tbody>';
			        table += '</table>'; 
			        $("#ogx").html(table);

			}else{
				$('#loadingIcon').hide();
				$('#loadingBox').dialog("close");
				$("#ogx").html("<p>No results found.</p>");
			}
			
	        loadLegal();

	        var tables = new Array();
	        
	        if(isAuditor === 1){

		 		$('.taskStatusOGX').click(function(){
			 		// EP or TN
			 		metaType = $(this).attr('meta-formtype');
			 		// SAN, CAN, ...
			 		metaDoc = $(this).attr('meta-doc');
			 		metaComment = $(this).attr('meta-comment');
			 		metaForm = $(this).attr('meta-form');
			 		
			 		$('.taskStatusOGX').css('border', '1px solid #000');
			 		$(this).css('border', '2px solid #00f');
			 		
			 		var offset = $(this).offset();
			 		
			 		$('#editStatus_name').text(""+metaForm +': ' + (""+metaDoc).toUpperCase());

			 		$('#editStatus_comment').val(metaComment);
	
			 		var id = '#' + metaForm + '_' + metaDoc;
	
			 		$('#editStatus_status').val(doc_types[$(id).text()]);
			 		$('#editStatus_status').css('background', $('#editStatus_status').find('option:selected').css('background'));
	
			 		//TODO: Fix it...
			 		//$('#historylink').attr('href', 'index.php?page=checklist_history&bus=' + truckid + '&taskid=' + taskid);
			 		
			 		offset.left += 100;
			 		if (offset.left > 900) offset.left = offset.left - 400;
			 		
			 		$('#editStatus').css('top', offset.top + "px");
			 		$('#editStatus').css('left', offset.left + "px");
			 		$('#editStatus').show();
			    });
	
		 		$('#editStatus_status').change(function(){
		 			$('#editStatus_status').css('background', $('#editStatus_status').find('option:selected').css('background'));
		 		});
	
				$("#closeeditStatus").click(function(){
					$('#editStatus').hide();
					$('.taskStatusOGX').css('border', '1px solid #000');
				});
	        }else{
		        //TODO: Implement CLs view.
	        }

		});
	}

	function loadLegal(){

		console.log("Loading Legal...");

        $.getJSON("loadLegal.php?cl=" + $("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
			var tns = String(data);
			if(tns != ""){
				var table = '<table id="legaltable">';
				table += '<thead>';
				table += '<th>Item</th>';
				table += '<th>Status</th>';
				table += '</thead>';
											
				table += '<tbody>';
		        $.each(data, function(index, item) { /* add to html string started above*/
		            table +='<tr><td>' + item.name + '</td>';
		            table +='<td id=\"'+$.trim(item.id)+'_statusLegal\" class=\'taskStatusLegal '+item.status+' ';

		            if(hasText(item.comment)){
		            	table +='comment';
		            }
		            
		            table += '\' '; //Closing class attr.
		            table +='meta-form=\''+item.name+'\' meta-comment=\''+formatDate(item.comment)+'\' meta-doc=\'status\' meta-type=\'status\'>' + item.status + '</td>';
		            table +='</tr>';
		        });
				table += '</tbody>';
		        table += '</table>'; 
		        $("#legal").html(table);

		     	$('.comment').mouseover(function(){
			     	//alert("will show comments");
		     		metaComment = $(this).attr('meta-comment');

		     		$(".comment").attr("title", metaComment).tooltip({
		                showURL: false,
		                fixPNG: true,
		                track:true,
		                delay:0
	                });
		     	});

		        if(isAuditor === 1){

			     	$('.taskStatusLegal').click(function(){
				 		// EP or TN
				 		metaId = $(this).attr('id');
				 		
				 		metaType = $(this).attr('meta-type');
				 		metaComment = $(this).attr('meta-comment');
				 		//alert("metaType: "+metaType);
				 		// SAN, CAN, ...
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

				 		//TODO: Fix it...
				 		//$('#historylink').attr('href', 'index.php?page=checklist_history&bus=' + truckid + '&taskid=' + taskid);
				 		
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

						$.getJSON("loadHistoryLegal.php?type=" + metaType+"&doc=" + metaDoc+"&form="+metaForm+"&cl="+$("#clId").val() +"&period="+ $("#periodId").val(), function(data) {
							
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

        	loadTerms();
		});
	}
		
	
	function loadOGX2(){

	}

	function validateShowForms(){
		if($("#clId").val() == 0 || $("#periodId").val() == 0){
			alert("Oops.. Select a CL and period before Go, dude.");
			return false;
		}

		//TODO: Review validation below.
		return true;

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

	$('#from').val('01.10.2012');
	
	$('#to').datepicker({
		dateFormat: 'dd.mm.yy'
	});

	$('#to').val('30.12.2012');

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

</body>
</html>
