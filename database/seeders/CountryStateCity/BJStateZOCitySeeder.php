<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BJStateZOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 455,
'name' => 'Abomey'
],[
'state_id' => 455,
'name' => 'Bohicon'
],[
'state_id' => 455,
'name' => 'Commune of Agbangnizoun'
],[
'state_id' => 455,
'name' => 'Cové'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
