<?php


namespace TD_Advertiser\src\classes;


class TD_Settings
{

    private static $instance;
    private $post_type_name ='td-advertiser';
    private $menu_capability = 'manage_options';
    /*private $import_page_name = 'importer';
    private $admin_menu_page_url = 'cf-events-import';*/
    private $view_params = array(
        'view'=>''
    );

    private $response_params = array(
        'page'=>null
    );

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function getPage()
    {
        return $this->getParams()['page'];
    }

    public function setPage($page_name)
    {
        $this->setParamsBy('page',$page_name);
    }
    /**
     * @return string
     */
    public function getPostTypeName()
    {
        return $this->post_type_name;
    }

    /**
     * @param string $post_type_name
     */
    public function setPostTypeName($post_type_name)
    {
        $this->post_type_name = $post_type_name;
    }

    /**
     * @return string
     */
    public function getMenuCapability()
    {
        return $this->menu_capability;
    }

    /**
     * @param string $menu_capability
     */
    public function setMenuCapability($menu_capability)
    {
        $this->menu_capability = $menu_capability;
    }

    /**
     * @return string
     */
    public function getImportPageName()
    {
        return $this->import_page_name;
    }

    /**
     * @param string $import_page_name
     */
    public function setImportPageName($import_page_name)
    {
        $this->import_page_name = $import_page_name;
    }

    /**
     * @param null $page_name
     * @return mixed
     */
   /* public function getAdminMenuPageUrl($page_name=null)
    {
        return $this->admin_menu_page_url;
    }*/

    /**
     * @param mixed $admin_menu_page_url
     */
   /* public function setAdminMenuPageUrl($admin_menu_page_url)
    {
        $this->admin_menu_page_url = $admin_menu_page_url;
    }*/
    //getters and setters
    public function getView()
    {
        return $this->getViewParams()['view'];
    }
    public function setView($view)
    {
        $this->setViewParams(array('view'=>$view));
    }

    /**
     * @return array
     */
    public function getViewParams()
    {
        return $this->view_params;
    }

    /**
     * @param array $view_params
     */
    public function setViewParams($view_params)
    {
        $this->view_params = wp_parse_args($view_params,$this->view_params);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->response_params;
    }

    /**
     * @param $param_name
     * @param $response_params
     */
    public function setParamsBy($param_name,$response_params)
    {
        if(isset($this->response_params[$param_name]) && is_object($this->response_params[$param_name])) {
            $this->response_params[$param_name] = wp_parse_args($response_params,$this->response_params[$param_name]);
        }
        else
        {
            $this->response_params[$param_name] = $response_params;
        }
    }

    public function setParams($params)
    {
        $this->response_params = wp_parse_args($params,$this->response_params);
    }
    function setNotify($value=array())
    {
        set_transient('td_ads_error_handler',$value);
    }

}