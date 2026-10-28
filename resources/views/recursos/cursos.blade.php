<div class="rbt-course-area bg-color-extra2 rbt-section-gap" id="cursos">
    <div class="container">
        <div class="row mb--60">
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <span class="subtitle bg-secondary-opacity">{{ $courseSection->eyebrow }}</span>
                    <h2 class="title">{{ $courseSection->title }}</h2>
                </div>
            </div>
        </div>
        <div class="row g-5">
            @forelse ($courses as $course)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="rbt-card variation-01 rbt-hover">
                        @if ($course->image_url)
                            <div class="rbt-card-img">
                                <a href="{{ $course->public_url }}">
                                    <img src="{{ $course->image_url }}" alt="{{ $course->image_alt ?: $course->title }}"
                                        loading="lazy" style="aspect-ratio: 8 / 5; object-fit: cover;">
                                    @if ($course->badge_text)
                                        <div class="rbt-badge-3 bg-white">
                                            <span>{{ $course->badge_text }}</span>
                                            @if ($course->badge_caption)
                                                <span>{{ $course->badge_caption }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </a>
                            </div>
                        @elseif ($course->badge_text)
                            <span class="rbt-badge-6">{{ $course->badge_text }} {{ $course->badge_caption }}</span>
                        @endif
                        <div class="rbt-card-body">
                            @if ($course->rating !== null || $course->reviews_count !== null)
                                <div class="rbt-card-top">
                                    <div class="rbt-review">
                                        @if ($course->rating !== null)
                                            <div class="rating" aria-label="{{ $course->rating }} / 5">
                                                @for ($star = 1; $star <= 5; $star++)
                                                    <i class="{{ $star <= $course->rating ? 'fas' : 'far' }} fa-star" aria-hidden="true"></i>
                                                @endfor
                                            </div>
                                        @endif
                                        @if ($course->reviews_count !== null)
                                            <span class="rating-count">({{ $course->reviews_count }} {{ $course->reviews_label }})</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <h4 class="rbt-card-title"><a href="{{ $course->public_url }}">{{ $course->title }}</a></h4>
                            @if ($course->lessons_count !== null || $course->students_count !== null)
                                <ul class="rbt-meta">
                                    @if ($course->lessons_count !== null)
                                        <li><i class="feather-book" aria-hidden="true"></i>{{ $course->lessons_count }} {{ $course->lessons_label }}</li>
                                    @endif
                                    @if ($course->students_count !== null)
                                        <li><i class="feather-users" aria-hidden="true"></i>{{ $course->students_count }} {{ $course->students_label }}</li>
                                    @endif
                                </ul>
                            @endif
                            <p class="rbt-card-text" style="white-space: pre-line;">{{ $course->description }}</p>
                            @if ($course->instructor || $course->category)
                                <div class="rbt-author-meta mb--20">
                                    @if ($course->instructor && $course->instructor_image_url)
                                        <div class="rbt-avater">
                                            <img src="{{ $course->instructor_image_url }}" alt="{{ $course->instructor }}" loading="lazy">
                                        </div>
                                    @endif
                                    <div class="rbt-author-info">
                                        {{ $course->instructor }}
                                        @if ($course->instructor && $course->category) · @endif
                                        {{ $course->category }}
                                    </div>
                                </div>
                            @endif
                            <div class="rbt-card-bottom">
                                @if ($course->price !== null)
                                    <div class="rbt-price">
                                        <span class="current-price">{{ $course->currency }}{{ number_format($course->price, 2, ',', '.') }}</span>
                                        @if ($course->original_price !== null && $course->original_price > $course->price)
                                            <span class="off-price">{{ $course->currency }}{{ number_format($course->original_price, 2, ',', '.') }}</span>
                                        @endif
                                    </div>
                                @endif
                                <a class="rbt-btn-link" href="{{ $course->public_url }}">{{ $course->button_text }}<i class="feather-arrow-right" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center"><p>{{ $courseSection->empty_text }}</p></div>
            @endforelse
        </div>
        @if ($courseSection->button_text && $courseSection->public_url)
            <div class="load-more-btn mt--60 text-center">
                <a class="rbt-btn btn-gradient btn-lg" href="{{ $courseSection->public_url }}">{{ $courseSection->button_text }}</a>
            </div>
        @endif
    </div>
</div>
