<div class="page-header">
    <h2 class="header-title">{{ $title }}</h2>
    <div class="header-sub-title">
        <nav class="breadcrumb breadcrumb-dash">
            @foreach($lists as $key => $list)
            @if($loop->first)
            <a href="{{ url($list) }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>{{ $key }}</a>
            @else
            @if($loop->last)
            <span class="breadcrumb-item active">{{ $key }}</span>
            @else
            <a class="breadcrumb-item" href="{{ url($list) }}">{{ $key }}</a>
            @endif
            @endif
            @endforeach
        </nav>
    </div>
</div>