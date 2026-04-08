<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1147,
'name' => 'Huaquillas'
],[
'state_id' => 1147,
'name' => 'Machala'
],[
'state_id' => 1147,
'name' => 'Pasaje'
],[
'state_id' => 1147,
'name' => 'Piñas'
],[
'state_id' => 1147,
'name' => 'Portovelo'
],[
'state_id' => 1147,
'name' => 'Puerto Bolívar'
],[
'state_id' => 1147,
'name' => 'Santa Rosa'
],[
'state_id' => 1147,
'name' => 'Zaruma'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
