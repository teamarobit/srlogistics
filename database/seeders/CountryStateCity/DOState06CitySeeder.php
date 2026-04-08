<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState06CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1112,
'name' => 'Agua Santa del Yuna'
],[
'state_id' => 1112,
'name' => 'Arenoso'
],[
'state_id' => 1112,
'name' => 'Castillo'
],[
'state_id' => 1112,
'name' => 'Hostos'
],[
'state_id' => 1112,
'name' => 'Las Guáranas'
],[
'state_id' => 1112,
'name' => 'Pimentel'
],[
'state_id' => 1112,
'name' => 'San Francisco de Macorís'
],[
'state_id' => 1112,
'name' => 'Villa Riva'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
