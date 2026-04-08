<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateVCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 187,
'name' => 'Río Grande'
],[
'state_id' => 187,
'name' => 'Tolhuin'
],[
'state_id' => 187,
'name' => 'Ushuaia'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
