<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CIStateZZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 916,
'name' => 'Bondoukou'
],[
'state_id' => 916,
'name' => 'Bouna'
],[
'state_id' => 916,
'name' => 'Bounkani'
],[
'state_id' => 916,
'name' => 'Gontougo'
],[
'state_id' => 916,
'name' => 'Sinfra'
],[
'state_id' => 916,
'name' => 'Tanda'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
