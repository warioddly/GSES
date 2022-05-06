<div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="historyModalLabel">{{__('History')}}</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="history-table" class="display" style="width:100%">
                        <thead>
                        <tr>
                            <th title="{{__('No')}}">{{__('No')}}</th>
                            <th title="{{__('Message')}}">{{__('Message')}}</th>
{{--                            <th title="{{__('Model')}}">{{__('Model')}}</th>--}}
                            <th title="{{__('Data')}}">{{__('Data')}}</th>
                            <th title="{{__('User')}}">{{__('User')}}</th>
                            <th title="{{__('Date')}}">{{__('Date')}}</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>
