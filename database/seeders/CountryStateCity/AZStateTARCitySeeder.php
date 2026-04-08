<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateTARCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 224,
'name' => 'Martakert'
],[
'state_id' => 224,
'name' => 'Terter'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
