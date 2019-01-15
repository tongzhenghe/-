<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2018/11/17 0017
     * Time: 上午 10:24
     */
    
    namespace app\admin\controller;
    
    use app\admin\model\Admin as AdminModel;
    use app\common\Common;
    use think\Cache;
    use think\Cookie;
    use think\Db;
    use think\Request;
    use think\Session;
    use think\Url;
    use traits\think\Instance;

    /**
     * Class Admin
     * @package app\admin\controller
     */
    class Admin extends  Common
    {
        /**
         * 数据统计
         * @author  tzhe      11630
         * @return \think\response\View
         */
        public function index()
        {
            
            return view();
        
        }
        
            //留言
        public  function  consult()
        {
            $consult = Db::name('message')->select();

            $this->assign('consult', $consult );
            
            // 只用户的咨询列表
            return view();
        
        }
    
    
        /**
         * @return \think\response\View
         * @throws \think\Exception
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @throws \think\exception\PDOException
         */
       /* public function nav()
        {
            //添加下拉statistics
            $param = \request()->get();
            
            if ($param) {
                //编辑
                if ($param ['point']== 'update') {
                    if (empty($param['id'])) {
                        exit(false);
                    }
        
                    $id = intval($param['id']);
    
                    $parentNav =   Db::name('nav')->where([ 'status' => 1,  'isdel' => 1] )->select();
                    
                    $parentNav = tree( $parentNav, 0 );
                
                    $find = Db::name('nav')->where('id',$id)->find();
                    
                    $this->assign( 'find', $find );
                    
                }
    
                if ( $param['point']  == 'addNav'  && !Request::instance()->isAjax()) {
    
                    $parentNav =   Db::name('nav')->where(['pid' =>0,  'status' => 1,  'isdel' => 1] )->select();
    
                }
    
                $this->assign( 'parentNav', $parentNav );
                return view('addnav');
                
            }
            
            if (Request::instance()->isAjax()) {
                
                $data =  \request()->post();
                //update
                if (!empty($data['id'])) {
                    $id = intval($data['id']);
                    $setData = [
                        'English'=> trim( $data['English']),
                        'name'=>trim( $data['name']),
                        'pid'=> intval($data['pid']),
                        'sort'=> intval($data['sort']),
                        'url'=> trim($data['url']),
                        'update_time' => time()
                    ];
                    
                    $result = Db::name('nav')->where('id',  $id )->update( $setData );
                    
                    if (!empty($result)) {
                        echo  return_json(\url('admin/admin/nav'));
                        exit;
                    } else {
                        exit(false);
                    }
            }
            
                //add
                $data['create_time'] = time();
                $result =  Db::name('nav')->insert($data);
                if ($result) {
                    exit( return_json());
                }
    
            }
    
    
            $nav =  Db::name('nav')->where([ 'isdel' => 1] )->select();

            $nav = tree( $nav, 0 );
           
            $this->assign( 'nav', $nav );
            return view();
            
        }*/
    
        /**
         * @return bool
         * @throws \think\Exception
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @throws \think\exception\PDOException
         */
        public function  setQuery()
        {
    
            if (Request::instance()->isAjax()) {
                
                $data =  \request()->post();
                //改变状态
            if ( $data['point'] == 'changStatus' ) {
        
                    if (empty( $data['id'])) {
                        exit(false);
                    }
                    $id = $data['id'];
                    $status = $data['status'];
            
                    $count = count(Db::name('nav')->where(['pid' =>$id, 'status' => 1, 'is_del' => 1 ])->field('pid')->select());
            
                    if (!empty($count)) {
                        exit( return_json('', '400', 0, '操作失败, 还有下级！'));
                    }
            
                    $result =    Db::name('nav')->where('id', $id)->setField('status', $status );
            
                    if (!empty($result)) {
                
                        exit(return_json('/index.php/admin/admin/nav'));
                
                    }
                exit(return_json('', '400', '0', '操作失败'));
            
                }
                
                
                  //改变状态
            if ( $data['point'] == 'change_status_menu' ) {

                    if (empty( $data['id'])) {
                        exit(false);
                    }
                    
                    $id =intval( $data['id'] );
                    $status = $data['status'];
            
                    $result =    Db::name('menu')->where('id', $id)->setField('status', $status );
            
                    if (!empty($result)) {
                    delete_cache('menu_cache');
                        exit(return_json('menu'));
                
                    }
                exit(return_json('', '400', '0', '操作失败'));
            
                }
                
                
                  //改变状态
            if ( $data['point'] == 'change_status_title' ) {

                    if (empty( $data['id'])) {
                        exit(false);
                    }
                    
                    $id =intval( $data['id'] );
                    $status = $data['status'];
            
                    $result =    Db::name('title')->where('id', $id)->setField('status', $status );
            
                    if (!empty($result)) {
                    delete_cache('title_cache');
                        exit(return_json('title'));
                
                    }
                exit(return_json('', '400', '0', '操作失败'));
            
                }
                
                
                  //改变状态
            if ( $data['point'] == 'change_status_keywords' ) {

                    if (empty( $data['id'])) {
                        exit(false);
                    }
                    
                    $id =intval( $data['id'] );
                    $status = $data['status'];
            
                    $result =    Db::name('keywords')->where('id', $id)->setField('status', $status );
            
                    if (!empty($result)) {
                    delete_cache('keywords_cache');
                        exit(return_json('keywords'));
                
                    }
                exit(return_json('', '400', '0', '操作失败'));
            
                }
                
                  
                  //改变状态
            if ( $data['point'] == 'change_status_goodscate' ) {

                    if (empty( $data['id'])) {
                        exit(false);
                    }
                    
                    $id =intval( $data['id'] );
                    $status = $data['status'];
            
                    $result =    Db::name('goodscategory')->where('id', $id)->setField('status', $status );
            
                    if (!empty($result)) {
                    delete_cache('goodscate_cache');
                        exit(return_json('goodscate'));
                
                    }
                exit(return_json('', '400', '0', '操作失败'));
            
                }
                  
                  
                  //改变状态
            if ( $data['point'] == 'change_status_goods' ) {

                    if (empty( $data['id'])) {
                        exit(false);
                    }
                    
                    $id =intval( $data['id'] );
                    
                    $status = $data['status'];
            
                    $result =    Db::name('goods')->where('id', $id)->setField('status', $status );
            
                    if (!empty($result)) {
                    delete_cache('goods_cache');
                        exit(return_json('goods'));
                
                    }
                exit(return_json('', '400', '0', '操作失败'));
            
                }
                
                
                
                //delete
                if ($data['point'] == 'deleteNav') {
    
                    if (empty($data['id'])) {
                        return false;
                    }
                    $id =  intval($data['id']);
    
                 $result =    Db::name('nav')->where('id', $id)->update(['is_del' =>intval($data['is_del'])]);
                    if ($result) {
                        exit(return_json(\url('admin/nav')));
                    } else {
                        exit(return_json('', '400', '0', '操作失败'));
                    }
                
                }
                
                
                
                //delete
                if ($data['point'] == 'delete_goodscate') {
    
                    if (empty($data['id'])) {
                        return false;
                    }
                    $id =  intval($data['id']);
    
                 $result =    Db::name('goodscategory')->where('id', $id)->update(['is_del' =>intval($data['is_del'])]);
                    if ($result) {
                        delete_cache('goodscate_cache');
                        exit(return_json(\url('goodscate')));
                    } else {
                        exit(return_json('', '400', '0', '操作失败'));
                    }
                
                }
                
                
                
                
                //delete
                if ($data['point'] == 'delete_goods') {
    
                    if (empty($data['id'])) {
                        return false;
                    }
                    $id =  intval($data['id']);
    
                 $result =    Db::name('goods')->where('id', $id)->update(['is_del' =>intval($data['is_del'])]);
                    if ($result) {
                        delete_cache('goods_cache');
                        exit(return_json(\url('goods')));
                    } else {
                        exit(return_json('', '400', '0', '操作失败'));
                    }
                
                }
                
                
                //delete
                if ($data['point'] == 'delete_title') {
    
                    if (empty($data['id'])) {
                        return false;
                    }
                    $id =  intval($data['id']);
    
                 $result =    Db::name('title')->where('id', $id)->update(['is_del' =>intval($data['is_del'])]);
                    if ($result) {
                        delete_cache('title_cache');
                        exit(return_json(\url('title')));
                    } else {
                        exit(return_json('', '400', '0', '操作失败'));
                    }
                
                }
                
                
                
                //delete
                if ($data['point'] == 'delete_keywords') {
    
                    if (empty($data['id'])) {
                        return false;
                    }
                    $id =  intval($data['id']);
    
                 $result =    Db::name('keywords')->where('id', $id)->update(['is_del' =>intval($data['is_del'])]);
                    if ($result) {
                        delete_cache('keywords_cache');
                        exit(return_json(\url('keywords')));
                    } else {
                        exit(return_json('', '400', '0', '操作失败'));
                    }
                
                }
                
                //deletebanner
                if ($data['point'] == 'deletebanner') {
    
                    if (empty($data['id'])) {
                        return false;
                    }
                    
                    $id =  intval($data['id']);
    
                 $result =    Db::name('banner')->where('id', $id)->update(['is_del' =>intval($data['is_del'])]);
    
                    if ($result) {
                        delete_cache('banner_cache');
                        exit(return_json(\url('admin/banner')));
                    } else {
                        exit(return_json('', '400', '0', '操作失败'));
                    }
                
                }
                
                if ( $data['point'] == 'delbanner' ) {
                    $id = $data['id'];
                    if (empty($id) ) {
                        return false;
                    }
                    $id = intval($id);
                    $result = Db::name('banner')->where('id', $id)->delete();
                    if ($result) {
                        delete_cache('banner_cache');
                        exit(return_json(\url('admin/admin/banner')));
                    }
                    return false;
                }
                
                   if ( $data['point'] == 'delnews' ) {
                    $id = $data['id'];
                    if (empty($id) ) {
                        return false;
                    }
                    $id = intval($id);
                    $result = Db::name('news')->where('id', $id)->delete();
                    if ($result) {
                        delete_cache('news_cache');
                        exit(return_json(\url('admin/admin/news')));
                    }
                    return false;
                }
                
                if ( $data['point'] == 'delbase' ) {
                    $id = $data['id'];
                    if (empty($id) ) {
                        return false;
                    }
                    $id = intval($id);
                    $result = Db::name('base')->where('id', $id)->delete();
                    if ($result) {
                        delete_cache('base_cache');
                        exit(return_json(\url('admin/admin/base')));
                    }
                    return false;
                }
                
                    if ( $data['point'] == 'delaptitude' ) {
                    $id = $data['id'];
                    if (empty($id) ) {
                        return false;
                    }
                    $id = intval($id);
                    $result = Db::name('aptitude')->where('id', $id)->delete();
                    if ($result) {
                        delete_cache('aptitude_cache');
                        exit(return_json(\url('admin/admin/aptitude')));
                    }
                    return false;
                }
                   if ( $data['point'] == 'delmenu' ) {
                    $id = $data['id'];
                    if (empty($id) ) {
                        return false;
                    }
                    $id = intval($id);
                    $result = Db::name('menu')->where('id', $id)->delete();
                    if ($result) {
                        delete_cache('menu_cache');
                        exit(return_json(\url('admin/admin/menu')));
                    }
                    return false;
                }
                
               if ( $data['point'] == 'delgoods' ) {
                    $id = $data['id'];
                    if (empty($id) ) {
                        return false;
                    }
                    $id = intval($id);
                    $result = Db::name('goods')->where('id', $id)->update(['is_del' => 2]);
                    if ($result) {
                        delete_cache('goods_cache');
                        exit(return_json(\url('admin/admin/goods')));
                    }
                    return false;
                }
                
                
               if ( $data['point'] == 'delbrand' ) {
                    $id = $data['id'];
                    if (empty($id) ) {
                        return false;
                    }
                    $id = intval($id);
                    $result = Db::name('brand')->where('id', $id)->update(['is_del' => 2]);
                    if ($result) {
                        delete_cache('brand_cache');
                        exit(return_json(\url('admin/admin/brand')));
                    }
                    return false;
                }
                
                if ( $data['point'] == 'delgoodscate' ) {

                    $id = $data['id'];
                    
                    if (empty($id) ) {
                        return false;
                    }
                    $id = intval($id);
                    $xiaji =  Db::name('goodscategory')->where('pid', $id)->select();
                    if (!empty($xiaji)) {
                        exit(return_json('', 400, false, '删除失败， 此分类还有下级'));
                    }
    
                    $result = Db::name('goodscategory')->where('id', $id)->update(['is_del' => 2]);
                    if ($result) {
                        delete_cache('goods_cache');
                        exit(return_json(\url('admin/admin/goodscate')));
                    }
                    return false;
                }
                
            }
            
        }
        
        //简介
        public  function  setting()
        {
            if (empty($setting)) {
                $setting = Db::name('us')->find();
            }
            if (\request()->isAjax()) {
                $post = \request()->post();
                if (!empty($post)) {
                    if ( empty( $post['title']) ) {
                        exit(return_json('', 400, false, '网站标题不能为空！'));
                    }
                    if ( empty( $post['people']) ) {
                        exit(return_json('', 400, false, '网站联系人不能为空！'));
                    }
                    $preg_phone='/^1[34578]\d{9}$/ims';
                     if(!preg_match($preg_phone,trim($post['people_tel']))){
                         exit(return_json('', 400, false, '手机为空或格式不正确！'));
                    }
                    $preg_email='/^[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+)*@([a-zA-Z0-9]+[-.])+([a-z]{2,5})$/ims';
                    if(!preg_match($preg_email, trim($post['email']))) {
                        exit(return_json('', 400, false, '邮箱为空或格式不正确！'));
                    }
                    if ( empty( $post['code']) ) {
                        exit(return_json('', 400, false, '请上传官方二维码！'));
                    }
                    if ( empty( $post['comintro']) ) {
                        exit(return_json('', 400, false, '公司简介不能为空！'));
                    }
                    if ( empty( $post['address']) ) {
                        exit(return_json('', 400, false, '公司地址不能为空！'));
                    }
                    $data = [
                        'title' => trim($post['title']),
                        'people' => trim($post['people']),
                        'people_tel' => trim($post['people_tel']),
                        'email' => trim($post['email']),
                        'code' => trim($post['code']),
                        'footer_msg' => serialize($post['footer_msg']),
                        'description' => serialize($post['description']),
                        'keywords' => serialize($post['keywords']),
                        'comintro' => htmlspecialchars($post['comintro']),
                        'native' => htmlspecialchars($post['native']),
                        'address' => serialize($post['address']),
                        'update_time' => time()
                    ];
            }
            
                if ( empty($setting)) {
                    $result    =     Db::name('us')->insert($data);
                } else {
                    
                    if ( empty($post['id'])) {
                        $this->error('缺少参数id');
                        exit;
                    }
                    $result    =     Db::name('us')->where('id', $post['id'])->update($data);
                }
                if (!empty($result)) {
                    delete_cache('setting_cache');
                 exit(return_json(\url('admin/admin/setting')));
                }
            }
            
            if ($setting) {
                $setting['footer_msg'] = unserialize( $setting['footer_msg'] );
                $setting['keywords'] = unserialize( $setting['keywords'] );
                $setting['description'] = unserialize( $setting['description'] );
                $setting['address'] = unserialize( $setting['address'] );
                $this->assign('setting',  $setting );
            }
    
            $this->assign('rand',  rand(12, 9995252588));
            return view();
        
        }
        
        //banner
        public  function banner()
        {
            if (Request::instance()->isAjax()) {
                if ( \request()->post('point') == 'changStatus' ) {
                    $post = \request()->post() ;
                    
                    if (empty($post['id']) ) {
                        return false;
                    }
                    
                    $id = intval($post['id']);
                    $data['status'] = intval($post['status']);
                    $result = Db::name('banner')->where('id', $id)->update($data);
                    if ($result) {
                        delete_cache('banner_cache');
                        exit(return_json());
                    }
                    return false;
                }
                
            }
    
    
            if (\request()->get()) {
                $get = \request()->get();
                
                if ($get['point'] == 'update' && !empty($get['id'])) {
                    
                    $find = Db::name('banner')->where('id', intval($get['id']))->find();
    
                    $this->assign('find',   $find);
                    $this->assign('rand',   946296889869);
                    return view('admin/addbanner');
                
                } else {
                    $this->error('缺少参数');
                    exit;
                }
            }
            
            //记录缓存
            //$banner = get_cache('banner_cache');
           
//            if (empty($banner)) {
                $banner = Db::name('banner')->where('is_del', 1 )->select();
              //  set_cache('banner_cache', $banner);
//            }
    
            $this->assign('banner',   $banner);
            
            return view();
        }
        
           //banner
        public  function addbanner()
        {
            $post = \request()->post();
            if (!empty($post)) {
                
                if (empty($post['banner'])) {
                    $this->error('请上传幻灯片图片');
                }
                
                if (!empty( $post['intro'] )) {
                    $data['intro'] = htmlspecialchars( $post['intro']);
                }
                $data['banner'] = trim($post['banner']);
                $data['sort'] = trim($post['sort']);
                $data['name'] = trim($post['name']);

                if (empty($post['id'])) {
                    $result = Db::name('banner')->insert($data);
                } else {
                    $id = intval($post['id']);
                    $result = Db::name('banner')->where('id', $id)->update($data);
                }
                if ($result) {
                     delete_cache('banner_cache');
                    $this->success('提交成功', url('admin/admin/banner'));
                    exit;
                } else {
                    $this->error('提交失败');
                    exit;
                }
            }
            $this->assign('rand',  rand(12, 9995252588));
            return view();
        }
        
           
           //banner
        public  function addnews()
        {
    
    
    
            $post = \request()->post();
            if (!empty($post)) {
                if ($_FILES) {
                    $file = $_FILES['file'];
                    if (empty($file)) {
                        exit(false);
                    }
                    upload($file);
                }
                
                if (!empty( $post['intro'] )) {
                    $data['intro'] = $post['intro'];
                }
                $data['sort'] = trim($post['sort']);
                $data['title'] = trim($post['title']);
                $data['icon'] = trim($post['icon']);
                $data['author'] = trim($post['author']);
                $data['content'] = htmlspecialchars($post['content']);

                if (empty($post['id'])) {
                    $data['create_time'] =time();
                    $result = Db::name('news')->insert($data);
                } else {
                    $id = intval($post['id']);
                    $result = Db::name('news')->where('id', $id)->update($data);
                }
                if ($result) {
                     delete_cache('news_cache');
                    $this->success('提交成功', url('admin/admin/news'));
                    exit;
                } else {
                    $this->error('提交失败');
                    exit;
                }
            }
            $this->assign('rand',  rand(12, 9995252588));
            return view();
        }
        
        
        //menu
        public  function  menu()
        {
           // $menu = get_cache('menu_cache');
//            if (empty($menu)) {

                $menu =  Db::name('menu')->where([ 'is_del' => 1] )->select();
                //set_cache('menu_cache', $menu);

//            }

            $this->assign( 'menu', $menu );
            return view();

        }

        public  function  addmenu()
        {
            $get = \request()->get();
            if (!empty($get)) {
                $id  = intval($get['id']);
                $find = Db::name('menu')->where('id', $id)->find();
                $this->assign('find', $find);
            }
            if (Request::instance()->isAjax()) {

                $post = \request()->post();
    
                if ( empty($post['title'])) {
                    exit(return_json('', '400',  false , '标题不能为空！'));
                }
                if ( empty($post['url'])) {
                exit(return_json('', '400',  false , '跳转链接不能为空！'));
                }
                
                if (!empty($post)) {
                    $data['title'] = trim($post['title']);
                    $data['url'] = trim($post['url']);
                    $data['sort'] = intval($post['sort']);
                    $data['create_time'] = time();
                    
                    if (empty($post['id'] )) {
                        $result = Db::name('menu')->insert($data);
                    } else {
                        $id = intval($post['id']);
                        $data['update_time'] = time();
                        $result = Db::name('menu')->where('id',  $id )->update( $data );

                    }

                    if (!empty($result)) {
                        delete_cache('menu_cache');
                        exit(return_json('menu'));
                    } else {
                        exit(return_json('', '400', '0', '操作失败'));

                    }
                }
            }

        return view();

        }
        
        
        //标题
        public function title()
        {
            $title = get_cache('title_cache');
            if (empty($title)) {
                
                $title = Db::name('title')->where('is_del', 1)->select();
                set_cache('title_cache', $title);
            }
            $this->assign('title', $title);
            return view();
        
        }
        
        
        //
        public function keywords()
        {
    
            if (\request()->isAjax()) {
                $post = \request()->post();
                
                if ($post['do'] == '_status') {
                    if (empty($post['id'])) {
                        exit(return_json('', 400, false, '缺少参数！'));
                    }
                
                    $result = Db::name('keywords')->where('id', intval($post['id']))->update([trim($post['field']) => intval($post['value'])] );
                    if (!empty($result)) {
                        exit(return_json());
                    }
                    
                }
            }
            
//            $keywords = get_cache('keywords_cache');
//            if (empty($keywords)) {
                
                $keywords = Db::name('keywords')->where('is_del', 1)->select();
               // set_cache('keywords_cache', $keywords);
          //  }
            $this->assign('keywords', $keywords);
            return view();
        
        }
        
        
        //标题
        public function addtitle()
        {
            if (!empty(\request()->get('id'))) {
                
                $id = \request()->get('id');
                $find  =  Db::name('title')->where('id', $id)->find();
                
                $this->assign('find', $find);
                
            }
    
            if (Request::instance()->isAjax()) {
                
                $post  = \request()->post();
                
                $data['sort']  = intval($post['sort']);
                $data['a_title']  = intval($post['a_title']);
                $data['b_title']    = intval($post['b_title']);
                $data['recommend']    = intval($post['recommend']);
                $data['status']   =  1;
                $data['create_time']   =  time();
                $data['is_del'] = 1;
    
                if (empty($post['id'])) {
                    $result = Db::name('title')->insert($data);
                } else {
                    $id = intval($post['id']);
                    $result = Db::name('title')->where('id', $id)->update($data);
                }
    
                if ($result) {
                    delete_cache('title_cache');
                    exit(return_json('title'));
                }
                    json_debug($_POST);
                
            }
            
            return view();
        
        }
        
        
        
        //标题
        public function addkeywords()
        {
    
            $id = \request()->get('id');
            if (!empty( $id )) {
                
                $id = \request()->get('id');
                
                $find  =  Db::name('keywords')->where('id', $id)->find();
                
                $this->assign('find', $find);
                
            }
    
            if (Request::instance()->isAjax()) {
                
                $post  = \request()->post();
                
                $data['sort']  = intval($post['sort']);
                $data['keywords']  = trim($post['keywords']);
                $data['url']    = trim($post['url']);
                $data['recommend']    = intval($post['recommend']);
                $data['status']   =  1;
                $data['create_time']   =  time();
                $data['is_del'] = 1;
    
                if (empty($post['id'])) {
                    $result = Db::name('keywords')->insert($data);
                } else {
                    $id = intval($post['id']);
                    $result = Db::name('keywords')->where('id', $id)->update($data);
                }
    
                if ($result) {
                    delete_cache('keywords_cache');
                    exit(return_json('keywords'));
                }
                    json_debug($_POST);
                
            }
            
            return view();
        
        }
        
        
        //goodsc_ate
        public  function  goodscate()
        {
    
            if (\request()->isAjax()) {
                $post = \request()->post();
                if ($post['do'] == "_status" ) {
                    if (empty($post['id'])) {
                        exit(  return_json('', 400, false, '缺少参数'));
                    }
    
                    $result = Db::name('goodscategory')->where('id', intval($post['id']))->update([trim($post['field']) => intval($post['value'])]);
    
                    if (!empty( $result )) {
        
                        exit(return_json());
        
                    }
                    exit(false);
                }
            }
            
            
            //$goodsCate = get_cache('goodscate_cache');

          //  if (empty($goodsCate)) {
            
                $goodsCate = Db::name('goodscategory')->where('is_del',  1)->select();
                
                $goodsCate = tree($goodsCate);
                
                //set_cache('goodscate_cache', $goodsCate);
           // }
            
            $this->assign('goodsCate', $goodsCate);
    
            return view();
    
        }
        
        
        /**
         * @return \think\response\View
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         */
        public  function  addgoodscate()
        {
            $get = \request()->get();
            if ( !empty( $get['id'] ) ) {
                
                $id = intval($get['id']);
                
                $find = Db::name('goodscategory')->where('id', $id )->find();
                
                $this->assign('find', $find);
                
            }
            
            $post = \request()->post();
            if (!empty( $post )) {
    
                $data  = [
                    'cate_name' => trim( $post['cate_name'] ),
                    'icon' => trim( $post['icon'] ),
                    'pid' => intval( $post['pid'] ),
                    'sort' => intval( $post['sort'] ),
                    'is_recommend' => intval( $post['is_recommend'] )
                ];

                if (empty($post['id'])) {
                    $data['create_time'] =time();
                   $result = Db::name('goodscategory')->insert( $data );
                } else {
                    $id = intval( $post['id'] );
                    $data['update_time'] = time();
                    $result = Db::name('goodscategory')->where('id', $id )->update( $data );
                }
    
                if (!empty( $result )) {
                    delete_cache('goodscate_cache');
                    exit(return_json(\url('goodscate')));
                }
    
            }
            
//            $goodsCate = get_cache('goodscate_cache');
//            delete_cache('goodscate_cache');
           // if (empty($goodsCate)) {
                
                $goodsCate = Db::where(['is_del' => 1, 'status' => 1])->name('goodscategory')->select();

                $goodsCate = tree($goodsCate);
                
//                set_cache('goodscate_cache', $goodsCate);
                
           // }
            
            $this->assign('rand',  rand(12, 9995252588));
            $this->assign('goodsCate',  $goodsCate);
    
            return view();
        
        }
    
        /**
         * @return \think\response\View
         * @throws \think\Exception
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @throws \think\exception\PDOException
         */
        public  function  brand()
        {
            if (\request()->get('do') == 'add') {
                $id  = \request()->get('id');
                if (!empty($id)) {
                    $find = Db::name('brand')->where('id', $id)->find();
                    $this->assign('find',  $find);
                }
                $this->assign('rand',  rand(12, 9995252588));
                return view('admin/addbrand');
            }
    
            if (\request()->isPost()) {
                
                $post = \request()->post();
                
                if ($post['do'] == 'add') {
                    
                    $data = [
                        'name' =>trim($post['name']),
                        'icon' =>trim($post['icon']),
                        'status' => 1,
                        'is_del' => 1,
                        'update_time' => time()
                    ];
                    
                    if (!empty($post['id'])) {
                        
                        $id = intval($post['id']);
                        $result = Db::name('brand')->where('id', $id )->update($data);
                        
                    } else {
                        
                        $result = Db::name('brand')->insert($data);
                        
                    }
                    
                    if (!empty($result)) {
                        exit(return_json());
                    }

                    exit(false);
                    
                }

                if (trim(\request()->post('do')) ==  "_status") {
                    
                    $post = \request()->post();
                    
                    if (empty($post['id'])) {
                        exit(  return_json('', 400, false, '缺少参数'));
                    }
    
                    $result = Db::name('brand')->where('id', intval($post['id']))->update([trim($post['field']) => intval($post['value'])]);
    
                    if (!empty( $result )) {
                        
                        exit(return_json());
                        
                    }
                    exit(false);
                }
                
            }

                
            $brand = Db::name('brand')->where('is_del', 1)->select();
            $this->assign('brand', $brand);
            return view();
        }
        
        
        
        
        
        /**
         * @return \think\response\View
         */
        public  function  goods()
        {
            $where = [];
            if (!empty(\request()->get('cateid'))) {
                $where = ['cateid' => intval(\request()->get('cateid'))];
            }
              if (request()->get('cateid') == 'all') {
                $where = [];
            }
            
            $goods = Db::name('goods')->where(['is_del' =>1])->where($where)->select();
            foreach ( $goods as $key => &$val) {
                $val['intro'] = unserialize($val['intro']);
                $val['label'] = unserialize( $val['label'] );
                $val['pic'] = unserialize( $val['pic'] );
                $cate = Db::name('goodscategory')->where('id', $val['cateid'])->field('cate_name')->find();
                $val['cate_name'] = trim($cate['cate_name'] );
                if (!empty( $val['label']  )) {
                    $val['label']  = implode('、', $val['label']);
                }
                $val['create_time'] = date('Y/m/d H:i:s', $val['create_time']);
            }
    
            if (\request()->isAjax()) {
                $post = \request()->post();
                if ($post['do'] == '_status') {
                    
                    if (empty($post['id'])) {
                        exit(return_json('', 400, false, '缺少参数！'));
                    }
                    
                    $id = intval($post['id']);
                    $result = Db::name('goods')->where('id', $id)->update([trim($post['field']) => intval($post['value'])]);
                    if (!empty($result)) {
                        exit(return_json());
                    }
                    exit(false);
                }
            }

            $cate = Db::name('goodscategory')->where(['is_del' => 1, 'status' => 1])->select();
            $cate = tree($cate);
            
            $this->assign('goods', $goods );
            $this->assign('cate', $cate );
            return view();
        
        }
    
        /**
         * @return \think\response\View
         */
        public  function  addgoods()
        {
            $cate = Db::name('goodscategory')->where( 'pid' , '<>', 0 )->where('status', 1)->select();
            $brand = Db::name('brand')->where('is_del', 1 )->where('status', 1)->select();
            if (empty( $cate )) {
                $this->error('请先添加商品分类', \url('admin/admin/goodscate'));
                exit;
            }
            if (empty( $brand )) {
                $this->error('请先添加品牌', \url('admin/admin/brand'));
                exit;
            }
    
            $get = \request()->get();
            if (!empty($get['id'])) {
                $id = intval($get['id']);
                $find  = Db::name('goods')->where('id', $id)->find();
                $find['intro'] = unserialize($find['intro']);
                $find['label'] = unserialize($find['label']);
                $find['pic'] = unserialize($find['pic']);
                $this->assign('find', $find);
            }
    
            if (\request()->isPost()) {
                $post = \request()->post();
    
                if ( empty($post['name'])) {
                    exit(return_json('', '400',  false , '商品名称不能为空！'));
                }
                if ( empty($post['variety'])) {
                    exit(return_json('', '400',  false , '品种不能为空！'));
                }
                if ( empty($post['packing_specifications'])) {
                    exit(return_json('', '400',  false , '袋装规格不能为空！'));
                }
               if ( empty($post['brandid'])) {
                     exit(return_json('', '400',  false , '品牌不能为空！'));
                }
                if ( empty($post['new_price'])) {
                     exit(return_json('', '400',  false , '商品现价不能为空！'));
                }
                if ( empty($post['icon'])) {
                    exit(return_json('', '400',  false , '商品图标不能为空！'));
                }
                if ( empty($post['labelArr'])) {
                    exit(return_json('', '400',  false , '请添加商品标签！'));
                }
                if ( empty($post['picArr'])) {
                    exit(return_json('', '400',  false , '请上传商品图片！'));
                }
                if ( empty($post['intro'])) {
                    exit(return_json('', '400',  false , '商品简介不能为空！'));
                }
                if ( empty($post['detail'])) {
                    exit(return_json('', '400',  false , '商品详情不能为空！'));
                }
              
                
                $data  = [
                    'sort' => intval($post['sort']),
                    'name' => trim($post['name']),
                    'variety' => trim($post['variety']),
                    'packing_specifications' => $post['packing_specifications'],
                    'brandid' => intval($post['brandid']),
                    'grade' => 1,
                    'cateid' => intval($post['cateid']),
                    'intro' => serialize($post['intro']),
                    'detail' => htmlspecialchars($post['detail']),
                    'icon' => trim($post['icon']),
                    'old_price' => trim($post['old_price']),
                    'new_price' => trim($post['new_price']),
                    'label' =>  serialize(  $post['labelArr']),
                    'is_hot' => intval($post['is_hot']),
                    'is_recommend' =>intval( $post['is_recommend']),
                    'volume' => $post['volume'],
                    'weight' => $post['weight'],
                    'pic' => serialize($post['picArr']),
                    'video' => trim($post['video']),
                    'expresses_price' => trim($post['expresses_price'])
                    ];
                
                if (empty($post['id'])) {
                    $data['create_time'] = time();
                    $result = Db::name('goods')->insert( $data );
                } else {
                    $id = intval($post['id']);
                    $data['update_time'] = time();
                  $result = Db::name('goods')->where('id', $id )->update($data);
                }
    
                if (!empty($result)) {
                    
                    exit(return_json('goods'));
                    
                }
                
                exit(return_json('', '400', '0', '操作失败'));
                
            }
            
            //分类
            $goodsCate = Db::name('goodscategory')->where(['status' => 1, 'is_del' =>1])->select();
            $goodsCate = tree($goodsCate);
            
            //品牌
            $brand = Db::name('brand')->where(['status' => 1, 'is_del' =>1])->select();

            $this->assign('goodsCate',  $goodsCate);
            $this->assign('brand',  $brand);
            $this->assign('rand',  rand(12, 9995252588));
        return view();
        
        }
    
        //文章
        public  function news()
        {
            if (Request::instance()->isAjax()) {
                if (!empty(\request()->post())) {
                    $post = \request()->post();
                    if ($post['do'] == "_status") {
                        $field =  trim($post['field']);
                        $id = intval($post['id']);
                        $value = intval($post['value']);
                    }
                    $result = Db::name('news')->where('id', $id)->update([$field=> $value]);
                    if (!empty($result)) {
                        exit(return_json());
                    } else {
                        exit(false);
                    }
                }
            }
    
        
            if (\request()->get()) {
                $get = \request()->get();
            
                if ($get['point'] == 'update' && !empty($get['id'])) {
                
                    $find = Db::name('news')->where('id', intval($get['id']))->find();
                
                    $this->assign('find',   $find);
                    $this->assign('rand',   946296889869);
                    return view('admin/addnews');
                
                } else {
                    $this->error('缺少参数');
                    exit;
                }
            }
        
            //记录缓存
            $news = Db::name('news')->where('is_del', 1 )->select();
            $this->assign('news',   $news);
        
            return view();
        }
        
        public  function  base()
        {
            if (\request()->post('do') == '_status') {
                $post = \request()->post();
                $field =  trim($post['field']);
                $id = intval($post['id']);
                $value = intval($post['value']);
                $result = Db::name('base')->where('id', $id)->update([$field=> $value]);
                if (!empty($result)) {
                exit(return_json());
                } else {
                exit(false);
                }
            }
            if (\request()->param('point') == 'add') {
                if (!empty( \request()->get('id') )) {
                    $id = intval( \request()->get('id'));
                    $find = Db::name('base') ->where('id', $id)->find();
                    $this->assign('find', $find);
                }
                
                if (\request()->isAjax()) {
                    $post = \request()->post();
                    
                    if ( empty($post['title'])) {
                        exit(return_json('', '400',  false , '标题不能为空！'));
                    }
                    
                    $content = trim($post['content']);
                    if (empty($content)) {
                        exit(return_json('', '400',  false , '介绍不能为空！'));
                    }
                    
                    $icon = trim($post['icon']);
                    if (empty( $icon )) {
                        exit(return_json('', '400',  false , '图片不能为空！'));
                    }
                    
                    $data  = [
                        'title'  => trim($post['title']),
                        'icon' => trim($post['icon']),
                        'content' => htmlspecialchars($post['content']),
                        'status' => 1,
                        'sort' => intval($post['sort']),
                        'update_time'  => time()
                    ];
                    
                    $id = intval($post['id']);
                    if ( empty($id)) {
                        $result = Db::name('base')->insert($data);
                    } else {

                        $result = Db::name('base')->where('id', $id)->update($data);
                    }
                    if (!empty($result )) {
                        exit(return_json());
                    } else {
                        exit(false);
                    }
                }
                
                $this->assign('rand',   946296889869);
                return view('admin/addbase');
            }
            
            $data = Db::name('base')->select();
            
            $this->assign('data', $data);
            return view();
        
        }
        
        //资质
        public  function  aptitude()
        {
            if (\request()->post('do') == '_status') {
                $post = \request()->post();
                $field =  trim($post['field']);
                $id = intval($post['id']);
                $value = intval($post['value']);
                $result = Db::name('aptitude')->where('id', $id)->update([$field=> $value]);
                if (!empty($result)) {
                exit(return_json());
                } else {
                exit(false);
                }
            }
            
            if (\request()->param('point') == 'add') {
    
                if (!empty( \request()->get('id') )) {
                    $id = intval( \request()->get('id'));
                    $find = Db::name('aptitude') ->where('id', $id)->find();
                    $this->assign('find', $find);
                }
                
                if (\request()->isAjax()) {
                    $post = \request()->post();
    
    
                    if ( empty($post['title'])) {
                        exit(return_json('', '400',  false , '标题不能为空！'));
                    }
    
                    $intro = trim($post['intro']);
                    if (empty($intro)) {
                        exit(return_json('', '400',  false , '介绍不能为空！'));
                    }
    
                    $icon = trim($post['icon']);
                    if (empty( $icon )) {
                        exit(return_json('', '400',  false , '图片不能为空！'));
                    }
                    
                    $data  = [
                        'title'  => trim($post['title']),
                        'icon' => trim($post['icon']),
                        'intro' =>  htmlspecialchars($post['intro'] ),
                        'status' => 1,
                        'sort' => intval($post['sort']),
                        'update_time'  => time()
                    ];
                    
                    $id = intval($post['id']);
                    
                    if ( empty($id)) {
                        $result = Db::name('aptitude')->insert($data);
                    } else {

                        $result = Db::name('aptitude')->where('id', $id)->update($data);
                    }
                    if (!empty($result )) {
                        exit(return_json());
                    } else {
                        exit(false);
                    }
                }
                
                $this->assign('rand',   946296889869);
                return view('admin/addaptitude');
            }
            
            $data = Db::name('aptitude')->select();
            
            $this->assign('data', $data);
            return view();
        
        }
    
    
        public  function  admin()
        {
            if (\request()->isAjax()) {
                $post = \request()->post();
                //如果用户存在， 就更新用户信息
                //如不存在就新增用户信息
                $id = intval($post['id']);
                
                if (!empty($id)) {
                    $valid =  AdminModel::update_account($post);
                    
                    if (!empty( $valid )) {
                        
                        $data = [
                            'username' => trim($post['username']),
                            'password' => md5($post['password']),
                            'userip' => get_ip(),
                            'status' => 1,
                            'is_del' => 1,
                            'update_time' => time(),
                            'icon' => trim($post['icon'])
                        ];
                        
                        $update_result = Db::name('admin')->where('id',  intval($post['id']))->update($data);

                        if (!empty($update_result)) {
                            Cookie::delete('userinfo');
                            Session::delete('userinfo');
                            exit(return_json( url('admin/admin/login') ));
                        }
                    }
                } else {
                    $result = AdminModel::valid_account($post);
                    if ( true === $result) {
                        $data = [
                            'status' => 1,
                            'is_del' => 1,
                            'username' => $post['username'],
                            'password' => md5( $post['password'] ),
                            'userip' => get_ip(),
                            'create_time' => time(),
                            'icon' => trim($post['icon'])
                        ];
                        $result    =     Db::name('admin')->insert($data);
                        if ($result ) {
                            exit( return_json());
                        }
                        exit(false);
                    }
                }
                
            }
            
            $account = Db::name('admin')->where('status', 1 )->find();

            if (!empty($account)) {
                $this->assign('account', $account);
            }
            
            $this->assign('rand',   946296889869);
            
            return view();
        
        }
        
        
        
        public  function  setcache()
        {
            if (\request()->isAjax()) {
                $set =  \request()->post('setCache');
                if (true == $set) {
                    $result =   Cache::clear();
                    if ($result) {
                  exit(return_json('', 400, false, '操作成功！'));
                    }
                    exit(false);
                }
            }
        }
        
        public function uploader()
        {
            if (\request()->file()) {
                $file =$_FILES['file'];
                upload( $file );
            }
        }
    
        /**
         * @return \think\response\View
         */
        public  function  login()
        {
            if ( true === request()->isPost()) {
    
                $post = request()->post();
    
                $captcha = trim($post['captcha']);
            
                if (empty( $post['username'] )) {
                    exit(return_json('', 400,  false, '用户名不能为空！'));
                }
            
                if (empty( $post['password'] )) {
                    exit(return_json('', 400,  false, '密码不能为空！'));
                }
            
                if(!captcha_check($captcha)) {
                    //验证失败
                    exit(return_json('', 400,  false, '验证码输入错误'));
                };

                $result   =  AdminModel::check_login( $post );
            
                if (true === $result ) {
                    //记录log
                    exit(return_json(url('admin/admin/index'), 200,  true,  '欢迎'. $post['username']. '回来!'));
                
                } else {
                
                    exit(return_json('', 400,  false, '系统错误！'));
                
                }
            
            }
        
            return view();
        
        }
    
        public  function  logout()
        {
            
                //清除session
                Session::delete('userInfo');
                $this->success('正在退出...', \url('admin/login'));
        }
    
    
    }