<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateSMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 287,
'name' => 'Corat'
],[
'state_id' => 287,
'name' => 'Hacı Zeynalabdin'
],[
'state_id' => 287,
'name' => 'Sumqayıt'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
