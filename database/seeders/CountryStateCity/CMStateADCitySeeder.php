<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CMStateADCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 690,
'name' => 'Bankim'
],[
'state_id' => 690,
'name' => 'Banyo'
],[
'state_id' => 690,
'name' => 'Bélel'
],[
'state_id' => 690,
'name' => 'Djohong'
],[
'state_id' => 690,
'name' => 'Kontcha'
],[
'state_id' => 690,
'name' => 'Mayo-Banyo'
],[
'state_id' => 690,
'name' => 'Meïganga'
],[
'state_id' => 690,
'name' => 'Ngaoundéré'
],[
'state_id' => 690,
'name' => 'Somié'
],[
'state_id' => 690,
'name' => 'Tibati'
],[
'state_id' => 690,
'name' => 'Tignère'
],[
'state_id' => 690,
'name' => 'Vina'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
