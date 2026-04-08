<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BSStateCICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 316,
'name' => 'Arthur’s Town'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
