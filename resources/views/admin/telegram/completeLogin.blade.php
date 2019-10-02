<div class="container">
    <form action="{{route('admin.dashboard.telegram.completePhoneLogin')}}" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label for="url_callback_bot">{{__('admin.telegram.completePhoneLogin')}}</label>
            <input type="text" class="form-control" id="code" name="code" required>
        </div>
        <button class="btn btn-primary" type="submit">{{__('admin.ok')}}</button>
    </form>
</div>
