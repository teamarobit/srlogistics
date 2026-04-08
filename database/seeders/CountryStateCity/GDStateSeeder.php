<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class GDStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 87,
'name' => 'Saint Patrick Parish',
'iso2' => '06'
],[
'country_id' => 87,
'name' => 'Saint George Parish',
'iso2' => '03'
],[
'country_id' => 87,
'name' => 'Saint Andrew Parish',
'iso2' => '01'
],[
'country_id' => 87,
'name' => 'Saint Mark Parish',
'iso2' => '05'
],[
'country_id' => 87,
'name' => 'Carriacou and Petite Martinique',
'iso2' => '10'
],[
'country_id' => 87,
'name' => 'Saint John Parish',
'iso2' => '04'
],[
'country_id' => 87,
'name' => 'Saint David Parish',
'iso2' => '02'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
