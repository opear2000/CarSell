<div class="row">
    @foreach ($types as $type )
        <div class="col">
                    <label class="inline-radio">
                      <input type="radio" name="car_type_id" value="{{ $type->id }}" {{ $attributes->get('value') == $type->id ? 'checked' : '' }} />
                      {{ $type->name }}
                    </label>
        </div>
        @if ($loop->iteration % 3 == 0 && !$loop->last)
        </div>
        <div class="row">
        @endif
    @endforeach
</div>