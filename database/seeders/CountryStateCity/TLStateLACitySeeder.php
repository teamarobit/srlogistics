<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TLStateLACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1125,
'name' => 'Iliomar'
],[
'state_id' => 1125,
'name' => 'Lautem'
],[
'state_id' => 1125,
'name' => 'Lospalos'
],[
'state_id' => 1125,
'name' => 'Luro'
],[
'state_id' => 1125,
'name' => 'Tutuala'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
