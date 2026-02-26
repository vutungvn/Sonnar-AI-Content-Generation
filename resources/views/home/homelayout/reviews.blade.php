<div class="lonyo-section-padding position-relative overflow-hidden">
    <div class="container">
        <div class="lonyo-section-title">
            <div class="row">

                @php
                    $title = App\Models\Title::find(1);
                @endphp

                <div class="col-xl-8 col-lg-8">
                    <h2 id="reviews-title" contenteditable="{{ auth()->check() ? 'true' : 'false' }}"
                        data-id="{{ $title->id }}">{{ $title->reviews }}</h2>
                </div>

                <div class="col-xl-4 col-lg-4 d-flex align-items-center justify-content-end">
                    <div class="lonyo-title-btn">
                        <a class="lonyo-default-btn t-btn" href="contact-us.html">Read Customer Stories</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lonyo-testimonial-slider-init">

        @php
            $reviews = App\Models\Review::latest()->get();
        @endphp

        @foreach ($reviews as $review)
            <div class="lonyo-t-wrap wrap2 light-bg">
                <div class="lonyo-t-ratting">
                    <img src="{{ asset('frontend/assets/images/shape/star.svg') }}" alt="">
                </div>
                <div class="lonyo-t-text">
                    <p>{{ $review->message }}</p>
                </div>
                <div class="lonyo-t-author">
                    <div class="lonyo-t-author-thumb">
                        <img src="{{ asset($review->image) }}" style="border-radius: 10px;" alt="">
                    </div>
                    <div class="lonyo-t-author-data">
                        <p>{{ $review->name }}</p>
                        <span>{{ $review->position }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="lonyo-t-overlay2">
        <img src="{{ asset('frontend/assets/images/v2/overlay.png') }}" alt="">
    </div>
</div>

{{-- CSRF Token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const titleElement = document.getElementById('reviews-title');

        function saveChanges(element) {
            let reviewsId = element.dataset.id;
            let field = element.id === 'reviews-title' ? 'reviews' : '';
            let newValue = element.innerText.trim();

            fetch(`/edit-reviews/${reviewsId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ [field]: newValue })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(`${field} updated successfully`);
                    }
                })
                .catch(error => {
                    console.error('Error updating reviews:', error);
                });
        }

        // Auto save on Enter key
        titleElement.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                saveChanges(e.target);
            }
        })

        // Auto save on Losing Focus
        titleElement.addEventListener('blur', function () {
            saveChanges(titleElement);
        })
    })
</script>