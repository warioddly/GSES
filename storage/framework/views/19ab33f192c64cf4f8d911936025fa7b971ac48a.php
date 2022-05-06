

<?php $__env->startSection('panel'); ?>
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft"><?php echo e(__('Alias')); ?></h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subject-create')): ?>
                <h3 class="animated fadeInRight"><a class="btn btn-success"
                                                    href="<?php echo e(route('modules.nicknames.create')); ?>"> <?php echo e(__('Create New Subject')); ?></a>
                </h3>
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
                <table class="table table-striped table-bordered" id="nickname-table" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="<?php echo e(__('No')); ?>" width="50"><?php echo e(__('No')); ?></th>
                        <th data-title="<?php echo e(__('Alias')); ?>"><?php echo e(__('Alias')); ?></th>
                        <th data-title="<?php echo e(__('Subject')); ?>"><?php echo e(__('Subject')); ?></th>
                        <th data-title="<?php echo e(__('Creator')); ?>"><?php echo e(__('Creator')); ?></th>
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
        $('#nickname-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '<?php echo e(route('modules.nicknames.index')); ?>',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'nickname', name: 'nickname'},
                {data: 'subject_id', name: 'subject_id'},
                {data: 'user_id', name: 'user_id'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "order": [[0, "desc"]],
            "language": {
                "url": "<?php echo e(asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')); ?>"
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\gses\resources\views/nicknames/index.blade.php ENDPATH**/ ?>