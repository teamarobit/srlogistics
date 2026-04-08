<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateNTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1739,
'name' => 'Atambua'
],[
'state_id' => 1739,
'name' => 'Ende'
],[
'state_id' => 1739,
'name' => 'Kabupaten Alor'
],[
'state_id' => 1739,
'name' => 'Kabupaten Belu'
],[
'state_id' => 1739,
'name' => 'Kabupaten Ende'
],[
'state_id' => 1739,
'name' => 'Kabupaten Flores Timur'
],[
'state_id' => 1739,
'name' => 'Kabupaten Kupang'
],[
'state_id' => 1739,
'name' => 'Kabupaten Lembata'
],[
'state_id' => 1739,
'name' => 'Kabupaten Malaka'
],[
'state_id' => 1739,
'name' => 'Kabupaten Manggarai'
],[
'state_id' => 1739,
'name' => 'Kabupaten Manggarai Barat'
],[
'state_id' => 1739,
'name' => 'Kabupaten Manggarai Timur'
],[
'state_id' => 1739,
'name' => 'Kabupaten Nagekeo'
],[
'state_id' => 1739,
'name' => 'Kabupaten Ngada'
],[
'state_id' => 1739,
'name' => 'Kabupaten Rote Ndao'
],[
'state_id' => 1739,
'name' => 'Kabupaten Sabu Raijua'
],[
'state_id' => 1739,
'name' => 'Kabupaten Sikka'
],[
'state_id' => 1739,
'name' => 'Kabupaten Sumba Barat'
],[
'state_id' => 1739,
'name' => 'Kabupaten Sumba Barat Daya'
],[
'state_id' => 1739,
'name' => 'Kabupaten Sumba Tengah'
],[
'state_id' => 1739,
'name' => 'Kabupaten Sumba Timur'
],[
'state_id' => 1739,
'name' => 'Kabupaten Timor Tengah Selatan'
],[
'state_id' => 1739,
'name' => 'Kabupaten Timor Tengah Utara'
],[
'state_id' => 1739,
'name' => 'Kefamenanu'
],[
'state_id' => 1739,
'name' => 'Komodo'
],[
'state_id' => 1739,
'name' => 'Kota Kupang'
],[
'state_id' => 1739,
'name' => 'Kupang'
],[
'state_id' => 1739,
'name' => 'Labuan Bajo'
],[
'state_id' => 1739,
'name' => 'Maumere'
],[
'state_id' => 1739,
'name' => 'Naisano Dua'
],[
'state_id' => 1739,
'name' => 'Ruteng'
],[
'state_id' => 1739,
'name' => 'Soe'
],[
'state_id' => 1739,
'name' => 'Waingapu'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
