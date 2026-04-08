<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BAStateSRPCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 511,
'name' => 'Balatun'
],[
'state_id' => 511,
'name' => 'Banja Luka'
],[
'state_id' => 511,
'name' => 'Bijeljina'
],[
'state_id' => 511,
'name' => 'Bileća'
],[
'state_id' => 511,
'name' => 'Blatnica'
],[
'state_id' => 511,
'name' => 'Brod'
],[
'state_id' => 511,
'name' => 'Bronzani Majdan'
],[
'state_id' => 511,
'name' => 'Derventa'
],[
'state_id' => 511,
'name' => 'Doboj'
],[
'state_id' => 511,
'name' => 'Dobrljin'
],[
'state_id' => 511,
'name' => 'Dvorovi'
],[
'state_id' => 511,
'name' => 'Foča'
],[
'state_id' => 511,
'name' => 'Gacko'
],[
'state_id' => 511,
'name' => 'Gradiška'
],[
'state_id' => 511,
'name' => 'Hiseti'
],[
'state_id' => 511,
'name' => 'Istočni Mostar'
],[
'state_id' => 511,
'name' => 'Janja'
],[
'state_id' => 511,
'name' => 'Kalenderovci Donji'
],[
'state_id' => 511,
'name' => 'Kneževo'
],[
'state_id' => 511,
'name' => 'Knežica'
],[
'state_id' => 511,
'name' => 'Koran'
],[
'state_id' => 511,
'name' => 'Kostajnica'
],[
'state_id' => 511,
'name' => 'Kotor Varoš'
],[
'state_id' => 511,
'name' => 'Kozarska Dubica'
],[
'state_id' => 511,
'name' => 'Krupa na Vrbasu'
],[
'state_id' => 511,
'name' => 'Laktaši'
],[
'state_id' => 511,
'name' => 'Lamovita'
],[
'state_id' => 511,
'name' => 'Ljubinje'
],[
'state_id' => 511,
'name' => 'Lopare'
],[
'state_id' => 511,
'name' => 'Maglajani'
],[
'state_id' => 511,
'name' => 'Marićka'
],[
'state_id' => 511,
'name' => 'Maslovare'
],[
'state_id' => 511,
'name' => 'Mejdan - Obilićevo'
],[
'state_id' => 511,
'name' => 'Milići'
],[
'state_id' => 511,
'name' => 'Modriča'
],[
'state_id' => 511,
'name' => 'Mrkonjić Grad'
],[
'state_id' => 511,
'name' => 'Nevesinje'
],[
'state_id' => 511,
'name' => 'Novi Grad'
],[
'state_id' => 511,
'name' => 'Obudovac'
],[
'state_id' => 511,
'name' => 'Omarska'
],[
'state_id' => 511,
'name' => 'Opština Oštra Luka'
],[
'state_id' => 511,
'name' => 'Opština Višegrad'
],[
'state_id' => 511,
'name' => 'Oštra Luka'
],[
'state_id' => 511,
'name' => 'Pale'
],[
'state_id' => 511,
'name' => 'Pelagićevo'
],[
'state_id' => 511,
'name' => 'Petkovci'
],[
'state_id' => 511,
'name' => 'Piskavica'
],[
'state_id' => 511,
'name' => 'Podbrdo'
],[
'state_id' => 511,
'name' => 'Popovi'
],[
'state_id' => 511,
'name' => 'Pribinić'
],[
'state_id' => 511,
'name' => 'Priboj'
],[
'state_id' => 511,
'name' => 'Prijedor'
],[
'state_id' => 511,
'name' => 'Rogatica'
],[
'state_id' => 511,
'name' => 'Rudo'
],[
'state_id' => 511,
'name' => 'Sokolac'
],[
'state_id' => 511,
'name' => 'Srbac'
],[
'state_id' => 511,
'name' => 'Srebrenica'
],[
'state_id' => 511,
'name' => 'Stanari'
],[
'state_id' => 511,
'name' => 'Starcevica'
],[
'state_id' => 511,
'name' => 'Svodna'
],[
'state_id' => 511,
'name' => 'Teslić'
],[
'state_id' => 511,
'name' => 'Trebinje'
],[
'state_id' => 511,
'name' => 'Trn'
],[
'state_id' => 511,
'name' => 'Ugljevik'
],[
'state_id' => 511,
'name' => 'Velika Obarska'
],[
'state_id' => 511,
'name' => 'Višegrad'
],[
'state_id' => 511,
'name' => 'Vlasenica'
],[
'state_id' => 511,
'name' => 'Zvornik'
],[
'state_id' => 511,
'name' => 'Čajniče'
],[
'state_id' => 511,
'name' => 'Čelinac'
],[
'state_id' => 511,
'name' => 'Čečava'
],[
'state_id' => 511,
'name' => 'Šamac'
],[
'state_id' => 511,
'name' => 'Šekovići'
],[
'state_id' => 511,
'name' => 'Šipovo'
],[
'state_id' => 511,
'name' => 'Živinice'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
