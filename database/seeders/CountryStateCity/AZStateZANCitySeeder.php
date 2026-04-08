<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateZANCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 286,
'name' => 'Mincivan'
],[
'state_id' => 286,
'name' => 'Zangilan'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
