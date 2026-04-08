<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateWCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1128,
'name' => 'Puerto Ayora'
],[
'state_id' => 1128,
'name' => 'Puerto Baquerizo Moreno'
],[
'state_id' => 1128,
'name' => 'Puerto Villamil'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
