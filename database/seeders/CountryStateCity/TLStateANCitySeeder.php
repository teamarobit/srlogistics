<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TLStateANCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1120,
'name' => 'Ainaro'
],[
'state_id' => 1120,
'name' => 'Hato-Udo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
