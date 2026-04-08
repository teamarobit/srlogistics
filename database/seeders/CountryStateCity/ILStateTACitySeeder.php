<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ILStateTACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1832,
'name' => 'Azor'
],[
'state_id' => 1832,
'name' => 'Bat Yam'
],[
'state_id' => 1832,
'name' => 'Bnei Brak'
],[
'state_id' => 1832,
'name' => 'Giv\'at Shmuel'
],[
'state_id' => 1832,
'name' => 'Givatayim'
],[
'state_id' => 1832,
'name' => 'Herzliya'
],[
'state_id' => 1832,
'name' => 'Herzliya Pituah'
],[
'state_id' => 1832,
'name' => 'H̱olon'
],[
'state_id' => 1832,
'name' => 'Jaffa'
],[
'state_id' => 1832,
'name' => 'Kefar Shemaryahu'
],[
'state_id' => 1832,
'name' => 'Or Yehuda'
],[
'state_id' => 1832,
'name' => 'Ramat Gan'
],[
'state_id' => 1832,
'name' => 'Ramat HaSharon'
],[
'state_id' => 1832,
'name' => 'Tel Aviv'
],[
'state_id' => 1832,
'name' => 'Yehud-Monosson'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
