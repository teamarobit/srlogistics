<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class KRStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 116,
'name' => 'Daegu',
'iso2' => '27'
],[
'country_id' => 116,
'name' => 'Gyeonggi Province',
'iso2' => '41'
],[
'country_id' => 116,
'name' => 'Incheon',
'iso2' => '28'
],[
'country_id' => 116,
'name' => 'Seoul',
'iso2' => '11'
],[
'country_id' => 116,
'name' => 'Daejeon',
'iso2' => '30'
],[
'country_id' => 116,
'name' => 'North Jeolla Province',
'iso2' => '45'
],[
'country_id' => 116,
'name' => 'Ulsan',
'iso2' => '31'
],[
'country_id' => 116,
'name' => 'Jeju',
'iso2' => '49'
],[
'country_id' => 116,
'name' => 'North Chungcheong Province',
'iso2' => '43'
],[
'country_id' => 116,
'name' => 'North Gyeongsang Province',
'iso2' => '47'
],[
'country_id' => 116,
'name' => 'South Jeolla Province',
'iso2' => '46'
],[
'country_id' => 116,
'name' => 'South Gyeongsang Province',
'iso2' => '48'
],[
'country_id' => 116,
'name' => 'Gwangju',
'iso2' => '29'
],[
'country_id' => 116,
'name' => 'South Chungcheong Province',
'iso2' => '44'
],[
'country_id' => 116,
'name' => 'Busan',
'iso2' => '26'
],[
'country_id' => 116,
'name' => 'Sejong City',
'iso2' => '50'
],[
'country_id' => 116,
'name' => 'Gangwon Province',
'iso2' => '42'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
