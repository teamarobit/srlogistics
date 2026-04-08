<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateSECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1135,
'name' => 'La Libertad'
],[
'state_id' => 1135,
'name' => 'Salinas'
],[
'state_id' => 1135,
'name' => 'Santa Elena'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
