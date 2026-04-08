<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState48CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 113,
'name' => 'Ammi Moussa'
],[
'state_id' => 113,
'name' => 'Djidiouia'
],[
'state_id' => 113,
'name' => 'Mazouna'
],[
'state_id' => 113,
'name' => 'Oued Rhiou'
],[
'state_id' => 113,
'name' => 'Relizane'
],[
'state_id' => 113,
'name' => 'Smala'
],[
'state_id' => 113,
'name' => 'Zemoura'
],[
'state_id' => 113,
'name' => '’Aïn Merane'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
