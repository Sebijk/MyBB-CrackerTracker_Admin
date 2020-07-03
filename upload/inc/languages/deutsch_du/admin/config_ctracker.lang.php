<?php
#########################################################
# Deutsches Sprachpaket (Informell)                     #
# Version 1.4.8                                         #
# Datum: 26.06.2009                                     #
# MyBB-Version 1.4.8                                    #
# Autor: MyBBoard.de | Webseite: http://www.mybboard.de #
# (c) 2005-2009 MyBBoard.de | Alle Rechte vorbehalten!  #
#                                                       #
# Die Lizenz/Nutzungsbedingungen finden Sie in der      #
# beiliegenden Readme.                                  #
#########################################################

$l['ctracker_system'] = "CrackerTracker";

$l['ctracker_credits'] = "Credits";
$l['ctracker_credits_desc'] = "Hier befinden sich ein paar Hinweise und die Credits des CBACK CrackerTrackers. Eine Seite um Dir weitere Informationen zu sicherheitsrelevanten Dingen zu 
															geben, sowie eine Möglichkeit \"Danke\" zu sagen.";
$l['ctracker_credits_1'] = "Idee & Umsetzung";
$l['ctracker_credits_2'] = "Herstellerseite und Supportforum";
$l['ctracker_credits_3'] = "Icons";
$l['ctracker_credits_4'] = "Offizielle Downloadseite";
$l['ctracker_credits_thx'] = "Danke an...";
$l['ctracker_credits_thx_1'] = "An dieser Stelle geht ein Dankeschön an einige Personen die mir bei der MOD Entwicklung mit Ideen, Tests und mehr zur Seite standen.";
$l['ctracker_credits_thx_2'] = "Featureideen, Sicherheitstests und Kontrolllesen";
$l['ctracker_credits_thx_3'] = "Featurevorschläge";
$l['ctracker_credits_thx_4'] = "Übersetzer";
$l['ctracker_credits_thx_5'] = "Korrektur (Englisch)";
$l['ctracker_credits_thx_6'] = "Korrektur (Deutsch)";
$l['ctracker_credits_thx_7'] = "Beta Tester";
$l['ctracker_credits_thx_8'] = "Umsetzung für MyBB";
$l['ctracker_credits_thx_9'] = "Sprachpacket (Deutsch)";
$l['ctracker_credits_thx_10'] = "Danke an alle Teilnehmer des Beta-Tests,<br/>an die CBACK Premium User und natürlich auch an<br/>einige Kollegen aus der \"Modder-Szene\", 
																welche bei Beta Tests und Korrekturlesen geholfen haben.";
$l['ctracker_credits_donate'] = "CBACK Spenden";
$l['ctracker_credits_donate_1_0'] = "Gefällt Dir ";
$l['ctracker_credits_donate_1_1'] = "CBACK CrackerTracker Professional? ";
$l['ctracker_credits_donate_1_2'] = "Dann wäre es sehr nett von Dir, wenn Du das CBACK Projekt mit einer kleinen PayPal Spende unterstützen würdest. Weiterentwicklung und Servermiete 
																		kosten unser non-profit Projekt viel Geld. Mit einer kleinen Unterstützung hilfst Du, dass wir unsere Services wie zum Beispiel den CrackerTracker 
																		weiterhin kostenfrei anbieten können. ";
$l['ctracker_credits_donate_1_3'] = "Vielen Dank für die Unterstützung!";

$l['ctracker_checksum'] = "Prüfsummenscanner";
$l['ctracker_checksum_desc'] = "Dieser Scanner erzeugt für jede PHP Datei Deines Forums eine Prüfsumme, sobald Du auf \"Erstelle oder aktualisiere Prüfsummen\" klickst. Danach hast 
																Du immer die Möglichkeit mit \"Überprüfe Dateiänderungen\" festzustellen, ob sich die Dateien seit dem letzten Erzeugen von Prüfsummen geändert haben 
																oder nicht. Damit kannst Du überwachen, ob sich vielleicht Dateien geändert haben, ohne das Du selbst etwas editiert hast. Dies ist meist ein Anzeichen 
																davon, dass jemand Zugang zu Deinem Foren-Datenbestand bekommen hatte. Achte übrigens auch auf die letzte Prüfzeit. So siehst Du, ob jemand unbefugt 
																diesen Prüfsummenscanner aktiviert hat!<br /><br /><b>Information:</b> Nicht alle Server unterstützen dieses Feature. Gelegentlich kann es zu Script Timeouts 
																kommen, wenn der Server zu lange braucht, um die MyBB Dateiliste zu erzeugen. Andere Server brechen den Vorgang ab, da er recht performanceintensiv ist.";
$l['ctracker_checksum_desc_1'] = "» Die letzte Aktualisierung der Dateiprüfsummen fand am ";
$l['ctracker_checksum_desc_2'] = "d.m.Y \u\m H:i \U\h\\r ";
$l['ctracker_checksum_desc_3'] = "statt.";
$l['ctracker_checksum_desc_4'] = "» Du hast noch kein Abbild der Checksumme gemacht, wir empfehlen dir DRINGENST dieß zu tun UND dir DATUM und UHZEIT dieser Prüfung zu Notiern!!!";
$l['ctracker_checksum_func'] = "Funktionen";
$l['ctracker_checksum_func_makesum'] = "Erstelle oder aktualisiere Prüfsummen";
$l['ctracker_checksum_func_checksum'] = "Überprüfe Dateiänderungen";
$l['ctracker_checksum_sys'] = "Systemausgabe";
$l['ctracker_checksum_sys_chose'] = "Bitte wähle eine Aktion aus!";
$l['ctracker_checksum_sys_make'] = "Aktualisieren der Dateiprüfsummen wurde vollständig ausgeführt!";
$l['ctracker_checksum_sys_datapath'] = "Dateipfad";
$l['ctracker_checksum_sys_status'] = "Status";
$l['ctracker_ckecksum_sys_unchanged'] = 'UNVERÄNDERT';
$l['ctracker_ckecksum_sys_changed'] = 'GEÄNDERT';
$l['ctracker_ckecksum_sys_deleted'] = 'GELÖSCHT';

$l['ctracker_restore'] = "System Recovery";
$l['ctracker_restore_desc'] = "Hier hast Du die Möglichkeit, die Konfigurationstabelle und die Konfigurations Datein deines Forums zu sichern oder zur letzten funktionierenden Konfiguration zurückzukehren. 
															Wenn Du die Funktion in den allgemeinen Einstellungen des CrackerTrackers aktiviert hast, dann wird die Konfigurationstabelle Deines Forums jedesmal 
															gesichert, wenn Du die Allgemeine Forenkonfiguration änderst. (ACHTUNG! Es handelt sich <b>NICHT</b> um ein komplettes Datenbankbackup!)<br /><br />
															Wenn Du nicht mehr ins ACP kommst nachdem Du Einstellungen verändert hast, dann kannst Du die letzte als funktionierend bekannte Konfiguration auch über 
															die Notfallkonsole des CrackerTrackers reaktivieren. Lese hierzu den Dateikommentar in der Datei ctracker/emergency.php für weitere Instruktionen zur 
															Notfallwiederherstellung der Forenkonfiguration. Bitte beachte, dass diese Datei immer erst vor Benutzung freigegeben werden muss. Wie das geht steht 
															ebenfalls im Dateikommentar.<br /><br /><b>ACHTUNG!</b> Diese Funktion sollte nur bei akuten Problemen benutzt werden!";
$l['ctracker_restore_backup'] = "Backup der Konfigurationstabelle und der Konfigurationsdatein";
$l['ctracker_restore_restore'] = "Wiederherstellen der zuletzt gespeicherten Konfigurationstabelle und Konfigurationsdatein";
$l['ctracker_restore_last'] = "Letztes Backup der Konfigurationstabelle: ";
$l['ctracker_restore_format'] = "d.m.Y \u\m H:i \U\h\\r ";
$l['ctracker_restore_none'] = "Die Konfigurationstabelle wurde bislang noch nicht gesichert!";
$l['ctracker_restore_make'] = "Das Datenbank und Dateibackup wurde erfolgreich ausgeführt.";
$l['ctracker_restore_rest'] = "Das Datenbank und Dateibackup wurde erfolgreich wiederhergestellt.";
?>