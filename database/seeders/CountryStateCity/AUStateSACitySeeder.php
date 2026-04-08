<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AUStateSACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 207,
'name' => 'Aberfoyle Park'
],[
'state_id' => 207,
'name' => 'Adelaide'
],[
'state_id' => 207,
'name' => 'Adelaide Hills'
],[
'state_id' => 207,
'name' => 'Adelaide city centre'
],[
'state_id' => 207,
'name' => 'Albert Park'
],[
'state_id' => 207,
'name' => 'Alberton'
],[
'state_id' => 207,
'name' => 'Aldgate'
],[
'state_id' => 207,
'name' => 'Aldinga Beach'
],[
'state_id' => 207,
'name' => 'Alexandrina'
],[
'state_id' => 207,
'name' => 'Allenby Gardens'
],[
'state_id' => 207,
'name' => 'Anangu Pitjantjatjara'
],[
'state_id' => 207,
'name' => 'Andrews Farm'
],[
'state_id' => 207,
'name' => 'Angaston'
],[
'state_id' => 207,
'name' => 'Angle Park'
],[
'state_id' => 207,
'name' => 'Angle Vale'
],[
'state_id' => 207,
'name' => 'Ardrossan'
],[
'state_id' => 207,
'name' => 'Ascot Park'
],[
'state_id' => 207,
'name' => 'Ashford'
],[
'state_id' => 207,
'name' => 'Athelstone'
],[
'state_id' => 207,
'name' => 'Athol Park'
],[
'state_id' => 207,
'name' => 'Balaklava'
],[
'state_id' => 207,
'name' => 'Balhannah'
],[
'state_id' => 207,
'name' => 'Banksia Park'
],[
'state_id' => 207,
'name' => 'Barmera'
],[
'state_id' => 207,
'name' => 'Barossa'
],[
'state_id' => 207,
'name' => 'Barunga West'
],[
'state_id' => 207,
'name' => 'Beaumont'
],[
'state_id' => 207,
'name' => 'Bedford Park'
],[
'state_id' => 207,
'name' => 'Belair'
],[
'state_id' => 207,
'name' => 'Bellevue Heights'
],[
'state_id' => 207,
'name' => 'Berri'
],[
'state_id' => 207,
'name' => 'Berri and Barmera'
],[
'state_id' => 207,
'name' => 'Beulah Park'
],[
'state_id' => 207,
'name' => 'Beverley'
],[
'state_id' => 207,
'name' => 'Birdwood'
],[
'state_id' => 207,
'name' => 'Birkenhead'
],[
'state_id' => 207,
'name' => 'Black Forest'
],[
'state_id' => 207,
'name' => 'Blackwood'
],[
'state_id' => 207,
'name' => 'Blair Athol'
],[
'state_id' => 207,
'name' => 'Blakeview'
],[
'state_id' => 207,
'name' => 'Bordertown'
],[
'state_id' => 207,
'name' => 'Brahma Lodge'
],[
'state_id' => 207,
'name' => 'Bridgewater'
],[
'state_id' => 207,
'name' => 'Brighton'
],[
'state_id' => 207,
'name' => 'Broadview'
],[
'state_id' => 207,
'name' => 'Brompton'
],[
'state_id' => 207,
'name' => 'Brooklyn Park'
],[
'state_id' => 207,
'name' => 'Burnside'
],[
'state_id' => 207,
'name' => 'Burra'
],[
'state_id' => 207,
'name' => 'Burton'
],[
'state_id' => 207,
'name' => 'Camden Park'
],[
'state_id' => 207,
'name' => 'Campbelltown'
],[
'state_id' => 207,
'name' => 'Ceduna'
],[
'state_id' => 207,
'name' => 'Charles Sturt'
],[
'state_id' => 207,
'name' => 'Cheltenham'
],[
'state_id' => 207,
'name' => 'Christie Downs'
],[
'state_id' => 207,
'name' => 'Christies Beach'
],[
'state_id' => 207,
'name' => 'City of West Torrens'
],[
'state_id' => 207,
'name' => 'Clapham'
],[
'state_id' => 207,
'name' => 'Clare'
],[
'state_id' => 207,
'name' => 'Clare and Gilbert Valleys'
],[
'state_id' => 207,
'name' => 'Clarence Gardens'
],[
'state_id' => 207,
'name' => 'Clarence Park'
],[
'state_id' => 207,
'name' => 'Clearview'
],[
'state_id' => 207,
'name' => 'Cleve'
],[
'state_id' => 207,
'name' => 'Clovelly Park'
],[
'state_id' => 207,
'name' => 'Collinswood'
],[
'state_id' => 207,
'name' => 'Colonel Light Gardens'
],[
'state_id' => 207,
'name' => 'Coober Pedy'
],[
'state_id' => 207,
'name' => 'Copper Coast'
],[
'state_id' => 207,
'name' => 'Coromandel Valley'
],[
'state_id' => 207,
'name' => 'Cowandilla'
],[
'state_id' => 207,
'name' => 'Cowell'
],[
'state_id' => 207,
'name' => 'Crafers'
],[
'state_id' => 207,
'name' => 'Crafers West'
],[
'state_id' => 207,
'name' => 'Craigburn Farm'
],[
'state_id' => 207,
'name' => 'Craigmore'
],[
'state_id' => 207,
'name' => 'Croydon Park'
],[
'state_id' => 207,
'name' => 'Crystal Brook'
],[
'state_id' => 207,
'name' => 'Cumberland Park'
],[
'state_id' => 207,
'name' => 'Darlington'
],[
'state_id' => 207,
'name' => 'Davoren Park'
],[
'state_id' => 207,
'name' => 'Daw Park'
],[
'state_id' => 207,
'name' => 'Dernancourt'
],[
'state_id' => 207,
'name' => 'Dover Gardens'
],[
'state_id' => 207,
'name' => 'Dulwich'
],[
'state_id' => 207,
'name' => 'Echunga'
],[
'state_id' => 207,
'name' => 'Eden Hills'
],[
'state_id' => 207,
'name' => 'Edwardstown'
],[
'state_id' => 207,
'name' => 'Elizabeth Downs'
],[
'state_id' => 207,
'name' => 'Elizabeth East'
],[
'state_id' => 207,
'name' => 'Elizabeth Grove'
],[
'state_id' => 207,
'name' => 'Elizabeth North'
],[
'state_id' => 207,
'name' => 'Elizabeth Park'
],[
'state_id' => 207,
'name' => 'Elizabeth South'
],[
'state_id' => 207,
'name' => 'Elizabeth Vale'
],[
'state_id' => 207,
'name' => 'Elliston'
],[
'state_id' => 207,
'name' => 'Encounter Bay'
],[
'state_id' => 207,
'name' => 'Enfield'
],[
'state_id' => 207,
'name' => 'Erindale'
],[
'state_id' => 207,
'name' => 'Ethelton'
],[
'state_id' => 207,
'name' => 'Evandale'
],[
'state_id' => 207,
'name' => 'Evanston'
],[
'state_id' => 207,
'name' => 'Evanston Gardens'
],[
'state_id' => 207,
'name' => 'Evanston Park'
],[
'state_id' => 207,
'name' => 'Everard Park'
],[
'state_id' => 207,
'name' => 'Exeter'
],[
'state_id' => 207,
'name' => 'Fairview Park'
],[
'state_id' => 207,
'name' => 'Felixstow'
],[
'state_id' => 207,
'name' => 'Ferryden Park'
],[
'state_id' => 207,
'name' => 'Findon'
],[
'state_id' => 207,
'name' => 'Firle'
],[
'state_id' => 207,
'name' => 'Flagstaff Hill'
],[
'state_id' => 207,
'name' => 'Flinders Park'
],[
'state_id' => 207,
'name' => 'Flinders Ranges'
],[
'state_id' => 207,
'name' => 'Forestville'
],[
'state_id' => 207,
'name' => 'Franklin Harbour'
],[
'state_id' => 207,
'name' => 'Freeling'
],[
'state_id' => 207,
'name' => 'Fulham'
],[
'state_id' => 207,
'name' => 'Fulham Gardens'
],[
'state_id' => 207,
'name' => 'Fullarton'
],[
'state_id' => 207,
'name' => 'Gawler'
],[
'state_id' => 207,
'name' => 'Gawler East'
],[
'state_id' => 207,
'name' => 'Gawler South'
],[
'state_id' => 207,
'name' => 'Gilberton'
],[
'state_id' => 207,
'name' => 'Gilles Plains'
],[
'state_id' => 207,
'name' => 'Glandore'
],[
'state_id' => 207,
'name' => 'Glen Osmond'
],[
'state_id' => 207,
'name' => 'Glenalta'
],[
'state_id' => 207,
'name' => 'Glenelg'
],[
'state_id' => 207,
'name' => 'Glenelg East'
],[
'state_id' => 207,
'name' => 'Glenelg North'
],[
'state_id' => 207,
'name' => 'Glenelg South'
],[
'state_id' => 207,
'name' => 'Glengowrie'
],[
'state_id' => 207,
'name' => 'Glenside'
],[
'state_id' => 207,
'name' => 'Glenunga'
],[
'state_id' => 207,
'name' => 'Glynde'
],[
'state_id' => 207,
'name' => 'Golden Grove'
],[
'state_id' => 207,
'name' => 'Goodwood'
],[
'state_id' => 207,
'name' => 'Goolwa'
],[
'state_id' => 207,
'name' => 'Goolwa Beach'
],[
'state_id' => 207,
'name' => 'Goyder'
],[
'state_id' => 207,
'name' => 'Grange'
],[
'state_id' => 207,
'name' => 'Grant'
],[
'state_id' => 207,
'name' => 'Greenacres'
],[
'state_id' => 207,
'name' => 'Greenock'
],[
'state_id' => 207,
'name' => 'Greenwith'
],[
'state_id' => 207,
'name' => 'Gulfview Heights'
],[
'state_id' => 207,
'name' => 'Hackham'
],[
'state_id' => 207,
'name' => 'Hackham West'
],[
'state_id' => 207,
'name' => 'Hahndorf'
],[
'state_id' => 207,
'name' => 'Hallett Cove'
],[
'state_id' => 207,
'name' => 'Hampstead Gardens'
],[
'state_id' => 207,
'name' => 'Happy Valley'
],[
'state_id' => 207,
'name' => 'Hawthorn'
],[
'state_id' => 207,
'name' => 'Hawthorndene'
],[
'state_id' => 207,
'name' => 'Hayborough'
],[
'state_id' => 207,
'name' => 'Hazelwood Park'
],[
'state_id' => 207,
'name' => 'Hectorville'
],[
'state_id' => 207,
'name' => 'Henley Beach'
],[
'state_id' => 207,
'name' => 'Henley Beach South'
],[
'state_id' => 207,
'name' => 'Hewett'
],[
'state_id' => 207,
'name' => 'Highbury'
],[
'state_id' => 207,
'name' => 'Highgate'
],[
'state_id' => 207,
'name' => 'Hillbank'
],[
'state_id' => 207,
'name' => 'Hillcrest'
],[
'state_id' => 207,
'name' => 'Hindmarsh Island'
],[
'state_id' => 207,
'name' => 'Holden Hill'
],[
'state_id' => 207,
'name' => 'Holdfast Bay'
],[
'state_id' => 207,
'name' => 'Hope Valley'
],[
'state_id' => 207,
'name' => 'Hove'
],[
'state_id' => 207,
'name' => 'Huntfield Heights'
],[
'state_id' => 207,
'name' => 'Hyde Park'
],[
'state_id' => 207,
'name' => 'Ingle Farm'
],[
'state_id' => 207,
'name' => 'Jamestown'
],[
'state_id' => 207,
'name' => 'Joslin'
],[
'state_id' => 207,
'name' => 'Kadina'
],[
'state_id' => 207,
'name' => 'Kangaroo Island'
],[
'state_id' => 207,
'name' => 'Kapunda'
],[
'state_id' => 207,
'name' => 'Karoonda East Murray'
],[
'state_id' => 207,
'name' => 'Keith'
],[
'state_id' => 207,
'name' => 'Kensington Gardens'
],[
'state_id' => 207,
'name' => 'Kensington Park'
],[
'state_id' => 207,
'name' => 'Kent Town'
],[
'state_id' => 207,
'name' => 'Kersbrook'
],[
'state_id' => 207,
'name' => 'Kidman Park'
],[
'state_id' => 207,
'name' => 'Kilburn'
],[
'state_id' => 207,
'name' => 'Kilkenny'
],[
'state_id' => 207,
'name' => 'Kimba'
],[
'state_id' => 207,
'name' => 'Kingscote'
],[
'state_id' => 207,
'name' => 'Kingston'
],[
'state_id' => 207,
'name' => 'Kingston South East'
],[
'state_id' => 207,
'name' => 'Klemzig'
],[
'state_id' => 207,
'name' => 'Kurralta Park'
],[
'state_id' => 207,
'name' => 'Largs Bay'
],[
'state_id' => 207,
'name' => 'Largs North'
],[
'state_id' => 207,
'name' => 'Leabrook'
],[
'state_id' => 207,
'name' => 'Lewiston'
],[
'state_id' => 207,
'name' => 'Light'
],[
'state_id' => 207,
'name' => 'Linden Park'
],[
'state_id' => 207,
'name' => 'Little Hampton'
],[
'state_id' => 207,
'name' => 'Lobethal'
],[
'state_id' => 207,
'name' => 'Lockleys'
],[
'state_id' => 207,
'name' => 'Lower Eyre Peninsula'
],[
'state_id' => 207,
'name' => 'Lower Mitcham'
],[
'state_id' => 207,
'name' => 'Loxton'
],[
'state_id' => 207,
'name' => 'Loxton Waikerie'
],[
'state_id' => 207,
'name' => 'Lyndoch'
],[
'state_id' => 207,
'name' => 'Macclesfield'
],[
'state_id' => 207,
'name' => 'Magill'
],[
'state_id' => 207,
'name' => 'Maitland'
],[
'state_id' => 207,
'name' => 'Mallala'
],[
'state_id' => 207,
'name' => 'Malvern'
],[
'state_id' => 207,
'name' => 'Manningham'
],[
'state_id' => 207,
'name' => 'Mannum'
],[
'state_id' => 207,
'name' => 'Mansfield Park'
],[
'state_id' => 207,
'name' => 'Maralinga Tjarutja'
],[
'state_id' => 207,
'name' => 'Marden'
],[
'state_id' => 207,
'name' => 'Marino'
],[
'state_id' => 207,
'name' => 'Marion'
],[
'state_id' => 207,
'name' => 'Marleston'
],[
'state_id' => 207,
'name' => 'Maslin Beach'
],[
'state_id' => 207,
'name' => 'Mawson Lakes'
],[
'state_id' => 207,
'name' => 'Maylands'
],[
'state_id' => 207,
'name' => 'McCracken'
],[
'state_id' => 207,
'name' => 'McLaren Flat'
],[
'state_id' => 207,
'name' => 'McLaren Vale'
],[
'state_id' => 207,
'name' => 'Meadows'
],[
'state_id' => 207,
'name' => 'Medindie'
],[
'state_id' => 207,
'name' => 'Melrose Park'
],[
'state_id' => 207,
'name' => 'Meningie'
],[
'state_id' => 207,
'name' => 'Mid Murray'
],[
'state_id' => 207,
'name' => 'Middleton'
],[
'state_id' => 207,
'name' => 'Mile End'
],[
'state_id' => 207,
'name' => 'Millicent'
],[
'state_id' => 207,
'name' => 'Millswood'
],[
'state_id' => 207,
'name' => 'Minlaton'
],[
'state_id' => 207,
'name' => 'Mitcham'
],[
'state_id' => 207,
'name' => 'Mitchell Park'
],[
'state_id' => 207,
'name' => 'Moana'
],[
'state_id' => 207,
'name' => 'Modbury'
],[
'state_id' => 207,
'name' => 'Modbury Heights'
],[
'state_id' => 207,
'name' => 'Modbury North'
],[
'state_id' => 207,
'name' => 'Monash'
],[
'state_id' => 207,
'name' => 'Moonta Bay'
],[
'state_id' => 207,
'name' => 'Moorak'
],[
'state_id' => 207,
'name' => 'Morphett Vale'
],[
'state_id' => 207,
'name' => 'Morphettville'
],[
'state_id' => 207,
'name' => 'Mount Barker'
],[
'state_id' => 207,
'name' => 'Mount Compass'
],[
'state_id' => 207,
'name' => 'Mount Gambier'
],[
'state_id' => 207,
'name' => 'Mount Remarkable'
],[
'state_id' => 207,
'name' => 'Munno Para'
],[
'state_id' => 207,
'name' => 'Munno Para West'
],[
'state_id' => 207,
'name' => 'Murray Bridge'
],[
'state_id' => 207,
'name' => 'Mylor'
],[
'state_id' => 207,
'name' => 'Myrtle Bank'
],[
'state_id' => 207,
'name' => 'Nailsworth'
],[
'state_id' => 207,
'name' => 'Nairne'
],[
'state_id' => 207,
'name' => 'Naracoorte'
],[
'state_id' => 207,
'name' => 'Naracoorte and Lucindale'
],[
'state_id' => 207,
'name' => 'Netherby'
],[
'state_id' => 207,
'name' => 'Netley'
],[
'state_id' => 207,
'name' => 'Newton'
],[
'state_id' => 207,
'name' => 'Noarlunga Downs'
],[
'state_id' => 207,
'name' => 'Normanville'
],[
'state_id' => 207,
'name' => 'North Adelaide'
],[
'state_id' => 207,
'name' => 'North Brighton'
],[
'state_id' => 207,
'name' => 'North Haven'
],[
'state_id' => 207,
'name' => 'North Plympton'
],[
'state_id' => 207,
'name' => 'Northern Areas'
],[
'state_id' => 207,
'name' => 'Northfield'
],[
'state_id' => 207,
'name' => 'Northgate'
],[
'state_id' => 207,
'name' => 'Norwood'
],[
'state_id' => 207,
'name' => 'Norwood Payneham St Peters'
],[
'state_id' => 207,
'name' => 'Novar Gardens'
],[
'state_id' => 207,
'name' => 'Nuriootpa'
],[
'state_id' => 207,
'name' => 'O\'Sullivan Beach'
],[
'state_id' => 207,
'name' => 'Oakden'
],[
'state_id' => 207,
'name' => 'Oaklands Park'
],[
'state_id' => 207,
'name' => 'Old Noarlunga'
],[
'state_id' => 207,
'name' => 'Old Reynella'
],[
'state_id' => 207,
'name' => 'One Tree Hill'
],[
'state_id' => 207,
'name' => 'Onkaparinga'
],[
'state_id' => 207,
'name' => 'Onkaparinga Hills'
],[
'state_id' => 207,
'name' => 'Orroroo/Carrieton'
],[
'state_id' => 207,
'name' => 'Osborne'
],[
'state_id' => 207,
'name' => 'Ottoway'
],[
'state_id' => 207,
'name' => 'O’Halloran Hill'
],[
'state_id' => 207,
'name' => 'Panorama'
],[
'state_id' => 207,
'name' => 'Para Hills'
],[
'state_id' => 207,
'name' => 'Para Hills West'
],[
'state_id' => 207,
'name' => 'Para Vista'
],[
'state_id' => 207,
'name' => 'Paradise'
],[
'state_id' => 207,
'name' => 'Parafield Gardens'
],[
'state_id' => 207,
'name' => 'Paralowie'
],[
'state_id' => 207,
'name' => 'Paringa'
],[
'state_id' => 207,
'name' => 'Park Holme'
],[
'state_id' => 207,
'name' => 'Parkside'
],[
'state_id' => 207,
'name' => 'Pasadena'
],[
'state_id' => 207,
'name' => 'Payneham'
],[
'state_id' => 207,
'name' => 'Payneham South'
],[
'state_id' => 207,
'name' => 'Pennington'
],[
'state_id' => 207,
'name' => 'Penola'
],[
'state_id' => 207,
'name' => 'Peterborough'
],[
'state_id' => 207,
'name' => 'Peterhead'
],[
'state_id' => 207,
'name' => 'Playford'
],[
'state_id' => 207,
'name' => 'Plympton'
],[
'state_id' => 207,
'name' => 'Plympton Park'
],[
'state_id' => 207,
'name' => 'Pooraka'
],[
'state_id' => 207,
'name' => 'Port Adelaide'
],[
'state_id' => 207,
'name' => 'Port Adelaide Enfield'
],[
'state_id' => 207,
'name' => 'Port Augusta'
],[
'state_id' => 207,
'name' => 'Port Augusta West'
],[
'state_id' => 207,
'name' => 'Port Broughton'
],[
'state_id' => 207,
'name' => 'Port Elliot'
],[
'state_id' => 207,
'name' => 'Port Lincoln'
],[
'state_id' => 207,
'name' => 'Port Noarlunga'
],[
'state_id' => 207,
'name' => 'Port Noarlunga South'
],[
'state_id' => 207,
'name' => 'Port Pirie'
],[
'state_id' => 207,
'name' => 'Port Pirie City and Dists'
],[
'state_id' => 207,
'name' => 'Port Pirie South'
],[
'state_id' => 207,
'name' => 'Port Pirie West'
],[
'state_id' => 207,
'name' => 'Port Willunga'
],[
'state_id' => 207,
'name' => 'Prospect'
],[
'state_id' => 207,
'name' => 'Queenstown'
],[
'state_id' => 207,
'name' => 'Quorn'
],[
'state_id' => 207,
'name' => 'Redwood Park'
],[
'state_id' => 207,
'name' => 'Renmark'
],[
'state_id' => 207,
'name' => 'Renmark Paringa'
],[
'state_id' => 207,
'name' => 'Renmark West'
],[
'state_id' => 207,
'name' => 'Renown Park'
],[
'state_id' => 207,
'name' => 'Reynella'
],[
'state_id' => 207,
'name' => 'Reynella East'
],[
'state_id' => 207,
'name' => 'Richmond'
],[
'state_id' => 207,
'name' => 'Ridgehaven'
],[
'state_id' => 207,
'name' => 'Ridleyton'
],[
'state_id' => 207,
'name' => 'Risdon Park'
],[
'state_id' => 207,
'name' => 'Risdon Park South'
],[
'state_id' => 207,
'name' => 'Robe'
],[
'state_id' => 207,
'name' => 'Rose Park'
],[
'state_id' => 207,
'name' => 'Rosewater'
],[
'state_id' => 207,
'name' => 'Rosslyn Park'
],[
'state_id' => 207,
'name' => 'Rostrevor'
],[
'state_id' => 207,
'name' => 'Roxby Downs'
],[
'state_id' => 207,
'name' => 'Royal Park'
],[
'state_id' => 207,
'name' => 'Royston Park'
],[
'state_id' => 207,
'name' => 'Salisbury'
],[
'state_id' => 207,
'name' => 'Salisbury Downs'
],[
'state_id' => 207,
'name' => 'Salisbury East'
],[
'state_id' => 207,
'name' => 'Salisbury Heights'
],[
'state_id' => 207,
'name' => 'Salisbury North'
],[
'state_id' => 207,
'name' => 'Salisbury Park'
],[
'state_id' => 207,
'name' => 'Salisbury Plain'
],[
'state_id' => 207,
'name' => 'Seacliff'
],[
'state_id' => 207,
'name' => 'Seacliff Park'
],[
'state_id' => 207,
'name' => 'Seacombe Gardens'
],[
'state_id' => 207,
'name' => 'Seacombe Heights'
],[
'state_id' => 207,
'name' => 'Seaford'
],[
'state_id' => 207,
'name' => 'Seaford Meadows'
],[
'state_id' => 207,
'name' => 'Seaford Rise'
],[
'state_id' => 207,
'name' => 'Seaton'
],[
'state_id' => 207,
'name' => 'Seaview Downs'
],[
'state_id' => 207,
'name' => 'Sefton Park'
],[
'state_id' => 207,
'name' => 'Sellicks Beach'
],[
'state_id' => 207,
'name' => 'Semaphore'
],[
'state_id' => 207,
'name' => 'Semaphore Park'
],[
'state_id' => 207,
'name' => 'Semaphore South'
],[
'state_id' => 207,
'name' => 'Sheidow Park'
],[
'state_id' => 207,
'name' => 'Smithfield'
],[
'state_id' => 207,
'name' => 'Smithfield Plains'
],[
'state_id' => 207,
'name' => 'Solomontown'
],[
'state_id' => 207,
'name' => 'Somerton Park'
],[
'state_id' => 207,
'name' => 'South Brighton'
],[
'state_id' => 207,
'name' => 'South Plympton'
],[
'state_id' => 207,
'name' => 'Southern Mallee'
],[
'state_id' => 207,
'name' => 'St Agnes'
],[
'state_id' => 207,
'name' => 'St Georges'
],[
'state_id' => 207,
'name' => 'St Marys'
],[
'state_id' => 207,
'name' => 'St Morris'
],[
'state_id' => 207,
'name' => 'St Peters'
],[
'state_id' => 207,
'name' => 'Stirling'
],[
'state_id' => 207,
'name' => 'Stirling North'
],[
'state_id' => 207,
'name' => 'Stonyfell'
],[
'state_id' => 207,
'name' => 'Strathalbyn'
],[
'state_id' => 207,
'name' => 'Streaky Bay'
],[
'state_id' => 207,
'name' => 'Sturt'
],[
'state_id' => 207,
'name' => 'Surrey Downs'
],[
'state_id' => 207,
'name' => 'Tailem Bend'
],[
'state_id' => 207,
'name' => 'Tanunda'
],[
'state_id' => 207,
'name' => 'Taperoo'
],[
'state_id' => 207,
'name' => 'Tatiara'
],[
'state_id' => 207,
'name' => 'Tea Tree Gully'
],[
'state_id' => 207,
'name' => 'Tennyson'
],[
'state_id' => 207,
'name' => 'The Coorong'
],[
'state_id' => 207,
'name' => 'Thebarton'
],[
'state_id' => 207,
'name' => 'Toorak Gardens'
],[
'state_id' => 207,
'name' => 'Torrens Park'
],[
'state_id' => 207,
'name' => 'Torrensville'
],[
'state_id' => 207,
'name' => 'Tranmere'
],[
'state_id' => 207,
'name' => 'Trinity Gardens'
],[
'state_id' => 207,
'name' => 'Trott Park'
],[
'state_id' => 207,
'name' => 'Tumby Bay'
],[
'state_id' => 207,
'name' => 'Tusmore'
],[
'state_id' => 207,
'name' => 'Two Wells'
],[
'state_id' => 207,
'name' => 'Underdale'
],[
'state_id' => 207,
'name' => 'Unley'
],[
'state_id' => 207,
'name' => 'Unley Park'
],[
'state_id' => 207,
'name' => 'Vale Park'
],[
'state_id' => 207,
'name' => 'Valley View'
],[
'state_id' => 207,
'name' => 'Victor Harbor'
],[
'state_id' => 207,
'name' => 'Virginia'
],[
'state_id' => 207,
'name' => 'Waikerie'
],[
'state_id' => 207,
'name' => 'Wakefield'
],[
'state_id' => 207,
'name' => 'Walkerville'
],[
'state_id' => 207,
'name' => 'Walkley Heights'
],[
'state_id' => 207,
'name' => 'Wallaroo'
],[
'state_id' => 207,
'name' => 'Warradale'
],[
'state_id' => 207,
'name' => 'Waterloo Corner'
],[
'state_id' => 207,
'name' => 'Wattle Park'
],[
'state_id' => 207,
'name' => 'Wattle Range'
],[
'state_id' => 207,
'name' => 'Wayville'
],[
'state_id' => 207,
'name' => 'West Beach'
],[
'state_id' => 207,
'name' => 'West Croydon'
],[
'state_id' => 207,
'name' => 'West Hindmarsh'
],[
'state_id' => 207,
'name' => 'West Lakes'
],[
'state_id' => 207,
'name' => 'West Lakes Shore'
],[
'state_id' => 207,
'name' => 'Westbourne Park'
],[
'state_id' => 207,
'name' => 'Whyalla'
],[
'state_id' => 207,
'name' => 'Whyalla Jenkins'
],[
'state_id' => 207,
'name' => 'Whyalla Norrie'
],[
'state_id' => 207,
'name' => 'Whyalla Playford'
],[
'state_id' => 207,
'name' => 'Whyalla Stuart'
],[
'state_id' => 207,
'name' => 'Willaston'
],[
'state_id' => 207,
'name' => 'Williamstown'
],[
'state_id' => 207,
'name' => 'Willunga'
],[
'state_id' => 207,
'name' => 'Windsor Gardens'
],[
'state_id' => 207,
'name' => 'Woodcroft'
],[
'state_id' => 207,
'name' => 'Woodside'
],[
'state_id' => 207,
'name' => 'Woodville'
],[
'state_id' => 207,
'name' => 'Woodville Gardens'
],[
'state_id' => 207,
'name' => 'Woodville North'
],[
'state_id' => 207,
'name' => 'Woodville Park'
],[
'state_id' => 207,
'name' => 'Woodville South'
],[
'state_id' => 207,
'name' => 'Woodville West'
],[
'state_id' => 207,
'name' => 'Wudinna'
],[
'state_id' => 207,
'name' => 'Wynn Vale'
],[
'state_id' => 207,
'name' => 'Yankalilla'
],[
'state_id' => 207,
'name' => 'Yorke Peninsula'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
