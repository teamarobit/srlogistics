<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState05CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1106,
'name' => 'Dajabón'
],[
'state_id' => 1106,
'name' => 'El Pino'
],[
'state_id' => 1106,
'name' => 'Loma de Cabrera'
],[
'state_id' => 1106,
'name' => 'Partido'
],[
'state_id' => 1106,
'name' => 'Restauración'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
