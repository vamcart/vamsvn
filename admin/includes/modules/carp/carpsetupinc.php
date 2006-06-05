<?php
defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );
function HiddenField($n,$v='') {
	global $carpsetup;
	if ((!strlen($v))&&isset($carpsetup[$n])) $v=$carpsetup[$n];
	if (strlen($v)) echo '<input type="hidden" name="'.$n.'" value="'.preg_replace('/"/','&quot;',$v)."\" />\n";
}

function HiddenFields($step,$asking=0) {
	global $carpsetup;
	HiddenField('step',$step);
	if ($asking!=1) {
		if (isset($carpsetup['incdir'])) HiddenField('incdir');
		if (isset($carpsetup['chrincdir'])) HiddenField('chrincdir');
	}
	if ($asking!=2) {
		if (isset($carpsetup['proxyserver'])) HiddenField('proxyserver');
		if (isset($carpsetup['proxyport'])) HiddenField('proxyport');
		if (isset($carpsetup['proxyuser'])) HiddenField('proxyuser');
		if (isset($carpsetup['proxypass'])) HiddenField('proxypass');
	}
}

function AddToFailed($failedname) {
	global $failed,$havefailed;
	$failed.=($havefailed?', ':'').$failedname;
	$havefailed=1;
}

function CarpSetup0() {
	global $failed,$havefailed;
	
	echo '<b>Checking your server\'s PHP version...</b>';
	$vers=explode('.',PHP_VERSION);
	$needvers=array(4,0);
	$j=count($vers);
	$k=count($needvers);
	if ($k<$j) $j=$k;
	for ($i=0;$i<$j;$i++) {
		if (($vers[$i]+0)>$needvers[$i]) break;
		if (($vers[$i]+0)<$needvers[$i]) {
			echo '<span class="fail">Failed</span>. Your server is running PHP version '.PHP_VERSION.
				'. CaRP requires PHP version ';
			for ($i=0,$j=count($needvers);$i<$j;$i++) echo ($i?'.':'').$needvers[$i];
			echo ' or higher.';
			return;
		}
	}
	
	echo 'Pass<br /><br /><b>Checking your server\'s PHP function support...</b>';
	$failed='';
	$havefailed=0;
	if (trim(' a ')!='a') AddToFailed('trim');
	if (str_replace('ab','x','1ab2ab3')!='1x2x3') AddToFailed('str_replace');
	if (!file_exists(__file__)) AddToFailed('file_exists');
	if (count(explode('.','1.2.3.4'))!=4) AddToFailed('explode');
	if (strlen('12345')!=5) AddToFailed('strlen');
	if (strpos('12345','4')!=3) AddToFailed('strpos');
	if (strtolower('CaRP')!='carp') AddToFailed('strtolower');
	if (strcmp('carp','carp')||!strcmp('carp','grouper')) AddToFailed('strcmp');
	if (preg_replace('/a/','b','asdf')!='bsdf') AddToFailed('preg_replace');
	if (!preg_match('/a/','ace')) AddToFailed('preg_match');
	
	if (strlen($_SERVER['SERVER_ADDR'])) $ip=$_SERVER['SERVER_ADDR'];
	else if (strlen($_SERVER['SERVER_NAME'])||strlen($_SERVER['HOST_NAME'])) {
		$server=$_SERVER[strlen($_SERVER['SERVER_NAME'])?'SERVER_NAME':'HOST_NAME'];
		if (preg_match('/[^0-9.]/',$server)) {
			$ip=gethostbyname($server);
			if ($ip==$server) $ip='127.0.0.1';
		} else $ip=$server;
	} else $ip='127.0.0.1';
	if ($fp=fsockopen($ip,$_SERVER['SERVER_PORT'])) fclose($fp);
	else AddToFailed('fsockopen');

	if ($fp=fopen(__file__,'r')) fclose($fp);
	else AddToFailed('fopen');
	if ($p=xml_parser_create()) xml_parser_free($p);
	else AddToFailed('xml_parser_create');
	/*
	next most important to check:
	unlink, fstat, flock (just be sure function exists--okay for it to fail)
	
	not checked:
	preg_match_all, call_user_func, error_reporting, array_splices, strcasecmp, strtotime, parse_url,
	fputs, feof, fgets, clearstatcache, fclose, ftruncate, fflush, xml_parser_set_option, 
	xml_set_element_handler, xml_set_character_data_handler, fread, xml_error_string,
	xml_get_current_line_number, xml_parser_free
	*/
	
	if (strlen($failed)) {
		include_once dirname(__file__).'/carp.php';
		?>
		<span class="fail">Failed</span><br />The following functions are either disabled on your server,
			or are not working correctly.
		CaRP will not work on this server unless this situation is resolved:
		<?php echo $failed; ?><br /><br />

		<form action="http://www.geckotribe.com/rss/carp/installer_feedback.php" method="post" style="display:inline;">
		We would be appreciate your sending us the follow information to help us with future CaRP development.
		All items are optional.<br /><br />
		
		<table border="0" cellspacing="0" cellpadding="1">
		<tr>
			<td>Host name:</td>
			<td><input name="host" size="60" maxlength="255" value="<?php echo $_SERVER['SERVER_NAME']; ?>" /></td>
		</tr><tr>
			<td>CaRP Version:</td>
			<td><input name="version" size="60" maxlength="255" value="<?php echo $carpversion; ?>" /></td>
		</tr><tr>
			<td>Error message:</td>
			<td><input name="errormsg" size="60" value="Unsupported functions: <?php echo $failed; ?>" /></td>
		</tr><tr>
			<td valign="top">Comments:</td>
			<td>
				<textarea name="comments" rows="5" cols="60" wrap="virtual"></textarea><br /><br />
				If you would like a response to your comments, please indicate your email address.
			</td>
		</tr><tr>
			<td></td>
			<td><input type="submit" value="Send"></td>
		</tr>
		</table>
		</form>		
		<?php
		return;
	}
	echo "Pass<br /><br />\n";
	if (CarpSetupCreateDirectories(1)&&CarpSetupAccessDirectories(1)) {
		echo '<b>Checking for cache directories...</b>Found<br /><br />'; 
		CarpSetup7();
	} else CarpSetup1();
}

function CarpSetup1() {
	global $carpsetup;
	?>
	<b>Create cache folders:</b><br/>
	The easiest method is to enter your FTP or Telnet login name and password, and let me try to do it automatically.
	<b style="color:#c00;">If the automatic method fails for any reason, you will need to use the manual method.</b>
	Please choose your preferred method:<br /><br />
	
	<table border="1" cellpadding="5" cellspacing="1"><tr>
	<td valign="top">
		<form action="carpsetup.php" method="post">
		<?php HiddenFields(2); ?>
		<b>Automatic:</b><br />
		<table border="0" cellspacing="0" cellpadding="2">
		<tr><td>FTP&nbsp;or&nbsp;Telnet&nbsp;login:</td><td><input name="u" size="12"></td></tr>
		<tr><td>Password:</td><td><input type="password" name="p" size="12"></td></tr>
		<tr><td>&nbsp;</td><td><input type="submit" value="Continue..." /></td></tr>
		</table><br />
		NOTES:
		<ul>
		<li>This process may take a few seconds,
			and if it is successful, I'll take a few seconds attempting to load a newsfeed.
			Please be patient.</li>
		<li>If you can connect to your webserver using SFTP, SSH, or a control panel that uses SSL (HTTPS),
			you may wish to use the manual method for greater security.</li>
		</ul>
		</form>
	</td><td valign="top">
		<form action="carpsetup.php" method="post">
		<?php HiddenFields(3); ?>
		<b>Manual:</b><br />
		
		Use one of: FTP, SFTP, Telnet, SSH or your web host's control panel or file manager to temporarily give full access to the directory in which carp.php is located to all users.
		On a UNIX, Linux, or BSD server, set the permissions to 777 or read/write/execute for everyone.
		Read below for more information.
		Once you have changed the access permissions, click "Continue...":<br /><br />
		
		<input type="submit" value="Continue..." /><br /><br />
		
		<b>If you have Telnet or SSH access</b> to your server, enter this command:<br /><br />
		<code>chmod 777 <?php echo $carpsetup['chrincdir']; ?></code><br /><br />
		
		If you get a file not found error, then your login is in a "chroot" environment, making the path for Telnet or SSH different from the path that PHP scripts see.
		In that case, you'll either need to figure out and enter the path to the carp directory the way you see it when using Telnet or SSH,
			or use some other method to set access permissions.<br /><br />

		<b>If you do not have Telnet or SSH access</b> to your server,
			<a href="http://www.geckotribe.com/help/access-permissions.php" target="_blank">click here for help with using FTP, SFTP or some other method</a> (opens in a new window).
		</form>
	</td>
	</tr></table>
	<?php
}

function CarpSetupCheckAccess($desired,$mask) {
	global $carpsetup;
	$rv=0;
	clearstatcache();
	if ($dstat=stat($carpsetup['incdir'])) {
		if (($dstat['mode']&$mask)==($desired&$mask)) $rv=1;
	}
	return $rv;
}

function CarpSetup2LastTry() {
	global $carpsetup,$telnet,$ftp;
	if ($carpsetup['protocol']=='ftp') $ftp->DoCommand('site chmod 777 '.$carpsetup['chrincdir'],$rn,$rt);
	 else $telnet->DoCommand('chmod 777 '.$carpsetup['chrincdir'],$result);

	if (CarpSetupCheckAccess(0777,0777)) CarpSetup4();
	else {
		echo '<span class="fail">Unable to set access permissions automatically</span><br />';
		echo 'Please set the access permissions manually.';
		CarpSetup1();
	}
}

function CarpSetup2() {
	global $carpsetup,$telnet,$ftp;
	
	$carpsetup['protocol']='ftp';
	include_once dirname(__file__).'/PHPFTP.php';
	$ftp=new PHPFTP;
	$dotelnet=1;
	if (!$ftp->Connect('',$carpsetup['u'],$carpsetup['p'])) {
		$dotelnet=0;
		$ftp->DoCommand('site chmod 777 '.$carpsetup['incdir'],$rn,$rt);
		if (CarpSetupCheckAccess(0777,0777)) CarpSetup4();
		else {
			$ftp->DoCommand('pwd',$rn,$path);
			if ($rn{0}==2) {
				$path=($path{0}=='"')?substr($path,1,strpos(substr($path,1),'"',1)):trim($path);
				if (($start=strpos($carpsetup['incdir'],$path))!==false) {
					$carpsetup['chrincdir']=substr($carpsetup['incdir'],$start);
					CarpSetup2LastTry();
				} else if (($start=strpos($carpsetup['incdir'],'public_html'))!==false) {
					$carpsetup['chrincdir']='/www'.substr($carpsetup['incdir'],$start+strlen('public_html'));
					CarpSetup2LastTry();
				}
			} else $dotelnet=1;
		}
	}
	if ($dotelnet) {
		$carpsetup['protocol']='telnet';
		include_once dirname(__file__).'/PHPTelnet.php';
		$telnet=new PHPTelnet;
		if (!($r=$telnet->Connect('',$carpsetup['u'],$carpsetup['p']))) {
			$telnet->DoCommand('chmod 777 '.$carpsetup['incdir'],$junk);
			if (CarpSetupCheckAccess(0777,0777)) CarpSetup4();
			else {
				$telnet->DoCommand('pwd',$path);
				if (($start=strpos($carpsetup['incdir'],$path))!==false) {
					$carpsetup['chrincdir']=substr($carpsetup['incdir'],$start);
					CarpSetup2LastTry();
				} else if (($start=strpos($carpsetup['incdir'],'public_html'))!==false) {
					$carpsetup['chrincdir']='/www'.substr($carpsetup['incdir'],$start+strlen('public_html'));
					CarpSetup2LastTry();
				}
			}
		} else {
			echo '<span class="fail">Unable to set access permissions</span><br />';
			switch($r) {
			case 1:
				echo 'Unable to create network connection. Please set access permissions manually.<br /><br />';
				break;
			case 3:
				echo 'Login failed. Please be sure to enter your login name and password accurately, or set access permissions manually.<br /><br />';
				break;
			case 4:
				echo 'The version of PHP running on your server does not support functions needed to set access permissions automatically. Please do that manually instead.<br /><br />';
				break;
			}
			CarpSetup1();
		}
	}
}

function CarpSetupCreateDirectories($silent=0) {
	global $carpsetup;
	if ($silent) $ser=error_reporting(0);
	else echo 'Attempting to create cache directories...';
	$rv=(file_exists($carpsetup['incdir']."/manualcache")||mkdir($carpsetup['incdir']."/manualcache",0700))
		&&(file_exists($carpsetup['incdir']."/autocache")||mkdir($carpsetup['incdir']."/autocache",0700))
		&&(file_exists($carpsetup['incdir']."/aggregatecache")||mkdir($carpsetup['incdir']."/aggregatecache",0700));
	if (!$silent)  {
		if ($rv) echo "Success<br />\n";
		else {
			echo '<span class="fail">Unexpected error</span><br />';
			echo 'Although the access permissions on your carp directory are correct, I am unable to create subdirectories inside it. '.
				'Unable to proceed with installation.';
		}
	}
	if ($silent) error_reporting($ser);
	return $rv;
}

function CarpSetupAccessDirectories($silent=0) {
	global $carpsetup;
	$rv=1;
	if ($silent) $ser=error_reporting(0);
	else echo 'Attempting to create files in cache directories...';
	if ($f=fopen($carpsetup['incdir']."/manualcache/test",'w')) {
		fclose($f);
		unlink($carpsetup['incdir']."/manualcache/test");
		if ($f=fopen($carpsetup['incdir']."/autocache/test",'w')) {
			fclose($f);
			unlink($carpsetup['incdir']."/autocache/test");
			if ($f=fopen($carpsetup['incdir']."/aggregatecache/test",'w')) {
				fclose($f);
				unlink($carpsetup['incdir']."/aggregatecache/test");
			} else $rv=0;
		} else $rv=0;
	} else $rv=0;
	if (!$silent)  {
		if ($rv) echo "Success<br />\n";
		else echo '<span class="fail">Failed.</span> Unable to create files inside your cache directories. '.
			'If you created these directories manually (for example, with the command "mkdir manualcache", etc.), please delete them and run the installation script again. '.
			'If the installation script created them, then some unexected error is causing the problem.';
	}
	if ($silent) error_reporting($ser);
	return $rv;
}

function CarpSetup3() {
	if (CarpSetupCheckAccess(0777,0777)) {
		if (CarpSetupCreateDirectories()&&CarpSetupAccessDirectories()) CarpSetup6();
	} else {
		echo '<span class="fail">Access permissions incorrect</span><br />';
		CarpSetup1();
	}
}

function CarpSetup4() {
	if (CarpSetupCreateDirectories()&&CarpSetupAccessDirectories()) CarpSetup5();
}

function CarpSetup5() {
	global $carpsetup,$telnet,$ftp;
	if ($carpsetup['protocol']=='ftp') $ftp->DoCommand('site chmod 711 '.$carpsetup['chrincdir'],$rn,$rt);
	else $telnet->DoCommand('chmod 711 '.$carpsetup['chrincdir'],$junk);
	if (CarpSetupCheckAccess(0711,0777)) CarpSetup7();
	else {
		echo '<span class="fail">I was unable to reset the access permissions on the carp directory.</span><br />';
		CarpSetup6();
	}
}

function CarpSetup6() {
	global $carpsetup;
	?>
	<form action="carpsetup.php" method="post">
	<?php HiddenFields(7); ?>
	For security purposes, please change the access permissions for the directory where carp.php is located so that it is only writable by its owner.
	If using Telnet or SSH, enter the following command
		(changing the path if necessary as you did when setting the access permissions to 777 before):<br /><br />
	
	<code>chmod 711 <?php echo $carpsetup['chrincdir']; ?></code><br /><br />
	
	Once you have changed the access permissions, click "Continue...".<br /><br />

	<input type="submit" value="Continue..." />
	</form>
	<?php
}

function CarpSetupAskProxy() {
	global $carpsetup;
	?>
	<form action="carpsetup.php" method="post">
	<?php HiddenFields(7,2); ?>
	<table border="0" cellpadding="3" cellspacing="0" width="610">
	<tr><td colspan="3" style="color:white;background:#003399;">
		If the server where you are installing CaRP connects to the internet through a web proxy server, please enter the following.
		Otherwise, leave them blank.
	</td></tr>
	<tr>
		<td>Proxy server name:</td>
		<td>http://<input name="proxyserver" size="20"></td>
		<td>eg. www.myproxyserver.com</td>
	</tr>
	<tr>
		<td>Proxy server port:</td>
		<td><input name="proxyport" size="4" value="80"></td>
		<td>&nbsp;</td>
	</tr>
	<tr><td colspan="3" style="color:white;background:#003399;">
		If the proxy server requires a username and password, enter them here.
		Otherwise, leave them blank.
	</td></tr>
	<tr>
		<td>Username:</td>
		<td><input name="proxyuser" size="20"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><input name="proxypass" size="20"></td>
		<td>&nbsp;</td>
	</tr>
	</table><p>

	<input type="submit" value="Continue...">
	</form>
	<?php
}

function CarpSetup7() {
	global $carpsetup;
	if (isset($carpsetup['proxyserver'])) {
		$proxy=preg_replace("#/$#",'',$carpsetup['proxyserver']).((isset($carpsetup['proxyport'])&&($carpsetup['proxyport']!=80))?(':'.$carpsetup['proxyport']):'');
	} else $proxy=$carpsetup['proxyuser']=$carpsetup['proxypass']='';
	
	if (strlen($proxy)) {
		if (preg_match('/[^0-9.]/',$carpsetup['proxyserver'])) $ip=gethostbyname($carpsetup['proxyserver']);
		else $ip=$carpsetup['proxyserver'];
		$rq='http://www.geckotribe.com/help/installtest.txt';
		$port=($carpsetup['proxyport']+0)?($carpsetup['proxyport']+0):80;
		$server=$carpsetup['proxyserver'];
	} else {
		$ip=gethostbyname('www.geckotribe.com');
		$rq='/help/installtest.txt';
		$port=80;
		$server='www.geckotribe.com';
	}
	if (preg_match('/[^0-9.]/',$ip)) {
		echo "<span class=\"fail\">DNS lookup of $server failed.</span><br />CaRP may be installed properly, but I am unable to confirm at this time.";
	} else {
		if ($tfp=fsockopen($ip,$port)) {
			fputs($tfp,"GET $rq HTTP/1.0\r\nHost: $server\r\nUser-Agent: CaRPInstaller/1.0\r\n");
			if (strlen($carpsetup['proxyuser']))
				fputs($tfp,'Proxy-Authorization: Basic '.base64_encode($carpsetup['proxyuser'].':'.$carpsetup['proxypass'])."\r\n");
			fputs($tfp,"\r\n");
			do { $l=fgets($tfp,4096); } while (strlen(preg_replace("/[\r\n]/",'',$l))&&!feof($tfp));
			if (feof($tfp)) CarpSetupAskProxy();
			else {
				$l=fgets($tfp,4096);
				if (preg_match('/Installation Success/',$l)) CarpSetup8();
				else CarpSetupAskProxy();
			}
		} else CarpSetupAskProxy();
	}
}

function CarpSetup8() {
	global $carpsetup,$carpconf,$carpversion;
	include_once $carpsetup['incdir'].'/carp.php';
	if (isset($carpconf)) {
		echo "I will now attempt to display a newsfeed.<br />";
		echo '<div style="margin:15px;padding:6px;background:#ccc;border:1px solid:#333;">';
		CarpConf('maxitems',3);
		CarpConf('phperrors',E_ALL);
		CarpConf('carperrors',1);
		if (isset($carpsetup['proxyserver'])) {
			$proxy=preg_replace("#/$#",'',$carpsetup['proxyserver']).((isset($carpsetup['proxyport'])&&($carpsetup['proxyport']!=80))?(':'.$carpsetup['proxyport']):'');
		} else $proxy=$carpsetup['proxyuser']=$carpsetup['proxypass']='';
		if (strlen($proxy)) CarpConf('proxyserver',$proxy);
		if (isset($carpsetup['proxyuser'])&&strlen($carpsetup['proxyuser'])) CarpConf('proxyauth',$carpsetup['proxyuser'].':'.$carpsetup['proxypass']);
		CarpShow('http://rss.geckotribe.com/rss/9.rss');
		?>
		</div><br />
		If a newsfeed was successfully displayed above, then installation is complete.
		If error messages were displayed, you will need to resolve them.<br /><br />
		
		<h2 style="margin:0;display:inline;">To display newsfeeds in your web pages</h2>
			copy the following code and paste it into a PHP page (a page whose filename ends with ".php").
		To display newsfeeds in pages whose filenames end in ".html" or any other non-PHP extension,
			paste the following code into a new document whose name ends with ".php",
			and refer to the <a href="http://www.geckotribe.com/rss/carp/docs/examples/js.php" target="_blank">example code for converting RSS to JavaScript</a>.<br /><br />

		Change the URL on the line where "CarpCacheShow" is called to the URL of the feed you wish to display,
			and add any desired configuration settings where shown.
		For more information, please refer to the <a href="http://www.geckotribe.com/rss/carp/docs/" target="_blank">CaRP documentation</a>.<br /><br />

		<div style="margin:15px;padding:6px;background:#ccc;border:1px solid:#333;">
		&lt;?php<br>
		require_once '<?php echo $carpsetup['incdir']; ?>/carp.php';<br />
		// Add any desired configuration settings below this line using "CarpConf" and other functions<br />
		<?php
		if (isset($carpsetup['proxyuser'])&&strlen($carpsetup['proxyuser'])) echo "CarpConf('proxyauth',".$carpsetup['proxyuser'].':'.$carpsetup['proxypass'].");<br>\n";
		if (isset($proxy)&&strlen($proxy)) echo "CarpConf('proxyserver',$proxy);<br>\n";
		echo "CarpCacheShow('http://www.geckotribe.com/press/rss/pr.rss');<br>\n";
		echo "?&gt;\n";
		echo '</div>';
		
		if ((isset($proxy)&&strlen($proxy))||(isset($carpsetup['proxyuser'])&&strlen($carpsetup['proxyuser']))||(isset($carpsetup['proxypass'])&&strlen($carpsetup['proxypass']))) {
			echo "<br>You may wish to specify the proxyserver and proxyauth settings in carpconf.php rather than in every PHP file where you use CaRP.\n";
		}
	} else echo "An unexpected error occurred while attempting to load carp.php. Please resolve this issue and then load the CaRP setup assistant again.";
}
?>
