<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/1/11 0011
     * Time: 下午 4:52
     */
    
    namespace app\admin\model;
    
    use think\Cookie;
    use think\Db;
    use think\Model;
    use think\Session;

    class Admin extends  Model
    {
        
        static  public  function  valid_account( $data  )
        {
            $username = trim( $data['username']);
            $password = trim($data['password']);
            $repassword = trim($data['repassword']);
        
            if (strlen($username) >= 5 ) {
            
                if( preg_match("/^[A-Za-z0-9]+$/", $username)) {
                    if ($password  === $repassword) {
                    
                        return true;
                    
                    } else {
                    
                        exit(return_json('', 400, false, '两次密码输入不一致'));
                    
                    }
                
                }  else {
                
                    exit(return_json('', 400, false, '用户名不能包含特殊字符！'));
                
                }
            
            } else {
            
                exit(return_json('', 400, false, '用户名长度不够！'));
            
            }
        
        }
    
    
        static  public  function  update_account( $userInfo )
        {
            
            if (empty( $userInfo['oldpassword'] )) {
                exit( return_json('', 400, false, '旧密码为空！'));
            }
            if (empty( $userInfo['password'] )) {
                exit( return_json('', 400, false, '新密码为空！'));
            }
            if (empty( $userInfo['repassword'] )) {
                exit( return_json('', 400, false, '确认新密码为空！'));
            }
            if ( $userInfo['repassword'] !== $userInfo['password']) {
                    exit( return_json('', 400, false, '密码输入不一致！'));
            }
            $user  = Db::name('admin')->where( 'username' , trim($userInfo['username']))->find();

            $oldpassword = md5( $userInfo['oldpassword']);
            if ( !empty($user) && $user['password'] === $oldpassword ) {
                return true;
            } else {
                exit( return_json('', 400, false, '旧密码输入错误！'));
            }
        
        }
    
        static  public  function  check_login( $_user )
        {
            $second  = Session::get('second');
        
            if ( (int)$second  > 5 ) {
            
                $second_time = Session::get('second_time');
            
                if ($second_time  +3600 <= time() ) {
                
                    Session::delete('second_time');
                    Session::delete('second');
                
                }
            
                exit( return_json('', 400, false, '您已超出登录次数， 请于1小时后在尝试登录！'));
            }
        
            if ( !empty($_user)  || is_array( $_user )) {
                //验证
                $userInfo = Db::name('admin')->where('username',  trim($_user['username']))->find();
                if (!empty($userInfo)) {
                
                    if ( md5( $_user['password'] )  === $userInfo['password']) {
                        Session::set('userInfo', $userInfo );
                        return true;
                    } else {
                        Session::set('second', $second +1);
                        Session::set('second_time',  time());
                        exit( return_json('', 400, false, '用户名或密码输入错误！'));
                    }
                } else {
                
                    exit( return_json('', 400, false, '用户不存在！'));
                }
            } else {
            
                exit( return_json('', 400, false, '数据错误！'));
            
            }
        }
        
    }