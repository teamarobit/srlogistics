<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateBGLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 6,
'name' => 'Baghlān'
],[
'state_id' => 6,
'name' => 'Nahrīn'
],[
'state_id' => 6,
'name' => 'Pul-e Khumrī'
],[
'state_id' => 6,
'name' => 'Ḩukūmatī Dahanah-ye Ghōrī'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
