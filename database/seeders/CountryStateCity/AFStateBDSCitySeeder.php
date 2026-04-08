<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateBDSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 32,
'name' => 'Ashkāsham'
],[
'state_id' => 32,
'name' => 'Fayzabad'
],[
'state_id' => 32,
'name' => 'Jurm'
],[
'state_id' => 32,
'name' => 'Khandūd'
],[
'state_id' => 32,
'name' => 'Rāghistān'
],[
'state_id' => 32,
'name' => 'Wākhān'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
