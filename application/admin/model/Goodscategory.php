<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2018/11/27 0027
     * Time: 下午 4:04
     */
    
    namespace app\admin\model;
    
    
    use think\Model;

    class Goodscategory extends  Model
    {
        protected $insert = ['valid', 'status' => 1];
        
    }