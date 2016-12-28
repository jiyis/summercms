@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-search-edit') !!}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($search, ['route' => ['admin.search.update', $search],'class' => 'form-horizontal form-bordered', 'method' => 'patch', 'files' => true ]) !!}

                @include('admin.search.fields')

                {!! Form::close() !!}

            </div>
        </div>
    </section>
@endsection