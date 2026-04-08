<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateKSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1740,
'name' => 'Amuntai'
],[
'state_id' => 1740,
'name' => 'Banjarmasin'
],[
'state_id' => 1740,
'name' => 'Barabai'
],[
'state_id' => 1740,
'name' => 'Kabupaten Balangan'
],[
'state_id' => 1740,
'name' => 'Kabupaten Banjar'
],[
'state_id' => 1740,
'name' => 'Kabupaten Barito Kuala'
],[
'state_id' => 1740,
'name' => 'Kabupaten Hulu Sungai Selatan'
],[
'state_id' => 1740,
'name' => 'Kabupaten Hulu Sungai Tengah'
],[
'state_id' => 1740,
'name' => 'Kabupaten Hulu Sungai Utara'
],[
'state_id' => 1740,
'name' => 'Kabupaten Kota Baru'
],[
'state_id' => 1740,
'name' => 'Kabupaten Tabalong'
],[
'state_id' => 1740,
'name' => 'Kabupaten Tanah Bumbu'
],[
'state_id' => 1740,
'name' => 'Kabupaten Tanah Laut'
],[
'state_id' => 1740,
'name' => 'Kabupaten Tapin'
],[
'state_id' => 1740,
'name' => 'Kota Banjar Baru'
],[
'state_id' => 1740,
'name' => 'Kota Banjarmasin'
],[
'state_id' => 1740,
'name' => 'Martapura'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
