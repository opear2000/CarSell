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
            'maker_id.required' => 'Please select a maker.',
            'maker_id.exists' => 'Selected maker does not exist.',
            'model_id.required' => 'Please select a model.',
            'model_id.exists' => 'Selected model does not exist.',
            'year.required' => 'Please enter the manufacturing year.',
            'year.integer' => 'Year must be a valid integer.',
            'year.min' => 'Year must be at least 1900.',
            'year.max' => 'Year cannot be in the future.',
            'vin.required' => 'Please enter the VIN code.',
            'vin.unique' => 'This VIN code is already used for another car.',
            'vin.size' => 'VIN code must be exactly 17 characters.',
            'mileage.required' => 'Please enter the mileage.',
            'mileage.numeric' => 'Mileage must be a valid number.',
            'mileage.min' => 'Mileage cannot be negative.',
            'price.required' => 'Please enter the price.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price cannot be negative.',
            'description.required' => 'Please enter a description.',
            'description.max' => 'Description cannot exceed 1000 characters.',
            'car_type_id.required' => 'Please select a car type.',
            'car_type_id.exists' => 'Selected car type does not exist.',
            'fuel_type_id.required' => 'Please select a fuel type.',
            'fuel_type_id.exists' => 'Selected fuel type does not exist.',
            'state_id.required' => 'Please select a state.',
            'state_id.exists' => 'Selected state does not exist.',
            'city_id.required' => 'Please select a city.',
            'city_id.exists' => 'Selected city does not exist.',
            'address.required' => 'Please enter an address.',
            'address.max' => 'Address cannot exceed 255 characters.',
            'phone.required' => 'Please enter a phone number.',
            'phone.max' => 'Phone number cannot exceed 20 characters.',
            'published_at.required' => 'Please select a publication date.',
            'published_at.date' => 'Publication date must be a valid date.',
            'published_at.after_or_equal' => 'Publication date cannot be in the past.',
            'images.array' => 'Images must be an array of files.',
            'images.max' => 'You can upload a maximum of 10 images.',
            'images.*.image' => 'Each file must be an image.',
            'images.*.mimes' => 'Images must be in WEBP, JPEG, PNG, JPG, or GIF format.',
            'images.*.max' => 'Each image must not exceed 200KB.',
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
            'maker_id' => 'Maker',
            'model_id' => 'Model',
            'year' => 'Year',
            'vin' => 'VIN Code',
            'mileage' => 'Mileage',
            'price' => 'Price',
            'description' => 'Description',
            'car_type_id' => 'Car Type',
            'fuel_type_id' => 'Fuel Type',
            'state_id' => 'State',
            'city_id' => 'City',
            'address' => 'Address',
            'phone' => 'Phone',
            'published_at' => 'Publication Date',
            'images' => 'Images',
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
