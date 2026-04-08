<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateGOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1733,
'name' => 'Gorontalo'
],[
'state_id' => 1733,
'name' => 'Kabupaten Boalemo'
],[
'state_id' => 1733,
'name' => 'Kabupaten Bone Bolango'
],[
'state_id' => 1733,
'name' => 'Kabupaten Gorontalo'
],[
'state_id' => 1733,
'name' => 'Kabupaten Gorontalo Utara'
],[
'state_id' => 1733,
'name' => 'Kabupaten Pohuwato'
],[
'state_id' => 1733,
'name' => 'Kota Gorontalo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
