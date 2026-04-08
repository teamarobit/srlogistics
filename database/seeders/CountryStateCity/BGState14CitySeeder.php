<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState14CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 557,
'name' => 'Batanovtsi'
],[
'state_id' => 557,
'name' => 'Breznik'
],[
'state_id' => 557,
'name' => 'Obshtina Kovachevtsi'
],[
'state_id' => 557,
'name' => 'Obshtina Pernik'
],[
'state_id' => 557,
'name' => 'Obshtina Radomir'
],[
'state_id' => 557,
'name' => 'Obshtina Zemen'
],[
'state_id' => 557,
'name' => 'Pernik'
],[
'state_id' => 557,
'name' => 'Radomir'
],[
'state_id' => 557,
'name' => 'Tran'
],[
'state_id' => 557,
'name' => 'Zemen'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
