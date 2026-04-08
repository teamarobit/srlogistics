<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class GAStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 79,
'name' => 'Woleu-Ntem Province',
'iso2' => '9'
],[
'country_id' => 79,
'name' => 'Ogooué-Ivindo Province',
'iso2' => '6'
],[
'country_id' => 79,
'name' => 'Nyanga Province',
'iso2' => '5'
],[
'country_id' => 79,
'name' => 'Haut-Ogooué Province',
'iso2' => '2'
],[
'country_id' => 79,
'name' => 'Estuaire Province',
'iso2' => '1'
],[
'country_id' => 79,
'name' => 'Ogooué-Maritime Province',
'iso2' => '8'
],[
'country_id' => 79,
'name' => 'Ogooué-Lolo Province',
'iso2' => '7'
],[
'country_id' => 79,
'name' => 'Moyen-Ogooué Province',
'iso2' => '3'
],[
'country_id' => 79,
'name' => 'Ngounié Province',
'iso2' => '4'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
