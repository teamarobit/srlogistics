<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateJACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1736,
'name' => 'Bejubang Dua'
],[
'state_id' => 1736,
'name' => 'Jambi City'
],[
'state_id' => 1736,
'name' => 'Kabupaten Batang Hari'
],[
'state_id' => 1736,
'name' => 'Kabupaten Bungo'
],[
'state_id' => 1736,
'name' => 'Kabupaten Kerinci'
],[
'state_id' => 1736,
'name' => 'Kabupaten Merangin'
],[
'state_id' => 1736,
'name' => 'Kabupaten Muaro Jambi'
],[
'state_id' => 1736,
'name' => 'Kabupaten Sarolangun'
],[
'state_id' => 1736,
'name' => 'Kabupaten Tanjung Jabung Barat'
],[
'state_id' => 1736,
'name' => 'Kabupaten Tanjung Jabung Timur'
],[
'state_id' => 1736,
'name' => 'Kabupaten Tebo'
],[
'state_id' => 1736,
'name' => 'Kota Jambi'
],[
'state_id' => 1736,
'name' => 'Kota Sungai Penuh'
],[
'state_id' => 1736,
'name' => 'Kuala Tungkal'
],[
'state_id' => 1736,
'name' => 'Mendaha'
],[
'state_id' => 1736,
'name' => 'Simpang'
],[
'state_id' => 1736,
'name' => 'Sungai Penuh'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
