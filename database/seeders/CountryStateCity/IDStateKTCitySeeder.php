<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateKTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1717,
'name' => 'Kabupaten Barito Selatan'
],[
'state_id' => 1717,
'name' => 'Kabupaten Barito Timur'
],[
'state_id' => 1717,
'name' => 'Kabupaten Barito Utara'
],[
'state_id' => 1717,
'name' => 'Kabupaten Gunung Mas'
],[
'state_id' => 1717,
'name' => 'Kabupaten Kapuas'
],[
'state_id' => 1717,
'name' => 'Kabupaten Katingan'
],[
'state_id' => 1717,
'name' => 'Kabupaten Kotawaringin Barat'
],[
'state_id' => 1717,
'name' => 'Kabupaten Kotawaringin Timur'
],[
'state_id' => 1717,
'name' => 'Kabupaten Lamandau'
],[
'state_id' => 1717,
'name' => 'Kabupaten Murung Raya'
],[
'state_id' => 1717,
'name' => 'Kabupaten Pulang Pisau'
],[
'state_id' => 1717,
'name' => 'Kabupaten Seruyan'
],[
'state_id' => 1717,
'name' => 'Kabupaten Sukamara'
],[
'state_id' => 1717,
'name' => 'Kota Palangka Raya'
],[
'state_id' => 1717,
'name' => 'Kualakapuas'
],[
'state_id' => 1717,
'name' => 'Palangkaraya'
],[
'state_id' => 1717,
'name' => 'Pangkalanbuun'
],[
'state_id' => 1717,
'name' => 'Sampit'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
