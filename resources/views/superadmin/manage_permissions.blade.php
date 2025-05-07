@extends('superadmin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <a href="{{ route("superadmin.manageRoles") }}" class="back-to-home-label">
                            <i class="fas fa-arrow-left"></i> Back to Roles Management
                        </a>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Permissions For User Role:
                                    <u>{{ $role->role }}</u></h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table mb-0 text-nowrap table-hover table-centered table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Platform Features</th>
                                            <th scope="col">Feature Permission</th>
                                            <th scope="col">Can Create</th>
                                            <th scope="col">Can Edit</th>
                                            <th scope="col">Can Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($platformFeatures as $feature)
                                            <tr>
                                                <td> <strong>{{ $feature->feature }} </strong></td>
                                                <td>
                                                    @if ($role->featurePermission($feature->id) == 1)
                                                        <a href="{{ route('superadmin.revokeFeaturePermission', [$role->id, $feature->id]) }}"
                                                            onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                                class="btn btn-success btn-sm">Revoke
                                                                Permission</button></a>
                                                    @else
                                                        <a href="{{ route('superadmin.grantFeaturePermission', [$role->id, $feature->id]) }}"
                                                            onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                                class="btn btn-primary btn-sm">Grant
                                                                Permission</button></a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($role->featurePermission($feature->id) == 1)
                                                        @if ($role->createPermission($feature->id) == 1)
                                                        <a href="{{ route('superadmin.revokeCreatePermission', [$role->id, $feature->id]) }}"
                                                            onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                                class="btn btn-success btn-sm">Revoke
                                                                Permission</button></a>
                                                        @else
                                                        <a href="{{ route('superadmin.grantCreatePermission', [$role->id, $feature->id]) }}"
                                                            onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                                class="btn btn-primary btn-sm">Grant
                                                                Permission</button></a>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-secondary btn-sm">Grant Permission</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($role->featurePermission($feature->id) == 1)
                                                        @if ($role->editPermission($feature->id) == 1)
                                                        <a href="{{ route('superadmin.revokeEditPermission', [$role->id, $feature->id]) }}"
                                                            onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                                class="btn btn-success btn-sm">Revoke
                                                                Permission</button></a>
                                                        @else
                                                        <a href="{{ route('superadmin.grantEditPermission', [$role->id, $feature->id]) }}"
                                                            onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                                class="btn btn-primary btn-sm">Grant
                                                                Permission</button></a>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-secondary btn-sm">Grant Permission</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($role->featurePermission($feature->id) == 1)
                                                        @if ($role->deletePermission($feature->id) == 1)
                                                        <a href="{{ route('superadmin.revokeDeletePermission', [$role->id, $feature->id]) }}"
                                                            onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                                class="btn btn-success btn-sm">Revoke
                                                                Permission</button></a>
                                                        @else
                                                        <a href="{{ route('superadmin.grantDeletePermission', [$role->id, $feature->id]) }}"
                                                            onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                                class="btn btn-primary btn-sm">Grant
                                                                Permission</button></a>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-secondary btn-sm">Grant Permission</button>
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


    <script type="text/javascript">
         document.getElementById("settings").classList.add('active');
        document.getElementById("platform").classList.add('show');
        document.getElementById("roles").classList.add('active');
    </script>
@endsection
