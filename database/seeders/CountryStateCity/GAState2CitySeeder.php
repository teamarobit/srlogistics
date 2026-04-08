<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GAState2CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1398,
'name' => 'Franceville'
],[
'state_id' => 1398,
'name' => 'Lékoni'
],[
'state_id' => 1398,
'name' => 'Moanda'
],[
'state_id' => 1398,
'name' => 'Mounana'
],[
'state_id' => 1398,
'name' => 'Okondja'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
