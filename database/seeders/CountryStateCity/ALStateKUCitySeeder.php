<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ALStateKUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 64,
'name' => 'Bajram Curri'
],[
'state_id' => 64,
'name' => 'Krumë'
],[
'state_id' => 64,
'name' => 'Kukës'
],[
'state_id' => 64,
'name' => 'Rrethi i Hasit'
],[
'state_id' => 64,
'name' => 'Rrethi i Kukësit'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
