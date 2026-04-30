<x-app-layout>
<main>
      @php
        $carsCount = method_exists($cars, 'total') ? $cars->total() : $cars->count();
      @endphp
      <!-- New Cars -->
      <section>
        <div class="container">
          <div class="flex justify-between items-center">
            <h2> My Favorite Cars</h2>
            @if ($carsCount > 0)
              <div class="pagination-summary">
                <p>
                  Showing {{ $cars->firstItem() }} to {{ $cars->lastItem() }} of {{ $carsCount }} cars
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
              You do not have any favorite cars yet. Browse cars and add them to your watchlist to see them here.
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
