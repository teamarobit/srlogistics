<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState19CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1088,
'name' => 'Salcedo'
],[
'state_id' => 1088,
'name' => 'Salsipuedes'
],[
'state_id' => 1088,
'name' => 'Tenares'
],[
'state_id' => 1088,
'name' => 'Villa Tapia'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
