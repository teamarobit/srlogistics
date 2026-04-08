<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CMStateLTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 689,
'name' => 'Bonabéri'
],[
'state_id' => 689,
'name' => 'Diang'
],[
'state_id' => 689,
'name' => 'Dibombari'
],[
'state_id' => 689,
'name' => 'Dizangué'
],[
'state_id' => 689,
'name' => 'Douala'
],[
'state_id' => 689,
'name' => 'Edéa'
],[
'state_id' => 689,
'name' => 'Loum'
],[
'state_id' => 689,
'name' => 'Manjo'
],[
'state_id' => 689,
'name' => 'Mbanga'
],[
'state_id' => 689,
'name' => 'Melong'
],[
'state_id' => 689,
'name' => 'Mouanko'
],[
'state_id' => 689,
'name' => 'Ndom'
],[
'state_id' => 689,
'name' => 'Ngambé'
],[
'state_id' => 689,
'name' => 'Nkongsamba'
],[
'state_id' => 689,
'name' => 'Penja'
],[
'state_id' => 689,
'name' => 'Yabassi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
