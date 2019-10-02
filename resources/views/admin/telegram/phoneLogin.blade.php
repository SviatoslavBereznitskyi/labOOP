<div class="container">
    <form action="{{route('admin.dashboard.telegram.phoneLogin')}}" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label for="url_callback_bot">{{__('admin.telegram.phone')}}</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <button class="btn btn-primary" type="submit">{{__('admin.login')}}</button>
    </form>
</div>
