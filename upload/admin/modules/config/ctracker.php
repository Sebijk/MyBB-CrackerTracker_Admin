<?php
/**
 * MyBB 1.4
 * Copyright © 2008 MyBB Group, All Rights Reserved
 *
 * Website: http://www.mybboard.net
 * License: http://www.mybboard.net/about/license
 *
 * $Id:$
 */

// Direktzugriff auf die Datei verhindern
if(!defined("IN_MYBB")) {
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

// Laden der Sprachdatei
$lang->load("config_ctracker");

// Laden der Funktionen
require_once MYBB_ROOT."inc/functions_ctracker.php";

// Beziehen des letzten Checksum Dates
$row = $db->fetch_array($db->simple_select("ctracker_config", "ct_config_value", "`ct_config_name` = 'last_checksum_scan'"));
if (!$row['ct_config_value'] == "0") {
	$last_checksum = date($lang->ctracker_checksum_desc_2,$row['ct_config_value']);
	$last_checksum = $lang->ctracker_checksum_desc."<br /><br />".$lang->ctracker_checksum_desc_1."<b>".$last_checksum." </b>".$lang->ctracker_checksum_desc_3;
} else {
	$last_checksum = $lang->ctracker_checksum_desc."<br /><br /><b>".$lang->ctracker_checksum_desc_4."</b>";
}

// Beziehen des letzten Restore Dates
if ($db->table_exists("ctracker_backup")) {
	$row = $db->fetch_array($db->simple_select("ctracker_config", "ct_config_value", "`ct_config_name` = 'last_backup'"));
	if (!$row['ct_config_value'] == "0") {
		$last_restore = date($lang->ctracker_restore_format,$row['ct_config_value']);
		$last_restore = $lang->ctracker_restore_last.$last_restore;
	} else {
		$last_restore = $lang->ctracker_restore_none;
	}
}

// Hinzufügen des Menüpunktes im ACP
$page->add_breadcrumb_item($lang->ctracker_system, "index.php?module=config/ctracker");

// Aufbau des Submenü
if($mybb->input['action'] == 'restore' || $mybb->input['action'] == 'checksum' || !$mybb->input['action']) {
	$sub_tabs['ct_credits'] = array(
		'title'				=>	$lang->ctracker_credits,
		'link'				=>	"index.php?module=config/ctracker",
		'description'	=>	"<center><img border=\"0\" alt=\"CrackerTracker Header\" title=\"CrackerTracker Header\" src=\"../images/ctracker/acp_head_logo.png\"/></center><br />".$lang->ctracker_credits_desc
	);
	$sub_tabs['checksum'] = array(
		'title'				=>	$lang->ctracker_checksum,
		'link'				=>	"index.php?module=config/ctracker&amp;action=checksum",
		'description'	=>	"<center><img border=\"0\" alt=\"CrackerTracker Header\" title=\"CrackerTracker Header\" src=\"../images/ctracker/acp_head_logo.png\"/></center><br />".$last_checksum
	);
	$sub_tabs['restore'] = array(
		'title'				=>	$lang->ctracker_restore,
		'link'				=>	"index.php?module=config/ctracker&amp;action=restore",
		'description'	=>	"<center><img border=\"0\" alt=\"CrackerTracker Header\" title=\"CrackerTracker Header\" src=\"../images/ctracker/acp_head_logo.png\"/></center><br />".$lang->ctracker_restore_desc
	);
}

$plugins->run_hooks("admin_config_warning_begin");

// Ausgabe der Credits
// Ausgabe bei Angabe keiner Aktion
if(!$mybb->input['action']) {
	// ??????????????????????????????
	$plugins->run_hooks("admin_config_warning_start");

	// Seiten Titel ausgeben
	$page->output_header($lang->ctracker_system." - ".$lang->ctracker_credits);

	// Ausgeben des aktiven Submenü
	$page->output_nav_tabs($sub_tabs, 'ct_credits');

	// Beginn der Credits Tabelle
	// Erzeugen einer neuen Tabelle
	$table = new Table;
	// Erzeugen einer neuen Zelle
	$table->construct_cell("<br/><center>
													<b>".$lang->ctracker_credits_1."</b><br/>
													Christian Knerr (CBACK)
													<br/><br/><br/>
													<b>".$lang->ctracker_credits_2."</b><br/>
													<a target=\"_blank\" href=\"http://www.cback.de\">www.cback.de</a><br/>
													<a target=\"_blank\" href=\"http://www.community.cback.de\">CBACK Community</a>
													<br/><br/><br/>
													<b>".$lang->ctracker_credits_3."</b><br/>
													Crystal Vista XT<br/>
													<a target=\"_blank\" href=\"http://www.paolomod.altervista.org\">PaoloMOD</a>
													<br/><br/><br/>
													<b>".$lang->ctracker_credits_4."</b><br/>
													<a target=\"_blank\" href=\"http://www.cback.de\">CrackerTracker MOD Download</a><br/>
													<br/><br/></center>",
													array('colspan' => 1));
	// Erzeugen einer neuen Zeile
	$table->construct_row();
	// ??????????????????????????
	$no_results = true;

	// Beginn der Danke an... Tabelle
	// Erzeugen einer neuen Tabelle
	$table2 = new Table;
	// Erzeugen einer neuen Zelle
	$table2->construct_cell("<br/><center>
													<b>".$lang->ctracker_credits_thx_8."</b><br />
													Robert Kuntz<br />
													(<a target=\"_blank\" href=\"http://www.broatcast.de\">Broatcast Host</a>)<br />
													(<a target=\"_blank\" href=\"http://www.board.broatcast.de\">Broatcast Board</a>)<br />
													Sebijk<br />
													(<a target=\"_blank\" href=\"http://www.mybbcoder.info/\">MyBBCoder</a>)<br />
													(<a target=\"_blank\" href=\"http://www.sebijk.com/\">Home of the Sebijk.com</a>)
													<br /><br /><br />
													<b>".$lang->ctracker_credits_thx_9."</b><br />
													Robert Kuntz<br />
													(<a target=\"_blank\" href=\"http://www.broatcast.de\">Broatcast Host</a>)<br />
													(<a target=\"_blank\" href=\"http://www.board.broatcast.de\">Broatcast Board</a>)<br />
													<br /><hr><br />
													".$lang->ctracker_credits_thx_1."
													<br/><br/><br/>
													<b>".$lang->ctracker_credits_thx_2."</b><br/>
													Tekin Birdüzen<br/>
													(<a target=\"_blank\" href=\"http://www.cybercosmonaut.de\">cYbercOsmOnauT</a>)
													<br/><br/><br/>
													<b>".$lang->ctracker_credits_thx_3."</b><br/>
													Bernhard Jaud<br/>
													(GenuineParts)
													<br/><br/><br/>
													<b>".$lang->ctracker_credits_thx_4."</b><br/>
													mc-dragon<br/>
													(Englisch)
													<br/><br/><br/>
													<b>".$lang->ctracker_credits_thx_5."</b><br/>
													George<br/>
													Sommerset<br/>
													(<a target=\"_blank\" href=\"http://www.englisch-hilfen.de\">www.englisch-hilfen.de</a>)
													<br/><br/><br/>
													<b>".$lang->ctracker_credits_thx_6."</b><br/>
													Johnny (diegoriv)<br/>
													(<a target=\"_blank\" href=\"http://alpinum.at\">Alpinum.at</a>)
													<br/><br/><br/>
													<b>".$lang->ctracker_credits_thx_7."</b><br/>
													".$lang->ctracker_credits_thx_10."
													<br /><br /></center>",
													array('colspan' => 1));
	// Erzeigen einer neuen Zeile
	$table2->construct_row();
	// ??????????????????????????
	$no_results = true;

	// Beginn der CBACK Spenden Tabelle
	// Erzeugen einer neien Tabelle
	$table3 = new Table;
	// Erzeugen einer neuen Zelle
	$table3->construct_cell("<br/>
														".$lang->ctracker_credits_donate_1_0."
														<b>".$lang->ctracker_credits_donate_1_1."</b>
														".$lang->ctracker_credits_donate_1_2.$lang->ctracker_credits_donate_1_3."
														<br /><br />
														".$lang->ctracker_credits_donate_1_3."
														<br /><br />
														<center>
														<form target=\"_blank\" method=\"post\" action=\"https://www.paypal.com/cgi-bin/webscr\">
														<input type=\"hidden\" value=\"_s-xclick\" name=\"cmd\"/>
														<input type=\"image\" border=\"0\" alt=\"Zahlen Sie mit PayPal - schnell, kostenlos und sicher!\" name=\"submit\" src=\"https://www.paypal.com/de_DE/i/btn/x-click-but04.gif\"/>
														<img width=\"1\" height=\"1\" border=\"0\" src=\"https://www.paypal.com/de_DE/i/scr/pixel.gif\" alt=\"\"/>
														<input type=\"hidden\" value=\"-----BEGIN PKCS7-----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-----END PKCS7-----\" name=\"encrypted\"/>
														</form>
														<br />",
													array('colspan' => 1));
	// Erzeugen einer neuen Zeile
	$table3->construct_row();
	// ??????????????????????????
	$no_results = true;

	// Ausgabe der Tabelle und Festlegung des Tabellen Headers
	$table->output("<center>".$lang->ctracker_credits."<br /><img border=\"0\" alt=\"{$lang->ctracker_credits}\" title=\"{$lang->ctracker_credits}\" src=\"../images/ctracker/acp_credits_2.png\"/></center>");
	$table2->output("<center>".$lang->ctracker_credits_thx."<br /><img border=\"0\" alt=\"{$lang->ctracker_credits_thx}\" title=\"{$lang->ctracker_credits_thx}\" src=\"../images/ctracker/acp_credits_3.png\"/></center>");
	$table3->output("<center>".$lang->ctracker_credits_donate."<br /><img border=\"0\" alt=\"{$lang->ctracker_credits_donate}\" title=\"{$lang->ctracker_credits_donate}\" src=\"../images/ctracker/acp_credits_1.png\"/></center>");

	// Der Return
	$page->output_footer();
}

// Ausgabe des Prüfsummenchecks
if($mybb->input['action'] == "checksum") {
	$todo = $HTTP_GET_VARS['do'];
	// ??????????????????????????????
	$plugins->run_hooks("admin_config_warning_add_type");

	// Seiten Titel ausgeben
	$page->output_header($lang->ctracker_system." - ".$lang->ctracker_checksum);

	// Ausgeben des aktiven Submenü
	$page->output_nav_tabs($sub_tabs, 'checksum');

	// Beginn der Funktions Tabelle
	// Erzeugen einer neuen Tabelle
	$table = new Table;
	// Erzeugen einer neuen Zelle
	$table->construct_cell("<a style=\"text-decoration:none;\" href=\"index.php?module=config/ctracker&amp;action=checksum&amp;do=make\"><img border=\"0\" alt=\"{$lang->ctracker_checksum_func_makesum}\" title=\"{$lang->ctracker_checksum_func_makesum}\" src=\"../images/ctracker/fc_icon_1.png\"/><br />{$lang->ctracker_checksum_func_makesum}</a>", array("class" => "align_center", "width" => 150));
	$table->construct_cell("<a style=\"text-decoration:none;\" href=\"index.php?module=config/ctracker&amp;action=checksum&amp;do=check\"><img border=\"0\" alt=\"{$lang->ctracker_checksum_func_checksum}\" title=\"{$lang->ctracker_checksum_func_checksum}\" src=\"../images/ctracker/fc_icon_2.png\"/><br />{$lang->ctracker_checksum_func_checksum}</a>", array("class" => "align_center", "width" => 150));
	// Erzeugen einer neuen Zeile
	$table->construct_row();
	// ??????????????????????????
	$no_results = true;

	// Beginn der Systemausgabe Tablle
	// Erzeugen einer neuen Tabelle
	$table2 = new Table;
	// Überprüfen der Existenze von Post DO
	if (!isset($todo)) {
		// Erzeugen einer neuen Zelle
		$table2->construct_cell("<center><b>".$lang->ctracker_checksum_sys_chose."</b></center>", array('colspan' => 1));
		// Erzeugen einer neuen Zeile
		$table2->construct_row();
		// ??????????????????????????
		$no_results = false;
	// Überprüfen auf Aktuallisierung der Checksummen
	} elseif ($todo == "make") {
		// Beziehen des Aktuellen Timestamp und Erstellen des Update Array's
		$data = array("ct_config_value" => time());
		// Aktuallisierungzeit in Datenbank schreiben
		$db->update_query('ctracker_config', $data, $where="`ct_config_name` = 'last_checksum_scan'", $limit="1");

		// Erzeugen einer neuen Zelle
		$table2->construct_cell("<center><b>".$lang->ctracker_checksum_sys_make."</b></center>", array('colspan' => 1));
		// Erzeugen einer neuen Zeile
		$table2->construct_row();
		// ??????????????????????????
		$no_results = false;

		// Beziehen der Aktuellen Checksummen
		do_filechk();
	} elseif ($todo == "check") {
		// Erstellen des Tabellen Header
		$table2->construct_header($lang->ctracker_checksum_sys_datapath, array("class" => "align_center", "width" => "80%"));
		$table2->construct_header($lang->ctracker_checksum_sys_status, array("class" => "align_center", "width" => "20%"));

		// Beziehen der Alten Checksummen
		$query = $db->query("SELECT * FROM {$db->table_prefix}ctracker_filechk");
		while($row = $db->fetch_array($query)) {
			$checksum[] = $row;
		}

		foreach($checksum as $row) {
			// ????????????????????????????
			$current_hash = '';
			$current_hash = @filesize($row['filepath']).'-'.count(@file($row['filepath']));

			// Testen auf Löschen
			if ($current_hash == '-1') {
				$filestatus = $lang->ctracker_ckecksum_sys_deleted;
				$color = '#0300FF';
			// Testen auf Änderung
			} elseif (md5($current_hash) != $row['hash']) {
				$filestatus = $lang->ctracker_ckecksum_sys_changed;
				$color = '#FF1200';
			// Ausgabe auf Unversehrtheit
			} else {
				$filestatus = $lang->ctracker_ckecksum_sys_unchanged;
				$color = '#269F00';
			}

			// Entfernen des "./../" aus dem Dateipath
			$path_cleaned = str_replace('./../', '', $row['filepath']);

			// Ausgabe des Dateinamen/path
			$table2->construct_cell($path_cleaned, array('colspan' => 1));
			// Augabe des Dateistatus
			$table2->construct_cell('<b><font style="color:'.$color.'">'.$filestatus.'</font></b>', array('colspan' => 1, 'class' => 'align_center'));
			// Erzeugen einer neuen Zeile
			$table2->construct_row();
			// ??????????????????????????
			$no_results = false;
		}
	}
	// Ausgabe der Tabelle und Festlegung des Tabellen Headers
	$table->output("<center>".$lang->ctracker_checksum_func."</center>");
	$table2->output("<center>".$lang->ctracker_checksum_sys."</center>");

	// Der Return
	$page->output_footer();
}

// Ausgabe des Systemrestores
if($mybb->input['action'] == "restore") {
	$todo = $HTTP_GET_VARS['do'];
	// ??????????????????????????????
	$plugins->run_hooks("admin_config_warning_start");

	// Seiten Titel ausgeben
	$page->output_header($lang->ctracker_system." - ".$lang->ctracker_restore);

	// Ausgeben des aktiven Submenü
	$page->output_nav_tabs($sub_tabs, 'restore');

	// Beginn der Credits Tabelle
	// Erzeugen einer neuen Tabelle
	$table = new Table;
	// Erzeugen einer neuen Zelle
	if (!isset($todo)) {
		$table->construct_cell("<br/><center><img border=\"0\" alt=\"{$lang->ctracker_restore}\" title=\"{$lang->ctracker_restore}\" src=\"../images/ctracker/recovery.png\"/><br />
														<b>".$last_restore."</b></center>", array('colspan' => 1));
	} elseif ($todo == "backup") {
		make_backup_settings('config.php');
		make_backup_settings('settings.php');
		recover_configuration();
		$table->construct_cell("<br/><center><img border=\"0\" alt=\"{$lang->ctracker_restore}\" title=\"{$lang->ctracker_restore}\" src=\"../images/ctracker/recovery.png\"/><br />
														<b><font style='color:#269F00'>".$lang->ctracker_restore_make."</font></b></center>", array('colspan' => 1));
	} elseif ($todo == "restore") {
		restore_backup_settings('config.php');
		restore_backup_settings('settings.php');
		restore_configuration();
		$table->construct_cell("<br/><center><img border=\"0\" alt=\"{$lang->ctracker_restore}\" title=\"{$lang->ctracker_restore}\" src=\"../images/ctracker/recovery.png\"/><br />
														<b><font style='color:#269F00'>".$lang->ctracker_restore_rest."</font></b></center>", array('colspan' => 1));
	}
	// Erzeugen einer neuen Zeile
	$table->construct_row();
	// Erzeugen einer neuen Zelle
	$table->construct_cell("» <a style=\"text-decoration:none;\" href=\"index.php?module=config/ctracker&amp;action=restore&amp;do=backup\">".$lang->ctracker_restore_backup."</a>");
	// Erzeugen einer neuen Zeile
	$table->construct_row();
	// Erzeugen einer neuen Zelle
	$table->construct_cell("» <a style=\"text-decoration:none;\" href=\"index.php?module=config/ctracker&amp;action=restore&amp;do=restore\">".$lang->ctracker_restore_restore."</a>");
	// Erzeugen einer neuen Zeile
	$table->construct_row();
	// ??????????????????????????
	$no_results = true;

	// Ausgabe der Tabelle und Festlegung des Tabellen Headers
	$table->output("<center>".$lang->ctracker_restore."</center>");

	// Der Return
	$page->output_footer();
}
?>