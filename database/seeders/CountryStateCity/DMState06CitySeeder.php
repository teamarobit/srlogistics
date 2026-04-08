<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DMState06CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1084,
'name' => 'Saint Joseph'
],[
'state_id' => 1084,
'name' => 'Salisbury'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
