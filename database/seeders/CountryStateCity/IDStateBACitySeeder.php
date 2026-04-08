<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateBACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1745,
'name' => 'Amlapura'
],[
'state_id' => 1745,
'name' => 'Amlapura city'
],[
'state_id' => 1745,
'name' => 'Banjar'
],[
'state_id' => 1745,
'name' => 'Banjar Wangsian'
],[
'state_id' => 1745,
'name' => 'Bedugul'
],[
'state_id' => 1745,
'name' => 'Denpasar'
],[
'state_id' => 1745,
'name' => 'Jimbaran'
],[
'state_id' => 1745,
'name' => 'Kabupaten Badung'
],[
'state_id' => 1745,
'name' => 'Kabupaten Bangli'
],[
'state_id' => 1745,
'name' => 'Kabupaten Buleleng'
],[
'state_id' => 1745,
'name' => 'Kabupaten Gianyar'
],[
'state_id' => 1745,
'name' => 'Kabupaten Jembrana'
],[
'state_id' => 1745,
'name' => 'Kabupaten Karang Asem'
],[
'state_id' => 1745,
'name' => 'Kabupaten Klungkung'
],[
'state_id' => 1745,
'name' => 'Kabupaten Tabanan'
],[
'state_id' => 1745,
'name' => 'Klungkung'
],[
'state_id' => 1745,
'name' => 'Kota Denpasar'
],[
'state_id' => 1745,
'name' => 'Kuta'
],[
'state_id' => 1745,
'name' => 'Legian'
],[
'state_id' => 1745,
'name' => 'Lovina'
],[
'state_id' => 1745,
'name' => 'Munduk'
],[
'state_id' => 1745,
'name' => 'Negara'
],[
'state_id' => 1745,
'name' => 'Nusa Dua'
],[
'state_id' => 1745,
'name' => 'Seririt'
],[
'state_id' => 1745,
'name' => 'Singaraja'
],[
'state_id' => 1745,
'name' => 'Tabanan'
],[
'state_id' => 1745,
'name' => 'Ubud'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
