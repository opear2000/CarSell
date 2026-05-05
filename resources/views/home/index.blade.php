<x-app-layout title="Home Page">

  <main>
    <div style="text-align:center; margin:2.5rem 0 1.5rem 0;">
      <span style="font-size:2.2rem; font-style:italic; font-weight:900; color:#D97706; letter-spacing:1px; text-shadow:0 2px 12px #fff7e6, 0 1px 0 #fbbf24;">
        Carros en venta en El Salvador
      </span>
    </div>

  <x-search-form />

      <!-- New Cars -->
      @php
        $hasFilters = request()->filled('maker_id') || request()->filled('model_id') || request()->filled('car_type_id') || request()->filled('fuel_type_id') || request()->filled('state_id') || request()->filled('city_id') || request()->filled('year_from') || request()->filled('year_to') || request()->filled('price_from') || request()->filled('price_to') || request()->filled('mileage');
      @endphp
      @if (! $hasFilters || ($hasFilters && !$cars->isEmpty()))
      <section>
        <div class="container">
          <h2>
            @if ($hasFilters)
              Resultados de búsqueda
            @else
              Últimos carros añadidos
            @endif
          </h2>
          <div class="car-items-listing">
            @if ($cars->isEmpty())
              <div class="no-cars-message" style="text-align:center;padding:2rem 0;color:#888;font-size:1.25rem;">
                @if ($hasFilters)
                  No hay carros que coincidan con tu búsqueda.
                @else
                  No hay carros publicados.
                @endif
              </div>
            @else
              @foreach ($cars as $car)
                <x-car-item :$car :isInWatchlist="in_array($car->id, $watchlistCarIds, true)" />
              @endforeach
            @endif
          </div>
        </div>
      </section>
      @endif
      <!--/ New Cars -->
  </main>
</x-app-layout>
