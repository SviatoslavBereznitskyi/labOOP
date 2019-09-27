<div class="container">
    <form action="{{route('admin.settings.store')}}" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label for="">{{__('admin.settings.uriTitle')}}</label>
            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        {{__('admin.settings.action')}}
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#"
                               onclick="document.getElementById('url_callback_bot').value = '{{url('')}}'">
                                {{__('admin.settings.insertUri')}}
                            </a>
                        </li>
                        <li><a href="#"
                               onclick="event.preventDefault(); document.getElementById('setWebhook').submit();">
                                {{__('admin.settings.sendUri')}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <input type="url" class="form-control" id="url_callback_bot" name="url_callback_bot"
                   value="{{isset($url_callback_bot) ? $url_callback_bot:''}}" required>
        </div>
        <button class="btn btn-primary" type="submit">{{__('admin.settings.save')}}</button>
    </form>

    <form id="setWebhook" action="{{route('admin.setting.webhook')}}" method="post" style="display: none">
        {{csrf_field()}}
        <input type="hidden" name="uri" id="uri" value="{{isset($url_callback_bot) ? $url_callback_bot:''}}">
    </form>
</div>
