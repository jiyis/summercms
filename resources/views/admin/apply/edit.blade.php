@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-apply-edit') !!}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($apply, ['route' => ['admin.apply.update', $apply],'class' => 'form-horizontal form-bordered', 'method' => 'patch', 'files' => true ]) !!}

                @include('admin.apply.fields')

                {!! Form::close() !!}

            </div>
        </div>
    </section>
@endsection