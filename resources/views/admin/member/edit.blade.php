@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-member-edit') !!}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">

                {!! Form::model($member, ['route' => ['admin.member.update', $member],'class' => '', 'method' => 'patch', 'files' => true ]) !!}

                @include('admin.member.fields')

                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection