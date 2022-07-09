<ul class="nav nav-list">
    <li>
        <div class="left-bg"></div>
    </li>
    <li class="time">
        <h1 class="animated fadeInLeft">21:00</h1>
        <p class="animated fadeInRight">Sat,October 1st 2029</p>
    </li>
    <li class="ripple <?php echo e(request()->routeIs('dashboard')?'active':''); ?>">
        <a href="<?php echo e(route('dashboard')); ?>"><span class="fas fa-tachometer-alt"></span> <?php echo e(__('Dashboard')); ?></a>
    </li>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('expertise-list')): ?>
        <li class="ripple <?php echo e(request()->routeIs('expertise.*')?'active':''); ?>">
            <a href="<?php echo e(route('expertise.index')); ?>"><span class="fas fa-flask"></span> <?php echo e(__('Expertise')); ?></a>
        </li>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('material-list')): ?>
        <li class="ripple <?php echo e(request()->routeIs('materials.*')?'active':''); ?>">
            <a href="<?php echo e(route('materials.index')); ?>"><span class="fas fa-swatchbook"></span> <?php echo e(__('Materials')); ?></a>
        </li>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['contractor-list', 'marker-word-list', 'template-list', 'report-list'])): ?>
        <li class="ripple <?php echo e(request()->routeIs('modules.*')?'active':''); ?>">
            <a class="tree-toggle nav-header">
                <span class="fa fa-th"></span> <?php echo e(__('Modules')); ?> <span
                        class="fa-angle-right fa right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contractor-list')): ?>
                    <li class="ripple <?php echo e(request()->routeIs('modules.contractors.*')?'active':''); ?>">
                        <a href="<?php echo e(route('modules.contractors.index')); ?>"><?php echo e(__('Counterparties')); ?></a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subject-list')): ?>
                    <li class="ripple <?php echo e(request()->routeIs('modules.subjects.*')?'active':''); ?>">
                        <a href="<?php echo e(route('modules.subjects.index')); ?>"><?php echo e(__('Subjects')); ?></a>
                    </li>
                <?php endif; ?>





                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('expertise_article-list')): ?>
                    <li class="ripple <?php echo e(request()->routeIs('modules.expertiseArticles.*')?'active':''); ?>">
                        <a href="<?php echo e(route('modules.expertiseArticles.index')); ?>"><?php echo e(__('Expertise articles')); ?></a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('marker-word-list')): ?>
                    <li class="ripple <?php echo e(request()->routeIs('modules.marker_words.*')?'active':''); ?>">
                        <a href="<?php echo e(route('modules.marker_words.index')); ?>"><?php echo e(__('Marker words')); ?></a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('template-list')): ?>
                    <li class="ripple <?php echo e(request()->routeIs('modules.templates.*')?'active':''); ?>">
                        <a href="<?php echo e(route('modules.templates.index')); ?>"><?php echo e(__('Templates')); ?></a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-list')): ?>
                    <li class="ripple <?php echo e(request()->routeIs('modules.reports.*')?'active':''); ?>">
                        <a href="<?php echo e(route('modules.reports.index')); ?>"><?php echo e(__('Reports')); ?></a>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['user-list', 'role-list'])): ?>
        <li class="ripple <?php echo e(request()->routeIs('security.*')?'active':''); ?>">
            <a class="tree-toggle nav-header">
                <span class="fa fa-shield-alt"></span> <?php echo e(__('Security')); ?> <span
                        class="fa-angle-right fa right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-list')): ?>
                    <li class="ripple <?php echo e(request()->routeIs('security.users.*')?'active':''); ?>">
                        <a href="<?php echo e(route('security.users.index')); ?>"><span class="fas fa-users"></span> <?php echo e(__('Users')); ?>

                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-list')): ?>
                    <li class="ripple <?php echo e(request()->routeIs('security.roles.*')?'active':''); ?>">
                        <a href="<?php echo e(route('security.roles.index')); ?>"><span
                                    class="fas fa-user-tag"></span> <?php echo e(__('Roles')); ?></a>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['language-list', 'setting-report-list'])): ?>
        <li class="ripple <?php echo e(request()->routeIs('settings.*')?'active':''); ?>">
            <a class="tree-toggle nav-header">
                <span class="fa fa-cogs"></span> <?php echo e(__('Settings')); ?> <span
                        class="fa fa-angle-right right-arrow text-right"></span>
            </a>
            <ul class="nav nav-list tree">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('language-list')): ?>
                    <li class="ripple <?php echo e(request()->routeIs('languages.*')?'active':''); ?>">
                        <a href="<?php echo e(route('languages.index')); ?>"><?php echo e(__('Languages')); ?></a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting-report-list')): ?>
                    <li class="ripple <?php echo e(request()->routeIs('settings.reports.*')?'active':''); ?>">
                        <a href="<?php echo e(route('settings.reports.index')); ?>"><?php echo e(__('Reports')); ?></a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('queue-monitor')): ?>
                    <li class="ripple <?php echo e(request()->routeIs('queue-monitor::*')?'active':''); ?>">
                        <a href="<?php echo e(route('queue-monitor::index')); ?>"><?php echo e(__('Queue Monitor')); ?></a>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>
</ul>
<?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.2\GSES 2.0\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>