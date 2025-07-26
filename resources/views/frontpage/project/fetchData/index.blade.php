<div class="row">
    <div class="col-lg-12">
        <ul class="portfolio__filter">
            <li class="active" data-filter="*">All</li>
            @foreach ($kategori as $col)
                <li data-filter=".{{$col->slug}}">{{$col->nama}}</li>
            @endforeach
            
        </ul>
    </div>
</div>

<div class="row portfolio__gallery">
@foreach ($project as $row)
    @php
        $img_url = json_decode($row->img_url);
    @endphp
    <div class="col-lg-4 col-md-6 col-sm-6 mix {{$row->kategori_project->slug}}">
        <div class="portfolio__item">
            <div class="portfolio__item__video set-bg" data-setbg="{{img_src($img_url[0],'project')}}">
                <a href="{{route('web.project.slug', $row->slug)}}" class="play-btn "><i class="fa fa-arrow-right"></i></a>
            </div>
            <div class="portfolio__item__text">
                <h4>{{$row->nama}}</h4>
                <ul>
                    <li>{{$row->kategori_project->nama}}</li>
                </ul>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{$project->links('frontpage.layouts.pagination.index')}}