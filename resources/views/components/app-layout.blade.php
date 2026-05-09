@props(['title' => '', 'bodyClass' => null])

<x-layouts.app :title="$title" :bodyClass="$bodyClass">
    {{ $slot }}
</x-layouts.app>
