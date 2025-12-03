   <nav class="pc-sidebar">
       <div class="navbar-wrapper">
           <div class="m-header flex items-center py-4 px-6 h-header-height">
               <a href="../dashboard/index.html" class="b-brand flex items-center gap-3">
                   <!-- ========   Change your logo from here   ============ -->
                   <span class="text-2xl font-bold text-white">APP FLOW TRACK</span>
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
                   <li class="pc-item pc-caption">
                       <label>Data Master</label>
                       <i data-feather="feather"></i>
                   </li>
                   <li class="pc-item pc-hasmenu">
                       <a href="{{ route('karyawan.index') }}" class="pc-link">
                           <span class="pc-micon"> <i data-feather="users"></i></span>
                           <span class="pc-mtext">Karyawan</span>
                       </a>
                   </li>
                   <li class="pc-item pc-hasmenu">
                       <a href="{{ route('bahan.baku.index') }}" class="pc-link">
                           <span class="pc-micon"> <i data-feather="more-horizontal"></i></span>
                           <span class="pc-mtext">Bahan Produksi</span>
                       </a>
                   </li>
                   <li class="pc-item pc-hasmenu">
                       <a href="{{ route('set-role.index') }}" class="pc-link">
                           <span class="pc-micon"> <i data-feather="user-check"></i></span>
                           <span class="pc-mtext">Set Role</span>
                       </a>
                   </li>

                   <li class="pc-item pc-caption">
                       <label>Data Pesanan</label>
                       <i data-feather="feather"></i>
                   </li>
                   <li class="pc-item pc-hasmenu">
                       <a href="{{ route('pesanan.index') }}" class="pc-link">
                           <span class="pc-micon"> <i data-feather="shopping-cart"></i></span>
                           <span class="pc-mtext">Pesanan</span>
                       </a>
                   </li>

                   <li class="pc-item pc-caption">
                       <label>Data Produksi</label>
                       <i data-feather="feather"></i>
                   </li>
                   <li class="pc-item pc-hasmenu">
                       <a href="{{ route('produksi.index') }}" class="pc-link">
                           <span class="pc-micon"> <i data-feather="codepen"></i></span>
                           <span class="pc-mtext">Proses Produksi</span>
                       </a>
                   </li>

                   {{-- Laporan Menu --}}
                   <li class="pc-item pc-caption">
                       <label>Laporan</label>
                       <i data-feather="monitor"></i>
                   </li>
                   <li class="pc-item pc-hasmenu">
                       <a href="#" class="pc-link" target="_blank">
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
