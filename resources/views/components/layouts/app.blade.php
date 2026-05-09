@props(['title' => '', 'bodyClass' => null])

<x-layouts.base :title="$title" :bodyClass="$bodyClass">
    @includeIf('components.layouts.header')
    @if(session('success'))
        <div class="container my-large">
            <div class="success-message">   
                {{ session('success') }}
            </div>
        </div>
    @endif
    {{ $slot }}
</x-layouts.base>
