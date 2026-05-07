  <x-app-layout title="Edit Car">
    <main>
      <div class="container-small">
        <h1 class="car-details-page-title">Editar Auto: {{ $car->getTitle() }}</h1>
        <form
          action="{{ route('car.update', $car) }}"
          method="POST"
          enctype="multipart/form-data"
          class="card add-new-car-form"
        >
        @csrf
        @method('PUT')
          <div class="form-content">
           <div class="form-details">
              <div class="row">
                <div class="col">
                  <div class="form-group @error('maker_id') has-error @enderror">
                    <label>Fabricante</label>
                    <x-select-maker :value="old('maker_id', $car->maker_id)" />
                    <p class="error-message"> 
                      {{ $errors->first('maker_id') }}
                    </p>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group @error('model_id') has-error @enderror">
                    <label>Modelo</label>
                    <x-select-model :value="old('model_id', $car->model_id)" />
                    <p class="error-message"> 
                      {{ $errors->first('model_id') }}
                    </p>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group @error('year') has-error @enderror">
                    <label>Año</label>
                    <x-select-year :value="old('year', $car->year)" />
                    <p class="error-message"> 
                      {{ $errors->first('year') }}
                    </p>
                  </div>
                </div>
              </div>
              <div class="form-group @error('car_type_id') has-error @enderror">
                <label>Tipo de Auto</label>
                <x-radio-list-car-type :value="old('car_type_id', $car->car_type_id)" />
                <p class="error-message"> 
                  {{ $errors->first('car_type_id') }}
                </p>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group @error('price') has-error @enderror">
                    <label>Precio</label>
                    <input type="number" value="{{ old('price', $car->price) }}" name="price" />
                    <p class="error-message"> 
                      {{ $errors->first('price') }}
                    </p>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group @error('vin') has-error @enderror">
                    <label>Código VIN</label>
                    <input type="text" placeholder="Código VIN" name="vin" value="{{ old('vin', $car->vin) }}" />
                    <p class="error-message"> 
                      {{ $errors->first('vin') }}
                    </p>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group @error('mileage') has-error @enderror">
                    <label>Kilometraje (ml)</label>
                    <input type="number" value="{{ old('mileage', $car->mileage) }}" name="mileage" />
                    <p class="error-message"> 
                      {{ $errors->first('mileage') }}
                    </p>          
                  </div>
                </div>
              </div>
              <div class="form-group @error('fuel_type_id') has-error @enderror">
                <label>Tipo de Combustible</label>
                <x-radio-list-fuel-type :value="old('fuel_type_id', $car->fuel_type_id)" />
                <p class="error-message"> 
                  {{ $errors->first('fuel_type_id') }}
                </p>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group @error('state_id') has-error @enderror">
                    <label>Estado/Región</label>
                    <x-select-state :value="old('state_id', $car->state_id)" />
                    <p class="error-message"> 
                      {{ $errors->first('state_id') }}
                    </p>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group @error('city_id') has-error @enderror">
                    <label>Ciudad</label>
                    <x-select-city :value="old('city_id', $car->city_id)" />
                    <p class="error-message"> 
                      {{ $errors->first('city_id') }}
                    </p>  
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group @error('address') has-error @enderror">
                    <label>Dirección</label>
                    <input placeholder="Dirección" name="address" value="{{ old('address', $car->address) }}" />
                    <p class="error-message"> 
                      {{ $errors->first('address') }}
                    </p>          
                  </div>
                </div>
                <div class="col">
                  <div class="form-group @error('phone') has-error @enderror">
                    <label>Teléfono</label>
                    <input placeholder="Teléfono" name="phone" value="{{ old('phone', $car->phone) }}" />
                    <p class="error-message"> 
                      {{ $errors  ->first('phone') }}
                    </p>            
                  </div>
                </div>
              </div>
           <x-checkbox-car-features :car="$car" />
              <div class="form-group @error('description') has-error @enderror">
                <label>Descripción Detallada</label>
                <textarea rows="10" name="description">{{ old('description', $car->description) }}</textarea>
                <p class="error-message"> 
                  {{ $errors->first('description') }}
                </p>  
              </div>
              <div class="form-group @error('published_at') has-error @enderror">
                <label>Fecha de Publicación</label>
                  <input type="date" name="published_at" value="{{ old('published_at', optional($car->published_at)->format('Y-m-d')) }}">
                    <p class="error-message"> 
                      {{ $errors  ->first('published_at') }}
                    </p>    
              </div>
            </div>
            <div class="form-images">
             <p>
               <strong>Nota:</strong> Haga clic <a href="{{ route('car.images', $car) }}"> aquí </a> para gestionar las imágenes del automóvil individualmente, donde puede agregar nuevas imágenes o eliminar las existentes. Sin embargo, si desea subir un lote de imágenes juntas, puede usar la sección a continuación para cargar varias imágenes a la vez. Las imágenes cargadas a través de esta sección se agregarán a las imágenes existentes del automóvil sin eliminar ninguna imagen actual.
             </p>
             <div class="car-form-images"> 
              @foreach ($car->images as $image)
              <a href="#" class="car-form-image-preview">
                <img src="{{ $image->getUrl() }}" alt="Imagen del automóvil">  
              </a>
              @endforeach

            </div>
          </div>
          <div class="p-medium" style="width: 100%">
            <div class="flex justify-end gap-1">
              <button type="button" class="btn btn-default">Resetear</button>
              <button class="btn btn-primary">Enviar</button>
            </div>
          </div>
        </form>
      </div>
    </main>
</x-app-layout>
