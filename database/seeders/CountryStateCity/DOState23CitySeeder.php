<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState23CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1109,
'name' => 'El Puerto'
],[
'state_id' => 1109,
'name' => 'Los Llanos'
],[
'state_id' => 1109,
'name' => 'Quisqueya'
],[
'state_id' => 1109,
'name' => 'Ramón Santana'
],[
'state_id' => 1109,
'name' => 'San Pedro de Macorís'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
