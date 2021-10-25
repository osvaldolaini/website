
<div class="container-fluid">
    <div class="row text-center copyright">
        <div class="col-lg-12">
            <span>Copyright &copy; @php date('Y') @endphp - {{ $config->title }}, todos os direitos
                reservados. Desenvolvido Por
                <picture>
                    <source data-srcset="{{ url('storage/images/logos/logo-ol.png') }}" class="lazyload" />
                    <source data-srcset="{{ url('storage/images/logos/logo-ol.webp') }}" class="lazyload" />
                    <img data-src="{{ url('storage/images/logos/logo-ol.png') }}" class="lazyload"
                        style="width:10%" />
                </picture>
            </span>
        </div>
    </div>
</div>
