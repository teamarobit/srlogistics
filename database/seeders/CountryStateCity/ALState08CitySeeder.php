<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ALState08CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 50,
'name' => 'Bashkia Kurbin'
],[
'state_id' => 50,
'name' => 'Bashkia Lezhë'
],[
'state_id' => 50,
'name' => 'Bashkia Mirditë'
],[
'state_id' => 50,
'name' => 'Kurbnesh'
],[
'state_id' => 50,
'name' => 'Laç'
],[
'state_id' => 50,
'name' => 'Lezhë'
],[
'state_id' => 50,
'name' => 'Mamurras'
],[
'state_id' => 50,
'name' => 'Milot'
],[
'state_id' => 50,
'name' => 'Rrethi i Kurbinit'
],[
'state_id' => 50,
'name' => 'Rrëshen'
],[
'state_id' => 50,
'name' => 'Rubik'
],[
'state_id' => 50,
'name' => 'Shëngjin'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
