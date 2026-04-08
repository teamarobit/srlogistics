<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState07CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 97,
'name' => 'Biskra'
],[
'state_id' => 97,
'name' => 'Oumache'
],[
'state_id' => 97,
'name' => 'Sidi Khaled'
],[
'state_id' => 97,
'name' => 'Sidi Okba'
],[
'state_id' => 97,
'name' => 'Tolga'
],[
'state_id' => 97,
'name' => 'Zeribet el Oued'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
