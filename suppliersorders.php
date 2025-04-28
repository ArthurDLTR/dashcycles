<?php
/* Copyright (C) 2025      Arthur LENOBLE		<arthurl52100@gmail.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 *	\file       dashcycles/suppliersorders.php
 *	\ingroup    dashcycles
 *	\brief      Page for status of suppliers' orders
 */

 // Load Dolibarr environment
$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) {
	$res = @include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
}
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp = empty($_SERVER['SCRIPT_FILENAME']) ? '' : $_SERVER['SCRIPT_FILENAME']; $tmp2 = realpath(__FILE__); $i = strlen($tmp) - 1; $j = strlen($tmp2) - 1;
while ($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i] == $tmp2[$j]) {
	$i--;
	$j--;
}
if (!$res && $i > 0 && file_exists(substr($tmp, 0, ($i + 1))."/main.inc.php")) {
	$res = @include substr($tmp, 0, ($i + 1))."/main.inc.php";
}
if (!$res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php")) {
	$res = @include dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php";
}
// Try main.inc.php using relative path
if (!$res && file_exists("../main.inc.php")) {
	$res = @include "../main.inc.php";
}
if (!$res && file_exists("../../main.inc.php")) {
	$res = @include "../../main.inc.php";
}
if (!$res && file_exists("../../../main.inc.php")) {
	$res = @include "../../../main.inc.php";
}
if (!$res) {
	die("Include of main fails");
}

// Load translation files required by the page
$langs->loadLangs(array("dashcycles@dashcycles"));

require_once DOL_DOCUMENT_ROOT.'/societe/class/societe.class.php';
require_once DOL_DOCUMENT_ROOT.'/fourn/class/fournisseur.commande.class.php';


$sql = "SELECT c.ref as comm_ref, c.rowid as comm_id, c.fk_statut as comm_statut, c.entity as comm_entity, c.date_valid as comm_valid, c.date_approve as comm_approuv, c.date_commande as comm_commande, s.nom as soc_nom, s.rowid as soc_id, s.logo as soc_logo, s.status as soc_status FROM ".MAIN_DB_PREFIX."commande_fournisseur as c LEFT JOIN ".MAIN_DB_PREFIX."societe as s on s.rowid = c.fk_soc WHERE c.fk_statut < 4";
// print "Requete : ".$sql."<br>";

$resql = $db->query($sql);

$soc = new Societe($db);
$comm = new CommandeFournisseur($db);

$sec = getDolGlobalInt('DASHCYCLES_RELOAD_FREQUENCY'); // Recover the value of refresh frequency
llxHeader("", $langs->trans("DashCyclesArea"), '', '', 0, 0, '', '', '', 'mod-dashcycles page-index');
print load_fiche_titre($langs->trans("SUPPLIERS_ORDERS_PAGE"), '', 'dash.png@dashcycles');
print '<meta http-equiv="refresh" content="'.$sec.';URL='.$_SERVER['PHP_SELF'].'">'; // html tag to force the reload of the page based on $sec
print '<style>#id-left{display: none}</style>';

if ($resql){
	$num = $db->num_rows($resql);
	
    print '<table class="noborder centpercent">';
    print '<tr class="liste_titre">';
    print '<th>Fournisseurs</th>';
    print '<th>Commande</th>';
    print '<th>Etat de la commande</th>';
	print '</tr>';	


	for ($i = 0; $i < $num; $i++){
		$obj = $db->fetch_object($resql);

		$soc->id = $obj->soc_id;
		$soc->name = $obj->soc_nom;
		$soc->logo = $obj->soc_logo;
		$soc->status = $obj->soc_status;
		

		$comm->id = $obj->comm_id;
		$comm->ref = $obj->comm_ref;
		$comm->status = $obj->comm_statut;
		$comm->entity = $obj->comm_entity;

		print '<tr class="oddeven">';
		print '<td class="tdoverflowmax200" data-ker="ref">' . $soc->getNomUrl(1, 'supplier', 100, 0, 1, 1) .'</td>';
		print '<td class="nowrap">'.$comm->getNomUrl(1).'</td>';
		switch ($comm->status){
			case 0:
				print '<td class="nowrap"><span class="sticker" id="to-complete">A compléter</span></td>';
				break;
			case 1:
				print '<td class="nowrap"><span class="sticker" id="to-send">A envoyer</span></td>';
				break;
			case 2:
				print '<td class="nowrap"><span class="sticker" id="approved">Envoyée le '.date("d/m",strtotime($obj->comm_valid)).'</span></td>';
				break;
			case 3:
				print '<td class="nowrap"><span class="sticker" id="send">Validée le '.date("d/m",strtotime($obj->comm_commande)).'</span></td>';
				break;
		}
		print '</tr>';	
	}

	print '</table>';
}