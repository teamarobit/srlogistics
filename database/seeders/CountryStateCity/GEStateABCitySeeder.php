<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GEStateABCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1414,
'name' => 'Bich’vinta'
],[
'state_id' => 1414,
'name' => 'Dranda'
],[
'state_id' => 1414,
'name' => 'Gagra'
],[
'state_id' => 1414,
'name' => 'Gali'
],[
'state_id' => 1414,
'name' => 'Gantiadi'
],[
'state_id' => 1414,
'name' => 'Gudauta'
],[
'state_id' => 1414,
'name' => 'Kelasuri'
],[
'state_id' => 1414,
'name' => 'Och’amch’ire'
],[
'state_id' => 1414,
'name' => 'P’rimorsk’oe'
],[
'state_id' => 1414,
'name' => 'Sokhumi'
],[
'state_id' => 1414,
'name' => 'Stantsiya Novyy Afon'
],[
'state_id' => 1414,
'name' => 'Tqvarch\'eli'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
