<?php
/* Copyright (C) 2001-2005 Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2015 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2012 Regis Houssin        <regis.houssin@inodbox.com>
 * Copyright (C) 2015      Jean-François Ferry	<jfefe@aternatik.fr>
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
 *	\file       dashcycles/dashcyclesindex.php
 *	\ingroup    dashcycles
 *	\brief      Home page of dashcycles top menu
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

require_once DOL_DOCUMENT_ROOT.'/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formfile.class.php';

// Load translation files required by the page
$langs->loadLangs(array("dashcycles@dashcycles"));

$action = GETPOST('action', 'aZ09');

$now = dol_now();
$max = getDolGlobalInt('MAIN_SIZE_SHORTLIST_LIMIT', 5);

// Security check - Protection if external user
$socid = GETPOST('socid', 'int');
if (isset($user->socid) && $user->socid > 0) {
	$action = '';
	$socid = $user->socid;
}

// Security check (enable the most restrictive one)
//if ($user->socid > 0) accessforbidden();
//if ($user->socid > 0) $socid = $user->socid;
//if (!isModEnabled('dashcycles')) {
//	accessforbidden('Module not enabled');
//}
//if (! $user->hasRight('dashcycles', 'myobject', 'read')) {
//	accessforbidden();
//}
//restrictedArea($user, 'dashcycles', 0, 'dashcycles_myobject', 'myobject', '', 'rowid');
//if (empty($user->admin)) {
//	accessforbidden('Must be admin');
//}


/*
 * Actions
 */

// None


/*
 * View
 */

$form = new Form($db);
$formfile = new FormFile($db);
$sec = getDolGlobalInt('DASHCYCLES_RELOAD_FREQUENCY'); // Recover the value of refresh frequency
llxHeader("", $langs->trans("DashCyclesArea"), '', '', 0, 0, '', '', '', 'mod-dashcycles page-index');
print '<meta http-equiv="refresh" content="'.$sec.';URL='.$_SERVER['PHP_SELF'].'">'; // html tag to force the reload of the page based on $sec
print '<style>#id-left{display: none}</style>';

// print load_fiche_titre($langs->trans("DashCyclesArea"), '', 'dashcycles.png@dashcycles');

print '<div class="fichecenter fichecenterbis">';

// Créer un clone de cette fonction pour récupérer les widgets sélectionnés dans les paramètres du module
// Se contenter de boxlista et boxlistb car ce sont les seuls que l'on utilise
$resultboxes = FormOther::getBoxesArea($user, "0"); // Load $resultboxes (selectboxlist + boxactivated + boxlista + boxlistb)

$boxlist = '<div class="twocolumns">';

$boxlist .= '<div class="firstcolumn fichehalfleft boxhalfleft" id="boxhalfleft">';

$boxlist .= $resultboxes['boxlista'];

$boxlist .= '</div>';

$boxlist .= '<div class="secondcolumn fichehalfright boxhalfright" id="boxhalfright">';

$boxlist .= $resultboxes['boxlistb'];

$boxlist .= '</div>';
$boxlist .= "\n";

$boxlist .= '</div>';


print $boxlist;


// End of page
llxFooter();
$db->close();
