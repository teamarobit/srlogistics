<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateDKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1175,
'name' => 'Ajā'
],[
'state_id' => 1175,
'name' => 'Al Jammālīyah'
],[
'state_id' => 1175,
'name' => 'Al Manzalah'
],[
'state_id' => 1175,
'name' => 'Al Manşūrah'
],[
'state_id' => 1175,
'name' => 'Al Maţarīyah'
],[
'state_id' => 1175,
'name' => 'Bilqās'
],[
'state_id' => 1175,
'name' => 'Dikirnis'
],[
'state_id' => 1175,
'name' => 'Minyat an Naşr'
],[
'state_id' => 1175,
'name' => 'Shirbīn'
],[
'state_id' => 1175,
'name' => 'Ţalkhā'
],[
'state_id' => 1175,
'name' => '‘Izbat al Burj'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
