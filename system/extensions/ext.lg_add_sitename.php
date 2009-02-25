<?php
/**
* Class file for LG Add Sitename.
* 
* This file must be placed in the
* /system/extensions/ folder in your ExpressionEngine installation.
*
* @package LgAddSitename
* @version 1.3.0
* @author Leevi Graham <http://leevigraham.com>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-add-sitename/
* @copyright Copyright (c) 2007-2008 Leevi Graham
* @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-Share Alike 3.0 Unported
*/

if ( ! defined('EXT')) exit('Invalid file request');

define("LG_ASN_version",			"1.3.0");
define("LG_ASN_docs_url",			"http://leevigraham.com/cms-customisation/expressionengine/addon/lg-add-sitename/");
define("LG_ASN_addon_id",			"LG Add Sitename");
define("LG_ASN_extension_class",	"Lg_add_sitename");
define("LG_ASN_cache_name",			"lg_cache");

/**
* Adds custom XHTML and CSS to the header of the ExpressionEngine control panel.
*
* @package LgAddSitename
* @version 1.3.0
* @author Leevi Graham <http://leevigraham.com>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-add-sitename/
* @copyright Copyright (c) 2007-2008 Leevi Graham
* @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-Share Alike 3.0 Unported
*/
class Lg_add_sitename {

	/**
	* Extension settings
	* @var array
	*/
	var $settings			= array();

	/**
	* Extension name
	* @var string
	*/
	var $name				= LG_ASN_addon_id;

	/**
	* Extension version
	* @var string
	*/
	var $version			= LG_ASN_version;

	/**
	* Extension description
	* @var string
	*/
	var $description		= 'Adds custom XHTML and CSS to the header of the ExpressionEngine control panel.';

	/**
	* If $settings_exist = 'y' then a settings page will be shown in the ExpressionEngine admin
	* @var string
	*/
	var $settings_exist		= 'y';

	/**
	* Link to extension documentation
	* @var string
	*/
	var $docs_url			= LG_ASN_docs_url;

	/**
	* Debug?
	* @var string
	*/
	var $debug 				= FALSE;

	/**
	* PHP4 Constructor
	*
	* @see __construct()
	*/
	function Lg_add_sitename($settings='')
	{
		$this->__construct($settings);
	}

	/**
	* PHP 5 Constructor
	*
	* @param	array|string $settings Extension settings associative array or an empty string
	* @since	Version 1.1.0
	*/
	function __construct($settings='')
	{
		global $IN, $SESS;

		// get the settings from our helper class
		// this returns all the sites settings
		$this->settings = $this->_get_settings();

		if(isset($SESS->cache['lg']) === FALSE){
			$SESS->cache['lg'] = array();
		}
		$this->debug = $IN->GBL('debug');
	}

	/**
	* Configuration for the extension settings page
	**/
	function settings_form($current)
	{
		global $DB, $DSP, $LANG, $IN, $PREFS, $SESS;

		// create a local variable for the site settings
		$settings = $this->_get_settings();

		$DSP->crumbline = TRUE;

		$DSP->title  = $LANG->line('extension_settings');
		$DSP->crumb  = $DSP->anchor(BASE.AMP.'C=admin'.AMP.'area=utilities', $LANG->line('utilities')).
		$DSP->crumb_item($DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extensions_manager', $LANG->line('extensions_manager')));

		$DSP->crumb .= $DSP->crumb_item($LANG->line('lg_add_sitename_title') . " {$this->version}");

		$DSP->right_crumb($LANG->line('disable_extension'), BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=toggle_extension_confirm'.AMP.'which=disable'.AMP.'name='.$IN->GBL('name'));

		$DSP->body = '';

		if(isset($settings['show_promos']) === FALSE) {$settings['show_promos'] = 'y';}
		if($settings['show_promos'] == 'y')
		{
			$DSP->body .= "<script src='http://leevigraham.com/promos/ee.php?id=" . rawurlencode(LG_ASN_addon_id) ."&v=".$this->version."' type='text/javascript' charset='utf-8'></script>";
		}

		if(isset($settings['show_donate']) === FALSE) {$settings['show_donate'] = 'y';}
		if($settings['show_donate'] == 'y')
		{
			$DSP->body .= "<style type='text/css' media='screen'>
				#donate{float:right; margin-top:0; padding-left:190px; position:relative; top:-2px}
				#donate .button{background:transparent url(http://leevigraham.com/themes/site_themes/default/img/btn_paypal-donation.png) no-repeat scroll left bottom; display:block; height:0; overflow:hidden; position:absolute; top:0; left:0; padding-top:27px; text-decoration:none; width:175px}
				#donate .button:hover{background-position:top right;}
			</style>";
			$DSP->body .= "<p id='donate'>
							" . $LANG->line('donation') ."
							<a rel='external' href='https://www.paypal.com/cgi-bin/webscr?cmd=_donations&amp;business=sales%40leevigraham%2ecom&amp;item_name=LG%20Expression%20Engine%20Development&amp;amount=%2e00&amp;no_shipping=1&amp;return=http%3a%2f%2fleevigraham%2ecom%2fdonate%2fthanks&amp;cancel_return=http%3a%2f%2fleevigraham%2ecom%2fdonate%2fno%2dthanks&amp;no_note=1&amp;tax=0&amp;currency_code=USD&amp;lc=US&amp;bn=PP%2dDonationsBF&amp;charset=UTF%2d8' class='button' target='_blank'>Donate</a>
						</p>";
		}

		$DSP->body .= $DSP->heading($LANG->line('lg_add_sitename_title') . " <small>{$this->version}</small>");
		
		$DSP->body .= $DSP->form_open(
								array(
									'action' => 'C=admin'.AMP.'M=utilities'.AMP.'P=save_extension_settings'
								),
								// WHAT A M*THERF!@KING B!TCH THIS WAS
								// REMBER THE NAME ATTRIBUTE MUST ALWAYS MATCH THE FILENAME AND ITS CASE SENSITIVE
								// BUG??
								array('name' => strtolower(get_class($this)))
		);

		// EXTENSION ACCESS
		$DSP->body .=   $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableHeading', '', '2');
		$DSP->body .=   $LANG->line("access_rights");
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellOne', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold', $LANG->line('enable_extension_for_this_site'));
		$DSP->body .=   $DSP->td_c();

		$DSP->body .=   $DSP->td('tableCellOne');
		$DSP->body .=   "<select name='enable'>"
						. $DSP->input_select_option('y', "Yes", (($settings['enable'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['enable'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->table_c();

		// HEAD ADDITIONS
		$DSP->body .=   $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableHeading', '', '2');
		$DSP->body .=   $LANG->line("head_additions_title");
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('', '', '2');
		$DSP->body .=   "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'><p>" . $LANG->line('head_additions_info'). "</p></div>";
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellOne', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold', $LANG->line('head_additions_label'));
		$DSP->body .=   $DSP->td_c();

		$DSP->body .=   $DSP->td('tableCellOne');
		$DSP->body .=   $DSP->input_textarea('head_additions', $settings['head_additions'], 10, 'textarea', '99%');
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->table_c();

		// CP HEADER
		$DSP->body .=   $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableHeading', '', '2');
		$DSP->body .=   $LANG->line("cp_header_title");
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellOne', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold', $LANG->line('css'));
		$DSP->body .=   $DSP->td_c();

		$DSP->body .=   $DSP->td('tableCellOne');
		$DSP->body .=   $DSP->input_textarea('css', $settings['css'], 13, 'textarea', '99%');
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellTwo', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold', $LANG->line('xhtml'));
		$DSP->body .=   $DSP->td_c();

		$DSP->body .=   $DSP->td('tableCellTwo');
		$DSP->body .=   $DSP->input_textarea('xhtml', $settings['xhtml'], 5, 'textarea', '99%');
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('', '', '2');
		$DSP->body .=   "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'><p>" . $LANG->line('enable_super_replacements_info'). "</p></div>";
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellTwo', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold', $LANG->line('enable_super_replacements'));
		$DSP->body .=   $DSP->td_c();

		$DSP->body .=   $DSP->td('tableCellTwo');
		$DSP->body .=   "<select name='enable_super_replacements'>"
						. $DSP->input_select_option('y', "Yes", (($settings['enable_super_replacements'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['enable_super_replacements'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellOne', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold', $LANG->line('show_time_label'));
		$DSP->body .=   $DSP->td_c();

		$DSP->body .=   $DSP->td('tableCellOne');
		$DSP->body .=   "<select name='show_time'>"
						. $DSP->input_select_option('y', "Yes", (($settings['show_time'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['show_time'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->table_c();

		// FOOTER
		$DSP->body .=   $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableHeading', '', '2');
		$DSP->body .=   $LANG->line("foot_additions_title");
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('', '', '2');
		$DSP->body .=   "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'><p>" . $LANG->line('foot_additions_info'). "</p></div>";
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellOne', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold', $LANG->line('foot_additions_label'));
		$DSP->body .=   $DSP->td_c();

		$DSP->body .=   $DSP->td('tableCellOne');
		$DSP->body .=   $DSP->input_textarea('foot_additions', $settings['foot_additions'], 10, 'textarea', '99%');
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->table_c();

		// PAGE TITLES
		$DSP->body .=   $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableHeading', '', '2');
		$DSP->body .=   $LANG->line("page_title_title");
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('', '', '2');
		$DSP->body .=   "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'><p>" . $LANG->line('page_title_title_info'). "</p></div>";
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellOne', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold', $LANG->line('page_title_enable_label'));
		$DSP->body .=   $DSP->td_c();

		$DSP->body .=   $DSP->td('tableCellOne');
		$DSP->body .=   "<select name='enable_page_title_replacement'>"
						. $DSP->input_select_option('y', "Yes", (($settings['enable_page_title_replacement'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['enable_page_title_replacement'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellTwo', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold', $LANG->line("page_title_value_label"));
		$DSP->body .=   $DSP->td_c();

		$DSP->body .=   $DSP->td('tableCellTwo');
		$DSP->body .=   $DSP->input_text('page_title_replacement_value', $settings['page_title_replacement_value']);
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->table_c();

		// UPDATE SETTINGS
		$DSP->body .=   $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableHeading', '', '2');
		$DSP->body .=   $LANG->line("check_for_updates_title");
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('', '', '2');
		$DSP->body .=   "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'><p>" . $LANG->line('check_for_updates_info'). "</p></div>";
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellOne', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold', $LANG->line("check_for_updates_label"));
		$DSP->body .=   $DSP->td_c();


		$DSP->body .=   $DSP->td('tableCellOne');
		$DSP->body .=   "<select name='check_for_updates'>"
						. $DSP->input_select_option('y', "Yes", (($settings['check_for_updates'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['check_for_updates'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->table_c();

		if($IN->GBL('lg_admin') != 'y')
		{
			$DSP->body .= $DSP->table_c();
			$DSP->body .= "<input type='hidden' value='".$settings['show_donate']."' name='show_donate' />";
			$DSP->body .= "<input type='hidden' value='".$settings['show_promos']."' name='show_promos' />";
		}
		else
		{
			$DSP->body .= $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));
			$DSP->body .= $DSP->tr()
				. $DSP->td('tableHeading', '', '2')
				. $LANG->line("lg_admin_title")
				. $DSP->td_c()
				. $DSP->tr_c();

			$DSP->body .= $DSP->tr()
				. $DSP->td('tableCellOne', '30%')
				. $DSP->qdiv('defaultBold', $LANG->line("show_donate_label"))
				. $DSP->td_c();

			$DSP->body .= $DSP->td('tableCellOne')
				. "<select name='show_donate'>"
						. $DSP->input_select_option('y', "Yes", (($settings['show_donate'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['show_donate'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer()
				. $DSP->td_c()
				. $DSP->tr_c();

			$DSP->body .= $DSP->tr()
				. $DSP->td('tableCellTwo', '30%')
				. $DSP->qdiv('defaultBold', $LANG->line("show_promos_label"))
				. $DSP->td_c();

			$DSP->body .= $DSP->td('tableCellTwo')
				. "<select name='show_promos'>"
						. $DSP->input_select_option('y', "Yes", (($settings['show_promos'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['show_promos'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer()
				. $DSP->td_c()
				. $DSP->tr_c();

			$DSP->body .= $DSP->table_c();
		}		

		$DSP->body .=   $DSP->qdiv('itemWrapperTop', $DSP->input_submit());
		$DSP->body .=   $DSP->form_c();
	}

	/**
	* Save Settings
	**/
	function save_settings()
	{
		// make somethings global
		global $DB, $IN, $PREFS, $REGX, $SESS;

		// unset the name
		unset($_POST['name']);
		
		// load the settings from cache or DB
		// force a refresh and return the full site settings
		$settings = $this->_get_settings(TRUE, TRUE);

		// add the posted values to the settings
		$settings[$PREFS->ini('site_id')] = $_POST;

		// update the settings
		$query = $DB->query($sql = "UPDATE exp_extensions SET settings = '" . addslashes(serialize($settings)) . "' WHERE class = '" . LG_ASN_extension_class . "'");
	}

	/**
	* Returns the extension settings from the DB
	*
	* @access	private
	* @param	bool	$force_refresh	Force a refresh
	* @param	bool	$return_all		Set the full array of settings rather than just the current site
	* @return	array					The settings array
	*/
	function _get_settings($force_refresh = FALSE, $return_all = FALSE)
	{
		global $SESS, $DB, $REGX, $LANG, $PREFS;

		// assume there are no settings
		$settings = FALSE;

		// Get the settings for the extension
		if(isset($SESS->cache['lg'][LG_ASN_addon_id]['settings']) === FALSE || $force_refresh === TRUE)
		{
			// check the db for extension settings
			$query = $DB->query("SELECT settings FROM exp_extensions WHERE enabled = 'y' AND class = '" . LG_ASN_extension_class . "' LIMIT 1");

			// if there is a row and the row has settings
			if ($query->num_rows > 0 && $query->row['settings'] != '')
			{
				// save them to the cache
				$SESS->cache[LG_ASN_addon_id]['settings'] = $REGX->array_stripslashes(unserialize($query->row['settings']));
			}
		}
		// check to see if the session has been set
		// if it has return the session
		// if not return false
		if(empty($SESS->cache[LG_ASN_addon_id]['settings']) !== TRUE)
		{
			$settings = ($return_all === TRUE) ?  $SESS->cache[LG_ASN_addon_id]['settings'] : $SESS->cache[LG_ASN_addon_id]['settings'][$PREFS->ini('site_id')];
		}

		return $settings;

	}

	/**
	* Activates the extension
	*
	* @return	bool Always TRUE
	*/
	function activate_extension()
	{
		global $DB;

		// create a default settings array
		// create a blank settings array which will be filled later
		$default_settings = array(
			'enable' 							=> 'y',
			'enable_page_title_replacement'		=> 'n',
			'show_time'							=> 'n',
			'page_title_replacement_value' 		=> '{site_name}',
			'xhtml' 							=> "<div id='cp_sitename'>{site_name}</div>",
			'css' 								=> "#cp_sitename{
  border-right:1px solid #3D525F;
  color:#dadada;
  font-size:14px;
  float:left;
  padding:2px 10px 2px 0;
  margin:2px 10px 0 0;
}
#server-time{padding-bottom:9px}
/* Float the EE link left */
div.helpLinksLeft p{color:#fff;}
div.helpLinksLeft a { padding-top: 7px; display: block; float: left; }",
			'enable_super_replacements'			=> 'n',
			'check_for_updates' 				=> 'y',
			'add_site_name_to_admin_page_title' => 'y',
			'head_additions'					=> '',
			'foot_additions'					=> ''
);

		// get the list of installed sites
		$query = $DB->query("SELECT * FROM exp_sites");

		// for each of the sites
		foreach($query->result as $row)
		{
			// build a multi dimensional array for the settings
			$settings[$row['site_id']] = $default_settings;
		}

		// our hooks for the extension
		$hooks = array(
			'show_full_control_panel_end' 		=> 'show_full_control_panel_end',
			'lg_addon_update_register_source'	=> 'lg_addon_update_register_source',
			'lg_addon_update_register_addon'	=> 'lg_addon_update_register_addon'
		);

		// for each hook
		foreach ($hooks as $hook => $method)
		{
			// build sql
			$sql[] = $DB->insert_string( 'exp_extensions', 
											array('extension_id' 			=> '',
												'class'						=> LG_ASN_extension_class,
												'method'					=> $method,
												'hook'						=> $hook,
												'settings'					=> addslashes(serialize($settings)),
												'priority'					=> 10,
												'version'					=> $this->version,
												'enabled'					=> "y"
											)
										);
		}

		// run all sql queries
		foreach ($sql as $query)
		{
			$DB->query($query);
		}

	}

	/**
	* Updates the extension
	*
	* If the existing version is below 1.1.0 then the update process changes some
	* method names. This may cause an error which can be resolved by reloading
	* the page.
	*
	* @param	string $current If installed the current version of the extension otherwise an empty string
	* @return	bool FALSE if the extension is not installed or is the current version
	*/
	function update_extension($current='')
	{
		global $DB;

		if ($current == '' OR $current == $this->version)
			return FALSE;

		// Integrated LG Addon Updater
		// Removed control_panel_homepage hook
		// Added lg_addon_update_register_source hook + method
		// Added lg_addon_update_register_addon hook + method
		if($current < '1.2.0')
		{
			$settings = $this->_get_settings(TRUE, TRUE);

			foreach ($settings as $site_id => $site_settings)
			{
				$settings[$site_id]['show_time'] = 'n';
			}

			$sql[] = "DELETE FROM `exp_extensions` WHERE `class` = '".get_class($this)."' AND `hook` = 'control_panel_home_page'";
			$hooks = array(
				'lg_addon_update_register_source'	=> 'lg_addon_update_register_source',
				'lg_addon_update_register_addon'	=> 'lg_addon_update_register_addon'
			);

			foreach ($hooks as $hook => $method)
			{
				$sql[] = $DB->insert_string( 'exp_extensions', 
												array('extension_id' 	=> '',
													'class'			=> get_class($this),
													'method'		=> $method,
													'hook'			=> $hook,
													'settings'		=> addslashes(serialize($settings)),
													'priority'		=> 10,
													'version'		=> $this->version,
													'enabled'		=> "y"
												)
											);
			}
			
			$this->settings = $settngs[$PREFS->core_ini['site_id']];
			
		}

		// Added header additions and footer additions
		// Now it's out of our hands
		// Best of luck site admins, boo ha ha ha aha ha, cough, ha
		if($current < '1.3.0')
		{
			$settings = $this->_get_settings(TRUE, TRUE);

			foreach ($settings as $site_id => $site_settings)
			{
				$settings[$site_id]['head_additions'] = '';
				$settings[$site_id]['foot_additions'] = '';
			}

			foreach ($hooks as $hook => $method)
			{
				$sql[] = $DB->update_string( 'exp_extensions',
											  array('settings' => addslashes(serialize($settings))),
											  "class = '".get_class($this)."'"
											);
			}

			$this->settings = $settngs[$PREFS->core_ini['site_id']];

		}

		// update the version
		$sql[] = "UPDATE exp_extensions SET version = '" . $DB->escape_str($this->version) . "' WHERE class = '" . get_class($this) . "'";

		// run all sql queries
		foreach ($sql as $query)
		{
			$DB->query($query);
		}

		return TRUE;
	}

	/**
	* Disables the extension the extension and deletes settings from DB
	*/
	function disable_extension()
	{
		global $DB;
		$DB->query("DELETE FROM exp_extensions WHERE class = '".$DB->escape_str(get_class($this))."'");
	}

	/**
	* Takes the control panel html and adds the custom css and xhtml.
	*
	* @param	string $out The control panel html
	* @return	string The modified control panel html
	* @since 	Version 1.1.0
	* @see		http://expressionengine.com/developers/extension_hooks/show_full_control_panel_end/
	*/
	function show_full_control_panel_end( $out )
	{
		global $EXT, $PREFS, $LOC;

		if($EXT->last_call !== FALSE)
		{
			$out = $EXT->last_call;
		}

		if($this->settings['enable'] == 'y')
		{
			// replace {site_name} in the setting
			$site_name = stripslashes($PREFS->ini('site_name'));

			$xhtml = "";

			if($this->settings['show_time'] == 'y')
			{
				$xhtml = "<div id='server-time'>";
				$xhtml .= "Server Time: " . date("D M j G:i:s T Y") . " <!-- " . time() ." --><br/>";
				$xhtml .= "EE UTC Time: " . date("D M j G:i:s \U\T\C Y", $LOC->now) . " <!-- " . $LOC->now . " --><br/>";
				$xhtml .= "PHP UTC Time: " . gmdate("D M j G:i:s \U\T\C Y") . "<br />";
				$xhtml .= "Localised Time: " . date("D M j G:i:s Y", $LOC->set_localized_time()) . "<br />";
				$xhtml .= "Localised EE Human Time: " . $LOC->set_human_time();
				$xhtml .= "</div>";
			}

			$xhtml .= $this->settings['xhtml'];

			$xhtml = str_replace("{sitename}", $PREFS->core_ini['site_name'], $xhtml);
			$xhtml = str_replace("{site_name}", $PREFS->core_ini['site_name'], $xhtml);
			$xhtml = str_replace("{site_description}", $PREFS->core_ini['site_description'], $xhtml);
			$xhtml = str_replace("{site_url}", $PREFS->core_ini['site_url'], $xhtml);

			// we just check if this is set for updates
			if(isset($this->settings['enable_super_replacements']) && $this->settings['enable_super_replacements'] == 'y')
			{
				foreach($PREFS->core_ini as $key => $value)
				{
					if(is_array($value) === FALSE && strpos($xhtml, LD.$key.RD) !== FALSE)
					{
						$xhtml = str_replace(LD.$key.RD, $value, $xhtml);
					}
				}
			}

			$patterns[0] = "#</head>#";
			$replacements[0] = "\n" . $this->settings['head_additions'] . "\n" . '<style type="text/css" media="screen">'.$this->settings['css']."</style>\n</head>";

			$patterns[1] = "#</body>#";
			$replacements[1] = "\n" . $this->settings['foot_additions'] . "\n</body>";

			// CP head html
			$patterns[2] = "/(<div class='helpLinksLeft' >)/";
			$replacements[2] = "<div class='helpLinksLeft' >" . $xhtml;
			
			if(isset($this->settings['enable_page_title_replacement']) === TRUE && $this->settings['enable_page_title_replacement'] == 'y')
			{
				$patterns[3] = "/ExpressionEngine<\/title>/";
				$replacements[3] = str_replace("{site_name}", $PREFS->core_ini['site_name'], $this->settings['page_title_replacement_value']) . "</title>";
			}

			// the new output
			$out = preg_replace($patterns, $replacements, $out);
		}

		return $out;
	}

	/**
	* Register a new Addon Source
	*
	* @param array $sources The existing sources
	* @return array The new source list
	* @since version 1.1.0
	*/
	function lg_addon_update_register_source($sources)
	{
		global $EXT;
		// -- Check if we're not the only one using this hook
		if($EXT->last_call !== FALSE)
			$sources = $EXT->last_call;

		// add a new source
		// must be in the following format:
		/*
		<versions>
			<addon id='LG Addon Updater' version='2.0.0' last_updated="1218852797" docs_url="http://leevigraham.com/" />
		</versions>
		*/
		if($this->settings['check_for_updates'] == 'y')
		{
			$sources[] = 'http://leevigraham.com/version-check/versions.xml';
		}

		return $sources;

	}

	/**
	* Register a new Addon
	*
	* @param array $addons The existing sources
	* @return array The new addon list
	* @since version 1.1.0
	*/
	function lg_addon_update_register_addon($addons)
	{
		global $EXT;
		// -- Check if we're not the only one using this hook
		if($EXT->last_call !== FALSE)
			$addons = $EXT->last_call;

		// add a new addon
		// the key must match the id attribute in the source xml
		// the value must be the addons current version
		if($this->settings['check_for_updates'] == 'y')
		{
			$addons[LG_ASN_addon_id] = $this->version;
		}

		return $addons;
	}

}

?>