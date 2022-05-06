@if(!empty($user->getRoleNames()))
@foreach($user->getRoleNames() as $roleName)
    <label class="badge badge-success">{{$roleName}}</label>
@endforeach
@endif
