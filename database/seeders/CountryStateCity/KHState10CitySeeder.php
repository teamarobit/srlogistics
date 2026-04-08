<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState10CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 672,
'name' => 'Kracheh'
],[
'state_id' => 672,
'name' => 'Kratié'
],[
'state_id' => 672,
'name' => 'Snuol'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
