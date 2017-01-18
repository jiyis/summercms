@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-page-edit') !!}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">

                {!! Form::model($page, ['route' => ['admin.page.update', $page],'class' => '', 'method' => 'patch', 'files' => true ]) !!}

                @include('admin.page.fields')

                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection