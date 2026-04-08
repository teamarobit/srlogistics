<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateMUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1723,
'name' => 'East Halmahera Regency'
],[
'state_id' => 1723,
'name' => 'Kabupaten Halmahera Barat'
],[
'state_id' => 1723,
'name' => 'Kabupaten Halmahera Selatan'
],[
'state_id' => 1723,
'name' => 'Kabupaten Halmahera Tengah'
],[
'state_id' => 1723,
'name' => 'Kabupaten Halmahera Utara'
],[
'state_id' => 1723,
'name' => 'Kabupaten Kepulauan Sula'
],[
'state_id' => 1723,
'name' => 'Kabupaten Pulau Morotai'
],[
'state_id' => 1723,
'name' => 'Kabupaten Pulau Taliabu'
],[
'state_id' => 1723,
'name' => 'Kota Ternate'
],[
'state_id' => 1723,
'name' => 'Kota Tidore Kepulauan'
],[
'state_id' => 1723,
'name' => 'Sofifi'
],[
'state_id' => 1723,
'name' => 'Ternate'
],[
'state_id' => 1723,
'name' => 'Tobelo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
