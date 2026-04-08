<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class INStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 101,
'name' => 'Meghalaya',
'iso2' => 'ML'
],[
'country_id' => 101,
'name' => 'Haryana',
'iso2' => 'HR'
],[
'country_id' => 101,
'name' => 'Maharashtra',
'iso2' => 'MH'
],[
'country_id' => 101,
'name' => 'Goa',
'iso2' => 'GA'
],[
'country_id' => 101,
'name' => 'Manipur',
'iso2' => 'MN'
],[
'country_id' => 101,
'name' => 'Puducherry',
'iso2' => 'PY'
],[
'country_id' => 101,
'name' => 'Telangana',
'iso2' => 'TG'
],[
'country_id' => 101,
'name' => 'Odisha',
'iso2' => 'OR'
],[
'country_id' => 101,
'name' => 'Rajasthan',
'iso2' => 'RJ'
],[
'country_id' => 101,
'name' => 'Punjab',
'iso2' => 'PB'
],[
'country_id' => 101,
'name' => 'Uttarakhand',
'iso2' => 'UT'
],[
'country_id' => 101,
'name' => 'Andhra Pradesh',
'iso2' => 'AP'
],[
'country_id' => 101,
'name' => 'Nagaland',
'iso2' => 'NL'
],[
'country_id' => 101,
'name' => 'Lakshadweep',
'iso2' => 'LD'
],[
'country_id' => 101,
'name' => 'Himachal Pradesh',
'iso2' => 'HP'
],[
'country_id' => 101,
'name' => 'Delhi',
'iso2' => 'DL'
],[
'country_id' => 101,
'name' => 'Uttar Pradesh',
'iso2' => 'UP'
],[
'country_id' => 101,
'name' => 'Andaman and Nicobar Islands',
'iso2' => 'AN'
],[
'country_id' => 101,
'name' => 'Arunachal Pradesh',
'iso2' => 'AR'
],[
'country_id' => 101,
'name' => 'Jharkhand',
'iso2' => 'JH'
],[
'country_id' => 101,
'name' => 'Karnataka',
'iso2' => 'KA'
],[
'country_id' => 101,
'name' => 'Assam',
'iso2' => 'AS'
],[
'country_id' => 101,
'name' => 'Kerala',
'iso2' => 'KL'
],[
'country_id' => 101,
'name' => 'Jammu and Kashmir',
'iso2' => 'JK'
],[
'country_id' => 101,
'name' => 'Gujarat',
'iso2' => 'GJ'
],[
'country_id' => 101,
'name' => 'Chandigarh',
'iso2' => 'CH'
],[
'country_id' => 101,
'name' => 'Dadra and Nagar Haveli and Daman and Diu',
'iso2' => 'DH'
],[
'country_id' => 101,
'name' => 'Sikkim',
'iso2' => 'SK'
],[
'country_id' => 101,
'name' => 'Tamil Nadu',
'iso2' => 'TN'
],[
'country_id' => 101,
'name' => 'Mizoram',
'iso2' => 'MZ'
],[
'country_id' => 101,
'name' => 'Bihar',
'iso2' => 'BR'
],[
'country_id' => 101,
'name' => 'Tripura',
'iso2' => 'TR'
],[
'country_id' => 101,
'name' => 'Madhya Pradesh',
'iso2' => 'MP'
],[
'country_id' => 101,
'name' => 'Chhattisgarh',
'iso2' => 'CT'
],[
'country_id' => 101,
'name' => 'Ladakh',
'iso2' => 'LA'
],[
'country_id' => 101,
'name' => 'West Bengal',
'iso2' => 'WB'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
