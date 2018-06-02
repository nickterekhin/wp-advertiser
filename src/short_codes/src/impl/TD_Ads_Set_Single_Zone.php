<?php


namespace TD_Advertiser\src\short_codes\src\impl;


use TD_Advertiser\src\short_codes\src\TD_Ads_Short_Codes_Base;
use WP_Post;
use WP_Query;
use WP_Term;

class TD_Ads_Set_Single_Zone extends TD_Ads_Short_Codes_Base
{
    public function __construct()
    {
        parent::__construct('td_ads_single_zone'); // TODO: Change the autogenerated stub
        $this->short_code_title = "Ads Single Layout";

    }


    function render($attr, $content)
    {
        $this->params = shortcode_atts($this->default_options,$attr);
        return $this->show_layout();
    }

    function base_params()
    {
        $zones = $this->get_ads_zones_list();

        $params_sc = array();
        $params_sc[] = array (
            'type' =>'dropdown' ,
            'heading' =>'Select Zone' ,
            'param_name' =>'ads_zone' ,
            'value'=>$zones,
            'save_always' => true,
            'description' =>'Select Zone what banners have to be shown',
        );

        return $params_sc;

    }
    private function get_ads_zones_list()
    {
        $args = array(
            'taxonomy'=>'td_ads_zone',
            'fields'=>'id=>name',
            'hide_empty' => false,
        );
       $terms =  get_terms($args);

        //var_dump(array_flip($terms));
        $zones = array_flip($terms);

        return $zones;
    }
    private  function show_layout()
    {
        global $wp_query;

        $obj = get_queried_object();

        $res = $wp_query->post;
        $args = array('location'=>'all');
        if($obj instanceof WP_Post && $obj->post_type=='page')
        {
            $args['location']='page';
            $args['obj_id']=$res->ID;
        }
        elseif($obj instanceof WP_Post && is_single($res->ID) && $res->post_type=='post')
        {
            $args['location']='single';
        }
        elseif($obj instanceof WP_Term && $obj->taxonomy=='category')
        {
            $args['location']='category';
            $args['obj_id']=$obj->term_id;
        }

        $res = $this->db->getBanners()->getMarkedBannerInZoneAndLocation($this->params['ads_zone'],$args);

        //set view+=1
        //set next marker 1

       //var_dump($res);
        $this->params['banners']=$res;
        return $this->View('single_layout',array_merge(array('obj'=>$this),$this->params));
    }

    private function getMarkedBanner()
    {



    }

}