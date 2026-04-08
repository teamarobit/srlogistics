<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BJStatePLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 456,
'name' => 'Kétou'
],[
'state_id' => 456,
'name' => 'Pobé'
],[
'state_id' => 456,
'name' => 'Sakété'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
