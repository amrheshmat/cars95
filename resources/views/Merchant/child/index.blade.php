@extends('layouts.merchant')

@section('content')

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        List
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-Medical-Request">
                                <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>email</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($requests as $key => $request)
                                    <tr data-entry-id="{{ $request->id }}">
                                        <td>

                                        </td>
                                        <td>{{ $request->id ?? '' }}</td>
                                        <td>{{ $request->name ?? '' }}</td>
                                        <td>{{ $request->email ?? '' }}</td>
                                        <td></td>
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
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


            $.extend(true, $.fn.dataTable.defaults, {
                order: [[1, 'desc']],
                pageLength: 100,
            });
            $('.datatable-Medical-Request:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection