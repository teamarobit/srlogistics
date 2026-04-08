<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DMState09CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1079,
'name' => 'Berekua'
],[
'state_id' => 1079,
'name' => 'La Plaine'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
