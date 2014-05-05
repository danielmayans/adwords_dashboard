<?php

function drawTable($keyData){
	$keywords = $keyData->GetKeywordData();
	$keywordHeaders = $keyData->GetHeaders();

	print("<table border=\"1\" class=\"tSortable\">");

	tH($keywordHeaders);
	tD($keywords);

	print("</table>");

	print('<form method="POST" action="'.$_SERVER['PHP_SELF'].'">
		<input type="hidden" value="'.$_POST['month'].'" name="month"/>
		<input type="hidden" value="'.$_POST['campaign'].'" name="campaign"/>
		<input type="submit" value="Generate CSV" name="downloadcsv"/></form>');
}
function tH($keywordHeaders){
	print("<tr>");
	foreach($keywordHeaders as $headers){
		print("<th>".$headers[0]."</th>");
	}
	print("</tr>");
}

function tD($keywords){
	foreach($keywords as $key){
		print("<tr>");			
		foreach($key as $data){			
			print("<td>".$data."</td>");
		}
		print("</tr>");
	}
}

?>