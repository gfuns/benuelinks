@extends('superadmin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Discount Configuration</h4>
                                <button class="btn btn-primary ms-auto btn-sm" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasRight">
                                    <i class="fa fa-plus"></i>
                                    New Discount
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="example" class="table mb-0 text-nowrap table-hover table-centered">
                                    <thead>
                                        <tr>
                                            <th scope="col">S/No.</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Discount</th>
                                            <th scope="col">Date Created</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($discounts as $config)
                                            <tr>
                                                <td class="align-middle"> {{ $loop->index + 1 }} </td>
                                                <td class="align-middle"> {{ $config->configuration_name }} </td>
                                                <td class="align-middle">
                                                    @if ($config->metric == 'flat')
                                                        &#8358;
                                                        @endif{{ number_format($config->value, 2) }}@if ($config->metric == 'percentage')
                                                            %
                                                        @endif
                                                </td>
                                                <td class="align-middle"> {{ date_format($config->created_at, 'jS F, Y') }}
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
                                                                    data-bs-toggle="offcanvas" data-bs-target="#editDiscount"
                                                                    data-backdrop="static" data-myid="{{ $config->id }}"
                                                                    data-description="{{ $config->configuration_name }}"
                                                                    data-discount="{{ $config->value }}"
                                                                    data-metric="{{ $config->metric }}"><i
                                                                        class="fe fe-eye dropdown-item-icon"></i>Edit
                                                                    Discount Details</a>
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
                <h3 class="offcanvas-title" id="offcanvasExampleLabel">Create New Discount</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('superadmin.storeDiscountData') }}">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Description</strong> <span class="text-danger">*</span></label>
                            <input id="" type="text" name="description" class="form-control"
                                placeholder="Enter Description" required>
                            <div class="invalid-feedback">Please provide description.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Discount</strong> <span class="text-danger">*</span></label>
                            <input id="" type="text" name="discount" class="form-control"
                                placeholder="Enter Discount" required>
                            <div class="invalid-feedback">Please provide discount.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Metric</strong> <span class="text-danger">*</span></label>
                            <select id="metrik" name="metric" class="form-select" data-width="100%" required>
                                <option value="">Select Metric</option>
                                <option value="flat">Flat Rate</option>
                                <option value="percentage">Percentage</option>
                            </select>
                            <div class="invalid-feedback">Please provide metric.</div>
                        </div>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Create Discount</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="editDiscount" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Update Discount Details</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post"
                    action="{{ route('superadmin.updateDiscountData') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Description</strong> <span class="text-danger">*</span></label>
                            <input id="description" type="text" name="description" class="form-control"
                                placeholder="Enter Description" required>
                            <div class="invalid-feedback">Please provide description.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Discount</strong> <span class="text-danger">*</span></label>
                            <input id="discount" type="text" name="discount" class="form-control"
                                placeholder="Enter Discount" required>
                            <div class="invalid-feedback">Please provide discount.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Metric</strong> <span class="text-danger">*</span></label>
                            <select id="metric" name="metric" class="form-select" data-width="100%" required>
                                <option value="">Select Metric</option>
                                <option value="flat">Flat Rate</option>
                                <option value="percentage">Percentage</option>
                            </select>
                            <div class="invalid-feedback">Please provide metric.</div>
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
        document.getElementById("discount").classList.add('active');
    </script>
@endsection
