<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateXIZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 242,
'name' => 'Altıağac'
],[
'state_id' => 242,
'name' => 'Khyzy'
],[
'state_id' => 242,
'name' => 'Kilyazi'
],[
'state_id' => 242,
'name' => 'Şuraabad'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
