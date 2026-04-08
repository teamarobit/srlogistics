<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState15CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 114,
'name' => 'Arhribs'
],[
'state_id' => 114,
'name' => 'Azazga'
],[
'state_id' => 114,
'name' => 'Beni Douala'
],[
'state_id' => 114,
'name' => 'Boghni'
],[
'state_id' => 114,
'name' => 'Boudjima'
],[
'state_id' => 114,
'name' => 'Chemini'
],[
'state_id' => 114,
'name' => 'Draa Ben Khedda'
],[
'state_id' => 114,
'name' => 'Freha'
],[
'state_id' => 114,
'name' => 'Ighram'
],[
'state_id' => 114,
'name' => 'L’Arbaa Naït Irathen'
],[
'state_id' => 114,
'name' => 'Mekla'
],[
'state_id' => 114,
'name' => 'Timizart'
],[
'state_id' => 114,
'name' => 'Tirmitine'
],[
'state_id' => 114,
'name' => 'Tizi Ouzou'
],[
'state_id' => 114,
'name' => 'Tizi Rached'
],[
'state_id' => 114,
'name' => 'Tizi-n-Tleta'
],[
'state_id' => 114,
'name' => '’Aïn el Hammam'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
