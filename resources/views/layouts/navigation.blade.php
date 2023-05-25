<nav id="sidebarMenu" class="col d-md-block sidebar">
    <div class="position-sticky pt-3">
        <strong class="menu-header d-inline-block">Menu</strong>
        <hr class="hr" />

{{--        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">--}}
{{--            <span>Beheermenu</span>--}}
{{--            <a class="link-secondary" href="#" aria-label="Add a new report">--}}
{{--                <span data-feather="plus-circle"></span>--}}
{{--            </a>--}}
{{--        </h6>--}}
        <ul class="nav flex-column">
            @foreach ($menu as $menuItem)
                <li class="nav-item">
                    <a class="parent nav-link" href="{{ $menuItem->url }}">
                    {{ $menuItem->name }}
                    </a>
                    @if ($menuItem->children)
                        <ul class="nav flex-column">
                            @foreach ($menuItem->children as $child)
                                <a class="child nav-link" href="{{ $child->url }}">
                                <li class="nav-item">
                                    {{ $child->name }}
                                </li>
                                </a>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</nav>
