<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class CDStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 51,
'name' => 'Tshuapa',
'iso2' => 'TU'
],[
'country_id' => 51,
'name' => 'Tanganyika',
'iso2' => 'TA'
],[
'country_id' => 51,
'name' => 'Haut-Uélé',
'iso2' => 'HU'
],[
'country_id' => 51,
'name' => 'Kasaï Oriental',
'iso2' => 'KE'
],[
'country_id' => 51,
'name' => 'Sud-Kivu',
'iso2' => 'SK'
],[
'country_id' => 51,
'name' => 'Nord-Ubangi',
'iso2' => 'NU'
],[
'country_id' => 51,
'name' => 'Kwango',
'iso2' => 'KG'
],[
'country_id' => 51,
'name' => 'Kinshasa',
'iso2' => 'KN'
],[
'country_id' => 51,
'name' => 'Kasaï Central',
'iso2' => 'KC'
],[
'country_id' => 51,
'name' => 'Sankuru',
'iso2' => 'SA'
],[
'country_id' => 51,
'name' => 'Équateur',
'iso2' => 'EQ'
],[
'country_id' => 51,
'name' => 'Maniema',
'iso2' => 'MA'
],[
'country_id' => 51,
'name' => 'Kongo Central',
'iso2' => 'BC'
],[
'country_id' => 51,
'name' => 'Lomami',
'iso2' => 'LO'
],[
'country_id' => 51,
'name' => 'Sud-Ubangi',
'iso2' => 'SU'
],[
'country_id' => 51,
'name' => 'Nord-Kivu',
'iso2' => 'NK'
],[
'country_id' => 51,
'name' => 'Haut-Katanga',
'iso2' => 'HK'
],[
'country_id' => 51,
'name' => 'Ituri',
'iso2' => 'IT'
],[
'country_id' => 51,
'name' => 'Mongala',
'iso2' => 'MO'
],[
'country_id' => 51,
'name' => 'Bas-Uélé',
'iso2' => 'BU'
],[
'country_id' => 51,
'name' => 'Mai-Ndombe',
'iso2' => 'MN'
],[
'country_id' => 51,
'name' => 'Tshopo',
'iso2' => 'TO'
],[
'country_id' => 51,
'name' => 'Kasaï',
'iso2' => 'KS'
],[
'country_id' => 51,
'name' => 'Haut-Lomami',
'iso2' => 'HL'
],[
'country_id' => 51,
'name' => 'Kwilu',
'iso2' => 'KL'
],[
'country_id' => 51,
'name' => 'Lualaba',
'iso2' => 'LU'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
