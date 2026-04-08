<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ILStateDCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1829,
'name' => 'Arad'
],[
'state_id' => 1829,
'name' => 'Ashdod'
],[
'state_id' => 1829,
'name' => 'Ashkelon'
],[
'state_id' => 1829,
'name' => 'Beersheba'
],[
'state_id' => 1829,
'name' => 'Dimona'
],[
'state_id' => 1829,
'name' => 'Eilat'
],[
'state_id' => 1829,
'name' => 'Lehavim'
],[
'state_id' => 1829,
'name' => 'Midreshet Ben-Gurion'
],[
'state_id' => 1829,
'name' => 'Mitzpe Ramon'
],[
'state_id' => 1829,
'name' => 'Netivot'
],[
'state_id' => 1829,
'name' => 'Ofaqim'
],[
'state_id' => 1829,
'name' => 'Qiryat Gat'
],[
'state_id' => 1829,
'name' => 'Rahat'
],[
'state_id' => 1829,
'name' => 'Sederot'
],[
'state_id' => 1829,
'name' => 'Yeroẖam'
],[
'state_id' => 1829,
'name' => '‘En Boqeq'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
