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

	// Donate button
	var $paypal 			=  array(
		"account"				=> "sales@newism.com.au",
		"donations_accepted"	=> TRUE,
		"donation_amount"		=> "20.00",
		"currency_code"			=> "USD",
		"return_url"			=> "http://leevigraham.com/donate/thanks/",
		"cancel_url"			=> "http://leevigraham.com/donate/cancel/"
	);

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

		if(isset($SESS->cache['lg']) === FALSE){ $SESS->cache['lg'] = array();}
		if(isset($SESS->cache['Morphine']) === FALSE) $SESS->cache['Morphine'] = array();

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

		$lgau_query = $DB->query("SELECT class FROM exp_extensions WHERE class = 'Lg_addon_updater_ext' AND enabled = 'y' LIMIT 1");
		$lgau_enabled = $lgau_query->num_rows ? TRUE : FALSE;

		$DSP->title  = $LANG->line('extension_settings');

		$DSP->crumbline = TRUE;
		$DSP->crumb  = $DSP->anchor(BASE.AMP.'C=admin'.AMP.'area=utilities', $LANG->line('utilities')).
		$DSP->crumb_item($DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extensions_manager', $LANG->line('extensions_manager')));
		$DSP->crumb .= $DSP->crumb_item("{$this->name} {$this->version}");

		$DSP->right_crumb($LANG->line('disable_extension'), BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=toggle_extension_confirm'.AMP.'which=disable'.AMP.'name='.$IN->GBL('name'));

		$DSP->body = "<div class='mor settings-form'>";
		$DSP->body .= "<p class='donate paypal'>
							<a rel='external'"
								. "href='https://www.paypal.com/cgi-bin/webscr?"
									. "cmd=_donations&amp;"
									. "business=".rawurlencode($this->paypal["account"])."&amp;"
									. "item_name=".rawurlencode($this->name . " Development: Donation")."&amp;"
									. "amount=".rawurlencode($this->paypal["donation_amount"])."&amp;"
									. "no_shipping=1&amp;return=".rawurlencode($this->paypal["return_url"])."&amp;"
									. "cancel_return=".rawurlencode($this->paypal["cancel_url"])."&amp;"
									. "no_note=1&amp;"
									. "tax=0&amp;"
									. "currency_code=".$this->paypal["currency_code"]."&amp;"
									. "lc=US&amp;"
									. "bn=PP%2dDonationsBF&amp;"
									. "charset=UTF%2d8'"
								."class='button'
								target='_blank'>
								Support this addon by donating via PayPal.
							</a>
						</p>";
		$DSP->body .= $DSP->heading($this->name . " <small>{$this->version}</small>");
		ob_start(); include(PATH_LIB.'lg_add_sitename/views/lg_add_sitename/form_settings.php'); $DSP->body .= ob_get_clean();
		$DSP->body .=   "</div>";
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
			'body_additions'        => '',
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
												'priority'					=> 1,
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
				$settings[$site_id]['body_additions'] = '';
				$settings[$site_id]['foot_additions'] = '';
			}

			foreach ($hooks as $hook => $method)
			{
				$sql[] = $DB->update_string( 'exp_extensions',
											  array(
												'settings' => addslashes(serialize($settings)),
												'priority' => 1
											  ),
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
		global $EXT, $IN, $PREFS, $LOC, $SESS;

		if($EXT->last_call !== FALSE)
		{
			$out = $EXT->last_call;
		}

		if($this->settings['enable'] == 'y')
		{
			// replace {site_name} in the setting
			$site_name = stripslashes($PREFS->ini('site_name'));

			$xhtml = '';

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

			$fields = array(
				'xhtml' => $xhtml . $this->settings['xhtml'],
				'head_additions' => $this->settings['head_additions'],
				'foot_additions' => $this->settings['foot_additions'],
				'body_additions' => $this->settings['body_additions'],
			);

			$fields['xhtml'] = str_replace("{sitename}", $PREFS->core_ini['site_name'], $fields['xhtml']);
			$fields['xhtml'] = str_replace("{site_name}", $PREFS->core_ini['site_name'], $fields['xhtml']);
			$fields['xhtml'] = str_replace("{site_description}", $PREFS->core_ini['site_description'], $fields['xhtml']);
			$fields['xhtml'] = str_replace("{site_url}", $PREFS->core_ini['site_url'], $fields['xhtml']);
			$fields['xhtml'] = str_replace("{screen_name}", $SESS->userdata['screen_name'], $fields['xhtml']);
			$fields['xhtml'] = str_replace("{username}", $SESS->userdata['username'], $fields['xhtml']);

			// we just check if this is set for updates
			if(isset($this->settings['enable_super_replacements']) && $this->settings['enable_super_replacements'] == 'y')
			{
				foreach ($fields as $field => $field_contents)
				{
					$replacements = array_merge($PREFS->core_ini, $SESS->userdata);
  					foreach($replacements as $key => $value)
					{
						if(is_array($value) === FALSE && strpos($field_contents, LD . $key . RD) !== FALSE)
						{
							$fields[$field] = str_replace(LD.$key.RD, $value, $fields[$field]);
						}
					}
				}
			}

			$patterns[0] = "#</head>#";
			$replacements[0] = "\n" . $fields['head_additions'] . "\n" . '<style type="text/css" media="screen">'.$this->settings['css']."</style>\n</head>";

			$patterns[1] = "#<body>#";
			$replacements[1] = "\n<body>" . $fields['body_additions'];

			$patterns[2] = "#</body>#";
			$replacements[2] = "\n" . $fields['foot_additions'] . "\n</body>";

			// CP head html
			$patterns[3] = "/(<div class='helpLinksLeft' >)/";
			$replacements[3] = "<div class='helpLinksLeft' >" . $fields['xhtml'];
			
			if(isset($this->settings['enable_page_title_replacement']) === TRUE && $this->settings['enable_page_title_replacement'] == 'y')
			{
				$patterns[4] = "/ExpressionEngine<\/title>/";
				$replacements[4] = str_replace("{site_name}", $PREFS->core_ini['site_name'], $this->settings['page_title_replacement_value']) . "</title>";
			}

			if(isset($SESS->cache['Morphine']['cp_styles_included']) === FALSE && $IN->GBL("P") == "extension_settings" && $IN->GBL("name") == "lg_add_sitename")
			{
				$patterns['morphine'] = "#</head>#";
				$replacements['morphine'] .= "\n<link rel='stylesheet' type='text/css' media='screen' href='" . $PREFS->ini('theme_folder_url', 1) . "cp_themes/".$PREFS->ini('cp_theme')."/Morphine/css/MOR_screen.css' />";
				$SESS->cache['Morphine']['cp_styles_included'] = TRUE;
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
	/**
	 * Creates a select box
	 *
	 * @access public
	 * @param mixed $selected The selected value
	 * @param array $options The select box options in a multi-dimensional array. Array keys are used as the option value, array values are used as the option label
	 * @param string $input_name The name of the input eg: Lg_polls_ext[log_ip]
	 * @param string $input_id A unique ID for this select. If no id is given the id will be created from the $input_name
	 * @param boolean $use_lanng Pass the option label through the $LANG->line() method or display in a raw state
	 * @param array $attributes Any other attributes for the select box such as class, multiple, size etc
	 * @return string Select box html
	 */
	function select_box($selected, $options, $input_name, $input_id = FALSE, $use_lang = TRUE, $key_is_value = TRUE, $attributes = array())
	{
		global $LANG;

		$input_id = ($input_id === FALSE) ? str_replace(array("[", "]"), array("_", ""), $input_name) : $input_id;

		$attributes = array_merge(array(
			"name" => $input_name,
			"id" => strtolower($input_id)
		), $attributes);

		$attributes_str = "";
		foreach ($attributes as $key => $value)
		{
			$attributes_str .= " {$key}='{$value}' ";
		}

		$ret = "<select{$attributes_str}>";

		foreach($options as $option_value => $option_label)
		{
			if (!is_int($option_value))
				$option_value = $option_value;
			else
				$option_value = ($key_is_value === TRUE) ? $option_value : $option_label;

			$option_label = ($use_lang === TRUE) ? $LANG->line($option_label) : $option_label;
			$checked = ($selected == $option_value) ? " selected='selected' " : "";
			$ret .= "<option value='{$option_value}'{$checked}>{$option_label}</option>";
		}

		$ret .= "</select>";
		return $ret;
	}

}