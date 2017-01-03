<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        /*   $script = getcwd().'/database/seeds/init.sql';

            $username = Config::get('database.connections.mysql.username');
            $password = Config::get('database.connections.mysql.password');
            $database = Config::get('database.connections.mysql.database');

            $command = "mysql -u $username -p$password $database < $script";

            exec($command);

         *   Model::unguard();
         *   $this->call(UserTableSeeder::class);
         *   Model::reguard();
         *      //另外的插入方法
         *   DB::table($table)->insert($row);
         */
        $prefix = env('DB_PREFIX');
        $password = bcrypt('123456');
        $array = [
            "insert  into `".$prefix."admin_users`(`id`,`name`,`nickname`,`email`,`password`,`is_super`,`remember_token`,`created_at`,`updated_at`) values (1,'admin','管理员','admin@admin.com','\$2y\$10\$tg34bc0xdnZ2kQCsFhpIpey9zSibiEWA0UGeQhzhhlgmKFhuY91ou',1,'C5jQ2NmD8UgYFviG5UGGCHMwJWJC82N3AU18GSoyAMMXMjT0MB01bSLsm1Id','2016-06-02 07:33:41','2016-06-15 06:21:29'),(3,'luck','小何','luck@benq.com','luck',0,NULL,'2016-06-13 08:39:58','2016-06-13 08:39:58');",
            "insert  into `".$prefix."permissions`(`id`,`fid`,`icon`,`name`,`display_name`,`description`,`is_menu`,`sort`,`created_at`,`updated_at`) values (20,0,'gear','#-1456129983','系统设置','',1,100,'2016-02-22 09:33:03','2016-02-22 09:33:03'),(21,20,'circle-o','admin.users.index','用户权限','查看后台用户列表',1,10,'2016-02-18 08:56:26','2016-12-19 14:02:45'),(22,20,'','admin.users.create','创建后台用户','页面',0,0,'2016-02-23 04:48:18','2016-02-23 04:48:18'),(35,0,'home','admin.home','控制台','后台首页',1,0,'2016-04-13 08:46:58','2016-04-13 06:46:58'),(37,36,'','admin.registers.index','报名列表','',1,0,'2016-02-22 10:15:48','2016-06-28 08:27:18'),(38,20,'','admin.users.store','保存新建后台用户','操作',0,0,'2016-02-23 04:48:52','2016-02-23 04:48:52'),(39,20,'','admin.users.destroy','删除后台用户','操作',0,0,'2016-02-23 04:49:09','2016-02-23 04:49:09'),(40,20,'','admin.users.destory.all','批量后台用户删除','操作',0,0,'2016-02-23 05:01:01','2016-02-23 05:01:01'),(42,20,'','admin.users.edit','编辑后台用户','页面',0,0,'2016-02-23 04:48:35','2016-02-23 04:48:35'),(43,20,'','admin.users.update','保存编辑后台用户','操作',0,0,'2016-02-23 04:50:12','2016-02-23 04:50:12'),(44,20,'','admin.permission.index','权限管理','页面',0,0,'2016-02-23 04:51:36','2016-02-23 04:51:36'),(45,20,'','admin.permission.create','新建权限','页面',0,0,'2016-02-23 04:52:16','2016-02-23 04:52:16'),(46,20,'','admin.permission.store','保存新建权限','操作',0,0,'2016-02-23 04:52:38','2016-02-23 04:52:38'),(47,20,'','admin.permission.edit','编辑权限','页面',0,0,'2016-02-23 04:53:29','2016-02-23 04:53:29'),(48,20,'','admin.permission.update','保存编辑权限','操作',0,0,'2016-02-23 04:53:56','2016-02-23 04:53:56'),(49,20,'','admin.permission.destroy','删除权限','操作',0,0,'2016-02-23 04:54:27','2016-02-23 04:54:27'),(50,20,'','admin.permission.destory.all','批量删除权限','操作',0,0,'2016-02-23 04:55:17','2016-02-23 04:55:17'),(51,20,'','admin.role.index','角色管理','页面',0,0,'2016-02-23 04:56:07','2016-02-23 04:56:07'),(52,20,'','admin.role.create','新建角色','页面',0,0,'2016-02-23 04:56:33','2016-02-23 04:56:33'),(53,20,'','admin.role.store','保存新建角色','操作',0,0,'2016-02-23 04:57:26','2016-02-23 04:57:26'),(54,20,'','admin.role.edit','编辑角色','页面',0,0,'2016-02-23 04:58:25','2016-02-23 04:58:25'),(55,20,'','admin.role.update','保存编辑角色','操作',0,0,'2016-02-23 04:58:50','2016-02-23 04:58:50'),(56,20,'','admin.role.permissions','角色权限设置','',0,0,'2016-02-23 04:59:26','2016-02-23 04:59:26'),(57,20,'','admin.role.destroy','角色删除','操作',0,0,'2016-02-23 04:59:49','2016-02-23 04:59:49'),(58,20,'','admin.role.destory.all','批量删除角色','',0,0,'2016-02-23 05:01:58','2016-02-23 05:01:58'),(59,0,'cubes','#-1481783084','工具管理','数据库和菜单管理等工具',1,75,'2016-12-09 13:19:41','2016-12-15 14:24:44'),(60,59,'database','admin.database','数据库管理','可以针对所需要字段，自定义添加模型',1,0,'2016-12-09 13:26:26','2016-12-09 13:27:33'),(61,59,'list','admin.menus.index','菜单管理','',1,0,'2016-12-12 13:14:33','2016-12-12 13:14:33'),(62,0,'file-o','admin.page.index','页面管理','自定义页面管理',1,0,'2016-12-15 09:36:35','2016-12-15 09:36:35'),(63,59,'tablet','admin.layout.index','布局管理','页面布局管理',1,0,'2016-12-15 16:32:27','2016-12-16 13:27:43'),(64,59,'paint-brush','admin.template.index','模板管理','包括列表模板、内容模板',1,12,'2016-12-16 10:46:40','2016-12-16 10:46:40'),(65,20,'circle-o','admin.settings','网站设置','网站基本设置',1,1,'2016-12-19 10:23:41','2016-12-19 14:02:33'),(66,0,'folder','admin.category.index','栏目管理','栏目管理',1,71,'2016-12-19 10:23:41','2016-12-19 14:02:33'),(67,0,'pencil-square-o','#-1482636808','日志管理','',1,85,'2016-12-25 11:33:12','2016-12-25 11:33:28'),(68,67,'','admin.logs.index','登陆日志','',1,0,'2016-12-25 11:38:25','2016-12-25 11:39:34'),(69,67,'','admin.operationlog.index','操作日志','',1,1,'2016-12-25 11:38:43','2016-12-25 11:39:58'),(70,59,'paint-brush','admin.search.index','搜索模版管理','',1,30,'2016-12-25 11:38:43','2016-12-25 11:39:58'),(71,0,'gamepad','admin.game.index','赛事中心','赛事管理',1,11,'2016-12-29 16:07:02','2016-12-29 16:07:17');",
            "insert  into `".$prefix."roles`(`id`,`name`,`display_name`,`description`,`created_at`,`updated_at`) values (1,'administrator','超级管理员','拥有所有的权限','2016-06-03 02:26:42','2016-06-15 08:23:10'),(2,'developer','开发RD','开发人员','2016-06-13 15:20:55','2016-06-15 07:42:49');",
            /*"insert  into `".$prefix."permission_role`(`permission_id`,`role_id`) values (20,1),(21,1),(22,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1);",
            "insert  into `".$prefix."role_user`(`user_id`,`role_id`) values (1,1),(3,2);",*/

        ];

        foreach ($array as $key => $value) {
            DB::insert($value);
        }

        DB::table('data_types')->insert([
            0 => [
                'id'                    => 1,
                'name'                  => 'cms_menus',
                'slug'                  => 'menus',
                'display_name_singular' => '菜单',
                'display_name_plural'   => '菜单管理',
                'icon'                  => 'voyager-list',
                'model_name'            => '\\App\\Models\\Menu',
                'description'           => '',
                'created_at'            => '2016-12-12 11:03:32',
                'updated_at'            => '2016-12-12 11:03:32',
            ],
        ]);
        DB::insert("insert  into `".$prefix."data_rows`(`data_type_id`,`field`,`type`,`display_name`,`required`,`browse`,`read`,`edit`,`add`,`delete`,`details`,`deleted_at`) values (1,'id','PRI','id',1,0,0,0,0,0,'',NULL),(1,'name','text','名称',1,1,1,1,1,1,'',NULL),(1,'created_at','timestamp','创建时间',0,1,1,1,0,1,'',NULL),(1,'updated_at','timestamp','更新时间',0,0,0,0,0,0,'',NULL),(1,'deleted_at','timestamp','删除时间',0,0,0,0,0,0,'',NULL);");

        DB::insert("insert  into `".$prefix."settings`(`id`,`key`,`display_name`,`value`,`details`,`type`,`order`,`created_at`,`updated_at`,`deleted_at`) values (1,'seo_title','网站标题','BenQCms','','text',1,'2016-12-23 15:34:55','2016-12-25 11:44:00',NULL),(2,'seo_keyword','网站关键字','BenQCms','','text',2,'2016-12-23 15:35:38','2016-12-25 11:44:00',NULL),(3,'seo_description','网站简介','BenQCms','','text_area',3,'2016-12-23 15:36:03','2016-12-25 11:44:00',NULL);");

    }
}
