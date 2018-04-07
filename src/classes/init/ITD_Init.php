<?php


namespace TD_Advertiser\src\classes\init;


interface ITD_Init
{

    public static function getInstance();

    function init_admin_menu();

    function init();

    function init_admin_resources();

    function init_front_end_resources();

    function init_post_type();
}