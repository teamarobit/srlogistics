<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateTAKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 24,
'name' => 'Taloqan'
],[
'state_id' => 24,
'name' => 'Ārt Khwājah'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
