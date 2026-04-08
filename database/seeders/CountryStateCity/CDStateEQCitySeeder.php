<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateEQCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 877,
'name' => 'Gemena'
],[
'state_id' => 877,
'name' => 'Lisala'
],[
'state_id' => 877,
'name' => 'Lukolela'
],[
'state_id' => 877,
'name' => 'Mbandaka'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
