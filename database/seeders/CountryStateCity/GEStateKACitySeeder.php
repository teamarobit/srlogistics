<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GEStateKACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1423,
'name' => 'Akhmet’a'
],[
'state_id' => 1423,
'name' => 'Akhmet’is Munitsip’alit’et’i'
],[
'state_id' => 1423,
'name' => 'Gurjaani'
],[
'state_id' => 1423,
'name' => 'Lagodekhi'
],[
'state_id' => 1423,
'name' => 'Qvareli'
],[
'state_id' => 1423,
'name' => 'Sagarejo'
],[
'state_id' => 1423,
'name' => 'Sighnaghi'
],[
'state_id' => 1423,
'name' => 'Sighnaghis Munitsip’alit’et’i'
],[
'state_id' => 1423,
'name' => 'Telavi'
],[
'state_id' => 1423,
'name' => 'Tsinandali'
],[
'state_id' => 1423,
'name' => 'Tsnori'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
