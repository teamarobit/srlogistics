<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState15CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1761,
'name' => 'Aleshtar'
],[
'state_id' => 1761,
'name' => 'Aligudarz'
],[
'state_id' => 1761,
'name' => 'Azna'
],[
'state_id' => 1761,
'name' => 'Borujerd'
],[
'state_id' => 1761,
'name' => 'Delfan'
],[
'state_id' => 1761,
'name' => 'Khorramabad'
],[
'state_id' => 1761,
'name' => 'Kuhdasht'
],[
'state_id' => 1761,
'name' => 'Nurabad'
],[
'state_id' => 1761,
'name' => 'Pol-e Dokhtar'
],[
'state_id' => 1761,
'name' => 'Rumeshkhan County'
],[
'state_id' => 1761,
'name' => 'Selseleh'
],[
'state_id' => 1761,
'name' => 'Vasian'
],[
'state_id' => 1761,
'name' => 'Momen Abad'
],[
'state_id' => 1761,
'name' => 'Shool Abad'
],[
'state_id' => 1761,
'name' => 'Oshtorinan'
],[
'state_id' => 1761,
'name' => 'Pol Dokhtar'
],[
'state_id' => 1761,
'name' => 'Mamulan'
],[
'state_id' => 1761,
'name' => 'Bayranshahr'
],[
'state_id' => 1761,
'name' => 'Zagheh'
],[
'state_id' => 1761,
'name' => 'Sepid Dasht'
],[
'state_id' => 1761,
'name' => 'Haft Cheshmeh'
],[
'state_id' => 1761,
'name' => 'Chalan Chulan'
],[
'state_id' => 1761,
'name' => 'Dorud'
],[
'state_id' => 1761,
'name' => 'Sarab-e Dowreh'
],[
'state_id' => 1761,
'name' => 'Veysian'
],[
'state_id' => 1761,
'name' => 'Chaqabol'
],[
'state_id' => 1761,
'name' => 'Firouz Abad'
],[
'state_id' => 1761,
'name' => 'Darb Gonbad'
],[
'state_id' => 1761,
'name' => 'Kunani'
],[
'state_id' => 1761,
'name' => 'Garab'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
