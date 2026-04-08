<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateHKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 883,
'name' => 'Haut Katanga'
],[
'state_id' => 883,
'name' => 'Kambove'
],[
'state_id' => 883,
'name' => 'Kipushi'
],[
'state_id' => 883,
'name' => 'Likasi'
],[
'state_id' => 883,
'name' => 'Lubumbashi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
