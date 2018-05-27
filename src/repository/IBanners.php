<?php


namespace TD_Advertiser\src\repository;


interface IBanners extends IRepository
{
    function getMarkedBannerInZone($zone_id);
    function getMarkedBannerInZoneAndLocation($zone_id,$location=array('all'));
    function getNextBanner($zone_id,$create_at);
    function setViewsById($banner_id);
    function moveMarker($current_banner_id);
    function getZoneIdByBannerId($banner_id);
}