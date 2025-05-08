@extends('superadmin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Terminal Management</h4>
                                <button class="btn btn-primary btn-round ms-auto btn-sm" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasRight">
                                    <i class="fa fa-plus"></i>
                                    New Terminal
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="example" class="table mb-0 text-nowrap table-hover table-centered">
                                    <thead>
                                        <tr>
                                            <th scope="col">S/No.</th>
                                            <th scope="col">Terminal</th>
                                            <th scope="col">State</th>
                                            <th scope="col">LGA</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Date Created</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($terminals as $terminal)
                                            <tr>
                                                <td class="align-middle"> {{ $loop->index + 1 }} </td>
                                                <td class="align-middle"> {{ $terminal->terminal }} </td>
                                                <td class="align-middle">{{ $terminal->state }}</td>
                                                <td class="align-middle">{{ $terminal->lga }}</td>
                                                <td class="align-middle">{{ $terminal->address }}</td>
                                                <td>
                                                    @if ($terminal->status == 'active')
                                                        <span class="badge badge-success p-2"
                                                            style="font-size: 10px">{{ ucwords($terminal->status) }}</span>
                                                    @else
                                                        <span class="badge badge-warning p-2"
                                                            style="font-size: 10px">{{ ucwords($terminal->status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    {{ date_format($terminal->created_at, 'jS F, Y') }}
                                                </td>
                                                <td class="align-middle">

                                                    <div class="btn-group dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu" style="">
                                                            <li>
                                                                <a class="dropdown-item mb-2" href="#"
                                                                    data-bs-toggle="offcanvas"
                                                                    data-bs-target="#editTerminal" data-backdrop="static"
                                                                    data-myid="{{ $terminal->id }}"
                                                                    data-terminal="{{ $terminal->terminal }}"
                                                                    data-state="{{ $terminal->state }}"
                                                                    data-lga="{{ $terminal->lga }}"
                                                                    data-address="{{ $terminal->address }}"><i
                                                                        class="fe fe-eye dropdown-item-icon"></i>Edit
                                                                    Terminal</a>
                                                                @if ($terminal->id != 1)
                                                                    @if ($terminal->status == 'active')
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('superadmin.deactivateTerminal', [$terminal->id]) }}"
                                                                            onclick="return confirm('Are you sure you want to deactivate this terminal');"><i
                                                                                class="fe fe-trash dropdown-item-icon"></i>Deactivate
                                                                            Terminal</a>
                                                                    @else
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('superadmin.activateTerminal', [$terminal->id]) }}"
                                                                            onclick="return confirm('Are you sure you want to activate this terminal');"><i
                                                                                class="fe fe-trash dropdown-item-icon"></i>Activate
                                                                            Terminal</a>
                                                                    @endif
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>

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
                <h3 class="offcanvas-title" id="offcanvasExampleLabel">Create New Terminal</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('superadmin.storeTerminal') }}">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Terminal</strong> <span class="text-danger">*</span></label>
                            <input type="text" name="terminal" class="form-control" placeholder="Enter Terminal"
                                required>
                            <div class="invalid-feedback">Please provide terminal.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>State</strong> <span class="text-danger">*</span></label>
                            <select id="state" name="state" class="form-select" data-width="100%" required>
                                <option value="">Select State</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->state }}">{{ $state->state }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select state.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>LGA</strong> <span class="text-danger">*</span></label>
                            <input type="text" name="lga" class="form-control" placeholder="Enter LGA" required>
                            <div class="invalid-feedback">Please provide lga.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Address</strong> <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control" placeholder="Terminal Address"
                                required>
                            <div class="invalid-feedback">Please provide address.</div>
                        </div>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Create Terminal</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="editTerminal" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Update Terminal Information</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post"
                    action="{{ route('superadmin.updateTerminal') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Terminal</strong> <span class="text-danger">*</span></label>
                            <input id="terminal" type="text" name="terminal" class="form-control"
                                placeholder="Enter Terminal" required>
                            <div class="invalid-feedback">Please provide terminal.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>State</strong> <span class="text-danger">*</span></label>
                            <select id="ustate" name="state" class="form-select" data-width="100%" required>
                                <option value="">Select State</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->state }}">{{ $state->state }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select state.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>LGA</strong> <span class="text-danger">*</span></label>
                            <input id="lga" type="text" name="lga" class="form-control"
                                placeholder="Enter LGA" required>
                            <div class="invalid-feedback">Please provide lga.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Address</strong> <span class="text-danger">*</span></label>
                            <input id="address" type="text" name="address" class="form-control"
                                placeholder="Terminal Address" required>
                            <div class="invalid-feedback">Please provide address.</div>
                        </div>

                        <input id="myid" type="hidden" name="terminal_id" class="form-control" required>

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
        document.getElementById("terminals").classList.add('active');
    </script>
@endsection
