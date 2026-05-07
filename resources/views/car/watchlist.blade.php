<x-app-layout>
<main>
      @php
        $carsCount = method_exists($cars, 'total') ? $cars->total() : $cars->count();
      @endphp
      <!-- New Cars -->
      <section>
        <div class="container">
          <div class="flex justify-between items-center">
            <h2> Mis Autos Favoritos</h2>
            @if ($carsCount > 0)
              <div class="pagination-summary">
                <p>
                  Mostrando {{ $cars->firstItem() }} a {{ $cars->lastItem() }} de {{ $carsCount }} autos favoritos
                </p>
              </div>
            @endif

          </div>
          <div class="car-items-listing">
            @foreach($cars as $car)
              <x-car-item :$car :isInWatchlist="true" />
            @endforeach
            </div>

            @if ($carsCount === 0)
             <div class="text-center p-large">
              No tiene autos favoritos todavia. Busque su auto favorito y agréguelo a su lista de favoritos para verlo aquí.
            </div>
            @endif  
        </div>   
        @if (method_exists($cars, 'links') && $carsCount > 0)
          {{ $cars->links() }}
        @endif
        </div>
      </section>
      <!--/ New Cars -->
    </main>
</x-app-layout>
