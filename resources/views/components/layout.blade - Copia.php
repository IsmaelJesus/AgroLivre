@php
  $farms = auth()->user()->farms; // ou o método que você usa

  $role = Auth::user()->getRoleForSelectedFarm();
  $isOwner = auth()->user()->isOwner;
@endphp
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>AgroLivre</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="{{ asset('images/kaiadmin/favicon.ico') }}"
      type="{{ asset('image/x-icon') }}"
    />

    <!-- Fonts and icons -->
    <script src="{{ asset('js/plugin/webfont/webfont.min.js')}}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["{{ asset('css/fonts.min.css')}} "],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/kaiadmin.css')}} " />
    <link rel="stylesheet" href="{{ asset('css/style.css')}} " />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo">
              <img
                src="{{ asset('images/agroLivre_logo.svg')}}"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                <a
                  href="{{ route('dashboard') }}"
                >
                  <i class="fas fa-home"></i>
                  <p>Inicio</p>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Menus</h4>
              </li>
              @if($role === 'admin' || $isOwner === 1)
                <!-- Plots  -->
                <li class="nav-item {{ request()->is('plot*') ? 'active' : '' }}">
                  <a href="{{ route('plot.index') }}">
                    <i class="fas fa-layer-group"></i>
                    <p>Áreas</p>
                  </a>
                </li>
              @endif
              @if($role === 'admin' || $role === 'tecnico' || $role === 'operador' || $isOwner === 1)
              <!-- Activies  -->
              <li class="nav-item {{ request()->is('activity*') ? 'active' : '' }}">
                <a href="{{ route('activity.create') }}">
                  <i class="fas fa-pen-square"></i>
                  <p>Atividades</p>
                </a>
              </li>
              @endif
              @if($role === 'admin' || $isOwner === 1)
              <!-- Farms  -->
              <li class="nav-item {{ request()->is('farm*') ? 'active' : '' }}">
                <a href="{{ route('farm.index') }}">
                  <i class="fas fa-map-marker-alt"></i>
                  <p>Fazendas</p>
                </a>
              </li>
              <li class="nav-item {{ request()->is('supply*') ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#charts">
                  <i class="far fa-chart-bar"></i>
                  <p>Insumos</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="charts">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{ route('supply.index') }}">
                        <span class="sub-item">Defensivos</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('seed.create') }}">
                        <span class="sub-item">Sementes</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>

              {{-- <!-- Suplies  -->
              <li class="nav-item {{ request()->is('supply*') ? 'active' : '' }}">
                <a href="{{ route('supply.index') }}">
                  <i class="fas fa-table"></i>
                  <p>Insumos</p>
                </a>
              </li> --}}
              <!-- Machineries  -->
              <li class="nav-item {{ request()->is('machinery*') ? 'active' : '' }}">
                <a href="{{ route('machinery.index') }}">
                  <i class="fas fa-map-marker-alt"></i>
                  <p>Patrimônio</p>
                </a>
              </li>
              <!-- Crops  -->
              <li class="nav-item {{ request()->is('crops*') ? 'active' : '' }}">
                <a href="{{ route('crop.index') }}">
                  <i class="fas fa-th-list"></i>
                  <p>Safras</p>
                </a>
              </li>
              <!-- Users  -->
              <li class="nav-item {{ request()->is('user*') ? 'active' : '' }}">
                <a href="{{ route('user.create') }}">
                  <i class="far fa-chart-bar"></i>
                  <p>Usuários</p>
                </a>
              </li>
              @endif
              @if(Auth::check())
                  <form action="{{ route('select.farm') }}" method="POST">
                      @csrf
                     
                      <label for="farm_id" class="text-white">Selecionar Fazenda</label>
                      <select name="farm_id" id="farm_id" onchange="this.form.submit()" class="form-select bg-gray-800 text-black">
                          <option value="">-- Selecione --</option>

                          @foreach($farms as $farm)
                              <option value="{{ $farm->id }}" {{ session('selected_farm_id') == $farm->id ? 'selected' : '' }}>
                                  {{ $farm->name }}
                              </option>
                          @endforeach
                      </select>
                  </form>
              @endif
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index.html" class="logo">
                <img
                  src="assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
             <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <img
                        src="{{ asset('images/profile.png')}}"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
                    </div>
                    <span class="profile-username">
                      <span class="op-7">Olá,</span>
                      <span class="fw-bold">{{ Auth::user()->name }}</span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <img
                              src="{{ asset('images/profile.png')}}"
                              alt="image profile"
                              class="avatar-img rounded"
                            />
                          </div>
                          <div class="u-text">
                            <h4>{{ Auth::user()->name }}</h4>
                            <p class="text-muted">{{ Auth::user()->email }}</p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <!--<form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link class="dropdown-item" :href="route('logout')">Logout</x-dropdown-link>
                        </form>-->
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" class="dropdown-item"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>

        <div class="container">
          <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Dashboard</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>

                    @foreach (Request::segments() as $index => $segment)
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url(implode('/', array_slice(Request::segments(), 0, $index + 1))) }}">
                                {{ ucfirst(str_replace('-', ' ', $segment)) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="page-category">
                @if (session('error'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <strong class="font-bold">Erro!</strong>
                                                <span class="block sm:inline">{{ session('error') }}</span>
                      <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                @elseif(session('success'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <strong class="font-bold">Sucesso !</strong>
                                                <span class="block sm:inline">{{ session('success') }}</span>
                      <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                @endif
                <!--------------- VOU COLOCAR A PARTE DE CONTEUDOS AQUI ---------------------->
                {{ $slot }}

            </div>
          </div>
        </div>
        
    <!--   Core JS Files   -->
    <script src="{{ asset('js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{ asset('js/core/popper.min.js')}}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('js/plugin/chart.js/chart.min.js')}}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('js/plugin/jquery.sparkline/jquery.sparkline.min.js')}} "></script>

    <!-- Chart Circle -->
    <script src="{{ asset('js/plugin/chart-circle/circles.min.js')}} "></script>

    <!-- Datatables -->
    <script src="{{ asset('js/plugin/datatables/datatables.min.js')}} "></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('js/plugin/bootstrap-notify/bootstrap-notify.min.js')}} "></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('js/plugin/jsvectormap/jsvectormap.min.js')}} "></script>
    <script src="{{ asset('js/plugin/jsvectormap/world.js')}} "></script>

    <!-- Google Maps Plugin -->
    <script src="{{ asset('js/plugin/gmaps/gmaps.js')}} "></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('js/plugin/sweetalert/sweetalert.min.js')}} "></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('js/kaiadmin.min.js')}}"></script>

    <script src="https://unpkg.com/imask"></script>

    <script>
        document.querySelectorAll('.alert').forEach(function (alert) {
            alert.addEventListener('closed.bs.alert', function () {

            });
        });
    </script>
  </body>
</html>