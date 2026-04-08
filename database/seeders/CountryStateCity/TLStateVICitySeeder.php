<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TLStateVICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1116,
'name' => 'Lacluta'
],[
'state_id' => 1116,
'name' => 'Ossu'
],[
'state_id' => 1116,
'name' => 'Uatocarabau'
],[
'state_id' => 1116,
'name' => 'Uatolari'
],[
'state_id' => 1116,
'name' => 'Viqueque'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
