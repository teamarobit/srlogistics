<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState15CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 663,
'name' => 'Bakan'
],[
'state_id' => 663,
'name' => 'Krakor'
],[
'state_id' => 663,
'name' => 'Pursat'
],[
'state_id' => 663,
'name' => 'Sampov Meas'
],[
'state_id' => 663,
'name' => 'Srŏk Kândiĕng'
],[
'state_id' => 663,
'name' => 'Srŏk Véal Vêng'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
