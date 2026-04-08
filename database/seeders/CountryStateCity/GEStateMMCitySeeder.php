<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GEStateMMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1415,
'name' => 'Akhalgori'
],[
'state_id' => 1415,
'name' => 'Dzegvi'
],[
'state_id' => 1415,
'name' => 'Gudauri'
],[
'state_id' => 1415,
'name' => 'Java'
],[
'state_id' => 1415,
'name' => 'Mtskheta'
],[
'state_id' => 1415,
'name' => 'P’asanauri'
],[
'state_id' => 1415,
'name' => 'Step’antsminda'
],[
'state_id' => 1415,
'name' => 'Zhinvali'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
