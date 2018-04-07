<?php


namespace TD_Advertiser\src;
use TD_Advertiser\src\classes\init\TD_Advertiser_Init;
use TD_Advertiser\src\services\TD_Ads_Class_Loader;

if(!defined('ABSPATH'))
{
    die('-1');
}

if(!class_exists('TD_Advertiser_Main')) {

    class TD_Advertiser_Main
    {
        protected static $instance;

        /**
         * TD_Advertiser_Main constructor.
         */
        private function __construct()
        {
            register_activation_hook(TD_ADVERTISER_ROOT_PATH,array($this,'activate'));
            register_deactivation_hook(TD_ADVERTISER_ROOT_PATH,array($this,'deactivate'));


            $this->init_autoloader();
            add_action('plugins_loaded',array($this,'init'),0);
        }

        public static function getInstance()
        {
            if(!self::$instance)
            {
                self::$instance = new self;
            }
            return self::$instance;
        }

        public function init()
        {

            TD_Advertiser_Init::getInstance()->init();
        }

        function activate()
        {

        }
        function deactivate()
        {

        }
        private function init_autoloader()
        {

            if(!class_exists('TD_Ads_Class_Loader'))
            {
               require_once TD_ADVERTISER_PLUGIN_DIR.'src/services/TD_Ads_Class_Loader.php';
            }

            $autoLoader =TD_Ads_Class_Loader::getInstance();
            $autoLoader->setPrefixes(array("TD_Advertiser"=>TD_ADVERTISER_PLUGIN_DIR));
            $autoLoader->register_auto_loader();

        }

    }
}