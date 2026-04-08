<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AMStateTVCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 204,
'name' => 'Archis'
],[
'state_id' => 204,
'name' => 'Artsvaberd'
],[
'state_id' => 204,
'name' => 'Aygehovit'
],[
'state_id' => 204,
'name' => 'Azatamut'
],[
'state_id' => 204,
'name' => 'Bagratashen'
],[
'state_id' => 204,
'name' => 'Berd'
],[
'state_id' => 204,
'name' => 'Berdavan'
],[
'state_id' => 204,
'name' => 'Dilijan'
],[
'state_id' => 204,
'name' => 'Haghartsin'
],[
'state_id' => 204,
'name' => 'Ijevan'
],[
'state_id' => 204,
'name' => 'Khasht’arrak'
],[
'state_id' => 204,
'name' => 'Mosesgegh'
],[
'state_id' => 204,
'name' => 'Navur'
],[
'state_id' => 204,
'name' => 'Noyemberyan'
],[
'state_id' => 204,
'name' => 'Parravak’ar'
],[
'state_id' => 204,
'name' => 'Sarigyugh'
],[
'state_id' => 204,
'name' => 'Voskevan'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
