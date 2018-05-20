<?php


namespace TD_Advertiser\src\tables;

if(!class_exists('WP_List_Table')){
    require_once(ABSPATH.'wp-admin/includes/class-wp-list-table.php');
}

if(!class_exists('WP_Posts_List_Table')){
    require_once(ABSPATH.'wp-admin/includes/class-wp-posts-list-table.php');
}
use TD_Advertiser\src\repository\DBContext;
use WP_List_Table;

abstract class TD_Advertiser_List_Table extends WP_List_Table
{
    /**
     * @var DBContext
     */
    protected $db_ctx;

    protected function getScreenName($page=null)
    {
        global $_menu_hooks;
        if(!$page)return 'banners-list';
        return isset($_menu_hooks[$page])?$_menu_hooks[$page]:'banners-list';
    }

    public function add_new_button()
    {
        echo '<a href="admin.php?page='.$_REQUEST['page'].'&a=add" class="add-new-h2">Add New</a>';
    }

    protected function custom_table_css_classes()
    {
        return '';
    }
    public function display()
    {
        $singular = $this->_args['singular'];

        //$this->display_tablenav( 'top' );

        $this->screen->render_screen_reader_content( 'heading_list' );
        ?>
        <table class="wp-list-table <?php echo implode( ' ', $this->get_table_classes() ); ?> <?php echo $this->custom_table_css_classes();?>" id="sorted_table">
            <thead>
            <tr>
                <?php $this->print_column_headers(); ?>
            </tr>
            </thead>

            <tbody id="the-list"<?php
            if ( $singular ) {
                echo " data-wp-lists='list:$singular'";
            } ?>>
            <?php $this->display_rows_or_placeholder(); ?>
            </tbody>
            <?php echo $this->display_footer();?>

        </table>
        <?php
        $this->display_tablenav( 'bottom' );
        ?>
        <div class="wp-list-table-filters-container hidden" id="wp-list-table-filters">
            <?php echo $this->display_table_filters(); ?>
        </div>
        <?php

    }
    public function display_rows_or_placeholder() {
        if ( $this->has_items() ) {
            $this->display_rows();
        }
    }

    private function display_table_filters()
    {
        if($this->has_filters()) {

            $html = '<div class="wp-list-table-filters">';

            $filters =  $this->filters_list();
            if($filters && is_array($filters))
            {
                $html.='<ul class="filters-items-list">';
                $html.='<li><span>Filters:</span></li>';
                foreach($filters as $f)
                {
                    $html.='<li>'.$f.'</li>';
                }
                $html.='</ul>';
            }

            $html.='</div>';
            return $html;
        }
        return '';
    }
    protected function has_filters(){
        return false;
    }
    protected function filters_list()
    {
        return array();
    }

    public function js_filters()
    {
        if($this->has_filters())
        {
            ?>
            <script type="text/javascript">
                (function($){
                    $(document).ready(function(){
                        gObj.add_filters([{id:'user-status',column:2},{id:'subscription-status',column:3},{id:'billing-plans',column:5}]);
                        /*gObj.initTotal();*/
                    });
                })(jQuery);
            </script>
            <?php
        }
    }

    protected function display_footer()
    {
        return '<tfoot></tfoot>';
    }

}