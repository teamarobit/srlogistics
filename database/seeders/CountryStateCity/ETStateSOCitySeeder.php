<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ETStateSOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1224,
'name' => 'Afder Zone'
],[
'state_id' => 1224,
'name' => 'Degehabur Zone'
],[
'state_id' => 1224,
'name' => 'Gode Zone'
],[
'state_id' => 1224,
'name' => 'Jijiga'
],[
'state_id' => 1224,
'name' => 'Liben zone'
],[
'state_id' => 1224,
'name' => 'Shinile Zone'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
