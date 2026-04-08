<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateNBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1735,
'name' => 'Bima'
],[
'state_id' => 1735,
'name' => 'Dompu'
],[
'state_id' => 1735,
'name' => 'Gili Air'
],[
'state_id' => 1735,
'name' => 'Kabupaten Bima'
],[
'state_id' => 1735,
'name' => 'Kabupaten Dompu'
],[
'state_id' => 1735,
'name' => 'Kabupaten Lombok Barat'
],[
'state_id' => 1735,
'name' => 'Kabupaten Lombok Tengah'
],[
'state_id' => 1735,
'name' => 'Kabupaten Lombok Timur'
],[
'state_id' => 1735,
'name' => 'Kabupaten Lombok Utara'
],[
'state_id' => 1735,
'name' => 'Kabupaten Sumbawa'
],[
'state_id' => 1735,
'name' => 'Kabupaten Sumbawa Barat'
],[
'state_id' => 1735,
'name' => 'Kota Bima'
],[
'state_id' => 1735,
'name' => 'Kota Mataram'
],[
'state_id' => 1735,
'name' => 'Labuan Lombok'
],[
'state_id' => 1735,
'name' => 'Lembar'
],[
'state_id' => 1735,
'name' => 'Mataram'
],[
'state_id' => 1735,
'name' => 'Pemenang'
],[
'state_id' => 1735,
'name' => 'Pototano'
],[
'state_id' => 1735,
'name' => 'Praya'
],[
'state_id' => 1735,
'name' => 'Senggigi'
],[
'state_id' => 1735,
'name' => 'Sumbawa Besar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
