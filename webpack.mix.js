const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/*
*	copy files
*
*/
// jQuery
mix.copy("vendor/bower/adminlte/plugins/jQuery/*.js",'resources/assets/js/jquery.min.js');
mix.copy("vendor/bower/adminlte/plugins/jQuery/*.js",'resources/assets/plugins/jquery/jquery.min.js');

// bootstarp
mix.copy("vendor/bower/adminlte/bootstrap/css/bootstrap.min.css",'resources/assets/css/');
mix.copy("vendor/bower/adminlte/bootstrap/js/bootstrap.min.js",'resources/assets/js/');
mix.copy("vendor/bower/adminlte/bootstrap/fonts/*","resources/assets/fonts/");
mix.copy("vendor/bower/adminlte/bootstrap/fonts/*","resources/assets/plugins/fonts/");
mix.copy("vendor/bower/adminlte/bootstrap/css/bootstrap.min.css","resources/assets/plugins/bootstrap/");
mix.copy("vendor/bower/adminlte/bootstrap/js/bootstrap.min.js","resources/assets/plugins/bootstrap/");

//adminlte
mix.copy("vendor/bower/adminlte/dist/css/AdminLTE.min.css","resources/assets/css/");
mix.copy("vendor/bower/adminlte/dist/css/skins/skin-blue.min.css","resources/assets/css/");
mix.copy("vendor/bower/adminlte/dist/js/app.min.js","resources/assets/js/");
mix.copy("vendor/bower/adminlte/dist/img/*","resources/assets/img/");

// Fontawesome
mix.copy("vendor/bower/fontawesome/css/font-awesome.min.css","resources/assets/css/");
mix.copy("vendor/bower/fontawesome/fonts/*","resources/assets/fonts/");

// Ionicons
mix.copy("vendor/bower/ionicons/css/ionicons.min.css","resources/assets/css/");
mix.copy("vendor/bower/ionicons/fonts/*","resources/assets/fonts/");

// iCheck
mix.copy("vendor/bower/adminlte/plugins/iCheck/icheck.min.js","resources/assets/js/");
mix.copy("vendor/bower/adminlte/plugins/iCheck/square/blue.css","resources/assets/css/");
mix.copy("vendor/bower/adminlte/plugins/iCheck/square/blue.png","resources/assets/css/");
mix.copy("vendor/bower/adminlte/plugins/iCheck/square/blue@2x.png","resources/assets/css/");

// select2
mix.copy("vendor/bower/adminlte/plugins/select2/select2.min.js","resources/assets/js/");
mix.copy("vendor/bower/adminlte/plugins/select2/select2.min.css","resources/assets/css/");

//sweetalert2
mix.copy("vendor/bower/sweetalert2/dist/sweetalert2.css","resources/assets/css/");
mix.copy("vendor/bower/sweetalert2/dist/sweetalert2.min.js","resources/assets/js/");
mix.copy("vendor/bower/es6-promise/es6-promise.auto.min.js","resources/assets/js/");

//datapicker
mix.copy("vendor/bower/smalot-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css","resources/assets/plugins/datetimepicker/");
mix.copy("vendor/bower/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js","resources/assets/plugins/datetimepicker/");
mix.copy("vendor/bower/smalot-bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js","resources/assets/plugins/datetimepicker/");

//dataTable
mix.copy("vendor/bower/DataTables/media/css/dataTables.bootstrap.min.css","resources/assets/css/");
mix.copy("vendor/bower/DataTables/media/js/jquery.dataTables.min.js","resources/assets/js/");
mix.copy("vendor/bower/DataTables/media/js/dataTables.bootstrap.min.js","resources/assets/js/");

//dropzone
mix.copy("vendor/bower/dropzone/dist/min/dropzone.min.css","resources/assets/plugins/dropzone/");
mix.copy("vendor/bower/dropzone/dist/min/dropzone.min.js","resources/assets/plugins/dropzone/");

//cropper
mix.copy("vendor/bower/cropper/dist/cropper.min.css","resources/assets/css/");
mix.copy("vendor/bower/cropper/dist/cropper.min.js","resources/assets/js/");

//vuejs
mix.copy("vendor/bower/vue/dist/vue.min.js","resources/assets/js/");

//toastr
mix.copy("vendor/bower/toastr/toastr.min.css","resources/assets/plugins/toastr/");
mix.copy("vendor/bower/toastr/toastr.min.js","resources/assets/plugins/toastr/"); 


//拷贝插件包到public目录
mix.copy('resources/assets/plugins/', 'public/assets/plugins/',false);

mix.copy('resources/assets/package/', 'public/assets/package/',false);

mix.copy('resources/assets/language/', 'public/assets/language/',false);

mix.copy('resources/assets/fonts/', 'public/assets/fonts/',false);

mix.copy('resources/assets/img/', 'public/assets/img/',false);

mix.copy('resources/assets/images/', 'public/assets/images',false);

mix.copy('resources/assets/css/*.png', 'public/assets/css/');


/*
*	build project
*
*/

// 合并后台javascript脚本
mix.combine(
	[
        'resources/assets/js/jquery.min.js',
        'resources/assets/js/bootstrap.min.js',
        'resources/assets/js/icheck.min.js',
        'resources/assets/js/app.min.js',
        'resources/assets/js/select2.full.min.js',
        'resources/assets/js/es6-promise.auto.min.js',
        'resources/assets/js/sweetalert2.min.js',
        'resources/assets/js/jquery.dataTables.min.js',
        'resources/assets/js/dataTables.bootstrap.min.js',
        'resources/assets/js/vue.min.js',
        'resources/assets/js/common.js'

    ], 
    'public/assets/js/admin.js'
);


// 合并登录的javascript脚本
mix.combine(
    [
        'resources/assets/js/jquery.min.js',
        'resources/assets/js/bootstrap.min.js',
        'resources/assets/js/icheck.min.js'
    ],
    'public/assets/js/login.js'
);

// 合并后台css样式
mix.combine(
    [
        'resources/assets/css/bootstrap.min.css',
        'resources/assets/css/font-awesome.min.css',
        'resources/assets/css/ionicons.min.css',
        'resources/assets/css/select2.min.css',
        'resources/assets/css/AdminLTE.min.css',
        'resources/assets/css/skin-blue.min.css',
        'resources/assets/css/dataTables.bootstrap.min.css',
        'resources/assets/css/sweetalert2.css',
        'resources/assets/css/all.css',
        'resources/assets/css/blue.css',
        'resources/assets/css/common.css'

    ],
    'public/assets/css/admin.css'
);

// 合并登录所需要的css样式
mix.combine(
    [
        'resources/assets/css/bootstrap.min.css',
        'resources/assets/css/font-awesome.min.css',
        'resources/assets/css/ionicons.min.css',
        'resources/assets/css/AdminLTE.min.css',
        'resources/assets/css/blue.css',
        'resources/assets/css/common.css',
    ],
    'public/assets/css/login.css'
);

//前台发布到public目录
mix.copy("assets/images/*.*","public/dist/images/");
mix.copy("assets/js/pgwslideshow.min.js","public/dist/js/");


mix.combine(
    [
        'assets/js/jquery.min.js',
        'assets/js/vue.min.js',
        'assets/js/env.js',
        'assets/js/common.js'
    ],
    'public/dist/js/base.min.js'       
);


mix.combine(
    [
        'assets/css/pgwslideshow.css',
        'assets/css/style.css',

    ],
    'public/dist/css/app.min.css'         
);

mix.combine(['assets/js/index.js'],'public/dist/js/app.min.js');


//前台发布到build目录
mix.copy("assets/images/*.*","build/dist/images/");
mix.copy("assets/js/pgwslideshow.min.js","build/dist/js/");


mix.combine(
    [
        'assets/js/jquery.min.js',
        'assets/js/vue.min.js',
        'assets/js/env.js',
        'assets/js/common.js'
    ],
    'build/dist/js/base.min.js'         
);


mix.combine(
    [
        'assets/css/pgwslideshow.css',
        'assets/css/style.css',

    ],
    'build/dist/css/app.min.css'         
);

mix.combine(['assets/js/index.js'],'build/dist/js/app.min.js');


if (mix.config.inProduction) {
	mix.version();
}

