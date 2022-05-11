<?php $__env->startSection('panel'); ?>
    <div class="col-md-6 col-sm-12" style="display: flex; align-items: center">
        <h3 class="animated fadeInLeft"><?php echo e(__('Materials')); ?></h3>
        <h3 class="ml-3">
            <a class="btn btn-link" href="<?php echo e(route('export-materials')); ?>">
                <?php echo e(__('Go to export')); ?>

            </a>
        </h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('material-create')): ?>
                <h3 class="animated fadeInRight">
                    <a class="btn btn-success" href="<?php echo e(route('materials.create')); ?>">
                        <?php echo e(__('Create New Material')); ?>

                    </a>
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
            <div>
                <table class="table table-striped table-bordered" id="material-table" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="<?php echo e(__('No')); ?>" width="50"><?php echo e(__('No')); ?></th>
                        <th data-title="<?php echo e(__('Material name')); ?>"><?php echo e(__('Material name')); ?></th>
                        <th data-title="<?php echo e(__('Object type')); ?>"><?php echo e(__('Object type')); ?></th>
                        <th data-title="<?php echo e(__('Material type')); ?>"><?php echo e(__('Material type')); ?></th>
                        <th data-title="<?php echo e(__('Language')); ?>"><?php echo e(__('Language')); ?></th>
                        <th data-title="<?php echo e(__('Source')); ?>"><?php echo e(__('Source')); ?></th>
                        <th data-title="<?php echo e(__('Document')); ?>"><?php echo e(__('Document')); ?></th>
                        <th data-title="<?php echo e(__('Comment')); ?>"><?php echo e(__('Comment')); ?></th>
                        <th data-title="<?php echo e(__('Status')); ?>"><?php echo e(__('Status')); ?></th>
                        <th data-title="<?php echo e(__('Created at')); ?>"><?php echo e(__('Created at')); ?></th>
                        <th data-title="<?php echo e(__('Content analyze')); ?>"><?php echo e(__('Content analyze')); ?></th>
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
        $(document).ready(function () {
            $('#material-table').DataTable({
                "processing": true,
                "serverSide": true,
                "oSearch": {"sSearch": '<?php echo e(request()->input('search')); ?>'},
                "ajax": '<?php echo e(route('materials.index')); ?>',
                "columns": [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'object_type', name: 'object_type'},
                    {data: 'type', name: 'type'},
                    {data: 'language', name: 'language'},
                    {data: 'source', name: 'source'},
                    {data: 'file', name: 'file'},
                    {data: 'file_text_comment', name: 'file_text_comment'},
                    {data: 'status', name: 'status'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'words', name: 'words'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                "createdRow": function (row, data, rowIndex) {
                    // Per-cell function to do whatever needed with cells
                    $.each($('td', row), function (colIndex) {
                        var $title = $('#material-table thead tr th:nth-child(' + (colIndex + 1) + ')');
                        // For example, adding data-* attributes to the cell
                        $(this).attr('data-title', $title.data('title') ?? null);
                    });
                },
                "order": [[0, "desc"]],
                "language": {
                    "url": "<?php echo e(asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')); ?>"
                },
                initComplete: function () {
                    $("#material-table").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                    var api = this.api();

                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function (colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            if (colIdx === 11) {
                                $(cell).empty();
                                return false;
                            }
                            if (colIdx === 0) {
                                $(cell).html('<input type="text" style="width: 100%"/>');
                            } else {
                                $(cell).html('<input type="text" />');
                            }
                            // On every keypress in this input
                            $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                            )
                                .off('keyup change')
                                .on('keyup change', function (e) {
                                    e.stopPropagation();
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != ''
                                                ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                : '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();

                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });

                        });
                },
            });
            $('#material-table thead tr').clone(true).addClass('filters').appendTo('#material-table thead');
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.2\GSES 2.0\resources\views/materials/index.blade.php ENDPATH**/ ?>