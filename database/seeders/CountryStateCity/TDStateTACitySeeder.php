<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TDStateTACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 754,
'name' => 'Béré'
],[
'state_id' => 754,
'name' => 'Kelo'
],[
'state_id' => 754,
'name' => 'Laï'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
