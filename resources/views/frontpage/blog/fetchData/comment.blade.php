@foreach ($comment as $row)
    <div class="media-block comment-section">
        <a class="media-left" href="#"><img class="img-circle img-sm mr-3" alt="Profile Picture"
                src="https://bootdey.com/img/Content/avatar/avatar{{ mt_rand(1, 8) }}.png"></a>
        <div class="media-body">
            <div class="mar-btm">
                <a href="#" class="btn-link text-semibold media-heading box-inline">Anonimous.</a>
                <p class="text-muted text-sm">
                    {{ Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                </p>
            </div>
            <p>{{ $row->isi }}</p>
            <div class="pad-ver">
                <div class="btn-group">
                    <a class="btn btn-sm btn-default btn-hover-success" href="javascript:void(0)"><i
                            class="fa fa-thumbs-up"></i></a>
                    <a class="btn btn-sm btn-default btn-hover-danger" href="javascript:void(0)"><i
                            class="fa fa-thumbs-down"></i></a>
                </div>
                <a class="btn btn-sm btn-default btn-hover-primary triggerReplay" href="javascript:void(0)">Comment</a>
                <div class="panel sectionReply d-none">
                    <div class="panel-body">
                        <textarea class="form-control" rows="2" placeholder="What are you thinking?"></textarea>
                        <div class="mar-top clearfix">
                            <a href="javascript:void(0)" data-id="{{ $row->id }}"
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
                        <a class="media-left" href="#"><img class="img-circle img-sm mr-3" alt="Profile Picture"
                                src="https://bootdey.com/img/Content/avatar/avatar{{ mt_rand(1, 8) }}.png"></a>
                        <div class="media-body">
                            <div class="mar-btm">
                                <a href="javascript:void(0)"
                                    class="btn-link text-semibold media-heading box-inline">Anonimous</a>
                                <p class="text-muted text-sm">
                                    {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                </p>
                            </div>
                            <p>{{ $item->isi }}</p>
                            <div class="pad-ver">
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-default btn-hover-success active"
                                        href="javascript:void(0)"><i class="fa fa-thumbs-up"></i></a>
                                    <a class="btn btn-sm btn-default btn-hover-danger" href="javascript:void(0)"><i
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
<script type="text/javascript">
    $(document).ready(function() {

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
                    url: "{{ route('web.blog.slug.comment.reply', $data->slug) }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": "POST",
                        "comment": textarea.val(),
                        komentar_id: comment_id
                    },
                    success: function() {
                        $.ajax({
                            url: "{{ route('web.blog.fetchData.comment') }}",
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
