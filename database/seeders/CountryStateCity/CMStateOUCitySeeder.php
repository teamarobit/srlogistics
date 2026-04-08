<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CMStateOUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 691,
'name' => 'Bafang'
],[
'state_id' => 691,
'name' => 'Bafoussam'
],[
'state_id' => 691,
'name' => 'Bamendjou'
],[
'state_id' => 691,
'name' => 'Bana'
],[
'state_id' => 691,
'name' => 'Bandjoun'
],[
'state_id' => 691,
'name' => 'Bangangté'
],[
'state_id' => 691,
'name' => 'Bansoa'
],[
'state_id' => 691,
'name' => 'Bazou'
],[
'state_id' => 691,
'name' => 'Dschang'
],[
'state_id' => 691,
'name' => 'Foumban'
],[
'state_id' => 691,
'name' => 'Foumbot'
],[
'state_id' => 691,
'name' => 'Hauts-Plateaux'
],[
'state_id' => 691,
'name' => 'Koung-Khi'
],[
'state_id' => 691,
'name' => 'Mbouda'
],[
'state_id' => 691,
'name' => 'Ngou'
],[
'state_id' => 691,
'name' => 'Noun'
],[
'state_id' => 691,
'name' => 'Tonga'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
