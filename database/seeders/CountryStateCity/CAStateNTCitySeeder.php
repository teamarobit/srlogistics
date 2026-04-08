<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CAStateNTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 705,
'name' => 'Behchokǫ̀'
],[
'state_id' => 705,
'name' => 'Fort McPherson'
],[
'state_id' => 705,
'name' => 'Fort Smith'
],[
'state_id' => 705,
'name' => 'Hay River'
],[
'state_id' => 705,
'name' => 'Inuvik'
],[
'state_id' => 705,
'name' => 'Norman Wells'
],[
'state_id' => 705,
'name' => 'Yellowknife'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
