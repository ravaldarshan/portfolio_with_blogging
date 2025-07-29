@extends('frontpage.layouts.main')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg-color"
        data-setbgcolor="{{ $settings['general_breadcrumb_color'] ?? '#1e2a45' }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Our Blog</h2>
                        <div class="breadcrumb__links">
                            <a href="{{route('web.index')}}">Home</a>
                            <span>Blog</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Blog Section Begin -->
    <section class="blog spad">
        <div class="container" id="blogSection">
            <div class="row">
                @foreach ($data as $key => $row)
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                        <a href="{{ route('web.blog.slug', $row->slug) }}" class="text-decoration-none text-dark" title="{{ $row->title }}">
                            <div class="blog__item position-relative" style="aspect-ratio: 382 / 271; overflow: hidden;">
                                @php
                                    $jsonParse = json_decode($row->img_url);
                                @endphp
                                <img src="{{ img_src($jsonParse[0], 'blog') }}" alt="{{ $row->title }}" class="w-100 h-100 object-fit-cover" style="border-radius: 5px;">
                            </div>
                            <div class="mt-2">
                                <h4 class="fw-bold mb-1 text-white">{{ $row->title }}</h4>
                                <h6 class="text-muted mb-1"></h6>
                                <small class="text-secondary">{{ date('D M d, Y', strtotime($row->posting_date)) }}</small>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
            {{ $data->links('frontpage.layouts.pagination.index') }}

        </div>
    </section>
    <!-- Blog Section End -->
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.set-bg-blog').hover(
                function() {
                    var originalBg = $(this).data('setbg');
                    $(this).css('background-image', 'url(' + originalBg + ')');
                },
                function() {
                    $(this).css('background-image', '');
                }
            );

            $(document).on('click', '.pagination__option a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });

            function fetch_data(page) {
                $.ajax({
                    url: "{{ route('web.blog.fetchData') }}?page=" + page,
                    success: function(data) {
                        $('#blogSection').html(data);
                        $('.set-bg-blog').hover(
                            function() {
                                var originalBg = $(this).data('setbg');
                                $(this).css('background-image', 'url(' + originalBg + ')');
                            },
                            function() {
                                $(this).css('background-image',
                                '');
                            }
                        );
                    },
                });
            }
        });
    </script>
@endpush
