<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState32CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 112,
'name' => 'Brezina'
],[
'state_id' => 112,
'name' => 'El Abiodh Sidi Cheikh'
],[
'state_id' => 112,
'name' => 'El Bayadh'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
