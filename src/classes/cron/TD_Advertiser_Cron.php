<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 03.06.2018
 * Time: 22:17
 */

namespace TD_Advertiser\src\classes\cron;


use TD_Advertiser\src\repository\DBContext;

class TD_Advertiser_Cron
{

    private static $instance;
    private static $action = 'td_advertiser_scheduler_cron';
    private static $run_task = 'td_advertiser_cron_run';
    private static $interval_name = 'td_advertiser-daily';
    private $is_running = false;
    /**
     * @var DBContext
     */
    private $dbc;

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public static function getAction()
    {
        return self::$action;
    }

    private function __construct()
    {
        $this->dbc = DBContext::getInstance();

        add_action( 'init', array( $this, 'reg_cron' ) );

        add_filter( 'cron_schedules', array( $this, 'init_custom_interval' ) );

        add_action( self::$action, array( $this, 'run' ) );

        add_action( self::$run_task, array( $this, 'fetch_task' ), 15 );
    }

    function init_custom_interval(array $schedules)
    {
        $schedules[self::$interval_name] = array(
            'interval' => DAY_IN_SECONDS,
            'display'  => 'Every Day At 00:01',
        );

        return (array) $schedules;
    }
    function reg_cron()
    {
        if ( wp_next_scheduled( self::$action ) ) {
            return;
        }

        $date = date( 'Y-m-d ' );
        $date .= '00:01';

        $start_timestamp = strtotime( $date );

        wp_schedule_event( $start_timestamp, self::$interval_name, self::$action );
    }
    function run()
    {
        $this->is_running = true;

        do_action( self::$run_task );
        $this->is_running = false;

    }

    function fetch_task()
    {
        $this->dbc->getBanners()->cleanBanners();
    }
}