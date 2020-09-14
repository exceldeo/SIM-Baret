<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow px-15">
            <!-- Mini Mode -->
            <div class="content-header-section sidebar-mini-visible-b">
                <!-- Logo -->
                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                    <span class="text-dual-primary-dark">c</span><span class="text-primary">b</span>
                </span>
                <!-- END Logo -->
            </div>
            <!-- END Mini Mode -->

            <!-- Normal Mode -->
            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                <!-- END Close Sidebar -->

                <!-- Logo -->
                <div class="content-header-item">
                    <a class="font-w700" href="{{route('dashboard.index')}}">
                        {{-- <i class="si si-pencil text-primary"></i> --}}
                        <img src="https://presensi.its.ac.id/assets/media/img/myits-academics.png" alt="Logo ITS" height="40px" class="mr-5">
                        <span class="font-size-l text-dual-primary-dark">Online</span><span class="font-size-xl text-primary">Test</span>
                    </a>
                </div>
                <!-- END Logo -->
            </div>
            <!-- END Normal Mode -->
        </div>
        <!-- END Side Header -->

        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <li>
                    <a href="{{route('dashboard.index')}}"><i class="si si-cup"></i><span class="sidebar-mini-hide">Dashboard</span></a>
                </li>
                <li>
                    <a href="{{route('test_scenario.index')}}"><i class="si si-doc"></i><span class="sidebar-mini-hide">Test Scenario</span></a>
                </li>
                <li>
                    <a href="{{route('dashboard.question_package.scenario')}}"><i class="si si-notebook"></i><span class="sidebar-mini-hide">Question Bank</span></a>
                </li>
                <li>
                    <a href="{{route('schedule.index')}}"><i class="si si-pencil"></i><span class="sidebar-mini-hide">Test</span></a>
                </li>
                <li>
                    <a href="{{route('dashboard.role.all')}}"><i class="si si-user"></i><span class="sidebar-mini-hide">User Management</span></a>
                </li>
                <li>
                    <a href="{{route('participant.login')}}"><i class="si si-login"></i><span class="sidebar-mini-hide">Participant Login</span></a>
                </li>
                {{-- <li>
                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-pencil"></i><span class="sidebar-mini-hide">Test Question</span></a>
                    <ul>
                        <li>
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><span class="sidebar-mini-hide">Dashboards</span></a>
                            <ul>
                                <li>
                                    <a href="be_pages_dashboard2.html"><span class="sidebar-mini-hide">Dashboard 2</span></a>
                                </li>
                                <li>
                                    <a href="be_pages_dashboard3.html"><span class="sidebar-mini-hide">Dashboard 3</span></a>
                                </li>
                                <li>
                                    <a href="be_pages_dashboard4.html"><span class="sidebar-mini-hide">Dashboard 4</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- Sidebar Content -->
</nav>
