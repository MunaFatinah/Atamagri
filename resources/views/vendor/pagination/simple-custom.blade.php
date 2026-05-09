@if ($paginator->hasPages())
    @if ($paginator->onFirstPage())
        <span class="page-btn" style="opacity:.4;cursor:default;">‹</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="page-btn">‹</a>
    @endif

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="page-btn">›</a>
    @else
        <span class="page-btn" style="opacity:.4;cursor:default;">›</span>
    @endif
@endif
