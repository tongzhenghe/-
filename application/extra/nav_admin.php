<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2018/12/28 0028
     * Time: 下午 6:16
     */
    
    $helper =  '../thinkphp/helper.php';
    if (file_exists( $helper )) {
        require   ($helper);
    } else {
        exit('获取数据失败');
    }
 
    return [
        //数据分析
        [
            'name' => '数据分析',
            'url' => 'javascript:;',
            'item' => 'donation.html',
            'children' => [
                [
                    'name' => '数据概况',//最新留言、 文章发布量、 网站访问量、
                    'url' => url(  'admin/admin/index'),
                ]
            ],
        ],
     //服务团队
       [
            'name' => '导航管理',
            'url' => 'javascript:;',
           'children' => [
                [
                    'name' => '前台导航',
                    'url' => url('admin/admin/menu'),
                ] ,
            ],
        ],
        
        //服务项目
          [
            'name' => '幻灯片管理',
            'url' => 'javascript:;',
            'children' => [
                [
                    'name' => '幻灯片列表',
                    'url' => url('admin/admin/banner'),
                ] ,
            ],
        ],
        
        
           //辅助
          [
            'name' => '辅助栏目',
            'url' => 'javascript:;',
            'children' => [
                [
                    'name' => '前台关键字',
                    'url' => url('admin/admin/keywords'),
                ],
                [
                    'name' => '新闻/咨询动态',
                    'url' => url('admin/admin/news'),
                ] ,
            ],
        ],
        //商品
        [
            'name' => '商品管理',
            'url' => 'javascript:;',
            'children' => [
                [
                    'name' => '商品列表',
                    'url' => url('admin/admin/goods'),
                ] ,
                [
                    'name' => '商品分类',
                    'url' => url('admin/admin/goodscate'),
                ] ,
                [
                    'name' => '品牌管理',
                    'url' => url('admin/admin/brand'),
                ]
            ],
        ],

        //评论管理
        [
            'name' => '炬晖农业',
            'url' => 'javascript:;',
            'children' => [
                [
                    'name' => '关于我们',
                    'url' => url('admin/admin/setting'),
                ] ,
                [
                    'name' => '生产基地',
                    'url' => url('admin/admin/base'),
                ] ,   [
                    'name' => '荣誉资质',
                    'url' => url('admin/admin/aptitude'),
                ] ,
            ],
        ],
        //社会捐助
        [
            'name' => '留言管理',
            'url' => 'javascript:;',
            'children' => [
                [
                    'name' => '留言列表',
                    'url' => url('admin/admin/consult'),
                ] ,
            ],
        ],
        //设置
        [
            'name' => '设置',
            'url' => 'javascript:;',
            'children' => [
//                [
//                    'name' => '清除缓存',
//                    'url' => url('admin/admin/setcache'),
//                ] ,
                [
                    'name' => '账户管理',
                    'url' => url('admin/admin/admin'),
                ] ,
            ],
        ],

    ];