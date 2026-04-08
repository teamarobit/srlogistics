<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SKStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 200,
'name' => 'Banská Bystrica Region',
'iso2' => 'BC'
],[
'country_id' => 200,
'name' => 'Košice Region',
'iso2' => 'KI'
],[
'country_id' => 200,
'name' => 'Prešov Region',
'iso2' => 'PV'
],[
'country_id' => 200,
'name' => 'Trnava Region',
'iso2' => 'TA'
],[
'country_id' => 200,
'name' => 'Bratislava Region',
'iso2' => 'BL'
],[
'country_id' => 200,
'name' => 'Nitra Region',
'iso2' => 'NI'
],[
'country_id' => 200,
'name' => 'Trenčín Region',
'iso2' => 'TC'
],[
'country_id' => 200,
'name' => 'Žilina Region',
'iso2' => 'ZI'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
