<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateABSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 245,
'name' => 'Ceyranbatan'
],[
'state_id' => 245,
'name' => 'Digah'
],[
'state_id' => 245,
'name' => 'Gyuzdek'
],[
'state_id' => 245,
'name' => 'Khirdalan'
],[
'state_id' => 245,
'name' => 'Qobu'
],[
'state_id' => 245,
'name' => 'Saray'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
