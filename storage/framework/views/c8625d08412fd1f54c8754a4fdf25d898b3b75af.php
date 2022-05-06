<?php $__env->startSection('panel'); ?>
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft"><?php echo e(__('Counterparties')); ?></h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contractor-create')): ?>
            <h3 class="animated fadeInRight"><a class="btn btn-success" href="<?php echo e(route('modules.contractors.create')); ?>"> <?php echo e(__('Create New Contractor')); ?></a></h3>
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
                <table class="table table-striped table-bordered" id="contractor-table" style="width:100%">
                <thead>
                    <tr>
                        <th data-title="<?php echo e(__('No')); ?>" width="50"><?php echo e(__('No')); ?></th>
                        <th data-title="<?php echo e(__('Type')); ?>"><?php echo e(__('Type')); ?></th>
                        <th data-title="<?php echo e(__('Name of body, institution')); ?>"><?php echo e(__('Name of body, institution')); ?></th>
                        <th data-title="<?php echo e(__('Surname')); ?>"><?php echo e(__('Surname')); ?></th>
                        <th data-title="<?php echo e(__('Name')); ?>"><?php echo e(__('Name')); ?></th>
                        <th data-title="<?php echo e(__('Middle name')); ?>"><?php echo e(__('Middle name')); ?></th>
                        <th data-title="<?php echo e(__('Position')); ?>"><?php echo e(__('Position')); ?></th>
                        <th data-title="<?php echo e(__('Phone number')); ?>"><?php echo e(__('Phone number')); ?></th>
                        <th data-title="<?php echo e(__('Email')); ?>"><?php echo e(__('Email')); ?></th>
                        <th data-title="<?php echo e(__('Created at')); ?>"><?php echo e(__('Created at')); ?></th>
                        <th data-title="<?php echo e(__('Created by')); ?>"><?php echo e(__('Created by')); ?></th>
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
    $('#contractor-table').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": '<?php echo e(route('modules.contractors.index')); ?>',
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'type', name: 'type'},
            {data: 'organ', name: 'organ'},
            {data: 'last_name', name: 'last_name'},
            {data: 'name', name: 'name'},
            {data: 'middle_name', name: 'middle_name'},
            {data: 'position', name: 'position'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'created_at', name: 'created_at'},
            {data: 'creator', name: 'creator'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "createdRow": function (row, data, rowIndex) {
            // Per-cell function to do whatever needed with cells
            $.each($('td', row), function (colIndex) {
                var $title = $('#contractor-table thead tr th:nth-child('+(colIndex+1)+')');
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/contractors/index.blade.php ENDPATH**/ ?>