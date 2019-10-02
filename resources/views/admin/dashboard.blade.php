<form id="send" action="{{route('admin.dashboard.send')}}" method="post">
    {{csrf_field()}}
    <label for="send_message">
        {{__('admin.dashboard.send_label')}}
    </label>
    <input type="submit" id="send_message" value="{{__('admin.dashboard.send')}}">


</form>
<div>
    @if($user === null)
        <a href="{{route('admin.dashboard.telegram.login')}}" class="">login</a>
    @else
        @foreach($user as $key => $value)
            <div>
            <span class="col-md-3">{{__('admin.tgUsers.' . $key)}}</span>
            <span class="col-md-9">{{$value}}</span>
            </div>
        @endforeach
            <form id="logout" action="{{route('admin.dashboard.telegram.logout')}}" method="post">
                {{csrf_field()}}
                <input type="submit" id="send_message" value="logout">
            </form>
    @endif
</div>
