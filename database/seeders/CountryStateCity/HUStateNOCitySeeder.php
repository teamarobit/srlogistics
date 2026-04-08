<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateNOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1652,
'name' => 'Balassagyarmat'
],[
'state_id' => 1652,
'name' => 'Balassagyarmati Járás'
],[
'state_id' => 1652,
'name' => 'Bercel'
],[
'state_id' => 1652,
'name' => 'Buják'
],[
'state_id' => 1652,
'name' => 'Bátonyterenye'
],[
'state_id' => 1652,
'name' => 'Bátonyterenyei Járás'
],[
'state_id' => 1652,
'name' => 'Diósjenő'
],[
'state_id' => 1652,
'name' => 'Héhalom'
],[
'state_id' => 1652,
'name' => 'Jobbágyi'
],[
'state_id' => 1652,
'name' => 'Karancskeszi'
],[
'state_id' => 1652,
'name' => 'Karancslapujtő'
],[
'state_id' => 1652,
'name' => 'Kazár'
],[
'state_id' => 1652,
'name' => 'Mátranovák'
],[
'state_id' => 1652,
'name' => 'Mátraterenye'
],[
'state_id' => 1652,
'name' => 'Mátraverebély'
],[
'state_id' => 1652,
'name' => 'Nagyoroszi'
],[
'state_id' => 1652,
'name' => 'Palotás'
],[
'state_id' => 1652,
'name' => 'Pásztó'
],[
'state_id' => 1652,
'name' => 'Pásztói Járás'
],[
'state_id' => 1652,
'name' => 'Rimóc'
],[
'state_id' => 1652,
'name' => 'Romhány'
],[
'state_id' => 1652,
'name' => 'Rétság'
],[
'state_id' => 1652,
'name' => 'Rétsági Járás'
],[
'state_id' => 1652,
'name' => 'Salgótarján'
],[
'state_id' => 1652,
'name' => 'Salgótarjáni Járás'
],[
'state_id' => 1652,
'name' => 'Somoskőújfalu'
],[
'state_id' => 1652,
'name' => 'Szurdokpüspöki'
],[
'state_id' => 1652,
'name' => 'Szécsény'
],[
'state_id' => 1652,
'name' => 'Szécsényi Járás'
],[
'state_id' => 1652,
'name' => 'Tar'
],[
'state_id' => 1652,
'name' => 'Érsekvadkert'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
