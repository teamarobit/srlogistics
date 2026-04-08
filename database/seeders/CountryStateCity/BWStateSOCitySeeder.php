<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BWStateSOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 517,
'name' => 'Kanye'
],[
'state_id' => 517,
'name' => 'Khakhea'
],[
'state_id' => 517,
'name' => 'Mosopa'
],[
'state_id' => 517,
'name' => 'Sekoma'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
