<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState43CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 115,
'name' => 'Chelghoum el Aïd'
],[
'state_id' => 115,
'name' => 'Mila'
],[
'state_id' => 115,
'name' => 'Rouached'
],[
'state_id' => 115,
'name' => 'Sidi Mérouane'
],[
'state_id' => 115,
'name' => 'Telerghma'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
