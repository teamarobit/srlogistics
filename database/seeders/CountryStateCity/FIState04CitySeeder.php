<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState04CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1255,
'name' => 'Enonkoski'
],[
'state_id' => 1255,
'name' => 'Haukivuori'
],[
'state_id' => 1255,
'name' => 'Heinävesi'
],[
'state_id' => 1255,
'name' => 'Hirvensalmi'
],[
'state_id' => 1255,
'name' => 'Joroinen'
],[
'state_id' => 1255,
'name' => 'Juva'
],[
'state_id' => 1255,
'name' => 'Jäppilä'
],[
'state_id' => 1255,
'name' => 'Kangasniemi'
],[
'state_id' => 1255,
'name' => 'Kerimäki'
],[
'state_id' => 1255,
'name' => 'Mikkeli'
],[
'state_id' => 1255,
'name' => 'Mäntyharju'
],[
'state_id' => 1255,
'name' => 'Pertunmaa'
],[
'state_id' => 1255,
'name' => 'Pieksämäki'
],[
'state_id' => 1255,
'name' => 'Punkaharju'
],[
'state_id' => 1255,
'name' => 'Puumala'
],[
'state_id' => 1255,
'name' => 'Rantasalmi'
],[
'state_id' => 1255,
'name' => 'Ristiina'
],[
'state_id' => 1255,
'name' => 'Savonlinna'
],[
'state_id' => 1255,
'name' => 'Savonranta'
],[
'state_id' => 1255,
'name' => 'Sulkava'
],[
'state_id' => 1255,
'name' => 'Virtasalmi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
