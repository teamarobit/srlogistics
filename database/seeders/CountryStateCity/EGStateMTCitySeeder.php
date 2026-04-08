<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateMTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1161,
'name' => 'Al ‘Alamayn'
],[
'state_id' => 1161,
'name' => 'Mersa Matruh'
],[
'state_id' => 1161,
'name' => 'Siwa Oasis'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
