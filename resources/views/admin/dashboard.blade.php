<form id="setWebhook" action="{{route('admin.dashboard.send')}}" method="post">
    {{csrf_field()}}
    <label for="send_message">
        {{__('admin.dashboard.send_label')}}
    </label>
    <input type="submit" id="send_message" value="{{__('admin.dashboard.send')}}">
</form>
