<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GQStateCSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1200,
'name' => 'Acurenam'
],[
'state_id' => 1200,
'name' => 'Bicurga'
],[
'state_id' => 1200,
'name' => 'Evinayong'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
