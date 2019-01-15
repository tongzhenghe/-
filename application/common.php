<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
    use think\Cache;


    
    /**
     *
     * @param $values
     */
    function judebug($values)
    {
        echo '<pre>';
        print_r($values);
        echo '<pre>';
        exit;

    }
    
    
    function  judebuglog( $files  , $key  = '')
    {
        
        $files = [$key ? $key : date('Y-m-d H : s', time()) => $files];
        $dir = fopen("../application/admin/error.txt", "w") or die("Unable to open file!");
        
        fwrite($dir,  print_r($files, true) );
        
        fclose($dir);
        
    }
    
    
    
    function jsondebug( $array )
    {
        exit(json_encode(['json' => $array]));
    }
    
    
    /**
     * @param $key
     * @param $value
     * @param int $exprie
     */
    function set_cache( $key, $value, $exprie = 0 )
    {
        Cache::set( $key,  $value, $exprie );
    }
    
    /**
     * @param $key
     * @return mixed
     */
    function get_cache( $key )
    {
        $data =   Cache::get( $key );
    
        return $data;
    }
    
    
    /**
     * @param $key
     * @return bool
     */
    function delete_cache( $key )
    {
        $result =  Cache::rm( $key );
        
        return $result;
        
    }
    
    
    function return_json( $url = null , $code = 200,  $status = true, $msg = '操作成功')
    {
    
        $data = [
            'url' => $url,
            'code' =>$code,
            'status' =>  $status,
            'msg' => $msg,
        ];

        $json =  json_encode($data);
        
        return  $json;
        
    }
    
    
    
    function _reSort($data, $parent_id = 0) {
        $return = array();//不能用static
        foreach($data as $v) {
            if($v['pid'] == $parent_id) {
                foreach($data as $subv) {
                    if($subv['pid'] == $v['id']) {
                        $v['children'] = _reSort($data, $v['id']);
                        break;
                    }
                }
                $return[] = $v;
            }
        }
        return $return;
    }
    
    /**
     * @param $data
     * @param int $pid
     * @param int $deep
     * @return array
     */
    function tree($data, $pid = 0, $deep = 0 )
    {
        
        static $arr = [];
        foreach ($data as $val) {
            
            if ($val['pid'] == $pid ) {
                $val['deep'] = $deep;
                $val['html'] = str_repeat('----',$deep);
                $arr[] = $val;
                $arr = tree($data, $val['id'], $deep+1 );
            }
            
        }
        return $arr;
        
    }
    
    
    /**
     * @param $file
     * @return bool
     */
    
    function upload($file) {
        
/*        //设置一个后缀名与mime的映射关系
        $type_map = array(
            '.jpeg'=>array('image/jpeg','image/pjpeg'),
            '.jpg'=>array('image/jpeg','image/pjpeg'),
            '.png'=>array('image/png','image/x-png'),
            '.gif'=>array('image/gif')
        );
    */

        //目录存储
        $up_loadpath = './';
        
        $sub_dir = 'uploadImg';
        
        $date = date('Ymd');
        
        if(!is_dir($up_loadpath.$sub_dir )) {
            
            mkdir($up_loadpath.$sub_dir,  0777);
            
        }
        
        $newPath = $up_loadpath.$sub_dir.'/'.$date;
        
        if(!is_dir(  $newPath )) {
            
            mkdir( $newPath, 0777);
            
        }
    
        $prefix = 'juh_';
    
        $ext = strtolower(strrchr($file['name'],'.'));
        
        $name = str_replace('.',  '', uniqid($prefix,true)).$ext;
    
        $name = trim($name);
    
    
        if(move_uploaded_file($file['tmp_name'],$newPath . '/' . $name)) {
            
            $newPath = str_replace('.', '', $newPath);
    
            exit( json_encode( ['file' => $newPath.'/'.$name ]));
            
        }  else {
         
         return false;
         
        }
    }
    
    
    
     function get_ip() {
    //strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $res =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
    return  $res;
}
    
    function  islogin()
    {
        if (empty(\think\Session::get('userInfo'))) {
            if (empty( \think\Cookie::get('username') ) || empty( \think\Cookie::get('password') )) {
                \think\Cookie::delete('username');
                \think\Cookie::delete('password');
                return false;
            }
            return false;
        }
        return true;
        
    }
    
    