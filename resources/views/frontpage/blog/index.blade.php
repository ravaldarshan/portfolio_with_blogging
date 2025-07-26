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
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        @php
                            $jsonParse = json_decode($row->img_url);
                        @endphp
                        <div class="blog__item set-bg-blog" data-setbg="{{ img_src($jsonParse[0], 'blog') }}">
                            <h4>{{ $row->judul }}</h4>
                            <ul>
                                <li>{{ date('F d, Y', strtotime($row->tanggal_posting)) }}</li>
                                <li>{{$row->komentar_blog->count() + $row->komentar_blog_reply->count()}} Comment</li>
                            </ul>
                            <p>{{ Str::limit(strip_tags($row->isi), 100) }}</p>
                            <a href="{{ route('web.blog.slug', $row->slug) }}">Read more <span
                                    class="arrow_right"></span></a>
                        </div>
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
                    $(this).css('background-image', ''); // Clear background image on mouse out
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
                                ''); // Clear background image on mouse out
                            }
                        );
                    },
                });
            }
        });
    </script>
@endpush
