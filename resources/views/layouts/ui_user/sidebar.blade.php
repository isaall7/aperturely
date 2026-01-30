        <aside class="left-sidebar">
              <div>
                <div class="brand-logo d-flex align-items-center justify-content-between px-4 py-3">
          <a href="{{ route('user.dashboard') }}" class="logo-img d-flex align-items-center">
            <img 
              src="{{ asset('ui/images/logos/aperturely.png') }}" 
              class="img-fluid"
              style="max-height: 70px;"
              alt="Aperturely Logo"
            />
          </a>

          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <!-- <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">Home</span>
            </li> -->
            <li class="sidebar-item">
              <a class="sidebar-link primary-hover-bg justify-content-between"
                href="{{route('user.dashboard')}}" aria-expanded="false">
                <div class="d-flex align-items-center gap-6">
                  <span class="d-flex">
                    <iconify-icon icon="solar:widget-line-duotone"></iconify-icon>  
                  </span>
                  <span class="hide-menu">Beranda</span>
                </div>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link primary-hover-bg justify-content-between"
                href="{{route('user.dashboard')}}" aria-expanded="false">
                <div class="d-flex align-items-center gap-6">
                  <span class="d-flex">
                    <iconify-icon icon="solar:bell-line-duotone" class=""></iconify-icon>
                  </span>
                  <span class="hide-menu">Notifikasi</span>
                </div>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link primary-hover-bg justify-content-between"
                href="{{ auth()->check() ? route('user.postingan.create') : route('login') }}" aria-expanded="false">
                <div class="d-flex align-items-center gap-6">
                  <span class="d-flex">
                    <iconify-icon icon="solar:add-circle-line-duotone" class=""></iconify-icon>
                  </span>
                  <span class="hide-menu">Buat</span>
                </div>
              </a>
               <li class="sidebar-item">
              <a class="sidebar-link primary-hover-bg justify-content-between"
                href="https://bootstrapdemos.wrappixel.com/spike/dist/main/index2.html" aria-expanded="false">
                <div class="d-flex align-items-center gap-6">
                  <span class="d-flex">
                    <iconify-icon icon="solar:chart-line-duotone" class=""></iconify-icon>
                  </span>
                  <span class="hide-menu">Trending</span>
                </div>
              </a>
              <a class="sidebar-link primary-hover-bg justify-content-between"
                href="https://bootstrapdemos.wrappixel.com/spike/dist/main/index2.html" aria-expanded="false">
                <div class="d-flex align-items-center gap-6">
                  <span class="d-flex">
                    <iconify-icon icon="solar:compass-line-duotone" class=""></iconify-icon>
                  </span>
                  <span class="hide-menu">Eksplor</span>
                </div>
              </a>
            </li>
             <li class="sidebar-item">
              <a class="sidebar-link primary-hover-bg justify-content-between has-arrow" href="javascript:void(0)"
                aria-expanded="false">
                <div class="d-flex align-items-center gap-6">
                  <span class="d-flex">
                    <iconify-icon icon="solar:history-line-duotone"></iconify-icon>
                  </span>
                  <span class="hide-menu">Riwayat</span>
                </div>
              </a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                  <a class="sidebar-link primary-hover-bg justify-content-between"
                    href="https://bootstrapdemos.wrappixel.com/spike/dist/main/frontend-landingpage.html">
                    <div class="d-flex align-items-center gap-6">
                      <span class="d-flex">
                        <span class="ti ti-message-circle"></span>
                      </span>
                      <span class="hide-menu">Komentar</span>
                    </div>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link primary-hover-bg justify-content-between"
                    href="https://bootstrapdemos.wrappixel.com/spike/dist/main/frontend-aboutpage.html">
                    <div class="d-flex align-items-center gap-6">
                      <span class="d-flex">
                        <span class="ti ti-thumb-up"></span>
                      </span>
                      <span class="hide-menu">Menyukai</span>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </aside>