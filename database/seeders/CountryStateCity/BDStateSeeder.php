<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BDStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 19,
'name' => 'Rangpur Division',
'iso2' => 'F'
],[
'country_id' => 19,
'name' => 'Coxs Bazar District',
'iso2' => '11'
],[
'country_id' => 19,
'name' => 'Bandarban District',
'iso2' => '01'
],[
'country_id' => 19,
'name' => 'Rajshahi Division',
'iso2' => 'E'
],[
'country_id' => 19,
'name' => 'Pabna District',
'iso2' => '49'
],[
'country_id' => 19,
'name' => 'Sherpur District',
'iso2' => '57'
],[
'country_id' => 19,
'name' => 'Bhola District',
'iso2' => '07'
],[
'country_id' => 19,
'name' => 'Jessore District',
'iso2' => '22'
],[
'country_id' => 19,
'name' => 'Mymensingh Division',
'iso2' => 'H'
],[
'country_id' => 19,
'name' => 'Rangpur District',
'iso2' => '55'
],[
'country_id' => 19,
'name' => 'Dhaka Division',
'iso2' => 'C'
],[
'country_id' => 19,
'name' => 'Chapai Nawabganj District',
'iso2' => '45'
],[
'country_id' => 19,
'name' => 'Faridpur District',
'iso2' => '15'
],[
'country_id' => 19,
'name' => 'Comilla District',
'iso2' => '08'
],[
'country_id' => 19,
'name' => 'Netrokona District',
'iso2' => '41'
],[
'country_id' => 19,
'name' => 'Sylhet Division',
'iso2' => 'G'
],[
'country_id' => 19,
'name' => 'Mymensingh District',
'iso2' => '34'
],[
'country_id' => 19,
'name' => 'Sylhet District',
'iso2' => '60'
],[
'country_id' => 19,
'name' => 'Chandpur District',
'iso2' => '09'
],[
'country_id' => 19,
'name' => 'Narail District',
'iso2' => '43'
],[
'country_id' => 19,
'name' => 'Narayanganj District',
'iso2' => '40'
],[
'country_id' => 19,
'name' => 'Dhaka District',
'iso2' => '13'
],[
'country_id' => 19,
'name' => 'Nilphamari District',
'iso2' => '46'
],[
'country_id' => 19,
'name' => 'Rajbari District',
'iso2' => '53'
],[
'country_id' => 19,
'name' => 'Kushtia District',
'iso2' => '30'
],[
'country_id' => 19,
'name' => 'Khulna Division',
'iso2' => 'D'
],[
'country_id' => 19,
'name' => 'Meherpur District',
'iso2' => '39'
],[
'country_id' => 19,
'name' => 'Patuakhali District',
'iso2' => '51'
],[
'country_id' => 19,
'name' => 'Jhalokati District',
'iso2' => '25'
],[
'country_id' => 19,
'name' => 'Kishoreganj District',
'iso2' => '26'
],[
'country_id' => 19,
'name' => 'Lalmonirhat District',
'iso2' => '32'
],[
'country_id' => 19,
'name' => 'Sirajganj District',
'iso2' => '59'
],[
'country_id' => 19,
'name' => 'Tangail District',
'iso2' => '63'
],[
'country_id' => 19,
'name' => 'Dinajpur District',
'iso2' => '14'
],[
'country_id' => 19,
'name' => 'Barguna District',
'iso2' => '02'
],[
'country_id' => 19,
'name' => 'Chittagong District',
'iso2' => '10'
],[
'country_id' => 19,
'name' => 'Khagrachari District',
'iso2' => '29'
],[
'country_id' => 19,
'name' => 'Natore District',
'iso2' => '44'
],[
'country_id' => 19,
'name' => 'Chuadanga District',
'iso2' => '12'
],[
'country_id' => 19,
'name' => 'Jhenaidah District',
'iso2' => '23'
],[
'country_id' => 19,
'name' => 'Munshiganj District',
'iso2' => '35'
],[
'country_id' => 19,
'name' => 'Pirojpur District',
'iso2' => '50'
],[
'country_id' => 19,
'name' => 'Gopalganj District',
'iso2' => '17'
],[
'country_id' => 19,
'name' => 'Kurigram District',
'iso2' => '28'
],[
'country_id' => 19,
'name' => 'Moulvibazar District',
'iso2' => '38'
],[
'country_id' => 19,
'name' => 'Gaibandha District',
'iso2' => '19'
],[
'country_id' => 19,
'name' => 'Bagerhat District',
'iso2' => '05'
],[
'country_id' => 19,
'name' => 'Bogra District',
'iso2' => '03'
],[
'country_id' => 19,
'name' => 'Gazipur District',
'iso2' => '18'
],[
'country_id' => 19,
'name' => 'Satkhira District',
'iso2' => '58'
],[
'country_id' => 19,
'name' => 'Panchagarh District',
'iso2' => '52'
],[
'country_id' => 19,
'name' => 'Shariatpur District',
'iso2' => '62'
],[
'country_id' => 19,
'name' => 'Bahadia',
'iso2' => '33'
],[
'country_id' => 19,
'name' => 'Chittagong Division',
'iso2' => 'B'
],[
'country_id' => 19,
'name' => 'Thakurgaon District',
'iso2' => '64'
],[
'country_id' => 19,
'name' => 'Habiganj District',
'iso2' => '20'
],[
'country_id' => 19,
'name' => 'Joypurhat District',
'iso2' => '24'
],[
'country_id' => 19,
'name' => 'Barisal Division',
'iso2' => 'A'
],[
'country_id' => 19,
'name' => 'Jamalpur District',
'iso2' => '21'
],[
'country_id' => 19,
'name' => 'Rangamati Hill District',
'iso2' => '56'
],[
'country_id' => 19,
'name' => 'Brahmanbaria District',
'iso2' => '04'
],[
'country_id' => 19,
'name' => 'Khulna District',
'iso2' => '27'
],[
'country_id' => 19,
'name' => 'Sunamganj District',
'iso2' => '61'
],[
'country_id' => 19,
'name' => 'Rajshahi District',
'iso2' => '54'
],[
'country_id' => 19,
'name' => 'Naogaon District',
'iso2' => '48'
],[
'country_id' => 19,
'name' => 'Noakhali District',
'iso2' => '47'
],[
'country_id' => 19,
'name' => 'Feni District',
'iso2' => '16'
],[
'country_id' => 19,
'name' => 'Madaripur District',
'iso2' => '36'
],[
'country_id' => 19,
'name' => 'Barisal District',
'iso2' => '06'
],[
'country_id' => 19,
'name' => 'Lakshmipur District',
'iso2' => '31'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
