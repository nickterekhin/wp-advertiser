<?php


namespace TD_Advertiser\src\classes\init;

use TD_Advertiser\src\short_codes\TD_Ads_Short_Codes;

class TD_Advertiser_Init implements ITD_Init
{
    private static $instance;
    private $post_type="td-advertiser";
    /**
     * TD_Advertiser_Init constructor.
     */
    public function __construct()
    {
        TD_Ads_Short_Codes::getInstance()->init();

    }

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function init()
    {

        add_action('init',array($this,"init_post_type"),8);

        add_action('wp_enqueue_scripts',array($this,'init_front_end_resources'),20);

        if(is_admin())
        {
            add_action('admin_enqueue_scripts',array($this,'init_admin_resources'),11);
            add_action('admin_menu',array($this,'init_admin_menu'));
            add_action('do_meta_boxes', array($this,'remove_meta_boxes'));
        }


    }


    function init_admin_menu()
    {

    }

    function init_admin_resources()
    {
        wp_register_style('td_ads_admin-css',TD_ADVERTISER_PLUGIN_URL.'content/css/td_ads_admin_style.css');
        wp_enqueue_style('td_ads_admin-css');
        //wp_register_script('td_ads_admin-js',TD_ADVERTISER_PLUGIN_URL.'content/js/td_advertiser.js');
       // wp_enqueue_script('td_ads_admin-js');

    }
    function init_front_end_resources()
    {
        wp_enqueue_script('td_ads_jquery',TD_ADVERTISER_PLUGIN_URL.'content/js/jquery-3.3.1.min.js');
        wp_enqueue_script('td_ads_jquery');

        wp_enqueue_script('td_ads_jquery_ui',TD_ADVERTISER_PLUGIN_URL.'content/js/jquery-ui.min.js',array('jquery'),'3.3.1');
        wp_enqueue_script('td_ads_jquery_ui');

        wp_enqueue_script('td_ads_custom_js',TD_ADVERTISER_PLUGIN_URL.'content/js/td_advertiser.js',array('jquery'),'3.3.1');
        wp_enqueue_script('td_ads_custom_js');

        wp_register_style( 'td_ads_jquery_ui_css', TD_ADVERTISER_PLUGIN_URL . 'content/css/jquery-ui.min.css');
        wp_enqueue_style( 'td_ads_jquery_ui_css' );

        wp_register_style( 'td_ads_jquery_theme_css', TD_ADVERTISER_PLUGIN_URL . 'content/css/jquery-ui.theme.min.css');
        wp_enqueue_style( 'td_ads_jquery_theme_css' );

        wp_register_style('td_ads-css',TD_ADVERTISER_PLUGIN_URL.'content/css/td_ads_custom.css');
        wp_enqueue_style('td_ads-css');

    }

    function remove_meta_boxes()
    {
        global $wp_meta_boxes;

        remove_meta_box('mymetabox_revslider_0',$this->post_type,'normal');
    }
    function init_post_type()
    {
        $args =array(
            'labels'			=> array(
                'name'					=> __( 'Banner', 'a-cpt-i' ),
                'singular_name'			=> __( 'Banner', 'a-cpt-i' ),
                'add_new'				=> __( 'Add New' , 'a-cpt-i' ),
                'add_new_item'			=> __( 'Add New Banner' , 'a-cpt-i' ),
                'edit_item'				=> __( 'Edit Banner' , 'a-cpt-i' ),
                'new_item'				=> __( 'New Banner' , 'a-cpt-i' ),
                'view_item'				=> __( 'View Banner', 'a-cpt-i' ),
                'search_items'			=> __( 'Search Banners', 'a-cpt-i' ),
                'not_found'				=> __( 'No Banners found', 'a-cpt-i' ),
                'not_found_in_trash'	=> __( 'No Banners found in Trash', 'a-cpt-i' ),
            ),
            'description'       =>__('Description.'),
            'menu_icon'         =>'dashicons-admin-multisite',
            'menu_position'     =>6,
            'taxonomies'        =>array('td_ads_zone'),
            'public'			=> false,
            'show_ui'			=> true,
            '_builtin'			=> false,
            'capability_type'	=> 'ads_banner',
            'capabilities'		=> array(
                'edit_posts'            =>'edit_ads_banners',
                'create_posts'			=> 'create_ads_banner'
            ),
            'map_meta_cap'		=> true,
            'hierarchical'		=> false,
            'rewrite'			=> false,
            'query_var'			=> true,
            'supports' 			=> array('title'),
            'show_in_menu'		=> true,
            'has_archive'       => false,

        );

        register_post_type( $this->post_type, $args );

        $labels = array(
            'name'              => ( 'Ads Zones'),
            'singular_name'     => ( 'Ads Zone'),
            'search_items'      => __( 'Search Ads Zones' ),
            'all_items'         => __( 'All Ads Zones' ),
            'parent_item'       => __( 'Parent Ads Zone' ),
            'parent_item_colon' => __( 'Parent Ads Zone:' ),
            'edit_item'         => __( 'Edit Ads Zone' ),
            'update_item'       => __( 'Update Ads Zone' ),
            'add_new_item'      => __( 'Add New Ads Zone' ),
            'new_item_name'     => __( 'New Ads Zone Name' ),
            'menu_name'         => __( 'Ads Zones' ),
        );

        $args_taxonomy = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'public'			=>true,
            'show_ui'           => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'rewrite'           => array( 'slug' => 'ads_zones')
        );
        register_taxonomy( 'td_ads_zone', array( $this->post_type ), $args_taxonomy );

    }
}