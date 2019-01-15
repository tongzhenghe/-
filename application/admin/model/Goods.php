<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2018/11/28 0028
     * Time: 下午 3:09
     */
    
    namespace app\admin\model;
    
    
    use think\Model;

    class Goods extends  Model
    {
        protected $insert = ['is_del', 'status' => 1];
        
    }