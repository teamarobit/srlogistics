<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CFStateMPCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 732,
'name' => 'Bimbo'
],[
'state_id' => 732,
'name' => 'Boali'
],[
'state_id' => 732,
'name' => 'Damara'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
