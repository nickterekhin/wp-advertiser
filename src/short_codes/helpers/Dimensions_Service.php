<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 03.06.2018
 * Time: 16:27
 */

namespace TD_Advertiser\src\short_codes\helpers;


class Dimensions_Service
{
    private static $instance;
    private $dimensions = array(
        'a'=>array(
            'tablets'=>array(
                'width'=>null,
                'height'=>null
            ),
            'mobile'=>array(
                'width'=>null,
                'height'=>null
            )
        ),
        'w'=>array(
            'tablets'=>array(
                'width'=>null,
                'height'=>null
            ),
            'mobile'=>array(
                'width'=>null,
                'height'=>null
            )
        )

    );

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function getSize($zone_id,$device='desktop')
    {
        $res = get_term($zone_id,'td_ads_zone');
        if(preg_match('/(a|w)$/',$res->slug,$m)==1)
        {
            if(isset($this->dimensions[$m[1]][$device]))
            {
                return $this->dimensions[$m[1]][$device];
            }
        }
        return null;
    }
}