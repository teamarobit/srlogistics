<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateBUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1665,
'name' => 'Budapest'
],[
'state_id' => 1665,
'name' => 'Budapest I. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest II. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest III. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest IV. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest VI. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest VIII. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest X. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest XI. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest XII. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest XIII. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest XV. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest XVI. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest XVII. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest XVIII. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest XX. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest XXI. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest XXII. kerület'
],[
'state_id' => 1665,
'name' => 'Budapest XXIII. kerület'
],[
'state_id' => 1665,
'name' => 'Erzsébetváros'
],[
'state_id' => 1665,
'name' => 'Józsefváros'
],[
'state_id' => 1665,
'name' => 'Kispest'
],[
'state_id' => 1665,
'name' => 'Zugló'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
