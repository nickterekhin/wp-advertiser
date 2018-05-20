<?php


namespace TD_Advertiser\src\classes\init\factories;


use ReflectionClass;
use TD_Advertiser\src\classes\TD_Advertiser_Base;
use TD_Advertiser\src\managers\TD_Advertiser_Base_Manager;

class TD_Navigation_Manager_Factory
{
    private static $instance;

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function getManager($page_name)
    {
        global $_menu_hooks;
        if(array_key_exists($page_name,$_menu_hooks))
        {
            if(preg_match('/banners-(.*?)$/',$page_name,$m)==1) {


                $r = new ReflectionClass('TD_Advertiser\src\managers\TD_Advertiser_Banners_' . ucfirst($m[1]) . '_Manager');
                /** @var TD_Advertiser_Base_Manager $manager_object */
                $manager_object = ($r->newInstanceWithoutConstructor());
                return $manager_object->getInstance();
            }

        }

        return null;
    }
}