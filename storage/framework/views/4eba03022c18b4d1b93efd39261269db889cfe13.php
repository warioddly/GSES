<?php $__env->startSection('panel'); ?>
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft"><?php echo e(__('Create New article')); ?></h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="<?php echo e(route('modules.expertiseArticles.index')); ?>"> <?php echo e(__('Close')); ?></a>
                <button type="submit" class="btn btn-primary" form="article-form"><?php echo e(__('Save')); ?></button>
            </h3>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php if(count($errors) > 0): ?>
        <div class="alert alert-danger">
            <strong><?php echo e(__('Whoops!')); ?></strong> <?php echo e(__('There were some problems with your input.')); ?>

        </div>
    <?php endif; ?>

    <?php echo Form::open(array('id'=>'article-form', 'route' => 'modules.expertiseArticles.store','method'=>'POST', 'enctype'=>'multipart/form-data')); ?>


    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1"
                   class="">
                    <h4><?php echo e(__('Basic information')); ?></h4>
                </a>
            </div>
        </div>
        <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1"
             aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">



                    <div class="col-md-12 px-md-12 ">
                        <span>
                            <?php echo e(Form::radio('article_type', array_keys($articles)[0], true, ['id' => 'articleType_1'])); ?>

                            <?php echo e(Form::label('articleType_1', 'Тип статьи 1')); ?>

                        </span>

                        <span>
                            <?php echo e(Form::radio('article_type', array_keys($articles)[1], false, ['id' => 'articleType_2'])); ?>

                            <?php echo e(Form::label('articleType_2', 'Тип статьи 2')); ?>

                        </span>

                    </div>
                    <div class="col-md-6 px-md-12 form-field">
                        <div class="form-group form-animate-text ">
                            <?php echo Form::select("article", $articles, [], array('class' => 'form-control js-states select2')+(['required'])); ?>

                            <span class="bar"></span>
                            <label>Статья</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 panel-footer bg-white border-none">
            <div class="row">
                <div class="col-md-12 py-md-3 px-md-5 text-right">
                    <a href="<?php echo e(route('modules.expertiseArticles.index')); ?>" class="btn btn-secondary"><?php echo e(__('Close')); ?></a>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
                </div>
            </div>
        </div>
    </div>

    <?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>

<style>
    .select2-container--default .select2-results__option[aria-disabled=true] {
        display: none;
    }

    .select2-container--default .select2-results__group[aria-disabled=true]{
        display: none;
    }
</style>

<?php $__env->startPush('page-scripts'); ?>
    <script>

        let articles = '';
        let customSelect = $('select[name="article"]');

        customSelect.select2({
        placeholder: '<?php echo e(__('Search for an item')); ?>',
        allowClear: true,
        theme: 'default',
        width: '100%',
        });

        let placeholder = '<?php echo e(__('Search for an item')); ?>'

        $(() => {
            $(".select2-selection__rendered").text(placeholder);
            articles = <?php echo json_encode($articles, 15, 512) ?>;
            customSelect.find('optgroup').prop('disabled', true);

            if($("#articleType_1")[0].checked){
                customSelect.find('optgroup').each(function (index, elementOptgroup) {
                    if(elementOptgroup.label == $('#articleType_1').val()){
                        $(elementOptgroup).prop('disabled', false);
                    }
                });
            }
        })

        $('#articleType_1').change(() => {
            $(".select2-selection__rendered").text(placeholder);
            customSelect.find('optgroup').prop('disabled', true);
            customSelect.find('optgroup').each(function (index, elementOptgroup) {
                if(elementOptgroup.label === $('#articleType_1').val()){
                    $(elementOptgroup).prop('disabled', false);
                }
            });
        });

        $('#articleType_2').change(() => {
            $(".select2-selection__rendered").text(placeholder);
            customSelect.find('optgroup').prop('disabled', true);
            customSelect.find('optgroup').each(function (index, elementOptgroup) {
                if(elementOptgroup.label === $('#articleType_2').val()){
                    $(elementOptgroup).prop('disabled', false);
                }
            });
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.2\GSES 2.0\resources\views/simple-cruds/expertise_articles/create.blade.php ENDPATH**/ ?>