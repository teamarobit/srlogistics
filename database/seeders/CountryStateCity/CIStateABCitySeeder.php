<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CIStateABCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 909,
'name' => 'Abidjan'
],[
'state_id' => 909,
'name' => 'Abobo'
],[
'state_id' => 909,
'name' => 'Anyama'
],[
'state_id' => 909,
'name' => 'Bingerville'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
