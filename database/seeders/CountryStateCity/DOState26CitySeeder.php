<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState26CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1099,
'name' => 'Monción'
],[
'state_id' => 1099,
'name' => 'Sabaneta'
],[
'state_id' => 1099,
'name' => 'San Ignacio de Sabaneta'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
