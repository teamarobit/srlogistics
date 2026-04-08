<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateHERCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 18,
'name' => 'Chahār Burj'
],[
'state_id' => 18,
'name' => 'Ghōriyān'
],[
'state_id' => 18,
'name' => 'Herāt'
],[
'state_id' => 18,
'name' => 'Kafir Qala'
],[
'state_id' => 18,
'name' => 'Karukh'
],[
'state_id' => 18,
'name' => 'Kuhsān'
],[
'state_id' => 18,
'name' => 'Kushk'
],[
'state_id' => 18,
'name' => 'Qarah Bāgh'
],[
'state_id' => 18,
'name' => 'Shīnḏanḏ'
],[
'state_id' => 18,
'name' => 'Tīr Pul'
],[
'state_id' => 18,
'name' => 'Zindah Jān'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
