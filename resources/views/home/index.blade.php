<x-app-layout title="Home Page">
  <main>  
  <x-search-form />

      <!-- New Cars -->
      <section>
        <div class="container">
          <h2>Últimos carros añadidos</h2>
          <div class="car-items-listing">
            @if ($cars->isEmpty())
              <div class="no-cars-message" style="text-align:center;padding:2rem 0;color:#888;font-size:1.25rem;">
                No hay carros publicados.
              </div>
            @else
              @foreach ($cars as $car)
                <x-car-item :$car :isInWatchlist="in_array($car->id, $watchlistCarIds, true)" />
              @endforeach
            @endif
          </div>
        </div>
      </section>
      <!--/ New Cars -->
  </main>
</x-app-layout>
