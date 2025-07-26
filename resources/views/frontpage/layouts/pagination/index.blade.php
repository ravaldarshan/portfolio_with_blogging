<style>
    .disabled {
        pointer-events: none;
        color: #777;
    }
</style>

@if ($paginator->haspages())
    <div class="row">
        <div class="col-lg-12">
            <div class="pagination__option">
                @if ($paginator->onFirstPage())
                    <a class="arrow__pagination left__arrow disabled">
                        <span class="arrow_left"></span> Prev
                    </a>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="arrow__pagination left__arrow">
                        <span class="arrow_left"></span> Prev
                    </a>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span>{{ $element }}</span>
                    @endif
                    @if (is_array($element))
                        @php
                            $currentPage = $paginator->currentPage();
                            $lastPage = $paginator->lastPage();
                        @endphp
                        @foreach ($element as $page => $url)
                            @if ($page === 1)
                                <a href="{{ $url }}" class="number__pagination">{{ $page }}</a>
                            @elseif ($page === $currentPage - 1)
                                <a href="{{ $url }}" class="number__pagination">{{ $page }}</a>
                            @elseif ($page === $currentPage)
                                <a class="number__pagination active text-dark">{{ $page }}</a>
                            @elseif ($page === $currentPage + 1)
                                <a href="{{ $url }}" class="number__pagination">{{ $page }}</a>
                            @elseif ($page === $lastPage)
                                <a href="{{ $url }}" class="number__pagination">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->onLastPage())
                    <a class="arrow__pagination right__arrow disabled">
                        Next <span class="arrow_right"></span>
                    </a>
                @else
                    <a href="{{ $paginator->nextPageUrl() }}" class="arrow__pagination right__arrow">
                        Next <span class="arrow_right"></span>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
