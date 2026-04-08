<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ETStateAMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1225,
'name' => 'Abomsa'
],[
'state_id' => 1225,
'name' => 'Addiet Canna'
],[
'state_id' => 1225,
'name' => 'Bahir Dar'
],[
'state_id' => 1225,
'name' => 'Batī'
],[
'state_id' => 1225,
'name' => 'Bichena'
],[
'state_id' => 1225,
'name' => 'Burē'
],[
'state_id' => 1225,
'name' => 'Dabat'
],[
'state_id' => 1225,
'name' => 'Debark’'
],[
'state_id' => 1225,
'name' => 'Debre Birhan'
],[
'state_id' => 1225,
'name' => 'Debre Mark’os'
],[
'state_id' => 1225,
'name' => 'Debre Sīna'
],[
'state_id' => 1225,
'name' => 'Debre Tabor'
],[
'state_id' => 1225,
'name' => 'Debre Werk’'
],[
'state_id' => 1225,
'name' => 'Dejen'
],[
'state_id' => 1225,
'name' => 'Desē'
],[
'state_id' => 1225,
'name' => 'Finote Selam'
],[
'state_id' => 1225,
'name' => 'Gondar'
],[
'state_id' => 1225,
'name' => 'Kemisē'
],[
'state_id' => 1225,
'name' => 'Kombolcha'
],[
'state_id' => 1225,
'name' => 'Lalībela'
],[
'state_id' => 1225,
'name' => 'North Shewa Zone'
],[
'state_id' => 1225,
'name' => 'North Wollo Zone'
],[
'state_id' => 1225,
'name' => 'Robīt'
],[
'state_id' => 1225,
'name' => 'South Gondar Zone'
],[
'state_id' => 1225,
'name' => 'South Wollo Zone'
],[
'state_id' => 1225,
'name' => 'Wag Hemra Zone'
],[
'state_id' => 1225,
'name' => 'Were Īlu'
],[
'state_id' => 1225,
'name' => 'Werota'
],[
'state_id' => 1225,
'name' => 'Ādīs Zemen'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
