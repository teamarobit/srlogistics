<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState47CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 110,
'name' => 'Berriane'
],[
'state_id' => 110,
'name' => 'Ghardaïa'
],[
'state_id' => 110,
'name' => 'Metlili Chaamba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
