<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BWStateCECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 521,
'name' => 'Gobojango'
],[
'state_id' => 521,
'name' => 'Gweta'
],[
'state_id' => 521,
'name' => 'Kalamare'
],[
'state_id' => 521,
'name' => 'Letlhakane'
],[
'state_id' => 521,
'name' => 'Letsheng'
],[
'state_id' => 521,
'name' => 'Maapi'
],[
'state_id' => 521,
'name' => 'Machaneng'
],[
'state_id' => 521,
'name' => 'Mahalapye'
],[
'state_id' => 521,
'name' => 'Makobeng'
],[
'state_id' => 521,
'name' => 'Makwata'
],[
'state_id' => 521,
'name' => 'Mathakola'
],[
'state_id' => 521,
'name' => 'Mathambgwane'
],[
'state_id' => 521,
'name' => 'Mathathane'
],[
'state_id' => 521,
'name' => 'Maunatlala'
],[
'state_id' => 521,
'name' => 'Mogapi'
],[
'state_id' => 521,
'name' => 'Moijabana'
],[
'state_id' => 521,
'name' => 'Mookane'
],[
'state_id' => 521,
'name' => 'Mopipi'
],[
'state_id' => 521,
'name' => 'Mosetse'
],[
'state_id' => 521,
'name' => 'Nata'
],[
'state_id' => 521,
'name' => 'Orapa'
],[
'state_id' => 521,
'name' => 'Palapye'
],[
'state_id' => 521,
'name' => 'Pilikwe'
],[
'state_id' => 521,
'name' => 'Rakops'
],[
'state_id' => 521,
'name' => 'Ramokgonami'
],[
'state_id' => 521,
'name' => 'Ratholo'
],[
'state_id' => 521,
'name' => 'Sefophe'
],[
'state_id' => 521,
'name' => 'Serowe'
],[
'state_id' => 521,
'name' => 'Sua'
],[
'state_id' => 521,
'name' => 'Tamasane'
],[
'state_id' => 521,
'name' => 'Tobane'
],[
'state_id' => 521,
'name' => 'Tonota'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
