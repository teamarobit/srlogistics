<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CVStateSLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 722,
'name' => 'Espargos'
],[
'state_id' => 722,
'name' => 'Santa Maria'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
