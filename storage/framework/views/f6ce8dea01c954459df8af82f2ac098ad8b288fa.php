<div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="historyModalLabel"><?php echo e(__('History')); ?></h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="history-table" class="display" style="width:100%">
                        <thead>
                        <tr>
                            <th title="<?php echo e(__('No')); ?>"><?php echo e(__('No')); ?></th>
                            <th title="<?php echo e(__('Message')); ?>"><?php echo e(__('Message')); ?></th>

                            <th title="<?php echo e(__('Data')); ?>"><?php echo e(__('Data')); ?></th>
                            <th title="<?php echo e(__('User')); ?>"><?php echo e(__('User')); ?></th>
                            <th title="<?php echo e(__('Date')); ?>"><?php echo e(__('Date')); ?></th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.2\GSES 2.0\resources\views/layouts/history.blade.php ENDPATH**/ ?>