<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState29CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 107,
'name' => 'Bou Hanifia el Hamamat'
],[
'state_id' => 107,
'name' => 'Mascara'
],[
'state_id' => 107,
'name' => 'Oued el Abtal'
],[
'state_id' => 107,
'name' => 'Sig'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
