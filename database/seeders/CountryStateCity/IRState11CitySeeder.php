<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState11CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1764,
'name' => 'Chabahar'
],[
'state_id' => 1764,
'name' => 'Fanuj'
],[
'state_id' => 1764,
'name' => 'Hamoon'
],[
'state_id' => 1764,
'name' => 'Iranshahr'
],[
'state_id' => 1764,
'name' => 'Khash'
],[
'state_id' => 1764,
'name' => 'Mirjaveh'
],[
'state_id' => 1764,
'name' => 'Nimruz'
],[
'state_id' => 1764,
'name' => 'Nosratabad'
],[
'state_id' => 1764,
'name' => 'Nikshahr'
],[
'state_id' => 1764,
'name' => 'Qasr-e-qand'
],[
'state_id' => 1764,
'name' => 'Dalgan'
],[
'state_id' => 1764,
'name' => 'Hirmand'
],[
'state_id' => 1764,
'name' => 'Konarak'
],[
'state_id' => 1764,
'name' => 'Mehrestan'
],[
'state_id' => 1764,
'name' => 'Sarbaz'
],[
'state_id' => 1764,
'name' => 'Saravan'
],[
'state_id' => 1764,
'name' => 'Sib va Suran'
],[
'state_id' => 1764,
'name' => 'Zahedan'
],[
'state_id' => 1764,
'name' => 'Zehak'
],[
'state_id' => 1764,
'name' => 'Zabol'
],[
'state_id' => 1764,
'name' => 'Bazmān'
],[
'state_id' => 1764,
'name' => 'Bampour'
],[
'state_id' => 1764,
'name' => 'Mohamadan'
],[
'state_id' => 1764,
'name' => 'Negour'
],[
'state_id' => 1764,
'name' => 'Noukābād'
],[
'state_id' => 1764,
'name' => 'Golmorti'
],[
'state_id' => 1764,
'name' => 'Bonjār'
],[
'state_id' => 1764,
'name' => 'Nosrat Abad'
],[
'state_id' => 1764,
'name' => 'Zahak'
],[
'state_id' => 1764,
'name' => 'Jālq'
],[
'state_id' => 1764,
'name' => 'Sirkān'
],[
'state_id' => 1764,
'name' => 'Gosht'
],[
'state_id' => 1764,
'name' => 'Mohammadi'
],[
'state_id' => 1764,
'name' => 'Pishin'
],[
'state_id' => 1764,
'name' => 'Rāsk'
],[
'state_id' => 1764,
'name' => 'Suran'
],[
'state_id' => 1764,
'name' => 'Hidouj'
],[
'state_id' => 1764,
'name' => 'Fanouj'
],[
'state_id' => 1764,
'name' => 'Zarābād'
],[
'state_id' => 1764,
'name' => 'Zaboli'
],[
'state_id' => 1764,
'name' => 'Espakeh'
],[
'state_id' => 1764,
'name' => 'Bent'
],[
'state_id' => 1764,
'name' => 'Adimi'
],[
'state_id' => 1764,
'name' => 'Mohammadābād'
],[
'state_id' => 1764,
'name' => 'Dust Mohammad'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
