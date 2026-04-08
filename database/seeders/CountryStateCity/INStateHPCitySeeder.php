<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateHPCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1693,
'name' => 'Arki'
],[
'state_id' => 1693,
'name' => 'Baddi'
],[
'state_id' => 1693,
'name' => 'Banjar'
],[
'state_id' => 1693,
'name' => 'Bilaspur'
],[
'state_id' => 1693,
'name' => 'Chamba'
],[
'state_id' => 1693,
'name' => 'Chaupal'
],[
'state_id' => 1693,
'name' => 'Chowari'
],[
'state_id' => 1693,
'name' => 'Chuari Khas'
],[
'state_id' => 1693,
'name' => 'Dagshai'
],[
'state_id' => 1693,
'name' => 'Dalhousie'
],[
'state_id' => 1693,
'name' => 'Daulatpur'
],[
'state_id' => 1693,
'name' => 'Dera Gopipur'
],[
'state_id' => 1693,
'name' => 'Dharamsala'
],[
'state_id' => 1693,
'name' => 'Gagret'
],[
'state_id' => 1693,
'name' => 'Ghumarwin'
],[
'state_id' => 1693,
'name' => 'Hamirpur'
],[
'state_id' => 1693,
'name' => 'Jawala Mukhi'
],[
'state_id' => 1693,
'name' => 'Jogindarnagar'
],[
'state_id' => 1693,
'name' => 'Jubbal'
],[
'state_id' => 1693,
'name' => 'Jutogh'
],[
'state_id' => 1693,
'name' => 'Kasauli'
],[
'state_id' => 1693,
'name' => 'Kinnaur'
],[
'state_id' => 1693,
'name' => 'Kotkhai'
],[
'state_id' => 1693,
'name' => 'Kotla'
],[
'state_id' => 1693,
'name' => 'Kulu'
],[
'state_id' => 1693,
'name' => 'Kyelang'
],[
'state_id' => 1693,
'name' => 'Kalka'
],[
'state_id' => 1693,
'name' => 'Kangar'
],[
'state_id' => 1693,
'name' => 'Kangra'
],[
'state_id' => 1693,
'name' => 'Lahul and Spiti'
],[
'state_id' => 1693,
'name' => 'Mandi'
],[
'state_id' => 1693,
'name' => 'Manali'
],[
'state_id' => 1693,
'name' => 'Nagar'
],[
'state_id' => 1693,
'name' => 'Nagrota'
],[
'state_id' => 1693,
'name' => 'Nadaun'
],[
'state_id' => 1693,
'name' => 'Nahan'
],[
'state_id' => 1693,
'name' => 'Nalagarh'
],[
'state_id' => 1693,
'name' => 'Parwanoo'
],[
'state_id' => 1693,
'name' => 'Palampur'
],[
'state_id' => 1693,
'name' => 'Pandoh'
],[
'state_id' => 1693,
'name' => 'Paonta Sahib'
],[
'state_id' => 1693,
'name' => 'Rohru'
],[
'state_id' => 1693,
'name' => 'Rajgarh'
],[
'state_id' => 1693,
'name' => 'Rampur'
],[
'state_id' => 1693,
'name' => 'Sabathu'
],[
'state_id' => 1693,
'name' => 'Santokhgarh'
],[
'state_id' => 1693,
'name' => 'Sarka Ghat'
],[
'state_id' => 1693,
'name' => 'Sarahan'
],[
'state_id' => 1693,
'name' => 'Seoni'
],[
'state_id' => 1693,
'name' => 'Shimla'
],[
'state_id' => 1693,
'name' => 'Sirmaur'
],[
'state_id' => 1693,
'name' => 'Solan'
],[
'state_id' => 1693,
'name' => 'Sundarnagar'
],[
'state_id' => 1693,
'name' => 'Theog'
],[
'state_id' => 1693,
'name' => 'Tira Sujanpur'
],[
'state_id' => 1693,
'name' => 'Una'
],[
'state_id' => 1693,
'name' => 'Yol'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
