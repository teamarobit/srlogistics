<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class TWStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 216,
'name' => 'Yilan',
'iso2' => 'ILA'
],[
'country_id' => 216,
'name' => 'Penghu',
'iso2' => 'PEN'
],[
'country_id' => 216,
'name' => 'Changhua',
'iso2' => 'CHA'
],[
'country_id' => 216,
'name' => 'Pingtung',
'iso2' => 'PIF'
],[
'country_id' => 216,
'name' => 'Taichung',
'iso2' => 'TXG'
],[
'country_id' => 216,
'name' => 'Nantou',
'iso2' => 'NAN'
],[
'country_id' => 216,
'name' => 'Chiayi',
'iso2' => 'CYI'
],[
'country_id' => 216,
'name' => 'Taitung',
'iso2' => 'TTT'
],[
'country_id' => 216,
'name' => 'Hualien',
'iso2' => 'HUA'
],[
'country_id' => 216,
'name' => 'Kaohsiung',
'iso2' => 'KHH'
],[
'country_id' => 216,
'name' => 'Miaoli',
'iso2' => 'MIA'
],[
'country_id' => 216,
'name' => 'Kinmen',
'iso2' => 'KIN'
],[
'country_id' => 216,
'name' => 'Yunlin',
'iso2' => 'YUN'
],[
'country_id' => 216,
'name' => 'Hsinchu',
'iso2' => 'HSZ'
],[
'country_id' => 216,
'name' => 'Chiayi',
'iso2' => 'CYQ'
],[
'country_id' => 216,
'name' => 'Taoyuan',
'iso2' => 'TAO'
],[
'country_id' => 216,
'name' => 'Lienchiang',
'iso2' => 'LIE'
],[
'country_id' => 216,
'name' => 'Tainan',
'iso2' => 'TNN'
],[
'country_id' => 216,
'name' => 'Taipei',
'iso2' => 'TPE'
],[
'country_id' => 216,
'name' => 'Hsinchu',
'iso2' => 'HSQ'
],[
'country_id' => 216,
'name' => 'Keelung',
'iso2' => 'KEE'
],[
'country_id' => 216,
'name' => 'New Taipei',
'iso2' => 'NWT'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
