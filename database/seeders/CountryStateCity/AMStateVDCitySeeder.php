<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AMStateVDCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 197,
'name' => 'Agarakadzor'
],[
'state_id' => 197,
'name' => 'Aghavnadzor'
],[
'state_id' => 197,
'name' => 'Areni'
],[
'state_id' => 197,
'name' => 'Getap’'
],[
'state_id' => 197,
'name' => 'Gladzor'
],[
'state_id' => 197,
'name' => 'Jermuk'
],[
'state_id' => 197,
'name' => 'Malishka'
],[
'state_id' => 197,
'name' => 'Rrind'
],[
'state_id' => 197,
'name' => 'Shatin'
],[
'state_id' => 197,
'name' => 'Vayk’'
],[
'state_id' => 197,
'name' => 'Vernashen'
],[
'state_id' => 197,
'name' => 'Yeghegis'
],[
'state_id' => 197,
'name' => 'Yeghegnadzor'
],[
'state_id' => 197,
'name' => 'Zarrit’ap’'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
