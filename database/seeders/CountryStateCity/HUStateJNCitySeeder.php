<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateJNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1644,
'name' => 'Abádszalók'
],[
'state_id' => 1644,
'name' => 'Alattyán'
],[
'state_id' => 1644,
'name' => 'Besenyszög'
],[
'state_id' => 1644,
'name' => 'Cibakháza'
],[
'state_id' => 1644,
'name' => 'Cserkeszőlő'
],[
'state_id' => 1644,
'name' => 'Fegyvernek'
],[
'state_id' => 1644,
'name' => 'Jánoshida'
],[
'state_id' => 1644,
'name' => 'Jászalsószentgyörgy'
],[
'state_id' => 1644,
'name' => 'Jászapáti'
],[
'state_id' => 1644,
'name' => 'Jászapáti Járás'
],[
'state_id' => 1644,
'name' => 'Jászberény'
],[
'state_id' => 1644,
'name' => 'Jászberényi Járás'
],[
'state_id' => 1644,
'name' => 'Jászdózsa'
],[
'state_id' => 1644,
'name' => 'Jászjákóhalma'
],[
'state_id' => 1644,
'name' => 'Jászkisér'
],[
'state_id' => 1644,
'name' => 'Jászladány'
],[
'state_id' => 1644,
'name' => 'Jászszentandrás'
],[
'state_id' => 1644,
'name' => 'Jászárokszállás'
],[
'state_id' => 1644,
'name' => 'Karcag'
],[
'state_id' => 1644,
'name' => 'Karcagi Járás'
],[
'state_id' => 1644,
'name' => 'Kenderes'
],[
'state_id' => 1644,
'name' => 'Kengyel'
],[
'state_id' => 1644,
'name' => 'Kisújszállás'
],[
'state_id' => 1644,
'name' => 'Kunhegyes'
],[
'state_id' => 1644,
'name' => 'Kunhegyesi Járás'
],[
'state_id' => 1644,
'name' => 'Kunmadaras'
],[
'state_id' => 1644,
'name' => 'Kunszentmárton'
],[
'state_id' => 1644,
'name' => 'Kunszentmártoni Járás'
],[
'state_id' => 1644,
'name' => 'Mezőtúr'
],[
'state_id' => 1644,
'name' => 'Mezőtúri Járás'
],[
'state_id' => 1644,
'name' => 'Rákóczifalva'
],[
'state_id' => 1644,
'name' => 'Rákócziújfalu'
],[
'state_id' => 1644,
'name' => 'Szajol'
],[
'state_id' => 1644,
'name' => 'Szelevény'
],[
'state_id' => 1644,
'name' => 'Szolnok'
],[
'state_id' => 1644,
'name' => 'Szolnoki Járás'
],[
'state_id' => 1644,
'name' => 'Tiszabura'
],[
'state_id' => 1644,
'name' => 'Tiszabő'
],[
'state_id' => 1644,
'name' => 'Tiszaföldvár'
],[
'state_id' => 1644,
'name' => 'Tiszafüred'
],[
'state_id' => 1644,
'name' => 'Tiszafüredi Járás'
],[
'state_id' => 1644,
'name' => 'Tiszapüspöki'
],[
'state_id' => 1644,
'name' => 'Tiszaroff'
],[
'state_id' => 1644,
'name' => 'Tiszaszentimre'
],[
'state_id' => 1644,
'name' => 'Tiszaszőlős'
],[
'state_id' => 1644,
'name' => 'Tiszasüly'
],[
'state_id' => 1644,
'name' => 'Tószeg'
],[
'state_id' => 1644,
'name' => 'Törökszentmiklós'
],[
'state_id' => 1644,
'name' => 'Törökszentmiklósi Járás'
],[
'state_id' => 1644,
'name' => 'Túrkeve'
],[
'state_id' => 1644,
'name' => 'Zagyvarékas'
],[
'state_id' => 1644,
'name' => 'Öcsöd'
],[
'state_id' => 1644,
'name' => 'Újszász'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
