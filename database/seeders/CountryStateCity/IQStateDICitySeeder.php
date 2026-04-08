<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateDICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1791,
'name' => 'Al Miqdādīyah'
],[
'state_id' => 1791,
'name' => 'Baladrūz'
],[
'state_id' => 1791,
'name' => 'Baqubah'
],[
'state_id' => 1791,
'name' => 'Khāliş'
],[
'state_id' => 1791,
'name' => 'Kifrī'
],[
'state_id' => 1791,
'name' => 'Mandalī'
],[
'state_id' => 1791,
'name' => 'Qaḑā’ Kifrī'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
