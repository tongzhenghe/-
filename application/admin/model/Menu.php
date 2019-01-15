<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2018/11/22 0022
     * Time: 下午 12:55
     */
    
    namespace app\admin\model;
    
    
    use think\Model;

    class Menu extends  Model
    {
        protected $insert = ['is_del', 'status' => 1];
        
    }