<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DJStateTACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1072,
'name' => 'Dorra'
],[
'state_id' => 1072,
'name' => 'Tadjourah'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
