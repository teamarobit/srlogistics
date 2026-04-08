<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SAStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 194,
'name' => 'Riyadh',
'iso2' => '01'
],[
'country_id' => 194,
'name' => 'Makkah',
'iso2' => '02'
],[
'country_id' => 194,
'name' => 'Al Madinah',
'iso2' => '03'
],[
'country_id' => 194,
'name' => 'Tabuk',
'iso2' => '07'
],[
'country_id' => 194,
'name' => 'Asir',
'iso2' => '14'
],[
'country_id' => 194,
'name' => 'Northern Borders',
'iso2' => '08'
],[
'country_id' => 194,
'name' => 'Ha\'il',
'iso2' => '06'
],[
'country_id' => 194,
'name' => 'Eastern Province',
'iso2' => '04'
],[
'country_id' => 194,
'name' => 'Al Jawf',
'iso2' => '12'
],[
'country_id' => 194,
'name' => 'Jizan',
'iso2' => '09'
],[
'country_id' => 194,
'name' => 'Al Bahah',
'iso2' => '11'
],[
'country_id' => 194,
'name' => 'Najran',
'iso2' => '10'
],[
'country_id' => 194,
'name' => 'Al-Qassim',
'iso2' => '05'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
