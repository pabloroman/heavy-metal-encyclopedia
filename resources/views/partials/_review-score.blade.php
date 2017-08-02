<div class="score">
    <div class="score-bar">
        <div class="score-bar-filled score-bar-score-{{ round($album->median_score, -1) }}" style="width: {{ $album->median_score }}%"></div>
    </div>
    <div class="score-digits">
        <div class="score-points score-points-{{ round($album->median_score, -1) }}">{{ $album->median_score }}%</div>
        <div class="score-reviews">{{ $album->review_count }}&nbsp;{{ str_plural('review', $album->review_count) }}</div>
    </div>
</div>