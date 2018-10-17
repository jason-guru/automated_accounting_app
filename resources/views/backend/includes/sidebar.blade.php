<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('menus.backend.sidebar.general')
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard'), 'open') }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon icon-speedometer"></i> @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>
            @if($logged_in_user->isAdmin())
            {{-- The clients section --}}
            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/clients*'), 'open') }} {{ active_class(Active::checkUriPattern('admin/client*'), 'open') }}">
                <a href="#" class="nav-link nav-dropdown-toggle">
                    <i class="nav-icon icon-people"></i> @lang('menus.backend.sidebar.clients')
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-items">
                        <a href="{{ route('admin.clients.index') }}" class="nav-link {{ active_class(Active::checkUriPattern('admin/clients')) }}">
                            Clients
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/deadlines*'), 'open') }}">
                <a href="#" class="nav-link nav-dropdown-toggle">
                    <i class="nav-icon icon-cursor"></i> Deadlines
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-items">
                        <a href="{{ route('admin.deadlines.index') }}" class="nav-link {{ active_class(Active::checkUriPattern('admin/deadlines')) }}">
                            Manage Deadlines
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/reminders*'), 'open') }}">
                <a href="#" class="nav-link nav-dropdown-toggle">
                    <i class="nav-icon icon-clock"></i> Reminders
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-items">
                        <a href="{{ route('admin.reminders.index') }}" class="nav-link {{ active_class(Active::checkUriPattern('admin/reminders')) }}">
                            Manage Reminders
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/message-formats*'), 'open') }}">
                <a href="#" class="nav-link nav-dropdown-toggle">
                    <i class="nav-icon icon-envelope"></i>Formats
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-items">
                        <a href="{{ route('admin.message-formats.index') }}" class="nav-link {{ active_class(Active::checkUriPattern('admin/message-formats')) }}">
                            Manage Formats
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            <li class="nav-title">
                @lang('menus.backend.sidebar.system')
            </li>

            @if ($logged_in_user->isAdmin())
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth*')) }}" href="#">
                        <i class="nav-icon icon-user"></i> @lang('menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user*')) }}" href="{{ route('admin.auth.user.index') }}">
                                @lang('labels.backend.access.users.management')

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}" href="{{ route('admin.auth.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            <li class="divider"></li>

            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/log-viewer*')) }}" href="#">
                    <i class="nav-icon icon-list"></i> @lang('menus.backend.log-viewer.main')
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}" href="{{ route('log-viewer::dashboard') }}">
                            @lang('menus.backend.log-viewer.dashboard')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}" href="{{ route('log-viewer::logs.list') }}">
                            @lang('menus.backend.log-viewer.logs')
                        </a>
                    </li>
                </ul>
            </li>
            
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
