<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }} - No. 1 P2P Platform">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Peace Mass Transit (PMT) | Travel Routes</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-blue.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>

<body class="admin-dashboard page-user">
    @include('passenger.includes.nav')



    <div class="page-content">
        <div class="container">
            <div class="card content-area">
                <div class="card-innr">
                    <div class="card-head has-aside">
                        <h4 class="card-title">
                            Travel Routes
                        </h4>
                    </div>

                    <div class="page-nav-wrap">
                        <div class="page-nav-bar justify-content-between bg-lighter">

                            <div class="search flex-grow-1 pl-lg-4 w-100 w-sm-auto">
                                <form action="" method="GET" autocomplete="off">
                                    <div class="input-wrap">
                                        <span class="input-icon input-icon-left"><em class="ti ti-search"></em></span>
                                        <input type="search" class="input-solid input-transparent"
                                            placeholder="Quick travel route search using take-off point or destination"
                                            value="{{ $filter == 'quick' ? $keyword : '' }}" name="search">
                                        <input type="hidden" name="filter" value="quick">
                                    </div>
                                </form>
                            </div>
                            <div class="tools w-100 w-sm-auto">
                                <ul class="btn-grp guttar-8px">

                                    <li><a href="#"
                                            class="btn btn-light btn-sm btn-icon btn-outline bg-white advsearch-opt">
                                            <em class="ti ti-panel"></em> </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="search-adv-wrap hide">
                            <form class="adv-search" id="adv-search" action="" method="GET" autocomplete="off">
                                <div class="adv-search">
                                    <div class="row align-items-end guttar-20px guttar-vr-15px">
                                        <div class="col-sm-4 col-lg-3 col-mb-6">
                                            <div class="input-wrap input-with-label">
                                                <label class="input-item-label input-item-label-s2 text-exlight">Take
                                                    Off Point</label>
                                                <select name="takeoff"
                                                    class="select select-sm select-block select-bordered"
                                                    data-dd-class="search-on">
                                                    <option value="">All Terminals</option>
                                                    @foreach ($companyTerminals as $rt)
                                                        <option value="{{ $rt->id }}"
                                                            @if ($takeoff == $rt->id) selected @endif>
                                                            {{ $rt->terminal }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-lg-3 col-mb-6">
                                            <div class="input-wrap input-with-label">
                                                <label
                                                    class="input-item-label input-item-label-s2 text-exlight">Destination</label>
                                                <select name="destination"
                                                    class="select select-sm select-block select-bordered"
                                                    data-dd-class="search-on">
                                                    <option value="">All Terminals</option>
                                                    @foreach ($companyTerminals as $rd)
                                                        <option value="{{ $rd->id }}"
                                                            @if ($destination == $rd->id) selected @endif>
                                                            {{ $rd->terminal }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-lg-2 col-mb-6">
                                            <div class="input-wrap">
                                                <input type="hidden" name="filter" value="advanced">
                                                <button class="btn btn-sm btn-sm-s2 btn-auto btn-primary">
                                                    <em class="ti ti-search width-auto"></em><span>Search Records</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if ($filter != null)
                            <div class="search-adv-result">
                                <div class="search-info">Found <span
                                        class="search-count">{{ number_format(count($users), 0) }}</span> Users.
                                </div>
                                <ul class="search-opt">
                                    @if ($keyword != null)
                                        <li><a
                                                href="/portal/user-management?status={{ $status }}&amp;role={{ $role }}&amp;filter={{ $filter }}">Search
                                                Keyword:
                                                <span>{{ $keyword }}</span></a>
                                        </li>
                                    @endif
                                    @if ($status != null)
                                        <li><a
                                                href="/portal/user-management?search={{ $keyword }}&amp;role={{ $role }}&amp;filter={{ $filter }}">Status:
                                                <span>{{ ucwords($status) }}</span></a>
                                        </li>
                                    @endif
                                    @if ($role != null)
                                        <li><a
                                                href="/portal/user-management?search={{ $keyword }}&amp;status={{ $status }}&amp;filter={{ $filter }}">Role
                                                Type: <span>{{ \App\Models\UserRole::find($role)->role }}</span></a>
                                        </li>
                                    @endif
                                    <li><a href="{{ route('super.usermgt') }}" class="link link-underline">Clear
                                            All</a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="data-table user-list nobreak">
                            <thead>
                                <tr class="data-item data-head">
                                    <th class="data-col">S/No.</th>
                                    <th class="data-col">Take-off Point</th>
                                    <th class="data-col">Destination</th>
                                    <th class="data-col">Travel Fare</th>
                                    <th class="data-col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companyRoutes as $route)
                                    <tr class="data-item">
                                        <td class="data-col">
                                            <span class="sub sub-s2 sub-email">{{ $loop->index + 1 }}</span>
                                        </td>
                                        <td class="data-col">
                                            <span
                                                class="sub sub-s2 sub-email">{{ $route->departurePoint->terminal }}</span>
                                                <span class="sub user-id">{{ $route->departurePoint->address }}</span>
                                        </td>
                                        <td class="data-col">
                                            <span
                                                class="sub sub-s2 sub-email">{{ $route->destinationPoint->terminal }}</span>
                                                <span class="sub user-id">{{ $route->destinationPoint->address }}</span>
                                        </td>
                                        <td class="data-col">
                                            <span
                                                class="sub sub-s2 sub-email">&#8358;{{ number_format($route->transport_fare, 2) }}</span>
                                        </td>

                                        <td class="data-col data-col-wd-md text-right">
                                            <div class="relative d-inline-block">
                                                <a href="#"
                                                    class="btn btn-light-alt btn-xs btn-icon toggle-tigger"><em
                                                        class="ti ti-more-alt"></em></a>
                                                <div class="toggle-class dropdown-content dropdown-content-top-left">
                                                    <ul class="dropdown-list more-menu-3511">

                                                        <li><a href="#" data-userid=""
                                                                class="front suspendUser"><em
                                                                    class="fas fa-ban"></em>Suspend</a></li>


                                                    </ul>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                                @if (count($companyRoutes) < 1)
                                    <tr>
                                        <td colspan="5">
                                            <div class="col-xl-12 col-12 job-items job-empty">
                                                <div class="text-center mt-4"><i class="far fa-sad-tear"
                                                        style="font-size: 48px"></i>
                                                    <h5 class="mt-2">No Travel Routes Found</h5>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-bar">


                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="footer-bar">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-12">
                    <div class="copyright-text text-center pb-3">&copy; {{ date('Y') }} {{ env('APP_NAME') }}.
                        All
                        Rights Reserved. <br>Application Developed by <a href="{{ env('DEVELOPER_WEBSITE') }}"
                            target="_blank">{{ env('APP_DEVELOPER') }}</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div id="ajax-modal"></div>


    <div class="page-overlay">
        <div class="spinner"><span class="sp sp1"></span><span class="sp sp2"></span><span class="sp sp3"></span>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.bundle.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/admin.app.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/vendors/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/superadmin.js') }}?ver={{ date('his') }}"></script>

    @include('sweetalert::alert')

    <script type="text/javascript">
        document.getElementById("pricing").classList.add('active');
    </script>

</body>

</html>
