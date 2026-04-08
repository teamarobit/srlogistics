<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateQAXCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 231,
'name' => 'Qax'
],[
'state_id' => 231,
'name' => 'Qax İngiloy'
],[
'state_id' => 231,
'name' => 'Qaxbaş'
],[
'state_id' => 231,
'name' => 'Çinarlı'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
