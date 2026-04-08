<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState45CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 85,
'name' => 'Aïn Sefra'
],[
'state_id' => 85,
'name' => 'Naama'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
