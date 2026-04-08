<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateSATCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 262,
'name' => 'Saatlı'
],[
'state_id' => 262,
'name' => 'Əhmədbəyli'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
