<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateAGACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 248,
'name' => 'Aghstafa'
],[
'state_id' => 248,
'name' => 'Saloğlu'
],[
'state_id' => 248,
'name' => 'Vurğun'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
