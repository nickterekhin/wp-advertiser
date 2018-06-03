<?php


namespace TD_Advertiser\src\object;


use DateTime;

class Banner extends AdsObject
{
    /**
     * @var int
     */
    private $Id;
    /**
     * @var string
     */
    private $business_name;

    /**
     * @var string
     */
    private $banner_title;

    /**
     * @var string
     */
    private $business_email;
    /**
     * @var string
     */
    private $phone;
    /**
     * @var string
     */
    private $banner_ads_type;
    /**
     * @var string
     */
    private $banner_code = null;
    /**
     * @var array
     */
    private $banner_show_on=array();
    /**
     * @var string
     */
    private $banner_position='all';
    /**
     * @var int|null
     */
    private $banner_location_id=null;
    /**
     * @var bool
     */
    private $banner_dates_limits= false;
    /**
     * @var null|DateTime
     */
    private $banner_start_date=null;
    /**
     * @var null|DateTime
     */
    private $banner_end_date=null;
    /**
     * @var bool
     */
    private $banner_status = true;

    /**
     * @var DateTime
     */
    private $created_at;

    /**
     * @var DateTime
     */
    private $updated_at;
    /**
     * @var double
     */
    private $price_per_view=0.0;

    /**
     * @var int
     */
    private $views = 0;

    private $zone_id;

    private $post_status;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param int $Id
     */
    public function setId($Id)
    {
        $this->Id = $Id;
    }

    /**
     * @return string
     */
    public function getBusinessName()
    {
        return $this->business_name;
    }

    /**
     * @param string $business_name
     */
    public function setBusinessName($business_name)
    {
        $this->business_name = $business_name;
    }

    /**
     * @return string
     */
    public function getBusinessEmail()
    {
        return $this->business_email;
    }

    /**
     * @param string $business_email
     */
    public function setBusinessEmail($business_email)
    {
        $this->business_email = $business_email;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getBannerAdsType()
    {
        return $this->banner_ads_type;
    }

    /**
     * @param string $banner_ads_type
     */
    public function setBannerAdsType($banner_ads_type)
    {
        $this->banner_ads_type = $banner_ads_type;
    }

    /**
     * @return string
     */
    public function getBannerCode()
    {
        return $this->banner_code;
    }

    /**
     * @param string $banner_code
     */
    public function setBannerCode($banner_code)
    {
        $this->banner_code = $banner_code;
    }

    /**
     * @return array
     */
    public function getBannerShowOn()
    {
        return $this->banner_show_on;
    }

    /**
     * @param array $banner_show_on
     */
    public function setBannerShowOn($banner_show_on)
    {
        $this->banner_show_on = $banner_show_on;
    }

    /**
     * @return string
     */
    public function getBannerPosition()
    {
        return $this->banner_position;
    }

    /**
     * @param string $banner_position
     */
    public function setBannerPosition($banner_position)
    {
        $this->banner_position = $banner_position;
    }

    /**
     * @return int|null
     */
    public function getBannerLocationId()
    {
        return $this->banner_location_id;
    }

    /**
     * @param int|null $banner_location_id
     */
    public function setBannerLocationId($banner_location_id)
    {
        $this->banner_location_id = $banner_location_id;
    }

    /**
     * @return boolean
     */
    public function isBannerDatesLimits()
    {
        return $this->banner_dates_limits;
    }

    /**
     * @param boolean $banner_dates_limits
     */
    public function setBannerDatesLimits($banner_dates_limits)
    {
        $this->banner_dates_limits = $banner_dates_limits;
    }

    /**
     * @return DateTime|null
     */
    public function getBannerStartDate()
    {
        return $this->banner_start_date;
    }

    /**
     * @param DateTime|null $banner_start_date
     */
    public function setBannerStartDate($banner_start_date)
    {
        $this->banner_start_date = $banner_start_date;
    }

    /**
     * @return DateTime|null
     */
    public function getBannerEndDate()
    {
        return $this->banner_end_date;
    }

    /**
     * @param DateTime|null $banner_end_date
     */
    public function setBannerEndDate($banner_end_date)
    {
        $this->banner_end_date = $banner_end_date;
    }

    /**
     * @return boolean
     */
    public function isBannerStatus()
    {
        return $this->banner_status;
    }

    /**
     * @param boolean $banner_status
     */
    public function setBannerStatus($banner_status)
    {
        $this->banner_status = $banner_status;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param DateTime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return double
     */
    public function getPricePerView()
    {
        return $this->price_per_view;
    }

    /**
     * @param double $price_per_view
     */
    public function setPricePerView($price_per_view)
    {
        $this->price_per_view = $price_per_view?$price_per_view+0:0;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param DateTime $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return string
     */
    public function getBannerTitle()
    {
        return $this->banner_title;
    }

    /**
     * @param string $banner_title
     */
    public function setBannerTitle($banner_title)
    {
        $this->banner_title = $banner_title;
    }

    /**
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param int $views
     */
    public function setViews($views)
    {
        $this->views = $views?$views+0:0;
    }

    /**
     * @return mixed
     */
    public function getZoneId()
    {
        return $this->zone_id;
    }

    /**
     * @param mixed $zone_id
     */
    public function setZoneId($zone_id)
    {
        $this->zone_id = $zone_id;
    }

    /**
     * @return mixed
     */
    public function getPostStatus()
    {
        return $this->post_status;
    }

    /**
     * @param mixed $post_status
     */
    public function setPostStatus($post_status)
    {
        $this->post_status = $post_status;
    }





    public function toArray() {
        return $this->processArray(get_object_vars($this));
    }

    private function processArray($array) {

        foreach($array as $key => $value) {

            if (is_object($value)) {

                $array[$key] = $value->toArray();
            }
            if (is_array($value)) {
                $array[$key] = $this->processArray($value);
            }
        }
        return $array;
    }





}