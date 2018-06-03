<?php
?>
<?php /** @var Banner $banner */
use TD_Advertiser\src\object\Banner;

if($banners){ ?>
    <?php
    $zone_width =get_term_meta($ads_zone,'width',true);
    $zone_height = get_term_meta($ads_zone,'height',true);
    $style = ($zone_width && $zone_height)?'style="width:'.$zone_width.';height:'.$zone_height.';margin:0 auto; overflow:hidden"':'';
    ?>
    <script type="text/javascript">
        (function($){
            $(document).ready(function(){
                $("#zone_<?php echo $ads_zone;?>").bannerRotator({width:'<?php echo $zone_width;?>',height:'<?php echo $zone_height;?>',duration:4});
            });
        })(jQuery);

    </script>

    <div id="zone_<?php echo $ads_zone?>" class="td-ads-zone-container">
        <ul id="slides" class="slides">
            <?php foreach($banners as $banner){ ?>
            <li id="<?php echo $banner->getId(); ?>">
                <?php
                if($banner->getBannerAdsType()==='image') {
                    echo '<img src="'.wp_get_attachment_url($banner->getBannerCode()).'" style="width:100%;height:auto">';
                }else {

                    echo $banner->getBannerCode();
                }
                ?>
            </li>
            <?php } ?>
        </ul>
    </div>

<?php } ?>
