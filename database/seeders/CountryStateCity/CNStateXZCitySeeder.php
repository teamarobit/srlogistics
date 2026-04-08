<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateXZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 802,
'name' => 'Burang'
],[
'state_id' => 802,
'name' => 'Dêqên'
],[
'state_id' => 802,
'name' => 'Jiangzi'
],[
'state_id' => 802,
'name' => 'Lhasa'
],[
'state_id' => 802,
'name' => 'Nagqu'
],[
'state_id' => 802,
'name' => 'Nagqu Diqu'
],[
'state_id' => 802,
'name' => 'Ngari Diqu'
],[
'state_id' => 802,
'name' => 'Nyingchi Prefecture'
],[
'state_id' => 802,
'name' => 'Qamdo'
],[
'state_id' => 802,
'name' => 'Qamdo Shi'
],[
'state_id' => 802,
'name' => 'Rikaze'
],[
'state_id' => 802,
'name' => 'Saga'
],[
'state_id' => 802,
'name' => 'Shannan Diqu'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
