<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TDStateLRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 766,
'name' => 'Béboto'
],[
'state_id' => 766,
'name' => 'Bébédja'
],[
'state_id' => 766,
'name' => 'Doba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
