<div class="history-meta">
    @foreach($history->meta?:[] as $change)
        <p style="background: #d1ebfd;" class="p-1">
            [<strong>{{trans(ucfirst(str_replace('_',' ',str_replace(['_id'], '', $change['key']))))}}</strong>]
            :
            @if($change['old'])
                <span style="color: darkred;">
            @if (strpos($change['key'], '_id') !== false)
                        @if ($relationship = AppHelper::getFieldRelationship($history->model(), $change['key']))
                            @if ($model = $relationship->getRelated()->where(['id'=>$change['old']])->first())
                                @if ($model instanceof App\Models\Document)
                                    {{AppHelper::showBlade('', $model)}}
                                @elseif ($model->title)
                                    {{$model->title}}
                                @elseif ($model->name)
                                    {{$model->name}}
                                @endif
                            @else
                                {{$change['old']}}
                            @endif
                        @else
                            {{$history->model()}}:
                            {{$change['old']}}
                        @endif
                    @else
                        {{$change['old']}}
                    @endif
        </span> =>
            @endif
            @if($change['new'])
                <span style="color: darkgreen;">
            @if (strpos($change['key'], '_id') !== false)
                        @if ($relationship = AppHelper::getFieldRelationship($history->model(), $change['key']))
                            @if ($model = $relationship->getRelated()->where(['id'=>$change['new']])->first())
                                @if ($model instanceof App\Models\Document)
                                    {{AppHelper::showBlade('', $model)}}
                                @elseif ($model->title)
                                    {{$model->title}}
                                @elseif ($model->name)
                                    {{$model->name}}
                                @endif
                            @else
                                {{$change['new']}}
                            @endif
                        @else
                            {{$change['new']}}
                        @endif
                    @else
                        {{$change['new']}}
                    @endif
        </span>
            @endif
        </p>
    @endforeach
</div>
