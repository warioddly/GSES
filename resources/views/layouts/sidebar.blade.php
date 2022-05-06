<ul class="nav nav-list">
    <li>
        <div class="left-bg"></div>
    </li>
    <li class="time">
        <h1 class="animated fadeInLeft">21:00</h1>
        <p class="animated fadeInRight">Sat,October 1st 2029</p>
    </li>
    <li class="ripple {{request()->routeIs('dashboard')?'active':''}}">
        <a href="{{route('dashboard')}}"><span class="fas fa-tachometer-alt"></span> {{__('Dashboard')}}</a>
    </li>
    @can('expertise-list')
        <li class="ripple {{request()->routeIs('expertise.*')?'active':''}}">
            <a href="{{route('expertise.index')}}"><span class="fas fa-flask"></span> {{__('Expertise')}}</a>
        </li>
    @endcan
    @can('material-list')
        <li class="ripple {{request()->routeIs('materials.*')?'active':''}}">
            <a href="{{route('materials.index')}}"><span class="fas fa-swatchbook"></span> {{__('Materials')}}</a>
        </li>
    @endcan
    @canany(['contractor-list', 'marker-word-list', 'template-list', 'report-list'])
        <li class="ripple {{request()->routeIs('modules.*')?'active':''}}">
            <a class="tree-toggle nav-header">
                <span class="fa fa-th"></span> {{__('Modules')}} <span
                        class="fa-angle-right fa right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
                @can('contractor-list')
                    <li class="ripple {{request()->routeIs('modules.contractors.*')?'active':''}}">
                        <a href="{{route('modules.contractors.index')}}">{{__('Counterparties')}}</a>
                    </li>
                @endcan
                @can('subject-list')
                    <li class="ripple {{request()->routeIs('modules.subjects.*')?'active':''}}">
                        <a href="{{route('modules.subjects.index')}}">{{__('Subjects')}}</a>
                    </li>
                @endcan
                @can('nickname-list')
                    <li class="ripple {{request()->routeIs('modules.nicknames.*')?'active':''}}">
                        <a href="{{route('modules.nicknames.index')}}">{{__('Subject alias')}}</a>
                    </li>
                @endcan
                @can('expertise_article-list')
                    <li class="ripple {{request()->routeIs('modules.expertiseArticles.*')?'active':''}}">
                        <a href="{{route('modules.expertiseArticles.index')}}">{{__('Expertise articles')}}</a>
                    </li>
                @endcan
                @can('marker-word-list')
                    <li class="ripple {{request()->routeIs('modules.marker_words.*')?'active':''}}">
                        <a href="{{route('modules.marker_words.index')}}">{{__('Marker words')}}</a>
                    </li>
                @endcan
                @can('template-list')
                    <li class="ripple {{request()->routeIs('modules.templates.*')?'active':''}}">
                        <a href="{{route('modules.templates.index')}}">{{__('Templates')}}</a>
                    </li>
                @endcan
                @can('report-list')
                    <li class="ripple {{request()->routeIs('modules.reports.*')?'active':''}}">
                        <a href="{{route('modules.reports.index')}}">{{__('Reports')}}</a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcanany
    @canany(['user-list', 'role-list'])
        <li class="ripple {{request()->routeIs('security.*')?'active':''}}">
            <a class="tree-toggle nav-header">
                <span class="fa fa-shield-alt"></span> {{__('Security')}} <span
                        class="fa-angle-right fa right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
                @can('user-list')
                    <li class="ripple {{request()->routeIs('security.users.*')?'active':''}}">
                        <a href="{{route('security.users.index')}}"><span class="fas fa-users"></span> {{__('Users')}}
                        </a>
                    </li>
                @endcan
                @can('role-list')
                    <li class="ripple {{request()->routeIs('security.roles.*')?'active':''}}">
                        <a href="{{route('security.roles.index')}}"><span
                                    class="fas fa-user-tag"></span> {{__('Roles')}}</a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcanany
    @canany(['language-list', 'setting-report-list'])
        <li class="ripple {{request()->routeIs('settings.*')?'active':''}}">
            <a class="tree-toggle nav-header">
                <span class="fa fa-cogs"></span> {{__('Settings')}} <span
                        class="fa fa-angle-right right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
                @can('language-list')
                    <li class="ripple {{request()->routeIs('languages.*')?'active':''}}">
                        <a href="{{route('languages.index')}}">{{__('Languages')}}</a>
                    </li>
                @endcan
                @can('setting-report-list')
                    <li class="ripple {{request()->routeIs('settings.reports.*')?'active':''}}">
                        <a href="{{route('settings.reports.index')}}">{{__('Reports')}}</a>
                    </li>
                @endcan
                @can('queue-monitor')
                    <li class="ripple {{request()->routeIs('queue-monitor::*')?'active':''}}">
                        <a href="{{route('queue-monitor::index')}}">{{__('Queue Monitor')}}</a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcanany
</ul>
