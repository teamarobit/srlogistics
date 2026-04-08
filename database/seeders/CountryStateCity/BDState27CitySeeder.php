<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BDState27CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 406,
'name' => 'Bagerhat'
],[
'state_id' => 406,
'name' => 'Bherāmāra'
],[
'state_id' => 406,
'name' => 'Bhātpāra Abhaynagar'
],[
'state_id' => 406,
'name' => 'Chuadanga'
],[
'state_id' => 406,
'name' => 'Jessore'
],[
'state_id' => 406,
'name' => 'Jhenaidah'
],[
'state_id' => 406,
'name' => 'Jhingergācha'
],[
'state_id' => 406,
'name' => 'Kesabpur'
],[
'state_id' => 406,
'name' => 'Khulna'
],[
'state_id' => 406,
'name' => 'Kushtia'
],[
'state_id' => 406,
'name' => 'Kālia'
],[
'state_id' => 406,
'name' => 'Kālīganj'
],[
'state_id' => 406,
'name' => 'Magura'
],[
'state_id' => 406,
'name' => 'Meherpur'
],[
'state_id' => 406,
'name' => 'Morrelgonj'
],[
'state_id' => 406,
'name' => 'Narail'
],[
'state_id' => 406,
'name' => 'Nowlamary'
],[
'state_id' => 406,
'name' => 'Phultala'
],[
'state_id' => 406,
'name' => 'Sarankhola'
],[
'state_id' => 406,
'name' => 'Satkhira'
],[
'state_id' => 406,
'name' => 'Ujalpur'
],[
'state_id' => 406,
'name' => 'Uttar Char Fasson'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
