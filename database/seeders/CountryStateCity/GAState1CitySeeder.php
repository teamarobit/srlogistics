<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GAState1CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1399,
'name' => 'Cocobeach'
],[
'state_id' => 1399,
'name' => 'Libreville'
],[
'state_id' => 1399,
'name' => 'Ntoum'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
