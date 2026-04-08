<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateSRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1738,
'name' => 'Kabupaten Majene'
],[
'state_id' => 1738,
'name' => 'Kabupaten Mamasa'
],[
'state_id' => 1738,
'name' => 'Kabupaten Mamuju'
],[
'state_id' => 1738,
'name' => 'Kabupaten Mamuju Tengah'
],[
'state_id' => 1738,
'name' => 'Kabupaten Mamuju Utara'
],[
'state_id' => 1738,
'name' => 'Kabupaten Polewali Mandar'
],[
'state_id' => 1738,
'name' => 'Majene'
],[
'state_id' => 1738,
'name' => 'Mamuju'
],[
'state_id' => 1738,
'name' => 'Polewali'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
