<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateBUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 886,
'name' => 'Aketi'
],[
'state_id' => 886,
'name' => 'Bondo'
],[
'state_id' => 886,
'name' => 'Buta'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
