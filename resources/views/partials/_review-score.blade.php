<div class="review-wrapper">
    <div class="review-score review-score-{{ round($album->median_score, -1) }}">{{ $album->median_score }}%</div>
    <div class="review-count">{{ $album->review_count }} {{ str_plural('review', $album->review_count) }}</div>
</div>