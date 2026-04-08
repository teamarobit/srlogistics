<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class TNStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 224,
'name' => 'Ariana',
'iso2' => '12'
],[
'country_id' => 224,
'name' => 'Bizerte',
'iso2' => '23'
],[
'country_id' => 224,
'name' => 'Jendouba',
'iso2' => '32'
],[
'country_id' => 224,
'name' => 'Monastir',
'iso2' => '52'
],[
'country_id' => 224,
'name' => 'Tunis',
'iso2' => '11'
],[
'country_id' => 224,
'name' => 'Manouba',
'iso2' => '14'
],[
'country_id' => 224,
'name' => 'Gafsa',
'iso2' => '71'
],[
'country_id' => 224,
'name' => 'Sfax',
'iso2' => '61'
],[
'country_id' => 224,
'name' => 'Gabès',
'iso2' => '81'
],[
'country_id' => 224,
'name' => 'Tataouine',
'iso2' => '83'
],[
'country_id' => 224,
'name' => 'Medenine',
'iso2' => '82'
],[
'country_id' => 224,
'name' => 'Kef',
'iso2' => '33'
],[
'country_id' => 224,
'name' => 'Kebili',
'iso2' => '73'
],[
'country_id' => 224,
'name' => 'Siliana',
'iso2' => '34'
],[
'country_id' => 224,
'name' => 'Kairouan',
'iso2' => '41'
],[
'country_id' => 224,
'name' => 'Zaghouan',
'iso2' => '22'
],[
'country_id' => 224,
'name' => 'Ben Arous',
'iso2' => '13'
],[
'country_id' => 224,
'name' => 'Sidi Bouzid',
'iso2' => '43'
],[
'country_id' => 224,
'name' => 'Mahdia',
'iso2' => '53'
],[
'country_id' => 224,
'name' => 'Tozeur',
'iso2' => '72'
],[
'country_id' => 224,
'name' => 'Kasserine',
'iso2' => '42'
],[
'country_id' => 224,
'name' => 'Sousse',
'iso2' => '51'
],[
'country_id' => 224,
'name' => 'Béja',
'iso2' => '31'
],[
'country_id' => 224,
'name' => 'Nabeul',
'iso2' => '21'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
