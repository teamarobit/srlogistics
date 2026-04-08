<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GAState6CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1396,
'name' => 'Booué'
],[
'state_id' => 1396,
'name' => 'Makokou'
],[
'state_id' => 1396,
'name' => 'Zadie'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
