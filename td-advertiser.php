<?php

/*
Plugin Name: TD Advertiser
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Plugin helps adding Advs blocks to your site.
Version: 1.0
Author: Terekhin
Author URI: http://terekhin-development.com
License: A "Slug" license name e.g. GPL2
*/
namespace TD_Advertiser;


use TD_Advertiser\src\TD_Advertiser_Main;

if ( !function_exists( 'add_action' ) ) {
    echo 'It is a plugin and you can\'t run it directly ';
    exit;
}

define('TD_ADVERTISER_VERSION','1.0.0');
define('TD_ADVERTISER_ROOT_PATH',__FILE__);
define('TD_ADVERTISER_PLUGIN_URL',plugin_dir_url(TD_ADVERTISER_ROOT_PATH));
define('TD_ADVERTISER_PLUGIN_DIR',dirname(__FILE__)."/");


require_once TD_ADVERTISER_PLUGIN_DIR.'src/TD_Advertiser_Main.php';


TD_Advertiser_Main::getInstance();