<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateSOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1636,
'name' => 'Babócsa'
],[
'state_id' => 1636,
'name' => 'Balatonberény'
],[
'state_id' => 1636,
'name' => 'Balatonboglár'
],[
'state_id' => 1636,
'name' => 'Balatonfenyves'
],[
'state_id' => 1636,
'name' => 'Balatonföldvár'
],[
'state_id' => 1636,
'name' => 'Balatonlelle'
],[
'state_id' => 1636,
'name' => 'Balatonszabadi'
],[
'state_id' => 1636,
'name' => 'Balatonszárszó'
],[
'state_id' => 1636,
'name' => 'Barcs'
],[
'state_id' => 1636,
'name' => 'Barcsi Járás'
],[
'state_id' => 1636,
'name' => 'Berzence'
],[
'state_id' => 1636,
'name' => 'Böhönye'
],[
'state_id' => 1636,
'name' => 'Csurgó'
],[
'state_id' => 1636,
'name' => 'Csurgói Járás'
],[
'state_id' => 1636,
'name' => 'Fonyód'
],[
'state_id' => 1636,
'name' => 'Fonyódi Járás'
],[
'state_id' => 1636,
'name' => 'Kadarkút'
],[
'state_id' => 1636,
'name' => 'Kaposmérő'
],[
'state_id' => 1636,
'name' => 'Kaposvár'
],[
'state_id' => 1636,
'name' => 'Kaposvári Járás'
],[
'state_id' => 1636,
'name' => 'Karád'
],[
'state_id' => 1636,
'name' => 'Kéthely'
],[
'state_id' => 1636,
'name' => 'Lengyeltóti'
],[
'state_id' => 1636,
'name' => 'Lábod'
],[
'state_id' => 1636,
'name' => 'Marcali'
],[
'state_id' => 1636,
'name' => 'Marcali Járás'
],[
'state_id' => 1636,
'name' => 'Nagyatád'
],[
'state_id' => 1636,
'name' => 'Nagyatádi Járás'
],[
'state_id' => 1636,
'name' => 'Nagybajom'
],[
'state_id' => 1636,
'name' => 'Segesd'
],[
'state_id' => 1636,
'name' => 'Siófok'
],[
'state_id' => 1636,
'name' => 'Siófoki Járás'
],[
'state_id' => 1636,
'name' => 'Somogyvár'
],[
'state_id' => 1636,
'name' => 'Tab'
],[
'state_id' => 1636,
'name' => 'Tabi Járás'
],[
'state_id' => 1636,
'name' => 'Taszár'
],[
'state_id' => 1636,
'name' => 'Zamárdi'
],[
'state_id' => 1636,
'name' => 'Ádánd'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
