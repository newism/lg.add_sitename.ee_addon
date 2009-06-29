<?php
/**
* Language file for LG Add Sitename.
* 
* This file must be placed in the
* /system/language/english folder in your ExpressionEngine installation.
*
* @package LgAddSitename
* @version 1.3.0
* @author Leevi Graham <http://leevigraham.com>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-add-sitename/
* @copyright Copyright (c) 2007-2008 Leevi Graham
* @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-Share Alike 3.0 Unported
*/

$L = array(
	'lg_add_sitename_title' => 'LG Add Sitename',

	'access_rights' => 'Extension Access',
	'enable_extension_for_this_site' => 'Enable LG Add Sitename extension for this site?',
	'super_replacements' => 'Super Replacements',
	'enable_super_replacements' => 'Enable \'Super Replacements\'',
	'enable_super_replacements_info' => '
		<p>LG Add sitename will replace certain variables in your xhtml template. By default the extension will replace the following variables: <strong>{site_name}</strong>, <strong>{site_description}</strong> and <strong>{site_url}</strong>.</p>
		<p>Enabling \'Super Replacements\' extends the variables replaced. See the <a href=\'http://leevigraham.com/cms-customisation/expressionengine/lg-add-sitename/\'>extension documentation</a> for a full list of variables replaced.</p>',

	'cp_branding_title'			=> 'CP branding',
	'cp_branding_info'			=> 'CP branding can be added to the CP header. The following XHTML will be added to the top left of the header and the CSS is added before the closing &lt;/head&gt; tag.',
	'cp_branding_css_title' 	=> 'CP branding CSS',
	'cp_branding_xhtml_title' 	=> 'CP branding XHTML',

	'donation'					=> 'This extension was developed by <a href="http://leevigraham.com">Leevi Graham</a>. <br />Support its development by donating.',
	'lg_admin_title'			=> 'LG Admin Options',
	'show_donate_label'			=> 'Show the donation link at the top of the settings page?',
	'show_promos_label'			=> 'Show promos at the top of the settings page?',
	'show_time_label'			=> 'Show the server time and user time?',


	'head_additions_title'		=> 'CP &lt;/head&gt; additions',
	'head_additions_label'		=> 'Head additions',
	'head_additions_info'		=> 'Head additions are added right before the closing &lt;/head&gt; tag. Add global css files, site wide meta, favicons or whatever takes your fancy to every page of the CP.',

	'body_additions_title'		=> 'CP &lt;body&gt; additions',
	'body_additions_label'		=> 'Body additions',
	'body_additions_info'		=> 'Body additions are added right after the opening &lt;body&gt; tag. Add a global info to be display throughout the CP.',

	'foot_additions_title'		=> 'CP &lt;/body&gt; additions',
	'foot_additions_label'		=> 'Footer additions',
	'foot_additions_info'		=> 'Footer additions are added right before the closing &lt;/body&gt; tag. Add global js libraries or extra html to every page of the CP.',

	'page_title_title'			=> 'CP Admin page titles',
	'page_title_title_info' 	=> 'Replace \'ExpressionEngine\' in the CP admin page title with the value below.',
	'page_title_enable_label' 	=> 'Enable CP admin page title replacements?',
	'page_title_value_label' 	=> 'Replace \'ExpressionEngine\' with...',

	'extension_updates' => 'Extension Updates',
	'check_for_updates_title' => 'Check for updates?',
	'check_for_updates_info' => 'LG Add Sitename can call home (<a href="http://leevigraham.com/">http://leevigraham.com</a>) and check for recent updates.',
	'check_for_updates_label' => 'Would you like this extension to check for updates and display them on your CP homepage?',
	'cache_refresh_label' => 'How many minutes you like the update check cached for?',

// END
''=>''
);