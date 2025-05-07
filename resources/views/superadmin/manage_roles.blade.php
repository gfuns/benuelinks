@extends('superadmin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">User Roles</h4>
                                <button class="btn btn-primary btn-round ms-auto btn-sm" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasRight">
                                    <i class="fa fa-plus"></i>
                                    New User Role
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="example" class="table mb-0 text-nowrap table-hover table-centered">
                                    <thead>
                                        <tr>
                                            <th scope="col">S/No.</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Permissions</th>
                                            <th scope="col">Date Created</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($userRoles as $role)
                                            <tr>
                                                <td class="align-middle"> {{ $loop->index + 1 }} </td>
                                                <td class="align-middle"> {{ $role->role }} </td>
                                                <td class="align-middle">
                                                    {{ $role->id == 1 ? $role->totalPermissions() : $role->permissions->count() }}
                                                    Permissions Found</td>
                                                <td class="align-middle"> {{ date_format($role->created_at, 'jS F, Y') }}
                                                </td>
                                                <td class="align-middle">
                                                    @if ($role->id != 1)
                                                        <div class="btn-group dropdown">
                                                            <button class="btn btn-primary btn-sm dropdown-toggle"
                                                                type="button" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <ul class="dropdown-menu" role="menu" style="">
                                                                <li>
                                                                    <a class="dropdown-item mb-2" href="#"
                                                                        data-bs-toggle="offcanvas"
                                                                        data-bs-target="#editRole" data-backdrop="static"
                                                                        data-myid="{{ $role->id }}"
                                                                        data-role="{{ $role->role }}"><i
                                                                            class="fe fe-eye dropdown-item-icon"></i>Edit
                                                                        Role</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('superadmin.managePermissions', [$role->id]) }}"><i
                                                                            class="fe fe-trash dropdown-item-icon"></i>Manage
                                                                        Permissions</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel">Create New User Role</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('superadmin.storeUserRole') }}">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">User Role <span class="text-danger">*</span></label>
                            <input type="text" name="role" class="form-control" placeholder="Enter Role" required>
                            <div class="invalid-feedback">Please provide role.</div>
                        </div>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Create Role</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="editRole" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Update This User Role</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('superadmin.updateUserRole') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">User Role <span class="text-danger">*</span></label>
                            <input id="role" type="text" name="role" class="form-control"
                                placeholder="Enter Role" required>
                            <div class="invalid-feedback">Please provide role.</div>
                        </div>

                        <input id="myid" type="hidden" name="role_id" class="form-control" required>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Save Changes</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.getElementById("settings").classList.add('active');
        document.getElementById("platform").classList.add('show');
        document.getElementById("roles").classList.add('active');
    </script>
@endsection
