<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BDStateBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 398,
'name' => 'Bandarban'
],[
'state_id' => 398,
'name' => 'Bibir Hat'
],[
'state_id' => 398,
'name' => 'Brahmanbaria'
],[
'state_id' => 398,
'name' => 'Chandpur'
],[
'state_id' => 398,
'name' => 'Chhāgalnāiya'
],[
'state_id' => 398,
'name' => 'Chittagong'
],[
'state_id' => 398,
'name' => 'Comilla'
],[
'state_id' => 398,
'name' => 'Cox\'s Bazar'
],[
'state_id' => 398,
'name' => 'Cox’s Bāzār'
],[
'state_id' => 398,
'name' => 'Feni'
],[
'state_id' => 398,
'name' => 'Hājīganj'
],[
'state_id' => 398,
'name' => 'Khagrachhari'
],[
'state_id' => 398,
'name' => 'Lakshmipur'
],[
'state_id' => 398,
'name' => 'Lākshām'
],[
'state_id' => 398,
'name' => 'Manikchari'
],[
'state_id' => 398,
'name' => 'Nabīnagar'
],[
'state_id' => 398,
'name' => 'Noakhali'
],[
'state_id' => 398,
'name' => 'Patiya'
],[
'state_id' => 398,
'name' => 'Rangamati'
],[
'state_id' => 398,
'name' => 'Raojān'
],[
'state_id' => 398,
'name' => 'Rāipur'
],[
'state_id' => 398,
'name' => 'Rāmganj'
],[
'state_id' => 398,
'name' => 'Sandwīp'
],[
'state_id' => 398,
'name' => 'Sātkania'
],[
'state_id' => 398,
'name' => 'Teknāf'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
