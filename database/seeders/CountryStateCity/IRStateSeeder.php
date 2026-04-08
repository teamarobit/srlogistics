<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class IRStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 103,
'name' => 'Markazi',
'iso2' => '00'
],[
'country_id' => 103,
'name' => 'Khuzestan',
'iso2' => '06'
],[
'country_id' => 103,
'name' => 'Ilam',
'iso2' => '16'
],[
'country_id' => 103,
'name' => 'Kermanshah',
'iso2' => '05'
],[
'country_id' => 103,
'name' => 'Gilan',
'iso2' => '01'
],[
'country_id' => 103,
'name' => 'Chaharmahal and Bakhtiari',
'iso2' => '14'
],[
'country_id' => 103,
'name' => 'Qom',
'iso2' => '25'
],[
'country_id' => 103,
'name' => 'Isfahan',
'iso2' => '10'
],[
'country_id' => 103,
'name' => 'West Azarbaijan',
'iso2' => '04'
],[
'country_id' => 103,
'name' => 'Zanjan',
'iso2' => '19'
],[
'country_id' => 103,
'name' => 'Kohgiluyeh and Boyer-Ahmad',
'iso2' => '17'
],[
'country_id' => 103,
'name' => 'Razavi Khorasan',
'iso2' => '09'
],[
'country_id' => 103,
'name' => 'Lorestan',
'iso2' => '15'
],[
'country_id' => 103,
'name' => 'Alborz',
'iso2' => '30'
],[
'country_id' => 103,
'name' => 'South Khorasan',
'iso2' => '29'
],[
'country_id' => 103,
'name' => 'Sistan and Baluchestan',
'iso2' => '11'
],[
'country_id' => 103,
'name' => 'Bushehr',
'iso2' => '18'
],[
'country_id' => 103,
'name' => 'Golestan',
'iso2' => '27'
],[
'country_id' => 103,
'name' => 'Ardabil',
'iso2' => '24'
],[
'country_id' => 103,
'name' => 'Kurdistan',
'iso2' => '12'
],[
'country_id' => 103,
'name' => 'Yazd',
'iso2' => '21'
],[
'country_id' => 103,
'name' => 'Hormozgan',
'iso2' => '22'
],[
'country_id' => 103,
'name' => 'Mazandaran',
'iso2' => '02'
],[
'country_id' => 103,
'name' => 'Fars',
'iso2' => '07'
],[
'country_id' => 103,
'name' => 'Semnan',
'iso2' => '20'
],[
'country_id' => 103,
'name' => 'Qazvin',
'iso2' => '26'
],[
'country_id' => 103,
'name' => 'North Khorasan',
'iso2' => '28'
],[
'country_id' => 103,
'name' => 'Kerman',
'iso2' => '08'
],[
'country_id' => 103,
'name' => 'East Azerbaijan',
'iso2' => '03'
],[
'country_id' => 103,
'name' => 'Tehran',
'iso2' => '23'
],[
'country_id' => 103,
'name' => 'Hamadan',
'iso2' => '13'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
