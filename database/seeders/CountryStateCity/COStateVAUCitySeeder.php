<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateVAUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 830,
'name' => 'Caruru'
],[
'state_id' => 830,
'name' => 'Mitú'
],[
'state_id' => 830,
'name' => 'Pacoa'
],[
'state_id' => 830,
'name' => 'Papunaua'
],[
'state_id' => 830,
'name' => 'Taraira'
],[
'state_id' => 830,
'name' => 'Yavaraté'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
