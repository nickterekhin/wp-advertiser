<?php


namespace TD_Advertiser\src\repository;


use TD_Advertiser\src\object\AdsObject;

interface IRepository
{
    function create(AdsObject $object);
    function update(AdsObject $object);
    function delete($id);
    function getAll($args=array());
    function getById($id);
}