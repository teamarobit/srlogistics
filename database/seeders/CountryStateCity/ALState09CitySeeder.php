<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ALState09CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 51,
'name' => 'Bashkia Bulqizë'
],[
'state_id' => 51,
'name' => 'Bashkia Klos'
],[
'state_id' => 51,
'name' => 'Bashkia Mat'
],[
'state_id' => 51,
'name' => 'Bulqizë'
],[
'state_id' => 51,
'name' => 'Burrel'
],[
'state_id' => 51,
'name' => 'Klos'
],[
'state_id' => 51,
'name' => 'Peshkopi'
],[
'state_id' => 51,
'name' => 'Rrethi i Bulqizës'
],[
'state_id' => 51,
'name' => 'Rrethi i Dibrës'
],[
'state_id' => 51,
'name' => 'Rrethi i Matit'
],[
'state_id' => 51,
'name' => 'Ulëz'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
