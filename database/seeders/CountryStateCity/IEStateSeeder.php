<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class IEStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 105,
'name' => 'Tipperary',
'iso2' => 'TA'
],[
'country_id' => 105,
'name' => 'Sligo',
'iso2' => 'SO'
],[
'country_id' => 105,
'name' => 'Donegal',
'iso2' => 'DL'
],[
'country_id' => 105,
'name' => 'Dublin',
'iso2' => 'D'
],[
'country_id' => 105,
'name' => 'Leinster',
'iso2' => 'L'
],[
'country_id' => 105,
'name' => 'Cork',
'iso2' => 'CO'
],[
'country_id' => 105,
'name' => 'Monaghan',
'iso2' => 'MN'
],[
'country_id' => 105,
'name' => 'Longford',
'iso2' => 'LD'
],[
'country_id' => 105,
'name' => 'Kerry',
'iso2' => 'KY'
],[
'country_id' => 105,
'name' => 'Offaly',
'iso2' => 'OY'
],[
'country_id' => 105,
'name' => 'Galway',
'iso2' => 'G'
],[
'country_id' => 105,
'name' => 'Munster',
'iso2' => 'M'
],[
'country_id' => 105,
'name' => 'Roscommon',
'iso2' => 'RN'
],[
'country_id' => 105,
'name' => 'Kildare',
'iso2' => 'KE'
],[
'country_id' => 105,
'name' => 'Louth',
'iso2' => 'LH'
],[
'country_id' => 105,
'name' => 'Mayo',
'iso2' => 'MO'
],[
'country_id' => 105,
'name' => 'Wicklow',
'iso2' => 'WW'
],[
'country_id' => 105,
'name' => 'Ulster',
'iso2' => 'U'
],[
'country_id' => 105,
'name' => 'Connacht',
'iso2' => 'C'
],[
'country_id' => 105,
'name' => 'Cavan',
'iso2' => 'CN'
],[
'country_id' => 105,
'name' => 'Waterford',
'iso2' => 'WD'
],[
'country_id' => 105,
'name' => 'Kilkenny',
'iso2' => 'KK'
],[
'country_id' => 105,
'name' => 'Clare',
'iso2' => 'CE'
],[
'country_id' => 105,
'name' => 'Meath',
'iso2' => 'MH'
],[
'country_id' => 105,
'name' => 'Wexford',
'iso2' => 'WX'
],[
'country_id' => 105,
'name' => 'Limerick',
'iso2' => 'LK'
],[
'country_id' => 105,
'name' => 'Carlow',
'iso2' => 'CW'
],[
'country_id' => 105,
'name' => 'Laois',
'iso2' => 'LS'
],[
'country_id' => 105,
'name' => 'Westmeath',
'iso2' => 'WH'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
