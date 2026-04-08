<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateGSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1643,
'name' => 'Abda'
],[
'state_id' => 1643,
'name' => 'Bakonyszentlászló'
],[
'state_id' => 1643,
'name' => 'Beled'
],[
'state_id' => 1643,
'name' => 'Bőny'
],[
'state_id' => 1643,
'name' => 'Bősárkány'
],[
'state_id' => 1643,
'name' => 'Csorna'
],[
'state_id' => 1643,
'name' => 'Csornai Járás'
],[
'state_id' => 1643,
'name' => 'Farád'
],[
'state_id' => 1643,
'name' => 'Fertőd'
],[
'state_id' => 1643,
'name' => 'Fertőrákos'
],[
'state_id' => 1643,
'name' => 'Fertőszentmiklós'
],[
'state_id' => 1643,
'name' => 'Győr'
],[
'state_id' => 1643,
'name' => 'Győri Járás'
],[
'state_id' => 1643,
'name' => 'Győrszemere'
],[
'state_id' => 1643,
'name' => 'Győrújbarát'
],[
'state_id' => 1643,
'name' => 'Halászi'
],[
'state_id' => 1643,
'name' => 'Jánossomorja'
],[
'state_id' => 1643,
'name' => 'Kapuvár'
],[
'state_id' => 1643,
'name' => 'Kapuvári Járás'
],[
'state_id' => 1643,
'name' => 'Kimle'
],[
'state_id' => 1643,
'name' => 'Kóny'
],[
'state_id' => 1643,
'name' => 'Lébény'
],[
'state_id' => 1643,
'name' => 'Mihályi'
],[
'state_id' => 1643,
'name' => 'Mosonmagyaróvár'
],[
'state_id' => 1643,
'name' => 'Mosonmagyaróvári Járás'
],[
'state_id' => 1643,
'name' => 'Mosonszentmiklós'
],[
'state_id' => 1643,
'name' => 'Nagycenk'
],[
'state_id' => 1643,
'name' => 'Nyúl'
],[
'state_id' => 1643,
'name' => 'Pannonhalma'
],[
'state_id' => 1643,
'name' => 'Pannonhalmi Járás'
],[
'state_id' => 1643,
'name' => 'Pér'
],[
'state_id' => 1643,
'name' => 'Rajka'
],[
'state_id' => 1643,
'name' => 'Rábapatona'
],[
'state_id' => 1643,
'name' => 'Sopron'
],[
'state_id' => 1643,
'name' => 'Soproni Járás'
],[
'state_id' => 1643,
'name' => 'Szany'
],[
'state_id' => 1643,
'name' => 'Tét'
],[
'state_id' => 1643,
'name' => 'Téti Járás'
],[
'state_id' => 1643,
'name' => 'Töltéstava'
],[
'state_id' => 1643,
'name' => 'Ágfalva'
],[
'state_id' => 1643,
'name' => 'Ásványráró'
],[
'state_id' => 1643,
'name' => 'Öttevény'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
