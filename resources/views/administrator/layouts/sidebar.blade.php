<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a
                href="/">{{ array_key_exists('nama_app_admin', $settings) ? $settings['nama_app_admin'] : '' }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">
                <?php
                $namaText = array_key_exists('nama_app_admin', $settings) ? $settings['nama_app_admin'] : '';
                $twoInitialChars = strtoupper(substr($namaText, 0, 2));
                echo $twoInitialChars;
                ?>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Route::is('admin.dashboard*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.dashboard')}}"><i class="fas fa-columns"></i><span>Dashboard</span></a></li>
            <li class="menu-header">Menu</li>
            <li class="dropdown {{ Route::is('admin.kategori_project*', 'admin.service*', 'admin.kategori_blog*', 'admin.about*', 'admin.banner*', 'admin.contact*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-database"></i>
                    <span>Data Master</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Route::is('admin.banner*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.banner')}}">Banner</a></li>
                    <li class="{{ Route::is('admin.service*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.service')}}">Service</a></li>
                    <li class="{{ Route::is('admin.about*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.about')}}">About</a></li>
                    <li class="{{ Route::is('admin.contact*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.contact')}}">Contact</a></li>
                    <li class="{{ Route::is('admin.kategori_project*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.kategori_project')}}">Kategori Project</a></li>
                    <li class="{{ Route::is('admin.kategori_blog*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.kategori_blog')}}">Kategori Blog</a></li>
                </ul>
            </li>
            <li class="dropdown {{ Route::is('admin.project*', 'admin.komentar_project*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-tasks"></i>
                    <span>Portofolio</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Route::is('admin.project*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.project')}}">Project</a></li>
                    <li class="{{ Route::is('admin.komentar_project*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.komentar_project')}}">Komentar</a></li>
                </ul>
            </li>
            <li class="dropdown {{ Route::is('admin.blog*', 'admin.komentar_blog*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-newspaper"></i>
                    <span>Blog</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Route::is('admin.blog*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.blog')}}">Post</a></li>
                    <li class="{{ Route::is('admin.komentar_blog*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.komentar_blog')}}">Komentar</a></li>
                </ul>
            </li>
            <li class="{{ Route::is('admin.gallery*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.gallery')}}"><i class="fas fa-images"></i> <span>Gallery</span></a></li>
            <li class="{{ Route::is('admin.client*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.client')}}"><i class="fas fa-money-bill-wave"></i> <span>Client</span></a></li>
            <li class="dropdown {{ Route::is('admin.users*','admin.user_groups*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users-cog"></i>
                    <span>User Management</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Route::is('admin.user_groups*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.user_groups')}}">User Group</a></li>
                    <li class="{{ Route::is('admin.users*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.users')}}">User</a></li>
                </ul>
            </li>
            <li class="dropdown {{ Route::is('admin.logSystems*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-bezier-curve"></i>
                    <span>Systems</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Route::is('admin.logSystems*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.logSystems')}}">Logs</a></li>
                </ul>
            </li>
            <li class="{{ Route::is('admin.profile*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.profile',(auth()->user() ? auth()->user()->kode : ""))}}"><i class="fas fa-solid fa-user"></i> <span>Profile</span></a></li>
            <li class="dropdown {{ Route::is('admin.settings*','admin.module*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-cogs"></i> <span>Settings</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Route::is('admin.settings*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.settings')}}">Menu Settings</a></li>
                    <li class="{{ Route::is('admin.module*') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.module')}}">Module Management</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
