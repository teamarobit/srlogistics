<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GWStateBACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1570,
'name' => 'Bafatá'
],[
'state_id' => 1570,
'name' => 'Contuboel Sector'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
