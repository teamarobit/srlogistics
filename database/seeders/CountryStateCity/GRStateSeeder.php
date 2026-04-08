<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class GRStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 85,
'name' => 'Karditsa Regional Unit',
'iso2' => '41'
],[
'country_id' => 85,
'name' => 'West Greece Region',
'iso2' => 'G'
],[
'country_id' => 85,
'name' => 'Thessaloniki Regional Unit',
'iso2' => '54'
],[
'country_id' => 85,
'name' => 'Arcadia Prefecture',
'iso2' => '12'
],[
'country_id' => 85,
'name' => 'Imathia Regional Unit',
'iso2' => '53'
],[
'country_id' => 85,
'name' => 'Kastoria Regional Unit',
'iso2' => '56'
],[
'country_id' => 85,
'name' => 'Euboea',
'iso2' => '04'
],[
'country_id' => 85,
'name' => 'Grevena Prefecture',
'iso2' => '51'
],[
'country_id' => 85,
'name' => 'Preveza Prefecture',
'iso2' => '34'
],[
'country_id' => 85,
'name' => 'Lefkada Regional Unit',
'iso2' => '24'
],[
'country_id' => 85,
'name' => 'Argolis Regional Unit',
'iso2' => '11'
],[
'country_id' => 85,
'name' => 'Laconia',
'iso2' => '16'
],[
'country_id' => 85,
'name' => 'Pella Regional Unit',
'iso2' => '59'
],[
'country_id' => 85,
'name' => 'West Macedonia Region',
'iso2' => 'C'
],[
'country_id' => 85,
'name' => 'Crete Region',
'iso2' => 'M'
],[
'country_id' => 85,
'name' => 'Epirus Region',
'iso2' => 'D'
],[
'country_id' => 85,
'name' => 'Kilkis Regional Unit',
'iso2' => '57'
],[
'country_id' => 85,
'name' => 'Kozani Prefecture',
'iso2' => '58'
],[
'country_id' => 85,
'name' => 'Ioannina Regional Unit',
'iso2' => '33'
],[
'country_id' => 85,
'name' => 'Phthiotis Prefecture',
'iso2' => '06'
],[
'country_id' => 85,
'name' => 'Chania Regional Unit',
'iso2' => '94'
],[
'country_id' => 85,
'name' => 'Achaea Regional Unit',
'iso2' => '13'
],[
'country_id' => 85,
'name' => 'East Macedonia and Thrace',
'iso2' => 'A'
],[
'country_id' => 85,
'name' => 'South Aegean',
'iso2' => 'L'
],[
'country_id' => 85,
'name' => 'Peloponnese Region',
'iso2' => 'J'
],[
'country_id' => 85,
'name' => 'East Attica Regional Unit',
'iso2' => 'A2'
],[
'country_id' => 85,
'name' => 'Serres Prefecture',
'iso2' => '62'
],[
'country_id' => 85,
'name' => 'Attica Region',
'iso2' => 'I'
],[
'country_id' => 85,
'name' => 'Aetolia-Acarnania Regional Unit',
'iso2' => '01'
],[
'country_id' => 85,
'name' => 'Corfu Prefecture',
'iso2' => '22'
],[
'country_id' => 85,
'name' => 'Central Macedonia',
'iso2' => 'B'
],[
'country_id' => 85,
'name' => 'Boeotia Regional Unit',
'iso2' => '03'
],[
'country_id' => 85,
'name' => 'Kefalonia Prefecture',
'iso2' => '23'
],[
'country_id' => 85,
'name' => 'Central Greece Region',
'iso2' => 'H'
],[
'country_id' => 85,
'name' => 'Corinthia Regional Unit',
'iso2' => '15'
],[
'country_id' => 85,
'name' => 'Drama Regional Unit',
'iso2' => '52'
],[
'country_id' => 85,
'name' => 'Ionian Islands Region',
'iso2' => 'F'
],[
'country_id' => 85,
'name' => 'Larissa Prefecture',
'iso2' => '42'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
