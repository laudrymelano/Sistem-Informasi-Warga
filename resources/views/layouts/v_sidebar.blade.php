  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-teal elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
          <img src="{{ asset('assets/dist/img/siaga-logo.png') }}" alt="AdminLTE Logo"
              class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-dark">SIAGA</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="info">
                  <strong style="color: black">Hello, &nbsp; <a href="javascript:void(0)">Ketua
                          {{ Auth::user()->name }}</a></strong>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  @if (auth()->user()->role == 'rt')
                      <li class="nav-item">
                          <a href="{{ url('/dashboardRT') }}"
                              class="nav-link {{ Request::is('dashboardRT') ? 'active' : null }}">
                              <i class="fas fa-tachometer-alt"></i> &nbsp;
                              <p>Dashboard</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ url('/rt/data/warga') }}"
                              class="nav-link {{ Request::is('rt/data/warga') ? 'active' : null }}">
                              <i class="fas fa-users"></i> &nbsp;
                              <p>Warga</p>
                          </a>
                      </li>
                      <li
                          class="nav-item has-treeview {{ Request::is('rt/suratMasuk') || Request::is('rt/surat/disetujui') || Request::is('rt/surat/ditolak') ? 'menu-open' : null }}">
                          <a href="#"
                              class="nav-link {{ Request::is('rt/suratMasuk') || Request::is('rt/surat/disetujui') || Request::is('rt/surat/ditolak') ? 'active' : null }}">
                              <i class="fas fa-envelope"></i>
                              <p>
                                  Surat
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ url('rt/suratMasuk') }}"
                                      class="nav-link {{ Request::is('rt/suratMasuk') ? 'active' : null }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Surat Masuk</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ url('rt/surat/disetujui') }}"
                                      class="nav-link {{ Request::is('rt/surat/disetujui') ? 'active' : null }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Surat Disetujui</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ url('rt/surat/ditolak') }}"
                                      class="nav-link {{ Request::is('rt/surat/ditolak') ? 'active' : null }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Surat Ditolak</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                      <li
                          class="nav-item has-treeview {{ Request::is('rt/voting') || Request::is('rt/voting/calon') || Request::is('rt/voting/hasil') ? 'menu-open' : null }}">
                          <a href="#"
                              class="nav-link {{ Request::is('rt/voting') || Request::is('rt/voting/calon') || Request::is('rt/voting/hasil') ? 'active' : null }}">
                              <i class="fas fa-poll"></i>
                              <p>
                                  E-Voting
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ url('rt/voting') }}"
                                      class="nav-link {{ Request::is('rt/voting') ? 'active' : null }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Buat E-Voting</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ url('rt/voting/calon') }}"
                                      class="nav-link {{ Request::is('rt/voting/calon') ? 'active' : null }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Data Calon</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ url('rt/voting/hasil') }}"
                                      class="nav-link {{ Request::is('rt/voting/hasil') ? 'active' : null }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Hasil Voting</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endif
                  @if (auth()->user()->role == 'rw')
                      <li class="nav-item">
                          <a href="{{ url('/dashboardRW') }}"
                              class="nav-link {{ Request::is('dashboardRW') ? 'active' : null }}">
                              <i class="fas fa-tachometer-alt"></i> &nbsp;
                              <p> Dashboard </p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ url('/rw/data/warga') }}"
                              class="nav-link {{ Request::is('rw/data/warga') ? 'active' : null }}">
                              <i class="fas fa-users"></i> &nbsp;
                              <p>Warga</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ url('/rw/akun/rt') }}"
                              class="nav-link {{ Request::is('rw/akun/rt') ? 'active' : null }}">
                              <i class="fas fa-user"></i> &nbsp;
                              <p>Akun RT</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ url('/berita') }}"
                              class="nav-link {{ Request::is('berita') ? 'active' : null }}">
                              <i class="far fa-newspaper"></i> &nbsp;
                              <p> Berita </p>
                          </a>
                      </li>
                      <li
                          class="nav-item has-treeview {{ Request::is('rw/suratMasuk') || Request::is('rw/surat/disetujui') || Request::is('rw/surat/ditolak') ? 'menu-open' : null }}">
                          <a href="#"
                              class="nav-link {{ Request::is('rw/suratMasuk') || Request::is('rw/surat/disetujui') || Request::is('rw/surat/ditolak') ? 'active' : null }}">
                              <i class="far fa-envelope"></i>
                              <p>
                                  Surat
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ url('rw/suratMasuk') }}"
                                      class="nav-link {{ Request::is('rw/suratMasuk') ? 'active' : null }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Surat Masuk</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ url('rw/surat/disetujui') }}"
                                      class="nav-link {{ Request::is('rw/surat/disetujui') ? 'active' : null }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Surat Disetujui</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ url('rw/surat/ditolak') }}"
                                      class="nav-link {{ Request::is('rw/surat/ditolak') ? 'active' : null }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Surat Ditolak</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endif
                  <li class="nav-item">
                      <a href="{{ url('logoutAdmin') }}" class="nav-link">
                          @csrf
                          <i class="nav-icon fas fa-sign-out-alt"></i>
                          <p>Logout</p>
                  </li>
                  </a>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
