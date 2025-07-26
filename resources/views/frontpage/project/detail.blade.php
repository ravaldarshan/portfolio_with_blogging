@extends('frontpage.layouts.main')
@push('css')
    <style>
        .bootdey {
            border: 1px solid rgba(225, 225, 225, 0.5);
        }

        .img-sm {
            width: 46px;
            height: 46px;
        }

        .panel {
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.075);
            border-radius: 0;
            border: 0;
            margin-bottom: 15px;
        }

        .panel .panel-footer,
        .panel>:last-child {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        .panel .panel-heading,
        .panel>:first-child {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .panel-body {
            padding: 20px 15px;
        }


        .media-block .media-left {
            display: block;
            float: left
        }

        .media-block .media-right {
            float: right
        }

        .media-block .media-body {
            display: block;
            overflow: hidden;
            width: auto
        }

        .middle .media-left,
        .middle .media-right,
        .middle .media-body {
            vertical-align: middle
        }

        .thumbnail {
            border-radius: 0;
            border-color: #e9e9e9
        }

        .tag.tag-sm,
        .btn-group-sm>.tag {
            padding: 5px 10px;
        }

        .tag:not(.label) {
            background-color: #fff;
            padding: 6px 12px;
            border-radius: 2px;
            border: 1px solid #cdd6e1;
            font-size: 12px;
            line-height: 1.42857;
            vertical-align: middle;
            -webkit-transition: all .15s;
            transition: all .15s;
        }

        .text-muted,
        a.text-muted:hover,
        a.text-muted:focus {
            color: #acacac;
        }

        .text-sm {
            font-size: 0.9em;
        }

        .text-5x,
        .text-4x,
        .text-5x,
        .text-2x,
        .text-lg,
        .text-sm,
        .text-xs {
            line-height: 1.25;
        }

        .btn-trans {
            background-color: transparent;
            border-color: transparent;
            color: #929292;
        }

        .btn-icon {
            padding-left: 9px;
            padding-right: 9px;
        }

        .btn-sm,
        .btn-group-sm>.btn,
        .btn-icon.btn-sm {
            padding: 5px 10px !important;
        }

        .mar-top {
            margin-top: 15px;
        }
    </style>
@endpush
@section('content')
    <!-- Blog Details Hero Begin -->
    <section class="blog-hero spad set-bg-color" data-setbgcolor="{{ $settings['general_breadcrumb_color'] ?? '#1e2a45' }}">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <div class="blog__hero__text">
                        <h2>{{ $data->nama }}</h2>
                        <ul>
                            <li>{{ date('F d, Y', strtotime($data->created_at)) }}</li>
                            <li>{{ $countComment }} Comment</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Hero End -->

    <!-- Blog Details Section Begin -->
    <div class="blog-details spad">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <div class="blog__details__content">
                        <div class="blog__details__text">
                            {{-- <img src="{{img_src($decodeImg[0], 'project')}}"> --}}
                            <div id="image" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @foreach ($decodeImg as $key => $item)
                                        <li data-target="#image" data-slide-to="{{ $key }}"
                                            @if ($key === 0) class="active" @endif></li>
                                    @endforeach
                                </ol>
                                <div class="carousel-inner">
                                    @foreach ($decodeImg as $key => $item)
                                        <div class="carousel-item @if ($key === 0) active @endif ">
                                            <img class="d-block w-100" src="{{ img_src($item, 'project') }}"
                                                alt="First slide">
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#image" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#image" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class="blog__details__desc">
                            {!! $data->deskripsi !!}
                        </div>
                        <div class="blog__details__tags">
                            <span><i class="fa fa-tag"></i> Tag:</span>
                            <a href="#">{{ $data->kategori_project->nama }}</a>
                        </div>
                        <div class="blog__details__option">
                            <div class="row">
                                @foreach ($previous as $key => $row)
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <a href="{{ route('web.project.slug', $row->slug) }}"
                                            class="blog__details__option__item @if ($key === 1) blog__details__option__item--right @endif">
                                            <h5><i
                                                    class="fa fa-angle-@if ($key === 1) right @else left @endif"></i>
                                                Previous project</h5>
                                            <div class="blog__details__option__item__img">
                                                @php
                                                    $decodeImgPrevious = json_decode($row->img_url);
                                                @endphp
                                                <img width="150px" src="{{ img_src($decodeImgPrevious[0], 'project') }}"
                                                    alt="">
                                            </div>
                                            <div class="blog__details__option__item__text">
                                                <h6>{{ $row->nama }}</h6>
                                                <span>{{ date('F d, Y', strtotime($row->created_at)) }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="blog__details__recent">
                            <h4>Recent Project</h4>
                            <div class="row">
                                @foreach ($recent as $row)
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <a href="{{ route('web.project.slug', $row->slug) }}">
                                            <div class="blog__details__recent__item">
                                                @php
                                                    $decodeImgRecent = json_decode($row->img_url);
                                                @endphp
                                                <img src="{{ img_src($decodeImgRecent[0], 'project') }}" alt="">
                                                <h5>{{ $row->nama }}</h5>
                                                <span>{{ date('F d, Y', strtotime($row->created_at)) }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="blog__details__comment">
                            <h4>Leave a comment</h4>
                            <form>
                                <textarea placeholder="Comment" name="comment" id="inputComment"></textarea>
                                <button type="submit" class="site-btn" id="triggerSubmitCommment">Submit</button>
                            </form>
                        </div>

                        <div class="container bootdey">
                            <div class="col-md-12 bootstrap snippets">
                                <div class="panel">
                                    <div class="panel-body" id="sectionCommentHtml">
                                        <!-- Newsfeed Content -->
                                        <!--===================================================-->

                                        @foreach ($comment as $row)
                                            <div class="media-block comment-section">
                                                <a class="media-left" href="#"><img class="img-circle img-sm mr-3"
                                                        alt="Profile Picture"
                                                        src="https://bootdey.com/img/Content/avatar/avatar{{ mt_rand(1, 8) }}.png"></a>
                                                <div class="media-body">
                                                    <div class="mar-btm">
                                                        <a href="#"
                                                            class="text-white text-semibold media-heading box-inline">Anonymous.</a>
                                                        <p class="text-sm">
                                                            {{ Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                    <p class="text-white">{{ $row->isi }}</p>
                                                    <div class="pad-ver">
                                                        <div class="btn-group">
                                                            <a class="btn btn-sm btn-default btn-hover-success"
                                                                href="javascript:void(0)"><i
                                                                    class="fa fa-thumbs-up"></i></a>
                                                            <a class="btn btn-sm btn-default btn-hover-danger"
                                                                href="javascript:void(0)"><i
                                                                    class="fa fa-thumbs-down"></i></a>
                                                        </div>
                                                        <a class="btn btn-sm btn-default btn-hover-primary triggerReplay"
                                                            href="javascript:void(0)">Comment</a>
                                                        <div class="panel sectionReply d-none">
                                                            <div class="panel-body">
                                                                <textarea class="form-control" rows="2" placeholder="What are you thinking?"></textarea>
                                                                <div class="mar-top clearfix">
                                                                    <a href="javascript:void(0)"
                                                                        data-id="{{ $row->id }}"
                                                                        class="btn btn-sm btn-primary pull-right triggerCommentReply"><i
                                                                            class="fa fa-pencil fa-fw"></i>
                                                                        Share</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>

                                                    @foreach ($row->reply as $item)
                                                        <!-- Comments -->
                                                        <div>
                                                            <div class="media-block">
                                                                <a class="media-left" href="#"><img
                                                                        class="img-circle img-sm mr-3"
                                                                        alt="Profile Picture"
                                                                        src="https://bootdey.com/img/Content/avatar/avatar{{ mt_rand(1, 8) }}.png"></a>
                                                                <div class="media-body">
                                                                    <div class="mar-btm">
                                                                        <a href="javascript:void(0)"
                                                                            class="text-white text-semibold media-heading box-inline">Anonymous</a>
                                                                        <p class="text-sm">
                                                                            {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                                                        </p>
                                                                    </div>
                                                                    <p class="text-white">{{ $item->isi }}</p>
                                                                    <div class="pad-ver">
                                                                        <div class="btn-group">
                                                                            <a class="btn btn-sm btn-default btn-hover-success active"
                                                                                href="javascript:void(0)"><i
                                                                                    class="fa fa-thumbs-up"></i></a>
                                                                            <a class="btn btn-sm btn-default btn-hover-danger"
                                                                                href="javascript:void(0)"><i
                                                                                    class="fa fa-thumbs-down"></i></a>
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        @endforeach
                                        <!--===================================================-->
                                        <!-- End Newsfeed Content -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Details Section End -->
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#triggerSubmitCommment').on('click', function(e) {
                e.preventDefault();

                var submitButton = $(this);

                if ($('#inputComment').val() != '') {
                    // Disable the submit button and show loading state
                    submitButton.prop('disabled', true).text('Submitting...');

                    $.ajax({
                        type: "POST",
                        url: "{{ route('web.project.slug.comment', $data->slug) }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": "POST",
                            "comment": $('#inputComment').val(),
                        },
                        success: function() {
                            // Enable the submit button and restore its original text
                            submitButton.prop('disabled', false).text('Submit');

                            $.ajax({
                                url: "{{ route('web.project.fetchData.comment') }}",
                                data: {
                                    slug: "{{ $data->slug }}"
                                },
                                success: function(data) {
                                    $('#sectionCommentHtml').html(data);
                                    $('#inputComment').val('')
                                },
                            });
                        },
                        error: function() {
                            // Handle errors if needed
                            // Enable the submit button and restore its original text
                            submitButton.prop('disabled', false).text('Submit');
                        }
                    });
                }
            });


            $('.triggerCommentReply').on('click', function(e) {
                e.preventDefault();

                var comment_id = $(this).data('id');

                // Find the closest comment section
                var commentSection = $(this).closest('.comment-section');

                // Find the textarea within the comment section
                var textarea = commentSection.find('.sectionReply textarea');

                // Your code to handle the reply
                if (textarea.val() != '') {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('web.project.slug.comment.reply', $data->slug) }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": "POST",
                            "comment": textarea.val(),
                            komentar_id: comment_id
                        },
                        success: function() {
                            $.ajax({
                                url: "{{ route('web.project.fetchData.comment') }}",
                                data: {
                                    slug: "{{ $data->slug }}",
                                },
                                success: function(data) {
                                    $('#sectionCommentHtml').html(data);
                                    textarea.val('');
                                },
                            });
                        }
                    });
                }
            });

            $('.triggerReplay').on('click', function() {
                var sectionReply = $(this).closest('.comment-section').find('.sectionReply');
                if (sectionReply.hasClass('d-none')) {
                    sectionReply.removeClass('d-none');
                } else {
                    sectionReply.addClass('d-none');
                }
            });


        });
    </script>
@endpush
