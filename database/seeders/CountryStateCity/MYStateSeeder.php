<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MYStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 132,
'name' => 'Labuan',
'iso2' => '15'
],[
'country_id' => 132,
'name' => 'Sabah',
'iso2' => '12'
],[
'country_id' => 132,
'name' => 'Sarawak',
'iso2' => '13'
],[
'country_id' => 132,
'name' => 'Perlis',
'iso2' => '09'
],[
'country_id' => 132,
'name' => 'Penang',
'iso2' => '07'
],[
'country_id' => 132,
'name' => 'Pahang',
'iso2' => '06'
],[
'country_id' => 132,
'name' => 'Malacca',
'iso2' => '04'
],[
'country_id' => 132,
'name' => 'Terengganu',
'iso2' => '11'
],[
'country_id' => 132,
'name' => 'Perak',
'iso2' => '08'
],[
'country_id' => 132,
'name' => 'Selangor',
'iso2' => '10'
],[
'country_id' => 132,
'name' => 'Putrajaya',
'iso2' => '16'
],[
'country_id' => 132,
'name' => 'Kelantan',
'iso2' => '03'
],[
'country_id' => 132,
'name' => 'Kedah',
'iso2' => '02'
],[
'country_id' => 132,
'name' => 'Negeri Sembilan',
'iso2' => '05'
],[
'country_id' => 132,
'name' => 'Kuala Lumpur',
'iso2' => '14'
],[
'country_id' => 132,
'name' => 'Johor',
'iso2' => '01'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
