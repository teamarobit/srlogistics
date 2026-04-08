<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateMACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1722,
'name' => 'Amahai'
],[
'state_id' => 1722,
'name' => 'Ambon'
],[
'state_id' => 1722,
'name' => 'Kabupaten Buru'
],[
'state_id' => 1722,
'name' => 'Kabupaten Buru Selatan'
],[
'state_id' => 1722,
'name' => 'Kabupaten Kepulauan Aru'
],[
'state_id' => 1722,
'name' => 'Kabupaten Maluku Barat Daya'
],[
'state_id' => 1722,
'name' => 'Kabupaten Maluku Tengah'
],[
'state_id' => 1722,
'name' => 'Kabupaten Maluku Tenggara'
],[
'state_id' => 1722,
'name' => 'Kabupaten Maluku Tenggara Barat'
],[
'state_id' => 1722,
'name' => 'Kabupaten Seram Bagian Barat'
],[
'state_id' => 1722,
'name' => 'Kabupaten Seram Bagian Timur'
],[
'state_id' => 1722,
'name' => 'Kota Ambon'
],[
'state_id' => 1722,
'name' => 'Kota Tual'
],[
'state_id' => 1722,
'name' => 'Tual'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
