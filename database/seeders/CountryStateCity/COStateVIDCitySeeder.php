<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateVIDCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 839,
'name' => 'Cumaribo'
],[
'state_id' => 839,
'name' => 'La Primavera'
],[
'state_id' => 839,
'name' => 'Puerto Carreño'
],[
'state_id' => 839,
'name' => 'Santa Rosalia'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
