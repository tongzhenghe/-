<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/1/9 0009
     * Time: 下午 12:05
     */
    
    namespace app\admin\model;
    
    
    use think\Model;

    class News extends  Model
    {
    
        protected $insert = ['is_del','status' => 1];
    
    
    }