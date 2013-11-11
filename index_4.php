
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title>Pure CSS Scrollable Table with Fixed Header</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="language" content="en-us" />
<script type="text/javascript">
<!--
/* http://www.alistapart.com/articles/zebratables/ */
function removeClassName (elem, className) {
	elem.className = elem.className.replace(className, "").trim();
}

function addCSSClass (elem, className) {
	removeClassName (elem, className);
	elem.className = (elem.className + " " + className).trim();
}

String.prototype.trim = function() {
	return this.replace( /^\s+|\s+$/, "" );
}

function stripedTable() {
	if (document.getElementById && document.getElementsByTagName) {  
		var allTables = document.getElementsByTagName('table');
		if (!allTables) { return; }

		for (var i = 0; i < allTables.length; i++) {
			if (allTables[i].className.match(/[\w\s ]*scrollTable[\w\s ]*/)) {
				var trs = allTables[i].getElementsByTagName("tr");
				for (var j = 0; j < trs.length; j++) {
					removeClassName(trs[j], 'alternateRow');
					addCSSClass(trs[j], 'normalRow');
				}
				for (var k = 0; k < trs.length; k += 2) {
					removeClassName(trs[k], 'normalRow');
					addCSSClass(trs[k], 'alternateRow');
				}
			}
		}
	}
}

/* onload state is fired, append onclick action to the table's DIV */
/* container. This allows the HTML document to validate correctly. */
/* addIEonScroll added on 2005-01-28                               */
/* Terence Ordona, portal[AT]imaputz[DOT]com                       */
function addIEonScroll() {
	var thisContainer = document.getElementById('tableContainer');
	if (!thisContainer) { return; }

	var onClickAction = 'toggleSelectBoxes();';
	thisContainer.onscroll = new Function(onClickAction);
}

/* Only WinIE will fire this function. All other browsers scroll the TBODY element and not the DIV */
/* This is to hide the SELECT elements from scrolling over the fixed Header. WinIE only.           */
/* toggleSelectBoxes added on 2005-01-28 */
/* Terence Ordona, portal[AT]imaputz[DOT]com         */
function toggleSelectBoxes() {
	var thisContainer = document.getElementById('tableContainer');
	var thisHeader = document.getElementById('fixedHeader');
	if (!thisContainer || !thisHeader) { return; }

	var selectBoxes = thisContainer.getElementsByTagName('select');
	if (!selectBoxes) { return; }

	for (var i = 0; i < selectBoxes.length; i++) {
		if (thisContainer.scrollTop >= eval(selectBoxes[i].parentNode.offsetTop - thisHeader.offsetHeight)) {
			selectBoxes[i].style.visibility = 'hidden';
		} else {
			selectBoxes[i].style.visibility = 'visible';
		}
	}
} 

window.onload = function() { stripedTable(); addIEonScroll(); }
-->
</script>
<style type="text/css">
<!--
/* Terence Ordona, portal[AT]imaputz[DOT]com         */
/* http://creativecommons.org/licenses/by-sa/2.0/    */

/* begin some basic styling here                     */
body {
	background: #FFF;
	color: #000;
	font: normal normal 12px Verdana, Geneva, Arial, Helvetica, sans-serif;
	margin: 10px;
	padding: 0
}

table, td, a {
	color: #000;
	font: normal normal 12px Verdana, Geneva, Arial, Helvetica, sans-serif
}

h1 {
	font: normal normal 18px Verdana, Geneva, Arial, Helvetica, sans-serif;
	margin: 0 0 5px 0
}

h2 {
	font: normal normal 16px Verdana, Geneva, Arial, Helvetica, sans-serif;
	margin: 0 0 5px 0
}

h3 {
	font: normal normal 13px Verdana, Geneva, Arial, Helvetica, sans-serif;
	color: #008000;
	margin: 0 0 15px 0
}

/* end basic styling                                 */


/* define height and width of scrollable area. Add 16px to width for scrollbar          */
/* allow WinIE to scale 100% width of browser by not defining a width                   */
/* WARNING: applying a background here may cause problems with scrolling in WinIE 5.x   */
div.tableContainer {
	clear: both;
	border: 1px solid #963;
	height: 285px;
	overflow: auto;
	width: 756px;
}

/* WinIE 6.x needs to re-account for it's scrollbar. Give it some padding */
\html div.tableContainer/* */ {
	padding: 0 16px 0 0;
	width: 740px;
}

/* clean up for allowing display Opera 5.x/6.x and MacIE 5.x */
html>body div.tableContainer {
	height: auto;
	padding: 0;
}

/* Reset overflow value to hidden for all non-IE browsers. */
/* Filter out Opera 5.x/6.x and MacIE 5.x                  */
head:first-child+body div[class].tableContainer {
	height: 285px;
	overflow: hidden;
	width: 756px
}

/* define width of table. IE browsers only                 */
/* if width is set to 100%, you can remove the width       */
/* property from div.tableContainer and have the div scale */
div.tableContainer table {
	float: left;
	width: 100%
}

/* WinIE 6.x needs to re-account for padding. Give it a negative margin */
\html div.tableContainer table/* */ {
	margin: 0 -16px 0 0
}

/* define width of table. Opera 5.x/6.x and MacIE 5.x */
html>body div.tableContainer table {
	float: none;
	margin: 0;
	width: 740px
}

/* define width of table. Add 16px to width for scrollbar.           */
/* All other non-IE browsers. Filter out Opera 5.x/6.x and MacIE 5.x */
head:first-child+body div[class].tableContainer table {
	width: 756px
}

/* set table header to a fixed position. WinIE 6.x only                                       */
/* In WinIE 6.x, any element with a position property set to relative and is a child of       */
/* an element that has an overflow property set, the relative value translates into fixed.    */
/* Ex: parent element DIV with a class of tableContainer has an overflow property set to auto */
thead.fixedHeader tr {
	position: relative;
	/* expression is for WinIE 5.x only. Remove to validate and for pure CSS solution      */
	top: expression(document.getElementById("tableContainer").scrollTop);
}

/* set THEAD element to have block level attributes. All other non-IE browsers            */
/* this enables overflow to work on TBODY element. All other non-IE, non-Mozilla browsers */
/* Filter out Opera 5.x/6.x and MacIE 5.x                                                 */
head:first-child+body thead[class].fixedHeader tr {
	display: block;
}

/* make the TH elements pretty */
thead.fixedHeader th {
	background: #C96;
	border-left: 1px solid #EB8;
	border-right: 1px solid #B74;
	border-top: 1px solid #EB8;
	font-weight: normal;
	padding: 4px 3px;
	text-align: left
}

/* make the A elements pretty. makes for nice clickable headers                */
thead.fixedHeader a, thead.fixedHeader a:link, thead.fixedHeader a:visited {
	color: #FFF;
	display: block;
	text-decoration: none;
	width: 100%
}

/* make the A elements pretty. makes for nice clickable headers                */
/* WARNING: swapping the background on hover may cause problems in WinIE 6.x   */
thead.fixedHeader a:hover {
	color: #FFF;
	display: block;
	text-decoration: underline;
	width: 100%
}

/* define the table content to be scrollable                                              */
/* set TBODY element to have block level attributes. All other non-IE browsers            */
/* this enables overflow to work on TBODY element. All other non-IE, non-Mozilla browsers */
/* induced side effect is that child TDs no longer accept width: auto                     */
/* Filter out Opera 5.x/6.x and MacIE 5.x                                                 */
head:first-child+body tbody[class].scrollContent {
	display: block;
	height: 262px;
	overflow: auto;
	width: 100%
}

/* make TD elements pretty. Provide alternating classes for striping the table */
/* http://www.alistapart.com/articles/zebratables/                             */
tbody.scrollContent td, tbody.scrollContent tr.normalRow td {
	background: #FFF;
	border-bottom: none;
	border-left: none;
	border-right: 1px solid #CCC;
	border-top: 1px solid #DDD;
	padding: 2px 3px 3px 4px
}

tbody.scrollContent tr.alternateRow td {
	background: #EEE;
	border-bottom: none;
	border-left: none;
	border-right: 1px solid #CCC;
	border-top: 1px solid #DDD;
	padding: 2px 3px 3px 4px
}

/* define width of TH elements: 1st, 2nd, and 3rd respectively.      */
/* All other non-IE browsers. Filter out Opera 5.x/6.x and MacIE 5.x */
/* Add 16px to last TH for scrollbar padding                         */
/* http://www.w3.org/TR/REC-CSS2/selector.html#adjacent-selectors    */
head:first-child+body thead[class].fixedHeader th {
	width: 200px
}

head:first-child+body thead[class].fixedHeader th + th {
	width: 240px
}

head:first-child+body thead[class].fixedHeader th + th + th {
	border-right: none;
	padding: 4px 4px 4px 3px;
	width: 316px
}

/* define width of TH elements: 1st, 2nd, and 3rd respectively.      */
/* All other non-IE browsers. Filter out Opera 5.x/6.x and MacIE 5.x */
/* Add 16px to last TH for scrollbar padding                         */
/* http://www.w3.org/TR/REC-CSS2/selector.html#adjacent-selectors    */
head:first-child+body tbody[class].scrollContent td {
	width: 200px
}

head:first-child+body tbody[class].scrollContent td + td {
	width: 240px
}

head:first-child+body tbody[class].scrollContent td + td + td {
	border-right: none;
	padding: 2px 4px 2px 3px;
	width: 300px
}
-->
</style>
</head><body>


<div id="tableContainer" class="tableContainer">
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="scrollTable">
<thead class="fixedHeader" id="fixedHeader">
	<tr>
		<th><a href="#">Header 1</a></th>
		<th><a href="#">Header 2</a></th>
		<th><a href="#">Header 3</a></th>
	</tr>
</thead>
<tbody class="scrollContent">
	<tr>
		<td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nulla vitae wisi. Nulla euismod aliquet tellus.</td>
		<td>In sit amet enim. Praesent vulputate tortor nec ante. Morbi sollicitudin est non neque.</td>
		<td>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos.</td>
	</tr>
	<tr>
		<td>Cell Content 1</td>
		<td>Cell Content 2</td>
		<td><select name="sampleSelect1" id="sampleSelect1"><option>Option 1</option><option>Option 2</option><option>Option 3</option><option>Option 4</option><option>Option 5</option></select></td>
	</tr>
	<tr>
		<td>Cell Content 1</td>
		<td>Cell Content 2</td>
		<td><select name="sampleSelect2" id="sampleSelect2" size="5" multiple="multiple"><option>Option 1</option><option>Option 2</option><option>Option 3</option><option>Option 4</option><option>Option 5</option></select></td>
	</tr>
	<tr>
		<td>More Cell Content 1</td>
		<td>More Cell Content 2</td>
		<td><input type="text" name="sampleText" id="sampleText" value="This is a sample Text form element" /></td>
	</tr>
	<tr>
		<td>Even More Cell Content 1</td>
		<td>Even More Cell Content 2</td>
		<td><input type="password" name="samplePassword" id="samplePassword" value="password" /></td>
	</tr>
	<tr>
		<td>And Repeat 1</td>
		<td>And Repeat 2</td>
		<td><input type="submit" name="sampleSubmit" id="sampleSubmit" value="Sample Submit Button" /></td>
	</tr>
	<tr>
		<td>Cell Content 1</td>
		<td>Cell Content 2</td>
		<td><input type="reset" name="sampleReset" id="sampleReset" value="Sample Reset Button" /></td>
	</tr>
	<tr>
		<td>More Cell Content 1</td>
		<td>More Cell Content 2</td>
		<td><input type="button" name="sampleButton" id="sampleButton" value="Sample Button Element" /></td>
	</tr>
	<tr>
		<td>Even More Cell Content 1</td>
		<td>Even More Cell Content 2</td>
		<td><input type="checkbox" name="sampleCheckbox" id="sampleCheckboxA" value="sampleCheckboxA" /> <label for="sampleCheckboxA">Sample Checkbox A</label></td>
	</tr>
	<tr>
		<td>And Repeat 1</td>
		<td>And Repeat 2</td>
		<td><input type="checkbox" name="sampleCheckbox" id="sampleCheckboxB" value="sampleCheckboxB" /> <label for="sampleCheckboxB">Sample Checkbox B</label></td>
	</tr>
	<tr>
		<td>Cell Content 1</td>
		<td>Cell Content 2</td>
		<td><input type="radio" name="sampleRadio" id="sampleRadioA" value="sampleRadioA" /> <label for="sampleRadioA">Sample Radio A</label></td>
	</tr>
	<tr>
		<td>More Cell Content 1</td>
		<td>More Cell Content 2</td>
		<td><input type="radio" name="sampleRadio" id="sampleRadioB" value="sampleRadioB" /> <label for="sampleRadioB">Sample Radio B</label></td>
	</tr>
	<tr>
		<td>Even More Cell Content 1</td>
		<td>Even More Cell Content 2</td>
		<td><select name="sampleSelect3" id="sampleSelect3"><option>Option 1</option><option>Option 2</option><option>Option 3</option><option>Option 4</option><option>Option 5</option></select></td>
	</tr>
	<tr>
		<td>And Repeat 1</td>
		<td>And Repeat 2</td>
		<td><select name="sampleSelect4" id="sampleSelect4" size="5" multiple="multiple"><option>Option 1</option><option>Option 2</option><option>Option 3</option><option>Option 4</option><option>Option 5</option></select></td>
	</tr>
	<tr>
		<td>Cell Content 1</td>
		<td>Cell Content 2</td>
		<td><textarea cols="20" rows="5" name="sampleTextarea" id="sampleTextarea">Cell Content 3</textarea></td>
	</tr>
	<tr>
		<td>More Cell Content 1</td>
		<td>More Cell Content 2</td>
		<td>More Cell Content 3</td>
	</tr>
	<tr>
		<td>Even More Cell Content 1</td>
		<td>Even More Cell Content 2</td>
		<td>Even More Cell Content 3</td>
	</tr>
	<tr>
		<td>And Repeat 1</td>
		<td>And Repeat 2</td>
		<td>And Repeat 3</td>
	</tr>
	<tr>
		<td>Cell Content 1</td>
		<td>Cell Content 2</td>
		<td><select name="sampleSelect5" id="sampleSelect5"><option>Option 1</option><option>Option 2</option><option>Option 3</option><option>Option 4</option><option>Option 5</option></select></td>
	</tr>
	<tr>
		<td>More Cell Content 1</td>
		<td>More Cell Content 2</td>
		<td><select name="sampleSelect6" id="sampleSelect6"><option>Option 1</option><option>Option 2</option><option>Option 3</option><option>Option 4</option><option>Option 5</option></select></td>
	</tr>
	<tr>
		<td>Even More Cell Content 1</td>
		<td>Even More Cell Content 2</td>
		<td>Even More Cell Content 3</td>
	</tr>
	<tr>
		<td>And Repeat 1</td>
		<td>And Repeat 2</td>
		<td>And Repeat 3</td>
	</tr>
	<tr>
		<td>Cell Content 1</td>
		<td>Cell Content 2</td>
		<td>Cell Content 3</td>
	</tr>
	<tr>
		<td>More Cell Content 1</td>
		<td>More Cell Content 2</td>
		<td>More Cell Content 3</td>
	</tr>
	<tr>
		<td>Even More Cell Content 1</td>
		<td>Even More Cell Content 2</td>
		<td>Even More Cell Content 3</td>
	</tr>
	<tr>
		<td>And Repeat 1</td>
		<td>And Repeat 2</td>
		<td>And Repeat 3</td>
	</tr>
	<tr>
		<td>Cell Content 1</td>
		<td>Cell Content 2</td>
		<td>Cell Content 3</td>
	</tr>
	<tr>
		<td>More Cell Content 1</td>
		<td>More Cell Content 2</td>
		<td>More Cell Content 3</td>
	</tr>
	<tr>
		<td>Even More Cell Content 1</td>
		<td>Even More Cell Content 2</td>
		<td>Even More Cell Content 3</td>
	</tr>
	<tr>
		<td>And Repeat 1</td>
		<td>And Repeat 2</td>
		<td>And Repeat 3</td>
	</tr>
	<tr>
		<td>Cell Content 1</td>
		<td>Cell Content 2</td>
		<td>Cell Content 3</td>
	</tr>
	<tr>
		<td>More Cell Content 1</td>
		<td>More Cell Content 2</td>
		<td>More Cell Content 3</td>
	</tr>
	<tr>
		<td>Even More Cell Content 1</td>
		<td>Even More Cell Content 2</td>
		<td>Even More Cell Content 3</td>
	</tr>
	<tr>
		<td>And Repeat 1</td>
		<td>And Repeat 2</td>
		<td>And Repeat 3</td>
	</tr>
	<tr>
		<td>Cell Content 1</td>
		<td>Cell Content 2</td>
		<td>Cell Content 3</td>
	</tr>
	<tr>
		<td>More Cell Content 1</td>
		<td>More Cell Content 2</td>
		<td>More Cell Content 3</td>
	</tr>
	<tr>
		<td>Even More Cell Content 1</td>
		<td>Even More Cell Content 2</td>
		<td>Even More Cell Content 3</td>
	</tr>
	<tr>
		<td>And Repeat 1</td>
		<td>And Repeat 2</td>
		<td>And Repeat 3</td>
	</tr>
	<tr>
		<td>Cell Content 1</td>
		<td>Cell Content 2</td>
		<td>Cell Content 3</td>
	</tr>
	<tr>
		<td>More Cell Content 1</td>
		<td>More Cell Content 2</td>
		<td>More Cell Content 3</td>
	</tr>
	<tr>
		<td>Even More Cell Content 1</td>
		<td>Even More Cell Content 2</td>
		<td>Even More Cell Content 3</td>
	</tr>
	<tr>
		<td>And Repeat 1</td>
		<td>And Repeat 2</td>
		<td>And Repeat 3</td>
	</tr>
	<tr>
		<td>Cell Content 1</td>
		<td>Cell Content 2</td>
		<td>Cell Content 3</td>
	</tr>
	<tr>
		<td>More Cell Content 1</td>
		<td>More Cell Content 2</td>
		<td>More Cell Content 3</td>
	</tr>
	<tr>
		<td>Even More Cell Content 1</td>
		<td>Even More Cell Content 2</td>
		<td>Even More Cell Content 3</td>
	</tr>
	<tr>
		<td>End of Cell Content 1</td>
		<td>End of Cell Content 2</td>
		<td>End of Cell Content 3</td>
	</tr>
</tbody>
</table>
</div>

</body></html>