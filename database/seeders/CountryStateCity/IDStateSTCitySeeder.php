<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateSTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1734,
'name' => 'Kabupaten Banggai'
],[
'state_id' => 1734,
'name' => 'Kabupaten Banggai Kepulauan'
],[
'state_id' => 1734,
'name' => 'Kabupaten Banggai Laut'
],[
'state_id' => 1734,
'name' => 'Kabupaten Buol'
],[
'state_id' => 1734,
'name' => 'Kabupaten Donggala'
],[
'state_id' => 1734,
'name' => 'Kabupaten Morowali Utara'
],[
'state_id' => 1734,
'name' => 'Kabupaten Parigi Moutong'
],[
'state_id' => 1734,
'name' => 'Kabupaten Poso'
],[
'state_id' => 1734,
'name' => 'Kabupaten Sigi'
],[
'state_id' => 1734,
'name' => 'Kabupaten Toli-Toli'
],[
'state_id' => 1734,
'name' => 'Kota Palu'
],[
'state_id' => 1734,
'name' => 'Luwuk'
],[
'state_id' => 1734,
'name' => 'Morowali Regency'
],[
'state_id' => 1734,
'name' => 'Palu'
],[
'state_id' => 1734,
'name' => 'Poso'
],[
'state_id' => 1734,
'name' => 'Tojo Una-Una Regency'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
