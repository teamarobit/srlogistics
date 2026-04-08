<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CMStateNOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 692,
'name' => 'Faro Department'
],[
'state_id' => 692,
'name' => 'Garoua'
],[
'state_id' => 692,
'name' => 'Guider'
],[
'state_id' => 692,
'name' => 'Lagdo'
],[
'state_id' => 692,
'name' => 'Mayo-Louti'
],[
'state_id' => 692,
'name' => 'Mayo-Rey'
],[
'state_id' => 692,
'name' => 'Pitoa'
],[
'state_id' => 692,
'name' => 'Poli'
],[
'state_id' => 692,
'name' => 'Rey Bouba'
],[
'state_id' => 692,
'name' => 'Tcholliré'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
