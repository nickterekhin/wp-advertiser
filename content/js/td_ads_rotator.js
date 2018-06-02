(function($,obj){
    'use strict';

    obj.defaults = {
        opts:{
            container:'#td-banner-viewer',
            banner_item:'.td-banner'
        }
    };

     obj.$banners = null;
        obj.$container = null;
        obj.active_banner=0;

    obj.init = function()
    {
        var opt = $.extend({},obj.defaults.opts);
        console.log(opt);
        obj.$container = $(opt.container);
        obj.$banners = obj.$container.find(opt.banner_item);
        if(obj.$banners.length>=1) {
            $('#'+obj.$banners.get(0).id).show();

            if(obj.$banners.length>1)
                setTimeout(obj.run, 5000);
        }
        else
        {
            obj.$container.hide();
        }
        //this.run();
    };

    obj.run = function()
    {
        console.log('run');
        setInterval(obj.rotateBanners,5000);
    };

    obj.rotateBanners = function()
    {

        obj.showHideBanner(obj.active_banner);
        ++obj.active_banner;
        if(obj.active_banner===obj.$banners.length)
            obj.active_banner=0;
        obj.showHideBanner(obj.active_banner,true);
    };
    obj.showHideBanner = function(n,is_show)
    {
          is_show = is_show||false;

        var banner = $('#'+obj.$banners.get(obj.active_banner).id);
        if(is_show) {
            banner.fadeIn(500);
        }else
        {
            banner.fadeOut(500);
        }

    };


})(jQuery,window.ads_rotator=window.ads_rotator||{});