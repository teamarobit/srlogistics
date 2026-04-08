<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TDStateWFCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 756,
'name' => 'Biltine'
],[
'state_id' => 756,
'name' => 'Iriba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
