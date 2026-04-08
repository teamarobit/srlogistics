<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateSGCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1719,
'name' => 'Kabupaten Bombana'
],[
'state_id' => 1719,
'name' => 'Kabupaten Buton'
],[
'state_id' => 1719,
'name' => 'Kabupaten Buton Selatan'
],[
'state_id' => 1719,
'name' => 'Kabupaten Buton Tengah'
],[
'state_id' => 1719,
'name' => 'Kabupaten Buton Utara'
],[
'state_id' => 1719,
'name' => 'Kabupaten Kolaka'
],[
'state_id' => 1719,
'name' => 'Kabupaten Kolaka Timur'
],[
'state_id' => 1719,
'name' => 'Kabupaten Kolaka Utara'
],[
'state_id' => 1719,
'name' => 'Kabupaten Konawe'
],[
'state_id' => 1719,
'name' => 'Kabupaten Konawe Kepulauan'
],[
'state_id' => 1719,
'name' => 'Kabupaten Konawe Selatan'
],[
'state_id' => 1719,
'name' => 'Kabupaten Konawe Utara'
],[
'state_id' => 1719,
'name' => 'Kabupaten Muna'
],[
'state_id' => 1719,
'name' => 'Kabupaten Muna Barat'
],[
'state_id' => 1719,
'name' => 'Katabu'
],[
'state_id' => 1719,
'name' => 'Kendari'
],[
'state_id' => 1719,
'name' => 'Kota Baubau'
],[
'state_id' => 1719,
'name' => 'Kota Kendari'
],[
'state_id' => 1719,
'name' => 'Wakatobi Regency'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
