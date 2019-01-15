<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/1/11 0011
     * Time: 下午 12:50
     */
    
    namespace app\admin\model;
    
    
    use think\Model;

    class Brand extends  Model
    {
        protected $insert = ['is_del', 'status' => 1];
    }