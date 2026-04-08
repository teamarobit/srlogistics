<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateMLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1679,
'name' => 'Cherrapunji'
],[
'state_id' => 1679,
'name' => 'East Garo Hills'
],[
'state_id' => 1679,
'name' => 'East Jaintia Hills'
],[
'state_id' => 1679,
'name' => 'East Khasi Hills'
],[
'state_id' => 1679,
'name' => 'Mairang'
],[
'state_id' => 1679,
'name' => 'Mankachar'
],[
'state_id' => 1679,
'name' => 'Nongpoh'
],[
'state_id' => 1679,
'name' => 'Nongstoin'
],[
'state_id' => 1679,
'name' => 'North Garo Hills'
],[
'state_id' => 1679,
'name' => 'Ri-Bhoi'
],[
'state_id' => 1679,
'name' => 'Shillong'
],[
'state_id' => 1679,
'name' => 'South Garo Hills'
],[
'state_id' => 1679,
'name' => 'South West Garo Hills'
],[
'state_id' => 1679,
'name' => 'South West Khasi Hills'
],[
'state_id' => 1679,
'name' => 'Tura'
],[
'state_id' => 1679,
'name' => 'West Garo Hills'
],[
'state_id' => 1679,
'name' => 'West Jaintia Hills'
],[
'state_id' => 1679,
'name' => 'West Khasi Hills'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
