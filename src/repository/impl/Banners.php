<?php


namespace TD_Advertiser\src\repository\impl;


use DateTime;
use TD_Advertiser\src\object\AdsObject;
use TD_Advertiser\src\object\Banner;
use TD_Advertiser\src\repository\IBanners;
use WP_Post;

class Banners extends Repository implements IBanners
{
    function __construct()
    {
        parent::__construct(); // TODO: Change the autogenerated stub
    }

    /**
     * @param AdsObject|Banner $object
     */
    function create(AdsObject $object)
    {

    }

    function update(AdsObject $object)
    {
        // TODO: Implement update() method.
    }

    function delete($id)
    {
        wp_delete_post($id);
    }

    function getAll($args = array())
    {
        $default_args =array(
            'post_type'=>$this->settings->getPostTypeName(),
            'posts_per_page'=>-1
        );
        $args = wp_parse_args($args,$default_args);

        $q = new \WP_Query($args);

        $banners = array();
        foreach ($q->posts as $p ) {
            $banners[] = $this->mapping($p);
        }

        return $banners;

    }

    function getById($id)
    {
        $sql = $this->db->prepare("SELECT p.*,tr.term_taxonomy_id as zone_id FROM wp_posts p INNER JOIN wp_term_relationships tr ON p.ID = tr.object_id WHERE p.ID=%d",$id);
        $res = $this->db->get_row($sql);
        if($res)
            return $this->mapping($res);
        return null;
    }

    function getMarkedBannerInZone($zone_id)
    {

        $sql = $this->db->prepare("SELECT p.*,tr.term_taxonomy_id as zone_id FROM wp_posts p
INNER JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'banner_view_markers'
INNER JOIN wp_term_relationships tr ON p.ID = tr.object_id
WHERE pm.meta_value = 1 AND tr.term_taxonomy_id=%d",$zone_id);

        $res = $this->db->get_row($sql);

       if($res)
           return $this->mapping($res);
        return null;
    }

    function getMarkedBannerInZoneAndLocation($zone_id, $args = array())
    {
        $banners = array();
        if(!$zone_id) return $banners;

        $inner_join="   LEFT JOIN wp_postmeta pm3 ON p.ID = pm3.post_id AND pm3.meta_key='banner_start_date'
                        LEFT JOIN wp_postmeta pm4 ON p.ID = pm4.post_id AND pm4.meta_key='banner_end_date'
                        INNER JOIN wp_postmeta pm5 ON p.ID = pm5.post_id AND pm5.meta_key = 'banner_status'";

        $where="tr.term_taxonomy_id=".$zone_id." AND pm5.meta_value=1 AND ((pm3.meta_value <= CURDATE() AND pm4.meta_value >=CURDATE()) OR (pm3.meta_value Is NULL OR pm4.meta_value Is NULL))";
            switch($args['location'])
            {
                case 'single':
                    $inner_join .= " INNER JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'banner_position'";
                    $where .=" AND (pm.meta_value='single' OR pm.meta_value='all')";
                    break;
                case 'home':
                    $inner_join .= " INNER JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'banner_position'";
                    $where .=" AND (pm.meta_value='home' OR pm.meta_value='all')";
                    break;
                case 'page':
                    $inner_join .= "
                    INNER JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'banner_position'
                    LEFT JOIN wp_postmeta pm1 ON p.ID = pm1.post_id AND pm1.meta_key = 'banner_page'
                    ";
                    $where .=" AND ((pm.meta_value='page' AND pm1.meta_value=".$args['obj_id'].") OR pm.meta_value='all')";
                    break;
                case 'category':
                    $inner_join .= "
                    INNER JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'banner_position'
                    LEFT JOIN wp_postmeta pm1 ON p.ID = pm1.post_id AND pm1.meta_key = 'banner_category'
                    ";
                    $where .=" AND ((pm.meta_value='page' AND pm1.meta_value=".$args['obj_id'].") OR pm.meta_value='all')";
                    break;
            }

            if(isset($args['show_on']))
            {
                $inner_join .= " LEFT JOIN wp_postmeta pm2 ON p.ID = pm2.post_id AND pm2.meta_key='banner_show_on'";
                $where .= " AND pm2.meta_value LIKE '%".$args['show_on']."%'";
            }


        $sql = "SELECT p.*,tr.term_taxonomy_id as zone_id FROM wp_posts p ".$inner_join."

        INNER JOIN wp_term_relationships tr ON p.ID = tr.object_id WHERE ".$where." ORDER BY pm.meta_key DESC, p.post_date DESC";

        $res = $this->db->get_results($sql);



            foreach ($res as $r) {
                $banners[] = $this->mapping($r);
            }


        return $banners;
    }

    function setViewsById($banner_id,$reset=false)
    {
        if($reset)
        {
            update_post_meta($banner_id, 'banner_views', 0);
        }
        else
        {
            $views = get_post_meta($banner_id, 'banner_views', true);
            $views += 1;
            update_post_meta($banner_id, 'banner_views', $views);
        }
    }

    function moveMarker($current_banner_id)
    {
        $current_banner = $this->getById($current_banner_id);

        if($banner = $this->getNextBanner($current_banner->getZoneId(),$current_banner->getCreatedAt()->format('Y-m-d')))
        {
            update_post_meta($banner->getId(),'banner_view_marker',1);
        }
    }

    function setStatus($id, $state)
    {
        update_post_meta($id,'banner_status',$state);
    }


    function getNextBanner($zone_id,$create_date)
    {
        $sql = $this->db->prepare("SELECT p.*,tr.term_taxonomy_id as zone_id FROM wp_post p
 INNER JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'banner_view_markers'
  INNER JOIN wp_term_relationships tr ON p.ID = tr.object_id WHERE tr.term_taxonomy_id=%d AND pm.meta_value=0 p.post_date>%s ORDER BY p.post_date DESC LIMIT 1",$zone_id,$create_date);
        $res = $this->db->get_row($sql);
        if($res) {
            $sql = $this->db->prepare("SELECT p.*,tr.term_taxonomy_id as zone_id FROM wp_post p
 INNER JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'banner_view_markers'
  INNER JOIN wp_term_relationships tr ON p.ID = tr.object_id WHERE tr.term_taxonomy_id=%d AND pm.meta_value=0 ORDER BY p.post_date DESC LIMIT 1",$zone_id,$create_date);
            $res = $this->db->get_row($sql);
            if($res)
            {
                return $this->mapping($res);
            }
        }

        return null;
    }

    function getZoneIdByBannerId($banner_id)
    {
        $sql = $this->db->prepare("SELECT tr.term_taxonomy_id as zone_id FROM wp_post p
  INNER JOIN wp_term_relationships tr ON p.ID = tr.object_id WHERE p.ID=%d ORDER BY p.post_date DESC LIMIT 1",$banner_id);
        $res = $this->db->get_row($sql);
        if($res)
            return $res->zone_id;
        return null;
    }

    function cleanBanners()
    {
        $this->db->query("UPDATE wp_posts  as p
INNER JOIN wp_postmeta pm4 ON p.ID = pm4.post_id AND pm4.meta_key='banner_end_date'
INNER JOIN wp_postmeta pm5 ON p.ID = pm5.post_id AND pm5.meta_key = 'banner_status'
SET pm5.meta_value = 0
WHERE p.post_type='td-advertiser' AND pm5.meta_value=1
AND pm4.meta_value < CURDATE() AND pm4.meta_value Is NOT NULL");
    }


    /**
     * @param WP_Post $res
     * @return Banner
     */
    protected function mapping($res)
    {
        $banners = new Banner();
        $banners->setPostStatus($res->post_status);
        $banners->setId($res->ID);
        $banners->setBannerTitle($res->post_title);
        $banners->setCreatedAt(new DateTime($res->post_date));
        $banners->setUpdatedAt(new DateTime($res->post_modified));
        $banners->setBannerAdsType(get_post_meta($res->ID,'banner_ads_type',true));
        $banners->setBusinessName(get_post_meta($res->ID,'business_name',true));
        $banners->setBusinessEmail(get_post_meta($res->ID,'business_email',true));
        $banners->setPhone(get_post_meta($res->ID,'phone',true));
        $banners->setBannerCode(get_post_meta($res->ID,'banner_'.$banners->getBannerAdsType(),true));
        $banners->setBannerShowOn(get_post_meta($res->ID,'banner_show_on',true));
        $banners->setBannerPosition(get_post_meta($res->ID,'banner_position',true));
        $banners->setBannerLocationId(get_field('banner_'.$banners->getBannerPosition(),$res->ID));
        $banners->setBannerDatesLimits(get_field('banner_dates_limits',$res->ID));
        $banners->setBannerStartDate(get_field('banner_start_date',$res->ID)?new DateTime(get_field('banner_start_date',$res->ID)):null);
        $banners->setBannerEndDate(get_field('banner_end_date',$res->ID)?new DateTime(get_field('banner_end_date',$res->ID)):null);
        $banners->setBannerStatus(get_field('banner_status',$res->ID));
        $banners->setPricePerView(get_field('banner_price_per_view',$res->ID));
        $banners->setViews(get_field('banner_views',$res->ID));
        $banners->setUrlAds(get_field('ads_link',$res->ID));
        $banners->setZoneId($res->zone_id);
        return $banners;
    }
}