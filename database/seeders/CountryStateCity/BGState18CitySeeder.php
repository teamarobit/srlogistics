<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState18CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 575,
'name' => 'Borovo'
],[
'state_id' => 575,
'name' => 'Dve Mogili'
],[
'state_id' => 575,
'name' => 'Ivanovo'
],[
'state_id' => 575,
'name' => 'Obshtina Borovo'
],[
'state_id' => 575,
'name' => 'Obshtina Byala'
],[
'state_id' => 575,
'name' => 'Obshtina Dve Mogili'
],[
'state_id' => 575,
'name' => 'Obshtina Ivanovo'
],[
'state_id' => 575,
'name' => 'Obshtina Ruse'
],[
'state_id' => 575,
'name' => 'Obshtina Slivo Pole'
],[
'state_id' => 575,
'name' => 'Obshtina Tsenovo'
],[
'state_id' => 575,
'name' => 'Obshtina Vetovo'
],[
'state_id' => 575,
'name' => 'Ruse'
],[
'state_id' => 575,
'name' => 'Senovo'
],[
'state_id' => 575,
'name' => 'Slivo Pole'
],[
'state_id' => 575,
'name' => 'Tsenovo'
],[
'state_id' => 575,
'name' => 'Vetovo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
