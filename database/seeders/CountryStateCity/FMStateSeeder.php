<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class FMStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 143,
'name' => 'Chuuk State',
'iso2' => 'TRK'
],[
'country_id' => 143,
'name' => 'Pohnpei State',
'iso2' => 'PNI'
],[
'country_id' => 143,
'name' => 'Yap State',
'iso2' => 'YAP'
],[
'country_id' => 143,
'name' => 'Kosrae State',
'iso2' => 'KSA'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
