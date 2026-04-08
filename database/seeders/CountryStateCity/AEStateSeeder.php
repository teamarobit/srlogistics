<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class AEStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 231,
'name' => 'Sharjah Emirate',
'iso2' => 'SH'
],[
'country_id' => 231,
'name' => 'Dubai',
'iso2' => 'DU'
],[
'country_id' => 231,
'name' => 'Umm al-Quwain',
'iso2' => 'UQ'
],[
'country_id' => 231,
'name' => 'Fujairah',
'iso2' => 'FU'
],[
'country_id' => 231,
'name' => 'Ras al-Khaimah',
'iso2' => 'RK'
],[
'country_id' => 231,
'name' => 'Ajman Emirate',
'iso2' => 'AJ'
],[
'country_id' => 231,
'name' => 'Abu Dhabi Emirate',
'iso2' => 'AZ'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
