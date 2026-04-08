<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStatePARCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 26,
'name' => 'Charikar'
],[
'state_id' => 26,
'name' => 'Jabal os Saraj'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
