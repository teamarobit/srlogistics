<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState01CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 561,
'name' => 'Bansko'
],[
'state_id' => 561,
'name' => 'Belitsa'
],[
'state_id' => 561,
'name' => 'Blagoevgrad'
],[
'state_id' => 561,
'name' => 'Garmen'
],[
'state_id' => 561,
'name' => 'Gotse Delchev'
],[
'state_id' => 561,
'name' => 'Hadzhidimovo'
],[
'state_id' => 561,
'name' => 'Kolarovo'
],[
'state_id' => 561,
'name' => 'Kresna'
],[
'state_id' => 561,
'name' => 'Obshtina Bansko'
],[
'state_id' => 561,
'name' => 'Obshtina Belitsa'
],[
'state_id' => 561,
'name' => 'Obshtina Blagoevgrad'
],[
'state_id' => 561,
'name' => 'Obshtina Garmen'
],[
'state_id' => 561,
'name' => 'Obshtina Gotse Delchev'
],[
'state_id' => 561,
'name' => 'Obshtina Kresna'
],[
'state_id' => 561,
'name' => 'Obshtina Petrich'
],[
'state_id' => 561,
'name' => 'Obshtina Razlog'
],[
'state_id' => 561,
'name' => 'Obshtina Sandanski'
],[
'state_id' => 561,
'name' => 'Obshtina Satovcha'
],[
'state_id' => 561,
'name' => 'Obshtina Simitli'
],[
'state_id' => 561,
'name' => 'Obshtina Strumyani'
],[
'state_id' => 561,
'name' => 'Obshtina Yakoruda'
],[
'state_id' => 561,
'name' => 'Petrich'
],[
'state_id' => 561,
'name' => 'Razlog'
],[
'state_id' => 561,
'name' => 'Sandanski'
],[
'state_id' => 561,
'name' => 'Satovcha'
],[
'state_id' => 561,
'name' => 'Simitli'
],[
'state_id' => 561,
'name' => 'Stara Kresna'
],[
'state_id' => 561,
'name' => 'Strumyani'
],[
'state_id' => 561,
'name' => 'Yakoruda'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
