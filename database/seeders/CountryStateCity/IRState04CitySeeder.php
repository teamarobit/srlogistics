<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState04CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1757,
'name' => 'Chaypareh'
],[
'state_id' => 1757,
'name' => 'Khowy'
],[
'state_id' => 1757,
'name' => 'Miandoab'
],[
'state_id' => 1757,
'name' => 'Naqadeh'
],[
'state_id' => 1757,
'name' => 'Urmia'
],[
'state_id' => 1757,
'name' => 'Oshnaviyeh'
],[
'state_id' => 1757,
'name' => 'Piranshahr'
],[
'state_id' => 1757,
'name' => 'Poldasht'
],[
'state_id' => 1757,
'name' => 'Qarahziyaeddin'
],[
'state_id' => 1757,
'name' => 'Salmas'
],[
'state_id' => 1757,
'name' => 'Sardasht'
],[
'state_id' => 1757,
'name' => 'Bukan'
],[
'state_id' => 1757,
'name' => 'Chaldoran'
],[
'state_id' => 1757,
'name' => 'Mahabad'
],[
'state_id' => 1757,
'name' => 'Maku'
],[
'state_id' => 1757,
'name' => 'Shahin Dej'
],[
'state_id' => 1757,
'name' => 'Takab'
],[
'state_id' => 1757,
'name' => 'Serow'
],[
'state_id' => 1757,
'name' => 'Silvana'
],[
'state_id' => 1757,
'name' => 'Qushchi'
],[
'state_id' => 1757,
'name' => 'Noshin'
],[
'state_id' => 1757,
'name' => 'Oshnavieh'
],[
'state_id' => 1757,
'name' => 'Nalous'
],[
'state_id' => 1757,
'name' => 'Simmineh'
],[
'state_id' => 1757,
'name' => 'Nazok-e Olya'
],[
'state_id' => 1757,
'name' => 'Gerd Kashaneh'
],[
'state_id' => 1757,
'name' => 'Avajiq'
],[
'state_id' => 1757,
'name' => 'Siah Cheshmeh'
],[
'state_id' => 1757,
'name' => 'Evogli'
],[
'state_id' => 1757,
'name' => 'Khoy'
],[
'state_id' => 1757,
'name' => 'Dizaj Diz'
],[
'state_id' => 1757,
'name' => 'Zurabad'
],[
'state_id' => 1757,
'name' => 'Firuraq'
],[
'state_id' => 1757,
'name' => 'Qotur'
],[
'state_id' => 1757,
'name' => 'Rabat'
],[
'state_id' => 1757,
'name' => 'Mirabad'
],[
'state_id' => 1757,
'name' => 'Taze Shar'
],[
'state_id' => 1757,
'name' => 'Keshavarz'
],[
'state_id' => 1757,
'name' => 'Mahmoodabad'
],[
'state_id' => 1757,
'name' => 'Showt'
],[
'state_id' => 1757,
'name' => 'Marganlar'
],[
'state_id' => 1757,
'name' => 'Bazargan'
],[
'state_id' => 1757,
'name' => 'Khalifan'
],[
'state_id' => 1757,
'name' => 'Baruq'
],[
'state_id' => 1757,
'name' => 'Charburj'
],[
'state_id' => 1757,
'name' => 'Mohammadyar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
