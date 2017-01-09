@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-template-edit') !!}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($template, ['route' => ['admin.template.update', $template],'class' => 'form-horizontal form-bordered', 'method' => 'patch', 'files' => true ]) !!}

                @include('admin.template.fields')

                {!! Form::close() !!}

            </div>
        </div>
    </section>
@endsection