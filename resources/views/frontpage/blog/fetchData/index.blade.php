<div class="row">
    @foreach ($data as $key => $row)
        <div class="col-lg-4 col-md-6 col-sm-6">
            @php
                $jsonParse = json_decode($row->img_url);
            @endphp
            <div class="blog__item set-bg-blog" data-setbg="{{ img_src($jsonParse[0], 'blog') }}">
                <h4>{{ $row->title }}</h4>
                <ul>
                    <li>{{ date('F d, Y', strtotime($row->posting_date)) }}</li>
                    <li>{{$row->blog_comments->count() + $row->blog_comments_reply->count()}} Comment</li>
                </ul>
                <p>{{ Str::limit(strip_tags($row->contents), 100) }}</p>
                <a href="{{ route('web.blog.slug', $row->slug) }}">Read more <span
                        class="arrow_right"></span></a>
            </div>
        </div>
    @endforeach

</div>
{{ $data->links('frontpage.layouts.pagination.index') }}