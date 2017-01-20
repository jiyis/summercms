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
 * 前台静态资源发布
 *
 * Do a 'gulp copyfiles' after bower updates
 *

/**
 * 拷贝任何需要的文件
 *
 * Do a 'gulp copyfiles' after bower updates
 */
gulp.task("copyfiles", function() {

    // jQuery
    gulp.src("vendor/bower/adminlte/plugins/jQuery/*.js").pipe(rename('jquery.min.js'))
        .pipe(gulp.dest("resources/assets/js/"));

    gulp.src("vendor/bower/adminlte/plugins/jQuery/*.js").pipe(rename('jquery.min.js'))
        .pipe(gulp.dest("resources/assets/plugins/jquery/"));

    // bootstarp
    gulp.src("vendor/bower/adminlte/bootstrap/css/bootstrap.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/adminlte/bootstrap/js/bootstrap.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/adminlte/bootstrap/fonts/*")
        .pipe(gulp.dest("resources/assets/fonts/"));

    gulp.src("vendor/bower/adminlte/bootstrap/fonts/*")
        .pipe(gulp.dest("resources/assets/plugins/fonts/"));
    gulp.src("vendor/bower/adminlte/bootstrap/js/bootstrap.min.js")
        .pipe(gulp.dest("resources/assets/plugins/bootstrap/"));

    gulp.src("vendor/bower/adminlte/bootstrap/css/bootstrap.min.css")
        .pipe(gulp.dest("resources/assets/plugins/bootstrap/"));

    // adminlte
    gulp.src("vendor/bower/adminlte/dist/css/AdminLTE.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/adminlte/dist/css/skins/skin-blue.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/adminlte/dist/js/app.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/adminlte/dist/img/*")
        .pipe(gulp.dest("resources/assets/img/"));

    // Fontawesome
    gulp.src("vendor/bower/fontawesome/css/font-awesome.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/fontawesome/fonts/*")
        .pipe(gulp.dest("resources/assets/fonts/"));

    // Ionicons
    gulp.src("vendor/bower/ionicons/css/ionicons.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/ionicons/fonts/*")
        .pipe(gulp.dest("resources/assets/fonts/"));

    // slimScroll
    gulp.src("vendor/bower/adminlte/plugins/slimScroll/jquery.slimscroll.min.js")
        .pipe(gulp.dest("resources/assets/js/"));

    // iCheck
    gulp.src("vendor/bower/adminlte/plugins/iCheck/icheck.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    /*gulp.src("vendor/bower/adminlte/plugins/iCheck/all.css").pipe(cssimport(options))
     .pipe(gulp.dest("resources/assets/css/"));*/
    gulp.src("vendor/bower/adminlte/plugins/iCheck/square/purple.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/adminlte/plugins/iCheck/square/purple.png")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/adminlte/plugins/iCheck/square/purple@2x.png")
        .pipe(gulp.dest("resources/assets/css/"));

    // iCheck
    gulp.src("vendor/bower/adminlte/plugins/iCheck/icheck.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/adminlte/plugins/iCheck/all.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/adminlte/plugins/iCheck/square/blue.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/adminlte/plugins/iCheck/square/blue.png")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/adminlte/plugins/iCheck/square/blue@2x.png")
        .pipe(gulp.dest("resources/assets/css/"));

    // select2
    gulp.src("vendor/bower/adminlte/plugins/select2/select2.full.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/adminlte/plugins/select2/select2.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/adminlte/plugins/select2/select2.min.css")
        .pipe(gulp.dest("resources/assets/css/"));

    // pace
    gulp.src("vendor/bower/adminlte/plugins/pace/pace.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/adminlte/plugins/pace/pace.min.js")
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
        .pipe(gulp.dest("resources/assets/plugins/datetimepicker/"));
    gulp.src("vendor/bower/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")
        .pipe(gulp.dest("resources/assets//plugins/datetimepicker/"));
    gulp.src("vendor/bower/smalot-bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js")
        .pipe(gulp.dest("resources/assets/plugins/datetimepicker/"));

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

    //dropzone
    gulp.src("vendor/bower/dropzone/dist/min/dropzone.min.css")
        .pipe(gulp.dest("resources/assets/plugins/dropzone/"));
    gulp.src("vendor/bower/dropzone/dist/min/dropzone.min.js")
        .pipe(gulp.dest("resources/assets/plugins/dropzone/"));

    // cropper
    gulp.src("vendor/bower/cropper/dist/cropper.min.css")
        .pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/cropper/dist/cropper.min.js")
        .pipe(gulp.dest("resources/assets/js/"));

    // vuejs
    gulp.src("vendor/bower/vue/dist/vue.min.js")
        .pipe(gulp.dest("resources/assets/js/"));

    // bootstrap-switch
    gulp.src("vendor/bower/bootstrap-switch/dist/js/bootstrap-switch.min.js")
        .pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css")
        .pipe(gulp.dest("resources/assets/css/"));



});
elixir(function(mix) {

    //拷贝插件包到public目录
    mix.copy('resources/assets/plugins/', 'public/assets/plugins/');

    mix.copy('resources/assets/package/', 'public/assets/package/');

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
            'icheck.min.js',
            'app.min.js',
            'select2.full.min.js',
            'sweetalert.min.js',
            'jquery.dataTables.min.js',
            'dataTables.bootstrap.min.js',
            'vue.min.js',
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
            'adminlte.min.css',
            'skin-blue.min.css',
            'dataTables.bootstrap.min.css',
            'sweetalert.css',
            'all.css',
            'blue.css',
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
            'adminlte.min.css',
            'blue.css',
            'common.css',
        ],
        'public/assets/css/login.css',
        'resources/assets/css/'
    );
    //前台发布
    mix.scripts(
        [
            'jquery.min.js',
            'vue.min.js',
            'common.js'
        ],
        'build/dist/js/base.min.js',
        'assets/js/'          
    );
    mix.scripts(
        [
            'index.js',
        ],
        'build/dist/js/app.min.js',
        'assets/js/'          
    );
    mix.styles(
        [
            'pgwslideshow.css',
            'style.css',

        ],
        'build/dist/css/app.min.css',
        'assets/css/'          
    );

    mix.copy("assets/images/*.*","build/dist/images/");
    mix.copy("assets/js/pgwslideshow.min.js","build/dist/js/");

    mix.version(['assets/css/admin.css', 'assets/js/admin.js', 'assets/css/login.css', 'assets/js/login.js']);
});