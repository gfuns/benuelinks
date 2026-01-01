@extends('superadmin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Extra Luggage Fee Configuration</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="example" class="table mb-0 text-nowrap table-hover table-centered">
                                    <thead>
                                        <tr>
                                            <th scope="col">S/No.</th>
                                            <th scope="col">Configuration Name</th>
                                            <th scope="col">Fee Per KG</th>
                                            <th scope="col">Date Created</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                                <td class="align-middle"> 1. </td>
                                                <td class="align-middle"> {{ $config->configuration_name }} </td>
                                                <td class="align-middle"> &#8358; {{ number_format($config->value, 2) }} </td>
                                                <td class="align-middle"> {{ date_format($config->created_at, 'jS F, Y') }}
                                                </td>
                                                <td class="align-middle">
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
                                                                        data-bs-target="#editFee" data-backdrop="static"
                                                                        data-myid="{{ $config->id }}"
                                                                        data-fee="{{ $config->value }}"><i
                                                                            class="fe fe-eye dropdown-item-icon"></i>Edit
                                                                        Fee Amount</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                </td>
                                            </tr>

                                    </tbody>

                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="editFee" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Update Fee Amount</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('superadmin.updateExtraLuggaeFee') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">Fee <span class="text-danger">*</span></label>
                            <input id="fee" type="text" name="fee" class="form-control"
                                placeholder="Enter Fee" required>
                            <div class="invalid-feedback">Please provide fee.</div>
                        </div>

                        <input id="myid" type="hidden" name="config_id" class="form-control" required>

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
        document.getElementById("luggageFee").classList.add('active');
    </script>
@endsection
