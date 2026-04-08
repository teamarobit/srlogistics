<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DMState02CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1081,
'name' => 'Calibishie'
],[
'state_id' => 1081,
'name' => 'Marigot'
],[
'state_id' => 1081,
'name' => 'Wesley'
],[
'state_id' => 1081,
'name' => 'Woodford Hill'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
