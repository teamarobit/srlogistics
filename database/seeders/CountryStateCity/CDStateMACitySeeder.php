<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateMACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 878,
'name' => 'Kampene'
],[
'state_id' => 878,
'name' => 'Kasongo'
],[
'state_id' => 878,
'name' => 'Kindu'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
