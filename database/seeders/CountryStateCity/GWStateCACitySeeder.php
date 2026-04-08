<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GWStateCACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1563,
'name' => 'Cacheu'
],[
'state_id' => 1563,
'name' => 'Canchungo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
