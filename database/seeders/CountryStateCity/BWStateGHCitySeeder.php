<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BWStateGHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 515,
'name' => 'Dekar'
],[
'state_id' => 515,
'name' => 'Ghanzi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
