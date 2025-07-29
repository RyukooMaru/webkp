<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            @if($company && $company->logo)
                <img src="{{ $company->logo_url }}" height="40" alt="{{ $company->company_name }}" class="img-fluid">
            @else
                <span class="fw-bold">{{ $company->company_name ?? 'Company' }}</span>
            @endif
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @foreach($menus as $menu)
                    @if($menu->submenus->count() > 0)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ $menu->nama_menu }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($menu->submenus as $submenu)
                                    <li>
                                        <a class="dropdown-item" 
                                           href="{{ $submenu->websiteContent ? route('page.show', $submenu->websiteContent->id) : ($submenu->tautan ?? '#') }}"
                                           target="{{ !empty($submenu->tautan) && str_starts_with($submenu->tautan, 'http') ? '_blank' : '_self' }}">
                                            {{ $submenu->nama_submenu }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ $menu->final_link }}"
                               target="{{ $menu->link_target }}">
                                {{ $menu->nama_menu }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>