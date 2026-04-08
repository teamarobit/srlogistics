<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateBHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1171,
'name' => 'Abū al Maţāmīr'
],[
'state_id' => 1171,
'name' => 'Ad Dilinjāt'
],[
'state_id' => 1171,
'name' => 'Damanhūr'
],[
'state_id' => 1171,
'name' => 'Idkū'
],[
'state_id' => 1171,
'name' => 'Kafr ad Dawwār'
],[
'state_id' => 1171,
'name' => 'Kawm Ḩamādah'
],[
'state_id' => 1171,
'name' => 'Rosetta'
],[
'state_id' => 1171,
'name' => 'Ḩawsh ‘Īsá'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
