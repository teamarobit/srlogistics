<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ADState02CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 141,
'name' => 'Canillo'
],[
'state_id' => 141,
'name' => 'El Tarter'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
