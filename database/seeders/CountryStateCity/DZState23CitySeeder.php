<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState23CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 86,
'name' => 'Annaba'
],[
'state_id' => 86,
'name' => 'Berrahal'
],[
'state_id' => 86,
'name' => 'Drean'
],[
'state_id' => 86,
'name' => 'El Hadjar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
