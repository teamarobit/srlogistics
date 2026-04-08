<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState10CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 87,
'name' => 'Aïn Bessem'
],[
'state_id' => 87,
'name' => 'Bouïra'
],[
'state_id' => 87,
'name' => 'Chorfa'
],[
'state_id' => 87,
'name' => 'Draa el Mizan'
],[
'state_id' => 87,
'name' => 'Lakhdaria'
],[
'state_id' => 87,
'name' => 'Sour el Ghozlane'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
