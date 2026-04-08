<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateHACCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 276,
'name' => 'Hacıqabul'
],[
'state_id' => 276,
'name' => 'Mughan'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
