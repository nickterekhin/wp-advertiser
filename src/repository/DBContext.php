<?php


namespace TD_Advertiser\src\repository;


use TD_Advertiser\src\repository\impl\Banners;

final class DBContext
{
    private static $instance;
    /**
     * @var IBanners
     */
    private $banners;
    /**
     * DBContext constructor.
     */
    public function __construct()
    {
        $this->banners = new Banners();
    }
    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return IBanners
     */
    public function getBanners()
    {
        return $this->banners;
    }


}