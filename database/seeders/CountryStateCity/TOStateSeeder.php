<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class TOStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 222,
'name' => 'Vavaʻu',
'iso2' => '05'
],[
'country_id' => 222,
'name' => 'Tongatapu',
'iso2' => '04'
],[
'country_id' => 222,
'name' => 'Haʻapai',
'iso2' => '02'
],[
'country_id' => 222,
'name' => 'Niuas',
'iso2' => '03'
],[
'country_id' => 222,
'name' => 'ʻEua',
'iso2' => '01'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
