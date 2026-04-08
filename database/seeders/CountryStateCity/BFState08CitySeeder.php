<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BFState08CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 629,
'name' => 'Bogandé'
],[
'state_id' => 629,
'name' => 'Diapaga'
],[
'state_id' => 629,
'name' => 'Fada N\'gourma'
],[
'state_id' => 629,
'name' => 'Gayéri'
],[
'state_id' => 629,
'name' => 'Gnagna Province'
],[
'state_id' => 629,
'name' => 'Pama'
],[
'state_id' => 629,
'name' => 'Province de la Komandjoari'
],[
'state_id' => 629,
'name' => 'Province de la Kompienga'
],[
'state_id' => 629,
'name' => 'Province de la Tapoa'
],[
'state_id' => 629,
'name' => 'Province du Gourma'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
