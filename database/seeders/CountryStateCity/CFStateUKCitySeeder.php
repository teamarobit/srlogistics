<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CFStateUKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 742,
'name' => 'Bambari'
],[
'state_id' => 742,
'name' => 'Grimari'
],[
'state_id' => 742,
'name' => 'Ippy'
],[
'state_id' => 742,
'name' => 'Kouango'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
