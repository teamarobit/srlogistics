<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EEState51CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1219,
'name' => 'Järva-Jaani'
],[
'state_id' => 1219,
'name' => 'Koeru'
],[
'state_id' => 1219,
'name' => 'Paide'
],[
'state_id' => 1219,
'name' => 'Paide linn'
],[
'state_id' => 1219,
'name' => 'Särevere'
],[
'state_id' => 1219,
'name' => 'Türi'
],[
'state_id' => 1219,
'name' => 'Türi vald'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
