<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CIStateGDCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 926,
'name' => 'Divo'
],[
'state_id' => 926,
'name' => 'Gagnoa'
],[
'state_id' => 926,
'name' => 'Guibéroua'
],[
'state_id' => 926,
'name' => 'Gôh'
],[
'state_id' => 926,
'name' => 'Lakota'
],[
'state_id' => 926,
'name' => 'Lôh-Djiboua'
],[
'state_id' => 926,
'name' => 'Oumé'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
