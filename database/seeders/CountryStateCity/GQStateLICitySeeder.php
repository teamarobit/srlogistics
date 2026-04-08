<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GQStateLICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1196,
'name' => 'Bata'
],[
'state_id' => 1196,
'name' => 'Bitica'
],[
'state_id' => 1196,
'name' => 'Cogo'
],[
'state_id' => 1196,
'name' => 'Machinda'
],[
'state_id' => 1196,
'name' => 'Mbini'
],[
'state_id' => 1196,
'name' => 'Río Campo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
