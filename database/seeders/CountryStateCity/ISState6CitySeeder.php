<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ISState6CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1678,
'name' => 'Akureyri'
],[
'state_id' => 1678,
'name' => 'Dalvík'
],[
'state_id' => 1678,
'name' => 'Dalvíkurbyggð'
],[
'state_id' => 1678,
'name' => 'Eyjafjarðarsveit'
],[
'state_id' => 1678,
'name' => 'Fjallabyggð'
],[
'state_id' => 1678,
'name' => 'Grýtubakkahreppur'
],[
'state_id' => 1678,
'name' => 'Hörgársveit'
],[
'state_id' => 1678,
'name' => 'Húsavík'
],[
'state_id' => 1678,
'name' => 'Langanesbyggð'
],[
'state_id' => 1678,
'name' => 'Laugar'
],[
'state_id' => 1678,
'name' => 'Siglufjörður'
],[
'state_id' => 1678,
'name' => 'Skútustaðahreppur'
],[
'state_id' => 1678,
'name' => 'Svalbarðsstrandarhreppur'
],[
'state_id' => 1678,
'name' => 'Tjörneshreppur'
],[
'state_id' => 1678,
'name' => 'Þingeyjarsveit'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
