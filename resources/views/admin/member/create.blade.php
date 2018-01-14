@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-member-create') !!}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">

                {!! Form::open(['route' => 'admin.member.store','class' => '']) !!}

                @include('admin.member.fields')

                {!! Form::close() !!}

            </div>
        </div>
    </section>
@endsection

