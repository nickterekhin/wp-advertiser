<?php


namespace TD_Advertiser\src\managers;


use TD_Advertiser\src\tables\TD_Advertiser_Banners_List_Table;

class TD_Advertiser_Banners_List_Manager extends TD_Advertiser_Base_Manager
{
    protected function __construct()
    {
        parent::__construct(); // TODO: Change the autogenerated stub
        $this->settings->setView('banners_list');
    }
    protected function show()
    {
        $this->settings->setParamsBy('table_obj', new TD_Advertiser_Banners_List_Table(array('post_type'=>$this->settings->getPostTypeName(),'dbc'=>$this->db_ctx)));
    }

    protected function delete($id)
    {
        $this->db_ctx->getBanners()->delete($id);
        $this->showMessage('success','Banner Has been deleted successfully');
    }

    protected function state($id, $state)
    {
        switch($state)
        {
            case 'open':
                $this->db_ctx->getBanners()->setStatus($id,1);
                break;
            case 'close':
                $this->db_ctx->getBanners()->setStatus($id,0);
                break;
        }
        $this->showMessage('success','Banner state has been changed');
    }

    protected function reset_views($id)
    {
        $this->db_ctx->getBanners()->setViewsById($id,true);
        $this->showMessage('success','Banner views has been reset');
    }

    public function init_manager_routes()
    {
        $this->init_routes();
        switch($_REQUEST['a']) {
            case 'reset':
                $this->reset_views($_REQUEST['id']);
                break;
        }
    }


}