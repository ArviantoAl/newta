<!-- main-sidebar -->
<div class="sticky">
    <aside class="app-sidebar">
        <div class="main-sidebar-header active">
            <a class="header-logo active" href="index.html">
                <img src="{{ asset('nowa_assets') }}/img/brand/logo.png" class="main-logo  desktop-logo" alt="logo">
                <img src="{{ asset('nowa_assets') }}/img/brand/logo-white.png" class="main-logo  desktop-dark" alt="logo">
                <img src="{{ asset('nowa_assets') }}/img/brand/favicon.png" class="main-logo  mobile-logo" alt="logo">
                <img src="{{ asset('nowa_assets') }}/img/brand/favicon-white.png" class="main-logo  mobile-dark" alt="logo">
            </a>
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
            <ul class="side-menu">
                <li class="side-item side-item-category">Main</li>
                <li class="slide{{ $titlePage == 'Dashboard Admin' ? ' is-expanded' : '' }}">
                    <a class="side-menu__item{{ $titlePage == 'Dashboard Admin' ? ' active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"/>
                        </svg>
                        <span class="side-menu__label">Dashboards</span>
                    </a>
                </li>
                {{--                        <li class="slide">--}}
                {{--                            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">--}}
                {{--                                <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">--}}
                {{--                                    <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"/>--}}
                {{--                                </svg>--}}
                {{--                                <span class="side-menu__label">Dashboards</span>--}}
                {{--                                <i class="angle fe fe-chevron-right"></i>--}}
                {{--                            </a>--}}
                {{--                            <ul class="slide-menu">--}}
                {{--                                <li class="side-menu__label1"><a href="javascript:void(0);">Dashboards</a></li>--}}
                {{--                                <li><a class="slide-item" href="index.html">Dashboard-1</a></li>--}}
                {{--                                <li><a class="slide-item" href="index1.html">Dashboard-2</a></li>--}}
                {{--                                <li><a class="slide-item" href="index2.html">Dashboard-3</a></li>--}}
                {{--                            </ul>--}}
                {{--                        </li>--}}
                <li class="side-item side-item-category">User</li>
                <li class="slide{{ ($titlePage == 'Daftar User' || $titlePage == 'Tambah User') ? ' is-expanded' : '' }}">
                    <a class="side-menu__item{{ ($titlePage == 'Daftar User' || $titlePage == 'Tambah User' || $titlePage == 'Edit User') ? ' active' : '' }}" data-bs-toggle="slide" href="javascript:void(0);">
                        <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M12,5.5A3.5,3.5 0 0,1 15.5,9A3.5,3.5 0 0,1 12,12.5A3.5,3.5 0 0,1 8.5,9A3.5,3.5 0 0,1 12,5.5M5,8C5.56,8 6.08,8.15 6.53,8.42C6.38,9.85 6.8,11.27 7.66,12.38C7.16,13.34 6.16,14 5,14A3,3 0 0,1 2,11A3,3 0 0,1 5,8M19,8A3,3 0 0,1 22,11A3,3 0 0,1 19,14C17.84,14 16.84,13.34 16.34,12.38C17.2,11.27 17.62,9.85 17.47,8.42C17.92,8.15 18.44,8 19,8M5.5,18.25C5.5,16.18 8.41,14.5 12,14.5C15.59,14.5 18.5,16.18 18.5,18.25V20H5.5V18.25M0,20V18.5C0,17.11 1.89,15.94 4.45,15.6C3.86,16.28 3.5,17.22 3.5,18.25V20H0M24,20H20.5V18.25C20.5,17.22 20.14,16.28 19.55,15.6C22.11,15.94 24,17.11 24,18.5V20Z"/>
                        </svg>
                        <span class="side-menu__label">Data User</span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a href="javascript:void(0);">Data User</a></li>
                        <li><a class="slide-item{{ $titlePage == 'Daftar User' ? ' active' : '' }}" href="{{route('admin.user')}}">Daftar User</a></li>
                        <li><a class="slide-item{{ $titlePage == 'Tambah User' ? ' active' : '' }}" href="{{route('admin.tambahuser')}}">Tambah User</a></li>
                    </ul>
                </li>

                <li class="side-item side-item-category">Kategori dan Layanan</li>
{{--                kategori--}}
                <li class="slide{{ ($titlePage == 'Daftar Kategori' || $titlePage == 'Tambah Kategori') ? ' is-expanded' : '' }}">
                    <a class="side-menu__item{{ ($titlePage == 'Daftar Kategori' || $titlePage == 'Tambah Kategori') ? ' active' : '' }}" data-bs-toggle="slide" href="javascript:void(0);">
                        <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M5.5,9A1.5,1.5 0 0,0 7,7.5A1.5,1.5 0 0,0 5.5,6A1.5,1.5 0 0,0 4,7.5A1.5,1.5 0 0,0 5.5,9M17.41,11.58C17.77,11.94 18,12.44 18,13C18,13.55 17.78,14.05 17.41,14.41L12.41,19.41C12.05,19.77 11.55,20 11,20C10.45,20 9.95,19.78 9.58,19.41L2.59,12.42C2.22,12.05 2,11.55 2,11V6C2,4.89 2.89,4 4,4H9C9.55,4 10.05,4.22 10.41,4.58L17.41,11.58M13.54,5.71L14.54,4.71L21.41,11.58C21.78,11.94 22,12.45 22,13C22,13.55 21.78,14.05 21.42,14.41L16.04,19.79L15.04,18.79L20.75,13L13.54,5.71Z"/>
                        </svg>
                        <span class="side-menu__label">Data Kategori</span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a href="javascript:void(0);">Data Kategori</a></li>
                        <li><a class="slide-item{{ $titlePage == 'Daftar Kategori' ? ' active' : '' }}" href="{{route('admin.kategori')}}">Daftar Kategori</a></li>
                        <li><a class="slide-item{{ $titlePage == 'Tambah Kategori' ? ' active' : '' }}" href="{{route('admin.tambahkategori')}}">Tambah Kategori</a></li>
                    </ul>
                </li>
{{--                layanan--}}
                <li class="slide{{ ($titlePage == 'Daftar Layanan'|| $titlePage == 'Tambah Layanan') ? ' is-expanded' : '' }}">
                    <a class="side-menu__item{{ ($titlePage == 'Daftar Layanan'|| $titlePage == 'Tambah Layanan'|| $titlePage == 'Edit Layanan') ? ' active' : '' }}" data-bs-toggle="slide" href="javascript:void(0);">
                        <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M19.35,10.03C18.67,6.59 15.64,4 12,4C9.11,4 6.6,5.64 5.35,8.03C2.34,8.36 0,10.9 0,14A6,6 0 0,0 6,20H19A5,5 0 0,0 24,15C24,12.36 21.95,10.22 19.35,10.03Z"/>
                        </svg>
                        <span class="side-menu__label">Data Layanan</span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a href="javascript:void(0);">Data Layanan</a></li>
                        <li><a class="slide-item{{ $titlePage == 'Daftar Layanan' ? ' active' : '' }}" href="{{route('admin.layanan')}}">Daftar Layanan</a></li>
                        <li><a class="slide-item{{ $titlePage == 'Tambah Layanan' ? ' active' : '' }}" href="{{route('admin.tambahlayanan')}}">Tambah Layanan</a></li>
                    </ul>
                </li>

                <li class="side-item side-item-category">Langganan dan Pemesanan</li>
                {{--                langganan--}}
                <li class="slide{{ ($titlePage == 'Daftar langganan') ? ' is-expanded' : '' }}">
                    <a class="side-menu__item{{ ($titlePage == 'Daftar langganan') ? ' active' : '' }}" href="{{ route('admin.langganan') }}" data-bs-toggle="slide">
                        <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M11.86,2L11.34,3.93C15.75,4.78 19.2,8.23 20.05,12.65L22,12.13C20.95,7.03 16.96,3.04 11.86,2M10.82,5.86L10.3,7.81C13.34,8.27 15.72,10.65 16.18,13.68L18.12,13.16C17.46,9.44 14.55,6.5 10.82,5.86M3.72,9.69C3.25,10.73 3,11.86 3,13C3,14.95 3.71,16.82 5,18.28V22H8V20.41C8.95,20.8 9.97,21 11,21C12.14,21 13.27,20.75 14.3,20.28L3.72,9.69M9.79,9.76L9.26,11.72A3,3 0 0,1 12.26,14.72L14.23,14.2C14,11.86 12.13,10 9.79,9.76Z"/>
                        </svg>
                        <span class="side-menu__label">Daftar Langganan</span>
                    </a>
                </li>
                {{--                pemesanan--}}
                <li class="slide{{ ($titlePage == 'Form Pemesanan') ? ' is-expanded' : '' }}">
                    <a class="side-menu__item{{ ($titlePage == 'Form Pemesanan') ? ' active' : '' }}" href="{{ route('admin.form_pemesanan') }}" data-bs-toggle="slide">
                        <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M21.04 13.13C21.18 13.13 21.31 13.19 21.42 13.3L22.7 14.58C22.92 14.79 22.92 15.14 22.7 15.35L21.7 16.35L19.65 14.3L20.65 13.3C20.76 13.19 20.9 13.13 21.04 13.13M19.07 14.88L21.12 16.93L15.06 23H13V20.94L19.07 14.88M3 7V5H5V4C5 2.89 5.9 2 7 2H13V9L15.5 7.5L18 9V2H19C20.05 2 21 2.95 21 4V10L11 20V22H7C5.95 22 5 21.05 5 20V19H3V17H5V13H3V11H5V7H3M5 7H7V5H5V7M5 11V13H7V11H5M5 17V19H7V17H5Z"/>
                        </svg>
                        <span class="side-menu__label">Form Pemesanan</span>
                    </a>
                </li>

                {{--invoice--}}
                <li class="side-item side-item-category">invoice</li>
                <li class="slide{{ $titlePage == 'Daftar Invoice' ? ' is-expanded' : '' }}">
                    <a class="side-menu__item{{ $titlePage == 'Daftar Invoice' ? ' active' : '' }}" href="{{ route('admin.invoice') }}">
                        <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M3,22L4.5,20.5L6,22L7.5,20.5L9,22L10.5,20.5L12,22L13.5,20.5L15,22L16.5,20.5L18,22L19.5,20.5L21,22V2L19.5,3.5L18,2L16.5,3.5L15,2L13.5,3.5L12,2L10.5,3.5L9,2L7.5,3.5L6,2L4.5,3.5L3,2M18,9H6V7H18M18,13H6V11H18M18,17H6V15H18V17Z"/>
                        </svg>
                        <span class="side-menu__label">Daftar Invoice</span>
                    </a>
                </li>
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg></div>
        </div>
    </aside>
</div>
<!-- main-sidebar -->
