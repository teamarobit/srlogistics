<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState03CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 579,
'name' => 'Aksakovo'
],[
'state_id' => 579,
'name' => 'Asparuhovo'
],[
'state_id' => 579,
'name' => 'Balgarevo'
],[
'state_id' => 579,
'name' => 'Beloslav'
],[
'state_id' => 579,
'name' => 'Byala'
],[
'state_id' => 579,
'name' => 'Dalgopol'
],[
'state_id' => 579,
'name' => 'Devnya'
],[
'state_id' => 579,
'name' => 'Dolni Chiflik'
],[
'state_id' => 579,
'name' => 'Kiten'
],[
'state_id' => 579,
'name' => 'Obshtina Aksakovo'
],[
'state_id' => 579,
'name' => 'Obshtina Avren'
],[
'state_id' => 579,
'name' => 'Obshtina Beloslav'
],[
'state_id' => 579,
'name' => 'Obshtina Byala'
],[
'state_id' => 579,
'name' => 'Obshtina Dalgopol'
],[
'state_id' => 579,
'name' => 'Obshtina Devnya'
],[
'state_id' => 579,
'name' => 'Obshtina Dolni Chiflik'
],[
'state_id' => 579,
'name' => 'Obshtina Provadia'
],[
'state_id' => 579,
'name' => 'Obshtina Suvorovo'
],[
'state_id' => 579,
'name' => 'Obshtina Valchidol'
],[
'state_id' => 579,
'name' => 'Obshtina Varna'
],[
'state_id' => 579,
'name' => 'Obshtina Vetrino'
],[
'state_id' => 579,
'name' => 'Provadia'
],[
'state_id' => 579,
'name' => 'Suvorovo'
],[
'state_id' => 579,
'name' => 'Valchidol'
],[
'state_id' => 579,
'name' => 'Varna'
],[
'state_id' => 579,
'name' => 'Vetrino'
],[
'state_id' => 579,
'name' => 'Zlatni Pyasatsi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
