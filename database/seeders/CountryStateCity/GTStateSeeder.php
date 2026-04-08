<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class GTStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 90,
'name' => 'Quiché Department',
'iso2' => 'QC'
],[
'country_id' => 90,
'name' => 'Jalapa Department',
'iso2' => 'JA'
],[
'country_id' => 90,
'name' => 'Izabal Department',
'iso2' => 'IZ'
],[
'country_id' => 90,
'name' => 'Suchitepéquez Department',
'iso2' => 'SU'
],[
'country_id' => 90,
'name' => 'Sololá Department',
'iso2' => 'SO'
],[
'country_id' => 90,
'name' => 'El Progreso Department',
'iso2' => 'PR'
],[
'country_id' => 90,
'name' => 'Totonicapán Department',
'iso2' => 'TO'
],[
'country_id' => 90,
'name' => 'Retalhuleu Department',
'iso2' => 'RE'
],[
'country_id' => 90,
'name' => 'Santa Rosa Department',
'iso2' => 'SR'
],[
'country_id' => 90,
'name' => 'Chiquimula Department',
'iso2' => 'CQ'
],[
'country_id' => 90,
'name' => 'San Marcos Department',
'iso2' => 'SM'
],[
'country_id' => 90,
'name' => 'Quetzaltenango Department',
'iso2' => 'QZ'
],[
'country_id' => 90,
'name' => 'Petén Department',
'iso2' => 'PE'
],[
'country_id' => 90,
'name' => 'Huehuetenango Department',
'iso2' => 'HU'
],[
'country_id' => 90,
'name' => 'Alta Verapaz Department',
'iso2' => 'AV'
],[
'country_id' => 90,
'name' => 'Guatemala Department',
'iso2' => 'GU'
],[
'country_id' => 90,
'name' => 'Jutiapa Department',
'iso2' => 'JU'
],[
'country_id' => 90,
'name' => 'Baja Verapaz Department',
'iso2' => 'BV'
],[
'country_id' => 90,
'name' => 'Chimaltenango Department',
'iso2' => 'CM'
],[
'country_id' => 90,
'name' => 'Sacatepéquez Department',
'iso2' => 'SA'
],[
'country_id' => 90,
'name' => 'Escuintla Department',
'iso2' => 'ES'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
