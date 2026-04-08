<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateKDZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 31,
'name' => 'Dasht-e Archī'
],[
'state_id' => 31,
'name' => 'Imām Şāḩib'
],[
'state_id' => 31,
'name' => 'Khanabad'
],[
'state_id' => 31,
'name' => 'Kunduz'
],[
'state_id' => 31,
'name' => 'Qarāwul'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
