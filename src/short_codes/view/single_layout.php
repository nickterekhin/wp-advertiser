<?php
?>
<?php /** @var Banner $banner */
use TD_Advertiser\src\object\Banner;

if($banner){ ?>

    <?php

    $zone_width =get_term_meta($ads_zone,'width',true);
    $zone_height = get_term_meta($ads_zone,'height',true);
        $style = ($zone_width && $zone_height)?'style="width:'.$zone_width.';height:'.$zone_height.';margin:0 auto;"':'';

    ?>
    <div class="td-ads-zone-container" <?php echo $style; ?>>
        <div class="td-ads-zone-wrapper">
            <?php echo $banner->getBannerCode();?>
            </div>
    </div>

<?php } ?>
