<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BAStateBIHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 508,
'name' => 'Banovići'
],[
'state_id' => 508,
'name' => 'Barice'
],[
'state_id' => 508,
'name' => 'Bihać'
],[
'state_id' => 508,
'name' => 'Bijela'
],[
'state_id' => 508,
'name' => 'Bila'
],[
'state_id' => 508,
'name' => 'Blagaj'
],[
'state_id' => 508,
'name' => 'Bosanska Krupa'
],[
'state_id' => 508,
'name' => 'Bosanski Petrovac'
],[
'state_id' => 508,
'name' => 'Bosansko Grahovo'
],[
'state_id' => 508,
'name' => 'Breza'
],[
'state_id' => 508,
'name' => 'Bugojno'
],[
'state_id' => 508,
'name' => 'Busovača'
],[
'state_id' => 508,
'name' => 'Bužim'
],[
'state_id' => 508,
'name' => 'Cazin'
],[
'state_id' => 508,
'name' => 'Cim'
],[
'state_id' => 508,
'name' => 'Crnići'
],[
'state_id' => 508,
'name' => 'Divičani'
],[
'state_id' => 508,
'name' => 'Dobrinje'
],[
'state_id' => 508,
'name' => 'Domaljevac'
],[
'state_id' => 508,
'name' => 'Donja Dubica'
],[
'state_id' => 508,
'name' => 'Donja Mahala'
],[
'state_id' => 508,
'name' => 'Donja Međiđa'
],[
'state_id' => 508,
'name' => 'Donji Vakuf'
],[
'state_id' => 508,
'name' => 'Drežnica'
],[
'state_id' => 508,
'name' => 'Drinovci'
],[
'state_id' => 508,
'name' => 'Drvar'
],[
'state_id' => 508,
'name' => 'Dubrave Donje'
],[
'state_id' => 508,
'name' => 'Dubrave Gornje'
],[
'state_id' => 508,
'name' => 'Dubravica'
],[
'state_id' => 508,
'name' => 'Fojnica'
],[
'state_id' => 508,
'name' => 'Glamoč'
],[
'state_id' => 508,
'name' => 'Gnojnica'
],[
'state_id' => 508,
'name' => 'Goražde'
],[
'state_id' => 508,
'name' => 'Gorica'
],[
'state_id' => 508,
'name' => 'Gornja Breza'
],[
'state_id' => 508,
'name' => 'Gornja Koprivna'
],[
'state_id' => 508,
'name' => 'Gornja Tuzla'
],[
'state_id' => 508,
'name' => 'Gornje Moštre'
],[
'state_id' => 508,
'name' => 'Gornje Živinice'
],[
'state_id' => 508,
'name' => 'Gornji Vakuf'
],[
'state_id' => 508,
'name' => 'Gostovići'
],[
'state_id' => 508,
'name' => 'Gradačac'
],[
'state_id' => 508,
'name' => 'Gračanica'
],[
'state_id' => 508,
'name' => 'Gromiljak'
],[
'state_id' => 508,
'name' => 'Grude'
],[
'state_id' => 508,
'name' => 'Hadžići'
],[
'state_id' => 508,
'name' => 'Hercegovačko-Neretvanski Kanton'
],[
'state_id' => 508,
'name' => 'Hotonj'
],[
'state_id' => 508,
'name' => 'Ilijaš'
],[
'state_id' => 508,
'name' => 'Ilići'
],[
'state_id' => 508,
'name' => 'Izačić'
],[
'state_id' => 508,
'name' => 'Jablanica'
],[
'state_id' => 508,
'name' => 'Jajce'
],[
'state_id' => 508,
'name' => 'Jelah'
],[
'state_id' => 508,
'name' => 'Jezerski'
],[
'state_id' => 508,
'name' => 'Kakanj'
],[
'state_id' => 508,
'name' => 'Kanton Sarajevo'
],[
'state_id' => 508,
'name' => 'Karadaglije'
],[
'state_id' => 508,
'name' => 'Kačuni'
],[
'state_id' => 508,
'name' => 'Kiseljak'
],[
'state_id' => 508,
'name' => 'Kladanj'
],[
'state_id' => 508,
'name' => 'Ključ'
],[
'state_id' => 508,
'name' => 'Kobilja Glava'
],[
'state_id' => 508,
'name' => 'Konjic'
],[
'state_id' => 508,
'name' => 'Kovači'
],[
'state_id' => 508,
'name' => 'Kočerin'
],[
'state_id' => 508,
'name' => 'Liješnica'
],[
'state_id' => 508,
'name' => 'Livno'
],[
'state_id' => 508,
'name' => 'Ljubuški'
],[
'state_id' => 508,
'name' => 'Lokvine'
],[
'state_id' => 508,
'name' => 'Lukavac'
],[
'state_id' => 508,
'name' => 'Lukavica'
],[
'state_id' => 508,
'name' => 'Maglaj'
],[
'state_id' => 508,
'name' => 'Mahala'
],[
'state_id' => 508,
'name' => 'Mala Kladuša'
],[
'state_id' => 508,
'name' => 'Malešići'
],[
'state_id' => 508,
'name' => 'Mionica'
],[
'state_id' => 508,
'name' => 'Mostar'
],[
'state_id' => 508,
'name' => 'Mramor'
],[
'state_id' => 508,
'name' => 'Neum'
],[
'state_id' => 508,
'name' => 'Novi Travnik'
],[
'state_id' => 508,
'name' => 'Novi Šeher'
],[
'state_id' => 508,
'name' => 'Odžak'
],[
'state_id' => 508,
'name' => 'Olovo'
],[
'state_id' => 508,
'name' => 'Omanjska'
],[
'state_id' => 508,
'name' => 'Orahovica Donja'
],[
'state_id' => 508,
'name' => 'Orašac'
],[
'state_id' => 508,
'name' => 'Orašje'
],[
'state_id' => 508,
'name' => 'Orguz'
],[
'state_id' => 508,
'name' => 'Ostrožac'
],[
'state_id' => 508,
'name' => 'Otoka'
],[
'state_id' => 508,
'name' => 'Pajić Polje'
],[
'state_id' => 508,
'name' => 'Pazarić'
],[
'state_id' => 508,
'name' => 'Peći'
],[
'state_id' => 508,
'name' => 'Pećigrad'
],[
'state_id' => 508,
'name' => 'Pjanići'
],[
'state_id' => 508,
'name' => 'Podhum'
],[
'state_id' => 508,
'name' => 'Podzvizd'
],[
'state_id' => 508,
'name' => 'Polje'
],[
'state_id' => 508,
'name' => 'Polje-Bijela'
],[
'state_id' => 508,
'name' => 'Potoci'
],[
'state_id' => 508,
'name' => 'Prozor'
],[
'state_id' => 508,
'name' => 'Puračić'
],[
'state_id' => 508,
'name' => 'Radišići'
],[
'state_id' => 508,
'name' => 'Rodoč'
],[
'state_id' => 508,
'name' => 'Rumboci'
],[
'state_id' => 508,
'name' => 'Sanica'
],[
'state_id' => 508,
'name' => 'Sanski Most'
],[
'state_id' => 508,
'name' => 'Sapna'
],[
'state_id' => 508,
'name' => 'Sarajevo'
],[
'state_id' => 508,
'name' => 'Skokovi'
],[
'state_id' => 508,
'name' => 'Sladna'
],[
'state_id' => 508,
'name' => 'Solina'
],[
'state_id' => 508,
'name' => 'Srebrenik'
],[
'state_id' => 508,
'name' => 'Stijena'
],[
'state_id' => 508,
'name' => 'Stjepan-Polje'
],[
'state_id' => 508,
'name' => 'Stolac'
],[
'state_id' => 508,
'name' => 'Tasovčići'
],[
'state_id' => 508,
'name' => 'Tešanj'
],[
'state_id' => 508,
'name' => 'Tešanjka'
],[
'state_id' => 508,
'name' => 'Todorovo'
],[
'state_id' => 508,
'name' => 'Tojšići'
],[
'state_id' => 508,
'name' => 'Tomislavgrad'
],[
'state_id' => 508,
'name' => 'Travnik'
],[
'state_id' => 508,
'name' => 'Tržačka Raštela'
],[
'state_id' => 508,
'name' => 'Turbe'
],[
'state_id' => 508,
'name' => 'Tuzla'
],[
'state_id' => 508,
'name' => 'Ustikolina'
],[
'state_id' => 508,
'name' => 'Vareš'
],[
'state_id' => 508,
'name' => 'Varoška Rijeka'
],[
'state_id' => 508,
'name' => 'Velagići'
],[
'state_id' => 508,
'name' => 'Velika Kladuša'
],[
'state_id' => 508,
'name' => 'Vidoši'
],[
'state_id' => 508,
'name' => 'Visoko'
],[
'state_id' => 508,
'name' => 'Vitez'
],[
'state_id' => 508,
'name' => 'Vitina'
],[
'state_id' => 508,
'name' => 'Vogošća'
],[
'state_id' => 508,
'name' => 'Voljevac'
],[
'state_id' => 508,
'name' => 'Vrnograč'
],[
'state_id' => 508,
'name' => 'Vukovije Donje'
],[
'state_id' => 508,
'name' => 'Zabrišće'
],[
'state_id' => 508,
'name' => 'Zavidovići'
],[
'state_id' => 508,
'name' => 'Zborište'
],[
'state_id' => 508,
'name' => 'Zenica'
],[
'state_id' => 508,
'name' => 'Ćoralići'
],[
'state_id' => 508,
'name' => 'Čapljina'
],[
'state_id' => 508,
'name' => 'Čelić'
],[
'state_id' => 508,
'name' => 'Čitluk'
],[
'state_id' => 508,
'name' => 'Šerići'
],[
'state_id' => 508,
'name' => 'Široki Brijeg'
],[
'state_id' => 508,
'name' => 'Šturlić'
],[
'state_id' => 508,
'name' => 'Šumatac'
],[
'state_id' => 508,
'name' => 'Željezno Polje'
],[
'state_id' => 508,
'name' => 'Žepče'
],[
'state_id' => 508,
'name' => 'Živinice'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
