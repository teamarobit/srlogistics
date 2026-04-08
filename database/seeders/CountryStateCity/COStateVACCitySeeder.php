<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateVACCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 849,
'name' => 'Alcalá'
],[
'state_id' => 849,
'name' => 'Andalucía'
],[
'state_id' => 849,
'name' => 'Ansermanuevo'
],[
'state_id' => 849,
'name' => 'Argelia'
],[
'state_id' => 849,
'name' => 'Bolívar'
],[
'state_id' => 849,
'name' => 'Buenaventura'
],[
'state_id' => 849,
'name' => 'Bugalagrande'
],[
'state_id' => 849,
'name' => 'Caicedonia'
],[
'state_id' => 849,
'name' => 'Cali'
],[
'state_id' => 849,
'name' => 'Calima'
],[
'state_id' => 849,
'name' => 'Candelaria'
],[
'state_id' => 849,
'name' => 'Cartago'
],[
'state_id' => 849,
'name' => 'Dagua'
],[
'state_id' => 849,
'name' => 'El Cairo'
],[
'state_id' => 849,
'name' => 'El Cerrito'
],[
'state_id' => 849,
'name' => 'El Dovio'
],[
'state_id' => 849,
'name' => 'El Águila'
],[
'state_id' => 849,
'name' => 'Florida'
],[
'state_id' => 849,
'name' => 'Ginebra'
],[
'state_id' => 849,
'name' => 'Guacarí'
],[
'state_id' => 849,
'name' => 'Guadalajara de Buga'
],[
'state_id' => 849,
'name' => 'Jamundí'
],[
'state_id' => 849,
'name' => 'La Cumbre'
],[
'state_id' => 849,
'name' => 'La Unión'
],[
'state_id' => 849,
'name' => 'La Victoria'
],[
'state_id' => 849,
'name' => 'Obando'
],[
'state_id' => 849,
'name' => 'Palmira'
],[
'state_id' => 849,
'name' => 'Pradera'
],[
'state_id' => 849,
'name' => 'Restrepo'
],[
'state_id' => 849,
'name' => 'Riofrío'
],[
'state_id' => 849,
'name' => 'Roldanillo'
],[
'state_id' => 849,
'name' => 'San Pedro'
],[
'state_id' => 849,
'name' => 'Sevilla'
],[
'state_id' => 849,
'name' => 'Toro'
],[
'state_id' => 849,
'name' => 'Trujillo'
],[
'state_id' => 849,
'name' => 'Tuluá'
],[
'state_id' => 849,
'name' => 'Ulloa'
],[
'state_id' => 849,
'name' => 'Versalles'
],[
'state_id' => 849,
'name' => 'Vijes'
],[
'state_id' => 849,
'name' => 'Yotoco'
],[
'state_id' => 849,
'name' => 'Yumbo'
],[
'state_id' => 849,
'name' => 'Zarzal'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
