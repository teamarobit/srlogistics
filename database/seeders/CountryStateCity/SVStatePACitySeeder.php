<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class SVStatePACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1188,
'name' => 'El Rosario'
],[
'state_id' => 1188,
'name' => 'Olocuilta'
],[
'state_id' => 1188,
'name' => 'San Pedro Masahuat'
],[
'state_id' => 1188,
'name' => 'Santiago Nonualco'
],[
'state_id' => 1188,
'name' => 'Zacatecoluca'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
