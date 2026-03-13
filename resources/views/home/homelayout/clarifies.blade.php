@php
    $clarify = App\Models\Clarifi::find(1);
@endphp

<section class="lonyo-section-padding6">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="lonyo-content-thumb" data-aos="fade-up" data-aos-duration="700">
                    <img src="{{ asset($clarify->image) }}" alt="{{ $clarify->title }}">
                </div>
            </div>
            <div class="col-lg-7 d-flex align-items-center">
                <div class="lonyo-default-content pl-50" data-aos="fade-up" data-aos-duration="700">
                    <h2 id="clarify-title" contenteditable="{{ auth()->check() ? 'true' : 'false' }}"
                        data-id="{{ $clarify->id }}">{{ $clarify->title }}</h2>
                    <p class="data" id="clarify-description" contenteditable="{{ auth()->check() ? 'true' : 'false' }}"
                        data-id="{{ $clarify->id }}">{{ $clarify->description }}</p>
                    <div class="lonyo-faq-wrap1 mt-50">
                        <div class="lonyo-faq-item open" data-aos="fade-up" data-aos-duration="500">
                            <div class="lonyo-faq-header">
                                <h4>Real-Time Expense Tracking:</h4>
                                <div class="lonyo-active-icon">
                                    <img class="plasicon" src="{{ asset('frontend/assets/images/v1/mynus.svg') }}"
                                        alt="">
                                    <img class="mynusicon" src="{{ asset('frontend/assets/images/v1/plas.svg') }}"
                                        alt="">
                                </div>
                            </div>
                            <div class="lonyo-faq-body">
                                <p>Automatically and syncs with bank accounts and credit cards to provide instant
                                    updates on spending, helping users stay aware of their all daily transactions.
                                </p>
                            </div>
                        </div>
                        <div class="lonyo-faq-item" data-aos="fade-up" data-aos-duration="700">
                            <div class="lonyo-faq-header">
                                <h4>Comprehensive Financial Overview:</h4>
                                <div class="lonyo-active-icon">
                                    <img class="plasicon" src="{{ asset('frontend/assets/images/v1/mynus.svg') }}"
                                        alt="">
                                    <img class="mynusicon" src="{{ asset('frontend/assets/images/v1/plas.svg') }}"
                                        alt="">
                                </div>
                            </div>
                            <div class="lonyo-faq-body">
                                <p>Automatically and syncs with bank accounts and credit cards to provide instant
                                    updates on spending, helping users stay aware of their all daily transactions.
                                </p>
                            </div>
                        </div>
                        <div class="lonyo-faq-item" data-aos="fade-up" data-aos-duration="900">
                            <div class="lonyo-faq-header">
                                <h4>Stress-Reducing Automation:</h4>
                                <div class="lonyo-active-icon">
                                    <img class="plasicon" src="{{ asset('frontend/assets/images/v1/mynus.svg') }}"
                                        alt="">
                                    <img class="mynusicon" src="{{ asset('frontend/assets/images/v1/plas.svg') }}"
                                        alt="">
                                </div>
                            </div>
                            <div class="lonyo-faq-body">
                                <p>Automatically and syncs with bank accounts and credit cards to provide instant
                                    updates on spending, helping users stay aware of their all daily transactions.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CSRF Token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const titleElement = document.getElementById('clarify-title');
        const descriptionElement = document.getElementById('clarify-description');

        function saveChanges(element) {
            let clarifyId = element.dataset.id;
            let field = element.id === 'clarify-title' ? 'title' : 'description';
            let newValue = element.innerText.trim();

            fetch(`/edit-clarify/${clarifyId}`, {
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
                    console.error('Error updating clarify:', error);
                });
        }

        // Auto save on Enter key
        titleElement.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                saveChanges(e.target);
            }
        })

        descriptionElement.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                saveChanges(e.target);
            }
        })

        // Auto save on Losing Focus
        titleElement.addEventListener('blur', function () {
            saveChanges(titleElement);
        })

        descriptionElement.addEventListener('blur', function () {
            saveChanges(descriptionElement);
        })
    })
</script>