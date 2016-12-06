const gulp = require('gulp');
const elixir = require('laravel-elixir');
const rename = require('gulp-rename');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */


/**
 * 拷贝任何需要的文件
 *
 * Do a 'gulp copyfiles' after bower updates
 */
gulp.task("copyfiles", function() {

    // jQuery
    gulp.src("vendor/bower/AdminLTE/plugins/jQuery/*.js").pipe(rename('jQuery.min.js'))
        .pipe(gulp.dest("resources/assets/js/"));

    // bootstarp
    gulp.src("vendor/bower/AdminLTE/bootstrap/css/bootstrap.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/AdminLTE/bootstrap/js/bootstrap.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/AdminLTE/bootstrap/fonts/*")
        .pipe(gulp.dest("resources/assets/fonts/"));

    // AdminLTE
    gulp.src("vendor/bower/AdminLTE/dist/css/AdminLTE.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/AdminLTE/dist/css/skins/skin-green.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/AdminLTE/dist/js/app.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/AdminLTE/dist/img/*")
        .pipe(gulp.dest("resources/assets/img/"));

    // Fontawesome
    gulp.src("vendor/bower/fontawesome/css/font-awesome.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/fontawesome/fonts/*")
        .pipe(gulp.dest("resources/assets/fonts/"));

    // Ionicons
    gulp.src("vendor/bower/Ionicons/css/ionicons.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/Ionicons/fonts/*")
        .pipe(gulp.dest("resources/assets/fonts/"));

    // slimScroll
    gulp.src("vendor/bower/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js")
        .pipe(gulp.dest("resources/assets/js/"));

    // iCheck
    gulp.src("vendor/bower/AdminLTE/plugins/iCheck/icheck.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    /*gulp.src("vendor/bower/AdminLTE/plugins/iCheck/all.css").pipe(cssimport(options))
     .pipe(gulp.dest("resources/assets/css/"));*/
    gulp.src("vendor/bower/AdminLTE/plugins/iCheck/square/purple.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/AdminLTE/plugins/iCheck/square/purple.png")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/AdminLTE/plugins/iCheck/square/purple@2x.png")
        .pipe(gulp.dest("resources/assets/css/"));

    // iCheck
    gulp.src("vendor/bower/AdminLTE/plugins/iCheck/icheck.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/AdminLTE/plugins/iCheck/all.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/AdminLTE/plugins/iCheck/square/blue.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/AdminLTE/plugins/iCheck/square/blue.png")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/AdminLTE/plugins/iCheck/square/blue@2x.png")
        .pipe(gulp.dest("resources/assets/css/"));

    // select2
    gulp.src("vendor/bower/AdminLTE/plugins/select2/select2.full.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/AdminLTE/plugins/select2/select2.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/AdminLTE/plugins/select2/select2.min.css")
        .pipe(gulp.dest("resources/assets/css/"));

    // pace
    gulp.src("vendor/bower/AdminLTE/plugins/pace/pace.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/AdminLTE/plugins/pace/pace.min.js")
        .pipe(gulp.dest("resources/assets/js/"));

    //sweetalert
    gulp.src("vendor/bower/sweetalert/dist/sweetalert.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/sweetalert/dist/sweetalert.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/sweetalert/dist/sweetalert.gif")
        .pipe(gulp.dest("resources/assets/img/"));

    //datapicker
    gulp.src("vendor/bower/smalot-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/smalot-bootstrap-datetimepicker/js/locales/*")
        .pipe(gulp.dest("resources/assets/js/locales/"));


    //dataTable
    gulp.src("vendor/bower/DataTables/media/css/dataTables.bootstrap.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/DataTables/media/js/jquery.dataTables.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/DataTables/media/js/dataTables.bootstrap.min.js")
        .pipe(gulp.dest("resources/assets/js/"));

    //toastr
    gulp.src("vendor/bower/toastr/toastr.min.css")
        .pipe(gulp.dest("resources/assets/plugins/toastr/"));
    gulp.src("vendor/bower/toastr/toastr.min.js")
        .pipe(gulp.dest("resources/assets/plugins/toastr/"));


    // cropper
    gulp.src("vendor/bower/cropper/dist/cropper.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/cropper/dist/cropper.min.js")
        .pipe(gulp.dest("resources/assets/js/"));

});
elixir(function(mix) {

    //拷贝插件包到public目录
    mix.copy('resources/assets/plugins/', 'public/assets/plugins/');

    mix.copy('resources/assets/language/', 'public/assets/language/');

    mix.copy('resources/assets/fonts/', 'public/assets/fonts/');
    mix.copy('resources/assets/fonts/', 'public/build/assets/fonts/');

    mix.copy('resources/assets/img/', 'public/assets/img/');
    mix.copy('resources/assets/img/', 'public/build/assets/img/');

    mix.copy('resources/assets/images/', 'public/assets/images');

    mix.copy('resources/assets/css/*.png', 'public/assets/css/');
    mix.copy('resources/assets/css/*.png', 'public/build/assets/css/');


    // 合并javascript脚本
    mix.scripts(
        [
            'jquery.min.js',
            'bootstrap.min.js',
            'jquery.slimscroll.min.js',
            'icheck.min.js',
            'app.min.js',
            'select2.full.min.js',
            'sweetalert.min.js',
            'jquery.dataTables.min.js',
            'dataTables.bootstrap.min.js',
            'common.js'

        ],
        'public/assets/js/admin.js',
        'resources/assets/js/'
    );

    // 合并登录的javascript脚本
    mix.scripts(
        [
            'jquery.min.js',
            'bootstrap.min.js',
            'icheck.min.js'
        ],
        'public/assets/js/login.js',
        'resources/assets/js/'
    );

    // 合并css样式
    mix.styles(
        [
            'bootstrap.min.css',
            'font-awesome.min.css',
            'ionicons.min.css',
            'select2.min.css',
            'AdminLTE.min.css',
            'skin-green.min.css',
            //'purple.css',
            'dataTables.bootstrap.min.css',
            'sweetalert.css',
            'common.css'

        ],
        'public/assets/css/admin.css',
        'resources/assets/css/'
    );

    // 合并登录所需要的css样式
    mix.styles(
        [
            'bootstrap.min.css',
            'font-awesome.min.css',
            'ionicons.min.css',
            'AdminLTE.min.css',
            'blue.css',
            'common.css',
            'login.css'
        ],
        'public/assets/css/login.css',
        'resources/assets/css/'
    );

    //前台所需要的样式文件
    mix.styles(
        [
            'bootstrap.min.css',
            'font-awesome.min.css',
            'ionicons.min.css',
            'select2.min.css',
            'sweetalert.css',
            'purple.css',
            'fcommon.css'

        ],
        'public/assets/css/frontend.css',
        'resources/assets/css/'
    );
    mix.scripts(
        [
            'jquery.min.js',
            'bootstrap.min.js',
            'icheck.min.js',
            'app.min.js',
            'select2.full.min.js',
            'sweetalert.min.js',
            'fcommon.js'
        ],
        'public/assets/js/frontend.js',
        'resources/assets/js/'
    );

    mix.version(['assets/css/admin.css', 'assets/js/admin.js', 'assets/css/login.css', 'assets/js/login.js','assets/css/frontend.css','assets/js/frontend.js']);
});