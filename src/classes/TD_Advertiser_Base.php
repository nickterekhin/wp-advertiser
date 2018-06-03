<?php


namespace TD_Advertiser\src\classes;


use TD_Advertiser\src\repository\DBContext;

abstract class TD_Advertiser_Base
{
    private static $_instances = array();
    /**
     * @var DBContext
     */
    protected $db_ctx;

    private $default_actions = array(
        'del',
        'add'
    );

    /**
     * @var TD_Settings
     */
    protected $settings;

    protected function __construct()
    {
        $this->settings = TD_Settings::getInstance();
        $this->db_ctx = DBContext::getInstance();

    }
    public abstract function init();
    public static function getInstance() {
        $class = get_called_class();
        if (!isset(self::$_instances[$class])) {
            self::$_instances[$class] = new $class();
        }
        return self::$_instances[$class];
    }
    protected function isAction()
    {
        $action =$_REQUEST['a'];
        if(isset($action)) {
            if(in_array($action,$this->default_actions))
                return true;
        }

        return false;

    }
    protected function isSave()
    {
        return isset($_POST['td-ads-save']) && !empty($_POST['td-ads-save']) && $_POST['td-ads-save'] == '1';
    }

    protected function isObjectId()
    {
        return ((isset($_REQUEST['id']) && !empty($_REQUEST['id'])));
    }

    protected function isPage()
    {
        global $_menu_hooks;

        return isset($_REQUEST['page']) && !empty($_REQUEST['page']) && array_key_exists($_REQUEST['page'],$_menu_hooks);

    }

    /**
     * @return DBContext
     */
    public function getDbCtx()
    {
        return $this->db_ctx;
    }


}