<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BWStateKGCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 520,
'name' => 'Hukuntsi'
],[
'state_id' => 520,
'name' => 'Kang'
],[
'state_id' => 520,
'name' => 'Lehututu'
],[
'state_id' => 520,
'name' => 'Manyana'
],[
'state_id' => 520,
'name' => 'Tshabong'
],[
'state_id' => 520,
'name' => 'Werda'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
