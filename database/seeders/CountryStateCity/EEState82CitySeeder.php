<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EEState82CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1211,
'name' => 'Otepää vald'
],[
'state_id' => 1211,
'name' => 'Tõrva'
],[
'state_id' => 1211,
'name' => 'Valga'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
