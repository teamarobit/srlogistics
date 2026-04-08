<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CVStateCRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 728,
'name' => 'Pedra Badejo'
],[
'state_id' => 728,
'name' => 'Santa Cruz'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
