<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState10CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 565,
'name' => 'Boboshevo'
],[
'state_id' => 565,
'name' => 'Bobov Dol'
],[
'state_id' => 565,
'name' => 'Dupnitsa'
],[
'state_id' => 565,
'name' => 'Kocherinovo'
],[
'state_id' => 565,
'name' => 'Kyustendil'
],[
'state_id' => 565,
'name' => 'Nevestino'
],[
'state_id' => 565,
'name' => 'Obshtina Boboshevo'
],[
'state_id' => 565,
'name' => 'Obshtina Bobov Dol'
],[
'state_id' => 565,
'name' => 'Obshtina Dupnitsa'
],[
'state_id' => 565,
'name' => 'Obshtina Kocherinovo'
],[
'state_id' => 565,
'name' => 'Obshtina Kyustendil'
],[
'state_id' => 565,
'name' => 'Obshtina Nevestino'
],[
'state_id' => 565,
'name' => 'Obshtina Rila'
],[
'state_id' => 565,
'name' => 'Obshtina Sapareva Banya'
],[
'state_id' => 565,
'name' => 'Obshtina Treklyano'
],[
'state_id' => 565,
'name' => 'Rila'
],[
'state_id' => 565,
'name' => 'Sapareva Banya'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
