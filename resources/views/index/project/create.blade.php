@extends('index.layouts.layout')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('index-project-create') !!}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">

                {!! Form::open(['route' => 'project.store','class' => '']) !!}

                @include('index.project.fields')

                {!! Form::close() !!}

            </div>
        </div>
    </section>
@endsection

