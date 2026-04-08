<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BJStateALCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 459,
'name' => 'Banikoara'
],[
'state_id' => 459,
'name' => 'Kandi'
],[
'state_id' => 459,
'name' => 'Malanville'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
