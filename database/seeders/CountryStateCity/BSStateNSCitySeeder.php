<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BSStateNSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 322,
'name' => 'Andros Town'
],[
'state_id' => 322,
'name' => 'San Andros'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
