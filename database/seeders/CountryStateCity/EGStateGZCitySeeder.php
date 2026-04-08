<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateGZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1169,
'name' => 'Al Bawīţī'
],[
'state_id' => 1169,
'name' => 'Al Ḩawāmidīyah'
],[
'state_id' => 1169,
'name' => 'Al ‘Ayyāţ'
],[
'state_id' => 1169,
'name' => 'Awsīm'
],[
'state_id' => 1169,
'name' => 'Aş Şaff'
],[
'state_id' => 1169,
'name' => 'Giza'
],[
'state_id' => 1169,
'name' => 'Madīnat Sittah Uktūbar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
