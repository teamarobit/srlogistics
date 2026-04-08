<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateFYMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1168,
'name' => 'Al Fayyūm'
],[
'state_id' => 1168,
'name' => 'Al Wāsiţah'
],[
'state_id' => 1168,
'name' => 'Ibshawāy'
],[
'state_id' => 1168,
'name' => 'Iţsā'
],[
'state_id' => 1168,
'name' => 'Ţāmiyah'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
