@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-layout-create') !!}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(['route' => 'admin.layout.store','class' => '']) !!}

                @include('admin.layout.fields')

                {!! Form::close() !!}

            </div>
        </div>
    </section>
@endsection

