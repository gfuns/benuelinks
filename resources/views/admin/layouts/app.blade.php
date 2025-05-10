<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.header')

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            @include('admin.layouts.topmenu')

            <div class="container">
                @yield('content')
            </div>

            @include('admin.layouts.footer')
        </div>

        <!-- End Custom template -->
    </div>
    @include('admin.layouts.js')

    @yield('customjs')
</body>

</html>
