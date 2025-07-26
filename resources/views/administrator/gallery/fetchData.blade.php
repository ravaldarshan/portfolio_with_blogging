<div class="gallery">
    @foreach ($data as $key => $row)
        @php
            $jsonImg = json_decode($row->img_url);
        @endphp

        @if (count($jsonImg) > 1)
            <div class="gallery-item gallery-more"
                style="width: 100px !important; height: 100px !important;"
                data-image="{{ img_src($jsonImg[0], 'gallery') }}" data-title="{{ $jsonImg[0] }}"
                data-id="{{ $row->id }}">
                <div
                    style="
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 100%;">
                    <div style="margin: auto;">+{{ count($jsonImg) }}</div>
                </div>
            </div>


            @foreach (array_slice($jsonImg, 1) as $col)
                <div class="gallery-item gallery-hide" data-image="{{ img_src($col, 'gallery') }}"
                    data-title="{{ $col }}" data-id="{{ $row->id }}"></div>
            @endforeach
        @else
            <div class="gallery-item" style="width: 100px !important; height: 100px !important;"
                data-image="{{ img_src($jsonImg[0], 'gallery') }}" data-title="{{ $jsonImg[0] }}"
                data-id="{{ $row->id }}">
            </div>
        @endif
    @endforeach
</div>
<script src="{{ template_stisla('modules/chocolat/dist/js/jquery.chocolat.js') }}"></script>
