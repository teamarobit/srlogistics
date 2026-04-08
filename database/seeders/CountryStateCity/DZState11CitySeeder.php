<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState11CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 118,
'name' => 'I-n-Salah'
],[
'state_id' => 118,
'name' => 'Tamanrasset'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
