<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateSNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1718,
'name' => 'Galesong'
],[
'state_id' => 1718,
'name' => 'Kabupaten Bantaeng'
],[
'state_id' => 1718,
'name' => 'Kabupaten Barru'
],[
'state_id' => 1718,
'name' => 'Kabupaten Bone'
],[
'state_id' => 1718,
'name' => 'Kabupaten Bulukumba'
],[
'state_id' => 1718,
'name' => 'Kabupaten Enrekang'
],[
'state_id' => 1718,
'name' => 'Kabupaten Gowa'
],[
'state_id' => 1718,
'name' => 'Kabupaten Jeneponto'
],[
'state_id' => 1718,
'name' => 'Kabupaten Luwu'
],[
'state_id' => 1718,
'name' => 'Kabupaten Luwu Timur'
],[
'state_id' => 1718,
'name' => 'Kabupaten Luwu Utara'
],[
'state_id' => 1718,
'name' => 'Kabupaten Maros'
],[
'state_id' => 1718,
'name' => 'Kabupaten Pangkajene Dan Kepulauan'
],[
'state_id' => 1718,
'name' => 'Kabupaten Pinrang'
],[
'state_id' => 1718,
'name' => 'Kabupaten Sidenreng Rappang'
],[
'state_id' => 1718,
'name' => 'Kabupaten Sinjai'
],[
'state_id' => 1718,
'name' => 'Kabupaten Soppeng'
],[
'state_id' => 1718,
'name' => 'Kabupaten Takalar'
],[
'state_id' => 1718,
'name' => 'Kabupaten Tana Toraja'
],[
'state_id' => 1718,
'name' => 'Kabupaten Toraja Utara'
],[
'state_id' => 1718,
'name' => 'Kabupaten Wajo'
],[
'state_id' => 1718,
'name' => 'Kota Makassar'
],[
'state_id' => 1718,
'name' => 'Kota Palopo'
],[
'state_id' => 1718,
'name' => 'Kota Parepare'
],[
'state_id' => 1718,
'name' => 'Makassar'
],[
'state_id' => 1718,
'name' => 'Maros'
],[
'state_id' => 1718,
'name' => 'Palopo'
],[
'state_id' => 1718,
'name' => 'Parepare'
],[
'state_id' => 1718,
'name' => 'Rantepao'
],[
'state_id' => 1718,
'name' => 'Selayar Islands Regency'
],[
'state_id' => 1718,
'name' => 'Sengkang'
],[
'state_id' => 1718,
'name' => 'Sinjai'
],[
'state_id' => 1718,
'name' => 'Watampone'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
