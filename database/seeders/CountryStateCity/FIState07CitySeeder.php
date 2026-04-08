<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState07CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1254,
'name' => 'Halsua'
],[
'state_id' => 1254,
'name' => 'Kannus'
],[
'state_id' => 1254,
'name' => 'Kaustinen'
],[
'state_id' => 1254,
'name' => 'Kokkola'
],[
'state_id' => 1254,
'name' => 'Kälviä'
],[
'state_id' => 1254,
'name' => 'Lestijärvi'
],[
'state_id' => 1254,
'name' => 'Lohtaja'
],[
'state_id' => 1254,
'name' => 'Perho'
],[
'state_id' => 1254,
'name' => 'Toholampi'
],[
'state_id' => 1254,
'name' => 'Ullava'
],[
'state_id' => 1254,
'name' => 'Veteli'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
