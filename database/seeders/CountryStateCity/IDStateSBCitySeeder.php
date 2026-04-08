<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateSBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1747,
'name' => 'Bukittinggi'
],[
'state_id' => 1747,
'name' => 'Kabupaten Agam'
],[
'state_id' => 1747,
'name' => 'Kabupaten Dharmasraya'
],[
'state_id' => 1747,
'name' => 'Kabupaten Kepulauan Mentawai'
],[
'state_id' => 1747,
'name' => 'Kabupaten Lima Puluh Kota'
],[
'state_id' => 1747,
'name' => 'Kabupaten Padang Pariaman'
],[
'state_id' => 1747,
'name' => 'Kabupaten Pasaman'
],[
'state_id' => 1747,
'name' => 'Kabupaten Pasaman Barat'
],[
'state_id' => 1747,
'name' => 'Kabupaten Pesisir Selatan'
],[
'state_id' => 1747,
'name' => 'Kabupaten Sijunjung'
],[
'state_id' => 1747,
'name' => 'Kabupaten Solok'
],[
'state_id' => 1747,
'name' => 'Kabupaten Solok Selatan'
],[
'state_id' => 1747,
'name' => 'Kabupaten Tanah Datar'
],[
'state_id' => 1747,
'name' => 'Kota Bukittinggi'
],[
'state_id' => 1747,
'name' => 'Kota Padang'
],[
'state_id' => 1747,
'name' => 'Kota Padang Panjang'
],[
'state_id' => 1747,
'name' => 'Kota Pariaman'
],[
'state_id' => 1747,
'name' => 'Kota Payakumbuh'
],[
'state_id' => 1747,
'name' => 'Kota Sawah Lunto'
],[
'state_id' => 1747,
'name' => 'Kota Solok'
],[
'state_id' => 1747,
'name' => 'Padang'
],[
'state_id' => 1747,
'name' => 'Pariaman'
],[
'state_id' => 1747,
'name' => 'Payakumbuh'
],[
'state_id' => 1747,
'name' => 'Sijunjung'
],[
'state_id' => 1747,
'name' => 'Solok'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
