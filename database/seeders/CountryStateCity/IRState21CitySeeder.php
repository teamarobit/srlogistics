<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState21CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1769,
'name' => 'Ardakan'
],[
'state_id' => 1769,
'name' => 'Bafq'
],[
'state_id' => 1769,
'name' => 'Khavas Kuh'
],[
'state_id' => 1769,
'name' => 'Mahriz'
],[
'state_id' => 1769,
'name' => 'Meybod'
],[
'state_id' => 1769,
'name' => 'Abarkuh'
],[
'state_id' => 1769,
'name' => 'Ashkezar'
],[
'state_id' => 1769,
'name' => 'Behabad'
],[
'state_id' => 1769,
'name' => 'Khatam'
],[
'state_id' => 1769,
'name' => 'Tabas'
],[
'state_id' => 1769,
'name' => 'Taft'
],[
'state_id' => 1769,
'name' => 'Yazd'
],[
'state_id' => 1769,
'name' => 'Abarkooh'
],[
'state_id' => 1769,
'name' => 'Mehrdasht'
],[
'state_id' => 1769,
'name' => 'Ahmadabad'
],[
'state_id' => 1769,
'name' => 'Aqda'
],[
'state_id' => 1769,
'name' => 'Khezrabad'
],[
'state_id' => 1769,
'name' => 'Bafgh'
],[
'state_id' => 1769,
'name' => 'Bahabad'
],[
'state_id' => 1769,
'name' => 'Nir'
],[
'state_id' => 1769,
'name' => 'Marvast'
],[
'state_id' => 1769,
'name' => 'Harat'
],[
'state_id' => 1769,
'name' => 'Mehriz'
],[
'state_id' => 1769,
'name' => 'Bafruiyeh'
],[
'state_id' => 1769,
'name' => 'Nodoushan'
],[
'state_id' => 1769,
'name' => 'Hamidia'
],[
'state_id' => 1769,
'name' => 'Zarach'
],[
'state_id' => 1769,
'name' => 'Shahedieh'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
