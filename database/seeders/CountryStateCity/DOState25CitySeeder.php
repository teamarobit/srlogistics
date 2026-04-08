<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState25CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1107,
'name' => 'Baitoa'
],[
'state_id' => 1107,
'name' => 'Bisonó'
],[
'state_id' => 1107,
'name' => 'Juncalito Abajo'
],[
'state_id' => 1107,
'name' => 'La Canela'
],[
'state_id' => 1107,
'name' => 'Licey al Medio'
],[
'state_id' => 1107,
'name' => 'Palmar Arriba'
],[
'state_id' => 1107,
'name' => 'Pedro García'
],[
'state_id' => 1107,
'name' => 'Sabana Iglesia'
],[
'state_id' => 1107,
'name' => 'San José de Las Matas'
],[
'state_id' => 1107,
'name' => 'Santiago de los Caballeros'
],[
'state_id' => 1107,
'name' => 'Santo Tomás de Jánico'
],[
'state_id' => 1107,
'name' => 'Tamboril'
],[
'state_id' => 1107,
'name' => 'Villa Bisonó'
],[
'state_id' => 1107,
'name' => 'Villa González'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
