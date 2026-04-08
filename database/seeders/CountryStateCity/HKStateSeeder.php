<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class HKStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 98,
'name' => 'Yuen Long District',
'iso2' => 'NYL'
],[
'country_id' => 98,
'name' => 'Tsuen Wan District',
'iso2' => 'NTW'
],[
'country_id' => 98,
'name' => 'Sai Kung District',
'iso2' => 'NSK'
],[
'country_id' => 98,
'name' => 'Islands District',
'iso2' => 'NIS'
],[
'country_id' => 98,
'name' => 'Central and Western District',
'iso2' => 'HCW'
],[
'country_id' => 98,
'name' => 'Wan Chai',
'iso2' => 'HWC'
],[
'country_id' => 98,
'name' => 'Eastern',
'iso2' => 'HEA'
],[
'country_id' => 98,
'name' => 'Southern',
'iso2' => 'HSO'
],[
'country_id' => 98,
'name' => 'Yau Tsim Mong',
'iso2' => 'KYT'
],[
'country_id' => 98,
'name' => 'Sham Shui Po',
'iso2' => 'KSS'
],[
'country_id' => 98,
'name' => 'Kowloon City',
'iso2' => 'KKC'
],[
'country_id' => 98,
'name' => 'Wong Tai Sin',
'iso2' => 'KWT'
],[
'country_id' => 98,
'name' => 'Kwun Tong',
'iso2' => 'KKT'
],[
'country_id' => 98,
'name' => 'Kwai Tsing',
'iso2' => 'NKT'
],[
'country_id' => 98,
'name' => 'Tuen Mun',
'iso2' => 'NTM'
],[
'country_id' => 98,
'name' => 'North',
'iso2' => 'NNO'
],[
'country_id' => 98,
'name' => 'Sha Tin',
'iso2' => 'NST'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
