<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GHStateNPCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1443,
'name' => 'Kpandae'
],[
'state_id' => 1443,
'name' => 'Salaga'
],[
'state_id' => 1443,
'name' => 'Savelugu'
],[
'state_id' => 1443,
'name' => 'Tamale'
],[
'state_id' => 1443,
'name' => 'Yendi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
