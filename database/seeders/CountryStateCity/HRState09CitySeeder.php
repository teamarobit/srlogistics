<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState09CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 938,
'name' => 'Brinje'
],[
'state_id' => 938,
'name' => 'Gospić'
],[
'state_id' => 938,
'name' => 'Karlobag'
],[
'state_id' => 938,
'name' => 'Lički Osik'
],[
'state_id' => 938,
'name' => 'Novalja'
],[
'state_id' => 938,
'name' => 'Otočac'
],[
'state_id' => 938,
'name' => 'Perušić'
],[
'state_id' => 938,
'name' => 'Plitvička Jezera'
],[
'state_id' => 938,
'name' => 'Popovača'
],[
'state_id' => 938,
'name' => 'Senj'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
