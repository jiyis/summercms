@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-team-create') !!}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(['route' => 'admin.team.store','class' => '']) !!}

                @include('admin.team.fields')

                {!! Form::close() !!}

            </div>
        </div>
    </section>
@endsection

