<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TDStateMECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 755,
'name' => 'Bongor'
],[
'state_id' => 755,
'name' => 'Gounou Gaya'
],[
'state_id' => 755,
'name' => 'Guelendeng'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
