<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState39CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 82,
'name' => 'Debila'
],[
'state_id' => 82,
'name' => 'El Oued'
],[
'state_id' => 82,
'name' => 'Reguiba'
],[
'state_id' => 82,
'name' => 'Robbah'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
