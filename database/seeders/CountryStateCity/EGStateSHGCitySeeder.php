<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateSHGCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1156,
'name' => 'Akhmīm'
],[
'state_id' => 1156,
'name' => 'Al Balyanā'
],[
'state_id' => 1156,
'name' => 'Al Manshāh'
],[
'state_id' => 1156,
'name' => 'Jirjā'
],[
'state_id' => 1156,
'name' => 'Juhaynah'
],[
'state_id' => 1156,
'name' => 'Markaz Jirjā'
],[
'state_id' => 1156,
'name' => 'Markaz Sūhāj'
],[
'state_id' => 1156,
'name' => 'Sohag'
],[
'state_id' => 1156,
'name' => 'Ţahţā'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
