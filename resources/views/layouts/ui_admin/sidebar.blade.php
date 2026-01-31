        <aside class="left-sidebar">
              <div>
                <div class="brand-logo d-flex align-items-center justify-content-between px-4 py-3">
          <a href="{{ route('admin.dashboard') }}" class="logo-img d-flex align-items-center">
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
                href="{{route('admin.dashboard')}}" aria-expanded="false">
                <div class="d-flex align-items-center gap-6">
                  <span class="d-flex">
                    <iconify-icon icon="solar:home-smile-line-duotone"></iconify-icon>  
                  </span>
                  <span class="hide-menu">Beranda</span>
                </div>
              </a>
            </li>
           <li class="sidebar-item">
              <a class="sidebar-link primary-hover-bg justify-content-between"
                href="{{ route('admin.category.index') }}" aria-expanded="false">
                  <div class="d-flex align-items-center gap-6">
                      <span class="d-flex">
                          <iconify-icon icon="solar:layers-line-duotone"></iconify-icon>
                      </span>
                      <span class="hide-menu">Kategori</span>
                  </div>
              </a>
          </li>

          <li class="sidebar-item">
              <a class="sidebar-link primary-hover-bg justify-content-between"
                href="{{ auth()->check() ? route('admin.typecategory.index') : route('login') }}" aria-expanded="false">
                  <div class="d-flex align-items-center gap-6">
                      <span class="d-flex">
                          <iconify-icon icon="solar:widget-line-duotone"></iconify-icon>
                      </span>
                      <span class="hide-menu">Sub kategori</span>
                  </div>
              </a>
          </li>

          <li class="sidebar-item">
              <a class="sidebar-link primary-hover-bg justify-content-between"
                href="{{ route('admin.user.index') }}" aria-expanded="false">
                  <div class="d-flex align-items-center gap-6">
                      <span class="d-flex">
                          <iconify-icon icon="solar:users-group-rounded-line-duotone"></iconify-icon>
                      </span>
                      <span class="hide-menu">User</span>
                  </div>
              </a>
          </li>

          <li class="sidebar-item">
              <a class="sidebar-link primary-hover-bg justify-content-between"
                href="{{ route('admin.user.posts') }}" aria-expanded="false">
                  <div class="d-flex align-items-center gap-6">
                      <span class="d-flex">
                          <iconify-icon icon="solar:gallery-wide-line-duotone"></iconify-icon>
                      </span>
                      <span class="hide-menu">Postingan</span>
                  </div>
              </a>
          </li>

          <li class="sidebar-item">
              <a class="sidebar-link primary-hover-bg justify-content-between"
                href="#" aria-expanded="false">
                  <div class="d-flex align-items-center gap-6">
                      <span class="d-flex">
                          <iconify-icon icon="solar:chat-round-line-duotone"></iconify-icon>
                      </span>
                      <span class="hide-menu">Komentar</span>
                  </div>
              </a>
          </li>

          <li class="sidebar-item">
              <a class="sidebar-link primary-hover-bg justify-content-between"
                href="{{ route('admin.report.post') }}" aria-expanded="false">
                  <div class="d-flex align-items-center gap-6">
                      <span class="d-flex">
                          <iconify-icon icon="solar:flag-line-duotone"></iconify-icon>
                      </span>
                      <span class="hide-menu">Report Postingan</span>
                  </div>
              </a>
          </li>

          <li class="sidebar-item">
              <a class="sidebar-link primary-hover-bg justify-content-between"
                href="{{ route('admin.report.comment') }}" aria-expanded="false">
                  <div class="d-flex align-items-center gap-6">
                      <span class="d-flex">
                          <iconify-icon icon="solar:flag-2-line-duotone"></iconify-icon>
                      </span>
                      <span class="hide-menu">Report Komentar</span>
                  </div>
              </a>
          </li>

          </ul>
        </nav>
      </div>
    </aside>