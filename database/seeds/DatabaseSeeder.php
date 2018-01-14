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

        $prefix = env('DB_PREFIX');
        //$password = bcrypt('123456');
        $array = [
            "insert  into `".$prefix."admin_users`(`id`,`name`,`nickname`,`email`,`password`,`is_super`,`remember_token`,`created_at`,`updated_at`) values (1,'admin','管理员','admin@admin.com','\$2y\$10\$dunZeG22ZPwu.lmDJy9ZWOu7qiudT5iQ5VnGJmmPVp9387y7WU5HC',1,'C5jQ2NmD8UgYFviG5UGGCHMwJWJC82N3AU18GSoyAMMXMjT0MB01bSLsm1Id','2016-06-02 07:33:41','2016-06-15 06:21:29');",
            "insert  into `".$prefix."permissions`(`id`,`fid`,`icon`,`name`,`display_name`,`guard_name`,`is_menu`,`sort`,`created_at`,`updated_at`) values (1,0,NULL,'#-1510651486','权限管理','admin',1,10,'2017-11-14 11:23:21','2017-11-14 17:24:46'),(4,1,NULL,'admin.users.index','用户管理','admin',1,5,'2017-11-14 15:07:44','2017-11-14 17:09:02'),(5,1,NULL,'admin.role.index','角色管理','admin',1,5,'2017-11-14 17:09:54','2017-11-14 17:09:54'),(6,1,NULL,'admin.permission.index','权限管理','admin',1,8,'2017-11-14 17:10:23','2017-11-14 17:10:33'),(7,0,NULL,'#-1510650668','系统设置','admin',1,100,'2017-11-14 17:11:08','2017-11-14 17:11:08'),(8,7,NULL,'admin.operationlog.index','操作日志','admin',1,20,'2017-11-14 17:11:50','2017-11-14 17:12:25'),(9,7,NULL,'admin.logs.index','登录日志','admin',1,10,'2017-11-14 17:12:18','2017-11-14 17:12:18'),(10,1,NULL,'admin.users.create','新建用户页面','admin',0,11,'2017-11-14 17:26:34','2017-11-14 17:26:34'),(11,1,NULL,'admin.users.store','保存用户数据','admin',0,12,'2017-11-14 17:27:07','2017-11-14 17:27:07'),(12,1,NULL,'admin.users.edit','编辑用户页面','admin',0,13,'2017-11-14 17:27:28','2017-11-14 17:27:28'),(13,1,NULL,'admin.users.update','更新用户数据','admin',0,14,'2017-11-14 17:27:50','2017-11-14 17:27:50'),(14,1,NULL,'admin.users.destroy','删除用户','admin',0,15,'2017-11-14 17:28:44','2017-11-14 17:28:44'),(15,1,NULL,'admin.users.destroy.all','批量删除用户','admin',0,16,'2017-11-14 17:29:06','2017-11-14 17:29:06'),(16,1,NULL,'admin.role.create','新建角色','admin',0,17,'2017-11-14 17:29:06','2017-11-14 17:29:06'),(17,1,NULL,'admin.role.store','保存角色数据','admin',0,18,'2017-11-14 17:29:06','2017-11-14 17:29:06'),(18,1,NULL,'admin.role.edit','编辑角色页面','admin',0,19,'2017-11-14 17:29:06','2017-11-14 17:29:06'),(19,1,NULL,'admin.role.edit','更新角色数据','admin',0,20,'2017-11-14 17:29:06','2017-11-14 17:29:06'),(20,1,NULL,'admin.role.destroy','删除角色','admin',0,21,'2017-11-14 17:29:06','2017-11-14 17:29:06'),(21,1,NULL,'admin.role.destroy.all','批量删除角色','admin',0,22,'2017-11-14 17:29:06','2017-11-14 17:29:06'),(22,1,NULL,'admin.permission.create','新建权限页面','admin',0,23,'2017-11-14 17:29:06','2017-11-14 17:29:06'),(23,1,NULL,'admin.permission.store','保存权限数据','admin',0,24,'2017-11-14 17:29:06','2017-11-14 17:29:06'),(24,1,NULL,'admin.permission.edit','编辑权限页面','admin',0,25,'2017-11-14 17:29:06','2017-11-14 17:29:06'),(25,1,NULL,'admin.permission.update','更新权限数据','admin',0,26,'2017-11-14 17:29:06','2017-11-14 17:29:06'),(26,1,NULL,'admin.permission.destroy','删除权限','admin',0,27,'2017-11-14 17:29:06','2017-11-14 17:29:06'),(27,1,NULL,'admin.permission.destroy.all','批量删除权限','admin',0,28,'2017-11-14 17:29:06','2017-11-14 17:29:06'),(29,28,NULL,'admin.member.index','客户列表','admin',1,10,'2017-11-17 14:15:04','2017-11-17 14:15:04'),(30,0,NULL,'admin.home','控制台','admin',1,0,'2017-11-19 15:45:20','2017-11-19 15:45:20')",
            "insert  into `".$prefix."roles`(`id`,`name`,`display_name`,`guard_name`,`created_at`,`updated_at`) values (1,'admin','高级管理员','admin','2017-11-19 15:34:59','2017-11-19 15:34:59')",
            "insert  into `".$prefix."role_has_permissions`(`permission_id`,`role_id`) values (2,1),(2,2),(3,1),(3,2),(28,1),(28,2),(29,1),(29,2),(30,1),(30,2),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1)",
            "insert  into `".$prefix."model_has_roles`(`role_id`,`model_id`,`model_type`) values (1,2,'App\\Models\\AdminUser');",

            ];

        foreach ($array as $key => $value) {
            DB::insert($value);
        }
    }
}
