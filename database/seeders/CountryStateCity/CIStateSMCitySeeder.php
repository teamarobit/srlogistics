<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CIStateSMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 923,
'name' => 'Bouaflé'
],[
'state_id' => 923,
'name' => 'Daloa'
],[
'state_id' => 923,
'name' => 'Haut-Sassandra'
],[
'state_id' => 923,
'name' => 'Issia'
],[
'state_id' => 923,
'name' => 'Marahoué'
],[
'state_id' => 923,
'name' => 'Vavoua'
],[
'state_id' => 923,
'name' => 'Zuénoula'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
