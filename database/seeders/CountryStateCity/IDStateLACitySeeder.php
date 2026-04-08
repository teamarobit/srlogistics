<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateLACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1732,
'name' => 'Bandar Lampung'
],[
'state_id' => 1732,
'name' => 'Kabupaten Lampung Barat'
],[
'state_id' => 1732,
'name' => 'Kabupaten Lampung Selatan'
],[
'state_id' => 1732,
'name' => 'Kabupaten Lampung Tengah'
],[
'state_id' => 1732,
'name' => 'Kabupaten Lampung Timur'
],[
'state_id' => 1732,
'name' => 'Kabupaten Lampung Utara'
],[
'state_id' => 1732,
'name' => 'Kabupaten Mesuji'
],[
'state_id' => 1732,
'name' => 'Kabupaten Pesawaran'
],[
'state_id' => 1732,
'name' => 'Kabupaten Pesisir Barat'
],[
'state_id' => 1732,
'name' => 'Kabupaten Pringsewu'
],[
'state_id' => 1732,
'name' => 'Kabupaten Tanggamus'
],[
'state_id' => 1732,
'name' => 'Kabupaten Tulangbawang'
],[
'state_id' => 1732,
'name' => 'Kabupaten Way Kanan'
],[
'state_id' => 1732,
'name' => 'Kota Bandar Lampung'
],[
'state_id' => 1732,
'name' => 'Kota Metro'
],[
'state_id' => 1732,
'name' => 'Kotabumi'
],[
'state_id' => 1732,
'name' => 'Metro'
],[
'state_id' => 1732,
'name' => 'Terbanggi Besar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
