<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AMStateLOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 201,
'name' => 'Agarak'
],[
'state_id' => 201,
'name' => 'Akht’ala'
],[
'state_id' => 201,
'name' => 'Alaverdi'
],[
'state_id' => 201,
'name' => 'Arevashogh'
],[
'state_id' => 201,
'name' => 'Bazum'
],[
'state_id' => 201,
'name' => 'Chochkan'
],[
'state_id' => 201,
'name' => 'Darpas'
],[
'state_id' => 201,
'name' => 'Dsegh'
],[
'state_id' => 201,
'name' => 'Fioletovo'
],[
'state_id' => 201,
'name' => 'Gogaran'
],[
'state_id' => 201,
'name' => 'Gugark’'
],[
'state_id' => 201,
'name' => 'Gyulagarak'
],[
'state_id' => 201,
'name' => 'Jrashen'
],[
'state_id' => 201,
'name' => 'Lerrnants’k’'
],[
'state_id' => 201,
'name' => 'Lerrnapat'
],[
'state_id' => 201,
'name' => 'Lerrnavan'
],[
'state_id' => 201,
'name' => 'Lorut'
],[
'state_id' => 201,
'name' => 'Margahovit'
],[
'state_id' => 201,
'name' => 'Mets Parni'
],[
'state_id' => 201,
'name' => 'Metsavan'
],[
'state_id' => 201,
'name' => 'Norashen'
],[
'state_id' => 201,
'name' => 'Odzun'
],[
'state_id' => 201,
'name' => 'Sarahart’'
],[
'state_id' => 201,
'name' => 'Saramej'
],[
'state_id' => 201,
'name' => 'Shahumyan'
],[
'state_id' => 201,
'name' => 'Shirakamut'
],[
'state_id' => 201,
'name' => 'Shnogh'
],[
'state_id' => 201,
'name' => 'Spitak'
],[
'state_id' => 201,
'name' => 'Step’anavan'
],[
'state_id' => 201,
'name' => 'Tashir'
],[
'state_id' => 201,
'name' => 'Tsaghkaber'
],[
'state_id' => 201,
'name' => 'Urrut'
],[
'state_id' => 201,
'name' => 'Vahagni'
],[
'state_id' => 201,
'name' => 'Vanadzor'
],[
'state_id' => 201,
'name' => 'Vardablur'
],[
'state_id' => 201,
'name' => 'Yeghegnut'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
