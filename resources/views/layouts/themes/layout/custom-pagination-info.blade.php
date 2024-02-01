@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
    <div class="pagination-info" style="color: var(--theme-default)">แสดง {{ $paginator->firstItem() }} ถึง {{ $paginator->lastItem() }} จาก {{ $paginator->total() }} รายการ </div>
    @endif
</div>
