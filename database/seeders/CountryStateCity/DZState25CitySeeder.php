<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState25CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 104,
'name' => 'Aïn Smara'
],[
'state_id' => 104,
'name' => 'Constantine'
],[
'state_id' => 104,
'name' => 'Didouche Mourad'
],[
'state_id' => 104,
'name' => 'El Khroub'
],[
'state_id' => 104,
'name' => 'Hamma Bouziane'
],[
'state_id' => 104,
'name' => '’Aïn Abid'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
