<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BDState34CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 361,
'name' => 'Gafargaon'
],[
'state_id' => 361,
'name' => 'Jamalpur'
],[
'state_id' => 361,
'name' => 'Muktāgācha'
],[
'state_id' => 361,
'name' => 'Mymensingh'
],[
'state_id' => 361,
'name' => 'Netrakona'
],[
'state_id' => 361,
'name' => 'Sarishābāri'
],[
'state_id' => 361,
'name' => 'Sherpur'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
