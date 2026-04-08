<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState12CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1086,
'name' => 'Guaymate'
],[
'state_id' => 1086,
'name' => 'La Romana'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
