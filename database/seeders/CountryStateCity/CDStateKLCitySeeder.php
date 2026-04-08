<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateKLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 891,
'name' => 'Bandundu'
],[
'state_id' => 891,
'name' => 'Bulungu'
],[
'state_id' => 891,
'name' => 'Kikwit'
],[
'state_id' => 891,
'name' => 'Mangai'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
