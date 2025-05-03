<!DOCTYPE html>
<html lang="en">
@include('superadmin.layouts.header')

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('superadmin.layouts.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            @include('superadmin.layouts.topmenu')

            <div class="container">
                @yield('content')
            </div>

            @include('superadmin.layouts.footer')
        </div>

        <!-- End Custom template -->
    </div>
    @include('superadmin.layouts.js')

    @yield('customjs')
</body>

</html>
