<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateHECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1641,
'name' => 'Abasár'
],[
'state_id' => 1641,
'name' => 'Adács'
],[
'state_id' => 1641,
'name' => 'Andornaktálya'
],[
'state_id' => 1641,
'name' => 'Apc'
],[
'state_id' => 1641,
'name' => 'Besenyőtelek'
],[
'state_id' => 1641,
'name' => 'Boldog'
],[
'state_id' => 1641,
'name' => 'Bélapátfalva'
],[
'state_id' => 1641,
'name' => 'Bélapátfalvai Járás'
],[
'state_id' => 1641,
'name' => 'Csány'
],[
'state_id' => 1641,
'name' => 'Domoszló'
],[
'state_id' => 1641,
'name' => 'Ecséd'
],[
'state_id' => 1641,
'name' => 'Eger'
],[
'state_id' => 1641,
'name' => 'Egerszalók'
],[
'state_id' => 1641,
'name' => 'Egri Járás'
],[
'state_id' => 1641,
'name' => 'Erdőtelek'
],[
'state_id' => 1641,
'name' => 'Felsőtárkány'
],[
'state_id' => 1641,
'name' => 'Füzesabony'
],[
'state_id' => 1641,
'name' => 'Füzesabonyi Járás'
],[
'state_id' => 1641,
'name' => 'Gyöngyös'
],[
'state_id' => 1641,
'name' => 'Gyöngyöshalász'
],[
'state_id' => 1641,
'name' => 'Gyöngyösi Járás'
],[
'state_id' => 1641,
'name' => 'Gyöngyöspata'
],[
'state_id' => 1641,
'name' => 'Gyöngyössolymos'
],[
'state_id' => 1641,
'name' => 'Gyöngyöstarján'
],[
'state_id' => 1641,
'name' => 'Hatvan'
],[
'state_id' => 1641,
'name' => 'Hatvani Járás'
],[
'state_id' => 1641,
'name' => 'Heréd'
],[
'state_id' => 1641,
'name' => 'Heves'
],[
'state_id' => 1641,
'name' => 'Hevesi Járás'
],[
'state_id' => 1641,
'name' => 'Hort'
],[
'state_id' => 1641,
'name' => 'Karácsond'
],[
'state_id' => 1641,
'name' => 'Kerecsend'
],[
'state_id' => 1641,
'name' => 'Kisköre'
],[
'state_id' => 1641,
'name' => 'Kompolt'
],[
'state_id' => 1641,
'name' => 'Kál'
],[
'state_id' => 1641,
'name' => 'Lőrinci'
],[
'state_id' => 1641,
'name' => 'Maklár'
],[
'state_id' => 1641,
'name' => 'Mátraderecske'
],[
'state_id' => 1641,
'name' => 'Nagyréde'
],[
'state_id' => 1641,
'name' => 'Ostoros'
],[
'state_id' => 1641,
'name' => 'Parád'
],[
'state_id' => 1641,
'name' => 'Parádsasvár'
],[
'state_id' => 1641,
'name' => 'Petőfibánya'
],[
'state_id' => 1641,
'name' => 'Poroszló'
],[
'state_id' => 1641,
'name' => 'Pétervására'
],[
'state_id' => 1641,
'name' => 'Pétervásárai Járás'
],[
'state_id' => 1641,
'name' => 'Recsk'
],[
'state_id' => 1641,
'name' => 'Rózsaszentmárton'
],[
'state_id' => 1641,
'name' => 'Sirok'
],[
'state_id' => 1641,
'name' => 'Szihalom'
],[
'state_id' => 1641,
'name' => 'Szilvásvárad'
],[
'state_id' => 1641,
'name' => 'Tarnalelesz'
],[
'state_id' => 1641,
'name' => 'Tarnaörs'
],[
'state_id' => 1641,
'name' => 'Tiszanána'
],[
'state_id' => 1641,
'name' => 'Verpelét'
],[
'state_id' => 1641,
'name' => 'Vámosgyörk'
],[
'state_id' => 1641,
'name' => 'Zagyvaszántó'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
