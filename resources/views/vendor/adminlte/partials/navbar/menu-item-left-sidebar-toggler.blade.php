<li class="nav-item">
    <a class="nav-link" data-widget="pushmenu" href="#"
        @if(config('adminlte.sidebar_collapse_remember'))
            data-enable-remember="true"
        @endif
        @if(!config('adminlte.sidebar_collapse_remember_no_transition'))
            data-no-transition-after-reload="false"
        @endif
        @if(config('adminlte.sidebar_collapse_auto_size'))
            data-auto-collapse-size="{{ config('adminlte.sidebar_collapse_auto_size') }}"
        @endif>
        <i class="fas fa-bars"></i>
        <span class="sr-only">{{ __('adminlte::adminlte.toggle_navigation') }}</span>
    </a>

</li>
<li>
    <!--Alteração feita em 07/07/2021-->
    <a class="nav-link" href="{{url('')}}" target="_BLANK" data-trigger="hover" data-tooltip="tooltip" data-placement="top" title="Ver">
        <i class="fas fa-eye"></i>
    </a>
</li>
