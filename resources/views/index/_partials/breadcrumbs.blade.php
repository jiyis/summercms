@if($breadcrumbs)
    <h1>

        {{ $breadcrumbs[1]->title }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!$loop->last)
                <li><a href="{{ $breadcrumb->url }}"><i class="fa fa-dashboard"></i>{{ $breadcrumb->title }}</a></li>
            @else
                <li class="active">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ol>
@endif