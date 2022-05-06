<!-- start: Javascript -->
<script src="<?php echo e(asset('asset/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/jquery.ui.min.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/bootstrap.min.js')); ?>"></script>


<!-- plugins -->
<script src="<?php echo e(asset('asset/js/plugins/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/plugins/fullcalendar.min.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/plugins/jquery.datatables.min.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/plugins/datatables.bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/plugins/jquery.nicescroll.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/plugins/jquery.vmap.min.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/plugins/maps/jquery.vmap.world.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/plugins/jquery.vmap.sampledata.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/plugins/chart.min.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/plugins/select2.full.min.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/plugins/jquery.datetimepicker.full.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/input-mask.js')); ?>"></script>

<script src="//cdn.datatables.net/plug-ins/1.11.3/api/fnReloadAjax.js"></script>

<!-- custom -->
<script src="<?php echo e(asset('asset/js/main.js')); ?>"></script>
<script type="text/javascript">
    (function(jQuery){

        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        // start: Chart =============

        Chart.defaults.global.pointHitDetectionRadius = 1;
        Chart.defaults.global.customTooltips = function(tooltip) {

            var tooltipEl = $('#chartjs-tooltip');

            if (!tooltip) {
                tooltipEl.css({
                    opacity: 0
                });
                return;
            }

            tooltipEl.removeClass('above below');
            tooltipEl.addClass(tooltip.yAlign);

            var innerHtml = '';
            if (undefined !== tooltip.labels && tooltip.labels.length) {
                for (var i = tooltip.labels.length - 1; i >= 0; i--) {
                    innerHtml += [
                        '<div class="chartjs-tooltip-section">',
                        '   <span class="chartjs-tooltip-key" style="background-color:' + tooltip.legendColors[i].fill + '"></span>',
                        '   <span class="chartjs-tooltip-value">' + tooltip.labels[i] + '</span>',
                        '</div>'
                    ].join('');
                }
                tooltipEl.html(innerHtml);
            }

            tooltipEl.css({
                opacity: 1,
                left: tooltip.chart.canvas.offsetLeft + tooltip.x + 'px',
                top: tooltip.chart.canvas.offsetTop + tooltip.y + 'px',
                fontFamily: tooltip.fontFamily,
                fontSize: tooltip.fontSize,
                fontStyle: tooltip.fontStyle
            });
        };

        var expertiseMonthData = {
            labels: [
                '<?php echo e(__('January')); ?>',
                '<?php echo e(__('February')); ?>',
                '<?php echo e(__('March')); ?>',
                '<?php echo e(__('April')); ?>',
                '<?php echo e(__('May')); ?>',
                '<?php echo e(__('June')); ?>',
                '<?php echo e(__('July')); ?>',
                '<?php echo e(__('August')); ?>',
                '<?php echo e(__('September')); ?>',
                '<?php echo e(__('October')); ?>',
                '<?php echo e(__('November')); ?>',
                '<?php echo e(__('December')); ?>',
            ],
            datasets: [{
                label: "My First dataset",
                fillColor: "rgba(21,186,103,0.4)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(66,69,67,0.3)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: []
            }, {
                label: "My Second dataset",
                fillColor: "rgba(21,113,186,0.5)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: []
            }]
        };

        var expertiseRegionData = {
            labels: [
                '<?php echo e(__('Bishkek')); ?>',
                '<?php echo e(__('Chui region')); ?>',
                '<?php echo e(__('Issyk-Kul region')); ?>',
                '<?php echo e(__('Jalal-Abad region')); ?>',
                '<?php echo e(__('Talas region')); ?>',
                '<?php echo e(__('Osh region')); ?>',
                '<?php echo e(__('Naryn region')); ?>',
                '<?php echo e(__('Batken region')); ?>',
            ],
            datasets: [
                {
                    label: "My First dataset",
                    fillColor: "rgba(21,186,103,0.4)",
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: "rgba(21,186,103,0.2)",
                    highlightStroke: "rgba(21,186,103,0.2)",
                    data: []
                },
                {
                    label: "My Second dataset",
                    fillColor: "rgba(21,113,186,0.5)",
                    strokeColor: "rgba(151,187,205,0.8)",
                    highlightFill: "rgba(21,113,186,0.2)",
                    highlightStroke: "rgba(21,113,186,0.2)",
                    data: []
                }
            ]
        };

        window.onload = function(){
            if ($('.dashboard').length === 0)
                return;
            // var ctx = $(".doughnut-chart")[0].getContext("2d");
            // window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, {
            //     responsive : true,
            //     showTooltips: true
            // });

            var data = JSON.parse($(".expertise-month-chart").text());

            for (var year = 0; year < 2; year++) {
                for (var m = 1; m <= 12; m++) {
                    var total = data[year][m] || 0;
                    expertiseMonthData.datasets[year].data.push(total);
                }
            }

            var ctx2 = $(".expertise-month-chart")[0].getContext("2d");
            window.myLine = new Chart(ctx2).Line(expertiseMonthData, {
                responsive: true,
                showTooltips: true,
                multiTooltipTemplate: "<%= value %>",
                maintainAspectRatio: false
            });

            var data = JSON.parse($(".expertise-region-chart").text());

            for (var year = 0; year < 2; year++) {
                for (var r = 1; r <= 8; r++) {
                    var total = data[year][r] || 0;
                    expertiseRegionData.datasets[year].data.push(total);
                }
            }

            var ctx3 = $(".expertise-region-chart")[0].getContext("2d");
            window.myLine = new Chart(ctx3).Bar(expertiseRegionData, {
                responsive: true,
                showTooltips: true
            });

            // var ctx4 = $(".doughnut-chart2")[0].getContext("2d");
            // window.myDoughnut2 = new Chart(ctx4).Doughnut(doughnutData2, {
            //     responsive : true,
            //     showTooltips: true
            // });

        };

        //  end:  Chart =============

        // start: Calendar =========
        // $('.dashboard .calendar').fullCalendar({
        //     header: {
        //         left: 'prev,next today',
        //         center: 'title',
        //         right: 'month,agendaWeek,agendaDay'
        //     },
        //     defaultDate: '2015-02-12',
        //     businessHours: true, // display business hours
        //     editable: true,
        //     events: [
        //         {
        //             title: 'Business Lunch',
        //             start: '2015-02-03T13:00:00',
        //             constraint: 'businessHours'
        //         },
        //         {
        //             title: 'Meeting',
        //             start: '2015-02-13T11:00:00',
        //             constraint: 'availableForMeeting', // defined below
        //             color: '#20C572'
        //         },
        //         {
        //             title: 'Conference',
        //             start: '2015-02-18',
        //             end: '2015-02-20'
        //         },
        //         {
        //             title: 'Party',
        //             start: '2015-02-29T20:00:00'
        //         },
        //
        //         // areas where "Meeting" must be dropped
        //         {
        //             id: 'availableForMeeting',
        //             start: '2015-02-11T10:00:00',
        //             end: '2015-02-11T16:00:00',
        //             rendering: 'background'
        //         },
        //         {
        //             id: 'availableForMeeting',
        //             start: '2015-02-13T10:00:00',
        //             end: '2015-02-13T16:00:00',
        //             rendering: 'background'
        //         },
        //
        //         // red areas where no events can be dropped
        //         {
        //             start: '2015-02-24',
        //             end: '2015-02-28',
        //             overlap: false,
        //             rendering: 'background',
        //             color: '#FF6656'
        //         },
        //         {
        //             start: '2015-02-06',
        //             end: '2015-02-08',
        //             overlap: true,
        //             rendering: 'background',
        //             color: '#FF6656'
        //         }
        //     ]
        // });
        // end : Calendar==========

        // start: Maps============

        // jQuery('.maps').vectorMap({
        //     map: 'world_en',
        //     backgroundColor: null,
        //     color: '#fff',
        //     hoverOpacity: 0.7,
        //     selectedColor: '#666666',
        //     enableZoom: true,
        //     showTooltip: true,
        //     values: sample_data,
        //     scaleColors: ['#C8EEFF', '#006491'],
        //     normalizeFunction: 'polynomial'
        // });

        // end: Maps==============

        // start: Select2 ==============

        /*$("select.select2").each(function(){
            if (this.dataset.ajax) {
                $(this).select2({
                    ajax: {
                        url: this.dataset.ajax,
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                _token: CSRF_TOKEN,
                                search: params.term // search term
                            };
                        },
                        processResults: function (response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    },
                    placeholder: '<?php echo e(__('Search for an item')); ?>',
                    allowClear: true,
                    theme: 'default',
                    width: '100%'
                });
            }
            else {
                $(this).select2({
                    placeholder: '<?php echo e(__('Search for an item')); ?>',
                    theme: 'default',
                    allowClear: true,
                    width: '100%'
                });
            }
        });*/

        // end: Select2=================

        // date picker
        /*var lang = $('html').attr('lang');
        $.datetimepicker.setLocale(lang);

        $('.datepicker').datetimepicker({
            timepicker: false,
            mask: '39-19-9999',
            format: 'd-m-Y',
            dayOfWeekStart: 1
        }).each(function(){ if (this.value == '__-__-____') $(this).val(''); });

        $('.datetimepicker').datetimepicker({
            timepicker: true,
            mask: '39-19-9999 29:59',
            format: 'd-m-Y H:i',
            dayOfWeekStart: 1
        }).each(function(){ if (this.value == '__-__-____ __:__') $(this).val(''); });*/

        // document field
        /*$('.file-clear').click(function (){
            $(this).closest('.form-group').find('input[type="file"]').val('').trigger('change');
        });

        $('.form-group input[type="file"]').change(function(){
            if (this.files.length > 0) {
                var fileName = [];
                for (var file of this.files) {
                    fileName.push(file.name);
                }
                $(this).parent().find('.file-id').val('');
                $(this).parent().find('.file-name').val(fileName.join(', '));
                $(this).parent().find('.file-clear').show();
                $(this).parent().find('.file-download').show();
            }
            else {
                $(this).parent().find('.file-id').val('');
                $(this).parent().find('.file-name').val('');
                $(this).parent().find('.file-clear').hide();
                $(this).parent().find('.file-download').hide();
            }
        });*/

        // change value attr, when value changed
        $(".form-animate-text .form-text:not(:required)," +
            ".form-animate-text .form-text[type='password']").change(function(){
            this.setAttribute('value', this.value);
        });

        $('#search-form').submit(function(){
            if (!this.search.value) {
                location.href = this.action;
                return false;
            }
        });

        // Clickable datatable row
        $(document).on('click', '.dataTable tbody tr[role="row"]', function (e){
            if($(e.target).prop("tagName") === 'TD' &&
               $(e.target).find('a.row-edit').length === 0 &&
               $(e.target).find('a.row-show').length === 0) {
                var edit = $(e.target).closest('tr').find('a.row-edit').prop('href');
                var show = $(e.target).closest('tr').find('a.row-show').prop('href');
                if (edit || show) {
                    window.location.href = edit || show;
                }
            }
        });

    })(jQuery);

    function history(url) {

        if (window.historyTable)
            window.historyTable.destroy();

        window.historyTable = $('#history-table').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": url,
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'message', name: 'message'},
                // {data: 'model_type', name: 'model_type'},
                {data: 'meta', name: 'meta'},
                {data: 'user', name: 'user'},
                {data: 'performed_at', name: 'performed_at'},
            ],
            "createdRow": function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    var $title = $('#history-table thead tr th:nth-child('+(colIndex+1)+')');
                    // For example, adding data-* attributes to the cell
                    $(this).attr('data-title', $title.data('title')??null);
                });
            },
            "order": [[ 0, "desc" ]],
            "language": {
                "url": "<?php echo e(asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')); ?>"
            }
        } );

        $('#historyModal').modal('show');
    }
    function startPreloader() {
        $('#layout-preloader').show();
        $('body').addClass('body-scroll-off');
    }

    function stopPreloader() {
        $('#layout-preloader').hide();
        $('body').removeClass('body-scroll-off');
    }
</script>
<!-- end: Javascript -->
<?php /**PATH C:\Users\IMO\PhpstormProjects\gses\resources\views/layouts/scripts.blade.php ENDPATH**/ ?>