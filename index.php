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
}elseif(isset($_GET['dl'])){
	$strAction = 'download';
	$strParam = filter_var($_GET['dl'], FILTER_SANITIZE_STRING);
}elseif(isset($_GET['dl_upd'])){
	$strAction = 'download_update';
	$strParam = intval($_GET['dl_upd']);
}elseif(isset($_GET['help'])){
	$strAction = 'help';
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

function download($strParam){
	global $arrFiles;
	
	if($strParam == 'core' && isset($arrFiles['extension_pk'])){
		$val = $arrFiles['extension_pk'];
		$strDownloadLink = ($val['sf_filename'] != "") ? $val['sf_filename'] : 'http://'.get_random_mirror().'/'.$val['filename'];
		return generate_thankyou($strDownloadLink, "EQdkp Plus");
	} elseif(isset($arrFiles[$strParam])){
		$val = $arrFiles[$strParam];
		$strDownloadLink = ($val['sf_filename'] != "") ? $val['sf_filename'] : 'http://'.get_random_mirror().'/'.$val['filename'];
		return generate_thankyou($strDownloadLink, "this EQdkp Plus Extension");
	}
	
	return "Sorry, could not found package. Please check your link.";
}

function download_update($strParam){
	global $arrCoreUpdates, $strParam;
	
	if(isset($arrCoreUpdates[$strParam])){
		$val = $arrCoreUpdates[$strParam];
		$strDownloadLink = ($val['sf_filename'] != "") ? $val['sf_filename'] : 'http://'.get_random_mirror().'/'.$val['filename'];
		return generate_thankyou($strDownloadLink, "this EQdkp Plus Update");
	}
	
	return "Sorry, could not found package. Please check your link.";
}

function generate_thankyou($strURL, $strText){
	$out = '<meta http-equiv="refresh" content="3;url='.$strURL.'">';
	$out .= '<div style="font-size:34px; padding-top: 10px;">Thank you for downloading '.$strText.'!</div><br><br>
<div style="font-size:16px;">Your download should start automatically. If it doesn\'t, <a href="'.$strURL.'">download here</a>.
<br /><br />
<a href="?help"><i class="fa fa-question-circle"></i> Need help with your download file? Take a look at our help page</a></div>
<br><br><br>
<i class="fa fa-heart fa-5x" style="color:red;vertical-align:middle;"></i>
						<span class="fa-stack fa-lg" style="margin-left: -30px; margin-bottom: -10px; margin-right: 10px;">
						<i class="fa fa-circle fa-stack-2x"></i>
  						<i class="fa fa-usd fa-stack-1x fa-inverse"></i>
						</span><h1 style="display:inline; font-size:24px;">Support us</h1>
						
<div>
A project like EQdkp Plus can only exist, if we can get back some of the effort, time and love we invest in EQdkp Plus. You can give something back on the following ways:
						<ul style="margin-left:20px; list-style:inherit;">
							<li style="padding: 3px;"><i class="fa fa-usd" style="font-size:1.5em;"></i> <a onclick="document.getElementById(\'paypal\').submit();" style="cursor:pointer;">Support us financially so we can continue offering you our services like LiveUpdate</a></li>	
							<li style="padding: 3px;"><i class="fa fa-puzzle-piece" style="font-size:1.5em;"></i> <a href="http://eqdkp-plus.eu/repository/">Publish a plugin or template, so every EQdkp Plus user can use it</a></li>
							<li style="padding: 3px;"><i class="fa fa-comments" style="font-size:1.5em;"></i> <a href="http://eqdkp-plus.eu/forum/">Support us at our board</a></li>
							<li style="padding: 3px;"><i class="fa fa-cogs" style="font-size:1.5em;"></i> <a href="https://eqdkp-plus.eu/en/development.html">Take part actively in the development of EQdkp Plus</a></li>
						</ul>
						<br>So if you <i class="fa fa-heart" style="font-size:1.5em;"></i> EQdkp Plus as much as we do, think about supporting us!
</div>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" id="paypal" name="paypal">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="team@eqdkp-plus.eu">
<input type="hidden" name="lc" value="DE">
<input type="hidden" name="item_name" value="EQdkp Plus">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="currency_code" value="EUR">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
</form>

';						
	return $out;
}

function showCategory($intCategoryID){
	global $arrFiles, $arrCoreVersions, $arrCoreUpdates;
	
	$out = '<a href="index.php"><i class="fa fa-chevron-left fa-lg" style="font-size: 20px;"></i> Back to Categories</a><br /><br />';

	foreach($arrFiles as $key => $val){
		$strDownloadLink = '?dl=core';

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
		
		foreach($arrCoreUpdates as $key2 => $val){
			$strDownloadLink = '?dl_upd='.$key2;
			$out .= '<a href="'.$strDownloadLink.'" style="display:block;"><i class="fa fa-lg fa-download"></i> '.$val['name'].'</a>';
		}
		
		$out .= '<div class="clear"></div>
		
		
	</div>';
	}
	
			break;
			
		}
		
		if($intCategoryID == $val['category']){
			if($key === 'extension_pk') continue;
			$strDownloadLink = '?dl='.$key;
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

function display_help(){
	$out = '
      <h2>Install EQdkp Plus</h2>
      <p>Not everyone is a web professional. That\'s why we have collected the most serious steps needed to get started with EQdkp Plus.</p>  

      <h3>Download &amp; Upload</h3>
  
  
      <ul>
<li>First, Download the EQdkp Plus Core Package</li>
<li>Unzip the Package on your local PC</li>
<li>Upload the two files (one zip-Archive and one file named install.php) into the desired folder of your webspace.</li>
<li>Open the install.php with your browser. If you had uploaded the files into the folder "<em>eqdkp</em>", you have to browse to www.deinedomain.de/eqdkp/install.php</li>
<li>Now the package will be unzipped and you will redirected to the Installer of EQdkp Plus</li>
<li>If the package can\'t be unzipped, you have to unzip the uploaded archive on your local PC und upload all unzipped files to the desired folder of your webspace.</li>
</ul>  


      <h3>Installation</h3>
  
  
      <ul>
<li>First, the <a href="en/requirements.html" title="Requirements">Requirements</a> of your server will be checked</li>
<li>If php safemode is enabled or you don\'t want to give folders writing permissions, you can activate the FTP-Mode. Ask your Hoster for the FTP Credentials.</li>
<li>Create a random Encryption-Key that you should store securly. With this Key, critical information will be stored encrypted, like your users\' Email-Addreses.</li>
<li>Next, insert the Database-Credentials provided by your Hoster.</li>
<li>Now select the game and some other settings. All settings can be changed after the installation, too.</li>
</ul> 
	
	<h2>Update EQdkp Plus</span></h2>	
	To update your EQdkp Plus installation, you can
	      <ul>
<li>Use a suitable Update packages</li>
<li>Use the latest core packages</li>
</ul> 
The difference between those options is just the size of the package and the amount of included files. 
For both, the instructions are:
      <ul>
<li>Download update package or core package</li>
<li>Extract the downloaded package on local PC or your server</li>
<li>Replace the existing files with the extracted files</li>
<li>Follow the instructions at the maintenance mode, if there are database changes needed</li>
</ul> 
	

<h2>Install or Upgrade Extensions manually</span></h2>
<ul><li>Download the extension you want.Make sure the EQdkp Plus Version fits with the Extension</li>
<li> Extract the downloaded extension. You will get some folders. The first one is named like the package name, e.g. plugin-chat-0.1.1.</li>
<li> Open the package.xml in the root folder of your downloaded extension and note down the values for "install type" and "folder".</li>
<li> Go to your EQdkp Plus installation and create a folder, dependend of type and folder, see <a href="#Types_and_folders">#Types and folders</a></li>
<li> Upload the extension files to your created folder. You have to take the files from the folder "plugin-chat-0.1.1", that means the first folder where a .php file can be found.</li></ul>

<h2><span class="mw-headline" id="Types_and_folders">Types and folders</span></h2>
<table class="wikitable table">

<tbody><tr class="hintergrundfarbe5">
<th width="120px;"> Type </th>
<th> folder
</th></tr>
<tr>
<td> <b>plugin</b> </td>
<td> plugins/<i>FOLDER_FROM_PACKAGE_XML</i>
</td></tr>
<tr>
<td> <b>template</b> </td>
<td> templates/<i>FOLDER_FROM_PACKAGE_XML</i>
</td></tr>
<tr>
<td> <b>portal</b> </td>
<td> portal/<i>FOLDER_FROM_PACKAGE_XML</i>
</td></tr>
<tr>
<td> <b>game</b> </td>
<td> games/<i>FOLDER_FROM_PACKAGE_XML</i>
</td></tr>
<tr>
<td> <b>language</b> </td>
<td> <i>EQdkp-Root-folder</i>
</td></tr></tbody></table>

';
	
	return $out;
}

function execute(){
	global $strAction, $strParam;
	
	if($strAction == 'list'){
		echo showCategories();
	} elseif($strAction == 'category'){
		showCategory($strParam);
	} elseif($strAction == 'download'){
		echo download($strParam);
	} elseif($strAction == 'download_update'){
		echo download_update($strParam);
	}elseif($strAction == 'help'){
		echo display_help();
	}
}

?>
<!DOCTYPE html>
						<html>
						<head>
							<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

							<title>EQdkp Plus - Repository Mirror 1</title>
							<link rel='stylesheet' href='src/fontawesome/font-awesome.min.css' type='text/css' media='screen' />
							<meta name="viewport" content="width=device-width, initial-scale=1" />
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
							
							table, th, td {
							   border-bottom: 1px solid #ddd;
							   padding: 2px;
							}
							
							th {
								background-color: #efefef;
							}
							
							tr:nth-child(even) {background-color: #f2f2f2}

							td {
								padding: 5px;
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