const mix = require('laravel-mix');

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
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');*/

mix.scripts('resources/views/admin/template/js/main_admin.js','public/admin/js/main_admin.js')
.scripts('resources/views/admin/template/js/app_crud.js','public/admin/js/app_crud.js')
.scripts('resources/views/admin/template/js/jquery.mask.min.js','public/admin/js/jquery.mask.min.js')
.scripts('resources/views/admin/template/upload/app_uploads.js','public/admin/template/upload/app_uploads.js')
.scripts('resources/views/admin/template/upload/app_multipleuploads.js','public/admin/template/upload/app_multipleuploads.js')
.scripts('resources/views/admin/template/switch/app_switch.js','public/admin/template/switch/app_switch.js')
.scripts('resources/views/admin/template/js/recaptcha.js','public/admin/js/recaptcha.js')
.scripts('resources/views/admin/template/validate/app_validate.js','public/admin/template/validate/app_validate.js')
.scripts('resources/views/admin/template/js/app_emails.js','public/admin/js/app_emails.js')
.scripts('resources/views/admin/template/highchart/app_charts.js','public/admin/template/highchart/app_charts.js')
.sass('resources/views/admin/template/upload/scss/uploads.scss', 'public/admin/template/upload/uploads.css')
.sass('resources/views/admin/template/switch/scss/switch.scss', 'public/admin/template/switch/switch.css')
.sass('resources/views/admin/template/validate/scss/validate.scss', 'public/admin/template/validate/css/validate.css')

.minify([
    'public/admin/template/switch/app_switch.js',
    'public/admin/template/upload/app_uploads.js',
    'public/admin/template/upload/app_multipleuploads.js',
    'public/admin/js/main_admin.js',
    'public/admin/js/app_crud.js',
    'public/admin/js/recaptcha.js',
    'public/admin/template/validate/app_validate.js',
    'public/admin/js/app_emails.js',
    'public/admin/js/app_views.js',
    'public/admin/template/highchart/app_charts.js',
])
.minify([
    'public/admin/template/switch/switch.css',
    'public/admin/template/upload/uploads.css',
    'public/admin/template/validate/css/validate.css',
])
.version();

/*Site */
mix.scripts('resources/views/site/template/js/app_site.js','public/site/assets/js/app_site.js')
.copyDirectory('resources/views/site/template/vendor', 'public/site/template/vendor')
.copyDirectory('resources/views/site/template/fonts', 'public/fonts')
.scripts('resources/views/admin/template/js/app_views.js','public/site/assets/js/app_views.js')
.sass('resources/views/site/template/scss/style.scss', 'public/site/assets/css/style.css',{
    prependData: "$url:'" + process.env.APP_URL + "';"
})

.minify([
    'public/site/assets/css/style.css',
    'public/site/assets/js/app_site.js',
])

.version();
