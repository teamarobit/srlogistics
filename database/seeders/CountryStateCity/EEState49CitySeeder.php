<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EEState49CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1218,
'name' => 'Jõgeva'
],[
'state_id' => 1218,
'name' => 'Jõgeva vald'
],[
'state_id' => 1218,
'name' => 'Mustvee'
],[
'state_id' => 1218,
'name' => 'Põltsamaa'
],[
'state_id' => 1218,
'name' => 'Põltsamaa vald'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
