<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateNEFCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 235,
'name' => 'Neftçala'
],[
'state_id' => 235,
'name' => 'Severo-Vostotchnyi Bank'
],[
'state_id' => 235,
'name' => 'Sovetabad'
],[
'state_id' => 235,
'name' => 'Xıllı'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
