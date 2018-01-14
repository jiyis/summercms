let mix = require('laravel-mix');

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

//合并后台所需要的样式
mix.styles(
    [
        'resources/assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css',
        'resources/assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css',
        'resources/assets/adminlte/bower_components/Ionicons/css/ionicons.min.css',
        'resources/assets/adminlte/dist/css/AdminLTE.min.css',
        'resources/assets/adminlte/dist/css/skins/_all-skins.min.css',
        'resources/assets/adminlte/bower_components/morris.js/morris.css',
        'resources/assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
        'resources/assets/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css',
        'resources/assets/adminlte/bower_components/select2/dist/css/select2.min.css',
        'resources/assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
        'resources/assets/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
        'resources/assets/adminlte/plugins/toastr/toastr.min.css',
        'resources/assets/adminlte/plugins/iCheck/all.css',
        'resources/assets/adminlte/plugins/sweetalert/sweetalert.css',
        'resources/assets/adminlte/css/common.css'
    ],
    'public/css/admin.css'
);

//打包合并后台所需要的js
mix.scripts(
    [
        'resources/assets/adminlte/bower_components/jquery/dist/jquery.min.js',
        'resources/assets/adminlte/bower_components/jquery-ui/jquery-ui.min.js',
        'resources/assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js',
        'resources/assets/adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js',
        'resources/assets/adminlte/bower_components/jquery-knob/dist/jquery.knob.min.js',
        'resources/assets/adminlte/bower_components/moment/min/moment.min.js',
        'resources/assets/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js',
        'resources/assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
        'resources/assets/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        'resources/assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js',
        'resources/assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
        'resources/assets/adminlte/bower_components/select2/dist/js/select2.full.min.js',
        'resources/assets/adminlte/plugins/iCheck/icheck.min.js',
        'resources/assets/adminlte/plugins/sweetalert/core.js',
        'resources/assets/adminlte/plugins/sweetalert/sweetalert.min.js',
        'resources/assets/adminlte/dist/js/adminlte.min.js',
        'resources/assets/adminlte/plugins/toastr/toastr.min.js',
        'resources/assets/adminlte/js/common.js',
    ],
    'public/js/admin.js'
);


//合并后台登录页面所需要的样式
mix.styles(
    [
        'resources/assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css',
        'resources/assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css',
        'resources/assets/adminlte/bower_components/Ionicons/css/ionicons.min.css',
        'resources/assets/adminlte/dist/css/AdminLTE.min.css',
        'resources/assets/adminlte/plugins/iCheck/square/blue.css',
        'resources/assets/adminlte/css/common.css'
    ],
    'public/css/admin-login.css'
);


//打包合并后台登录所需要的js
mix.scripts(
    [
        'resources/assets/adminlte/bower_components/jquery/dist/jquery.min.js',
        'resources/assets/adminlte/bower_components/jquery-ui/jquery-ui.min.js',
        'resources/assets/adminlte/plugins/iCheck/icheck.min.js',
    ],
    'public/js/admin-login.js'
);

//压缩打包
mix.copy('resources/assets/adminlte/language/', 'public/language/');
mix.copy('resources/assets/adminlte/fonts/', 'public/fonts/');
mix.copy('resources/assets/adminlte/images/', 'public/images');
mix.copy('resources/assets/adminlte/plugins/iCheck/square/*.png', 'public/css/');


mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');



