<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KMStateMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 852,
'name' => 'Djoyézi'
],[
'state_id' => 852,
'name' => 'Fomboni'
],[
'state_id' => 852,
'name' => 'Hoani'
],[
'state_id' => 852,
'name' => 'Mtakoudja'
],[
'state_id' => 852,
'name' => 'Nioumachoua'
],[
'state_id' => 852,
'name' => 'Ouanani'
],[
'state_id' => 852,
'name' => 'Ziroudani'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
