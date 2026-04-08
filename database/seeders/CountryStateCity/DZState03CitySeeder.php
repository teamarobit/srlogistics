<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState03CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 121,
'name' => 'Aflou'
],[
'state_id' => 121,
'name' => 'Laghouat'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
