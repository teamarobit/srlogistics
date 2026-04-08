<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ADState03CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 139,
'name' => 'Encamp'
],[
'state_id' => 139,
'name' => 'Pas de la Casa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
