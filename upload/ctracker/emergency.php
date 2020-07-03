<?php
/**  
* <b>emergency.php</b>
* A small emergency console to reset the last functioning Board configuration
* or reset the domain settings. Please remember that <b>this file is not part of
* phpBB</b> so it is really important that you exactly READ the instructions
* before you use the file!
* 
* @author Christian Knerr (cback)
* @package ctracker
* @version 5.0.0
* @since 16.08.2006 - 00:20:13
* @copyright (c) 2006 www.cback.de
* 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*/

// CTracker_Ignore: File checked by human
// Warning........: File is not part of phpBB itself!


/*
 * Comment out the following code part to use the Emergency Console. If you stop
 * working with this file please remember to block this file again!! If not
 * everyone could access it and use the functions in here!
 * 
 * If you want access the recovery console just enter the url to that file into
 * your Browser for example:
 * 
 * www.example.com/ctracker/emergency.php
 * 
 * 
 * Our suggestion is to remove this file completely from your Board if you
 * don't need it!
 */
die('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><title>CBACK CrackerTracker - Emergency Console</title></head><body bgcolor="#000000"><div align="center"><img src="./../images/ctracker/console_pic.png" border="0" alt="ECON" title="ECON"><br /><br /><font color="#ffffff"><b>Emergency Console Blocked!</b><br />See more instructions in this file!</font></div></body></html>');

/*
 * Define some vars & constants we need
 */
define('IN_MYBB', true);
define('MYBB_ROOT', dirname(dirname(__FILE__))."/");

error_reporting(E_ALL & ~E_NOTICE);
set_magic_quotes_runtime(0); // Disable magic_quotes_runtime

// The following code (unsetting globals)
// Thanks to Matt Kavanagh and Stefan Esser for providing feedback as well as patch files

// PHP5 with register_long_arrays off?
if (@phpversion() >= '5.0.0' && (!@ini_get('register_long_arrays') || @ini_get('register_long_arrays') == '0' || strtolower(@ini_get('register_long_arrays')) == 'off'))
{
	$HTTP_POST_VARS = $_POST;
	$HTTP_GET_VARS = $_GET;
	$HTTP_SERVER_VARS = $_SERVER;
	$HTTP_COOKIE_VARS = $_COOKIE;
	$HTTP_ENV_VARS = $_ENV;
	$HTTP_POST_FILES = $_FILES;

	// _SESSION is the only superglobal which is conditionally set
	if (isset($_SESSION))
	{
		$HTTP_SESSION_VARS = $_SESSION;
	}
}

// Protect against GLOBALS tricks
if (isset($HTTP_POST_VARS['GLOBALS']) || isset($HTTP_POST_FILES['GLOBALS']) || isset($HTTP_GET_VARS['GLOBALS']) || isset($HTTP_COOKIE_VARS['GLOBALS']))
{
	die("Hacking attempt");
}

// Protect against HTTP_SESSION_VARS tricks
if (isset($HTTP_SESSION_VARS) && !is_array($HTTP_SESSION_VARS))
{
	die("Hacking attempt");
}


if (@ini_get('register_globals') == '1' || strtolower(@ini_get('register_globals')) == 'on')
{
	// PHP4+ path
	$not_unset = array('HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_COOKIE_VARS', 'HTTP_SERVER_VARS', 'HTTP_SESSION_VARS', 'HTTP_ENV_VARS', 'HTTP_POST_FILES', 'phpEx', 'phpbb_root_path');

	// Not only will array_merge give a warning if a parameter
	// is not an array, it will actually fail. So we check if
	// HTTP_SESSION_VARS has been initialised.
	if (!isset($HTTP_SESSION_VARS) || !is_array($HTTP_SESSION_VARS))
	{
		$HTTP_SESSION_VARS = array();
	}

	// Merge all into one extremely huge array; unset
	// this later
	$input = array_merge($HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS, $HTTP_SESSION_VARS, $HTTP_ENV_VARS, $HTTP_POST_FILES);

	unset($input['input']);
	unset($input['not_unset']);

	while (list($var,) = @each($input))
	{
		if (in_array($var, $not_unset))
		{
			die('Hacking attempt!');
		}
		unset($$var);
	}

	unset($input);
}

//
// addslashes to vars if magic_quotes_gpc is off
// this is a security precaution to prevent someone
// trying to break out of a SQL statement.
//
if( !get_magic_quotes_gpc() )
{
	if( is_array($HTTP_GET_VARS) )
	{
		while( list($k, $v) = each($HTTP_GET_VARS) )
		{
			if( is_array($HTTP_GET_VARS[$k]) )
			{
				while( list($k2, $v2) = each($HTTP_GET_VARS[$k]) )
				{
					$HTTP_GET_VARS[$k][$k2] = addslashes($v2);
				}
				@reset($HTTP_GET_VARS[$k]);
			}
			else
			{
				$HTTP_GET_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_GET_VARS);
	}

	if( is_array($HTTP_POST_VARS) )
	{
		while( list($k, $v) = each($HTTP_POST_VARS) )
		{
			if( is_array($HTTP_POST_VARS[$k]) )
			{
				while( list($k2, $v2) = each($HTTP_POST_VARS[$k]) )
				{
					$HTTP_POST_VARS[$k][$k2] = addslashes($v2);
				}
				@reset($HTTP_POST_VARS[$k]);
			}
			else
			{
				$HTTP_POST_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_POST_VARS);
	}

	if( is_array($HTTP_COOKIE_VARS) )
	{
		while( list($k, $v) = each($HTTP_COOKIE_VARS) )
		{
			if( is_array($HTTP_COOKIE_VARS[$k]) )
			{
				while( list($k2, $v2) = each($HTTP_COOKIE_VARS[$k]) )
				{
					$HTTP_COOKIE_VARS[$k][$k2] = addslashes($v2);
				}
				@reset($HTTP_COOKIE_VARS[$k]);
			}
			else
			{
				$HTTP_COOKIE_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_COOKIE_VARS);
	}
}


/*
 * Include some files we need for the Emergency Console
 */
require_once(MYBB_ROOT."inc/class_core.php");
$mybb = new MyBB;
require_once(MYBB_ROOT."inc/config.php");
require_once(MYBB_ROOT."inc/functions_ctracker.php");

// Connect to Database
define('TABLE_PREFIX', $config['database']['table_prefix']);

require_once(MYBB_ROOT."inc/db_{$config['database']['type']}.php");
switch($config['database']['type']) {
	case "sqlite3": $db = new DB_SQLite3; break;
	case "sqlite2": $db = new DB_SQLite2; break;
	case "pgsql": $db = new DB_PgSQL; break;
	case "mysqli": $db = new DB_MySQLi; break;
	default: $db = new DB_MySQL;
}

$db->connect($config['database']);
$db->set_table_prefix(TABLE_PREFIX);
$db->type = $config['database']['type'];

// Beziehen des Letzten Backups
$row = $db->fetch_array($db->simple_select("ctracker_config", "ct_config_value", "`ct_config_name` = 'last_backup'"));
$last_backup = date('d.m.Y H:i', $row['ct_config_value']);

$mode = $HTTP_GET_VARS['mode'];

if ($mode == 'restore_config_data') {
	restore_backup_settings('config.php');
	restore_backup_settings('settings.php');
	$success = '<font size="6" face="Verdana" color="#00cf09" style="text-decoration: blink;">Operation done successfully!</font><br/><br/>';
} elseif ($mode == 'restore_data_base') {
	restore_configuration();
	$success = '<font size="6" face="Verdana" color="#00cf09" style="text-decoration: blink;">Operation done successfully!</font><br/><br/>';
} elseif ($mode == 'manual_overwrite') {
	$bburl = array(
									'sid' => '30',
									'name' => 'bburl',
									'title' => 'Board URL',
									'description' => 'The url to your forums.<br />Include the http://. Do NOT include a trailing slash.',
									'optionscode' => 'text',
									'value' => $HTTP_POST_VARS['bburl'],
									'disporder' => '2',
									'gid' => '7',
									'isdefault' => '0'
								);
	$cookie_domain = array(
													'sid' => '37',
													'name' => 'cookiedomain',
													'title' => 'Cookie Domain',
													'description' => 'The domain which cookies should be set to. This can remain blank. It should also start with a . so it covers all subdomains.',
													'optionscode' => 'text',
													'value' => $HTTP_POST_VARS['cookie_domain'],
													'disporder' => '9',
													'gid' => '7',
													'isdefault' => '0'
												);
	$cookie_path = array(
												'sid' => '38',
												'name' => 'cookiepath',
												'title' => 'Cookie Path',
												'description' => 'The path which cookies are set to, we recommend setting this to the full directory path to your forums with a trailing slash.',
												'optionscode' => 'text',
												'value' => $HTTP_POST_VARS['cookie_path'],
												'disporder' => '10',
												'gid' => '7',
												'isdefault' => '0'
											);
	$cookie_prefix = array(
													'sid' => '39',
													'name' => 'cookieprefix',
													'title' => 'Cookie Prefix',
													'description' => 'A prefix to append to all cookies set by MyBB. This is useful if you wish to install multiple copies of MyBB on the one domain or have other software installed which conflicts with the names of the cookies in MyBB. If not specified, no prefix will be used.',
													'optionscode' => 'text',
													'value' => $HTTP_POST_VARS['cookie_prefix'],
													'disporder' => '10',
													'gid' => '7',
													'isdefault' => '0'
												);
	$seo = array(
								'sid' => '137',
								'name' => 'seourls',
								'title' => 'Enable search engine friendly URLs?',
								'description' => 'Search engine friendly URLs change the MyBB links to shorter URLs which search engines prefer and are easier to type. showthread.php?tid=1 becomes thread-1.html. <strong>Once this setting is enabled you need to make sure you have the MyBB .htaccess in your MyBB root directory (or the equivilent for your web server). Automatic detection may not work on all servers.</strong> Please see <a href="http://wiki.mybboard.net/index.php/SEF_URLS">The MyBB wiki</a> for assistance.',
								'optionscode' => 'select\nauto=Automatic Detection\nyes=Enabled\nno=Disabled',
								'value' => $HTTP_POST_VARS['seourls'],
								'disporder' => '1',
								'gid' => '17',
								'isdefault' => '0'
							);
	if (!empty($HTTP_POST_VARS['bburl'])) $db->update_query('settings', $bburl, $where="`sid` = '30'", $limit="1");
	$db->update_query('settings', $cookie_domain, $where="`sid` = '37'", $limit="1");
	$db->update_query('settings', $cookie_path, $where="`sid` = '38'", $limit="1");
	$db->update_query('settings', $cookie_prefix, $where="`sid` = '39'", $limit="1");
	$db->update_query('settings', $seo, $where="`sid` = '197'", $limit="1");
	
	// Einspielen der Settings PHP
	if (!empty($HTTP_POST_VARS['bburl'])) {
		include(MYBB_ROOT."inc/settings.php");
		
		$settings['bburl'] = "".$HTTP_POST_VARS['bburl']."";
		$settings['cookiedomain'] = "".$HTTP_POST_VARS['cookie_domain']."";
		$settings['cookiepath'] = "".$HTTP_POST_VARS['cookie_path']."";
		$settings['cookieprefix'] = "".$HTTP_POST_VARS['cookie_prefix']."";
		$settings['seourls'] = "".$HTTP_POST_VARS['seourls']."";
		
		$out = '<?php
/*********************************\\
  DO NOT EDIT THIS FILE, PLEASE USE
  THE SETTINGS EDITOR
\\*********************************/

';
		
		
		foreach($settings AS $key => $setting) {
			$out .= "\$settings['".$key."'] = \"".$setting."\";\n";
		}
		
		$out .= "\n?>";
		
		file_put_contents("./settings.php", $out);
		emergency_copy(settings);
		emergency_del_tmp(settings);
	}
	$success = '<font size="6" face="Verdana" color="#00cf09" style="text-decoration: blink;">Operation done successfully!</font><br/><br/>';
}

// Create Theme Output
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>CBACK CrackerTracker - Emergency Console</title>
			</head>
			<body bgcolor="#000000">
				<div align="center">
					<img border="0" title="ECON" alt="ECON" src="./../images/ctracker/console_pic.png" />
					<br/><br/>
					'.$success.'
					<font size="3" face="Verdana" color="#ffffff">
						Last Backup of Configuration Table: <b>'.$last_backup.'</b>
						<br/>
						<a style="color: rgb(253, 255, 0);" href="emergency.php?mode=restore_config_data">&raquo; Click here to restore configuration data files now! &laquo;</a><br />
						<a style="color: rgb(253, 255, 0);" href="emergency.php?mode=restore_data_base">&raquo; Click here to restore configuration table now! &laquo;</a>
					</font>
					<br/><br/><br/><br/>
					<form method="post" action="emergency.php?mode=manual_overwrite">
						<font size="3" face="Verdana" color="#ffffff">
							Manually override Board Configuration Settings<br/><br/>
						</font>
						<table width="80%" cellspacing="1" cellpadding="6" border="1" bgcolor="#3f3f3f" align="center">
							<tbody>
								<tr>
									<td><font size="3" face="Verdana" color="#ffffff">Board URL:</font></td>
									<td><input type="text" name="bburl" size="40" maxlength="255" class="post"/></td>
								</tr>
								<tr>
									<td><font size="3" face="Verdana" color="#ffffff">Cookie Domain :</font></td>
									<td><input type="text" name="cookie_domain" size="40" maxlength="255" class="post"/></td>
								</tr>
								<tr>
									<td><font size="3" face="Verdana" color="#ffffff">Cookie Path:</font></td>
									<td><input type="text" name="cookie_path" size="40" maxlength="255" class="post"/></td>
								</tr>
								<tr>
									<td><font size="3" face="Verdana" color="#ffffff">Cookie Prefix:</font></td>
									<td><input type="text" name="cookie_prefix" size="40" maxlength="16" class="post"/></td>
								</tr>
								<tr>
									<td><font size="3" face="Verdana" color="#ffffff">SEO Setting:</font></td>
									<td><select id="setting_seourls" name="seourls"><option selected="selected" value="auto">Automatische Erkennung</option><option value="yes">Aktivieren</option><option value="no">Deaktivieren</option></select></td>
								</tr>
								<tr>
									<td align="center" colspan="2"><br/><br/><input type="submit" value="Do it now!" name="submit"/></td>
								</tr>
							</tbody>
						</table>
						<br/><br/>
					</form>
					<font size="1" face="Verdana" color="#ffffff">
						CrackerTracker Professional &copy; 2004 - 2009 <a style="color: rgb(253, 255, 0);" target="_blank" href="http://www.cback.de">CBACK.de</a>
					</font>
				</div>
			</body>
		</html>';

/*
 * Disconnect from Database
 */
$db->close();
?>