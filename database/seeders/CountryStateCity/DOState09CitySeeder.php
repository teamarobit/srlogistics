<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState09CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1101,
'name' => 'Cayetano Germosén'
],[
'state_id' => 1101,
'name' => 'Gaspar Hernández'
],[
'state_id' => 1101,
'name' => 'Jamao al Norte'
],[
'state_id' => 1101,
'name' => 'Joba Arriba'
],[
'state_id' => 1101,
'name' => 'Juan López Abajo'
],[
'state_id' => 1101,
'name' => 'Moca'
],[
'state_id' => 1101,
'name' => 'San Víctor Arriba'
],[
'state_id' => 1101,
'name' => 'Veragua Arriba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
