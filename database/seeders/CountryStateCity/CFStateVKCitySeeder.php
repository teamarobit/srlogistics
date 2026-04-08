<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CFStateVKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 738,
'name' => 'Birao'
],[
'state_id' => 738,
'name' => 'Ouanda-Djallé'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
