<?php

namespace App\Http\Requests;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'maker_id' => 'required|exists:makers,id',
            'model_id' => 'required|exists:models,id',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'vin' => [
                'required',
                'size:17',
                Rule::unique('cars', 'vin')->ignore($this->route('car')),
            ],
            'mileage' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000',
            'car_type_id' => 'required|exists:car_types,id',
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:20', new Phone()],
            'published_at' => 'required|date|after_or_equal:today',
            // Car features
            'air_conditioning' => 'boolean',
            'power_windows' => 'boolean',
            'power_door_locks' => 'boolean',
            'abs' => 'boolean',
            'cruise_control' => 'boolean',
            'bluetooth_connectivity' => 'boolean',
            'remote_start' => 'boolean',
            'gps_navigation' => 'boolean',
            'heated_seats' => 'boolean',
            'climate_control' => 'boolean',
            'rear_parking_sensors' => 'boolean',
            'leather_seats' => 'boolean',
            // Images
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:webp,jpeg,png,jpg,gif|max:200',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'maker_id.required' => 'Por favor, selecciona un fabricante.',
            'maker_id.exists' => 'El fabricante seleccionado no existe.',
            'model_id.required' => 'Por favor, selecciona un modelo.',
            'model_id.exists' => 'El modelo seleccionado no existe.',
            'year.required' => 'Por favor, ingresa el año de fabricación.',
            'year.integer' => 'El año debe ser un número entero válido.',
            'year.min' => 'El año debe ser al menos 1900.',
            'year.max' => 'El año no puede estar en el futuro.',
            'vin.required' => 'Por favor, ingresa el código VIN.',
            'vin.unique' => 'Este código VIN ya está en uso para otro automóvil.',
            'vin.size' => 'El código VIN debe tener exactamente 17 caracteres.',
            'mileage.required' => 'Por favor, ingresa el kilometraje.',
            'mileage.numeric' => 'El kilometraje debe ser un número válido.',
            'mileage.min' => 'El kilometraje no puede ser negativo.',
            'price.required' => 'Por favor, ingresa el precio.',
            'price.numeric' => 'El precio debe ser un número válido.',
            'price.min' => 'El precio no puede ser negativo.',
            'description.required' => 'Por favor, ingresa una descripción.',
            'description.max' => 'La descripción no puede exceder los 1000 caracteres.',
            'car_type_id.required' => 'Por favor, selecciona un tipo de automóvil.',
            'car_type_id.exists' => 'El tipo de automóvil seleccionado no existe.',
            'fuel_type_id.required' => 'Por favor, selecciona un tipo de combustible.',
            'fuel_type_id.exists' => 'El tipo de combustible seleccionado no existe.',
            'state_id.required' => 'Por favor, selecciona un estado.',
            'state_id.exists' => 'El estado seleccionado no existe.',
            'city_id.required' => 'Por favor, selecciona una ciudad.',
            'city_id.exists' => 'La ciudad seleccionada no existe.',
            'address.required' => 'Por favor, ingresa una dirección.',
            'address.max' => 'La dirección no puede exceder los 255 caracteres.',
            'phone.required' => 'Por favor, ingresa un número de teléfono.',
            'phone.max' => 'El número de teléfono no puede exceder los 20 caracteres.',
            'published_at.required' => 'Por favor, selecciona una fecha de publicación.',
            'published_at.date' => 'La fecha de publicación debe ser una fecha válida.',
            'published_at.after_or_equal' => 'La fecha de publicación no puede estar en el pasado.',
            'images.array' => 'Las imágenes deben ser un arreglo de archivos.',
            'images.max' => 'Puedes subir un máximo de 10 imágenes.',
            'images.*.image' => 'Cada archivo debe ser una imagen.',
            'images.*.mimes' => 'Las imágenes deben estar en formato WEBP, JPEG, PNG, JPG o GIF.',
            'images.*.max' => 'Cada imagen no debe exceder los 200KB.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'maker_id' => 'Fabricante',
            'model_id' => 'Modelo',
            'year' => 'Año',
            'vin' => 'Código VIN',
            'mileage' => 'Kilometraje',
            'price' => 'Precio',
            'description' => 'Descripción',
            'car_type_id' => 'Tipo de automóvil',
            'fuel_type_id' => 'Tipo de combustible',
            'state_id' => 'Estado',
            'city_id' => 'Ciudad',
            'address' => 'Dirección',
            'phone' => 'Teléfono',
            'published_at' => 'Fecha de publicación',
            'images' => 'Imágenes',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('vin')) {
            $this->merge([
                'vin' => strtoupper($this->input('vin')),
            ]);
        }
    }
}
