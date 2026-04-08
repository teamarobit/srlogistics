<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TDStateLOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 760,
'name' => 'Benoy'
],[
'state_id' => 760,
'name' => 'Beïnamar'
],[
'state_id' => 760,
'name' => 'Lac Wey'
],[
'state_id' => 760,
'name' => 'Moundou'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
