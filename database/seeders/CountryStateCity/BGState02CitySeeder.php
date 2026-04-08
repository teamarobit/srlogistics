<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState02CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 577,
'name' => 'Aheloy'
],[
'state_id' => 577,
'name' => 'Ahtopol'
],[
'state_id' => 577,
'name' => 'Aytos'
],[
'state_id' => 577,
'name' => 'Bata'
],[
'state_id' => 577,
'name' => 'Burgas'
],[
'state_id' => 577,
'name' => 'Chernomorets'
],[
'state_id' => 577,
'name' => 'Kameno'
],[
'state_id' => 577,
'name' => 'Karnobat'
],[
'state_id' => 577,
'name' => 'Kiten'
],[
'state_id' => 577,
'name' => 'Malko Tarnovo'
],[
'state_id' => 577,
'name' => 'Nesebar'
],[
'state_id' => 577,
'name' => 'Obshtina Aytos'
],[
'state_id' => 577,
'name' => 'Obshtina Burgas'
],[
'state_id' => 577,
'name' => 'Obshtina Kameno'
],[
'state_id' => 577,
'name' => 'Obshtina Karnobat'
],[
'state_id' => 577,
'name' => 'Obshtina Malko Tarnovo'
],[
'state_id' => 577,
'name' => 'Obshtina Nesebar'
],[
'state_id' => 577,
'name' => 'Obshtina Pomorie'
],[
'state_id' => 577,
'name' => 'Obshtina Primorsko'
],[
'state_id' => 577,
'name' => 'Obshtina Sozopol'
],[
'state_id' => 577,
'name' => 'Obshtina Sungurlare'
],[
'state_id' => 577,
'name' => 'Obzor'
],[
'state_id' => 577,
'name' => 'Pomorie'
],[
'state_id' => 577,
'name' => 'Primorsko'
],[
'state_id' => 577,
'name' => 'Ravda'
],[
'state_id' => 577,
'name' => 'Ruen'
],[
'state_id' => 577,
'name' => 'Sarafovo'
],[
'state_id' => 577,
'name' => 'Sozopol'
],[
'state_id' => 577,
'name' => 'Sredets'
],[
'state_id' => 577,
'name' => 'Sungurlare'
],[
'state_id' => 577,
'name' => 'Sveti Vlas'
],[
'state_id' => 577,
'name' => 'Tsarevo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
