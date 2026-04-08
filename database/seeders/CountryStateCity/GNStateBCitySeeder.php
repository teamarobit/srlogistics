<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GNStateBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1526,
'name' => 'Boffa'
],[
'state_id' => 1526,
'name' => 'Boke Prefecture'
],[
'state_id' => 1526,
'name' => 'Boké'
],[
'state_id' => 1526,
'name' => 'Fria'
],[
'state_id' => 1526,
'name' => 'Gaoual'
],[
'state_id' => 1526,
'name' => 'Gaoual Prefecture'
],[
'state_id' => 1526,
'name' => 'Kimbo'
],[
'state_id' => 1526,
'name' => 'Koundara'
],[
'state_id' => 1526,
'name' => 'Koundara Prefecture'
],[
'state_id' => 1526,
'name' => 'Sanguéya'
],[
'state_id' => 1526,
'name' => 'Youkounkoun'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
