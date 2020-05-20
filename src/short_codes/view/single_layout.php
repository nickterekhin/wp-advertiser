<?php
?>
<?php /** @var Banner $banner */
use TD_Advertiser\src\object\Banner;

if($banners){ ?>


    <div id="zone_<?php echo $ads_zone?>" class="td-ads-zone-container <?php echo $custom_css_class;?>">
        <ul id="slides" class="slides">
            <?php foreach($banners as $banner){ ?>
            <li id="<?php echo $banner->getId(); ?>">
                <?php
                if($banner->getBannerAdsType()==='image') {
                    echo '<a href="'.$banner->getUrlAds().'" style="outline:none"><img src="'.wp_get_attachment_url($banner->getBannerCode()).'" style="width:100%;height:auto"></a>';
                }else {
                    echo $banner->getBannerCode();
                }
                ?>

            </li>
            <?php } ?>
        </ul>
    </div>
    <script type="text/javascript">
        (function($){


            $(document).ready(function(){
                var $zone = $("#zone_<?php echo $ads_zone;?>"),
                    //width = $zone.parent().outerWidth(),
                    opt = {
                        //width:$zone.parent().outerWidth()+'px',
                        //height:(width/1.2)+'px',
                        duration:4
                    };

                $zone.bannerRotator(opt);
            });
        })(jQuery);
    </script>

<?php } ?>
