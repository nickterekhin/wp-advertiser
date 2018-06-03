<?php
namespace TD_Advertiser\src\short_codes;

use TD_Advertiser\src\short_codes\src\impl\TD_Ads_Set_Single_Zone;
use TD_Advertiser\src\short_codes\src\TD_Ads_Short_Codes_Base;

class TD_Ads_Short_Codes
{
    private static $instance;

    /**
     * @var TD_Ads_Short_Codes_Base[]
     */
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
        $this->short_codes['banner'] = new TD_Ads_Set_Single_Zone();
    }

    function init()
    {


        if(is_admin())
        {
            add_action("admin_enqueue_scripts",array($this,"init_resource"));
        }
        add_action('wp_ajax_nopriv_banner_show',array($this,'ajax_action'));
        add_action('wp_ajax_banner_show',array($this,'ajax_action'));
        add_action("vc_before_init",array($this,'vc_integration'));
    }

    function vc_integration()
    {

        foreach($this->short_codes as $sc)
        {
            add_action('vc_after_set_mode',array($sc,'load'));
        }
    }

    function ajax_action()
    {
        if(isset($_REQUEST['banner_id']))
            $this->short_codes['banner']->set_banner_view($_REQUEST['banner_id']);
        echo 'ok';
        die();
    }
    function init_resource()
    {

    }

}