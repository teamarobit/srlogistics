<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TLStateERCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1118,
'name' => 'Ermera Villa'
],[
'state_id' => 1118,
'name' => 'Gleno'
],[
'state_id' => 1118,
'name' => 'Hatulia'
],[
'state_id' => 1118,
'name' => 'Letefoho'
],[
'state_id' => 1118,
'name' => 'Railaco'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
