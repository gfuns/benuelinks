@extends('superadmin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Platform Features</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-hover">
                                    <thead>
                                        <tr>
                                            <th>S/No.</th>
                                            <th>Feature Name</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($features as $ft)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td style="white-space: nowrap">{{ $ft->feature }}</td>
                                                <td>{{ $ft->description }}</td>
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
        document.getElementById("features").classList.add('active');
    </script>
@endsection
