<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState17CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 678,
'name' => 'Siem Reap'
],[
'state_id' => 678,
'name' => 'Srŏk Prasat Bakong'
],[
'state_id' => 678,
'name' => 'Srŏk Ângkôr Thum'
],[
'state_id' => 678,
'name' => 'Svay Leu'
],[
'state_id' => 678,
'name' => 'Varin'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
