<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DEStateMVCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1426,
'name' => 'Admannshagen-Bargeshagen'
],[
'state_id' => 1426,
'name' => 'Ahlbeck'
],[
'state_id' => 1426,
'name' => 'Alt Meteln'
],[
'state_id' => 1426,
'name' => 'Alt-Sanitz'
],[
'state_id' => 1426,
'name' => 'Altefähr'
],[
'state_id' => 1426,
'name' => 'Altenkirchen'
],[
'state_id' => 1426,
'name' => 'Altenpleen'
],[
'state_id' => 1426,
'name' => 'Altentreptow'
],[
'state_id' => 1426,
'name' => 'Altstadt'
],[
'state_id' => 1426,
'name' => 'Anklam'
],[
'state_id' => 1426,
'name' => 'Bad Doberan'
],[
'state_id' => 1426,
'name' => 'Bad Kleinen'
],[
'state_id' => 1426,
'name' => 'Bad Sülze'
],[
'state_id' => 1426,
'name' => 'Banzkow'
],[
'state_id' => 1426,
'name' => 'Bartenshagen-Parkentin'
],[
'state_id' => 1426,
'name' => 'Barth'
],[
'state_id' => 1426,
'name' => 'Bastorf'
],[
'state_id' => 1426,
'name' => 'Bentwisch'
],[
'state_id' => 1426,
'name' => 'Bentzin'
],[
'state_id' => 1426,
'name' => 'Bergen auf Rügen'
],[
'state_id' => 1426,
'name' => 'Bernitt'
],[
'state_id' => 1426,
'name' => 'Biendorf'
],[
'state_id' => 1426,
'name' => 'Blankensee'
],[
'state_id' => 1426,
'name' => 'Blowatz'
],[
'state_id' => 1426,
'name' => 'Bobitz'
],[
'state_id' => 1426,
'name' => 'Boizenburg'
],[
'state_id' => 1426,
'name' => 'Born'
],[
'state_id' => 1426,
'name' => 'Borrentin'
],[
'state_id' => 1426,
'name' => 'Brandshagen'
],[
'state_id' => 1426,
'name' => 'Broderstorf'
],[
'state_id' => 1426,
'name' => 'Brunn'
],[
'state_id' => 1426,
'name' => 'Brüel'
],[
'state_id' => 1426,
'name' => 'Brüsewitz'
],[
'state_id' => 1426,
'name' => 'Burg Stargard'
],[
'state_id' => 1426,
'name' => 'Burow'
],[
'state_id' => 1426,
'name' => 'Börgerende-Rethwisch'
],[
'state_id' => 1426,
'name' => 'Bützow'
],[
'state_id' => 1426,
'name' => 'Carlow'
],[
'state_id' => 1426,
'name' => 'Carpin'
],[
'state_id' => 1426,
'name' => 'Crivitz'
],[
'state_id' => 1426,
'name' => 'Dabel'
],[
'state_id' => 1426,
'name' => 'Dargun'
],[
'state_id' => 1426,
'name' => 'Dassow'
],[
'state_id' => 1426,
'name' => 'Demen'
],[
'state_id' => 1426,
'name' => 'Demmin'
],[
'state_id' => 1426,
'name' => 'Dersekow'
],[
'state_id' => 1426,
'name' => 'Dierkow-Neu'
],[
'state_id' => 1426,
'name' => 'Dierkow-West'
],[
'state_id' => 1426,
'name' => 'Dobbertin'
],[
'state_id' => 1426,
'name' => 'Domsühl'
],[
'state_id' => 1426,
'name' => 'Dranske'
],[
'state_id' => 1426,
'name' => 'Ducherow'
],[
'state_id' => 1426,
'name' => 'Dummerstorf'
],[
'state_id' => 1426,
'name' => 'Dömitz'
],[
'state_id' => 1426,
'name' => 'Dümmer'
],[
'state_id' => 1426,
'name' => 'Eggesin'
],[
'state_id' => 1426,
'name' => 'Eldena'
],[
'state_id' => 1426,
'name' => 'Elmenhorst'
],[
'state_id' => 1426,
'name' => 'Feldstadt'
],[
'state_id' => 1426,
'name' => 'Ferdinandshof'
],[
'state_id' => 1426,
'name' => 'Franzburg'
],[
'state_id' => 1426,
'name' => 'Friedland'
],[
'state_id' => 1426,
'name' => 'Gadebusch'
],[
'state_id' => 1426,
'name' => 'Garz'
],[
'state_id' => 1426,
'name' => 'Gelbensande'
],[
'state_id' => 1426,
'name' => 'Gielow'
],[
'state_id' => 1426,
'name' => 'Gingst'
],[
'state_id' => 1426,
'name' => 'Glowe'
],[
'state_id' => 1426,
'name' => 'Gnoien'
],[
'state_id' => 1426,
'name' => 'Goldberg'
],[
'state_id' => 1426,
'name' => 'Grabow'
],[
'state_id' => 1426,
'name' => 'Grabowhöfe'
],[
'state_id' => 1426,
'name' => 'Gramkow'
],[
'state_id' => 1426,
'name' => 'Greifswald'
],[
'state_id' => 1426,
'name' => 'Grevesmühlen'
],[
'state_id' => 1426,
'name' => 'Grimmen'
],[
'state_id' => 1426,
'name' => 'Groß Kiesow'
],[
'state_id' => 1426,
'name' => 'Groß Laasch'
],[
'state_id' => 1426,
'name' => 'Groß Miltzow'
],[
'state_id' => 1426,
'name' => 'Groß Nemerow'
],[
'state_id' => 1426,
'name' => 'Groß Wokern'
],[
'state_id' => 1426,
'name' => 'Gägelow'
],[
'state_id' => 1426,
'name' => 'Görmin'
],[
'state_id' => 1426,
'name' => 'Güstrow'
],[
'state_id' => 1426,
'name' => 'Gützkow'
],[
'state_id' => 1426,
'name' => 'Hagenow'
],[
'state_id' => 1426,
'name' => 'Hiddensee'
],[
'state_id' => 1426,
'name' => 'Hornstorf'
],[
'state_id' => 1426,
'name' => 'Jarmen'
],[
'state_id' => 1426,
'name' => 'Jatznick'
],[
'state_id' => 1426,
'name' => 'Jördenstorf'
],[
'state_id' => 1426,
'name' => 'Jürgenshagen'
],[
'state_id' => 1426,
'name' => 'Kalkhorst'
],[
'state_id' => 1426,
'name' => 'Karlshagen'
],[
'state_id' => 1426,
'name' => 'Kavelstorf'
],[
'state_id' => 1426,
'name' => 'Kemnitz'
],[
'state_id' => 1426,
'name' => 'Kessin'
],[
'state_id' => 1426,
'name' => 'Klein Rogahn'
],[
'state_id' => 1426,
'name' => 'Klink'
],[
'state_id' => 1426,
'name' => 'Klütz'
],[
'state_id' => 1426,
'name' => 'Koserow'
],[
'state_id' => 1426,
'name' => 'Krakow am See'
],[
'state_id' => 1426,
'name' => 'Kramerhof'
],[
'state_id' => 1426,
'name' => 'Kritzmow'
],[
'state_id' => 1426,
'name' => 'Kröpelin'
],[
'state_id' => 1426,
'name' => 'Kröslin'
],[
'state_id' => 1426,
'name' => 'Laage'
],[
'state_id' => 1426,
'name' => 'Lalendorf'
],[
'state_id' => 1426,
'name' => 'Lambrechtshagen'
],[
'state_id' => 1426,
'name' => 'Lankow'
],[
'state_id' => 1426,
'name' => 'Lassan'
],[
'state_id' => 1426,
'name' => 'Leezen'
],[
'state_id' => 1426,
'name' => 'Lewenberg'
],[
'state_id' => 1426,
'name' => 'Loddin'
],[
'state_id' => 1426,
'name' => 'Loitz'
],[
'state_id' => 1426,
'name' => 'Lubmin'
],[
'state_id' => 1426,
'name' => 'Ludwigslust'
],[
'state_id' => 1426,
'name' => 'Löcknitz'
],[
'state_id' => 1426,
'name' => 'Lübow'
],[
'state_id' => 1426,
'name' => 'Lübstorf'
],[
'state_id' => 1426,
'name' => 'Lübtheen'
],[
'state_id' => 1426,
'name' => 'Lübz'
],[
'state_id' => 1426,
'name' => 'Lüdersdorf'
],[
'state_id' => 1426,
'name' => 'Lützow'
],[
'state_id' => 1426,
'name' => 'Malchin'
],[
'state_id' => 1426,
'name' => 'Malchow'
],[
'state_id' => 1426,
'name' => 'Malliß'
],[
'state_id' => 1426,
'name' => 'Marlow'
],[
'state_id' => 1426,
'name' => 'Mecklenburg'
],[
'state_id' => 1426,
'name' => 'Mesekenhagen'
],[
'state_id' => 1426,
'name' => 'Mirow'
],[
'state_id' => 1426,
'name' => 'Möllenhagen'
],[
'state_id' => 1426,
'name' => 'Mönchhagen'
],[
'state_id' => 1426,
'name' => 'Mühl Rosin'
],[
'state_id' => 1426,
'name' => 'Mühlen Eichsen'
],[
'state_id' => 1426,
'name' => 'Neu Kaliß'
],[
'state_id' => 1426,
'name' => 'Neubrandenburg'
],[
'state_id' => 1426,
'name' => 'Neubukow'
],[
'state_id' => 1426,
'name' => 'Neuburg'
],[
'state_id' => 1426,
'name' => 'Neuenkirchen'
],[
'state_id' => 1426,
'name' => 'Neukalen'
],[
'state_id' => 1426,
'name' => 'Neukloster'
],[
'state_id' => 1426,
'name' => 'Neumühle'
],[
'state_id' => 1426,
'name' => 'Neustadt-Glewe'
],[
'state_id' => 1426,
'name' => 'Neustrelitz'
],[
'state_id' => 1426,
'name' => 'Neverin'
],[
'state_id' => 1426,
'name' => 'Nienhagen'
],[
'state_id' => 1426,
'name' => 'Niepars'
],[
'state_id' => 1426,
'name' => 'Nostorf'
],[
'state_id' => 1426,
'name' => 'Ostseebad Binz'
],[
'state_id' => 1426,
'name' => 'Ostseebad Boltenhagen'
],[
'state_id' => 1426,
'name' => 'Ostseebad Dierhagen'
],[
'state_id' => 1426,
'name' => 'Ostseebad Göhren'
],[
'state_id' => 1426,
'name' => 'Ostseebad Kühlungsborn'
],[
'state_id' => 1426,
'name' => 'Ostseebad Prerow'
],[
'state_id' => 1426,
'name' => 'Ostseebad Sellin'
],[
'state_id' => 1426,
'name' => 'Ostseebad Zinnowitz'
],[
'state_id' => 1426,
'name' => 'Pampow'
],[
'state_id' => 1426,
'name' => 'Papendorf'
],[
'state_id' => 1426,
'name' => 'Parchim'
],[
'state_id' => 1426,
'name' => 'Pasewalk'
],[
'state_id' => 1426,
'name' => 'Paulsstadt'
],[
'state_id' => 1426,
'name' => 'Penkun'
],[
'state_id' => 1426,
'name' => 'Penzlin'
],[
'state_id' => 1426,
'name' => 'Pinnow'
],[
'state_id' => 1426,
'name' => 'Plate'
],[
'state_id' => 1426,
'name' => 'Plau am See'
],[
'state_id' => 1426,
'name' => 'Poseritz'
],[
'state_id' => 1426,
'name' => 'Preetz'
],[
'state_id' => 1426,
'name' => 'Prohn'
],[
'state_id' => 1426,
'name' => 'Putbus'
],[
'state_id' => 1426,
'name' => 'Raben Steinfeld'
],[
'state_id' => 1426,
'name' => 'Rambin'
],[
'state_id' => 1426,
'name' => 'Rastow'
],[
'state_id' => 1426,
'name' => 'Rechlin'
],[
'state_id' => 1426,
'name' => 'Rehna'
],[
'state_id' => 1426,
'name' => 'Reinberg'
],[
'state_id' => 1426,
'name' => 'Retgendorf'
],[
'state_id' => 1426,
'name' => 'Retschow'
],[
'state_id' => 1426,
'name' => 'Ribnitz-Damgarten'
],[
'state_id' => 1426,
'name' => 'Richtenberg'
],[
'state_id' => 1426,
'name' => 'Roggendorf'
],[
'state_id' => 1426,
'name' => 'Roggentin'
],[
'state_id' => 1426,
'name' => 'Rosenow'
],[
'state_id' => 1426,
'name' => 'Rostock'
],[
'state_id' => 1426,
'name' => 'Röbel'
],[
'state_id' => 1426,
'name' => 'Rövershagen'
],[
'state_id' => 1426,
'name' => 'Saal'
],[
'state_id' => 1426,
'name' => 'Sagard'
],[
'state_id' => 1426,
'name' => 'Samtens'
],[
'state_id' => 1426,
'name' => 'Satow-Oberhagen'
],[
'state_id' => 1426,
'name' => 'Saßnitz'
],[
'state_id' => 1426,
'name' => 'Schelfstadt'
],[
'state_id' => 1426,
'name' => 'Schlagsdorf'
],[
'state_id' => 1426,
'name' => 'Schwaan'
],[
'state_id' => 1426,
'name' => 'Schwerin'
],[
'state_id' => 1426,
'name' => 'Seebad Bansin'
],[
'state_id' => 1426,
'name' => 'Seebad Heringsdorf'
],[
'state_id' => 1426,
'name' => 'Seeheilbad Graal-Müritz'
],[
'state_id' => 1426,
'name' => 'Seehof'
],[
'state_id' => 1426,
'name' => 'Sehlen'
],[
'state_id' => 1426,
'name' => 'Sellin'
],[
'state_id' => 1426,
'name' => 'Selmsdorf'
],[
'state_id' => 1426,
'name' => 'Siggelkow'
],[
'state_id' => 1426,
'name' => 'Spornitz'
],[
'state_id' => 1426,
'name' => 'Steinhagen'
],[
'state_id' => 1426,
'name' => 'Sternberg'
],[
'state_id' => 1426,
'name' => 'Stralendorf'
],[
'state_id' => 1426,
'name' => 'Stralsund'
],[
'state_id' => 1426,
'name' => 'Strasburg'
],[
'state_id' => 1426,
'name' => 'Stäbelow'
],[
'state_id' => 1426,
'name' => 'Sukow'
],[
'state_id' => 1426,
'name' => 'Sülstorf'
],[
'state_id' => 1426,
'name' => 'Tarnow'
],[
'state_id' => 1426,
'name' => 'Tessin'
],[
'state_id' => 1426,
'name' => 'Teterow'
],[
'state_id' => 1426,
'name' => 'Torgelow'
],[
'state_id' => 1426,
'name' => 'Tribsees'
],[
'state_id' => 1426,
'name' => 'Trinwillershagen'
],[
'state_id' => 1426,
'name' => 'Trollenhagen'
],[
'state_id' => 1426,
'name' => 'Tutow'
],[
'state_id' => 1426,
'name' => 'Ueckermünde'
],[
'state_id' => 1426,
'name' => 'Usedom'
],[
'state_id' => 1426,
'name' => 'Velgast'
],[
'state_id' => 1426,
'name' => 'Viereck'
],[
'state_id' => 1426,
'name' => 'Wackerow'
],[
'state_id' => 1426,
'name' => 'Wardow'
],[
'state_id' => 1426,
'name' => 'Waren'
],[
'state_id' => 1426,
'name' => 'Warin'
],[
'state_id' => 1426,
'name' => 'Warnemünde'
],[
'state_id' => 1426,
'name' => 'Warnow'
],[
'state_id' => 1426,
'name' => 'Wattmannshagen'
],[
'state_id' => 1426,
'name' => 'Weitenhagen'
],[
'state_id' => 1426,
'name' => 'Wendorf'
],[
'state_id' => 1426,
'name' => 'Werdervorstadt'
],[
'state_id' => 1426,
'name' => 'Wesenberg'
],[
'state_id' => 1426,
'name' => 'Weststadt'
],[
'state_id' => 1426,
'name' => 'Wiek'
],[
'state_id' => 1426,
'name' => 'Wismar'
],[
'state_id' => 1426,
'name' => 'Wittenburg'
],[
'state_id' => 1426,
'name' => 'Wittenförden'
],[
'state_id' => 1426,
'name' => 'Wittenhagen'
],[
'state_id' => 1426,
'name' => 'Woldegk'
],[
'state_id' => 1426,
'name' => 'Wolgast'
],[
'state_id' => 1426,
'name' => 'Wulkenzin'
],[
'state_id' => 1426,
'name' => 'Wusterhusen'
],[
'state_id' => 1426,
'name' => 'Wustrow'
],[
'state_id' => 1426,
'name' => 'Zarrendorf'
],[
'state_id' => 1426,
'name' => 'Zarrentin'
],[
'state_id' => 1426,
'name' => 'Ziesendorf'
],[
'state_id' => 1426,
'name' => 'Zingst'
],[
'state_id' => 1426,
'name' => 'Zurow'
],[
'state_id' => 1426,
'name' => 'Züssow'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
