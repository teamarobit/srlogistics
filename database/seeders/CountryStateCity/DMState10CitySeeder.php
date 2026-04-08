<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DMState10CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1083,
'name' => 'Mahaut'
],[
'state_id' => 1083,
'name' => 'Pont Cassé'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
