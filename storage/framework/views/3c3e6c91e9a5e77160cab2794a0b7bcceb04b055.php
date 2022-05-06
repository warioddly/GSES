<?php $__env->startSection('panel'); ?>
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft"><?php echo e(__('Export list of expertises')); ?></h3>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e($message); ?></p>
        </div>
    <?php endif; ?>
    <div id="expert-tab-content" class="tab-content">
        <div class="panel">
            <div class="panel-body">
                <div class="responsive-table">
                    <table class="table table-striped table-bordered" id="expertise-table"
                           style="width:100%">
                        <thead>
                            <th data-title="<?php echo e(__('No')); ?>" width="50"><?php echo e(__('No')); ?></th>
                            <th data-title="<?php echo e(__('Material name')); ?>"><?php echo e(__('Material name')); ?></th>
                            <th data-title="<?php echo e(__('Object type')); ?>"><?php echo e(__('Object type')); ?></th>
                            <th data-title="<?php echo e(__('Material type')); ?>"><?php echo e(__('Material type')); ?></th>
                            <th data-title="<?php echo e(__('Expertise name')); ?>"><?php echo e(__('Expertise name')); ?></th>
                            <th data-title="<?php echo e(__('Expertise No.')); ?>"><?php echo e(__('Expertise No.')); ?></th>
                            <th data-title="<?php echo e(__('Expertise type')); ?>"><?php echo e(__('Expertise type')); ?></th>
                            <th data-title="<?php echo e(__('Responsible')); ?>"><?php echo e(__('Responsible')); ?></th>
                            <th data-title="<?php echo e(__('Language')); ?>"><?php echo e(__('Language')); ?></th>
                            <th data-title="<?php echo e(__('Source')); ?>"><?php echo e(__('Source')); ?></th>
                            <th data-title="<?php echo e(__('Document')); ?>"><?php echo e(__('Document')); ?></th>
                            <th data-title="<?php echo e(__('Comment')); ?>"><?php echo e(__('Comment')); ?></th>
                            <th data-title="<?php echo e(__('Status')); ?>"><?php echo e(__('Status')); ?></th>
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
    </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('page-styles'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.3.0/css/searchBuilder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.5/css/colReorder.dataTables.min.css">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('script'); ?>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.3.0/js/dataTables.searchBuilder.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>

    <script src="https://cdn.datatables.net/colreorder/1.5.5/js/dataTables.colReorder.min.js"></script>
    <script>

        let expertiseTable;
        $(document).ready(function () {
            expertiseTable = $('#expertise-table').DataTable({
                "processing": true,
                "serverSide": false,
                dom: 'Q<"other-control-element"B>lfrtip',
                colReorder: {},
                buttons: [
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible',
                            orthogonal: 'export'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible',
                            orthogonal: 'export'
                        }
                    },
                    'colvis'
                ],
                "ajax": "<?php echo e(route('export-materials')); ?>",
                "columns": [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'object_type_id', name: 'object_type_id'},
                    {data: 'type_id', name: 'type_id'},
                    {data: 'expertise_name', name: 'expertise_name'},
                    {data: 'expertise_number', name: 'expertise_number'},
                    {data: 'expertise_types', name: 'expertise_types'},
                    {data: 'expertise_experts', name: 'expertise_experts'},
                    {data: 'language_id', name: 'language_id'},
                    {data: 'source', name: 'source'},
                    {data: 'file', name: 'file'},
                    {data: 'file_text_comment', name: 'file_text_comment'},
                    {data: 'status_id', name: 'status_id'},
                    {data: 'creator_id', name: 'creator_id'},
                    {
                        data: 'created_at',
                        render: {_: ".human_format", sb: '.iso8601',},
                        searchBuilder: {orthogonal: 'sb',},
                        searchBuilderType: 'date',
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                "order": [[0, "desc"]],
                "language": {
                    "url": "<?php echo e(asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')); ?>"
                },
                fixedHeader: true,
                initComplete: function () {
                    $("#expertise-table").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                }
            });
        });
    </script>
    <script>
        $(document).on('change', '.dtsb-condition', function () {
            $('.dtsp-joiner').html("<?php echo e(app()->getLocale()); ?>" == "ru" ? "И" : "Жана")
        })
    </script>
<?php $__env->stopSection(); ?>

<style>
.other-control-element .dt-button.active {
    background: #2196F3 !important;
    color: #fff !important;
}
</style>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/materials/export-index.blade.php ENDPATH**/ ?>