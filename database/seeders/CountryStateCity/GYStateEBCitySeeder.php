<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GYStateEBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1579,
'name' => 'New Amsterdam'
],[
'state_id' => 1579,
'name' => 'Skeldon'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
