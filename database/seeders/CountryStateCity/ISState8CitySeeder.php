<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ISState8CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1675,
'name' => 'Bláskógabyggð'
],[
'state_id' => 1675,
'name' => 'Flóahreppur'
],[
'state_id' => 1675,
'name' => 'Grímsnes- og Grafningshreppur'
],[
'state_id' => 1675,
'name' => 'Hrunamannahreppur'
],[
'state_id' => 1675,
'name' => 'Hveragerði'
],[
'state_id' => 1675,
'name' => 'Mýrdalshreppur'
],[
'state_id' => 1675,
'name' => 'Selfoss'
],[
'state_id' => 1675,
'name' => 'Skaftárhreppur'
],[
'state_id' => 1675,
'name' => 'Skeiða- og Gnúpverjahreppur'
],[
'state_id' => 1675,
'name' => 'Vestmannaeyjabær'
],[
'state_id' => 1675,
'name' => 'Vestmannaeyjar'
],[
'state_id' => 1675,
'name' => 'Ásahreppur'
],[
'state_id' => 1675,
'name' => 'Þorlákshöfn'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
