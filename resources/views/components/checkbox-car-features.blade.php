@props(['car' => null])

@php
    $features = [
        'air_conditioning' => 'Aire Acondicionado',
        'power_windows' => 'Ventanas Eléctricas',
        'power_door_locks' => 'Cerraduras Eléctricas',
        'abs' => 'ABS',
        'cruise_control' => 'Control de Crucero',
        'bluetooth_connectivity' => 'Conectividad Bluetooth',
        'remote_start' => 'Arranque Remoto',
        'gps_navigation' => 'Navegación GPS',
        'heated_seats' => 'Asientos Calefaccionados',
        'climate_control' => 'Control de Clima',
        'rear_parking_sensors' => 'Sensores de Estacionamiento',
        'leather_seats' => 'Asientos de Cuero', 
    ];
@endphp
              <div class="form-group">
                <div class="row">
                  <div class="col">
                    @foreach ($features as $key => $feature)
                      <label class="checkbox">
                        <input
                          type="checkbox"
                          name="{{ $key }}"
                          value="1"
                          {{ old($key) ? 'checked' : '' }}
                          @if ($car && $car->features)
                            {{ $car->features->$key ? 'checked' : '' }}
                          @endif
                        />
                        {{ $feature }}
                      </label>

                      @if ($loop->iteration % 6 == 0 && !$loop->last)
                        </div>
                        <div class="col">   
                      @endif
                    @endforeach
                  </div>
                </div>
              </div>