<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateKABCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 33,
'name' => 'Kabul'
],[
'state_id' => 33,
'name' => 'Mīr Bachah Kōṯ'
],[
'state_id' => 33,
'name' => 'Paghmān'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
