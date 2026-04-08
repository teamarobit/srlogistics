<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MMStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 151,
'name' => 'Kayin State',
'iso2' => '13'
],[
'country_id' => 151,
'name' => 'Mandalay Region',
'iso2' => '04'
],[
'country_id' => 151,
'name' => 'Yangon Region',
'iso2' => '06'
],[
'country_id' => 151,
'name' => 'Magway Region',
'iso2' => '03'
],[
'country_id' => 151,
'name' => 'Chin State',
'iso2' => '14'
],[
'country_id' => 151,
'name' => 'Rakhine State',
'iso2' => '16'
],[
'country_id' => 151,
'name' => 'Shan State',
'iso2' => '17'
],[
'country_id' => 151,
'name' => 'Tanintharyi Region',
'iso2' => '05'
],[
'country_id' => 151,
'name' => 'Bago',
'iso2' => '02'
],[
'country_id' => 151,
'name' => 'Ayeyarwady Region',
'iso2' => '07'
],[
'country_id' => 151,
'name' => 'Kachin State',
'iso2' => '11'
],[
'country_id' => 151,
'name' => 'Kayah State',
'iso2' => '12'
],[
'country_id' => 151,
'name' => 'Sagaing Region',
'iso2' => '01'
],[
'country_id' => 151,
'name' => 'Naypyidaw Union Territory',
'iso2' => '18'
],[
'country_id' => 151,
'name' => 'Mon State',
'iso2' => '15'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
