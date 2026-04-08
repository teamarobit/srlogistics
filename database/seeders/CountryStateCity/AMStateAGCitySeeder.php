<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AMStateAGCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 195,
'name' => 'Agarakavan'
],[
'state_id' => 195,
'name' => 'Aparan'
],[
'state_id' => 195,
'name' => 'Aragats'
],[
'state_id' => 195,
'name' => 'Arteni'
],[
'state_id' => 195,
'name' => 'Ashnak'
],[
'state_id' => 195,
'name' => 'Ashtarak'
],[
'state_id' => 195,
'name' => 'Byurakan'
],[
'state_id' => 195,
'name' => 'Hnaberd'
],[
'state_id' => 195,
'name' => 'Karbi'
],[
'state_id' => 195,
'name' => 'Kasakh'
],[
'state_id' => 195,
'name' => 'Kosh'
],[
'state_id' => 195,
'name' => 'Nor Yerznka'
],[
'state_id' => 195,
'name' => 'Oshakan'
],[
'state_id' => 195,
'name' => 'Sasunik'
],[
'state_id' => 195,
'name' => 'Shenavan'
],[
'state_id' => 195,
'name' => 'Tsaghkahovit'
],[
'state_id' => 195,
'name' => 'T’alin'
],[
'state_id' => 195,
'name' => 'Ushi'
],[
'state_id' => 195,
'name' => 'Voskevaz'
],[
'state_id' => 195,
'name' => 'Zovuni'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
