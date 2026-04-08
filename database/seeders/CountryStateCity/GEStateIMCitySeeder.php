<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GEStateIMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1418,
'name' => 'Baghdatis Munitsip’alit’et’i'
],[
'state_id' => 1418,
'name' => 'Chiat’ura'
],[
'state_id' => 1418,
'name' => 'Kharagauli'
],[
'state_id' => 1418,
'name' => 'Khoni'
],[
'state_id' => 1418,
'name' => 'Kutaisi'
],[
'state_id' => 1418,
'name' => 'K’alak’i Chiat’ura'
],[
'state_id' => 1418,
'name' => 'K’ulashi'
],[
'state_id' => 1418,
'name' => 'Sach’khere'
],[
'state_id' => 1418,
'name' => 'Samtredia'
],[
'state_id' => 1418,
'name' => 'Shorapani'
],[
'state_id' => 1418,
'name' => 'Tqibuli'
],[
'state_id' => 1418,
'name' => 'Tsqaltubo'
],[
'state_id' => 1418,
'name' => 'Vani'
],[
'state_id' => 1418,
'name' => 'Zestap’oni'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
