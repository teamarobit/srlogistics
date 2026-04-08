<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class NIStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 159,
'name' => 'Chontales',
'iso2' => 'CO'
],[
'country_id' => 159,
'name' => 'Managua',
'iso2' => 'MN'
],[
'country_id' => 159,
'name' => 'Rivas',
'iso2' => 'RI'
],[
'country_id' => 159,
'name' => 'Granada',
'iso2' => 'GR'
],[
'country_id' => 159,
'name' => 'León',
'iso2' => 'LE'
],[
'country_id' => 159,
'name' => 'Estelí',
'iso2' => 'ES'
],[
'country_id' => 159,
'name' => 'Boaco',
'iso2' => 'BO'
],[
'country_id' => 159,
'name' => 'Matagalpa',
'iso2' => 'MT'
],[
'country_id' => 159,
'name' => 'Madriz',
'iso2' => 'MD'
],[
'country_id' => 159,
'name' => 'Río San Juan',
'iso2' => 'SJ'
],[
'country_id' => 159,
'name' => 'Carazo',
'iso2' => 'CA'
],[
'country_id' => 159,
'name' => 'North Caribbean Coast',
'iso2' => 'AN'
],[
'country_id' => 159,
'name' => 'South Caribbean Coast',
'iso2' => 'AS'
],[
'country_id' => 159,
'name' => 'Masaya',
'iso2' => 'MS'
],[
'country_id' => 159,
'name' => 'Chinandega',
'iso2' => 'CI'
],[
'country_id' => 159,
'name' => 'Jinotega',
'iso2' => 'JI'
],[
'country_id' => 159,
'name' => 'Nueva Segovia',
'iso2' => 'NS'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
