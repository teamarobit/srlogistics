<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateMUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1784,
'name' => 'Ar Rumaythah'
],[
'state_id' => 1784,
'name' => 'As Samawah'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
