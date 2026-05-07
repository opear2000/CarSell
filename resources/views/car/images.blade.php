<x-app-layout bodyClass="page-my-cars">
  
       <main>
      <div>
        <div class="container">
          <h1 class="car-details-page-title">Administrar Imágenes para {{ $car->getTitle() }}</h1>
          <div class="card p-medium">
            <form action="{{ route('car.updateImages', $car) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="new_images">Agregar imágenes. Cada imagen debe tener el formato webp, jpeg, png, jpg, gif y no debe ser mayor de 200KB</label>
                <div class="flex items-center gap-medium">
                  <input type="file" name="new_images[]" id="new_images" multiple style="display:none;" />
                  <button type="button" class="btn btn-primary mb-medium" onclick="document.getElementById('new_images').click(); return false;">Agregar Imágenes</button>
                  <span id="selected-files" class="text-muted"></span>
                </div>
                @if ($errors->has('new_images') || $errors->has('new_images.*'))
                  <p class="error-message">
                    {{ $errors->first('new_images') ?: $errors->first('new_images.*') }}
                  </p>
                @endif
              </div>
              <script>
                const fileInput = document.getElementById('new_images');
                const selectedFiles = document.getElementById('selected-files');
                if (fileInput && selectedFiles) {
                  fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                      selectedFiles.textContent = Array.from(this.files).map(f => f.name).join(', ');
                    } else {
                      selectedFiles.textContent = '';
                    }
                  });
                }
              </script>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Delete</th>
                    <th>Image</th>
                    <th>Position</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($car->images as $image)
                  <tr>
                    <td>
                      <input type="checkbox" name="delete_images[]" id="delete_image_{{ $image->id }}" value="{{ $image->id }}" />
                    </td>
                    <td>
                      <img
                        src="{{ $image->getUrl() }}"
                        alt=""
                        class="my-cars-img-thumbnail"
                      />
                    </td>
                    <td>
                      <input type="number" name="positions[{{ $image->id }}]" value="{{ old('positions.' . $image->id, $image->position) }}" />
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="3" class="text-center p-large">
                      Aún no tienes imágenes del automóvil.
                    </td>
                  </tr>
                  @endforelse                
                </tbody>
              </table>
            </div>
            <div class="p-large">
              <div class="flex items-center gap-large">
                <button type="submit" class="btn btn-primary mb-large">Actualizar Imágenes</button>&nbsp;&nbsp;&nbsp;
              <a href="{{ route('car.index') }}" class="btn btn-primary mb-large">Volver a Mis Autos</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
</x-app-layout>
