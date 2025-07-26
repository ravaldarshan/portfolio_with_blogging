@extends('frontpage.layouts.main')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg-color"
        data-setbgcolor="{{ $settings['general_breadcrumb_color'] ?? '#1e2a45' }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Portfolio</h2>
                        <div class="breadcrumb__links">
                            <a href="{{ route('web.index') }}">Home</a>
                            <span>Project</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Portfolio Section Begin -->
    <section class="portfolio spad">
        <div class="container" id="projectData">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="portfolio__filter">
                        <li class="active" data-filter="*">All</li>
                        @foreach ($kategori as $col)
                            <li data-filter=".{{ $col->slug }}">{{ $col->nama }}</li>
                        @endforeach

                    </ul>
                </div>
            </div>

            <div class="row portfolio__gallery">
                @foreach ($project as $row)
                    @php
                        $img_url = json_decode($row->img_url);
                    @endphp
                    <div class="col-lg-4 col-md-6 col-sm-6 mix {{ $row->kategori_project->slug }}">
                        <div class="portfolio__item">
                            <div class="portfolio__item__video set-bg" data-setbg="{{ img_src($img_url[0], 'project') }}">
                                <a href="{{ route('web.project.slug', $row->slug) }}" class="play-btn "><i
                                        class="fa fa-arrow-right"></i></a>
                            </div>
                            <div class="portfolio__item__text">
                                <h4>{{ $row->nama }}</h4>
                                <ul>
                                    <li>{{ $row->kategori_project->nama }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $project->links('frontpage.layouts.pagination.index') }}

        </div>
    </section>
    <!-- Portfolio Section End -->
@endsection


@push('js')
    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('click', '.pagination__option a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });

            function fetch_data(page) {
                $.ajax({
                    url: "{{ route('web.project.fetchData') }}?page=" + page,
                    success: function(data) {
                        $('#projectData').html(data);
                        $('.set-bg').each(function() {
                            var bg = $(this).data('setbg');
                            $(this).css('background-image', 'url(' + bg + ')');
                        });
                        $('.portfolio__filter li').on('click', function() {
                            $('.portfolio__filter li').removeClass('active');
                            $(this).addClass('active');
                        });
                        if ($('.portfolio__gallery').length > 0) {
                            var containerEl = document.querySelector('.portfolio__gallery');
                            var mixer = mixitup(containerEl);
                        }
                    },
                });
            }
        });
    </script>
@endpush
