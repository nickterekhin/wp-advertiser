<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 29.10.17
 * Time: 02:15
 */


use TD_Advertiser\src\tables\TD_Advertiser_Banners_List_Table;

/** @var TD_advertiser_Banners_List_Table $table_obj */
$table_obj->prepare_items();
?>
<?php
$table_obj->js_filters();
?>
<div class="wrap">
    <h1 class="wp-heading-inline">Banners List</h1>
    <?php $table_obj->add_new_button()?>
    <p></p>
    <?php $table_obj->display();?>
</div>