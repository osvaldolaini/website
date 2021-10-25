@if (isset($item['accesslevel']))
    @if (Auth::user()->group->level <= $item['accesslevel'])
        <li @if(isset($item['id'])) id="{{ $item['id'] }}" @endif class="nav-header {{ $item['class'] ?? '' }}">
            {{ is_string($item) ? $item : $item['header'] }}
        </li>
    @endif
@endif
