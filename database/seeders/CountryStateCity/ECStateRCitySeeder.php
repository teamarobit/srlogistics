<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1133,
'name' => 'Babahoyo'
],[
'state_id' => 1133,
'name' => 'Catarama'
],[
'state_id' => 1133,
'name' => 'Montalvo'
],[
'state_id' => 1133,
'name' => 'Palenque'
],[
'state_id' => 1133,
'name' => 'Quevedo'
],[
'state_id' => 1133,
'name' => 'Ventanas'
],[
'state_id' => 1133,
'name' => 'Vinces'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
