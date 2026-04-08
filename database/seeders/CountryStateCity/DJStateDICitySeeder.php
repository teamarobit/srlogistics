<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DJStateDICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1071,
'name' => 'Dikhil'
],[
'state_id' => 1071,
'name' => 'Gâlâfi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
