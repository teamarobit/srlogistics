<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateDLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1694,
'name' => 'Alipur'
],[
'state_id' => 1694,
'name' => 'Bawana'
],[
'state_id' => 1694,
'name' => 'Central Delhi'
],[
'state_id' => 1694,
'name' => 'Delhi'
],[
'state_id' => 1694,
'name' => 'Deoli'
],[
'state_id' => 1694,
'name' => 'East Delhi'
],[
'state_id' => 1694,
'name' => 'Karol Bagh'
],[
'state_id' => 1694,
'name' => 'Najafgarh'
],[
'state_id' => 1694,
'name' => 'Narela'
],[
'state_id' => 1694,
'name' => 'New Delhi'
],[
'state_id' => 1694,
'name' => 'North Delhi'
],[
'state_id' => 1694,
'name' => 'North East Delhi'
],[
'state_id' => 1694,
'name' => 'North West Delhi'
],[
'state_id' => 1694,
'name' => 'Nangloi Jat'
],[
'state_id' => 1694,
'name' => 'Pitampura'
],[
'state_id' => 1694,
'name' => 'Rohini'
],[
'state_id' => 1694,
'name' => 'South Delhi'
],[
'state_id' => 1694,
'name' => 'South West Delhi'
],[
'state_id' => 1694,
'name' => 'West Delhi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
