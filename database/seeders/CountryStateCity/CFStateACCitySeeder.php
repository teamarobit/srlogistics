<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CFStateACCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 731,
'name' => 'Batangafo'
],[
'state_id' => 731,
'name' => 'Bossangoa'
],[
'state_id' => 731,
'name' => 'Bouca'
],[
'state_id' => 731,
'name' => 'Kabo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
