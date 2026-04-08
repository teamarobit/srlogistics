<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateLOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 880,
'name' => 'Lubao'
],[
'state_id' => 880,
'name' => 'Mwene-Ditu'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
