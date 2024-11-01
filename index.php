<?php
/*
Plugin Name: WP Contakt
Description: Creating forms for your site.
Author: Son Nguyen Huy
Author URI: http://creativevoi.com/
Version: 1.0
*/

define('WPCONTAKT_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('WPCONTAKT_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
define('WPCONTAKT_FORM_TABLE', 'wpcontakt_forms');
define('WPCONTAKT_FIELD_TABLE', 'wpcontakt_fields');
define('WPCONTAKT_SHORTCODE', 'WPCONTAKT');

require_once(WPCONTAKT_PLUGIN_PATH.'admin.php');

class WPContakt
{
    function __construct()
    {
        register_activation_hook(__FILE__, array(&$this, 'on_activation'));
        register_deactivation_hook(__FILE__, array(&$this, 'on_deactivation'));
    }
    
    function on_activation()
    {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        # Create wpcontakt_forms table
        $table = $wpdb->prefix . WPCONTAKT_FORM_TABLE;
        if($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
            $sql  = "CREATE TABLE /*!32312 IF NOT EXISTS*/ `$table` (
                      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                      `name` VARCHAR(255) NOT NULL DEFAULT '',
                      `attribute_id` VARCHAR(255) NOT NULL DEFAULT '',
                      `attribute_class` VARCHAR(255) NOT NULL DEFAULT '',
                      `data` TEXT NOT NULL DEFAULT '',
                      `enable` TINYINT(1) NOT NULL DEFAULT '1',
                      PRIMARY KEY (`id`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
                    ";
            dbDelta($sql);
        }

        # Create wpcontakt_fields table
        $table = $wpdb->prefix . WPCONTAKT_FIELD_TABLE;
        if($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
            $sql  = "CREATE TABLE /*!32312 IF NOT EXISTS*/ `$table` (
                      `id` INT(10) NOT NULL AUTO_INCREMENT,
                      `form_id` INT(10) NOT NULL DEFAULT '0',
                      `type` ENUM('text','textarea','checkbox','radio','select','hidden') NOT NULL DEFAULT 'text',
                      `label` TEXT NOT NULL DEFAULT '',
                      `default_value` TEXT NULL,
                      `attribute_class` VARCHAR(255) NULL,
                      `data` TEXT NULL,
                      `validation_rules` VARCHAR(255) NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
                    ";
            dbDelta($sql);
        }
    }
    
    function on_deactivation()
    {
        
    }
}

$WPContakt = new WPContakt();