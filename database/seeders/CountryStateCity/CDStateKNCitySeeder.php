<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateKNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 874,
'name' => 'Kinshasa'
],[
'state_id' => 874,
'name' => 'Masina'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
