<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateALXCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1165,
'name' => 'Alexandria'
],[
'state_id' => 1165,
'name' => 'Abu Qir'
],[
'state_id' => 1165,
'name' => 'Agami'
],[
'state_id' => 1165,
'name' => 'Ar-Raml'
],[
'state_id' => 1165,
'name' => 'Borg El Arab'
],[
'state_id' => 1165,
'name' => 'Montaza'
],[
'state_id' => 1165,
'name' => 'New Borg El Arab'
],[
'state_id' => 1165,
'name' => 'Sidi Bishr'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
