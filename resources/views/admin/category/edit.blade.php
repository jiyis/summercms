@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-category-edit') !!}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($category, ['route' => ['admin.category.update', $category],'class' => '', 'method' => 'patch', 'files' => true ]) !!}

                @include('admin.category.fields')

                {!! Form::close() !!}

            </div>
        </div>
    </section>
@endsection