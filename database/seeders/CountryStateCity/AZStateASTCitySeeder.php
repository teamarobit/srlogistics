<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateASTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 233,
'name' => 'Astara'
],[
'state_id' => 233,
'name' => 'Kizhaba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
