<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class VIStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 242,
'name' => 'Saint Thomas',
'iso2' => 'ST'
],[
'country_id' => 242,
'name' => 'Saint John',
'iso2' => 'SJ'
],[
'country_id' => 242,
'name' => 'Saint Croix',
'iso2' => 'SC'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
