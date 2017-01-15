@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-partial-edit') !!}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($partial, ['route' => ['admin.partial.update', $partial],'class' => 'form-horizontal form-bordered', 'method' => 'patch', 'files' => true ]) !!}

                @include('admin.partial.fields')

                {!! Form::close() !!}

            </div>
        </div>
    </section>
@endsection