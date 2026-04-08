<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState16CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 563,
'name' => 'Asenovgrad'
],[
'state_id' => 563,
'name' => 'Brezovo'
],[
'state_id' => 563,
'name' => 'Hisarya'
],[
'state_id' => 563,
'name' => 'Kalofer'
],[
'state_id' => 563,
'name' => 'Kaloyanovo'
],[
'state_id' => 563,
'name' => 'Karlovo'
],[
'state_id' => 563,
'name' => 'Klisura'
],[
'state_id' => 563,
'name' => 'Krichim'
],[
'state_id' => 563,
'name' => 'Laki'
],[
'state_id' => 563,
'name' => 'Obshtina Asenovgrad'
],[
'state_id' => 563,
'name' => 'Obshtina Hisarya'
],[
'state_id' => 563,
'name' => 'Obshtina Kaloyanovo'
],[
'state_id' => 563,
'name' => 'Obshtina Karlovo'
],[
'state_id' => 563,
'name' => 'Obshtina Krichim'
],[
'state_id' => 563,
'name' => 'Obshtina Kuklen'
],[
'state_id' => 563,
'name' => 'Obshtina Laki'
],[
'state_id' => 563,
'name' => 'Obshtina Maritsa'
],[
'state_id' => 563,
'name' => 'Obshtina Parvomay'
],[
'state_id' => 563,
'name' => 'Obshtina Perushtitsa'
],[
'state_id' => 563,
'name' => 'Obshtina Plovdiv'
],[
'state_id' => 563,
'name' => 'Obshtina Rakovski'
],[
'state_id' => 563,
'name' => 'Obshtina Rodopi'
],[
'state_id' => 563,
'name' => 'Obshtina Sadovo'
],[
'state_id' => 563,
'name' => 'Obshtina Saedinenie'
],[
'state_id' => 563,
'name' => 'Obshtina Sopot'
],[
'state_id' => 563,
'name' => 'Obshtina Stamboliyski'
],[
'state_id' => 563,
'name' => 'Parvomay'
],[
'state_id' => 563,
'name' => 'Perushtitsa'
],[
'state_id' => 563,
'name' => 'Plovdiv'
],[
'state_id' => 563,
'name' => 'Rakovski'
],[
'state_id' => 563,
'name' => 'Sadovo'
],[
'state_id' => 563,
'name' => 'Saedinenie'
],[
'state_id' => 563,
'name' => 'Stamboliyski'
],[
'state_id' => 563,
'name' => 'Topolovo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
