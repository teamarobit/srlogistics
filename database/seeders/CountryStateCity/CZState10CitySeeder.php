<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CZState10CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1018,
'name' => 'Braník'
],[
'state_id' => 1018,
'name' => 'Dolní Počernice'
],[
'state_id' => 1018,
'name' => 'Hodkovičky'
],[
'state_id' => 1018,
'name' => 'Horní Počernice'
],[
'state_id' => 1018,
'name' => 'Hostavice'
],[
'state_id' => 1018,
'name' => 'Karlín'
],[
'state_id' => 1018,
'name' => 'Kbely'
],[
'state_id' => 1018,
'name' => 'Letňany'
],[
'state_id' => 1018,
'name' => 'Libeň'
],[
'state_id' => 1018,
'name' => 'Malá Strana'
],[
'state_id' => 1018,
'name' => 'Modřany'
],[
'state_id' => 1018,
'name' => 'Prague'
],[
'state_id' => 1018,
'name' => 'Praha 1'
],[
'state_id' => 1018,
'name' => 'Praha 16'
],[
'state_id' => 1018,
'name' => 'Praha 20'
],[
'state_id' => 1018,
'name' => 'Praha 21'
],[
'state_id' => 1018,
'name' => 'Prosek'
],[
'state_id' => 1018,
'name' => 'Satalice'
],[
'state_id' => 1018,
'name' => 'Staré Město'
],[
'state_id' => 1018,
'name' => 'Střížkov'
],[
'state_id' => 1018,
'name' => 'Vysehrad'
],[
'state_id' => 1018,
'name' => 'Vysočany'
],[
'state_id' => 1018,
'name' => 'Černý Most'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
