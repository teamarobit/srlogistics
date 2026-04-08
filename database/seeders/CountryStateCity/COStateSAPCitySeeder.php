<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateSAPCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 845,
'name' => 'Providencia'
],[
'state_id' => 845,
'name' => 'San Andrés'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
