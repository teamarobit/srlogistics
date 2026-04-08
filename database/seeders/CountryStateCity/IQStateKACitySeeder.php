<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateKACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1783,
'name' => 'Al Hindīyah'
],[
'state_id' => 1783,
'name' => 'Karbala'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
