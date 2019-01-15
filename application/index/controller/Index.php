<?php
namespace app\index\controller;

use think\Db;
use think\Session;

class Index extends Common
{
    public function index()
    {
        if (request()->get()) {
            
            //推荐
            $recommend_goods = Db::name('goods')->where(['status' => 1, 'is_del' => 1])
                ->field('name, id, icon, intro, new_price')->limit(6)->select();
            $get =  request()->get();
            $view  = $get['view'];
    
            $view = $view ? $view : 'about';
            
            //goods详情
            if ($view  == 'single-product' ) {
                if ( !empty( $get['id'])) {
                    $id = intval($get['id']);
                    $goods_info = Db::name('goods') ->where('id', $id)->find();
                    $goods_info['intro'] = unserialize($goods_info['intro']);
                    $goods_info['label'] = unserialize($goods_info['label']);
                    $goods_info['pic'] = unserialize($goods_info['pic']);
                    $goods_info['detail'] = html_entity_decode($goods_info['detail']);
                    $this->assign('goods_info', $goods_info);
                    
                    //推荐
                    if ($recommend_goods) {
                        foreach ($recommend_goods as &$val ) :
                        $val['intro'] = unserialize($val['intro']);
                        Endforeach;
                    }
                  
                    $this->assign('recommend_goods', $recommend_goods);
                }
                return view('index/single-product');
            }
    
            //关于
            if ($view == 'about') {
                //荣誉资质
                $aptitude  =Db::name('aptitude')->where('status', 1)->field('icon, title')->order('sort asc')->select();
    
                $this->assign('aptitude', $aptitude);
                
                $this->assign('recommend_goods', $recommend_goods);
                
                return view('index/about');
                
            }
            
            
            //联系我们
            if ($view == 'contact') {
    
                if (request()->isAjax()) {
    
                    $post = request()->post();
                    if (trim($post['SE_KO']) !== Session::get('SE_KO')) {
                        exit(return_json('', 400, false, '您已经提交过了,  请勿重复提交哦！'));
                    }
                  
                  $data = [
                      'user_name' => trim($post['user_name']),
                      'user_tel' => trim($post['user_tel']),
                      'user_message' => trim($post['user_message']),
                      'status' => 1,
                      'time' => time(),
                      'ip' => get_ip()
                  ];
                  
                  $result = Db::name('message')->insert($data);
                    if (!empty($result)) {
                        Session::delete('SE_KO');
                        exit(return_json(url(''), 400, 100, '提交成功'));
                    }
                  
                }
                
                
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
                $this->assign('setting', $setting);
                $SE_KO = rand(1111111,9923455412315).chr(rand(65,90));
                Session::set('SE_KO', $SE_KO);
                $this->assign('SE_KO', $SE_KO );
    
                return view('index/contact');
            }
        exit;
        }
        
        //推荐商品展示
        $goods = Db::name('goods')->where(['status'=> 1, 'is_del' => 1])->where('is_recommend', 1)->limit(4)->order('sort asc')->select();
        
        //推荐分类
        $recommend_cate  = Db::name('goodscategory')->where(['is_recommend'=> 1, 'status'=> 1, 'is_del' => 1,])->where('pid<>0') ->select();
        
        if ($goods)
            $this->assign('goods', $goods);     if ($goods)
        if ($recommend_cate)
            $this->assign('recommend_cate', $recommend_cate);
        
        
        return view();
    }

}