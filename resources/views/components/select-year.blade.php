@php
    $year = date('Y');
@endphp

<select name="year">
    <option value="" {{ !$value ? 'selected' : '' }}>Year</option>
    @for ($i = $year; $i >= 1960; $i--)
        <option value="{{ $i }}" {{ $value == $i ? 'selected' : '' }}>{{ $i }}</option>
    @endfor
</select>