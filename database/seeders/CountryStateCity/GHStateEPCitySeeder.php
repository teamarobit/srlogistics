<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GHStateEPCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1442,
'name' => 'Aburi'
],[
'state_id' => 1442,
'name' => 'Akim Oda'
],[
'state_id' => 1442,
'name' => 'Akim Swedru'
],[
'state_id' => 1442,
'name' => 'Akropong'
],[
'state_id' => 1442,
'name' => 'Akwatia'
],[
'state_id' => 1442,
'name' => 'Asamankese'
],[
'state_id' => 1442,
'name' => 'Begoro'
],[
'state_id' => 1442,
'name' => 'Kibi'
],[
'state_id' => 1442,
'name' => 'Koforidua'
],[
'state_id' => 1442,
'name' => 'Mpraeso'
],[
'state_id' => 1442,
'name' => 'Nsawam'
],[
'state_id' => 1442,
'name' => 'Suhum'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
