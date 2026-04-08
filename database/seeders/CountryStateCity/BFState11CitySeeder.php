<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BFState11CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 596,
'name' => 'Boussé'
],[
'state_id' => 596,
'name' => 'Oubritenga'
],[
'state_id' => 596,
'name' => 'Province du Ganzourgou'
],[
'state_id' => 596,
'name' => 'Province du Kourwéogo'
],[
'state_id' => 596,
'name' => 'Ziniaré'
],[
'state_id' => 596,
'name' => 'Zorgo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
