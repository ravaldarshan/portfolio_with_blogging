<div class="row">
    @foreach ($data as $key => $row)
        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
            <a href="{{ route('web.blog.slug', $row->slug) }}" class="text-decoration-none text-dark"
                title="{{ $row->title }}">
                <div class="blog__item position-relative" style="aspect-ratio: 382 / 271; overflow: hidden;">
                    @php
                        $jsonParse = json_decode($row->img_url);
                    @endphp
                    <img src="{{ img_src($jsonParse[0], 'blog') }}" alt="{{ $row->title }}"
                        class="w-100 h-100 object-fit-cover" style="border-radius: 5px;">
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
