<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateCTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1712,
'name' => 'Akaltara'
],[
'state_id' => 1712,
'name' => 'Ambikapur'
],[
'state_id' => 1712,
'name' => 'Ambagarh Chauki'
],[
'state_id' => 1712,
'name' => 'Arang'
],[
'state_id' => 1712,
'name' => 'Baikunthpur'
],[
'state_id' => 1712,
'name' => 'Balod'
],[
'state_id' => 1712,
'name' => 'Baloda'
],[
'state_id' => 1712,
'name' => 'Baloda Bazar'
],[
'state_id' => 1712,
'name' => 'Basna'
],[
'state_id' => 1712,
'name' => 'Bastar'
],[
'state_id' => 1712,
'name' => 'Bemetara'
],[
'state_id' => 1712,
'name' => 'Bhatgaon'
],[
'state_id' => 1712,
'name' => 'Bhilai'
],[
'state_id' => 1712,
'name' => 'Bhanpuri'
],[
'state_id' => 1712,
'name' => 'Bhatapara'
],[
'state_id' => 1712,
'name' => 'Bijapur'
],[
'state_id' => 1712,
'name' => 'Bilaspur'
],[
'state_id' => 1712,
'name' => 'Chhuikhadan'
],[
'state_id' => 1712,
'name' => 'Champa'
],[
'state_id' => 1712,
'name' => 'Deori'
],[
'state_id' => 1712,
'name' => 'Dhamtari'
],[
'state_id' => 1712,
'name' => 'Dongargaon'
],[
'state_id' => 1712,
'name' => 'Dongargarh'
],[
'state_id' => 1712,
'name' => 'Durg'
],[
'state_id' => 1712,
'name' => 'Gandai'
],[
'state_id' => 1712,
'name' => 'Gariaband'
],[
'state_id' => 1712,
'name' => 'Gaurela'
],[
'state_id' => 1712,
'name' => 'Gharghoda'
],[
'state_id' => 1712,
'name' => 'Gidam'
],[
'state_id' => 1712,
'name' => 'Jagdalpur'
],[
'state_id' => 1712,
'name' => 'Janjgir-Champa'
],[
'state_id' => 1712,
'name' => 'Jashpur'
],[
'state_id' => 1712,
'name' => 'Jashpurnagar'
],[
'state_id' => 1712,
'name' => 'Janjgir'
],[
'state_id' => 1712,
'name' => 'Junagarh'
],[
'state_id' => 1712,
'name' => 'Kabeerdham'
],[
'state_id' => 1712,
'name' => 'Katghora'
],[
'state_id' => 1712,
'name' => 'Kawardha'
],[
'state_id' => 1712,
'name' => 'Khairagarh'
],[
'state_id' => 1712,
'name' => 'Khamharia'
],[
'state_id' => 1712,
'name' => 'Kharod'
],[
'state_id' => 1712,
'name' => 'Kharsia'
],[
'state_id' => 1712,
'name' => 'Kirandul'
],[
'state_id' => 1712,
'name' => 'Kondagaon'
],[
'state_id' => 1712,
'name' => 'Korba'
],[
'state_id' => 1712,
'name' => 'Koria'
],[
'state_id' => 1712,
'name' => 'Kotaparh'
],[
'state_id' => 1712,
'name' => 'Kota'
],[
'state_id' => 1712,
'name' => 'Kumhari'
],[
'state_id' => 1712,
'name' => 'Kurud'
],[
'state_id' => 1712,
'name' => 'Kanker'
],[
'state_id' => 1712,
'name' => 'Lormi'
],[
'state_id' => 1712,
'name' => 'Mahasamund'
],[
'state_id' => 1712,
'name' => 'Mungeli'
],[
'state_id' => 1712,
'name' => 'Narayanpur'
],[
'state_id' => 1712,
'name' => 'Narharpur'
],[
'state_id' => 1712,
'name' => 'Pandaria'
],[
'state_id' => 1712,
'name' => 'Pasan'
],[
'state_id' => 1712,
'name' => 'Pathalgaon'
],[
'state_id' => 1712,
'name' => 'Pendra'
],[
'state_id' => 1712,
'name' => 'Pithora'
],[
'state_id' => 1712,
'name' => 'Pandatarai'
],[
'state_id' => 1712,
'name' => 'Patan'
],[
'state_id' => 1712,
'name' => 'Raigarh'
],[
'state_id' => 1712,
'name' => 'Raipur'
],[
'state_id' => 1712,
'name' => 'Ratanpur'
],[
'state_id' => 1712,
'name' => 'Raj Nandgaon'
],[
'state_id' => 1712,
'name' => 'Ramanuj Ganj'
],[
'state_id' => 1712,
'name' => 'Sakti'
],[
'state_id' => 1712,
'name' => 'Saraipali'
],[
'state_id' => 1712,
'name' => 'Seorinarayan'
],[
'state_id' => 1712,
'name' => 'Simga'
],[
'state_id' => 1712,
'name' => 'Surguja'
],[
'state_id' => 1712,
'name' => 'Sarangarh'
],[
'state_id' => 1712,
'name' => 'Takhatpur'
],[
'state_id' => 1712,
'name' => 'Umarkot'
],[
'state_id' => 1712,
'name' => 'Uttar Bastar Kanker'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
