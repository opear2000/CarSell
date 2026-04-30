<select name="car_type_id">
        <option value="">Type</option>
        @foreach ($Types as $Type )
        <option value="{{ $Type->id }}"
                @selected($attributes->get('value') == $Type->id)>{{ $Type->name }}</option>
        @endforeach
</select>