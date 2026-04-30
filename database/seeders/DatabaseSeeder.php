<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarFeatures;
use App\Models\CarImage;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Model;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      CarType::factory()
        ->sequence(
          ['name' => 'Sedan'],
          ['name' => 'Hatchback'],
          ['name' => 'SUV'],
          ['name' => 'Pickup Truck'],
          ['name' => 'Minivan'],
          ['name' => 'Jeep'],
          ['name' => 'Coupe'],
          ['name' => 'Crossover'],
          ['name' => 'Sports Car'],
        )
        ->count(9)
        ->create();

       FuelType::factory()
        ->sequence(
          ['name' => 'Gasoline'],
          ['name' => 'Diesel'],
          ['name' => 'Electric'],
          ['name' => 'Hybrid'],
        )
        ->count(4)
        ->create();
     
        $states = [
          'Ahuachapán' => ['Ahuachapán', 'Atiquizaya', 'Concepción de Ataco', 'Apaneca', 'Tacuba', 'Jujutla', 'TBD'],
          'Cabañas' => ['Cabañas', 'Sensuntepeque', 'Ilobasco', 'Jutiapa', 'Tejutepeque', 'TBD'],
          'Chalatenango' => ['Chalatenango', 'La Palma', 'Nueva Concepción', 'San Fernando', 'San Francisco Morazán', 'TBD'],
          'Cuscatlán' => ['Cuscatlán', 'Cojutepeque', 'El Carmen', 'San Ramón', 'Suchitoto', 'TBD'],
          'La Libertad' => ['La Libertad', 'Santa Tecla', 'Antiguo Cuscatlán', 'Colón', 'Jayaque', 'TBD'],
          'La Paz' => ['La Paz', 'Zacatecoluca', 'San Luis Talpa', 'Olocuilta', 'San Pedro Masahuat', 'TBD'],
          'La Unión' => ['La Unión', 'Concepción de Oriente', 'Intipucá', 'Lislique', 'Santa Rosa de Lima', 'TBD'],
          'Morazán' => ['Morazán', 'Arambala', 'Cacaopera', 'Corinto', 'El Divisadero', 'TBD'],
          'San Miguel' => ['San Miguel', 'Chinameca', 'Ciudad Barrios', 'Comacarán', 'El Tránsito', 'TBD'],
          'San Salvador' => ['San Salvador', 'Aguilares', 'Apopa', 'Ayutuxtepeque', 'Cuscatancingo', 'TBD'],
          'San Vicente' => ['San Vicente', 'Apastepeque', 'Guadalupe', 'San Cayetano Istepeque', 'Tecoluca', 'TBD'],
          'Santa Ana' => ['Santa Ana', 'Chalchuapa', 'Coatepeque', 'El Congo', 'Metapán', 'TBD'],
          'Sonsonate' => ['Sonsonate', 'Acajutla', 'Armenia', 'Caluco', 'Cuisnahuat', 'TBD'],
          'Usulután' => ['Usulután', 'Alegría', 'Berlín', 'California', 'Concepción Batres', 'TBD'],
        ];


        foreach ($states as $state => $cities) {
        State::factory()
          ->state(['name' => $state])
          ->has(
            City::factory()
            ->count(count($cities))
            ->sequence(...array_map(fn ($city) => ['name' => $city], $cities))
          )
          ->create();
        }

      $makers = [
          'Acura' => ['ILX', 'MDX', 'RDX', 'RLX', 'TLX', 'TLX Type S', 'ZDX'],
          'Alfa Romeo' => ['Giulia', 'Stelvio', '4C', 'Giulietta', 'MiTo'],
          'Audi' => ['A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'Q3', 'Q5', 'Q7', 'Q8', 'e-tron'],
          'BMW' => ['3 Series', '5 Series', '7 Series', 'X1', 'X3', 'X5', 'X7', 'i3', 'i8'],
          'Buick' => ['Enclave', 'Encore', 'Envision', 'LaCrosse', 'Regal'],
          'Cadillac' => ['CT4', 'CT5', 'CT6', 'Escalade', 'XT4', 'XT5', 'XT6'],
          'Chevrolet' => ['Silverado', 'Equinox', 'Malibu', 'Impala', 'Cruze'],
          'Chrysler' => ['300', 'Pacifica', 'Voyager'],
          'Dodge' => ['Charger', 'Challenger', 'Durango', 'Journey', 'Grand Caravan'],
          'Fiat' => ['500', '500X', '500L', 'Panda', 'Tipo'],
          'Ford' => ['F-150', 'Escape', 'Explorer', 'Mustang', 'Fusion'],
          'Genesis' => ['G70', 'G80', 'G90', 'GV70', 'GV80'],
          'GMC' => ['Sierra', 'Terrain', 'Acadia', 'Yukon', 'Canyon'],
          'Honda' => ['Civic', 'Accord', 'CR-V', 'Pilot', 'Odyssey'],
          'Hyundai' => ['Elantra', 'Sonata', 'Santa Fe', 'Tucson', 'Palisade'],
          'Infiniti' => ['Q50', 'Q60', 'Q70', 'QX50', 'QX60', 'QX80'],
          'Jaguar' => ['XE', 'XF', 'XJ', 'F-PACE', 'E-PACE', 'I-PACE'],
          'Jeep' => ['Wrangler', 'Grand Cherokee', 'Cherokee', 'Renegade', 'Compass'],
          'Kia' => ['Soul', 'Seltos', 'Sportage', 'Sorento', 'Telluride'],
          'Land Rover' => ['Range Rover', 'Range Rover Sport', 'Range Rover Velar', 'Discovery', 'Discovery Sport', 'Defender'],
          'Lexus' => ['RX400', 'RX450', 'RX350', 'ES350', 'LS400'],
          'Lincoln' => ['Navigator', 'Aviator', 'Corsair', 'Nautilus'],
          'Mazda' => ['Mazda3', 'Mazda6', 'CX-3', 'CX-30', 'CX-5', 'CX-50', 'CX-70', 'CX-9', 'CX-90', 'MX-5 Miata'],
          'Mercedes-Benz' => ['C-Class', 'E-Class', 'S-Class', 'GLA', 'GLC', 'GLE', 'GLS', 'G-Class', 'EQC'],
          'Mini Cooper' => ['Cooper', 'Cooper S', 'Cooper SE', 'Countryman', 'Clubman'],
          'Mitsubishi' => ['Outlander', 'Eclipse Cross', 'ASX', 'Lancer', 'Mirage'],
          'Nissan' => ['Altima', 'Sentra', 'Maxima', 'Rogue', 'Murano', 'Pathfinder', 'Frontier', 'Titan'],
          'Porsche' => ['911', 'Cayenne', 'Macan', 'Panamera', 'Taycan'],
          'Ram' => ['1500', '2500', '3500', 'ProMaster', 'ProMaster City'],
          'Subaru' => ['Impreza', 'Legacy', 'Outback', 'Forester', 'Crosstrek', 'Ascent'],
          'Maserati' => ['Ghibli', 'Levante', 'Quattroporte', 'GranTurismo', 'GranCabrio'],
          'Tesla' => ['Model S', 'Model 3', 'Model X', 'Model Y', 'Cybertruck', 'Roadster'],
          'Toyota' => ['Avalon', 'Camry', 'Corolla', 'Corolla Cross', 'Fortuner', 'GR Corolla', 'GR Supra', 'GR86',
          'Grand Highlander','Highlander', 'Hilux', 'Land Cruiser', 'Prius', 'RAV4', 'Sequoia', 'Sienna', 'Tacoma', 'Tundra', 'Venza', 'Yaris', 'bz4x', '4Runner'],
          'Volkswagen' => ['Golf', 'Passat', 'Jetta', 'Tiguan', 'Atlas', 'Arteon', 'ID.4'],
          'Volvo' => ['S60', 'S90', 'V60', 'V90', 'XC40', 'XC60', 'XC90'],
          'TBD' => ['TBD'],
        ];

        foreach ($makers as $maker => $models) {
          Maker::factory()
          ->state(['name'=> $maker])
          ->has(Model::factory()->count(count($models))->sequence(...array_map(fn ($model) => ['name'=> $model], $models)))
          ->create();
          }

          // create 2 users and assign cars with images/feature data plus favorites
          $users = User::factory()->count(2)->create();

          foreach ($users as $user) {
              $cars = Car::factory()->count(20)->create(['user_id' => $user->id]);

              foreach ($cars as $car) {
                  // Always create 5 images with sequential positions
                  foreach (range(1, 5) as $pos) {
                      CarImage::factory()->create([
                          'car_id' => $car->id,
                          'position' => $pos
                      ]);
                  }
                  CarFeatures::factory()->create(['car_id' => $car->id]);
              }

              $user->favoriteCars()->sync($cars->pluck('id')->toArray());
          }


        

    

   }
}