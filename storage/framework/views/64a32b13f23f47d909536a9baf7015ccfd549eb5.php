

<?php $__env->startSection('panel'); ?>
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft"><?php echo e(__('Users Management')); ?></h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-create')): ?>
            <h3 class="animated fadeInRight"><a class="btn btn-success" href="<?php echo e(route('security.users.create')); ?>"> <?php echo e(__('Create New User')); ?></a></h3>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e($message); ?></p>
        </div>
    <?php endif; ?>
    <div class="panel">
        <div class="panel-body">
            <div class="responsive-table">
                <table class="table table-striped table-bordered" id="user-table" style="width:100%">
                <thead>
                    <tr>
                        <th data-title="<?php echo e(__('No')); ?>" width="50"><?php echo e(__('No')); ?></th>
                        <th data-title="<?php echo e(__('Name')); ?>"><?php echo e(__('Name')); ?></th>
                        <th data-title="<?php echo e(__('Position')); ?>"><?php echo e(__('Position')); ?></th>
                        <th data-title="<?php echo e(__('Email')); ?>"><?php echo e(__('Email')); ?></th>
                        <th data-title="<?php echo e(__('Roles')); ?>"><?php echo e(__('Roles')); ?></th>
                        <th data-title="<?php echo e(__('Created at')); ?>"><?php echo e(__('Created at')); ?></th>
                        <th style="width:180px;"><?php echo e(__('Action')); ?></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    $('#user-table').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": '<?php echo e(route('security.users.index')); ?>',
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'position', name: 'position'},
            {data: 'email', name: 'email'},
            {data: 'roles', name: 'roles', orderable: false, searchable: false},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "createdRow": function (row, data, rowIndex) {
            // Per-cell function to do whatever needed with cells
            $.each($('td', row), function (colIndex) {
                var $title = $('#user-table thead tr th:nth-child('+(colIndex+1)+')');
                // For example, adding data-* attributes to the cell
                $(this).attr('data-title', $title.data('title')??null);
            });
        },
        "order": [[ 0, "desc" ]],
        "language": {
            "url": "<?php echo e(asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')); ?>"
        }
    } );
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\gses\resources\views/security/users/index.blade.php ENDPATH**/ ?>