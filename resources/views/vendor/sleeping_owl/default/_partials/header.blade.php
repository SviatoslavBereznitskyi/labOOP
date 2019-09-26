<a href="{{ url(config('sleeping_owl.url_prefix')) }}" class="logo">
    <span class="logo-lg">{!! AdminTemplate::getLogo() !!}</span>
    <span class="logo-mini">{!! AdminTemplate::getLogoMini() !!}</span>
</a>

<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    @stack('navbar.left')
    <div class="navbar-custom-menu">
        <a href="/" class="logo">
			<span class="logo-lg"><img src="{!! asset('favicon.ico') !!}" alt="ico" style="width: 25%;">WSS Sherlock</span>
            <span class="logo-mini"><img src="{!! asset('favicon.ico') !!}" alt="ico" style="width: 100%;"></span>
        </a>
        <ul class="nav navbar-nav">
            @stack('navbar')
        </ul>

        <ul class="nav navbar-nav navbar-right">
            @stack('navbar.right')
        </ul>
    </div>
</nav>
