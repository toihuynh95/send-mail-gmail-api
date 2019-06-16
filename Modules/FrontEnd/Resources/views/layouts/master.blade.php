<!DOCTYPE html>
<html>
@include('frontend::layouts.include.head')
<body class="hold-transition skin-red sidebar-mini">{{--sidebar-collapse--}}
<div id="loader">
    <div class="loading">
        <div class="cssload-loader">
            <div class="cssload-inner cssload-one"></div>
            <div class="cssload-inner cssload-two"></div>
            <div class="cssload-inner cssload-three"></div>
        </div>
    </div>
</div>
<div class="wrapper">
    @include('frontend::layouts.include.header')
    @include('frontend::layouts.include.sidebar')
    <section class='content-wrapper'>
        @yield('content')
    </section>
    @include('frontend::layouts.include.footer')
</div>
@include('frontend::layouts.include.script_footer')
</body>
</html>
