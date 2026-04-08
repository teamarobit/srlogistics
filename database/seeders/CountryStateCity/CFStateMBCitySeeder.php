<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CFStateMBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 743,
'name' => 'Bangassou'
],[
'state_id' => 743,
'name' => 'Gambo'
],[
'state_id' => 743,
'name' => 'Ouango'
],[
'state_id' => 743,
'name' => 'Rafai'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
