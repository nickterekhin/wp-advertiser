<?php


namespace TD_Advertiser\src\short_codes\src;


use Mobile_Detect;
use TD_Advertiser\src\repository\DBContext;
use TD_Advertiser\src\short_codes\helpers\Dimensions_Service;

require_once(TD_ADVERTISER_PLUGIN_DIR.'/lib/device_detection/Mobile_Detect.php');

abstract class TD_Ads_Short_Codes_Base implements ITD_Ads
{
    protected $default_options = array(
        'ads_zone'=>'',
        'extra_css_class'=>'',
        'ads_banner'=>null
    );
    protected $short_code_slug;
    protected $short_code_category = 'TD ADS';
    protected $short_code_title;
    protected $params=array();
    protected $db;

    protected $dimensions;
    protected $detect_device;

    /**
     * TD_Ads_Short_Codes_Base constructor.
     * @param $short_code_slug
     * @param $short_code_category
     */
    public function __construct($short_code_slug,$short_code_category=null)
    {

        $this->db=DBContext::getInstance();
        $this->detect_device = new Mobile_Detect();
        $this->dimensions = Dimensions_Service::getInstance();
        if($short_code_category)
            $this->short_code_category = $short_code_category;
        $this->short_code_slug = $short_code_slug;
        add_shortcode($short_code_slug,array($this,"render"));
    }

    function load()
    {
        add_action('vc_after_mapping',array($this,'mapping'));
    }

    function mapping()
    {
        if (function_exists('vc_map')) {
            $attr = array(
                "name" => $this->short_code_title,
                "base" => $this->short_code_slug,
                "category" => $this->short_code_category,
                "icon" => 'td-news-icon ' . $this->set_icon(),
                //"allowed_container_element"=>"vc_row",
                "params" => $this->base_params()
            );
            if ($this->is_container()) {
                //$attr['as_parent']=array('only'=>'vc_row');
                $attr['is_container'] = true;
                $attr["js_view"] = 'VcColumnView';
                //$attr["content_element"] = true;
            }

            vc_map($attr);

        }
    }

    function set_icon()
    {
        return 'fas fa-san';
    }

    function is_container()
    {
        return false;
    }

    function View($viewName, array $params=array())
    {

        if(is_array($params) && count($params)) {
            extract($params);
        }
        $file = TD_ADVERTISER_PLUGIN_DIR . '/src/short_codes/view/'. $viewName . '.php';

        ob_start();
        include( $file );
        $ret_obj= ob_get_clean();


        return $ret_obj;
    }

    public function set_banner_view($banner_id)
    {
        $this->db->getBanners()->setViewsById($banner_id);
    }

}