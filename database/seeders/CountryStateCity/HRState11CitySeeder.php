<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState11CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 931,
'name' => 'Brestovac'
],[
'state_id' => 931,
'name' => 'Grad Pakrac'
],[
'state_id' => 931,
'name' => 'Grad Požega'
],[
'state_id' => 931,
'name' => 'Jakšić'
],[
'state_id' => 931,
'name' => 'Kaptol'
],[
'state_id' => 931,
'name' => 'Kutjevo'
],[
'state_id' => 931,
'name' => 'Lipik'
],[
'state_id' => 931,
'name' => 'Pakrac'
],[
'state_id' => 931,
'name' => 'Pleternica'
],[
'state_id' => 931,
'name' => 'Požega'
],[
'state_id' => 931,
'name' => 'Velika'
],[
'state_id' => 931,
'name' => 'Vidovci'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
