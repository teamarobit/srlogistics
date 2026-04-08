<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateTACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 868,
'name' => 'Kabalo'
],[
'state_id' => 868,
'name' => 'Kalemie'
],[
'state_id' => 868,
'name' => 'Kongolo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
