<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStatePRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1506,
'name' => 'El Jícaro'
],[
'state_id' => 1506,
'name' => 'Guastatoya'
],[
'state_id' => 1506,
'name' => 'Morazán'
],[
'state_id' => 1506,
'name' => 'San Agustín Acasaguastlán'
],[
'state_id' => 1506,
'name' => 'San Antonio La Paz'
],[
'state_id' => 1506,
'name' => 'San Cristóbal Acasaguastlán'
],[
'state_id' => 1506,
'name' => 'Sanarate'
],[
'state_id' => 1506,
'name' => 'Sansare'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
