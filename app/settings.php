<?php

/* Static settings */
$site['path'] = 'localhost/parfümal/';
$site['url'] = 'http://localhost/parfümal/';

/* Is developer is still driving :)
 * Set it true and include developer.php to overwrite settings
 */
$site['developer'] = 0;

// Location of web site
$site['dir'] = '//Applications/MAMP/htdocs/parfümal';

$site['data_dir'] = 'data/';
$site['image_dir'] = 'data/_images/';
$site['video_dir'] = 'data/_videos/';
$site['file_dir']  = 'data/dosyalar/';

// Url of important folders
$site['data_path']  = $site['url'].'data/';
$site['image_path'] = $site['data_path'].'_images/';
$site['video_path'] = $site['data_path'].'_videos/';
$site['file_path']  = $site['data_path'].'_files/';

// Version
$site['version'] = '1.0';

/* Dynamic settings */
$setting = Setting::read();

// Data, time and timestamp
$site['today'] = date('Y-m-d');
$site['time'] = date('H:s');
$site['timestamp'] = time();

/** Dynamic settings from database
 * 
 */
class Setting
{
    public static $table_settings = 'settings';
    public static $table_langs = 'langs';

    public static function read()
    {
        // Read settings from database and gather setting array
        $results = select(self::$table_settings)->order('setting_id ASC')->results();
        $setting = array();
        foreach ($results as $res) {
            $setting[$res['setting_name']] = $res['setting_value'];
        }

        $defaul_lang = select(self::$table_langs)->where('lang_code = "'.$setting['default_lang'].'"')->limit(1)->result();
        $setting['default_lang'] = $defaul_lang['lang_code'];
        $setting['default_lang_id'] = $defaul_lang['lang_id'];

        // Define timezone as in the http://us1.php.net/manual/en/timezones.php
        if (!empty($setting['timezone'])) {
            date_default_timezone_set($setting['timezone']);
        }

		// Set this variable to a bool
        if ($setting['multi_lang'] == 'off') {
            $setting['multi_lang'] = 0;
        } else {
            $setting['multi_lang'] = 1;
        }

        return $setting;
    }
}
// If the site is still in development include developer.php to overwride
if ($site['developer'] == 1) {
    require_once 'developer.php';
}
