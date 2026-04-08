<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class PSStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 169,
'name' => 'Bethlehem',
'iso2' => 'BTH'
],[
'country_id' => 169,
'name' => 'Deir El Balah',
'iso2' => 'DEB'
],[
'country_id' => 169,
'name' => 'Gaza',
'iso2' => 'GZA'
],[
'country_id' => 169,
'name' => 'Hebron',
'iso2' => 'HBN'
],[
'country_id' => 169,
'name' => 'Jenin',
'iso2' => 'JEN'
],[
'country_id' => 169,
'name' => 'Jericho and Al Aghwar',
'iso2' => 'JRH'
],[
'country_id' => 169,
'name' => 'Jerusalem',
'iso2' => 'JEM'
],[
'country_id' => 169,
'name' => 'Khan Yunis',
'iso2' => 'KYS'
],[
'country_id' => 169,
'name' => 'Nablus',
'iso2' => 'NBS'
],[
'country_id' => 169,
'name' => 'North Gaza',
'iso2' => 'NGZ'
],[
'country_id' => 169,
'name' => 'Qalqilya',
'iso2' => 'QQA'
],[
'country_id' => 169,
'name' => 'Rafah',
'iso2' => 'RFH'
],[
'country_id' => 169,
'name' => 'Ramallah',
'iso2' => 'RBH'
],[
'country_id' => 169,
'name' => 'Salfit',
'iso2' => 'SLT'
],[
'country_id' => 169,
'name' => 'Tubas',
'iso2' => 'TBS'
],[
'country_id' => 169,
'name' => 'Tulkarm',
'iso2' => 'TKM'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
