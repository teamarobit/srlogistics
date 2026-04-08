<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateBCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 879,
'name' => 'Boma'
],[
'state_id' => 879,
'name' => 'Kasangulu'
],[
'state_id' => 879,
'name' => 'Matadi'
],[
'state_id' => 879,
'name' => 'Mbanza-Ngungu'
],[
'state_id' => 879,
'name' => 'Moanda'
],[
'state_id' => 879,
'name' => 'Tshela'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
