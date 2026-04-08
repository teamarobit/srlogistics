<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GHStateAACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1446,
'name' => 'Accra'
],[
'state_id' => 1446,
'name' => 'Atsiaman'
],[
'state_id' => 1446,
'name' => 'Dome'
],[
'state_id' => 1446,
'name' => 'Gbawe'
],[
'state_id' => 1446,
'name' => 'Medina Estates'
],[
'state_id' => 1446,
'name' => 'Nungua'
],[
'state_id' => 1446,
'name' => 'Tema'
],[
'state_id' => 1446,
'name' => 'Teshi Old Town'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
