<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AMStateGRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 200,
'name' => 'Akunk’'
],[
'state_id' => 200,
'name' => 'Astghadzor'
],[
'state_id' => 200,
'name' => 'Chambarak'
],[
'state_id' => 200,
'name' => 'Ddmashen'
],[
'state_id' => 200,
'name' => 'Drakhtik'
],[
'state_id' => 200,
'name' => 'Dzoragyugh'
],[
'state_id' => 200,
'name' => 'Gagarin'
],[
'state_id' => 200,
'name' => 'Gandzak'
],[
'state_id' => 200,
'name' => 'Gavarr'
],[
'state_id' => 200,
'name' => 'Geghamasar'
],[
'state_id' => 200,
'name' => 'Geghamavan'
],[
'state_id' => 200,
'name' => 'Karanlukh'
],[
'state_id' => 200,
'name' => 'Karchaghbyur'
],[
'state_id' => 200,
'name' => 'Lanjaghbyur'
],[
'state_id' => 200,
'name' => 'Lchap’'
],[
'state_id' => 200,
'name' => 'Lchashen'
],[
'state_id' => 200,
'name' => 'Lichk’'
],[
'state_id' => 200,
'name' => 'Madina'
],[
'state_id' => 200,
'name' => 'Martuni'
],[
'state_id' => 200,
'name' => 'Mets Masrik'
],[
'state_id' => 200,
'name' => 'Nerk’in Getashen'
],[
'state_id' => 200,
'name' => 'Noratus'
],[
'state_id' => 200,
'name' => 'Sarukhan'
],[
'state_id' => 200,
'name' => 'Sevan'
],[
'state_id' => 200,
'name' => 'Tsovagyugh'
],[
'state_id' => 200,
'name' => 'Tsovak'
],[
'state_id' => 200,
'name' => 'Tsovasar'
],[
'state_id' => 200,
'name' => 'Tsovazard'
],[
'state_id' => 200,
'name' => 'Tsovinar'
],[
'state_id' => 200,
'name' => 'Vaghashen'
],[
'state_id' => 200,
'name' => 'Vahan'
],[
'state_id' => 200,
'name' => 'Vardenik'
],[
'state_id' => 200,
'name' => 'Vardenis'
],[
'state_id' => 200,
'name' => 'Varser'
],[
'state_id' => 200,
'name' => 'Verin Getashen'
],[
'state_id' => 200,
'name' => 'Yeranos'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
