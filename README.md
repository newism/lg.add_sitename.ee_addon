LG Add Sitename - Add images, css and text to your ExpressionEngine sites administration
========================================================================================

LG Add Sitename is a simple [ExpressionEngine][ee] extension inspired by [Ryan Masugas Add Sitename Extension][1].

This extension allows you to add any html and css to the ExpressionEngine CP header including images, flash or any other html element. For developers UTC and user localised time can also be displayed in the header which will help with debugging timezones.

The extension comes with default settings that adds a light grey piece of text with the site's name to the ExpressionEngine administration header.

LG Add Sitename is Multi-site Manager compatible and will notify site administrators when an update is available (requires [LG Addon Updater][lg_addon_updater]).

### Screenshots - coming soon.

Getting started
-------------

### Requirements

LG Add Sitename requires ExpressionEngine 1.6+ but is not available for EE 2.0+ yet. Addon update notifications require [LG Addon Updater][lg_addon_updater].

Technical requirements include:

* PHP5
* A modern browser: [Firefox][firefox], [Safari][safari], [Google Chrome][chrome] or IE8+

Other requirements:

LG Add Sitename requires the 'Morphine' default CP theme addon. [Download the theme addon from Github][gh_morphine_theme].

### Installation

1. Download the latest version of LG Add Sitename
2. Extract the .zip file to your desktop
3. Copy `system/extensions/ext.lg_add_sitename.php` to `system/extensions/`
3. Copy `system/language/english/lang.lg_add_sitename.php` to `system/language/english/`

### Activation

1. Open the [Extension Manager][ee_extensions_manager]
2. Enable Extensions if not already enabled
3. Enable the extension
4. Configure the extension settings


### Configuration

LG Add Sitename has the following extension settings which need to be entered separately for each Multi-Site Manager site.

Note: All configuration options are site specific. When a new site is created be sure to save the extension settings for the new site to avoid errors.

#### Extension preferences

##### Enable LG Add Sitename for this site?

Enabling LG Add Sitename will add custom CSS and HML to the CP for this site.

#### CP Branding

CP branding can be added to the CP header. The following XHTML will be added to the top left of the header and the CSS is added before the closing `</head>` tag.

LG Add sitename will replace certain variables in your xhtml template. By default the extension will replace the following variables: `{site_name}`, `{site_description`} and `{site_url}`.

##### CP branding XHTML [optional]

    <div id='cp_sitename'>{site_name}</div>

The XHTML is inserted into the top left of the CP, generally the site name or a website avatar.

##### Enable Super Replacements? [required]

Enabling 'Super Replacements' extends the variables replaced. The following variables are replaced in the CP branding XHTML when super replacements are enabled:

* `{enable_image_resizing}`
* `{image_resize_protocol}`
* `{image_library_path}`
* `{thumbnail_prefix}`
* `{word_separator}`
* `{use_category_name}`
* `{reserved_category_word}`
* `{auto_convert_high_ascii}`
* `{new_posts_clear_caches}`
* `{auto_assign_cat_parents}`
* `{site_404}`
* `{save_tmpl_revisions}`
* `{max_tmpl_revisions}`
* `{save_tmpl_files}`
* `{tmpl_file_basepath}`
* `{un_min_len}`
* `{pw_min_len}`
* `{allow_member_registration}`
* `{allow_member_localization}`
* `{req_mbr_activation}`
* `{new_member_notification}`
* `{mbr_notification_emails}`
* `{require_terms_of_service}`
* `{use_membership_captcha}`
* `{default_member_group}`
* `{profile_trigger}`
* `{member_theme}`
* `{enable_avatars}`
* `{allow_avatar_uploads}`
* `{avatar_url}`
* `{avatar_path}`
* `{avatar_max_width}`
* `{avatar_max_height}`
* `{avatar_max_kb}`
* `{enable_photos}`
* `{photo_url}`
* `{photo_path}`
* `{photo_max_width}`
* `{photo_max_height}`
* `{photo_max_kb}`
* `{allow_signatures}`
* `{sig_maxlength}`
* `{sig_allow_img_hotlink}`
* `{sig_allow_img_upload}`
* `{sig_img_url}`
* `{sig_img_path}`
* `{sig_img_max_width}`
* `{sig_img_max_height}`
* `{sig_img_max_kb}`
* `{prv_msg_upload_path}`
* `{prv_msg_max_attachments}`
* `{prv_msg_attach_maxsize}`
* `{prv_msg_attach_total}`
* `{prv_msg_html_format}`
* `{prv_msg_auto_links}`
* `{prv_msg_max_chars}`
* `{memberlist_order_by}`
* `{memberlist_sort_order}`
* `{memberlist_row_limit}`
* `{mailinglist_enabled}`
* `{mailinglist_notify}`
* `{mailinglist_notify_emails}`
* `{encryption_type}`
* `{site_index}`
* `{site_name}`
* `{site_url}`
* `{theme_folder_url}`
* `{webmaster_email}`
* `{webmaster_name}`
* `{weblog_nomenclature}`
* `{max_caches}`
* `{captcha_url}`
* `{captcha_path}`
* `{captcha_font}`
* `{captcha_rand}`
* `{captcha_require_members}`
* `{enable_db_caching}`
* `{enable_sql_caching}`
* `{force_query_string}`
* `{show_queries}`
* `{template_debugging}`
* `{include_seconds}`
* `{cookie_domain}`
* `{cookie_path}`
* `{user_session_type}`
* `{admin_session_type}`
* `{allow_username_change}`
* `{allow_multi_logins}`
* `{password_lockout}`
* `{password_lockout_interval}`
* `{require_ip_for_login}`
* `{require_ip_for_posting}`
* `{allow_multi_emails}`
* `{require_secure_passwords}`
* `{allow_dictionary_pw}`
* `{name_of_dictionary_file}`
* `{xss_clean_uploads}`
* `{redirect_method}`
* `{deft_lang}`
* `{xml_lang}`
* `{charset}`
* `{send_headers}`
* `{gzip_output}`
* `{log_referrers}`
* `{max_referrers}`
* `{time_format}`
* `{server_timezone}`
* `{server_offset}`
* `{daylight_savings}`
* `{default_site_timezone}`
* `{default_site_dst}`
* `{honor_entry_dst}`
* `{mail_protocol}`
* `{smtp_server}`
* `{smtp_username}`
* `{smtp_password}`
* `{email_debug}`
* `{email_charset}`
* `{email_batchmode}`
* `{email_batch_size}`
* `{mail_format}`
* `{word_wrap}`
* `{email_console_timelock}`
* `{log_email_console_msgs}`
* `{cp_theme}`
* `{email_module_captchas}`
* `{log_search_terms}`
* `{secure_forms}`
* `{deny_duplicate_data}`
* `{redirect_submitted_links}`
* `{enable_censoring}`
* `{censored_words}`
* `{censor_replacement}`
* `{banned_ips}`
* `{banned_emails}`
* `{banned_usernames}`
* `{banned_screen_names}`
* `{ban_action}`
* `{ban_message}`
* `{ban_destination}`
* `{enable_emoticons}`
* `{emoticon_path}`
* `{recount_batch_total}`
* `{remap_pm_urls}`
* `{remap_pm_dest}`
* `{new_version_check}`
* `{publish_tab_behavior}`
* `{sites_tab_behavior}`
* `{enable_throttling}`
* `{banish_masked_ips}`
* `{max_page_loads}`
* `{time_interval}`
* `{lockout_time}`
* `{banishment_type}`
* `{banishment_url}`
* `{banishment_message}`
* `{enable_search_log}`
* `{max_logged_searches}`
* `{theme_folder_path}`
* `{is_site_on}`
* `{app_version}`
* `{license_number}`
* `{debug}`
* `{install_lock}`
* `{db_hostname}`
* `{db_username}`
* `{db_password}`
* `{db_name}`
* `{db_type}`
* `{db_prefix}`
* `{db_conntype}`
* `{system_folder}`
* `{cp_url}`
* `{doc_url}`
* `{cookie_prefix}`
* `{is_system_on}`
* `{allow_extensions}`
* `{multiple_sites_enabled}`
* `{site_pages}`
* `{site_id}`
* `{site_label}`
* `{site_description}`
* `{site_short_name}`

##### CP branding CSS [optional]

    cp_sitename{
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
    div.helpLinksLeft a { padding-top: 7px; display: block; float: left; }

The css is added just before the closing `</head>` tag on every CP page.

##### Show the server time and user time?

For developers especially when debugging, timezones can cause issues. To make debugging ExpressionEngine timezone handling easier LG Add Sitename adds time output to the CP header in the following format:

    Server Time: Fri Aug 22 15:07:45 EST 2008
    EE UTC Time: Fri Aug 22 5:07:45 UTC 2008
    PHP UTC Time: Fri Aug 22 5:07:45 UTC 2008
    Localised Time: Fri Aug 22 15:07:45 2008
    Localised EE Human Time: 2008-08-22 03:07 PM

#### HTML source additions

Over time LG Add Sitename has evolved beyond it's namesake into a CP customisation extension. The following three extension settings allow you to modify core parts of the CP allowing you to add custom JS libraries, CSS or other HTML.

##### Head additions [optional]

Head additions are added right before the closing `</head>` tag. Add global css files, site wide meta, favicons or whatever takes your fancy to every page of the CP.

##### Body additions [optional]

Body additions are added right after the opening `<body>` tag. Add a global info to be display throughout the CP.
    
##### Footer additions [optional]

Footer additions are added right before the closing `</body>` tag. Add global js libraries or extra html to every page of the CP.

#### CP Admin page titles

This setting controls the CP `<title>` meta tag allowing you to add your own title.

##### Enable CP admin page title replacements?

Enable / disable CP admin page title replacements.

##### Replace 'ExpressionEngine' with...

    {site_name}

The string used when replacing 'ExpressionEngine' in the CP `<title>` tag.

#### Upgrade notifications

LG Add Sitename can call home, check for recent updates and display them on your CP homepage? This feature requires [LG Addon Updater][lg_addon_updater] to be installed and activated.

##### Would you like this extension to check for updates?

Enable / disable update notifications.

Version Notes
------------

### Upgrading?

* Before upgrading back up your database and site first, you can never be too careful.
* Never upgrade a live site, you're asking for trouble regardless of the addon.
* After an upgrade if you are experiencing errors re-save the extension settings for each site in your ExpressionEngine install.

### Change Log

#### 1.3.0

* Rewrote documentation
* Added HTML source additions
* LG Add Sitename now requires the 'Morphine' default CP theme addon. [Download the theme addon from Github][gh_morphine_theme].

#### 1.2.0

* Added Multi-Site manager compatibility
* Integrated LG Addon Updater
* Added page title replacements
* Added super {ee_tag} replacements
* Added 'Show Time' option

#### 1.1.0

* Changed method names to follow new internal coding standards
* Source code commenting in PHPDoc syntax
* Added Slovak language file

#### 1.0.1

* Small bug fix

#### 1.0.0

* Initial Release

Support
-------

Technical support is available primarily through the ExpressionEngine forums. Leevi Graham and Newism do not provide direct phone support. No representations or guarantees are made regarding the response time in which support questions are answered.

Although we are actively developing this addon, Leevi Graham and Newism makes no guarantees that it will be upgraded within any specific timeframe.

License
------

Ownership of this software always remains property of the author.

You may:

* Modify the software for your own projects
* Use the software on personal and commercial projects

You may not:

* Resell or redistribute the software in any form or manner without permission of the author
* Remove the license / copyright / author credits

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

[ee]: http://expressionengine.com/index.php?affiliate=newism
[ee_extensions_manager]: http://expressionengine.com/index.php?affiliate=newism&page=docs/cp/admin/utilities/extension_manager.html

[firefox]: http://firefox.com
[safari]: http://www.apple.com/safari/download/
[chrome]: http://www.google.com/chrome/

[lg_addon_updater]: http://leevigraham.com/cms-customisation/expressionengine/lg-addon-updater/
[gh_morphine_theme]: http://github.com/newism/nsm.morphine.theme

[1]: http://expressionengine.com/forums/viewthread/54996/