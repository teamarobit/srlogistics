<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState21CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 661,
'name' => 'Krŏng Doun Kaev'
],[
'state_id' => 661,
'name' => 'Phumĭ Véal Srê'
],[
'state_id' => 661,
'name' => 'Srŏk Borei Cholsar'
],[
'state_id' => 661,
'name' => 'Srŏk Ângkôr Borei'
],[
'state_id' => 661,
'name' => 'Takeo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
