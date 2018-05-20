<?php
namespace TD_Advertiser\src\short_codes;

use TD_Advertiser\src\short_codes\src\impl\TD_Ads_Set_Single_Zone;

class TD_Ads_Short_Codes
{
    private static $instance;

    private $short_codes = array();

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function __construct()
    {

    }

    function init()
    {


        if(is_admin())
        {
            add_action("admin_enqueue_scripts",array($this,"init_resource"));
        }
        add_action("vc_before_init",array($this,'vc_integration'));
    }

    function vc_integration()
    {

        $this->short_codes[] = new TD_Ads_Set_Single_Zone();

        foreach($this->short_codes as $sc)
        {
            add_action('vc_after_set_mode',array($sc,'load'));
        }
    }

    function init_resource()
    {

    }

}