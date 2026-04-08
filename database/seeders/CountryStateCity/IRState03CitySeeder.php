<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState03CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1777,
'name' => 'Ahar'
],[
'state_id' => 1777,
'name' => 'Bonab'
],[
'state_id' => 1777,
'name' => 'Hashtrud'
],[
'state_id' => 1777,
'name' => 'Marand'
],[
'state_id' => 1777,
'name' => 'Sarab'
],[
'state_id' => 1777,
'name' => 'Bostanabad'
],[
'state_id' => 1777,
'name' => 'Charavimaq'
],[
'state_id' => 1777,
'name' => 'Heris'
],[
'state_id' => 1777,
'name' => 'Jolfa'
],[
'state_id' => 1777,
'name' => 'Khoda Afarin'
],[
'state_id' => 1777,
'name' => 'Malekan'
],[
'state_id' => 1777,
'name' => 'Maragheh'
],[
'state_id' => 1777,
'name' => 'Mianeh'
],[
'state_id' => 1777,
'name' => 'Osku'
],[
'state_id' => 1777,
'name' => 'Varzaqan'
],[
'state_id' => 1777,
'name' => 'Azarshahr'
],[
'state_id' => 1777,
'name' => 'Tabriz'
],[
'state_id' => 1777,
'name' => 'Ajabshir'
],[
'state_id' => 1777,
'name' => 'Teymourlou'
],[
'state_id' => 1777,
'name' => 'Gogan'
],[
'state_id' => 1777,
'name' => 'Mamaqan'
],[
'state_id' => 1777,
'name' => 'Ilkhichi'
],[
'state_id' => 1777,
'name' => 'Sahand'
],[
'state_id' => 1777,
'name' => 'Hurand'
],[
'state_id' => 1777,
'name' => 'Bostan Abad'
],[
'state_id' => 1777,
'name' => 'Tekmeh Dash'
],[
'state_id' => 1777,
'name' => 'Basmenj'
],[
'state_id' => 1777,
'name' => 'Khosrowshah'
],[
'state_id' => 1777,
'name' => 'Sardroud'
],[
'state_id' => 1777,
'name' => 'Siahrood'
],[
'state_id' => 1777,
'name' => 'Hadishahr'
],[
'state_id' => 1777,
'name' => 'Qareh Aghaj'
],[
'state_id' => 1777,
'name' => 'Khomarlu'
],[
'state_id' => 1777,
'name' => 'Duzduzan'
],[
'state_id' => 1777,
'name' => 'Sharabian'
],[
'state_id' => 1777,
'name' => 'Mehraban'
],[
'state_id' => 1777,
'name' => 'Tasuj'
],[
'state_id' => 1777,
'name' => 'Khamaneh'
],[
'state_id' => 1777,
'name' => 'Sis'
],[
'state_id' => 1777,
'name' => 'Shabestar'
],[
'state_id' => 1777,
'name' => 'Sharafkhaneh'
],[
'state_id' => 1777,
'name' => 'Shendabad'
],[
'state_id' => 1777,
'name' => 'Soufian'
],[
'state_id' => 1777,
'name' => 'Koozehkonan'
],[
'state_id' => 1777,
'name' => 'Vaighan'
],[
'state_id' => 1777,
'name' => 'Javan Qala'
],[
'state_id' => 1777,
'name' => 'Abeshahmad'
],[
'state_id' => 1777,
'name' => 'Kaleybar'
],[
'state_id' => 1777,
'name' => 'Kharajoo'
],[
'state_id' => 1777,
'name' => 'Benab e Marand'
],[
'state_id' => 1777,
'name' => 'Zonouz'
],[
'state_id' => 1777,
'name' => 'Koshksaray'
],[
'state_id' => 1777,
'name' => 'Yamchi'
],[
'state_id' => 1777,
'name' => 'Leilan'
],[
'state_id' => 1777,
'name' => 'Mobarak Abad'
],[
'state_id' => 1777,
'name' => 'Aqkend'
],[
'state_id' => 1777,
'name' => 'Achachi'
],[
'state_id' => 1777,
'name' => 'Tark'
],[
'state_id' => 1777,
'name' => 'Turkman Chay'
],[
'state_id' => 1777,
'name' => 'Kharvana'
],[
'state_id' => 1777,
'name' => 'Varzeqān'
],[
'state_id' => 1777,
'name' => 'Bakhshāyesh'
],[
'state_id' => 1777,
'name' => 'Khaje'
],[
'state_id' => 1777,
'name' => 'Zarnaq'
],[
'state_id' => 1777,
'name' => 'Kelvanaq'
],[
'state_id' => 1777,
'name' => 'Nazarkahrizi'
],[
'state_id' => 1777,
'name' => 'Hashtrood'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
