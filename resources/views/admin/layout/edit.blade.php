@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-layout-edit') !!}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($layout, ['route' => ['admin.layout.update', $layout],'class' => '', 'method' => 'patch', 'files' => true ]) !!}

                @include('admin.layout.fields')

                {!! Form::close() !!}

            </div>
        </div>
    </section>
@endsection