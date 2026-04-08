<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStatePBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1721,
'name' => 'Kabupaten Fakfak'
],[
'state_id' => 1721,
'name' => 'Kabupaten Kaimana'
],[
'state_id' => 1721,
'name' => 'Kabupaten Manokwari'
],[
'state_id' => 1721,
'name' => 'Kabupaten Manokwari Selatan'
],[
'state_id' => 1721,
'name' => 'Kabupaten Maybrat'
],[
'state_id' => 1721,
'name' => 'Kabupaten Raja Ampat'
],[
'state_id' => 1721,
'name' => 'Kabupaten Sorong'
],[
'state_id' => 1721,
'name' => 'Kabupaten Sorong Selatan'
],[
'state_id' => 1721,
'name' => 'Kabupaten Tambrauw'
],[
'state_id' => 1721,
'name' => 'Kabupaten Teluk Bintuni'
],[
'state_id' => 1721,
'name' => 'Kabupaten Teluk Wondama'
],[
'state_id' => 1721,
'name' => 'Kota Sorong'
],[
'state_id' => 1721,
'name' => 'Manokwari'
],[
'state_id' => 1721,
'name' => 'Sorong'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
