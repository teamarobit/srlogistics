<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState13CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 574,
'name' => 'Batak'
],[
'state_id' => 574,
'name' => 'Belovo'
],[
'state_id' => 574,
'name' => 'Bratsigovo'
],[
'state_id' => 574,
'name' => 'Lesichovo'
],[
'state_id' => 574,
'name' => 'Obshtina Batak'
],[
'state_id' => 574,
'name' => 'Obshtina Belovo'
],[
'state_id' => 574,
'name' => 'Obshtina Bratsigovo'
],[
'state_id' => 574,
'name' => 'Obshtina Lesichovo'
],[
'state_id' => 574,
'name' => 'Obshtina Panagyurishte'
],[
'state_id' => 574,
'name' => 'Obshtina Pazardzhik'
],[
'state_id' => 574,
'name' => 'Obshtina Peshtera'
],[
'state_id' => 574,
'name' => 'Obshtina Rakitovo'
],[
'state_id' => 574,
'name' => 'Obshtina Septemvri'
],[
'state_id' => 574,
'name' => 'Obshtina Strelcha'
],[
'state_id' => 574,
'name' => 'Obshtina Velingrad'
],[
'state_id' => 574,
'name' => 'Panagyurishte'
],[
'state_id' => 574,
'name' => 'Pazardzhik'
],[
'state_id' => 574,
'name' => 'Peshtera'
],[
'state_id' => 574,
'name' => 'Rakitovo'
],[
'state_id' => 574,
'name' => 'Sarnitsa'
],[
'state_id' => 574,
'name' => 'Sarnitsa Obshtina'
],[
'state_id' => 574,
'name' => 'Septemvri'
],[
'state_id' => 574,
'name' => 'Strelcha'
],[
'state_id' => 574,
'name' => 'Velingrad'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
