<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2018/11/18 0018
     * Time: 下午 12:13
     */
    
    namespace app\admin\model;
    
    
    use think\Model;

    class Nav extends  Model
    {
        
        
        protected $insert = ['isdel', 'status' => 1];
    
    }