<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BWStateNWCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 519,
'name' => 'Maun'
],[
'state_id' => 519,
'name' => 'Nokaneng'
],[
'state_id' => 519,
'name' => 'Pandamatenga'
],[
'state_id' => 519,
'name' => 'Sehithwa'
],[
'state_id' => 519,
'name' => 'Shakawe'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
