<?php
?>
<?php if($zone_obj){ ?>

    <?php

    $zone_width =get_term_meta($zone_obj->term_id,'width',true);
    $zone_height = get_term_meta($zone_obj->term_id,'height',true);
        $style = ($zone_width && $zone_height)?'style="width:'.$zone_width.';height:'.$zone_height.';margin:0 auto;"':'';
    ?>
    <div class="td-ads-zone-container" <?php echo $style; ?>>
        <div class="td-ads-zone-wrapper">
    <?php if($banner_obj_ID){ ?>
                    <?php echo get_post_meta($banner_obj_ID,'ads_code',true);?>

    <?php } else {?>
                <?php echo get_term_meta($zone_obj->term_id,'default_ads_image',true);?>
            <?php } ?>
            </div>
    </div>

<?php } ?>
