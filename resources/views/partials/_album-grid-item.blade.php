@inject('albumHelper', 'App\Helpers\Album')

<div class="album-grid-item">
    <div class="album-grid-image-wrapper">
        <a href="{{ $album->permalink }}">
            <img class="album-grid-image" src="{{ $album->image }}">
        </a>
    </div>
    <div class="album-grid-description">
        @if(isset($hasBands))
        <h4 class="album-grid-subtitle">{!! $albumHelper->bandLinks($album) !!}</h4>
        @endif
        <h3 class="album-grid-title"><a href="{{ $album->permalink }}">{{ $album->title }}</a></h3>
        <div class="album-grid-meta">
            @if($album->published_at)
                {{ $album->published_at->format('Y') }} &middot;
            @endif
            {{ $album->type }}</div>
        <div class="album-grid-meta">{{ $album->label }}</div>
        @includeWhen($album->review_count, 'partials._review-score')
    </div>
</div>