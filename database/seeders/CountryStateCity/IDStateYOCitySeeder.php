<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateYOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1748,
'name' => 'Bambanglipuro'
],[
'state_id' => 1748,
'name' => 'Bantul'
],[
'state_id' => 1748,
'name' => 'Depok'
],[
'state_id' => 1748,
'name' => 'Gamping Lor'
],[
'state_id' => 1748,
'name' => 'Godean'
],[
'state_id' => 1748,
'name' => 'Kabupaten Bantul'
],[
'state_id' => 1748,
'name' => 'Kabupaten Gunung Kidul'
],[
'state_id' => 1748,
'name' => 'Kabupaten Kulon Progo'
],[
'state_id' => 1748,
'name' => 'Kabupaten Sleman'
],[
'state_id' => 1748,
'name' => 'Kasihan'
],[
'state_id' => 1748,
'name' => 'Kota Yogyakarta'
],[
'state_id' => 1748,
'name' => 'Melati'
],[
'state_id' => 1748,
'name' => 'Pandak'
],[
'state_id' => 1748,
'name' => 'Pundong'
],[
'state_id' => 1748,
'name' => 'Sewon'
],[
'state_id' => 1748,
'name' => 'Sleman'
],[
'state_id' => 1748,
'name' => 'Srandakan'
],[
'state_id' => 1748,
'name' => 'Yogyakarta'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
