<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState12CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 100,
'name' => 'Bir el Ater'
],[
'state_id' => 100,
'name' => 'Cheria'
],[
'state_id' => 100,
'name' => 'Hammamet'
],[
'state_id' => 100,
'name' => 'Tébessa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
