<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DEStateBECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1429,
'name' => 'Adlershof'
],[
'state_id' => 1429,
'name' => 'Alt-Hohenschönhausen'
],[
'state_id' => 1429,
'name' => 'Alt-Treptow'
],[
'state_id' => 1429,
'name' => 'Altglienicke'
],[
'state_id' => 1429,
'name' => 'Baumschulenweg'
],[
'state_id' => 1429,
'name' => 'Berlin'
],[
'state_id' => 1429,
'name' => 'Berlin Köpenick'
],[
'state_id' => 1429,
'name' => 'Berlin Treptow'
],[
'state_id' => 1429,
'name' => 'Biesdorf'
],[
'state_id' => 1429,
'name' => 'Blankenburg'
],[
'state_id' => 1429,
'name' => 'Blankenfelde'
],[
'state_id' => 1429,
'name' => 'Bohnsdorf'
],[
'state_id' => 1429,
'name' => 'Britz'
],[
'state_id' => 1429,
'name' => 'Buch'
],[
'state_id' => 1429,
'name' => 'Buckow'
],[
'state_id' => 1429,
'name' => 'Charlottenburg'
],[
'state_id' => 1429,
'name' => 'Charlottenburg-Nord'
],[
'state_id' => 1429,
'name' => 'Dahlem'
],[
'state_id' => 1429,
'name' => 'Falkenberg'
],[
'state_id' => 1429,
'name' => 'Falkenhagener Feld'
],[
'state_id' => 1429,
'name' => 'Fennpfuhl'
],[
'state_id' => 1429,
'name' => 'Französisch Buchholz'
],[
'state_id' => 1429,
'name' => 'Friedenau'
],[
'state_id' => 1429,
'name' => 'Friedrichsfelde'
],[
'state_id' => 1429,
'name' => 'Friedrichshagen'
],[
'state_id' => 1429,
'name' => 'Friedrichshain'
],[
'state_id' => 1429,
'name' => 'Frohnau'
],[
'state_id' => 1429,
'name' => 'Gatow'
],[
'state_id' => 1429,
'name' => 'Gesundbrunnen'
],[
'state_id' => 1429,
'name' => 'Gropiusstadt'
],[
'state_id' => 1429,
'name' => 'Grunewald'
],[
'state_id' => 1429,
'name' => 'Grünau'
],[
'state_id' => 1429,
'name' => 'Hakenfelde'
],[
'state_id' => 1429,
'name' => 'Halensee'
],[
'state_id' => 1429,
'name' => 'Hansaviertel'
],[
'state_id' => 1429,
'name' => 'Haselhorst'
],[
'state_id' => 1429,
'name' => 'Heiligensee'
],[
'state_id' => 1429,
'name' => 'Heinersdorf'
],[
'state_id' => 1429,
'name' => 'Hellersdorf'
],[
'state_id' => 1429,
'name' => 'Hermsdorf'
],[
'state_id' => 1429,
'name' => 'Johannisthal'
],[
'state_id' => 1429,
'name' => 'Karlshorst'
],[
'state_id' => 1429,
'name' => 'Karow'
],[
'state_id' => 1429,
'name' => 'Kaulsdorf'
],[
'state_id' => 1429,
'name' => 'Kladow'
],[
'state_id' => 1429,
'name' => 'Konradshöhe'
],[
'state_id' => 1429,
'name' => 'Kreuzberg'
],[
'state_id' => 1429,
'name' => 'Köpenick'
],[
'state_id' => 1429,
'name' => 'Lankwitz'
],[
'state_id' => 1429,
'name' => 'Lichtenberg'
],[
'state_id' => 1429,
'name' => 'Lichtenrade'
],[
'state_id' => 1429,
'name' => 'Lichterfelde'
],[
'state_id' => 1429,
'name' => 'Lübars'
],[
'state_id' => 1429,
'name' => 'Mahlsdorf'
],[
'state_id' => 1429,
'name' => 'Mariendorf'
],[
'state_id' => 1429,
'name' => 'Marienfelde'
],[
'state_id' => 1429,
'name' => 'Marzahn'
],[
'state_id' => 1429,
'name' => 'Mitte'
],[
'state_id' => 1429,
'name' => 'Moabit'
],[
'state_id' => 1429,
'name' => 'Märkisches Viertel'
],[
'state_id' => 1429,
'name' => 'Müggelheim'
],[
'state_id' => 1429,
'name' => 'Neu-Hohenschönhausen'
],[
'state_id' => 1429,
'name' => 'Neukölln'
],[
'state_id' => 1429,
'name' => 'Niederschöneweide'
],[
'state_id' => 1429,
'name' => 'Niederschönhausen'
],[
'state_id' => 1429,
'name' => 'Nikolassee'
],[
'state_id' => 1429,
'name' => 'Oberschöneweide'
],[
'state_id' => 1429,
'name' => 'Pankow'
],[
'state_id' => 1429,
'name' => 'Plänterwald'
],[
'state_id' => 1429,
'name' => 'Prenzlauer Berg'
],[
'state_id' => 1429,
'name' => 'Rahnsdorf'
],[
'state_id' => 1429,
'name' => 'Reinickendorf'
],[
'state_id' => 1429,
'name' => 'Rosenthal'
],[
'state_id' => 1429,
'name' => 'Rudow'
],[
'state_id' => 1429,
'name' => 'Rummelsburg'
],[
'state_id' => 1429,
'name' => 'Schmargendorf'
],[
'state_id' => 1429,
'name' => 'Schmöckwitz'
],[
'state_id' => 1429,
'name' => 'Schöneberg'
],[
'state_id' => 1429,
'name' => 'Siemensstadt'
],[
'state_id' => 1429,
'name' => 'Spandau'
],[
'state_id' => 1429,
'name' => 'Staaken'
],[
'state_id' => 1429,
'name' => 'Stadtrandsiedlung Malchow'
],[
'state_id' => 1429,
'name' => 'Steglitz'
],[
'state_id' => 1429,
'name' => 'Tegel'
],[
'state_id' => 1429,
'name' => 'Tempelhof'
],[
'state_id' => 1429,
'name' => 'Tiergarten'
],[
'state_id' => 1429,
'name' => 'Waidmannslust'
],[
'state_id' => 1429,
'name' => 'Wannsee'
],[
'state_id' => 1429,
'name' => 'Wartenberg'
],[
'state_id' => 1429,
'name' => 'Wedding'
],[
'state_id' => 1429,
'name' => 'Weißensee'
],[
'state_id' => 1429,
'name' => 'Westend'
],[
'state_id' => 1429,
'name' => 'Wilhelmsruh'
],[
'state_id' => 1429,
'name' => 'Wilhelmstadt'
],[
'state_id' => 1429,
'name' => 'Wilmersdorf'
],[
'state_id' => 1429,
'name' => 'Wittenau'
],[
'state_id' => 1429,
'name' => 'Zehlendorf'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
