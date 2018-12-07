@if(mca()['controller'] == 'Poly')
    @include('layouts.wap.out_header')
@else
    @include('layouts.wap.header')
@endif

@yield('content')