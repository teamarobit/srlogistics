<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FJStateNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1239,
'name' => 'Bua Province'
],[
'state_id' => 1239,
'name' => 'Cakaudrove Province'
],[
'state_id' => 1239,
'name' => 'Labasa'
],[
'state_id' => 1239,
'name' => 'Macuata Province'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
