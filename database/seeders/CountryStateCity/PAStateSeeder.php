<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class PAStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 170,
'name' => 'Darién Province',
'iso2' => '5'
],[
'country_id' => 170,
'name' => 'Colón Province',
'iso2' => '3'
],[
'country_id' => 170,
'name' => 'Coclé Province',
'iso2' => '2'
],[
'country_id' => 170,
'name' => 'Guna Yala',
'iso2' => 'KY'
],[
'country_id' => 170,
'name' => 'Herrera Province',
'iso2' => '6'
],[
'country_id' => 170,
'name' => 'Los Santos Province',
'iso2' => '7'
],[
'country_id' => 170,
'name' => 'Ngöbe-Buglé Comarca',
'iso2' => 'NB'
],[
'country_id' => 170,
'name' => 'Veraguas Province',
'iso2' => '9'
],[
'country_id' => 170,
'name' => 'Bocas del Toro Province',
'iso2' => '1'
],[
'country_id' => 170,
'name' => 'Panamá Oeste Province',
'iso2' => '10'
],[
'country_id' => 170,
'name' => 'Panamá Province',
'iso2' => '8'
],[
'country_id' => 170,
'name' => 'Emberá-Wounaan Comarca',
'iso2' => 'EM'
],[
'country_id' => 170,
'name' => 'Chiriquí Province',
'iso2' => '4'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
