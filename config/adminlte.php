<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/6.-Basic-Configuration
    |
    */

    'title' =>  'ASSGAPA',
    'title_prefix' => '',
    'title_postfix' => '| Associação de Suboficiais e Sargentos da Guarnição de Aeronáutica de Porto Alegre',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/6.-Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => true,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/6.-Basic-Configuration
    |
    */

    'logo' => 'ASSGAPA',
    'logo_img' => 'vendor/adminlte/dist/img/small_logo.png',
    //'logo_img' => 'vendor/adminlte/dist/img/assgapaLogo.png',
    'logo_img_class' => 'brand-image img-circle ',
    'logo_img_xl' => 'vendor/adminlte/dist/img/logo_1.png',
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'ASSGAPA',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/6.-Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/7.-Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/7.-Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => '',
    'classes_auth_header' => 'bg-gradient-primary',
    'classes_auth_body' => '',
    'classes_auth_footer' => 'text-center',
    'classes_auth_icon' => 'fa-lg text-info',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/7.-Layout-and-Styling-Configuration
    |
    */

    'classes_body' => 'layout-navbar-fixed ',
    'classes_brand' => 'navbar-light ',
    'classes_brand_text' => 'text-white text-monospace h4',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-light elevation-4 ',
    'classes_sidebar_nav' => 'nav-compact nav-flat nav-child-indent nav-legacy',
    'classes_topnav' => 'navbar-dark navbar-light',
    'classes_topnav_nav' => 'navbar-expand ',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/7.-Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/7.-Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/6.-Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'painel-admin',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => false,
    'password_reset_url' => false,
    'password_email_url' => false,
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/9.-Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/8.-Menu-Configuration
    |
    */

    'menu' => [
        [
            'text' => 'search',
            'search' => true,
            'topnav' => true,
        ],
        [
            'accesslevel' => 100,
            'text'  => 'Dashboard',
            'url'   => '/painel-admin',
            'active'=> ['/', 'painel-admin'],
            'icon'  => 'fas fa-tachometer-alt',
        ],
        [
            'accesslevel' => 10,
            'text'  => 'users_data',
            'url'   => 'usuarios',
            'icon'  => 'fas fa-fw fa-users',
            'active'=> ['user', 'user*', 'regex:@^user/[0-9]+$@'],
        ],
        /*hr personalizado */
        [
            'accesslevel' => 100,
            'header'   => '',
            'text'     =>'hr',
            'classes'  => 'border-bottom border-secondary mx-2 pt-1 pb-0',
        ],
        /*fim hr personalizado */
        /*fim hr personalizado */
        [
            'accesslevel' => 10,
            'header' => 'Site'
        ],
        [
            'accesslevel' => 10,
            'text'  => 'Ambientes',
            'url'   => 'ambientes',
            'icon'  => 'fas fa-home',
            'active'=> ['ambientes', 'ambientes*', 'regex:@^convenambientesios/[0-9]+$@'],
        ],
        [
            'accesslevel' => 10,
            'text'  => 'Parceiros',
            'url'   => 'parceiros',
            'icon'  => 'fas fa-address-book',
            'active'=> ['parceiros', 'parceiros*', 'regex:@^parceiros/[0-9]+$@'],
        ],
        [
            'accesslevel' => 10,
            'text'  => 'Convênios',
            'url'   => 'convenios',
            'icon'  => 'fas fa-address-book',
            'active'=> ['convenios', 'convenios*', 'regex:@^convenios/[0-9]+$@'],
        ],
        [
            'accesslevel' => 10,
            'text'  => 'Notícias',
            'url'   => 'noticias',
            'icon'  => 'fas fa-newspaper',
            'active'=> ['noticias', 'noticias*', 'regex:@^noticias/[0-9]+$@'],
        ],
        [
            'accesslevel' => 10,
            'text'  => 'Avisos',
            'url'   => 'avisos',
            'icon'  => 'fas fa-exclamation-triangle',
            'active'=> ['avisos', 'avisos*', 'regex:@^avisos/[0-9]+$@'],
        ],
        [
            'accesslevel' => 10,
            'text'  => 'Eventos',
            'url'   => 'eventos',
            'icon'  => 'fas fa-glass-cheers',
            'active'=> ['eventos', 'eventos*', 'regex:@^eventos/[0-9]+$@'],
        ],
        [
            'accesslevel' => 10,
            'text'  => 'Mídias sociais',
            'url'   => 'midias-sociais',
            'icon'  => 'fas fa-hashtag',
            'active'=> ['Mídias sociais', 'Mídias sociais*', 'regex:@^Mídias sociais/[0-9]+$@'],
        ],
        [
            'accesslevel' => 10,
            'text'  => 'Esportes',
            'url'   => 'esportes',
            'icon'  => 'fas fa-volleyball-ball',
            'active'=> ['esportes', 'esportes*', 'regex:@^esportes/[0-9]+$@'],
        ],
        [
            'accesslevel' => 10,
            'text'  => 'Emails',
            'url'   => 'emails',
            'icon'  => 'fas fa-mail-bulk',
            'active'=> ['emails', 'emails*', 'regex:@^emails/[0-9]+$@'],
        ],
        [
            'accesslevel' => 10,
            'text'  => 'Assinantes',
            'url'   => 'assinantes',
            'icon'  => 'far fa-newspaper',
            'active'=> ['assinantes', 'assinantes*', 'regex:@^assinantes/[0-9]+$@'],
        ],

        /*hr personalizado */
        [
            'accesslevel' => 1,
            'header'   => '',
            'text'     =>'hr',
            'classes'  => 'border-bottom border-secondary mx-2 pt-1 pb-0',
        ],

        /*fim hr personalizado */
        [
            'accesslevel' => 1,
            'header' => 'system_settings'
        ],
        [
            'accesslevel' => 1,
            'text'  => 'config',
            'url'   => '/configuracoes',
            'icon'  => 'fas fa-cogs',
            'active'=> ['config','regex:@^config/[0-9]+$@'],
            'level' => 1,
        ],
        [
            'accesslevel' => 1,
            'text'  => 'Informações',
            'url'   => '/informacoes',
            'icon'  => 'fas fa-info-circle',
            'active'=> ['informacoes','regex:@^informacoes/[0-9]+$@'],
            'level' => 1,
        ],
        [
            'accesslevel' => 1,
            'text'  => 'logs',
            'url'   => '/log-viewer',
            'icon'  => 'fa fa-archive',
            'active'=> ['logs','regex:@^logs/[0-9]+$@'],
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/8.-Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/9.-Other-Configuration
    |
    */

    'plugins' => [

        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],

            ],
        ],
        'DatatablesPlugins' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.bootstrap4.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.html5.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.print.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/jszip/jszip.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/pdfmake.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/vfs_fonts.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/css/buttons.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2/sweetalert2.all.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2/sweetalert2.min.css',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'Summernote' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css',
                ],
            ],
        ],
        'Main_admin' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'admin/js/main_admin.min.js',
                ],
            ],
        ],

        'App_switch' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'admin/template/switch/app_switch.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'admin/template/switch/switch.min.css',
                ],
            ],
        ],
        'App_uploads' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'admin/template/upload/app_uploads.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'admin/template/upload/uploads.min.css',
                ],
            ],
        ],
        'App_multipleuploads' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'admin/template/upload/app_multipleuploads.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'admin/template/upload/uploads.min.css',
                ],
            ],
        ],
        'App_validate' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'admin/template/validate/app_validate.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'admin/template/validate/css/validate.min.css',
                ],
            ],
        ],
        'App_emails' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'admin/js/app_emails.min.js',
                ],
            ],
        ],
        'App_crud' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'admin/js/app_crud.min.js',
                ],
            ],
        ],
        'ReCAPTCHAv3' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'https://www.google.com/recaptcha/api.js?render='.env('GOOGLE_RECAPTCHA_PUBLIC_KEY'),
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'admin/js/recaptcha.js',
                ],
            ],
        ],
        'App_charts' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'admin/template/highchart/highchart.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'admin/template/highchart/app_charts.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/9.-Other-Configuration
    */

    'livewire' => false,
];
