 @php
     use Illuminate\Support\Facades\Auth;
 @endphp
 <nav class="pc-sidebar">
     <div class="navbar-wrapper">
         <div class="m-header items-center py-4 px-6 h-header-height mb-4">
             <a href="{{ url('/dashboard') }}" class="b-brand flex items-center gap-3">
                 <!-- ========   Change your logo from here   ============ -->
                 <div class="flex flex-col items-center">
                     <div class="flex justify-center items-center w-full gap-4">
                         <img src="{{ asset('assets/images/logo-pabrik.png') }}" alt="Logo" class="h-20 w-20 object-contain rounded p-0.5 mx-auto">
                         <div class="flex flex-col items-start gap-0">
                             <span class="text-2xl font-bold text-white mt-2">MONITORING</span>
                             <span class="text-base font-semibold text-white mt-1">CV. Cakra Mas Jaya</span>
                         </div>
                     </div>
                 </div>
             </a>
        
         </div>
         <hr>
         <div class="navbar-content h-[calc(100vh_-_74px)] py-2.5">
             <ul class="pc-navbar">
                 <li class="pc-item pc-caption">
                     <label>Dashboard</label>
                 </li>
                 <li class="pc-item">
                 <li class="pc-item">
                     <a href="{{ url('/dashboard') }}" class="pc-link">
                         <span class="pc-micon">
                             <i class="feather icon-home" data-feather="home"></i>
                         </span>
                         <span class="pc-mtext">Dashboard</span>
                     </a>
                 </li>

                 {{-- Data Master --}}
                 @if (Auth::user()->role == 'admin' || Auth::user()->role == 'kepala_produksi')
                     <li class="pc-item pc-caption">
                         <label>User dan Pegawai</label>
                         <i data-feather="feather"></i>
                     </li>
                     <li class="pc-item pc-hasmenu">
                        <a href="{{ route('karyawan.index') }}" class="pc-link">
                            <span class="pc-micon"> <i data-feather="users"></i></span>
                            <span class="pc-mtext">Karyawan</span>
                        </a>
                    </li>
                 @endif

                 @if (Auth::user()->role == 'admin')
                     <li class="pc-item pc-hasmenu">
                        <a href="{{ route('set-role.index') }}" class="pc-link">
                            <span class="pc-micon"> <i data-feather="user-check"></i></span>
                            <span class="pc-mtext">Set Role</span>
                        </a>
                    </li>
                 @endif

                 {{-- data pesanan --}}
                 @if (Auth::user()->role == 'admin' || Auth::user()->role == 'kepala_produksi')
                     <li class="pc-item pc-caption">
                         <label>Pra Produksi</label>
                         <i data-feather="feather"></i>
                     </li>
                     <li class="pc-item pc-hasmenu">
                        <a href="{{ route('bahan.baku.index') }}" class="pc-link">
                            <span class="pc-micon"> <i data-feather="more-horizontal"></i></span>
                            <span class="pc-mtext">Bahan Produksi</span>
                        </a>
                    </li>
                     <li class="pc-item pc-hasmenu">
                         <a href="{{ route('pesanan.index') }}" class="pc-link">
                             <span class="pc-micon"> <i data-feather="shopping-cart"></i></span>
                             <span class="pc-mtext">Pesanan</span>
                         </a>
                     </li>
                 @endif

                 {{-- data produksi --}}
                 <li class="pc-item pc-caption">
                     <label>Produksi</label>
                     <i data-feather="feather"></i>
                 </li>
                 <li class="pc-item pc-hasmenu">
                     <a href="{{ route('produksi.index') }}" class="pc-link">
                         <span class="pc-micon"> <i data-feather="codepen"></i></span>
                         <span class="pc-mtext">Proses Linting</span>
                     </a>
                 </li>
                 <li class="pc-item pc-hasmenu">
                     <a href="{{ route('packing.index') }}" class="pc-link">
                         <span class="pc-micon"> <i data-feather="codepen"></i></span>
                         <span class="pc-mtext">Proses Packing</span>
                     </a>
                 </li>

                 {{-- data laporan --}}
                 <li class="pc-item pc-caption">
                     <label>Laporan</label>
                     <i data-feather="monitor"></i>
                 </li>
                 <li class="pc-item pc-hasmenu">
                     <a href="{{ route('hasil-produksi.index') }}" class="pc-link">
                         <span class="pc-micon"> <i data-feather="layers"></i></span>
                         <span class="pc-mtext">Hasil Produksi</span>
                     </a>
                 </li>

                 {{-- <li class="pc-item pc-caption">
                        <label>Other</label>
                        <i data-feather="sidebar"></i>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link"><span class="pc-micon"> <i data-feather="align-right"></i>
                            </span><span class="pc-mtext">Menu levels</span><span class="pc-arrow"><i
                                    class="ti ti-chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="#!">Level 2.1</a></li>
                            <li class="pc-item pc-hasmenu">
                                <a href="#!" class="pc-link">Level 2.2<span class="pc-arrow"><i
                                            class="ti ti-chevron-right"></i></span></a>
                                <ul class="pc-submenu">
                                    <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                                    <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                                    <li class="pc-item pc-hasmenu">
                                        <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i
                                                    class="ti ti-chevron-right"></i></span></a>
                                        <ul class="pc-submenu">
                                            <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                                            <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="pc-item pc-hasmenu">
                                <a href="#!" class="pc-link">Level 2.3<span class="pc-arrow"><i
                                            class="ti ti-chevron-right"></i></span></a>
                                <ul class="pc-submenu">
                                    <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                                    <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                                    <li class="pc-item pc-hasmenu">
                                        <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i
                                                    class="ti ti-chevron-right"></i></span></a>
                                        <ul class="pc-submenu">
                                            <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                                            <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="pc-item">
                        <a href="../other/sample-page.html" class="pc-link">
                            <span class="pc-micon">
                                <i data-feather="sidebar"></i>
                            </span>
                            <span class="pc-mtext">Sample page</span>
                        </a>
                    </li> --}}

             </ul>
         </div>
     </div>
 </nav>
