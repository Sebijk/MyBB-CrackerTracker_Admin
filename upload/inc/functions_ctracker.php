<?php
function do_filechk() {
	global $db;

	// Lehren der Hash Tabelle
	$db->query("TRUNCATE TABLE {$db->table_prefix}ctracker_filechk");

	// Checksum checker ;)
	recursive_filechk('./../', '', "php");
}

function recursive_filechk($dir, $prefix = '', $extension) {
	global $db;

	$directory = @opendir($dir);

	while ($file = @readdir($directory)) {
		if (!in_array($file, array('.', '..'))) {
			$is_dir = (@is_dir($dir .'/'. $file)) ? true : false;

			// Create a nice Path for the found Files / Folders
			$temp_path  = '';
			$temp_path  = $dir . '/' . (($is_dir) ? strtoupper($file) : $file);
			$temp_path  = str_replace('//', '/', $temp_path);

			// Remove dots from extension Parameter
			$extension  = str_replace('.', '', $extension);

			// Fill it in our File Array if the found file is matching the extension
			if( preg_match("/^.*?\." . $extension . "$/", $temp_path) && !preg_match('/cache\\//m', $temp_path) ) {
				$filehash = @filesize($temp_path) . '-' . count(@file($temp_path));
				$filehash = md5($filehash);

				$data = array("filepath" => $temp_path, "hash" => $filehash);
				$db->insert_query("ctracker_filechk", $data);
			}

			// Directory found, so recall this function
			if ($is_dir) {
				recursive_filechk($dir .'/'. $file, $dir .'/', $extension);
			}
		}
	}

	@closedir($directory);
}

function make_backup_settings($file) {
	copy('./../inc/'.$file, './../admin/backups/'.$file.'.bak');
}

function restore_backup_settings($file) {
	copy('./../admin/backups/'.$file.'.bak', './../inc/'.$file);
}

function recover_configuration() {
	global $db;

	// Drop existing Backup Table
	$db->drop_table('ctracker_backup', $hard=false);

	// Create Backup table
	$db->query('CREATE TABLE '.$db->table_prefix.'ctracker_backup (
					`sid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
					`name` varchar(120) NOT NULL DEFAULT \'\',
					`title` varchar(120) NOT NULL DEFAULT \'\',
					`description` text NOT NULL,
					`optionscode` text NOT NULL,
					`value` text NOT NULL,
					`disporder` smallint(5) unsigned NOT NULL DEFAULT \'0\',
					`gid` smallint(5) unsigned NOT NULL DEFAULT \'0\',
					`isdefault` int(1) NOT NULL DEFAULT \'0\',
					PRIMARY KEY (`sid`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;');

	// Insert config data
	$query = $db->simple_select('settings', '*');

	while ($row = $db->fetch_array($query)) {
		$row1['sid'] = $db->escape_string($row['sid']);
		$row1['name'] = $db->escape_string($row['name']);
		$row1['title'] = $db->escape_string($row['title']);
		$row1['description'] = $db->escape_string($row['description']);
		$row1['optionscode'] = $db->escape_string($row['optionscode']);
		$row1['value'] = $db->escape_string($row['value']);
		$row1['disporder'] = $db->escape_string($row['disporder']);
		$row1['gid'] = $db->escape_string($row['gid']);
		$row1['isdefault'] = $db->escape_string($row['isdefault']);
		$db->insert_query('ctracker_backup', $row1);
	}

	// Insert Backup Timestamp
	$data = array("ct_config_value" => time());
	$db->update_query('ctracker_config', $data,  $where="`ct_config_name` = 'last_backup'", $limit="1");
}

function restore_configuration() {
	global $db;

	// Drop existing Config Table
	$db->drop_table('settings', $hard=false);

	// Create Config table
	$db->query('CREATE TABLE '.$db->table_prefix.'settings (
					`sid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
					`name` varchar(120) NOT NULL DEFAULT \'\',
					`title` varchar(120) NOT NULL DEFAULT \'\',
					`description` text NOT NULL,
					`optionscode` text NOT NULL,
					`value` text NOT NULL,
					`disporder` smallint(5) unsigned NOT NULL DEFAULT \'0\',
					`gid` smallint(5) unsigned NOT NULL DEFAULT \'0\',
					`isdefault` int(1) NOT NULL DEFAULT \'0\',
					PRIMARY KEY (`sid`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;');

	// Insert config data
	$query = $db->simple_select('ctracker_backup', '*');

	while ($row = $db->fetch_array($query)) {
		$row1['sid'] = $db->escape_string($row['sid']);
		$row1['name'] = $db->escape_string($row['name']);
		$row1['title'] = $db->escape_string($row['title']);
		$row1['description'] = $db->escape_string($row['description']);
		$row1['optionscode'] = $db->escape_string($row['optionscode']);
		$row1['value'] = $db->escape_string($row['value']);
		$row1['disporder'] = $db->escape_string($row['disporder']);
		$row1['gid'] = $db->escape_string($row['gid']);
		$row1['isdefault'] = $db->escape_string($row['isdefault']);
		$db->insert_query('settings', $row1);
	}
}

function emergency_copy($file) {
	copy('./../ctracker/'.$file.'.php', './../inc/'.$file.'.php');
}

function emergency_del_tmp($file) {
	unlink('./../ctracker/'.$file.'.php');
}
?>