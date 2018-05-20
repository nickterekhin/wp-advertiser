<?php


namespace TD_Advertiser\src\repository\impl;


use TD_Advertiser\src\classes\TD_Settings;

abstract class Repository
{
    protected $db;
    protected $table;
    protected $settings;
    function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $wpdb->show_errors     = true;
        $wpdb->suppress_errors = false;
        $this->settings = TD_Settings::getInstance();
    }

    protected abstract function mapping($res);

    function showErrors()
    {
        if($this->db->last_error!='')
        {
            $str = htmlspecialchars($this->db->last_error,ENT_QUOTES);
            $query = htmlspecialchars($this->db->last_query,ENT_QUOTES);
            return "<strong>WordPress database error:</strong>[$str]<br /><i>$query</i>";
        }
        return null;
    }
}