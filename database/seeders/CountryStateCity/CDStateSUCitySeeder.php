<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateSUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 881,
'name' => 'Bongandanga'
],[
'state_id' => 881,
'name' => 'Libenge'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
