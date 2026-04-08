<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateHELCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 4,
'name' => 'Gereshk'
],[
'state_id' => 4,
'name' => 'Lashkar Gāh'
],[
'state_id' => 4,
'name' => 'Markaz-e Ḩukūmat-e Darwēshān'
],[
'state_id' => 4,
'name' => 'Sangīn'
],[
'state_id' => 4,
'name' => '‘Alāqahdārī Dīshū'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
