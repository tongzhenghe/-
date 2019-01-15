<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/1/11 0011
     * Time: 上午 10:51
     */
    
    namespace app\index\controller;
    
    
    use think\Controller;
    use think\Db;

    class Common  extends  Controller
    {
        public  function  _initialize()
        {
            
            //设置
            $setting = Db::name('us')->find();
            
            if (!empty($setting) ) {
                $setting['keywords'] = unserialize($setting['keywords'] );
                $setting['description'] = unserialize($setting['description'] );
                $setting['footer_msg'] = unserialize($setting['footer_msg'] );
                $setting['address'] = unserialize($setting['address'] );
                $setting['update_time'] = date('Y m d H:i:s', $setting['update_time'] );
                $setting['comintro'] = html_entity_decode($setting['comintro']);
                $setting['native'] = html_entity_decode($setting['native']);
                $this->assign('setting', $setting);

            }
    
            //前台菜单
            //$menu = get_cache('menu_cache');
            //   if (empty($menu)) {
            $menu = Db::name('menu')->where( ['status' => 1, 'is_del' => 1 ])->order('sort asc')->select();

            //  set_cache('menu_cache', $menu);
            // }
    
            //关键词
            // $keywords = get_cache('keywords_cache');
            // if (empty( $keywords )) {
            $keywords = Db::name('keywords')->where(['status' => 1, 'recommend' =>1,  'is_del' =>1 ])->order('sort desc')->select();
           
            //  }
    
            //banner
            // $banner = get_cache('banner_cache');
            //if (empty($banner)) {
            $banner = Db::name('banner')->where(['status' => 1, 'is_del' => 1])->order('sort asc')->select();
            
            // set_cache('banner_cache', $banner);
            //  }
    
            $this->assign('banner', $banner);
            $this->assign('menu', $menu);
            $this->assign('keywords', $keywords);
    
    
    
    
        }
    
    }