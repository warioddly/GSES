

<?php $__env->startSection('panel'); ?>
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft"><?php echo e(__('Roles')); ?></h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-create')): ?>
                <h3 class="animated fadeInRight"><a class="btn btn-success" href="<?php echo e(route('security.roles.create')); ?>"> <?php echo e(__('Create New Role')); ?></a></h3>
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
                <table class="table table-striped table-bordered" id="role-table" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="<?php echo e(__('No')); ?>"><?php echo e(__('No')); ?></th>
                        <th data-title="<?php echo e(__('Name')); ?>"><?php echo e(__('Name')); ?></th>
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
        $('#role-table').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": '<?php echo e(route('security.roles.index')); ?>',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "createdRow": function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    var $title = $('#role-table thead tr th:nth-child('+(colIndex+1)+')');
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\gses\resources\views/security/roles/index.blade.php ENDPATH**/ ?>