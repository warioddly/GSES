<div class="panel tabs-area" style="margin-top: 0; !important;">
    <ul id="tabs" class="nav nav-tabs nav-tabs-v3" role="tablist"
        style="padding-top: 0; !important;background: #F9F9F9;">
        <li role="presentation" class="active">
            <a href="#tabs-area1" id="tabs-1" role="tab" data-toggle="tab" aria-expanded="true">
                <h4><?php echo e(__('Expertise materials')); ?> (<span
                            id="count-materials"><?php echo e(__($expertise->materials()->count())); ?></span>)</h4></a>
        </li>
        <li role="presentation" class="">
            <a href="#tabs-area2" role="tab" id="tabs-2" data-toggle="tab" aria-expanded="true">
                <h4><?php echo e(__('Tasks for experts')); ?> (<span id="count-expert-tasks"><?php echo e($expertise->tasks()->count()); ?></span>)
                </h4></a>
        </li>
        <li role="presentation">
            <a href="#tabs-area3" id="tabs-3" role="tab" data-toggle="tab" aria-expanded="true">
                <h4><?php echo e(__('Expert conclusion')); ?> (<span
                            id="count-conclusions"><?php echo e($expertise->conclusions()->distinct('material_conclusions.id')->count('material_conclusions.id')); ?></span>)
                </h4></a>
        </li>
        <li role="presentation">
            <a href="#tabs-area4" id="tabs-4" role="tab" data-toggle="tab" aria-expanded="true"><h4><?php echo e(__('Petitions')); ?>

                    (<span id="count-petitions"><?php echo e($expertise->petitions()->count()); ?></span>)</h4></a>
        </li>
        <li role="presentation">
            <a href="#tabs-area5" id="tabs-5" role="tab" data-toggle="tab" aria-expanded="true">
                <h4><?php echo e(__('Court decision')); ?> (<span id="count-decisions"><?php echo e($expertise->decisions()->count()); ?></span>)
                </h4></a>
        </li>
        <li role="presentation">
            <a href="#tabs-area6" id="tabs-6" role="tab" data-toggle="tab" aria-expanded="true"><h4><?php echo e(__('History')); ?>

                    (<?php echo e($expertise->histories()->count()); ?>)</h4></a>
        </li>
    </ul>
    <div id="tabsDemo4Content" class="tab-content tab-content-v3">
        <div role="tabpanel" class="tab-pane fade active in" id="tabs-area1" aria-labelledby="tabs-area1"
             style="padding: 15px;">
            <!-------- Материалы экспертизы -------->
            <div class="responsive-table">
                <table id="material-table" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="<?php echo e(__('No')); ?>"><?php echo e(__('No')); ?></th>
                        <th data-title="<?php echo e(__('Name')); ?>"><?php echo e(__('Name')); ?></th>
                        <th data-title="<?php echo e(__('Type')); ?>"><?php echo e(__('Type')); ?></th>
                        <th data-title="<?php echo e(__('Document')); ?>"><?php echo e(__('Document')); ?></th>
                        <th data-title="<?php echo e(__('Status')); ?>"><?php echo e(__('Status')); ?></th>
                        <th data-title="<?php echo e(__('Language')); ?>"><?php echo e(__('Language')); ?></th>
                        <th data-title="<?php echo e(__('Created by')); ?>"><?php echo e(__('Created by')); ?></th>
                        <th data-title="<?php echo e(__('Created at')); ?>"><?php echo e(__('Created at')); ?></th>
                        <th data-title="<?php echo e(__('Action')); ?>"><?php echo e(__('Action')); ?></th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <button class="btn show-crud-modal" data-object="create-Material"
                        data-url="<?php echo e(route('expertise.modal.materials.create')); ?>">
                    <?php echo e(__('Create New Material')); ?>

                </button>
            </div>

        </div>
        <div role="tabpanel" class="tab-pane fade" id="tabs-area2" aria-labelledby="tabs-area2" style="padding: 15px;">
            <!-------- Задачи перед экспертами -------->
            <div class="responsive-table">
                <table id="task-table" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="<?php echo e(__('No')); ?>"><?php echo e(__('No')); ?></th>
                        <th data-title="<?php echo e(__('Task')); ?>"><?php echo e(__('Task')); ?></th>
                        <th data-title="<?php echo e(__('Comment')); ?>"><?php echo e(__('Comment')); ?></th>
                        <th data-title="<?php echo e(__('Date start task')); ?>"><?php echo e(__('Date start')); ?></th>
                        <th data-title="<?php echo e(__('Date end task')); ?>"><?php echo e(__('Date end')); ?></th>
                        <th data-title="<?php echo e(__('Status')); ?>"><?php echo e(__('Status')); ?></th>
                        <th data-title="<?php echo e(__('Expert')); ?>"><?php echo e(__('Expert')); ?></th>
                        <th data-title="<?php echo e(__('Created by')); ?>"><?php echo e(__('Created by')); ?></th>
                        <th data-title="<?php echo e(__('Created at')); ?>"><?php echo e(__('Created at')); ?></th>
                        <th data-title="<?php echo e(__('Action')); ?>"><?php echo e(__('Action')); ?></th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <button class="btn show-crud-modal" data-url="<?php echo e(route('expertise.modal.expert-tasks.create')); ?>">
                    <?php echo e(__('add expert task')); ?>

                </button>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tabs-area3" aria-labelledby="tabs-area3" style="padding: 15px;">
            <!-------- Заключения экспертов -------->
            <div class="responsive-table">
                <table id="conclusion-table" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="<?php echo e(__('No')); ?>"><?php echo e(__('No')); ?></th>
                        <th data-title="<?php echo e(__('Material')); ?>"><?php echo e(__('Material')); ?></th>
                        <!--th data-title="<?php echo e(__('Document')); ?>"><?php echo e(__('Document')); ?></th-->
                        <th data-title="<?php echo e(__('Conclusion')); ?>"><?php echo e(__('Conclusion')); ?></th>
                        <th data-title="<?php echo e(__('Conclusion text')); ?>"><?php echo e(__('Conclusion text')); ?></th>
                        <!--th data-title="<?php echo e(__('Status')); ?>"><?php echo e(__('Status')); ?></th-->
                        
                        <th data-title="<?php echo e(__('Created at')); ?>"><?php echo e(__('Created at')); ?></th>
                        <th data-title="<?php echo e(__('Action')); ?>"><?php echo e(__('Action')); ?></th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <button class="btn show-crud-modal" data-url="<?php echo e(route('expertise.modal.conclusions.create')); ?>">
                    <?php echo e(__('add conclusion')); ?>

                </button>
            </div>

        </div>
        <div role="tabpanel" class="tab-pane fade" id="tabs-area4" aria-labelledby="tabs-area4" style="padding: 15px;">
            <!-------- Ходатайства -------->
            <div class="responsive-table">
                <div class="responsive-table">
                    <table id="petition-table" class="display" style="width:100%">
                        <thead>
                        <tr>
                            <th data-title="<?php echo e(__('No')); ?>"><?php echo e(__('No')); ?></th>
                            <th data-title="<?php echo e(__('Reason')); ?>"><?php echo e(__('Reason')); ?></th>
                            <th data-title="<?php echo e(__('Type')); ?>"><?php echo e(__('Type')); ?></th>
                            <th data-title="<?php echo e(__('Scan')); ?>"><?php echo e(__('Scan')); ?></th>
                            <th data-title="<?php echo e(__('Status')); ?>"><?php echo e(__('Status')); ?></th>
                            
                            <th data-title="<?php echo e(__('Created at')); ?>"><?php echo e(__('Created at')); ?></th>
                            <th data-title="<?php echo e(__('Action')); ?>"><?php echo e(__('Action')); ?></th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <button class="btn show-crud-modal" data-url="<?php echo e(route('expertise.modal.petitions.create')); ?>">
                        <?php echo e(__('Create New Petition')); ?>

                    </button>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tabs-area5" aria-labelledby="tabs-area5" style="padding: 15px;">
            <!-------- Судебные заключения -------->
            <div class="responsive-table">
                <table id="decision-table" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="<?php echo e(__('No')); ?>"><?php echo e(__('No')); ?></th>
                        <th data-title="<?php echo e(__('Local court')); ?>"><?php echo e(__('Local court')); ?></th>
                        <th data-title="<?php echo e(__('Name of the local court')); ?>"><?php echo e(__('Name of the local court')); ?></th>
                        <th data-title="<?php echo e(__('Date')); ?>"><?php echo e(__('Date')); ?></th>
                        <th data-title="<?php echo e(__('Document')); ?>"><?php echo e(__('Document')); ?></th>
                        <th data-title="<?php echo e(__('Comment')); ?>"><?php echo e(__('Comment')); ?></th>
                        <th data-title="<?php echo e(__('Created at')); ?>"><?php echo e(__('Created at')); ?></th>
                        <th data-title="<?php echo e(__('Created by')); ?>"><?php echo e(__('Created by')); ?></th>
                        <th data-title="<?php echo e(__('Action')); ?>"><?php echo e(__('Action')); ?></th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                    <button class="btn show-crud-modal" data-url="<?php echo e(route('expertise.modal.decisions.create')); ?>">
                        <?php echo e(__('add decision')); ?>

                    </button>
                </div>
            </div>
        <div role="tabpanel" class="tab-pane fade" id="tabs-area6" aria-labelledby="tabs-area6" style="padding: 15px;">
            <!-------- история -------->
            <div class="responsive-table">
                <table id="expertise-history-table" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="<?php echo e(__('No')); ?>"><?php echo e(__('No')); ?></th>
                        <th data-title="<?php echo e(__('Message')); ?>"><?php echo e(__('Message')); ?></th>
                        
                        <th data-title="<?php echo e(__('Data')); ?>"><?php echo e(__('Data')); ?></th>
                        <th data-title="<?php echo e(__('User')); ?>"><?php echo e(__('User')); ?></th>
                        <th data-title="<?php echo e(__('Date')); ?>"><?php echo e(__('Date')); ?></th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="CRUD-modal" role="dialog" aria-labelledby="analyzeEditModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        
        <div class="modal-content">

        </div>
    </div>
</div>
<?php $__env->startSection('script'); ?>
    <script>
        // Материалы
        let materialsTable = $('#material-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '<?php echo e(route('expertise.modal.materials.index', ['expertise'=>$expertise->id])); ?>',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'type', name: 'type'},
                {data: 'file', name: 'file'},
                {data: 'status', name: 'status'},
                {data: 'language', name: 'language'},
                {data: 'creator', name: 'creator'},
                {data: 'created_at', name: 'created_at'},
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
            }
        });

        // Задачи перед экспертами
        let tasksTable = $('#task-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '<?php echo e(route('expertise.modal.expert-tasks.index', ['expertise'=>$expertise->id])); ?>',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'task', name: 'task'},
                {data: 'comment', name: 'comment'},
                {data: 'date_start', name: 'date_start'},
                {data: 'date_end', name: 'date_end'},
                {data: 'status', name: 'status'},
                {data: 'experts', name: 'experts'},
                {data: 'creator', name: 'creator'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "createdRow": function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    var $title = $('#task-table thead tr th:nth-child(' + (colIndex + 1) + ')');
                    // For example, adding data-* attributes to the cell
                    $(this).attr('data-title', $title.data('title') ?? null);
                });
            },
            "order": [[0, "desc"]],
            "language": {
                "url": "<?php echo e(asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')); ?>"
            }
        });

        // Заключения экспертов
        let conclusionsTable = $('#conclusion-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '<?php echo e(route('expertise.modal.conclusions.index', ['expertise'=>$expertise->id])); ?>',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'materials', name: 'materials'},
                //{data: 'file', name: 'file'},
                {data: 'options', name: 'options'},
                {data: 'result', name: 'result'},
                //{data: 'status', name: 'status'},
                // {data: 'experts', name: 'experts'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "createdRow": function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    var $title = $('#conclusion-table thead tr th:nth-child(' + (colIndex + 1) + ')');
                    // For example, adding data-* attributes to the cell
                    $(this).attr('data-title', $title.data('title') ?? null);
                });
            },
            "order": [[0, "desc"]],
            "language": {
                "url": "<?php echo e(asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')); ?>"
            }
        });

        // Ходатайства
        let petitionsTable = $('#petition-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '<?php echo e(route('expertise.modal.petitions.index', ['expertise'=>$expertise->id])); ?>',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'reason', name: 'reason'},
                {data: 'type', name: 'type'},
                {data: 'scan', name: 'scan'},
                {data: 'status', name: 'status'},
                // {data: 'expert', name: 'expert'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "createdRow": function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    var $title = $('#petition-table thead tr th:nth-child(' + (colIndex + 1) + ')');
                    // For example, adding data-* attributes to the cell
                    $(this).attr('data-title', $title.data('title') ?? null);
                });
            },
            "order": [[0, "desc"]],
            "language": {
                "url": "<?php echo e(asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')); ?>"
            }
        });

        // Судебные заключения
        let decisionsTable = $('#decision-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '<?php echo e(route('expertise.modal.decisions.index', ['expertise'=>$expertise->id])); ?>',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'court', name: 'court'},
                {data: 'court_name', name: 'court_name'},
                {data: 'date', name: 'date'},
                {data: 'file', name: 'file'},
                {data: 'comment', name: 'comment'},
                {data: 'creator', name: 'creator'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "createdRow": function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    var $title = $('#decision-table thead tr th:nth-child(' + (colIndex + 1) + ')');
                    // For example, adding data-* attributes to the cell
                    $(this).attr('data-title', $title.data('title') ?? null);
                });
            },
            "order": [[0, "desc"]],
            "language": {
                "url": "<?php echo e(asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')); ?>"
            }
        });

        // История
        $('#expertise-history-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '<?php echo route('histories.index', ['model_type' => get_class($expertise), 'model_id' => $expertise->id]); ?>',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'message', name: 'message'},
                // {data: 'model_type', name: 'model_type'},
                {data: 'meta', name: 'meta', width: "300px"},
                {data: 'user', name: 'user'},
                {data: 'performed_at', name: 'performed_at'},
            ],
            "createdRow": function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    var $title = $('#expertise-history-table thead tr th:nth-child(' + (colIndex + 1) + ')');
                    // For example, adding data-* attributes to the cell
                    $(this).attr('data-title', $title.data('title') ?? null);
                });
            },
            "order": [[0, "desc"]],
            "language": {
                "url": "<?php echo e(asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')); ?>"
            }
        });
    </script>
    
    <script>
        $(document).on('click', '.show-crud-modal', function (e) {
            $('#CRUD-modal .modal-content').removeClass('min-h-100');
            $('#CRUD-modal .modal-dialog').addClass('modal-lg');
            $('#CRUD-modal .modal-dialog').removeClass('modal-fullscreen');
            startPreloader();
            if (
                $(this).data('object') == 'show-Material' ||
                $(this).data('object') == 'create-Material' ||
                $(this).data('object') == 'edit-Material'
            ) {
                $('#CRUD-modal .modal-content').addClass('min-h-100');
                $('#CRUD-modal .modal-dialog').removeClass('modal-lg');
                $('#CRUD-modal .modal-dialog').addClass('modal-fullscreen');
            }
            $.ajax({
                method: 'get',
                url: $(this).data('url'),
                data: {
                    'expertise_id': '<?php echo e($expertise->id); ?>',
                },
                success: (data) => {
                    $('#CRUD-modal .modal-content').html(data);
                    $('#CRUD-modal').modal('show');
                    stopPreloader();
                },
                error: function (error) {
                    alert('Server error:' + error.status);
                }
            });
            return false;
        });
    </script>
    
    <script>
        $('#CRUD-modal').on('submit', '#modal-form', function (e) {
            startPreloader();
            $('.ajax-modal-error').remove();
            e.preventDefault();
            $.ajax({
                method: 'post',
                url: $(this).attr('action'),
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: (data) => {
                    if (data.entity === 'expert-task') {
                        if (data.action === 'stored') {
                            $('#count-expert-tasks').text(parseInt($('#count-expert-tasks').text()) + 1);
                        }
                        tasksTable.ajax.reload();
                    }
                    if (data.entity === 'conclusion') {
                        if (data.action === 'stored') {
                            $('#count-conclusions').text(parseInt($('#count-conclusions').text()) + 1);
                        }
                        conclusionsTable.ajax.reload();
                    }
                    if (data.entity === 'decision') {
                        if (data.action === 'stored') {
                            $('#count-decisions').text(parseInt($('#count-decisions').text()) + 1);
                        }
                        decisionsTable.ajax.reload();
                    }
                    if (data.entity === 'petition') {
                        if (data.action === 'stored') {
                            $('#count-petitions').text(parseInt($('#count-petitions').text()) + 1);
                        }
                        petitionsTable.ajax.reload();
                    }
                    if (data.entity === 'material') {
                        if (data.action === 'stored') {
                            $('#count-materials').text(parseInt($('#count-materials').text()) + 1);
                        }
                        materialsTable.ajax.reload();
                    }
                    stopPreloader();
                    $('#CRUD-modal').modal('hide');
                },
                error: function (error) {
                    stopPreloader();
                    if (error.status === 422) {
                        $.each(error.responseJSON.errors, function (i, error) {
                            var el = $('#CRUD-modal').find('[name="' + i + '"]');
                            if (el.length == 0) {
                                el = $('#CRUD-modal').find('[name="' + i + '[]"]');
                            }
                            if (el.length != 0) {
                                el.parent().append($('<em class="ajax-modal-error error">' + error[0] + '</em>'));
                            } else {
                                alert(error[0]);
                                // $('#errors-container').append('<em class="ajax-modal-error error">' + error[0] + '</em>');
                            }
                            $('#CRUD-modal').scrollTop(0);
                        });
                    } else {
                        alert('Server error:' + error.status);
                    }

                }
            });
            return false;
        })
    </script>
    
    <script>
        $(document).on('click', '.modal-delete', function (e) {
            e.preventDefault();
            if (!confirm('Вы действительно хотите удалить?')) {
                return;
            }
            startPreloader();
            $.ajax({
                method: 'delete',
                url: $(this).data('url') + "?expertise_id=" + "<?php echo e($expertise->id); ?>",
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: (data) => {
                    if (data === 'expert-task') {
                        tasksTable.ajax.reload();
                        $('#count-expert-tasks').text(parseInt($('#count-expert-tasks').text()) - 1);
                    } else if (data === 'conclusion') {
                        conclusionsTable.ajax.reload();
                        $('#count-conclusions').text(parseInt($('#count-conclusions').text()) - 1);
                    } else if (data === 'decision') {
                        decisionsTable.ajax.reload();
                        $('#count-decisions').text(parseInt($('#count-decisions').text()) - 1);
                    } else if (data === 'petition') {
                        petitionsTable.ajax.reload();
                        $('#count-petitions').text(parseInt($('#count-petitions').text()) - 1);
                    } else if (data === 'material') {
                        materialsTable.ajax.reload();
                        $('#count-materials').text(parseInt($('#count-materials').text()) - 1);
                    }
                    stopPreloader()
                },
                error: function (error) {
                    if (error.status === 422) {
                        alert(error.responseJSON.errors);
                    } else {
                        alert('Server error:' + error.status);
                    }
                    stopPreloader()
                }
            })
        })
    </script>
    
    <script>
        $('#CRUD-modal').on('hidden.bs.modal', function () {
            $(this).find('.modal-content').empty();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/expertise/sections.blade.php ENDPATH**/ ?>