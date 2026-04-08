<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AOStateCUSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 150,
'name' => 'Quibala'
],[
'state_id' => 150,
'name' => 'Sumbe'
],[
'state_id' => 150,
'name' => 'Uacu Cungo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
