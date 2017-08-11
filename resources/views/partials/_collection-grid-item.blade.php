<div class="collection-grid-item">

    <div class="collection-grid-item-image">
    @foreach($playlist->albums->take(4) as $album)
    <div class="collection-grid-image-wrapper">
        <img class="album-grid-image" src="{{ $album->image }}">
    </div>
    @endforeach
    </div>

    <div class="collection-grid-description">
        <div class="section-title-wrapper">
            <h3 class="section-title"><a href="{{ route('showCollection', [$playlist->slug]) }}">{{ $playlist->title }}</a></h3>
        </div>

        <p>{{ $playlist->description }}</p>
        <a href="{{ route('showCollection', [$playlist->slug]) }}" class="btn btn-primary">View collection</a>
    </div>

</div>

