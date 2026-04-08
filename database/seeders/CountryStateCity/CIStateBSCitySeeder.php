<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CIStateBSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 918,
'name' => 'Gbôklé'
],[
'state_id' => 918,
'name' => 'Nawa'
],[
'state_id' => 918,
'name' => 'San-Pédro'
],[
'state_id' => 918,
'name' => 'Sassandra'
],[
'state_id' => 918,
'name' => 'Tabou'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
