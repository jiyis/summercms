@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-team-edit') !!}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($team, ['route' => ['admin.team.update', $team],'class' => 'form-horizontal form-bordered', 'method' => 'patch', 'files' => true ]) !!}

                @include('admin.team.fields')

                {!! Form::close() !!}

            </div>
        </div>
    </section>
@endsection