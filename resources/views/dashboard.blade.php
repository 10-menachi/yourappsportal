@extends('layouts.app')

@section('content')
    <!-- Service 6 - Bootstrap Brain Component -->
    <section class="bsb-service-6 py-5 py-xl-8">
        <div class="container overflow-hidden">
            <div class="row gy-4 gy-md-0 gx-xxl-5">
                <div class="col-12 col-md-4">
                    <div class="card bg-transparent border-primary rounded-0">
                        <div class="card-body">
                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="50px" height="50px" viewBox="0 0 64 64"
                                enable-background="new 0 0 64 64" xml:space="preserve" fill="#1a66ad">
                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <polygon fill="none" stroke="#115ca2" stroke-width="2" stroke-miterlimit="10"
                                            points="21.903,5 55,38.097 34.097,59 1,25.903 1,5 " />
                                        <polyline fill="none" stroke="#115ca2" stroke-width="2" stroke-miterlimit="10"
                                            points="29.903,5 63,38.097 42.097,59 " />
                                        <circle fill="none" stroke="#115ca2" stroke-width="2" stroke-miterlimit="10"
                                            cx="14" cy="18" r="5" />
                                    </g>
                                </g>
                            </svg>

                            {{-- <h3 class="h2 mb-4">Products ( {{ $totalRecordsPosts }} )</h3> --}}
                            <h3 class="h2 mb-4">Products ( {{ 27 }} )</h3>

                            <a href="{{ route('products') }}" class="fw-bold text-decoration-none link-primary">
                                Products page
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card bg-transparent border-primary rounded-0">
                        <div class="card-body">
                            <svg width="50px" height="50px" viewBox="0 0 1024 1024" class="icon" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" fill="#1419b3">
                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M810.666667 277.333333c-70.4 0-128-19.2-128-42.666666v42.666666c0 23.466667 57.6 42.666667 128 42.666667s128-19.2 128-42.666667v-42.666666c0 23.466667-57.6 42.666667-128 42.666666z"
                                        fill="#258bb6" />
                                    <path
                                        d="M810.666667 213.333333c-70.4 0-128-19.2-128-42.666666v42.666666c0 23.466667 57.6 42.666667 128 42.666667s128-19.2 128-42.666667V170.666667c0 23.466667-57.6 42.666667-128 42.666666zM810.666667 341.333333c-70.4 0-128-19.2-128-42.666666v42.666666c0 23.466667 57.6 42.666667 128 42.666667s128-19.2 128-42.666667v-42.666666c0 23.466667-57.6 42.666667-128 42.666666z"
                                        fill="#258bb6" />
                                    <path
                                        d="M810.666667 405.333333c-70.4 0-128-19.2-128-42.666666v42.666666c0 23.466667 57.6 42.666667 128 42.666667s128-19.2 128-42.666667v-42.666666c0 23.466667-57.6 42.666667-128 42.666666z"
                                        fill="#258bb6" />
                                    <path
                                        d="M810.666667 469.333333c-70.4 0-128-19.2-128-42.666666v42.666666c0 23.466667 57.6 42.666667 128 42.666667s128-19.2 128-42.666667v-42.666666c0 23.466667-57.6 42.666667-128 42.666666z"
                                        fill="#258bb6" />
                                    <path
                                        d="M810.666667 533.333333c-70.4 0-128-19.2-128-42.666666v42.666666c0 23.466667 57.6 42.666667 128 42.666667s128-19.2 128-42.666667v-42.666666c0 23.466667-57.6 42.666667-128 42.666666z"
                                        fill="#258bb6" />
                                    <path
                                        d="M810.666667 597.333333c-70.4 0-128-19.2-128-42.666666v42.666666c0 23.466667 57.6 42.666667 128 42.666667s128-19.2 128-42.666667v-42.666666c0 23.466667-57.6 42.666667-128 42.666666z"
                                        fill="#258bb6" />
                                    <path
                                        d="M810.666667 661.333333c-70.4 0-128-19.2-128-42.666666v42.666666c0 23.466667 57.6 42.666667 128 42.666667s128-19.2 128-42.666667v-42.666666c0 23.466667-57.6 42.666667-128 42.666666z"
                                        fill="#258bb6" />
                                    <path
                                        d="M810.666667 725.333333c-70.4 0-128-19.2-128-42.666666v42.666666c0 23.466667 57.6 42.666667 128 42.666667s128-19.2 128-42.666667v-42.666666c0 23.466667-57.6 42.666667-128 42.666666z"
                                        fill="#258bb6" />
                                    <path
                                        d="M810.666667 789.333333c-70.4 0-128-19.2-128-42.666666v42.666666c0 23.466667 57.6 42.666667 128 42.666667s128-19.2 128-42.666667v-42.666666c0 23.466667-57.6 42.666667-128 42.666666z"
                                        fill="#258bb6" />
                                    <path
                                        d="M810.666667 853.333333c-70.4 0-128-19.2-128-42.666666v42.666666c0 23.466667 57.6 42.666667 128 42.666667s128-19.2 128-42.666667v-42.666666c0 23.466667-57.6 42.666667-128 42.666666z"
                                        fill="#258bb6" />
                                </g>
                            </svg>

                            <h3 class="h2 mb-4">Another Service</h3>

                            <a href="{{ route('services') }}" class="fw-bold text-decoration-none link-primary">
                                Services page
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
