<?php
session_start();

require_once("util/Util.class.php");
require_once("util/MyAiesec.class.php");
?>

<html>
<head>
<title>ADT Tool (alpha) - AIESEC in Brazil
</div>
</title>

<link href="res/css/smoothness/jquery-ui-1.9.1.custom.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="res/css/styles.css" />

<script src="res/js/jquery-1.8.2.js"></script>
<script src="res/js/jquery-ui-1.9.1.custom.min.js"></script>
<script src="res/js/FixedColumns.js"></script>
<script src="res/js/jquery.dataTables.js"></script>
<script src="res/js/jeditable.js"></script>

</head>
<body>
<script>
$(document).ready(function() {

	var from = "";
	var to= "";
	var types = "";
	var form_values_data = "";

	$.ajax({
		  url: "possible_values.php"
		}).done(function ( possible_data ) {
			form_values_data = possible_data;
//		  if( console && console.log ) {
//		    console.log("Sample of data:", form_values_data);
//		  }
		});
	
	$('#loadingIcon').hide();
	$("#tabs").tabs();
	$("#tabs").hide();

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

	function formatDate(val) {
	    val = $.trim(val);
	    return (val == undefined || val == '') ? "" : val;
	};

	function loadForms(){

		var tns = "";
		
		$("#loadingBox").dialog({
			title: "ADT - AuDit Tool",
            modal: true,
            resizable : false,
            draggable: false
		});

		$('#result').text("");
		
        $('#loadingIcon').show();
        $('#status').text("Loading forms...");

        $.getJSON("loadTNs.php?cl=" + $("#cmtId").val() +"&from="+from+"&to="+to, function(data) {
			var tns = String(data);
			if(tns != ""){
					var table = '<table id="icxtable">';
					table += '<thead>';
					table += '<th>TN Id</th>';
					table += '<th>Organisation name</th>';
					table += '<th>EP Id</th>';
					table += '<th>EP</th>';
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
					table += '<th>TN Id</th>';
					table += '</thead>';
												
					table += '<tbody>';
			        $.each(data, function(index, item) { /* add to html string started above*/
			        	table += '<tr><td class=\'form\' align="center"><a href=\'http://www.myaiesec.net/exchange/viewtn.do?operation=executeAction&tnId='+item.formId+'\' target="_blank">'+ item.id +'<a/></td>';
			            table +='<td>' + item.name + '</td>';
			            table +='<td class=\'form\'>' + item.formMAId + '</td>';
			            table +='<td class=\'form\'>' + item.formMAName + '</td>';
			            table +='<td class=\'extype '+item.type+'\'>' + item.type + '</td>';
			            table +='<td class=\'extype '+item.status+'\'>' + item.status + '</td>';
			            table +='<td class="dtForm">' + formatDate(item.dtRA) + '</td>';
			            table +='<td class="dtForm">' + formatDate(item.dtMA) + '</td>';
			            table +='<td class="dtForm">' + formatDate(item.dtRE) + '</td>';
			            table +='<td class="dtForm">' + formatDate(item.dtEND) + '</td>';
			            table +='<td class=\'editContrato '+item.contrato+'\'>' + item.contrato + '</td>';
			            table +='<td class=\'editSAN '+item.san+'\'>' + item.san + '</td>';
			            table +='<td class=\'editCAN '+item.can+'\'>' + item.can + '</td>';
			            table +='<td class=\'editRNE '+item.rne+'\'>' + item.rne + '</td>';
			            table +='<td class=\'editTN1 '+item.tn1+'\'>' + item.tn1 + '</td>';
			            table +='<td class=\'editTN2 '+item.tn2+'\'>' + item.tn2 + '</td>';
			            table +='<td class=\'editTN3 '+item.tn3+'\'>' + item.tn3 + '</td>';
			            table +='<td class=\'editTR1 '+item.tr1+'\'>' + item.tr1 + '</td>';
			            table +='<td class=\'editTR2 '+item.tr2+'\'>' + item.tr2 + '</td>';
			            table +='<td class=\'editTR3 '+item.tr3+'\'>' + item.tr3 + '</td>';
			            table +='<td class=\'form\'>' + item.id + '</td>';
			            table +='</tr>';
			        });
					table += '</tbody>';
			        table += '</table>'; 
			        $("#tabs").show();
			        $("#icx").html(table);

			        var oTable = $('#icxtable').dataTable( {
//				 		"sScrollX": "100%",
//				 		"bScrollCollapse": true,
//				 		"bPaginate": false
						"sScrollY": "300px",
						"sScrollX": "100%",
						"sScrollXInner": "150%",
						"bScrollCollapse": true,
						"bPaginate": false
				 	} );
				 	
				 	new FixedColumns( oTable, {
				 		"iLeftColumns": 2
				 	} );

					//TODO: Get columns here and avoid multiple styles
					$('.editContrato', oTable.fnGetNodes()).editable('updateForm.php', {
						"data"   : form_values_data,
					    "type"   : 'select',
					    "style"  : 'display: inline',
					    "submit" : 'go',
					    "indicator" : '<img src="res/img/saving.gif">',
				        "tooltip"   : 'Click to edit...',
						"submitdata": function ( value, settings ) {
							return {
								"form": $(this).parent().find("td:last").html(),
								'field': "contrato",   
								"column": oTable.fnGetPosition( this )[2]
							};
						},
				        "callback" : function(value, settings) {
							$(this).removeClass();
							$(this).addClass('.editContrato');
							$(this).addClass(value);
				        }
					});
					$('.editSAN', oTable.fnGetNodes()).editable('updateForm.php', {
						"data"   : form_values_data,
					    "type"   : 'select',
					    "style"  : 'display: inline',
					    "submit" : 'go',
					    "indicator" : '<img src="res/img/saving.gif">',
				        "tooltip"   : 'Click to edit...',
						"submitdata": function ( value, settings ) {
							return {
								//"row_id": this.parentNode.getAttribute('id'),
								"form": $(this).parent().find("td:last").html(), 
								'field': "san",   
								"column": oTable.fnGetPosition( this )[2]
							};
						},
				        "callback" : function(value, settings) {
							$(this).removeClass();
							$(this).addClass('.editSAN');
							$(this).addClass(value);
				        }
					});
					$('.editCAN', oTable.fnGetNodes()).editable('updateForm.php', {
						"data"   : form_values_data,
					    "type"   : 'select',
					    "style"  : 'display: inline',
					    "submit" : 'go',
					    "indicator" : '<img src="res/img/saving.gif">',
				        "tooltip"   : 'Click to edit...',
						"submitdata": function ( value, settings ) {
							return {
								//"row_id": this.parentNode.getAttribute('id'),
								"form": $(this).parent().find("td:last").html(), 
								'field': "can",   
								"column": oTable.fnGetPosition( this )[2]
							};
						},
				        "callback" : function(value, settings) {
							$(this).removeClass();
							$(this).addClass('.editCAN');
							$(this).addClass(value);
				        }
					});
					$('.editRNE', oTable.fnGetNodes()).editable('updateForm.php', {
						"data"   : form_values_data,
					    "type"   : 'select',
					    "style"  : 'display: inline',
					    "submit" : 'go',
					    "indicator" : '<img src="res/img/saving.gif">',
				        "tooltip"   : 'Click to edit...',
						"submitdata": function ( value, settings ) {
							return {
								//"row_id": this.parentNode.getAttribute('id'),
								"form": $(this).parent().find("td:last").html(), 
								'field': "rne",   
								"column": oTable.fnGetPosition( this )[2]
							};
						},
				        "callback" : function(value, settings) {
							$(this).removeClass();
							$(this).addClass('.editRNE');
							$(this).addClass(value);
				        }
					});
					$('.editTN1', oTable.fnGetNodes()).editable('updateForm.php', {
						"data"   : form_values_data,
					    "type"   : 'select',
					    "style"  : 'display: inline',
					    "submit" : 'go',
					    "indicator" : '<img src="res/img/saving.gif">',
				        "tooltip"   : 'Click to edit...',
						"submitdata": function ( value, settings ) {
							return {
								//"row_id": this.parentNode.getAttribute('id'),
								"form": $(this).parent().find("td:last").html(), 
								'field': "tn1",   
								"column": oTable.fnGetPosition( this )[2]
							};
						},
				        "callback" : function(value, settings) {
							$(this).removeClass();
							$(this).addClass('.editTN1');
							$(this).addClass(value);
				        }
					});
					$('.editTN2', oTable.fnGetNodes()).editable('updateForm.php', {
						"data"   : form_values_data,
					    "type"   : 'select',
					    "style"  : 'display: inline',
					    "submit" : 'go',
					    "indicator" : '<img src="res/img/saving.gif">',
				        "tooltip"   : 'Click to edit...',
						"submitdata": function ( value, settings ) {
							return {
								//"row_id": this.parentNode.getAttribute('id'),
								"form": $(this).parent().find("td:last").html(), 
								'field': "tn2",   
								"column": oTable.fnGetPosition( this )[2]
							};
						},
				        "callback" : function(value, settings) {
							$(this).removeClass();
							$(this).addClass('.editTN2');
							$(this).addClass(value);
				        }
					});
					$('.editTN3', oTable.fnGetNodes()).editable('updateForm.php', {
						"data"   : form_values_data,
					    "type"   : 'select',
					    "style"  : 'display: inline',
					    "submit" : 'go',
					    "indicator" : '<img src="res/img/saving.gif">',
				        "tooltip"   : 'Click to edit...',
						"submitdata": function ( value, settings ) {
							return {
								//"row_id": this.parentNode.getAttribute('id'),
								"form": $(this).parent().find("td:last").html(), 
								'field': "tn3",   
								"column": oTable.fnGetPosition( this )[2]
							};
						},
				        "callback" : function(value, settings) {
							$(this).removeClass();
							$(this).addClass('.editTN3');
							$(this).addClass(value);
				        }
					});
					$('.editTR1', oTable.fnGetNodes()).editable('updateForm.php', {
						"data"   : form_values_data,
					    "type"   : 'select',
					    "style"  : 'display: inline',
					    "submit" : 'go',
					    "indicator" : '<img src="res/img/saving.gif">',
				        "tooltip"   : 'Click to edit...',
						"submitdata": function ( value, settings ) {
							return {
								//"row_id": this.parentNode.getAttribute('id'),
								"form": $(this).parent().find("td:last").html(), 
								'field': "tr1",   
								"column": oTable.fnGetPosition( this )[2]
							};
						},
				        "callback" : function(value, settings) {
							$(this).removeClass();
							$(this).addClass('.editTR1');
							$(this).addClass(value);
				        }
					});
					$('.editTR2', oTable.fnGetNodes()).editable('updateForm.php', {
						"data"   : form_values_data,
					    "type"   : 'select',
					    "style"  : 'display: inline',
					    "submit" : 'go',
					    "indicator" : '<img src="res/img/saving.gif">',
				        "tooltip"   : 'Click to edit...',
						"submitdata": function ( value, settings ) {
							return {
								//"row_id": this.parentNode.getAttribute('id'),
								"form": $(this).parent().find("td:last").html(), 
								'field': "tr2",   
								"column": oTable.fnGetPosition( this )[2]
							};
						},
				        "callback" : function(value, settings) {
							$(this).removeClass();
							$(this).addClass('.editTR2');
							$(this).addClass(value);
				        }
					});
					$('.editTR3', oTable.fnGetNodes()).editable('updateForm.php', {
						"data"   : form_values_data,
					    "type"   : 'select',
					    "style"  : 'display: inline',
					    "submit" : 'go',
					    "indicator" : '<img src="res/img/saving.gif">',
				        "tooltip"   : 'Click to edit...',
						"submitdata": function ( value, settings ) {
							return {
								//"row_id": this.parentNode.getAttribute('id'),
								"form": $(this).parent().find("td:last").html(), 
								'field': "tr3",   
								"column": oTable.fnGetPosition( this )[2]
							};
						},
				        "callback" : function(value, settings) {
							$(this).removeClass();
							$(this).addClass('.editTR3');
							$(this).addClass(value);
				        }
					});
					

					loadOGX();
			}else{
				$('#loadingIcon').hide();
				$('#loadingBox').dialog("close");
				$("#icx").html("<p>No results found.</p>");
			}
		});
	}

	function loadOGX(){

		var arr = $.map($('input:checkbox:checked'), function(e, i) {
	        return +e.value;
	    });

		var types = arr.join(',');

		$.getJSON("loadEPs.php?cl=" + $("#cmtId").val() +"&from="+from+"&to="+to+"&types="+types, function(data3) {
			var tns = String(data3);
			if(tns != ""){
					var table= '<table id="ogxtable" cellpadding="2" cellspacing="0" border="1">'; 
					table += '<th>EP Id</th>';
					table += '<th>EP Name</th>';
					table += '<th>TN Id</th>';
					table += '<th>Organisation name</th>';
					table += '<th>GIP/GCDP</th>';
					table += '<th>Status</th>';
					table += '<th>RA</th>';
					table += '<th>MA</th>';
					table += '<th>RE</th>';
					table += '<th>End</th>';
							
			        $.each(data3, function(index, item) { /* add to html string started above*/
			        	table += '<tr><td align="center"><a href=\'http://www.myaiesec.net/exchange/viewep.do?operation=executeAction&epId='+item.formId+'\' target="_blank">'+ item.id +'<a/></td>';
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
			        $("#ogx").html(table);
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

<div class="container">
<div class="header"><img src="res/img/tna_logo_mini.png" /> ADT Tool -
v0.2 (alpha)</div>
<div class="lightSearchbox">
<h4>&rsaquo;&rsaquo; List TNs/EPs by LC and Audit period</h4>
<label>LC: </label> <select name="cmtId" id="cmtId" class="">
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
	<option value="1000000313" selected>INSPER</option>
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
<span class="light"> <b>by</b> </span> 
<label>period: </label>
<select id="periodId">
	<option value="0">Q4/2012</option>
	<option value="1">Jan/2013</option>
	<option value="2">Feb/2013</option>
	<option value="3">Mar/2013</option>
	<option value="4">...</option>
</select>
<button type="submit" id="bot">Go</button>
</div>
<br />
<div id="result" align="center"></div>

<div id="tabs" style="padding: 15px">
<ul>
	<li><a href="#icx"><span>ICX</span></a></li>
	<li><a href="#ogx"><span>OGX</span></a></li>
</ul>
<div id="icx" align="center"></div>
<div id="ogx" align="center"></div>
</div>

<div id="loadingBox"><br />
<div align="center" id="status"></div>
<br />
<div id="loadingIcon" align="center"><img src="res/img/loading.gif" /></div>
</div>
<br />
<br />
<div class="footer"></div>

</body>
</html>
