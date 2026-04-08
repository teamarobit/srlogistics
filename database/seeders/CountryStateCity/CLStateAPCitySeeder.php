<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateAPCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 775,
'name' => 'Arica'
],[
'state_id' => 775,
'name' => 'Camarones'
],[
'state_id' => 775,
'name' => 'Putre'
],[
'state_id' => 775,
'name' => 'General Lagos'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
