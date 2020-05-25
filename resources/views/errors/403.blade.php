@extends('layouts.app')
@section('content')
<!-- Main content -->
    <section class="content">
      <div class="error-page" style="width: 620px !important">
        <h2 class="headline text-danger"> 403 </h2>

        <div class="error-content">
          <h3 class="text-danger"><i class="fa fa-thumbs-o-down"></i> ERROR.</h3>
          <p>
            {!! $exception->getMessage() !!}
          </p>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
@endsection
