(function($){
    'use strict';
    $.fn.shuffle = function() {
        return this.each(function(){
            var items = $(this).children().clone(true);
            return (items.length) ? $(this).html($.shuffle(items)) : this;
        });
    };

    $.shuffle = function(arr) {
        for(var j, x, i = arr.length; i; j = parseInt(Math.random() * i), x = arr[--i], arr[i] = arr[j], arr[j] = x);
        return arr;
    };

    $.extend($.fn,{
        bannerRotator:function(options){
            var rotator = $.data(this[0],"rotator");
            if(rotator)
            {
                return rotator;
            }
            rotator = new banner(options,this[0]);

            return rotator;
        }
    });

    var banner = function(options,rotator)
    {
        var _self = this;
        _self.settings = $.extend( true, {}, banner.defaults, options );
        _self.currentRotator = rotator;
        _self.init();

    };
    $.extend(banner,{
        defaults:{
            slides_container:'#slides',
            width:330,
            height:280,
            duration:2,
            onShow:null
        },

        prototype:{
            init:function(){

                var _self = this;
                _self.current_slide = 0;

                _self.slides_container = $(_self.currentRotator);
                _self.slides = this.slides_container.find('li');
                if(_self.slides.length>=1) {
                    $.shuffle(_self.slides);


                    //_self.slides_container.get(0).style.width = _self.settings.width;
                    //_self.slides_container.get(0).style.height = _self.settings.height;


                    _self.showHideBanner(0, true);
                    if(_self.slides.length>1)
                        setInterval(this.run.bind(this, _self), _self.settings.duration*1000);
                }


            },
            run:function(o){

                var _self = o;
                _self.showHideBanner(_self.current_slide);
                ++_self.current_slide;

                if(_self.current_slide===_self.slides.length)
                    _self.current_slide = 0;

                _self.showHideBanner(_self.current_slide,true);
            },

            showHideBanner:function(n,is_show){

                var _self = this;
                is_show = is_show || false;
                var b = $(_self.slides[n]);

                if(is_show)
                {
                    b.fadeIn(500);
                    if(_self.settings.onShow)
                        _self.settings.onShow.call(_self,b);
                }else
                {
                    b.fadeOut(500);
                }
            }

        }

    });
})(jQuery);