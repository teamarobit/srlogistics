<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateKICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1725,
'name' => 'Balikpapan'
],[
'state_id' => 1725,
'name' => 'Bontang'
],[
'state_id' => 1725,
'name' => 'City of Balikpapan'
],[
'state_id' => 1725,
'name' => 'Kabupaten Berau'
],[
'state_id' => 1725,
'name' => 'Kabupaten Kutai Barat'
],[
'state_id' => 1725,
'name' => 'Kabupaten Kutai Kartanegara'
],[
'state_id' => 1725,
'name' => 'Kabupaten Kutai Timur'
],[
'state_id' => 1725,
'name' => 'Kabupaten Mahakam Hulu'
],[
'state_id' => 1725,
'name' => 'Kabupaten Paser'
],[
'state_id' => 1725,
'name' => 'Kabupaten Penajam Paser Utara'
],[
'state_id' => 1725,
'name' => 'Kota Balikpapan'
],[
'state_id' => 1725,
'name' => 'Kota Bontang'
],[
'state_id' => 1725,
'name' => 'Kota Samarinda'
],[
'state_id' => 1725,
'name' => 'Loa Janan'
],[
'state_id' => 1725,
'name' => 'Samarinda'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
