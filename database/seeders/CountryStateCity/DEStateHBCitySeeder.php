<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DEStateHBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1432,
'name' => 'Bremen'
],[
'state_id' => 1432,
'name' => 'Bremerhaven'
],[
'state_id' => 1432,
'name' => 'Burglesum'
],[
'state_id' => 1432,
'name' => 'Vegesack'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
