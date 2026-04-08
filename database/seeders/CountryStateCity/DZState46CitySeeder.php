<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState46CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 105,
'name' => 'Aïn Temouchent'
],[
'state_id' => 105,
'name' => 'Beni Saf'
],[
'state_id' => 105,
'name' => 'El Amria'
],[
'state_id' => 105,
'name' => 'El Malah'
],[
'state_id' => 105,
'name' => 'Hammam Bou Hadjar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
