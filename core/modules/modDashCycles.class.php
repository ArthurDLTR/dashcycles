<?php
/* Copyright (C) 2004-2018  Laurent Destailleur     <eldy@users.sourceforge.net>
 * Copyright (C) 2018-2019  Nicolas ZABOURI         <info@inovea-conseil.com>
 * Copyright (C) 2019-2024  Frédéric France         <frederic.france@free.fr>
 * Copyright (C) 2025 Atu SuperAdmin <arthurl52100@gmail.com>
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
 * 	\defgroup   dashcycles     Module DashCycles
 *  \brief      DashCycles module descriptor.
 *
 *  \file       htdocs/dashcycles/core/modules/modDashCycles.class.php
 *  \ingroup    dashcycles
 *  \brief      Description and activation file for module DashCycles
 */
include_once DOL_DOCUMENT_ROOT.'/core/modules/DolibarrModules.class.php';
include_once DOL_DOCUMENT_ROOT.'/core/class/infobox.class.php';


/**
 *  Description and activation class for module DashCycles
 */
class modDashCycles extends DolibarrModules
{
	/**
	 * Constructor. Define names, constants, directories, boxes, permissions
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
		global $langs, $conf;

		$this->db = $db;

		// Id for module (must be unique).
		// Use here a free id (See in Home -> System information -> Dolibarr for list of used modules id).
		$this->numero = 207405; // TODO Go on page https://wiki.dolibarr.org/index.php/List_of_modules_id to reserve an id number for your module

		// Key text used to identify module (for permissions, menus, etc...)
		$this->rights_class = 'dashcycles';

		// Family can be 'base' (core modules),'crm','financial','hr','projects','products','ecm','technic' (transverse modules),'interface' (link with external tools),'other','...'
		// It is used to group modules by family in module setup page
		$this->family = "Atu home made";

		// Module position in the family on 2 digits ('01', '10', '20', ...)
		$this->module_position = '90';

		// Gives the possibility for the module, to provide his own family info and position of this family (Overwrite $this->family and $this->module_position. Avoid this)
		//$this->familyinfo = array('myownfamily' => array('position' => '01', 'label' => $langs->trans("MyOwnFamily")));
		// Module label (no space allowed), used if translation string 'ModuleDashCyclesName' not found (DashCycles is name of module).
		$this->name = preg_replace('/^mod/i', '', get_class($this));

		// DESCRIPTION_FLAG
		// Module description, used if translation string 'ModuleDashCyclesDesc' not found (DashCycles is name of module).
		$this->description = "DashCyclesDescription";
		// Used only if file README.md and README-LL.md not found.
		$this->descriptionlong = "DashCyclesDescription";

		// Author
		$this->editor_name = 'Atu';
		$this->editor_url = '';		// Must be an external online web site
		$this->editor_squarred_logo = '';					// Must be image filename into the module/img directory followed with @modulename. Example: 'myimage.png@dashcycles'

		// Possible values for version are: 'development', 'experimental', 'dolibarr', 'dolibarr_deprecated', 'experimental_deprecated' or a version string like 'x.y.z'
		$this->version = '0.7';
		// Url to the file with your last numberversion of this module
		//$this->url_last_version = 'http://www.example.com/versionmodule.txt';

		// Key used in llx_const table to save module status enabled/disabled (where DASHCYCLES is value of property name of module in uppercase)
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);

		// Name of image file used for this module.
		// If file is in theme/yourtheme/img directory under name object_pictovalue.png, use this->picto='pictovalue'
		// If file is in module/img directory under name object_pictovalue.png, use this->picto='pictovalue@module'
		// To use a supported fa-xxx css style of font awesome, use this->picto='xxx'
		$this->picto = 'fa-file-o';

		// Define some features supported by module (triggers, login, substitutions, menus, css, etc...)
		$this->module_parts = array(
			// Set this to 1 if module has its own trigger directory (core/triggers)
			'triggers' => 0,
			// Set this to 1 if module has its own login method file (core/login)
			'login' => 0,
			// Set this to 1 if module has its own substitution function file (core/substitutions)
			'substitutions' => 0,
			// Set this to 1 if module has its own menus handler directory (core/menus)
			'menus' => 0,
			// Set this to 1 if module overwrite template dir (core/tpl)
			'tpl' => 0,
			// Set this to 1 if module has its own barcode directory (core/modules/barcode)
			'barcode' => 0,
			// Set this to 1 if module has its own models directory (core/modules/xxx)
			'models' => 0,
			// Set this to 1 if module has its own printing directory (core/modules/printing)
			'printing' => 0,
			// Set this to 1 if module has its own theme directory (theme)
			'theme' => 0,
			// Set this to relative path of css file if module has its own css file
			'css' => 0,
			// Set this to relative path of js file if module must load a js on all pages
			'js' => array(
				//   '/dashcycles/js/dashcycles.js.php',
			),
			// Set here all hooks context managed by module. To find available hook context, make a "grep -r '>initHooks(' *" on source code. You can also set hook context to 'all'
			/* BEGIN MODULEBUILDER HOOKSCONTEXTS */
			'hooks' => array(
				//   'data' => array(
				//       'hookcontext1',
				//       'hookcontext2',
				//   ),
				//   'entity' => '0',
			),
			/* END MODULEBUILDER HOOKSCONTEXTS */
			// Set this to 1 if features of module are opened to external users
			'moduleforexternal' => 0,
			// Set this to 1 if the module provides a website template into doctemplates/websites/website_template-mytemplate
			'websitetemplates' => 0
		);

		// Data directories to create when module is enabled.
		// Example: this->dirs = array("/dashcycles/temp","/dashcycles/subdir");
		$this->dirs = array("/dashcycles/temp");

		// Config pages. Put here list of php page, stored into dashcycles/admin directory, to use to setup module.
		$this->config_page_url = array("setup.php@dashcycles");

		// Dependencies
		// A condition to hide module
		$this->hidden = getDolGlobalInt('MODULE_DASHCYCLES_DISABLED'); // A condition to disable module;
		// List of module class names that must be enabled if this module is enabled. Example: array('always'=>array('modModuleToEnable1','modModuleToEnable2'), 'FR'=>array('modModuleToEnableFR')...)
		$this->depends = array();
		// List of module class names to disable if this one is disabled. Example: array('modModuleToDisable1', ...)
		$this->requiredby = array();
		// List of module class names this module is in conflict with. Example: array('modModuleToDisable1', ...)
		$this->conflictwith = array();

		// The language file dedicated to your module
		$this->langfiles = array("dashcycles@dashcycles");

		// Prerequisites
		$this->phpmin = array(7, 1); // Minimum version of PHP required by module
		$this->need_dolibarr_version = array(19, -3); // Minimum version of Dolibarr required by module
		$this->need_javascript_ajax = 0;

		// Messages at activation
		$this->warnings_activation = array(); // Warning to show when we activate module. array('always'='text') or array('FR'='textfr','MX'='textmx'...)
		$this->warnings_activation_ext = array(); // Warning to show when we activate an external module. array('always'='text') or array('FR'='textfr','MX'='textmx'...)
		//$this->automatic_activation = array('FR'=>'DashCyclesWasAutomaticallyActivatedBecauseOfYourCountryChoice');
		//$this->always_enabled = true;								// If true, can't be disabled

		// Constants
		// List of particular constants to add when module is enabled (key, 'chaine', value, desc, visible, 'current' or 'allentities', deleteonunactive)
		// Example: $this->const=array(1 => array('DASHCYCLES_MYNEWCONST1', 'chaine', 'myvalue', 'This is a constant to add', 1),
		//                             2 => array('DASHCYCLES_MYNEWCONST2', 'chaine', 'myvalue', 'This is another constant to add', 0, 'current', 1)
		// );
		$this->const = array();

		// Some keys to add into the overwriting translation tables
		/*$this->overwrite_translation = array(
			'en_US:ParentCompany'=>'Parent company or reseller',
			'fr_FR:ParentCompany'=>'Maison mère ou revendeur'
		)*/

		if (!isModEnabled("dashcycles")) {
			$conf->dashcycles = new stdClass();
			$conf->dashcycles->enabled = 0;
		}

		// Array to add new pages in new tabs
		/* BEGIN MODULEBUILDER TABS */
		$this->tabs = array();
		/* END MODULEBUILDER TABS */
		// Example:
		// To add a new tab identified by code tabname1
		// $this->tabs[] = array('data'=>'objecttype:+tabname1:Title1:mylangfile@dashcycles:$user->hasRight('dashcycles', 'read'):/dashcycles/mynewtab1.php?id=__ID__');
		// To add another new tab identified by code tabname2. Label will be result of calling all substitution functions on 'Title2' key.
		// $this->tabs[] = array('data'=>'objecttype:+tabname2:SUBSTITUTION_Title2:mylangfile@dashcycles:$user->hasRight('othermodule', 'read'):/dashcycles/mynewtab2.php?id=__ID__',
		// To remove an existing tab identified by code tabname
		// $this->tabs[] = array('data'=>'objecttype:-tabname:NU:conditiontoremove');
		//
		// Where objecttype can be
		// 'categories_x'	  to add a tab in category view (replace 'x' by type of category (0=product, 1=supplier, 2=customer, 3=member)
		// 'contact'          to add a tab in contact view
		// 'contract'         to add a tab in contract view
		// 'group'            to add a tab in group view
		// 'intervention'     to add a tab in intervention view
		// 'invoice'          to add a tab in customer invoice view
		// 'invoice_supplier' to add a tab in supplier invoice view
		// 'member'           to add a tab in foundation member view
		// 'opensurveypoll'	  to add a tab in opensurvey poll view
		// 'order'            to add a tab in sale order view
		// 'order_supplier'   to add a tab in supplier order view
		// 'payment'		  to add a tab in payment view
		// 'payment_supplier' to add a tab in supplier payment view
		// 'product'          to add a tab in product view
		// 'propal'           to add a tab in propal view
		// 'project'          to add a tab in project view
		// 'stock'            to add a tab in stock view
		// 'thirdparty'       to add a tab in third party view
		// 'user'             to add a tab in user view


		// Dictionaries
		/* Example:
		 $this->dictionaries=array(
		 'langs'=>'dashcycles@dashcycles',
		 // List of tables we want to see into dictonnary editor
		 'tabname'=>array("table1", "table2", "table3"),
		 // Label of tables
		 'tablib'=>array("Table1", "Table2", "Table3"),
		 // Request to select fields
		 'tabsql'=>array('SELECT f.rowid as rowid, f.code, f.label, f.active FROM '.MAIN_DB_PREFIX.'table1 as f', 'SELECT f.rowid as rowid, f.code, f.label, f.active FROM '.MAIN_DB_PREFIX.'table2 as f', 'SELECT f.rowid as rowid, f.code, f.label, f.active FROM '.MAIN_DB_PREFIX.'table3 as f'),
		 // Sort order
		 'tabsqlsort'=>array("label ASC", "label ASC", "label ASC"),
		 // List of fields (result of select to show dictionary)
		 'tabfield'=>array("code,label", "code,label", "code,label"),
		 // List of fields (list of fields to edit a record)
		 'tabfieldvalue'=>array("code,label", "code,label", "code,label"),
		 // List of fields (list of fields for insert)
		 'tabfieldinsert'=>array("code,label", "code,label", "code,label"),
		 // Name of columns with primary key (try to always name it 'rowid')
		 'tabrowid'=>array("rowid", "rowid", "rowid"),
		 // Condition to show each dictionary
		 'tabcond'=>array(isModEnabled('dashcycles'), isModEnabled('dashcycles'), isModEnabled('dashcycles')),
		 // Tooltip for every fields of dictionaries: DO NOT PUT AN EMPTY ARRAY
		 'tabhelp'=>array(array('code'=>$langs->trans('CodeTooltipHelp'), 'field2' => 'field2tooltip'), array('code'=>$langs->trans('CodeTooltipHelp'), 'field2' => 'field2tooltip'), ...),
		 );
		 */
		/* BEGIN MODULEBUILDER DICTIONARIES */
		$this->dictionaries = array();
		/* END MODULEBUILDER DICTIONARIES */

		// Boxes/Widgets
		// Add here list of php file(s) stored in dashcycles/core/boxes that contains a class to show a widget.
		/* BEGIN MODULEBUILDER WIDGETS */
		$this->boxes = array(
			 0 => array(
			     'file' => 'boxwaitingpropal@dashcycles',
			     'note' => 'Widget for propals waiting for sign, provided by DashCycles',
			     'enabledbydefaulton' => 'Home',
			 ),
			 1 => array(
				'file' => 'box_undeliveredorders@dashcycles',
				'note' => 'Widget for undelivered orders, provided by DashCycles',
				'enabledbydefaulton' => 'Home',
			 ),
			 2 => array(
				'file' => 'box_progressshipment@dashcycles',
				'note' => 'Widget for shipment in progress, provided by DashCycles',
				'enabledbydefaulton' => 'Home',
			 ),
			 3 => array(
				'file' => 'box_waitingapprob@dashcycles',
				'note' => 'Widget for propals waiting for response, provided by DashCycles',
				'enabledbydefaulton' => 'Home',
			 )
			//  ...
		);
		/* END MODULEBUILDER WIDGETS */

		// Cronjobs (List of cron jobs entries to add when module is enabled)
		// unit_frequency must be 60 for minute, 3600 for hour, 86400 for day, 604800 for week
		/* BEGIN MODULEBUILDER CRON */
		$this->cronjobs = array(
			//  0 => array(
			//      'label' => 'MyJob label',
			//      'jobtype' => 'method',
			//      'class' => '/dashcycles/class/myobject.class.php',
			//      'objectname' => 'MyObject',
			//      'method' => 'doScheduledJob',
			//      'parameters' => '',
			//      'comment' => 'Comment',
			//      'frequency' => 2,
			//      'unitfrequency' => 3600,
			//      'status' => 0,
			//      'test' => 'isModEnabled("dashcycles")',
			//      'priority' => 50,
			//  ),
		);
		/* END MODULEBUILDER CRON */
		// Example: $this->cronjobs=array(
		//    0=>array('label'=>'My label', 'jobtype'=>'method', 'class'=>'/dir/class/file.class.php', 'objectname'=>'MyClass', 'method'=>'myMethod', 'parameters'=>'param1, param2', 'comment'=>'Comment', 'frequency'=>2, 'unitfrequency'=>3600, 'status'=>0, 'test'=>'isModEnabled("dashcycles")', 'priority'=>50),
		//    1=>array('label'=>'My label', 'jobtype'=>'command', 'command'=>'', 'parameters'=>'param1, param2', 'comment'=>'Comment', 'frequency'=>1, 'unitfrequency'=>3600*24, 'status'=>0, 'test'=>'isModEnabled("dashcycles")', 'priority'=>50)
		// );

		// Permissions provided by this module
		$this->rights = array();
		$r = 0;
		// Add here entries to declare new permissions
		/* BEGIN MODULEBUILDER PERMISSIONS */
		/*
		$o = 1;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", ($o * 10) + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Read objects of DashCycles'; // Permission label
		$this->rights[$r][4] = 'myobject';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->hasRight('dashcycles', 'myobject', 'read'))
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", ($o * 10) + 2); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Create/Update objects of DashCycles'; // Permission label
		$this->rights[$r][4] = 'myobject';
		$this->rights[$r][5] = 'write'; // In php code, permission will be checked by test if ($user->hasRight('dashcycles', 'myobject', 'write'))
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", ($o * 10) + 3); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Delete objects of DashCycles'; // Permission label
		$this->rights[$r][4] = 'myobject';
		$this->rights[$r][5] = 'delete'; // In php code, permission will be checked by test if ($user->hasRight('dashcycles', 'myobject', 'delete'))
		$r++;
		*/
		/* END MODULEBUILDER PERMISSIONS */


		// Main menu entries to add
		$this->menu = array();
		$r = 0;
		// Add here entries to declare new menus
		/* BEGIN MODULEBUILDER TOPMENU */
		// $this->menu[$r++] = array(
		// 	'fk_menu'=>'', // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
		// 	'type'=>'top', // This is a Top menu entry
		// 	'titre'=>'ModuleDashCyclesName',
		// 	'prefix' => img_picto('', $this->picto, 'class="pictofixedwidth valignmiddle"'),
		// 	'mainmenu'=>'dashcycles',
		// 	'leftmenu'=>'',
		// 	'url'=>'/dashcycles/dashcyclesindex.php',
		// 	'langs'=>'dashcycles@dashcycles', // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
		// 	'position'=>1000 + $r,
		// 	'enabled'=>'isModEnabled("dashcycles")', // Define condition to show or hide menu entry. Use 'isModEnabled("dashcycles")' if entry must be visible if module is enabled.
		// 	'perms'=>'1', // Use 'perms'=>'$user->hasRight("dashcycles", "myobject", "read")' if you want your menu with a permission rules
		// 	'target'=>'',
		// 	'user'=>2, // 0=Menu for internal users, 1=external users, 2=both
		// );
		/* END MODULEBUILDER TOPMENU */

		/* BEGIN MODULEBUILDER LEFTMENU MYOBJECT */
		if (getDolGlobalString("DASHCYCLES_DISPLAY") == "single"){
			$this->menu[$r++]=array(
				'fk_menu'=>'fk_mainmenu=commercial',      // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
				'type'=>'left',                          // This is a Left menu entry
				'titre'=>$langs->trans('SALES_CYCLES'),
				'prefix' => img_picto('', $this->picto, 'class="pictofixedwidth valignmiddle paddingright"'),
				'mainmenu'=>'dashcycles',
				'leftmenu'=>'myobject',
				'url'=>'/dashcycles/dashcyclesindex.php',
				'langs'=>'dashcycles@dashcycles',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
				'position'=>1000+$r,
				'enabled'=>'isModEnabled("dashcycles")', // Define condition to show or hide menu entry. Use 'isModEnabled("dashcycles")' if entry must be visible if module is enabled.
				'perms'=>1,
				'target'=>'',
				'user'=>2,				                // 0=Menu for internal users, 1=external users, 2=both
				'object'=>'MyObject'
			);
		} else if (getDolGlobalString("DASHCYCLES_DISPLAY") == "double") {
			$this->menu[$r++]=array(
				'fk_menu'=>'fk_mainmenu=commercial',      // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
				'type'=>'left',                          // This is a Left menu entry
				'titre'=>$langs->trans('SALES_CYCLES_FIRST'),
				'prefix' => img_picto('', $this->picto, 'class="pictofixedwidth valignmiddle paddingright"'),
				'mainmenu'=>'dashcycles',
				'leftmenu'=>'myobject',
				'url'=>'/dashcycles/dashcyclesfirst.php',
				'langs'=>'dashcycles@dashcycles',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
				'position'=>1000+$r,
				'enabled'=>'isModEnabled("dashcycles")', // Define condition to show or hide menu entry. Use 'isModEnabled("dashcycles")' if entry must be visible if module is enabled.
				'perms'=>1,
				'target'=>'',
				'user'=>2,				                // 0=Menu for internal users, 1=external users, 2=both
				'object'=>'MyObject'
			);
			$this->menu[$r++]=array(
				'fk_menu'=>'fk_mainmenu=commercial',      // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
				'type'=>'left',                          // This is a Left menu entry
				'titre'=>$langs->trans('SALES_CYCLES_SECOND'),
				'prefix' => img_picto('', $this->picto, 'class="pictofixedwidth valignmiddle paddingright"'),
				'mainmenu'=>'dashcycles',
				'leftmenu'=>'myobject',
				'url'=>'/dashcycles/dashcyclessecond.php',
				'langs'=>'dashcycles@dashcycles',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
				'position'=>1000+$r,
				'enabled'=>'isModEnabled("dashcycles")', // Define condition to show or hide menu entry. Use 'isModEnabled("dashcycles")' if entry must be visible if module is enabled.
				'perms'=>1,
				'target'=>'',
				'user'=>2,				                // 0=Menu for internal users, 1=external users, 2=both
				'object'=>'MyObject'
			);
		}
		/*
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=commercial',      // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',                          // This is a Left menu entry
			'titre'=>$langs->trans('SUPPLIERS_ORDERS'),
			'prefix' => img_picto('', $this->picto, 'class="pictofixedwidth valignmiddle paddingright"'),
			'mainmenu'=>'commercial',
			'leftmenu'=>'dashcycles',
			'url'=>'/dashcycles/suppliersorders.php',
			'langs'=>'dashcycles@dashcycles',        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1010+$r,
			'enabled'=>'isModEnabled("dashcycles")', // Define condition to show or hide menu entry. Use 'isModEnabled("dashcycles")' if entry must be visible if module is enabled.
			'perms'=>1,
			'target'=>'',
			'user'=>2,				                // 0=Menu for internal users, 1=external users, 2=both
		);
		*/
		/*
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=dashcycles,fk_leftmenu=myobject',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'New_MyObject',
			'mainmenu'=>'dashcycles',
			'leftmenu'=>'dashcycles_myobject_new',
			'url'=>'/dashcycles/myobject_card.php?action=create',
			'langs'=>'dashcycles@dashcycles',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'isModEnabled("dashcycles")', // Define condition to show or hide menu entry. Use 'isModEnabled("dashcycles")' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->hasRight("dashcycles", "myobject", "write")'
			'target'=>'',
			'user'=>2,				                // 0=Menu for internal users, 1=external users, 2=both
			'object'=>'MyObject'
		);
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=dashcycles,fk_leftmenu=myobject',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'List_MyObject',
			'mainmenu'=>'dashcycles',
			'leftmenu'=>'dashcycles_myobject_list',
			'url'=>'/dashcycles/myobject_list.php',
			'langs'=>'dashcycles@dashcycles',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'isModEnabled("dashcycles")', // Define condition to show or hide menu entry. Use 'isModEnabled("dashcycles")' if entry must be visible if module is enabled.
			'perms'=>'$user->hasRight("dashcycles", "myobject", "read")'
			'target'=>'',
			'user'=>2,				                // 0=Menu for internal users, 1=external users, 2=both
			'object'=>'MyObject'
		);
		*/
		/* END MODULEBUILDER LEFTMENU MYOBJECT */


		// Exports profiles provided by this module
		$r = 1;
		/* BEGIN MODULEBUILDER EXPORT MYOBJECT */
		/*
		$langs->load("dashcycles@dashcycles");
		$this->export_code[$r] = $this->rights_class.'_'.$r;
		$this->export_label[$r] = 'MyObjectLines';	// Translation key (used only if key ExportDataset_xxx_z not found)
		$this->export_icon[$r] = $this->picto;
		// Define $this->export_fields_array, $this->export_TypeFields_array and $this->export_entities_array
		$keyforclass = 'MyObject'; $keyforclassfile='/dashcycles/class/myobject.class.php'; $keyforelement='myobject@dashcycles';
		include DOL_DOCUMENT_ROOT.'/core/commonfieldsinexport.inc.php';
		//$this->export_fields_array[$r]['t.fieldtoadd']='FieldToAdd'; $this->export_TypeFields_array[$r]['t.fieldtoadd']='Text';
		//unset($this->export_fields_array[$r]['t.fieldtoremove']);
		//$keyforclass = 'MyObjectLine'; $keyforclassfile='/dashcycles/class/myobject.class.php'; $keyforelement='myobjectline@dashcycles'; $keyforalias='tl';
		//include DOL_DOCUMENT_ROOT.'/core/commonfieldsinexport.inc.php';
		$keyforselect='myobject'; $keyforaliasextra='extra'; $keyforelement='myobject@dashcycles';
		include DOL_DOCUMENT_ROOT.'/core/extrafieldsinexport.inc.php';
		//$keyforselect='myobjectline'; $keyforaliasextra='extraline'; $keyforelement='myobjectline@dashcycles';
		//include DOL_DOCUMENT_ROOT.'/core/extrafieldsinexport.inc.php';
		//$this->export_dependencies_array[$r] = array('myobjectline'=>array('tl.rowid','tl.ref')); // To force to activate one or several fields if we select some fields that need same (like to select a unique key if we ask a field of a child to avoid the DISTINCT to discard them, or for computed field than need several other fields)
		//$this->export_special_array[$r] = array('t.field'=>'...');
		//$this->export_examplevalues_array[$r] = array('t.field'=>'Example');
		//$this->export_help_array[$r] = array('t.field'=>'FieldDescHelp');
		$this->export_sql_start[$r]='SELECT DISTINCT ';
		$this->export_sql_end[$r]  =' FROM '.MAIN_DB_PREFIX.'dashcycles_myobject as t';
		//$this->export_sql_end[$r]  .=' LEFT JOIN '.MAIN_DB_PREFIX.'dashcycles_myobject_line as tl ON tl.fk_myobject = t.rowid';
		$this->export_sql_end[$r] .=' WHERE 1 = 1';
		$this->export_sql_end[$r] .=' AND t.entity IN ('.getEntity('myobject').')';
		$r++; */
		/* END MODULEBUILDER EXPORT MYOBJECT */

		// Imports profiles provided by this module
		$r = 1;
		/* BEGIN MODULEBUILDER IMPORT MYOBJECT */
		/*
		$langs->load("dashcycles@dashcycles");
		$this->import_code[$r] = $this->rights_class.'_'.$r;
		$this->import_label[$r] = 'MyObjectLines';	// Translation key (used only if key ExportDataset_xxx_z not found)
		$this->import_icon[$r] = $this->picto;
		$this->import_tables_array[$r] = array('t' => MAIN_DB_PREFIX.'dashcycles_myobject', 'extra' => MAIN_DB_PREFIX.'dashcycles_myobject_extrafields');
		$this->import_tables_creator_array[$r] = array('t' => 'fk_user_author'); // Fields to store import user id
		$import_sample = array();
		$keyforclass = 'MyObject'; $keyforclassfile='/dashcycles/class/myobject.class.php'; $keyforelement='myobject@dashcycles';
		include DOL_DOCUMENT_ROOT.'/core/commonfieldsinimport.inc.php';
		$import_extrafield_sample = array();
		$keyforselect='myobject'; $keyforaliasextra='extra'; $keyforelement='myobject@dashcycles';
		include DOL_DOCUMENT_ROOT.'/core/extrafieldsinimport.inc.php';
		$this->import_fieldshidden_array[$r] = array('extra.fk_object' => 'lastrowid-'.MAIN_DB_PREFIX.'dashcycles_myobject');
		$this->import_regex_array[$r] = array();
		$this->import_examplevalues_array[$r] = array_merge($import_sample, $import_extrafield_sample);
		$this->import_updatekeys_array[$r] = array('t.ref' => 'Ref');
		$this->import_convertvalue_array[$r] = array(
			't.ref' => array(
				'rule'=>'getrefifauto',
				'class'=>(!getDolGlobalString('DASHCYCLES_MYOBJECT_ADDON') ? 'mod_myobject_standard' : getDolGlobalString('DASHCYCLES_MYOBJECT_ADDON')),
				'path'=>"/core/modules/dashcycles/".(!getDolGlobalString('DASHCYCLES_MYOBJECT_ADDON') ? 'mod_myobject_standard' : getDolGlobalString('DASHCYCLES_MYOBJECT_ADDON')).'.php',
				'classobject'=>'MyObject',
				'pathobject'=>'/dashcycles/class/myobject.class.php',
			),
			't.fk_soc' => array('rule' => 'fetchidfromref', 'file' => '/societe/class/societe.class.php', 'class' => 'Societe', 'method' => 'fetch', 'element' => 'ThirdParty'),
			't.fk_user_valid' => array('rule' => 'fetchidfromref', 'file' => '/user/class/user.class.php', 'class' => 'User', 'method' => 'fetch', 'element' => 'user'),
			't.fk_mode_reglement' => array('rule' => 'fetchidfromcodeorlabel', 'file' => '/compta/paiement/class/cpaiement.class.php', 'class' => 'Cpaiement', 'method' => 'fetch', 'element' => 'cpayment'),
		);
		$this->import_run_sql_after_array[$r] = array();
		$r++; */
		/* END MODULEBUILDER IMPORT MYOBJECT */
	}

	/**
	 *  Function called when module is enabled.
	 *  The init function add constants, boxes, permissions and menus (defined in constructor) into Dolibarr database.
	 *  It also creates data directories
	 *
	 *  @param      string  $options    Options when enabling module ('', 'noboxes')
	 *  @return     int             	1 if OK, 0 if KO
	 */
	public function init($options = '')
	{
		global $conf, $langs;

		//$result = $this->_load_tables('/install/mysql/', 'dashcycles');
		//$result = $this->_load_tables('/dashcycles/sql/');
		if ($result < 0) {
			return -1; // Do not activate module if error 'not allowed' returned when loading module SQL queries (the _load_table run sql with run_sql with the error allowed parameter set to 'default')
		}

		// Create extrafields during init
		//include_once DOL_DOCUMENT_ROOT.'/core/class/extrafields.class.php';
		//$extrafields = new ExtraFields($this->db);
		//$result0=$extrafields->addExtraField('dashcycles_separator1', "Separator 1", 'separator', 1,  0, 'thirdparty',   0, 0, '', array('options'=>array(1=>1)), 1, '', 1, 0, '', '', 'dashcycles@dashcycles', 'isModEnabled("dashcycles")');
		//$result1=$extrafields->addExtraField('dashcycles_myattr1', "New Attr 1 label", 'boolean', 1,  3, 'thirdparty',   0, 0, '', '', 1, '', -1, 0, '', '', 'dashcycles@dashcycles', 'isModEnabled("dashcycles")');
		//$result2=$extrafields->addExtraField('dashcycles_myattr2', "New Attr 2 label", 'varchar', 1, 10, 'project',      0, 0, '', '', 1, '', -1, 0, '', '', 'dashcycles@dashcycles', 'isModEnabled("dashcycles")');
		//$result3=$extrafields->addExtraField('dashcycles_myattr3', "New Attr 3 label", 'varchar', 1, 10, 'bank_account', 0, 0, '', '', 1, '', -1, 0, '', '', 'dashcycles@dashcycles', 'isModEnabled("dashcycles")');
		//$result4=$extrafields->addExtraField('dashcycles_myattr4', "New Attr 4 label", 'select',  1,  3, 'thirdparty',   0, 1, '', array('options'=>array('code1'=>'Val1','code2'=>'Val2','code3'=>'Val3')), 1,'', -1, 0, '', '', 'dashcycles@dashcycles', 'isModEnabled("dashcycles")');
		//$result5=$extrafields->addExtraField('dashcycles_myattr5', "New Attr 5 label", 'text',    1, 10, 'user',         0, 0, '', '', 1, '', -1, 0, '', '', 'dashcycles@dashcycles', 'isModEnabled("dashcycles")');

		// Permissions
		$this->remove($options);

		$sql = array();

		// Document templates
		$moduledir = dol_sanitizeFileName('dashcycles');
		$myTmpObjects = array();
		$myTmpObjects['MyObject'] = array('includerefgeneration'=>0, 'includedocgeneration'=>0);

		foreach ($myTmpObjects as $myTmpObjectKey => $myTmpObjectArray) {
			if ($myTmpObjectKey == 'MyObject') {
				continue;
			}
			if ($myTmpObjectArray['includerefgeneration']) {
				$src = DOL_DOCUMENT_ROOT.'/install/doctemplates/'.$moduledir.'/template_myobjects.odt';
				$dirodt = DOL_DATA_ROOT.'/doctemplates/'.$moduledir;
				$dest = $dirodt.'/template_myobjects.odt';

				if (file_exists($src) && !file_exists($dest)) {
					require_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';
					dol_mkdir($dirodt);
					$result = dol_copy($src, $dest, 0, 0);
					if ($result < 0) {
						$langs->load("errors");
						$this->error = $langs->trans('ErrorFailToCopyFile', $src, $dest);
						return 0;
					}
				}

				$sql = array_merge($sql, array(
					"DELETE FROM ".MAIN_DB_PREFIX."document_model WHERE nom = 'standard_".strtolower($myTmpObjectKey)."' AND type = '".$this->db->escape(strtolower($myTmpObjectKey))."' AND entity = ".((int) $conf->entity),
					"INSERT INTO ".MAIN_DB_PREFIX."document_model (nom, type, entity) VALUES('standard_".strtolower($myTmpObjectKey)."', '".$this->db->escape(strtolower($myTmpObjectKey))."', ".((int) $conf->entity).")",
					"DELETE FROM ".MAIN_DB_PREFIX."document_model WHERE nom = 'generic_".strtolower($myTmpObjectKey)."_odt' AND type = '".$this->db->escape(strtolower($myTmpObjectKey))."' AND entity = ".((int) $conf->entity),
					"INSERT INTO ".MAIN_DB_PREFIX."document_model (nom, type, entity) VALUES('generic_".strtolower($myTmpObjectKey)."_odt', '".$this->db->escape(strtolower($myTmpObjectKey))."', ".((int) $conf->entity).")"
				));
			}
		}

		return $this->_init($sql, $options);
	}

	/**
	 *  Function called when module is disabled.
	 *  Remove from database constants, boxes and permissions from Dolibarr database.
	 *  Data directories are not deleted
	 *
	 *  @param      string	$options    Options when enabling module ('', 'noboxes')
	 *  @return     int                 1 if OK, 0 if KO
	 */
	public function remove($options = '')
	{
		$sql = array();
		return $this->_remove($sql, $options);
	}

	/**
	 * Function called to print the widgets in dashcyclesindex.php
	 * @return array		Array of the two columns of widgets
	 */
	public function getBoxesDashCycles($boxactivated)
	{
		global $db;
		
		// Original version of the call
		// $boxactivated = InfoBox::listBoxes($this->db, 'activated', $areacode, (empty($user->conf->$confuserzone) ? null : $user), array(), 0); // Search boxes of common+user (or common only if user has no specific setup)
		
		// Define boxlista and boxlistb
		$boxlista = '';
		$boxlistb = '';
		
		$emptybox = new ModeleBoxes($db);
 
		$boxlista .= "\n<!-- Box left container -->\n";
	
		// Define $box_max_lines
		$box_max_lines = getDolGlobalInt('DASHCYCLES_MAX_LINES');
	
		$ii = 0;
		foreach ($boxactivated as $key => $box) {
			// if ((!empty($user->conf->$confuserzone) && $box->fk_user == 0) || (empty($user->conf->$confuserzone) && $box->fk_user != 0)) {
			// continue;
			// }
			if (empty($box->box_order) && $ii < ($nbboxactivated / 2)) {
			$box->box_order = 'A'.sprintf("%02d", ($ii + 1)); // When box_order was not yet set to Axx or Bxx and is still 0
			}
			if (preg_match('/^A/i', $box->box_order)) { // column A
			$ii++;
			//print 'box_id : '.strtoupper($box->boxcode).' ';
			//print 'box_order '.$boxactivated[$ii]->box_order.'<br>';
			// Show box
			$box->loadBox((getDolGlobalInt(strtoupper($box->boxcode)."_MAX_LINES") > 0) ? getDolGlobalInt(strtoupper($box->boxcode)."_MAX_LINES") : $box_max_lines);
			$boxlista .= $box->showBox(null, null, 1);
			}
		}
	
		// if ($conf->browser->layout != 'phone') {
		// 	$emptybox->box_id = 'A';
		// 	$emptybox->info_box_head = array();
		// 	$emptybox->info_box_contents = array();
		// 	$boxlista .= $emptybox->showBox(array(), array(), 1);
		// }
		$boxlista .= "<!-- End box left container -->\n";
	
		$boxlistb .= "\n<!-- Box right container -->\n";
	
		$ii = 0;
		foreach ($boxactivated as $key => $box) {
			if ((!empty($user->conf->confuserzone) && $box->fk_user == 0) || (empty($user->conf->confuserzone) && $box->fk_user != 0)) {
			continue;
			}
			if (empty($box->box_order) && $ii < ($nbboxactivated / 2)) {
			$box->box_order = 'B'.sprintf("%02d", ($ii + 1)); // When box_order was not yet set to Axx or Bxx and is still 0
			}
			if (preg_match('/^B/i', $box->box_order)) { // colonne B
			$ii++;
			//print 'box_id : '.getDolGlobalInt(strtoupper($box->boxcode)).' ';
			//print 'box_order '.$boxactivated[$ii]->box_order.'<br>';
			// Show box
			$box->loadBox((getDolGlobalInt(strtoupper($box->boxcode)."_MAX_LINES") > 0) ? getDolGlobalInt(strtoupper($box->boxcode)."_MAX_LINES") : $box_max_lines);
			$boxlistb .= $box->showBox(null, null, 1);
			}
		}
	
		if ($conf->browser->layout != 'phone') {
			$emptybox->box_id = 'B';
			$emptybox->info_box_head = array();
			$emptybox->info_box_contents = array();
			$boxlistb .= $emptybox->showBox(array(), array(), 1);
		}
	
		$boxlistb .= "<!-- End box right container -->\n";
	
		return array('boxlista' => $boxlista, 'boxlistb' => $boxlistb);
	}

	/**
	 * Function to return the list of the boxes we want to display on dashcyclesindex.php
	 * @return array			Array of boxes
	 */
	public static function listBoxes()
	{
		global $conf, $db;

		$boxes = array();

		$objs = array();
			/*
			(object) array(
				"position" => "0",
				"box_id" => "-1",
				"box_order" => "A01",
				"file" => "/dashcycles/core/boxes/box_undeliveredorders.php",
				"boxname" => "box_undeliveredorders"
			),
			(object) array(
				"position" => "0",
				"box_id" => "-1",
				"box_order" => "A02",
				"file" => "/dashcycles/core/boxes/box_progressshipment.php",
				"boxname" => "box_progressshipment"
			),
			(object) array(
				"position" => "0",
				"box_id" => "-1",
				"box_order" => "A03",
				"file" => "/dashcycles/core/boxes/box_waitingapprob.php",
				"boxname" => "box_waitingapprob"
			),
			(object) array(
				"position" => "0",
				"box_id" => "-1",
				"box_order" => "B01",
				"file" => "/dashcycles/core/boxes/box_waitingpropal.php",
				"boxname" => "box_waitingpropal"
			),
			(object) array(
				"position" => "0",
				"box_id" => "-1",
				"box_order" => "B03",
				"file" => "/core/boxes/box_factures_imp.php",
				"boxname" => "box_factures_imp"
			),
			(object) array(
				"position" => "0",
				"box_id" => "-1",
				"box_order" => "B02",
				"file" => "/dashcycles/core/boxes/box_supplierordersreception.php",
				"boxname" => "box_supplier_orders_awaiting_reception"
				)
				*/
		
		// Add the boxes if set as Yes in settings of the module
		if(getDolGlobalInt('DASHCYCLES_WIDGET_WAITING_PROPALS')){
			array_push($objs, array(
				"position" => "0",
				"box_id" => "-1",
				"box_order" => getDolGlobalString('LASTWAITINGPROPALS_ORDER'),
				"file" => "/dashcycles/core/boxes/box_waitingpropal.php",
				"boxname" => "box_waitingpropal"
			));
		}

		if(getDolGlobalInt('DASHCYCLES_WIDGET_ORDER_UNDELIVERED')){
			array_push($objs, array(
				"position" => "0",
				"box_id" => "-1",
				"box_order" => getDolGlobalString('UNDELIVEREDORDERS_ORDER'),
				"file" => "/dashcycles/core/boxes/box_undeliveredorders.php",
				"boxname" => "box_undeliveredorders"
			));
		}

		if(getDolGlobalInt('DASHCYCLES_WIDGET_INPROGRESS_SHIPMENT')){
			array_push($objs, array(
				"position" => "0",
				"box_id" => "-1",
				"box_order" => getDolGlobalString('PROGRESSSHIPMENTS_ORDER'),
				"file" => "/dashcycles/core/boxes/box_progressshipment.php",
				"boxname" => "box_progressshipment"
			));
		}
		

		if(getDolGlobalInt('DASHCYCLES_WIDGET_WAITING_BILLS')){
			array_push($objs, array(
				"position" => "0",
				"box_id" => "-1",
				"box_order" => getDolGlobalString('OLDESTUNPAIDCUSTOMERBILLS_ORDER'),
				"file" => "/core/boxes/box_factures_imp.php",
				"boxname" => "box_factures_imp"
			));
		}

		if(getDolGlobalInt('DASHCYCLES_WIDGET_WAITING_APPROB')){
			array_push($objs, array(
				"position" => "0",
				"box_id" => "-1",
				"box_order" => getDolGlobalString("WAITINGSUPPLIERORDERS_ORDER"),
				"file" => "/dashcycles/core/boxes/box_waitingapprob.php",
				"boxname" => "box_waitingapprob"
			));
		}

		if(getDolGlobalInt('DASHCYCLES_WIDGET_SHIPMENT_SUPPLIER')){
			array_push($objs, array(
				"position" => "0",
				"box_id" => "-1",
				"box_order" => getDolGlobalString("SUPPLIERORDERSAWAITINGRECEPTION_ORDER"),
				"file" => "/dashcycles/core/boxes/box_supplierordersreception.php",
				"boxname" => "box_supplier_orders_awaiting_reception"
			));
		}

		usort($objs, function ($a, $b) { return $a['box_order'] > $b['box_order']; });

		foreach ($objs as $key => $obj){
			$obj = (object) $obj;
			// Starting by getting the box_id based on the file name
			$sql = "SELECT b.rowid as rowid, bd.rowid as box_id, bd.note as note FROM ".MAIN_DB_PREFIX."boxes_def AS bd LEFT JOIN ".MAIN_DB_PREFIX.'boxes AS b ON bd.rowid = b.box_id WHERE bd.file = "'.$obj->file.'"';
			$resql = $db->query($sql);
			// print 'sql :'.$sql.' res : '.$resql;
			$res = $db->fetch_object($resql);
			if($res){
				$obj->rowid = $res->rowid;
				$obj->box_id = $res->box_id;
				$obj->note = $res->note;
			}
			// var_dump($obj);
			// print '<br>';

			dol_include_once($obj->file);
			if(class_exists($obj->boxname)){
				$box = new $obj->boxname($db, $obj->note);

				$box->id = $obj->rowid;
				$box->id = $obj->box_id;
				$box->position =  $obj->position;
				$box->box_order = $obj->box_order;
				$box->fk_user = 0;
				$box->sourcefile = $obj->file;
				$box->class = $boxname;
				$box->note = $obj->note;
			}

			$boxes[] = $box;
		}

		return $boxes;
	}
}
