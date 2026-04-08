<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState2CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 662,
'name' => 'Battambang'
],[
'state_id' => 662,
'name' => 'Srŏk Banăn'
],[
'state_id' => 662,
'name' => 'Srŏk Bâvĭl'
],[
'state_id' => 662,
'name' => 'Srŏk Rotanak Mondol'
],[
'state_id' => 662,
'name' => 'Srŏk Âk Phnŭm'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
