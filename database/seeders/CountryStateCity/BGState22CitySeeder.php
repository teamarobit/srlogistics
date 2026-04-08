<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState22CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 567,
'name' => 'Buhovo'
],[
'state_id' => 567,
'name' => 'Sofia'
],[
'state_id' => 567,
'name' => 'Stolichna Obshtina'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
