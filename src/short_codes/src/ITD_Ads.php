<?php


namespace TD_Advertiser\src\short_codes\src;


interface ITD_Ads
{
        function load();
        function render($attr,$content);
        function mapping();
        function set_icon();
        function base_params();
        function is_container();
}