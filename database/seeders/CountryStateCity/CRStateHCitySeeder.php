<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CRStateHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 896,
'name' => 'Barva'
],[
'state_id' => 896,
'name' => 'Belén'
],[
'state_id' => 896,
'name' => 'Flores'
],[
'state_id' => 896,
'name' => 'Heredia'
],[
'state_id' => 896,
'name' => 'La Asunción'
],[
'state_id' => 896,
'name' => 'Llorente'
],[
'state_id' => 896,
'name' => 'Mercedes'
],[
'state_id' => 896,
'name' => 'San Antonio'
],[
'state_id' => 896,
'name' => 'San Francisco'
],[
'state_id' => 896,
'name' => 'San Isidro'
],[
'state_id' => 896,
'name' => 'San Josecito'
],[
'state_id' => 896,
'name' => 'San Pablo'
],[
'state_id' => 896,
'name' => 'San Rafael'
],[
'state_id' => 896,
'name' => 'Santa Bárbara'
],[
'state_id' => 896,
'name' => 'Santo Domingo'
],[
'state_id' => 896,
'name' => 'Sarapiquí'
],[
'state_id' => 896,
'name' => 'Ángeles'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
