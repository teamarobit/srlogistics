<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ETStateGACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1232,
'name' => 'Administrative Zone 1'
],[
'state_id' => 1232,
'name' => 'Gambēla'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
