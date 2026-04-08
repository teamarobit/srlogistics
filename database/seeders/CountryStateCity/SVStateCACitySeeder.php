<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class SVStateCACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1184,
'name' => 'Sensuntepeque'
],[
'state_id' => 1184,
'name' => 'Victoria'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
