<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TLStateDICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1126,
'name' => 'Atauro Island'
],[
'state_id' => 1126,
'name' => 'Cristo Rei'
],[
'state_id' => 1126,
'name' => 'Dili'
],[
'state_id' => 1126,
'name' => 'Metinaro'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
