<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateBTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1731,
'name' => 'Curug'
],[
'state_id' => 1731,
'name' => 'Kabupaten Lebak'
],[
'state_id' => 1731,
'name' => 'Kabupaten Pandeglang'
],[
'state_id' => 1731,
'name' => 'Kabupaten Serang'
],[
'state_id' => 1731,
'name' => 'Kabupaten Tangerang'
],[
'state_id' => 1731,
'name' => 'Kota Cilegon'
],[
'state_id' => 1731,
'name' => 'Kota Serang'
],[
'state_id' => 1731,
'name' => 'Kota Tangerang'
],[
'state_id' => 1731,
'name' => 'Kota Tangerang Selatan'
],[
'state_id' => 1731,
'name' => 'Labuan'
],[
'state_id' => 1731,
'name' => 'Pandeglang'
],[
'state_id' => 1731,
'name' => 'Rangkasbitung'
],[
'state_id' => 1731,
'name' => 'Serang'
],[
'state_id' => 1731,
'name' => 'South Tangerang'
],[
'state_id' => 1731,
'name' => 'Tangerang'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
