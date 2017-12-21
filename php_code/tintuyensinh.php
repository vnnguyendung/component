<?php 
require __DIR__ . "/autoload.php";
////$path	= __DIR__ . '/img/chart.png';
//$qrcode = new QrReader($path);

//Kint::dump($GLOBALS, $_SERVER); // pass any number of parameters
//d($GLOBALS, $_SERVER); // or simply use d() as a shorthand

use Goutte\Client;

$client = new \Goutte\Client();

// Create and use a guzzle client instance that will time out after 90 seconds
$guzzleClient = new \GuzzleHttp\Client(array(
'timeout' => 90,
'verify' => false,
));

$client->setClient($guzzleClient);

$crawler = $client->request('GET', 'http://localhost/thituyensinh/info.html');
// d($crawler);


echo_header();

/// kiem tra coi co dung ten truong khong, de lo copy nham thi khong hay

echo $thongtintruong = $crawler->filter('table.tblMenuLeft')->filter('td:not(:empty)')->eq(0)->html();



///// phan than

 $xuly1 = $crawler->filter('td.xpt div.khaithac_body > div')->filter('table')->eq(0)->filter('td:not(:empty)');
 $demso = $xuly1->count();

 	echo '<div class="copy-content">';
 	
 $xuly1->slice(1,$demso-2)->each(function ($node) {
	
	 	if ($node->filter('label')->count()) {
	 		echo '<b>';
	 		echo $node->text();
	 		echo '</b>';
	 	} else {
	 		echo $node->html();
	 	}

 	echo "<br />";
});
 echo '</div>
      <button class="copy-btn footer-1">Copy Thong tin 1</button>';

/* $crawler->filter('td.xpt div.khaithac_body > div table.x1y3')->eq(0)->each(function ($node){
 		  		echo $node->html();
 });*/

 table_tuyensinh();



 	echo '<div class="copy-content">';
 $crawler->filter('td.xpt div.khaithac_body > div table.x1y3')->eq(1)->each(function ($node){
 		  		echo $node->html();
 });
echo '</div>
      <button class="copy-btn footer-3">Copy thong tin 3</button>';











function echo_header(){
	$html ='
		<!DOCTYPE html>
		<html lang="vi-vn" dir="ltr" >
		<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<style type="text/stylesheet">
				@-webkit-viewport   { width: device-width; }
				@-moz-viewport      { width: device-width; }
				@-ms-viewport       { width: device-width; }
				@-o-viewport        { width: device-width; }
				@viewport           { width: device-width; }
			</style>
		<script type="text/javascript">if(navigator.userAgent.match(/IEMobile\/10\.0/)){var msViewportStyle=document.createElement("style");msViewportStyle.appendChild(document.createTextNode("@-ms-viewport{width:auto!important}"));document.getElementsByTagName("head")[0].appendChild(msViewportStyle);}</script>
		<meta name="HandheldFriendly" content="true"/>
		<meta name="apple-mobile-web-app-capable" content="YES"/>
		<!-- Le HTML5 shim and media query for IE8 support -->
		<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script type="text/javascript" src="/v3/plugins/system/t3/base-bs3/js/respond.min.js"></script>
		<![endif]-->
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<style type="text/css">.layout#kunena+div{display:block !important}#kunena+div{display:block !important}</style>
		<!--[if lt IE 9]><script src="/v3/media/system/js/polyfill.event.js?17684feadd3199dea0eb45906f959cac" type="text/javascript"></script><![endif]-->
		<link rel="stylesheet" type="text/css" href="/test_code/vendor/thituyensinh/style.css" />
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript" src="/test_code/vendor/thituyensinh/index.js"></script>
		</head>
		<body>

	';
	echo $html;
}

function echo_footer(){
	$html ='</body>
</html>';

	echo $html;
}

function table_tuyensinh(){
	require_once dirname(__FILE__) . '/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
// require_once 'PHPExcel/IOFactory.php';
$objPHPExcel = PHPExcel_IOFactory::load(dirname(__FILE__) . "/../../thituyensinh/table_ts.xlsx");
foreach ($objPHPExcel->getWorksheetIterator() as $key => $worksheet) {
	// chi xuat neu la key 0, table chinh
	if ($key == 0) {
    $worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $nrColumns = ord($highestColumn) - 64;
 
  echo '<div class="copy-content">';

    echo '<table>';
    // $row = 3 de bo 2 row dau
    for ($row = 3; $row <= $highestRow; ++ $row) {
        echo '<tr>';
        // col = 2 de bo 2 col dau.
        for ($col = 0; $col < $highestColumnIndex; ++ $col) {


        		if ($col == 0){continue; }
        		if ($col == 1){continue; }

        		// loc chi trinh do dai hoc
	        	if ($worksheet->getCellByColumnAndRow(1, $row) == 'Trình độ cao đẳng'){
	        		continue;
	        	}

        	// xuat 3 khi la 2,
        	// xuat 2 khi la 3

	        	if ($col == 2){
	        		$cell = $worksheet->getCellByColumnAndRow(3, $row);
		            $val = nl2br($cell->getValue());
		            echo '<td>'. $val . '</td>';
		            continue;
	        	}
	        	if ($col == 3){
	        		$cell = $worksheet->getCellByColumnAndRow(2, $row);
		            $val = nl2br($cell->getValue());
		            echo '<td>' . $val . '</td>';
		            continue;
	        	}

            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val = nl2br($cell->getValue());
            echo '<td>' . $val . '</td>';
            // $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
            // echo '<td>' . $val . '<br>(Typ ' . $dataType . ')</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
    echo '</div>
      <button class="copy-btn footer-dh">Copy thong tin DHAI HOC</button>';



 echo '<div class="copy-content">';

    echo '<table>';
    // $row = 3 de bo 2 row dau
    for ($row = 3; $row <= $highestRow; ++ $row) {
        echo '<tr>';
        // col = 2 de bo 2 col dau.
        for ($col = 0; $col < $highestColumnIndex; ++ $col) {


        		if ($col == 0){continue; }
        		if ($col == 1){continue; }

        		// loc chi trinh do cao dang
	        	if ($worksheet->getCellByColumnAndRow(1, $row) == 'Trình độ đại học'){
	        		continue;
	        	}

        	// xuat 3 khi la 2,
        	// xuat 2 khi la 3

	        	if ($col == 2){
	        		$cell = $worksheet->getCellByColumnAndRow(3, $row);
		            $val = nl2br($cell->getValue());
		            echo '<td>'. $val . '</td>';
		            continue;
	        	}
	        	if ($col == 3){
	        		$cell = $worksheet->getCellByColumnAndRow(2, $row);
		            $val = nl2br($cell->getValue());
		            echo '<td>' . $val . '</td>';
		            continue;
	        	}

            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val = nl2br($cell->getValue());
            echo '<td>' . $val . '</td>';
            // $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
            // echo '<td>' . $val . '<br>(Typ ' . $dataType . ')</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
    echo '</div>
      <button class="copy-btn footer-cd">Copy thong tin CAO DANG</button>';






	} // end if key ($key == 0)
}
}