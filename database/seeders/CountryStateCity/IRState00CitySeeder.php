<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState00CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1749,
'name' => 'Arak'
],[
'state_id' => 1749,
'name' => 'Delijan'
],[
'state_id' => 1749,
'name' => 'Khomeyn'
],[
'state_id' => 1749,
'name' => 'Komijan'
],[
'state_id' => 1749,
'name' => 'Farahan'
],[
'state_id' => 1749,
'name' => 'Khondab'
],[
'state_id' => 1749,
'name' => 'Mahallat'
],[
'state_id' => 1749,
'name' => 'Shazand'
],[
'state_id' => 1749,
'name' => 'Zarandiyeh'
],[
'state_id' => 1749,
'name' => 'Ashtian'
],[
'state_id' => 1749,
'name' => 'Saveh'
],[
'state_id' => 1749,
'name' => 'Tafresh'
],[
'state_id' => 1749,
'name' => 'Abyek'
],[
'state_id' => 1749,
'name' => 'Davoud Abad'
],[
'state_id' => 1749,
'name' => 'Saroogh'
],[
'state_id' => 1749,
'name' => 'Karchan'
],[
'state_id' => 1749,
'name' => 'Khomein'
],[
'state_id' => 1749,
'name' => 'Ghurchi Bashi'
],[
'state_id' => 1749,
'name' => 'Javarseyan'
],[
'state_id' => 1749,
'name' => 'Naragh'
],[
'state_id' => 1749,
'name' => 'Parandak'
],[
'state_id' => 1749,
'name' => 'Khoshkrud'
],[
'state_id' => 1749,
'name' => 'Razeqan'
],[
'state_id' => 1749,
'name' => 'Zavieh'
],[
'state_id' => 1749,
'name' => 'Mamuniyeh'
],[
'state_id' => 1749,
'name' => 'Aveh'
],[
'state_id' => 1749,
'name' => 'Gharqabad'
],[
'state_id' => 1749,
'name' => 'Nowbaran'
],[
'state_id' => 1749,
'name' => 'Astaneh'
],[
'state_id' => 1749,
'name' => 'Tureh'
],[
'state_id' => 1749,
'name' => 'Shahbaz'
],[
'state_id' => 1749,
'name' => 'Mohajeran'
],[
'state_id' => 1749,
'name' => 'Hendoudar'
],[
'state_id' => 1749,
'name' => 'Khenejin'
],[
'state_id' => 1749,
'name' => 'Farmahin'
],[
'state_id' => 1749,
'name' => 'Milajerd'
],[
'state_id' => 1749,
'name' => 'Mahalat'
],[
'state_id' => 1749,
'name' => 'Nimvar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
