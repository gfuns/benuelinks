@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">User Management</h4>
                                <button class="btn btn-primary btn-round ms-auto btn-sm" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasRight">
                                    <i class="fa fa-plus"></i>
                                    New User Account
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="example" class="table mb-0 text-nowrap table-hover table-centered">
                                    <thead>
                                        <tr>
                                            <th scope="col">S/No.</th>
                                            <th scope="col">Surname</th>
                                            <th scope="col">Other Names</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">Station</th>
                                            <th scope="col">Assigned Role</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Date Created</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $usr)
                                            <tr>
                                                <td class="align-middle"> {{ $loop->index + 1 }} </td>
                                                <td class="align-middle"> {{ $usr->last_name }} </td>
                                                <td class="align-middle"> {{ $usr->other_names }} </td>
                                                <td class="align-middle"> {{ $usr->email }} </td>
                                                <td class="align-middle"> {{ $usr->phone_number }} </td>
                                                <td class="align-middle"> {{ $usr->terminal->terminal }} </td>
                                                <td class="align-middle"> {{ $usr->userRole->role }} </td>
                                                <td>
                                                    @if ($usr->status == 'active')
                                                        <span class="badge badge-success p-2"
                                                            style="font-size: 10px">{{ ucwords($usr->status) }}</span>
                                                    @else
                                                        <span class="badge badge-warning p-2"
                                                            style="font-size: 10px">{{ ucwords($usr->status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle"> {{ date_format($usr->created_at, 'jS F, Y') }}
                                                </td>
                                                <td class="align-middle">
                                                    @if ($usr->id != Auth::user()->id)
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
                                                                        data-bs-target="#editUser" data-backdrop="static"
                                                                        data-myid="{{ $usr->id }}"
                                                                        data-lastname="{{ $usr->last_name }}"
                                                                        data-othernames="{{ $usr->other_names }}"
                                                                        data-email="{{ $usr->email }}"
                                                                        data-phone="{{ $usr->phone_number }}"
                                                                        data-station="{{ $usr->station }}"
                                                                        data-role="{{ $usr->role_id }}"
                                                                        data-status="{{ ucwords($usr->status) }}"><i
                                                                            class="fe fe-eye dropdown-item-icon"></i>Edit
                                                                        User Details</a>
                                                                    @if ($usr->status == 'active')
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('admin.suspendUser', [$usr->id]) }}"  onclick="return confirm('Are you sure you want to suspend this user account');"><i
                                                                                class="fe fe-trash dropdown-item-icon"
                                                                               ></i>Suspend
                                                                            User</a>
                                                                    @else
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('admin.activateUser', [$usr->id]) }}"
                                                                            onclick="return confirm('Are you sure you want to activate this user account');"><i
                                                                                class="fe fe-trash dropdown-item-icon"></i>Activate
                                                                            User</a>
                                                                    @endif
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
                <h3 class="offcanvas-title" id="offcanvasExampleLabel">Create New User Account</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.storeUser') }}">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">Surname <span class="text-danger">*</span></label>
                            <input type="text" name="surname" class="form-control" placeholder="Enter Surname" required>
                            <div class="invalid-feedback">Please provide surname.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Other Names <span class="text-danger">*</span></label>
                            <input type="text" name="other_names" class="form-control" placeholder="Enter Other Names"
                                required>
                            <div class="invalid-feedback">Please provide other_names.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                            <div class="invalid-feedback">Please provide email.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone_number" class="form-control" placeholder="Enter Phone Number"
                                required>
                            <div class="invalid-feedback">Please provide phone number.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">User Role <span class="text-danger">*</span></label>
                            <select id="role" name="role" class="form-select" data-width="100%" required>
                                <option value="">Select User Role</option>
                                @foreach ($userRoles as $role)
                                    <option value="{{ $role->id }}">{{ $role->role }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select user role.</div>
                        </div>

                        <input type="hidden" name="station" value="{{ $terminal->id }}" class="form-control" required>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Create User Account</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="editUser" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Update User Account Information</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.updateUser') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">Surname <span class="text-danger">*</span></label>
                            <input id="lastname" type="text" name="surname" class="form-control" placeholder="Enter Role" required>
                            <div class="invalid-feedback">Please provide surname.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Other Names <span class="text-danger">*</span></label>
                            <input id="othernames" type="text" name="other_names" class="form-control" placeholder="Enter Role"
                                required>
                            <div class="invalid-feedback">Please provide other_names.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input id="email" type="email" name="email" class="form-control" placeholder="Enter Role" required>
                            <div class="invalid-feedback">Please provide email.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input id="phone" type="text" name="phone_number" class="form-control" placeholder="Enter Role"
                                required>
                            <div class="invalid-feedback">Please provide phone number.</div>
                        </div>

                         <div class="mb-3 col-12">
                            <label class="form-label">User Role <span class="text-danger">*</span></label>
                            <select id="usrrole" name="role" class="form-select" data-width="100%" required>
                                <option value="">Select User Role</option>
                                @foreach ($userRoles as $role)
                                    <option value="{{ $role->id }}">{{ $role->role }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select user role.</div>
                        </div>

                        <input type="hidden" name="station" value="{{ $terminal->id }}" class="form-control" required>
                        <input id="myid" type="hidden" name="user_id" class="form-control" required>

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
        document.getElementById("admins").classList.add('active');
    </script>
@endsection
