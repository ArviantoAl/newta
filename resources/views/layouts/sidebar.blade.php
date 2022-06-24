<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">User</li>
            @if($titlePage == 'Daftar User'|| $titlePage == 'Tambah User')
                <li class="nav-item dropdown active">
            @else
                <li class="nav-item dropdown">
            @endif
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>Data User</span></a>
                <ul class="dropdown-menu">
                    @if($titlePage == 'Daftar User')
                        <li class="active">
                    @else
                        <li>
                    @endif
                    <a class="nav-link" href="{{route('admin.user')}}">Daftar User</a></li>
                        @if($titlePage == 'Tambah User')
                            <li class="active">
                        @else
                            <li>
                        @endif
                    <a class="nav-link" href="{{route('admin.tambahuser')}}">Tambah User</a></li>
                </ul>
            </li>

            <li class="menu-header">Layanan dan Kategori</li>
                @if($titlePage == 'Daftar Kategori'|| $titlePage == 'Tambah Kategori')
                    <li class="nav-item dropdown active">
                @else
                    <li class="nav-item dropdown">
                @endif
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-tag"></i> <span>Kategori</span></a>
                <ul class="dropdown-menu">
                    @if($titlePage == 'Daftar Kategori')
                        <li class="active">
                    @else
                        <li>
                    @endif
                    <a class="nav-link" href="{{route('admin.kategori')}}">Daftar Kategori</a></li>
                        @if($titlePage == 'Tambah Kategori')
                            <li class="active">
                        @else
                            <li>
                        @endif
                    <a class="nav-link" href="{{route('admin.tambahkategori')}}">Tambah Kategori</a></li>
                </ul>
            </li>
                    @if($titlePage == 'Daftar Layanan'|| $titlePage == 'Tambah Layanan'|| $titlePage == 'Edit Layanan')
                        <li class="nav-item dropdown active">
                    @else
                        <li class="nav-item dropdown">
                    @endif
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-cloud"></i> <span>Layanan</span></a>
                <ul class="dropdown-menu">
                    @if($titlePage == 'Daftar Layanan')
                        <li class="active">
                    @else
                        <li>
                    @endif
                    <a class="nav-link" href="{{route('admin.layanan')}}">Daftar Layanan</a></li>
                        @if($titlePage == 'Tambah Layanan')
                            <li class="active">
                        @else
                            <li>
                        @endif
                    <a class="nav-link" href="{{route('admin.tambahlayanan')}}">Tambah Layanan</a></li>
                </ul>
            </li>

            <li class="menu-header">Langganan dan Invoice</li>
                @if($titlePage == 'Daftar Langganan')
                    <li class="nav-item dropdown active">
                @else
                    <li class="nav-item dropdown">
                @endif
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-satellite-dish"></i> <span>Langganan</span></a>
                <ul class="dropdown-menu">
                    @if($sub == 'Semua Langganan')
                        <li class="active">
                    @else
                        <li>
                    @endif
                    <a href="{{ route('admin.langganan') }}">Semua Langganan</a></li>
                        @if($sub == 'Langganan Baru')
                            <li class="active">
                        @else
                            <li>
                        @endif
                    <a href="{{ route('admin.langgananbaru') }}">Baru</a></li>
                            @if($sub == 'Langganan Disetujui')
                                <li class="active">
                            @else
                                <li>
                            @endif
                    <a href="{{ route('admin.langganansetuju') }}">Disetujui</a></li>
                                @if($sub == 'Langganan Menunggu Pembayaran')
                                    <li class="active">
                                @else
                                    <li>
                                @endif
                    <a href="{{ route('admin.langgananmenunggu') }}">Menunggu Pembayaran</a></li>
                                    @if($sub == 'Langganan Aktif')
                                        <li class="active">
                                    @else
                                        <li>
                                    @endif
                    <a href="{{ route('admin.langgananaktif') }}">Aktif</a></li>
                                        @if($sub == 'Langganan Kadaluarsa')
                                            <li class="active">
                                        @else
                                            <li>
                                        @endif
                    <a href="{{ route('admin.langganankadaluarsa') }}">Kadaluarsa</a></li>
                                            @if($sub == 'Langganan Batal')
                                                <li class="active">
                                            @else
                                                <li>
                                            @endif
                    <a href="{{ route('admin.langgananbatal') }}">Batal</a></li>
                </ul>
            </li>
                            @if($titlePage == 'Daftar Invoice')
                                <li class="nav-item dropdown active">
                            @else
                                <li class="nav-item dropdown">
                            @endif
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-file-invoice"></i> <span>Invoice</span></a>
                <ul class="dropdown-menu">
                    @if($sub == 'Semua Invoice')
                        <li class="active">
                    @else
                        <li>
                    @endif
                    <a href="{{ route('admin.invoice') }}">Semua Invoice</a></li>
                        @if($sub == 'Invoice Belum Dikirim')
                            <li class="active">
                        @else
                            <li>
                        @endif
                    <a href="{{ route('admin.inv_belumkirim') }}">Belum Dikirim</a></li>
                            @if($sub == 'Invoice Melebihi Batas Pembayaran')
                                <li class="active">
                            @else
                                <li>
                            @endif
                    <a href="{{ route('admin.inv_melebihibatas') }}">Melebihi Batas Bayar</a></li>
                                @if($sub == 'Invoice Menunggu Pembayaran')
                                    <li class="active">
                                @else
                                    <li>
                                @endif
                    <a href="{{ route('admin.inv_menunggu') }}">Menunggu Pembayaran</a></li>
                                    @if($sub == 'Invoice Lunas')
                                        <li class="active">
                                    @else
                                        <li>
                                    @endif
                    <a href="{{ route('admin.inv_lunas') }}">Lunas</a></li>
                                        @if($sub == 'Invoice Tidak Dibayar/Batal')
                                            <li class="active">
                                        @else
                                            <li>
                                        @endif
                    <a href="{{ route('admin.inv_batal') }}">Tidak Dibayar/Batal</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
