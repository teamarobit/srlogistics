<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GNStateMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1548,
'name' => 'Dalaba'
],[
'state_id' => 1548,
'name' => 'Mamou'
],[
'state_id' => 1548,
'name' => 'Mamou Prefecture'
],[
'state_id' => 1548,
'name' => 'Pita'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
