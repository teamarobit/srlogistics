<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateRICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1730,
'name' => 'Balaipungut'
],[
'state_id' => 1730,
'name' => 'Batam'
],[
'state_id' => 1730,
'name' => 'Dumai'
],[
'state_id' => 1730,
'name' => 'Kabupaten Bengkalis'
],[
'state_id' => 1730,
'name' => 'Kabupaten Indragiri Hilir'
],[
'state_id' => 1730,
'name' => 'Kabupaten Indragiri Hulu'
],[
'state_id' => 1730,
'name' => 'Kabupaten Kampar'
],[
'state_id' => 1730,
'name' => 'Kabupaten Kepulauan Meranti'
],[
'state_id' => 1730,
'name' => 'Kabupaten Kuantan Singingi'
],[
'state_id' => 1730,
'name' => 'Kabupaten Pelalawan'
],[
'state_id' => 1730,
'name' => 'Kabupaten Rokan Hilir'
],[
'state_id' => 1730,
'name' => 'Kabupaten Rokan Hulu'
],[
'state_id' => 1730,
'name' => 'Kabupaten Siak'
],[
'state_id' => 1730,
'name' => 'Kota Dumai'
],[
'state_id' => 1730,
'name' => 'Kota Pekanbaru'
],[
'state_id' => 1730,
'name' => 'Pekanbaru'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
