<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2018/11/29 0029
     * Time: 下午 1:41
     */
    
    namespace app\index\controller;
    
    use app\common\Common;
    use think\Db;

    class Zxmsg extends  Common
    {
        
        public  function  zxmsg()
        {
            if (request()->post()) {
                $post = request()->post();
                $post = $post['formData'];
                $data = [
                   'user_address' => $post['user_address'],
                   'user_email' =>$post['user_email'],
                   'user_message' => $post['user_message'],
                   'user_name' => $post['user_name'],
                   'user_tel' => $post['user_tel'],
                   'ip' => get_ip(),
                   'status' => 2,
                    'time' => time()
               ];

                $result  = Db::table('juh_usermsg')->insert($data);
                if (!empty($result)) {
                  
                  exit(json_encode(['message' => '提交成功', 'status' =>true ] ));
                
                } else {
                
                    exit(json_encode(['message' => '提交失败', 'status' => false]));
                
                }
    
            }
            
            return view();
        
        }
        
        
        
        
    }