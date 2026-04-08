<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GEStateSKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1416,
'name' => 'Agara'
],[
'state_id' => 1416,
'name' => 'Gori'
],[
'state_id' => 1416,
'name' => 'Goris Munitsip’alit’et’i'
],[
'state_id' => 1416,
'name' => 'Kaspi'
],[
'state_id' => 1416,
'name' => 'Khashuri'
],[
'state_id' => 1416,
'name' => 'Surami'
],[
'state_id' => 1416,
'name' => 'Ts’khinvali'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
