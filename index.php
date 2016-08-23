<?php
ini_set('display_error', 1);
$arrMirrorlist = array(
	'mirrordl1.eqdkp-plus.eu',
);


define("EQDKP_INC", true);
if(!file_exists('mirror_cache.php')) die("No mirror file available.");
include_once('mirror_cache.php');

$strAction = "list";
$strParam = false;

if(isset($_GET['c'])){
	$strParam = intval($_GET['c']);
	$strAction = 'category';
}


function showCategories(){
	$arrCategories = array(
		//Core
		'0' => array(
			'name' => 'EQdkp Plus Core',
			'icon' => 'fa-cog',
			'subtitle' => 'Download the latest version of EQdkp Plus.',
		),
		'7' => array(
			'name' => 'Games',
			'icon' => 'fa-gamepad',
		),
		'10' => array(
			'name' => 'Hooks',
			'icon' => 'fa-code',
		),
		'11' => array(
			'name' => 'Languages',
			'icon' => 'fa-globe',
		),
		'1' => array(
			'name' => 'Plugins',
			'icon' => 'fa-cogs',
		),
		'3' => array(
			'name' => 'Portal Modules',
			'icon' => 'fa-columns',
		),
		'2' => array(
			'name' => 'Templates',
			'icon' => 'fa-tint',
		),
		'12' => array(
			'name' => 'Tools',
			'icon' => 'fa-wrench',
		),
	);
	$out = "";
	foreach($arrCategories as $intKey => $val){
		$out .= '
			<div class="extCategoryContainer">
		<div>
			<div class="grid1">
				<a href="?c='.$intKey.'" style="color:#000;"><i class="fa '.$val['icon'].'" ></i></a>
			</div>
			
			<div class="grid7">
				<h2 style="font-size: 17px;">
					<a href="?c='.$intKey.'" style="display:block;">'.$val['name'].'</a>
				</h2>
				'.((isset($val['subtitle'])) ? $val['subtitle'] : '').'
			</div>

		</div>
		<div class="clear"></div>
	</div>
		';
	}
	
	return $out;
}

function showCategory($intCategoryID){
	global $arrFiles, $arrCoreVersions, $arrCoreUpdates;
	
	$out = '<a href="index.php"><i class="fa fa-chevron-left fa-lg" style="font-size: 20px;"></i> Back to Categories</a><br /><br />';

	foreach($arrFiles as $key => $val){
		$strDownloadLink = ($val['sf_filename'] != "") ? $val['sf_filename'] : 'http://'.get_random_mirror().'/'.$val['filename'];

		if($intCategoryID == 0 && $key === 'extension_pk'){

			$out .= '<div class="extCategoryContainer">
		<div>
			<div class="grid1">
				<a href="'.$strDownloadLink.'">
				<i class="fa fa-cog"></i>
				</a>
			</div>
			
			<div class="grid7" style="max-width: 800px;">
				<h2 style="font-size: 17px;">
					<a href="'.$strDownloadLink.'" style="display:block;">EQdkp Plus Core, '.resolveCoreVersion($val['version']).'</a>
				</h2>
				Released '.date('d-m-Y', $val['releasedate']).'<br />
				
				<a href="'.$strDownloadLink.'" style="display:block;"><i class="fa fa-lg fa-download"></i> Download</a><br /><br />
				
				The EQdkp Plus Core Version comes without plugins, portal modules and templates. You can download all extensions at the Extension Management Page after you have installed EQdkp Plus or from our Download-Section.
			</div>

		</div>
		<div class="clear"></div>
		
		
	</div>
	
	<h2>Core Updates</h2>
	';
	//Display Core Updates
	if(is_array($arrCoreUpdates)){
		$out .= '<div class="extCategoryContainer">';
		
		foreach($arrCoreUpdates as $key => $val){
			$strDownloadLink = ($val['sf_filename'] != "") ? $val['sf_filename'] : 'http://'.get_random_mirror().'/'.$val['filename'];
			$out .= '<a href="'.$strDownloadLink.'" style="display:block;"><i class="fa fa-lg fa-download"></i> '.$val['name'].'</a>';
		}
		
		$out .= '<div class="clear"></div>
		
		
	</div>';
	}
	
			break;
			
		}
		
		if($intCategoryID == $val['category']){
			if($key === 'extension_pk') continue;
			
			$out .= '<div class="extCategoryContainer">
		<div>
			<div class="grid1">
				<a href="'.$strDownloadLink.'">
				<i class="fa fa-download"></i>
				</a>
			</div>
			
			<div class="grid7" style="max-width: 800px;">
				<h2 style="font-size: 17px;">
					<a href="'.$strDownloadLink.'" style="display:block;">'.$val['name'].', '.$val['version'].'</a>
				</h2>
				Released '.date('d-m-Y', $val['tstamp']).'<br />
				For EQdkp Plus '.resolveCoreVersion($val['dep_coreversion']).'<br /><br />
				'.$val['description'].'<br />
				<a href="'.$strDownloadLink.'" style="display:block;"><i class="fa fa-lg fa-download"></i> Download</a><br />
				

				
			</div>

		</div>
		<div class="clear"></div>
	</div>';
			
		}
		
		
	}
	
	echo $out;
}

function resolveCoreVersion($strVersion){
	global $arrCoreVersions;
	return (isset($arrCoreVersions[$strVersion]) ? $arrCoreVersions[$strVersion] : $strVersion);
}

function get_random_mirror(){
	global $arrMirrorlist;
	
	$randomKey = array_rand($arrMirrorlist);
	return $arrMirrorlist[$randomKey];
}

function execute(){
	global $strAction, $strParam;
	
	if($strAction == 'list'){
		echo showCategories();
	} elseif($strAction == 'category'){
		showCategory($strParam);
	}
}

?>
<!DOCTYPE html>
						<html>
						<head>
							<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

							<title>EQdkp Plus - Repository Mirror 1</title>
							<link rel='stylesheet' href='src/fontawesome/font-awesome.min.css' type='text/css' media='screen' />
							<style type="text/css">
							/* body */
							html {
								height: 100%;
							}
							
							body {
								background: #0e0e0e;
								font-size: 14px;
								font-family: Tahoma,Arial,Verdana,sans-serif;
								color: #000;
								padding:0;
							  	margin:0;
								line-height: 20px;
							}
								
							
							.wrapper{
								background: #2e78b0; /* Old browsers */
								background: -moz-linear-gradient(top,  #2e78b0 0%, #193759 100%); /* FF3.6+ */
								background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#2e78b0), color-stop(100%,#193759)); /* Chrome,Safari4+ */
								background: -webkit-linear-gradient(top,  #2e78b0 0%,#193759 100%); /* Chrome10+,Safari5.1+ */
								background: -o-linear-gradient(top,  #2e78b0 0%,#193759 100%); /* Opera 11.10+ */
								background: -ms-linear-gradient(top,  #2e78b0 0%,#193759 100%); /* IE10+ */
								background: linear-gradient(to bottom,  #2e78b0 0%,#193759 100%); /* W3C */
								filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2e78b0', endColorstr='#193759',GradientType=0 ); /* IE6-9 */
								font-size: 14px;
								font-family: Tahoma,Arial,Verdana,sans-serif;
								color: #000000;
								padding:0;
							  	margin:0;
								line-height: 20px;
							}							
							
							.header {
								padding-top: 10px;
								font-size: 45px;
								font-weight: bold;
								text-shadow: 1px 1px 2px #fff;
								filter: dropshadow(color=#fff, offx=1, offy=1);
								border: none;
								color:  #fff;
								text-align:center;
								vertical-align: middle;
								font-family: 'Trebuchet MS',Arial,sans-serif;
								
								background: url(src/background-head.svg) no-repeat scroll center top transparent;
								background-size: 100%;
							}
							
							.header img {
								height: 150px;
								vertical-align: middle;
							}
							
							.footer {
								margin-top: 10px;
								color: #fff;
								text-align: center;
								background-color: #0e0e0e;
								padding: 10px 40px 10px;
							}
							
							.footer a, .footer a:link, .footer a:visited {
								color: #fff;
								text-decoration: none;
							}
							
							.footer a:hover {
								text-decoration: underline;
							}
							
							.innerWrapper {
								background-color: #f8f8f8;
							}
									
							h1, h2, h3 {
								font-family: 'Trebuchet MS',Arial,sans-serif;
							    font-weight: bold;
							    margin-bottom: 10px;
							    padding-bottom: 5px;
								border-bottom: 1px solid #CCCCCC;
								margin-top: 5px;
							}
							
							h1 {
							    font-size: 20px;
							}
							
							h2 {
								font-size: 18px;
							}
							
							h3 {
								font-size: 14px;
								border-bottom: none;
								margin-bottom: 5px;
							}
									
							/* Links */
							a,a:link,a:active,a:visited {
								color: #4E7FA8;
								text-decoration: none;
							}
							
							a:hover {
								color: #000;
								text-decoration: none;
							}
							
							.content {
								width: 960px;
								padding: 5px;
								margin: auto;
							}
							
							.extCategoryContainer {
								padding: 15px;
								border: 1px solid #DDD;
								background-color: #fff;
								margin-bottom: 10px;
							}
							
							.extCategoryContainer .grid1 i {
								font-size: 60px;
							}
							
							*[class*="grid"] {
								float: left;
								margin-left: 10px;
								margin-right: 10px;
								display: inline;
							}

							.grid1 {
								width: 60px;
							}

							.clear {
								clear: both;
							}

							.header h1 {
								padding-left: 40px;
								padding-top: 30px;
								font-size: 50px;
								font-weight: bold;
								text-shadow: 1px 1px 2px #fff;
								filter: dropshadow(color=#fff, offx=1, offy=1);
								border: none;
								line-height: 55px;
							}

							.header img {
								float: left;
							}

							.headerInner{
								width: 960px;
								margin: auto;
							}
							
							@media all and (max-width: 899px) {
								.grid50 {
									float: none;
									margin-left: 0px;
									margin-right: 0px;
									display: block;
									width: 95%;
								}
								
								.headerInner img {
									width: 150px;
									float: none;
									display: none;
								}
								
								.content {
									width: 95%;
								}
								.headerInner{
									width: 100%;
								}
								
								
								.headerInner h1 {
									padding-left: 5px;
									padding-top: 5px;
									font-size: 30px;
									line-height: 35px;
								}
								
								.fb-page, 
								.fb-page span, 
								.fb-page span iframe[style] { 
									width: 100% !important; 
								}
							}


						</style>
						</head>

						<body>
									
						<div class="wrapper">
							<div class="header">
								<div class="headerInner">
									<a href="index.php"><img src="src/logo.svg" alt="EQdkp Plus" class="absmiddle" style="height: 130px;"/></a>
									<h1>EQdkp Plus Repository Mirror 1</h1>
									<div class="clear"></div>
								</div>
							</div>
		
							<div class="innerWrapper">
								<div class="content">
									<?php
										execute();
									?>
								
								</div>

							</div>	
							
					</div>	
					<div class="footer">
							<a href="https://www.facebook.com/EQdkpPlus"><i class="fa fa-lg fa-facebook"></i> Facebook</a><br />
							<a href="https://twitter.com/#!/EQdkpPlus"><i class="fa fa-lg fa-twitter"></i> Twitter</a><br /><br />
						
					
					
						<a href="http://eqdkp-plus.eu" target="_new">EQDKP Plus</a> &copy; 2003 - 2016 by EQDKP Plus Developer Team | Mirror last update: <?php if (isset($intLastUpdate)) echo date("d-m-Y H:i", $intLastUpdate); ?>
							
							
					</div>	
					</body>
					</html>