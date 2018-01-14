@extends('index.layouts.layout')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('index-project-edit') !!}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">

                {!! Form::model($project, ['route' => ['project.update', $project],'class' => '', 'method' => 'patch', 'files' => true ]) !!}

                @include('index.project.fields')

                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection