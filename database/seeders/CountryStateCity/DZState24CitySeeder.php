<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState24CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 120,
'name' => 'Boumahra Ahmed'
],[
'state_id' => 120,
'name' => 'Guelma'
],[
'state_id' => 120,
'name' => 'Héliopolis'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
