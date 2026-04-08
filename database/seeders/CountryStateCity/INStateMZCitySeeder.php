<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateMZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1708,
'name' => 'Aizawl'
],[
'state_id' => 1708,
'name' => 'Champhai'
],[
'state_id' => 1708,
'name' => 'Darlawn'
],[
'state_id' => 1708,
'name' => 'Khawhai'
],[
'state_id' => 1708,
'name' => 'Kolasib'
],[
'state_id' => 1708,
'name' => 'Lawngtlai'
],[
'state_id' => 1708,
'name' => 'Lunglei'
],[
'state_id' => 1708,
'name' => 'Mamit'
],[
'state_id' => 1708,
'name' => 'North Vanlaiphai'
],[
'state_id' => 1708,
'name' => 'Saiha'
],[
'state_id' => 1708,
'name' => 'Sairang'
],[
'state_id' => 1708,
'name' => 'Serchhip'
],[
'state_id' => 1708,
'name' => 'Saitlaw'
],[
'state_id' => 1708,
'name' => 'Thenzawl'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
