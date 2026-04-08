<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState01CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 101,
'name' => 'Adrar'
],[
'state_id' => 101,
'name' => 'Aoulef'
],[
'state_id' => 101,
'name' => 'Reggane'
],[
'state_id' => 101,
'name' => 'Timimoun'
],
];
		foreach($jayParsedAry as $data){

			City::create($data);
		}
	}
}
