<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2018/11/17 0017
     * Time: 上午 10:12
     */
    
    namespace app\common;
    
    use think\Config;
    use think\Controller;
    use think\Db;
    use think\Request;

    class Common extends  Controller
    {
        public function _initialize()
        {

            $search_url = 'login';
            if ( strrpos($_SERVER['PATH_INFO'],  $search_url  ) === false  ) {
                
                if (!islogin()):
                    
                    $this->error('请登录', url('admin/admin/login'));
                
                    exit;
                Endif;
        
            }
            
            //前台菜单
            //$menu = get_cache('menu_cache');
         //   if (empty($menu)) {
                $menu = Db::name('menu')->where( ['status' => 1, 'is_del' => 1 ])->select();
              //  set_cache('menu_cache', $menu);
           // }
    
            //关键词
           // $keywords = get_cache('keywords_cache');
           // if (empty( $keywords )) {
                $keywords = Db::name('keywords')->where(['status' => 1, 'recommend' =>1,  'is_del' =>1 ])->select();
          //  }
    
            //banner
           // $banner = get_cache('banner_cache');
            //if (empty($banner)) {
                $banner = Db::name('banner')->where(['status' => 1, 'is_del' => 1])->select();
               // set_cache('banner_cache', $banner);
          //  }
    
            $this->assign('banner', $banner);
            $this->assign('menu', $menu);
            $this->assign('keywords', $keywords);
            
            

            
            $url  = ( $_SERVER['PHP_SELF'] );
    
            $result = strpos( $url, '/index.php/admin/admin/banner.html' );
           
            $this->assign('url',  $url );
    
            //后台menu
            $nav = Config::get('nav_admin');
            
            $this->assign( 'leftNav', $nav );
            
            return view('common/left');
        
        }
        
    
    }