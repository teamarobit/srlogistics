<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CUState10CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 961,
'name' => 'Amancio'
],[
'state_id' => 961,
'name' => 'Colombia'
],[
'state_id' => 961,
'name' => 'Jesús Menéndez'
],[
'state_id' => 961,
'name' => 'Jobabo'
],[
'state_id' => 961,
'name' => 'Las Tunas'
],[
'state_id' => 961,
'name' => 'Manatí'
],[
'state_id' => 961,
'name' => 'Puerto Padre'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
