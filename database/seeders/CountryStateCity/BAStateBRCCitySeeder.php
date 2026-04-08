<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BAStateBRCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 501,
'name' => 'Brka'
],[
'state_id' => 501,
'name' => 'Brčko'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
