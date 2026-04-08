<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1146,
'name' => 'Cantón San Fernando'
],[
'state_id' => 1146,
'name' => 'Cuenca'
],[
'state_id' => 1146,
'name' => 'Gualaceo'
],[
'state_id' => 1146,
'name' => 'La Unión'
],[
'state_id' => 1146,
'name' => 'Llacao'
],[
'state_id' => 1146,
'name' => 'Nulti'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
