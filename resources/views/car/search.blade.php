<x-app-layout title="Search Cars">
     <main>
    <!-- Found Cars -->
    <section>
      <div class="container">
        <div class="sm:flex items-center justify-between mb-medium">
          <div class="flex items-center">
            <button class="show-filters-button flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" style="width: 20px">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6 13.5V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 9.75V10.5" />
              </svg>
              Filters
            </button>
            <h2>Defina su criterio de búsqueda</h2>
          </div>

          <select class="sort-dropdown">
            <option value="">Ordenar por</option>
            <option value="price">Precio Asc</option>
            <option value="-price">Precio Desc</option>
            <option value="year">Año Asc</option>
            <option value="-year">Año Desc</option>
            <option value="mileage">Kilometraje Asc</option>
            <option value="-mileage">Kilometraje Desc</option>
            <option value="published_at">Más recientes primero</option>
            <option value="-published_at">Más antiguos primero</option>
          </select>
        </div>
        <div class="search-car-results-wrapper">
          <div class="search-cars-sidebar">
            <div class="card card-found-cars">
              <p class="m-0">Se encontraron <strong>{{ $cars->total() }}</strong> carros</p>

              <button class="close-filters-button">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 24px">
                  <path fill-rule="evenodd"
                    d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                    clip-rule="evenodd" />
                </svg>
              </button>
            </div>

            <!-- Find a car form -->
            <section class="find-a-car">
              <form action="" method="GET" class="find-a-car-form card flex p-medium">
                <div class="find-a-car-inputs">
                  <div class="form-group">
                    <label class="mb-medium">Marca</label>
                    <x-select-maker :value="request()->input('maker_id')" />
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">Modelo</label>
                    <x-select-model :value="request()->input('model_id')" />
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">Tipo</label>
                    <x-select-car-type :value="request()->input('car_type_id')" />
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">Año</label>
                    <div class="flex gap-1">
                      <input type="number" placeholder="Año Desde" name="year_from" value="{{ request()->input('year_from') }}" />
                      <input type="number" placeholder="Año Hasta" name="year_to" value="{{ request()->input('year_to') }}" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">Precio</label>
                    <div class="flex gap-1">
                      <input type="number" placeholder="Precio Desde" name="price_from" value="{{ request()->input('price_from') }}" />
                      <input type="number" placeholder="Precio Hasta" name="price_to" value="{{ request()->input('price_to') }}" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">Kilometraje</label>
                    <div class="flex gap-1">
                      <x-select-mileage :value="request()->input('mileage')" name="mileage" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">Estado</label>
                    <x-select-state :value="request()->input('state_id')" />
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">Ciudad</label>
                    <x-select-city :value="request()->input('city_id')" />
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">Tipo de Combustible</label>
                    <x-select-fuel-type :value="request()->input('fuel_type_id')" />
                  </div>
                </div>
                <div class="flex">
                  <button type="button" class="btn btn-find-a-car-reset">
                    Restablecer Filtros
                  </button>
                  <button class="btn btn-primary btn-find-a-car-submit">
                    Buscar
                  </button>
                </div>
              </form>
            </section>
            <!--/ Find a car form -->
          </div>

          <div class="search-cars-results">
            @if ($cars->count() == 0)
            <div class="text-center p-large">
              No se encontraron carros que coincidan con tus criterios. Por favor, ajusta tus filtros e inténtalo de nuevo.
            </div>
            @else
              <div class="car-items-listing">
                @foreach($cars as $car)
                  <x-car-item :$car :isInWatchlist="in_array($car->id, $watchlistCarIds, true)" />
                @endforeach
              </div>
            @endif  
            </div>
            {{ $cars->onEachSide(1)->appends(request()->query())->links('pagination') }}
          </div>
        </div>
      </div>
    </section>
    <!--/ Found Cars -->
  </main>
</x-app-layout>
