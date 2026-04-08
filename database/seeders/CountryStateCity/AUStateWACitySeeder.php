<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AUStateWACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 209,
'name' => 'Abbey'
],[
'state_id' => 209,
'name' => 'Albany'
],[
'state_id' => 209,
'name' => 'Albany city centre'
],[
'state_id' => 209,
'name' => 'Alexander Heights'
],[
'state_id' => 209,
'name' => 'Alfred Cove'
],[
'state_id' => 209,
'name' => 'Alkimos'
],[
'state_id' => 209,
'name' => 'Applecross'
],[
'state_id' => 209,
'name' => 'Ardross'
],[
'state_id' => 209,
'name' => 'Armadale'
],[
'state_id' => 209,
'name' => 'Ascot'
],[
'state_id' => 209,
'name' => 'Ashburton'
],[
'state_id' => 209,
'name' => 'Ashby'
],[
'state_id' => 209,
'name' => 'Ashfield'
],[
'state_id' => 209,
'name' => 'Attadale'
],[
'state_id' => 209,
'name' => 'Atwell'
],[
'state_id' => 209,
'name' => 'Aubin Grove'
],[
'state_id' => 209,
'name' => 'Augusta'
],[
'state_id' => 209,
'name' => 'Augusta-Margaret River Shire'
],[
'state_id' => 209,
'name' => 'Australind'
],[
'state_id' => 209,
'name' => 'Aveley'
],[
'state_id' => 209,
'name' => 'Bakers Hill'
],[
'state_id' => 209,
'name' => 'Balcatta'
],[
'state_id' => 209,
'name' => 'Baldivis'
],[
'state_id' => 209,
'name' => 'Balga'
],[
'state_id' => 209,
'name' => 'Ballajura'
],[
'state_id' => 209,
'name' => 'Banjup'
],[
'state_id' => 209,
'name' => 'Banksia Grove'
],[
'state_id' => 209,
'name' => 'Bassendean'
],[
'state_id' => 209,
'name' => 'Bateman'
],[
'state_id' => 209,
'name' => 'Baynton'
],[
'state_id' => 209,
'name' => 'Bayonet Head'
],[
'state_id' => 209,
'name' => 'Bayswater'
],[
'state_id' => 209,
'name' => 'Beachlands'
],[
'state_id' => 209,
'name' => 'Beaconsfield'
],[
'state_id' => 209,
'name' => 'Beckenham'
],[
'state_id' => 209,
'name' => 'Bedford'
],[
'state_id' => 209,
'name' => 'Bedfordale'
],[
'state_id' => 209,
'name' => 'Beechboro'
],[
'state_id' => 209,
'name' => 'Beeliar'
],[
'state_id' => 209,
'name' => 'Beldon'
],[
'state_id' => 209,
'name' => 'Bellevue'
],[
'state_id' => 209,
'name' => 'Belmont'
],[
'state_id' => 209,
'name' => 'Bennett Springs'
],[
'state_id' => 209,
'name' => 'Bentley'
],[
'state_id' => 209,
'name' => 'Beresford'
],[
'state_id' => 209,
'name' => 'Bertram'
],[
'state_id' => 209,
'name' => 'Beverley'
],[
'state_id' => 209,
'name' => 'Bibra Lake'
],[
'state_id' => 209,
'name' => 'Bicton'
],[
'state_id' => 209,
'name' => 'Bilingurr'
],[
'state_id' => 209,
'name' => 'Bindoon'
],[
'state_id' => 209,
'name' => 'Binningup'
],[
'state_id' => 209,
'name' => 'Bluff Point'
],[
'state_id' => 209,
'name' => 'Boddington'
],[
'state_id' => 209,
'name' => 'Booragoon'
],[
'state_id' => 209,
'name' => 'Boulder'
],[
'state_id' => 209,
'name' => 'Boyanup'
],[
'state_id' => 209,
'name' => 'Boyup Brook'
],[
'state_id' => 209,
'name' => 'Brabham'
],[
'state_id' => 209,
'name' => 'Brentwood'
],[
'state_id' => 209,
'name' => 'Bridgetown'
],[
'state_id' => 209,
'name' => 'Bridgetown-Greenbushes'
],[
'state_id' => 209,
'name' => 'Broadwater'
],[
'state_id' => 209,
'name' => 'Brockman'
],[
'state_id' => 209,
'name' => 'Brookdale'
],[
'state_id' => 209,
'name' => 'Brookton'
],[
'state_id' => 209,
'name' => 'Broome'
],[
'state_id' => 209,
'name' => 'Broomehill-Tambellup'
],[
'state_id' => 209,
'name' => 'Bruce Rock'
],[
'state_id' => 209,
'name' => 'Brunswick'
],[
'state_id' => 209,
'name' => 'Bulgarra'
],[
'state_id' => 209,
'name' => 'Bull Creek'
],[
'state_id' => 209,
'name' => 'Bullsbrook'
],[
'state_id' => 209,
'name' => 'Bunbury'
],[
'state_id' => 209,
'name' => 'Burns Beach'
],[
'state_id' => 209,
'name' => 'Burswood'
],[
'state_id' => 209,
'name' => 'Busselton'
],[
'state_id' => 209,
'name' => 'Busselton city cenre'
],[
'state_id' => 209,
'name' => 'Butler'
],[
'state_id' => 209,
'name' => 'Byford'
],[
'state_id' => 209,
'name' => 'Cable Beach'
],[
'state_id' => 209,
'name' => 'Calista'
],[
'state_id' => 209,
'name' => 'Cambridge'
],[
'state_id' => 209,
'name' => 'Camillo'
],[
'state_id' => 209,
'name' => 'Canning'
],[
'state_id' => 209,
'name' => 'Canning Vale'
],[
'state_id' => 209,
'name' => 'Cannington'
],[
'state_id' => 209,
'name' => 'Capel'
],[
'state_id' => 209,
'name' => 'Cardup'
],[
'state_id' => 209,
'name' => 'Carey Park'
],[
'state_id' => 209,
'name' => 'Carine'
],[
'state_id' => 209,
'name' => 'Carlisle'
],[
'state_id' => 209,
'name' => 'Carnamah'
],[
'state_id' => 209,
'name' => 'Carnarvon'
],[
'state_id' => 209,
'name' => 'Carramar'
],[
'state_id' => 209,
'name' => 'Castletown'
],[
'state_id' => 209,
'name' => 'Casuarina'
],[
'state_id' => 209,
'name' => 'Caversham'
],[
'state_id' => 209,
'name' => 'Champion Lakes'
],[
'state_id' => 209,
'name' => 'Chapman Valley'
],[
'state_id' => 209,
'name' => 'Chidlow'
],[
'state_id' => 209,
'name' => 'Chittering'
],[
'state_id' => 209,
'name' => 'Churchlands'
],[
'state_id' => 209,
'name' => 'City Beach'
],[
'state_id' => 209,
'name' => 'City of Cockburn'
],[
'state_id' => 209,
'name' => 'City of Perth'
],[
'state_id' => 209,
'name' => 'Claremont'
],[
'state_id' => 209,
'name' => 'Clarkson'
],[
'state_id' => 209,
'name' => 'Cloverdale'
],[
'state_id' => 209,
'name' => 'Cockburn Central'
],[
'state_id' => 209,
'name' => 'College Grove'
],[
'state_id' => 209,
'name' => 'Collie'
],[
'state_id' => 209,
'name' => 'Como'
],[
'state_id' => 209,
'name' => 'Connolly'
],[
'state_id' => 209,
'name' => 'Coodanup'
],[
'state_id' => 209,
'name' => 'Coogee'
],[
'state_id' => 209,
'name' => 'Coolbellup'
],[
'state_id' => 209,
'name' => 'Coolbinia'
],[
'state_id' => 209,
'name' => 'Coolgardie'
],[
'state_id' => 209,
'name' => 'Cooloongup'
],[
'state_id' => 209,
'name' => 'Coorow'
],[
'state_id' => 209,
'name' => 'Corrigin'
],[
'state_id' => 209,
'name' => 'Cottesloe'
],[
'state_id' => 209,
'name' => 'Cowaramup'
],[
'state_id' => 209,
'name' => 'Craigie'
],[
'state_id' => 209,
'name' => 'Cranbrook'
],[
'state_id' => 209,
'name' => 'Crawley'
],[
'state_id' => 209,
'name' => 'Cuballing'
],[
'state_id' => 209,
'name' => 'Cue'
],[
'state_id' => 209,
'name' => 'Cunderdin'
],[
'state_id' => 209,
'name' => 'Currambine'
],[
'state_id' => 209,
'name' => 'Daglish'
],[
'state_id' => 209,
'name' => 'Dalkeith'
],[
'state_id' => 209,
'name' => 'Dalwallinu'
],[
'state_id' => 209,
'name' => 'Dalyellup'
],[
'state_id' => 209,
'name' => 'Dampier'
],[
'state_id' => 209,
'name' => 'Dampier Peninsula'
],[
'state_id' => 209,
'name' => 'Dandaragan'
],[
'state_id' => 209,
'name' => 'Darch'
],[
'state_id' => 209,
'name' => 'Dardanup'
],[
'state_id' => 209,
'name' => 'Darling Downs'
],[
'state_id' => 209,
'name' => 'Darlington'
],[
'state_id' => 209,
'name' => 'Dawesville'
],[
'state_id' => 209,
'name' => 'Dayton'
],[
'state_id' => 209,
'name' => 'Denham'
],[
'state_id' => 209,
'name' => 'Denmark'
],[
'state_id' => 209,
'name' => 'Derby'
],[
'state_id' => 209,
'name' => 'Derby-West Kimberley'
],[
'state_id' => 209,
'name' => 'Dianella'
],[
'state_id' => 209,
'name' => 'Djugun'
],[
'state_id' => 209,
'name' => 'Dongara'
],[
'state_id' => 209,
'name' => 'Donnybrook'
],[
'state_id' => 209,
'name' => 'Donnybrook-Balingup'
],[
'state_id' => 209,
'name' => 'Doubleview'
],[
'state_id' => 209,
'name' => 'Dowerin'
],[
'state_id' => 209,
'name' => 'Drummond Cove'
],[
'state_id' => 209,
'name' => 'Dudley Park'
],[
'state_id' => 209,
'name' => 'Dumbleyung Shire'
],[
'state_id' => 209,
'name' => 'Duncraig'
],[
'state_id' => 209,
'name' => 'Dundas'
],[
'state_id' => 209,
'name' => 'Dunsborough'
],[
'state_id' => 209,
'name' => 'East Bunbury'
],[
'state_id' => 209,
'name' => 'East Cannington'
],[
'state_id' => 209,
'name' => 'East Carnarvon'
],[
'state_id' => 209,
'name' => 'East Fremantle'
],[
'state_id' => 209,
'name' => 'East Perth'
],[
'state_id' => 209,
'name' => 'East Pilbara'
],[
'state_id' => 209,
'name' => 'East Victoria Park'
],[
'state_id' => 209,
'name' => 'Eaton'
],[
'state_id' => 209,
'name' => 'Eden Hill'
],[
'state_id' => 209,
'name' => 'Edgewater'
],[
'state_id' => 209,
'name' => 'Eglinton'
],[
'state_id' => 209,
'name' => 'Ellenbrook'
],[
'state_id' => 209,
'name' => 'Embleton'
],[
'state_id' => 209,
'name' => 'Erskine'
],[
'state_id' => 209,
'name' => 'Esperance'
],[
'state_id' => 209,
'name' => 'Esperance Shire'
],[
'state_id' => 209,
'name' => 'Exmouth'
],[
'state_id' => 209,
'name' => 'Falcon'
],[
'state_id' => 209,
'name' => 'Ferndale'
],[
'state_id' => 209,
'name' => 'Fitzroy Crossing'
],[
'state_id' => 209,
'name' => 'Floreat'
],[
'state_id' => 209,
'name' => 'Forrestdale'
],[
'state_id' => 209,
'name' => 'Forrestfield'
],[
'state_id' => 209,
'name' => 'Fremantle'
],[
'state_id' => 209,
'name' => 'Garden Island'
],[
'state_id' => 209,
'name' => 'Gelorup'
],[
'state_id' => 209,
'name' => 'Geographe'
],[
'state_id' => 209,
'name' => 'Geraldton'
],[
'state_id' => 209,
'name' => 'Geraldton city centre'
],[
'state_id' => 209,
'name' => 'Gidgegannup'
],[
'state_id' => 209,
'name' => 'Gingin'
],[
'state_id' => 209,
'name' => 'Girrawheen'
],[
'state_id' => 209,
'name' => 'Glen Forrest'
],[
'state_id' => 209,
'name' => 'Glen Iris'
],[
'state_id' => 209,
'name' => 'Glendalough'
],[
'state_id' => 209,
'name' => 'Gnangara'
],[
'state_id' => 209,
'name' => 'Gnowangerup'
],[
'state_id' => 209,
'name' => 'Golden Bay'
],[
'state_id' => 209,
'name' => 'Goomalling'
],[
'state_id' => 209,
'name' => 'Gooseberry Hill'
],[
'state_id' => 209,
'name' => 'Gosnells'
],[
'state_id' => 209,
'name' => 'Grasmere'
],[
'state_id' => 209,
'name' => 'Greenfields'
],[
'state_id' => 209,
'name' => 'Greenmount'
],[
'state_id' => 209,
'name' => 'Greenwood'
],[
'state_id' => 209,
'name' => 'Guildford'
],[
'state_id' => 209,
'name' => 'Gwelup'
],[
'state_id' => 209,
'name' => 'Halls Creek'
],[
'state_id' => 209,
'name' => 'Halls Head'
],[
'state_id' => 209,
'name' => 'Hamersley'
],[
'state_id' => 209,
'name' => 'Hamilton Hill'
],[
'state_id' => 209,
'name' => 'Hammond Park'
],[
'state_id' => 209,
'name' => 'Hannans'
],[
'state_id' => 209,
'name' => 'Harrisdale'
],[
'state_id' => 209,
'name' => 'Harvey'
],[
'state_id' => 209,
'name' => 'Heathridge'
],[
'state_id' => 209,
'name' => 'Helena Valley'
],[
'state_id' => 209,
'name' => 'Henley Brook'
],[
'state_id' => 209,
'name' => 'Herne Hill'
],[
'state_id' => 209,
'name' => 'High Wycombe'
],[
'state_id' => 209,
'name' => 'Highgate'
],[
'state_id' => 209,
'name' => 'Hilbert'
],[
'state_id' => 209,
'name' => 'Hillarys'
],[
'state_id' => 209,
'name' => 'Hillman'
],[
'state_id' => 209,
'name' => 'Hilton'
],[
'state_id' => 209,
'name' => 'Hocking'
],[
'state_id' => 209,
'name' => 'Huntingdale'
],[
'state_id' => 209,
'name' => 'Iluka'
],[
'state_id' => 209,
'name' => 'Inglewood'
],[
'state_id' => 209,
'name' => 'Innaloo'
],[
'state_id' => 209,
'name' => 'Irwin'
],[
'state_id' => 209,
'name' => 'Jandakot'
],[
'state_id' => 209,
'name' => 'Jane Brook'
],[
'state_id' => 209,
'name' => 'Jarrahdale'
],[
'state_id' => 209,
'name' => 'Jerramungup'
],[
'state_id' => 209,
'name' => 'Jindalee'
],[
'state_id' => 209,
'name' => 'Jolimont'
],[
'state_id' => 209,
'name' => 'Joondalup'
],[
'state_id' => 209,
'name' => 'Joondanna'
],[
'state_id' => 209,
'name' => 'Jurien Bay'
],[
'state_id' => 209,
'name' => 'Kalamunda'
],[
'state_id' => 209,
'name' => 'Kalbarri'
],[
'state_id' => 209,
'name' => 'Kalgoorlie'
],[
'state_id' => 209,
'name' => 'Kalgoorlie/Boulder'
],[
'state_id' => 209,
'name' => 'Kallaroo'
],[
'state_id' => 209,
'name' => 'Kambalda East'
],[
'state_id' => 209,
'name' => 'Kambalda West'
],[
'state_id' => 209,
'name' => 'Karawara'
],[
'state_id' => 209,
'name' => 'Kardinya'
],[
'state_id' => 209,
'name' => 'Karnup'
],[
'state_id' => 209,
'name' => 'Karratha'
],[
'state_id' => 209,
'name' => 'Karrinyup'
],[
'state_id' => 209,
'name' => 'Katanning'
],[
'state_id' => 209,
'name' => 'Kellerberrin'
],[
'state_id' => 209,
'name' => 'Kelmscott'
],[
'state_id' => 209,
'name' => 'Kent Shire'
],[
'state_id' => 209,
'name' => 'Kenwick'
],[
'state_id' => 209,
'name' => 'Kewdale'
],[
'state_id' => 209,
'name' => 'Kiara'
],[
'state_id' => 209,
'name' => 'Kingsley'
],[
'state_id' => 209,
'name' => 'Kinross'
],[
'state_id' => 209,
'name' => 'Kojonup'
],[
'state_id' => 209,
'name' => 'Kondinin'
],[
'state_id' => 209,
'name' => 'Koondoola'
],[
'state_id' => 209,
'name' => 'Koorda'
],[
'state_id' => 209,
'name' => 'Kulin'
],[
'state_id' => 209,
'name' => 'Kununurra'
],[
'state_id' => 209,
'name' => 'Kwinana'
],[
'state_id' => 209,
'name' => 'Lake Grace'
],[
'state_id' => 209,
'name' => 'Lakelands'
],[
'state_id' => 209,
'name' => 'Lamington'
],[
'state_id' => 209,
'name' => 'Landsdale'
],[
'state_id' => 209,
'name' => 'Langford'
],[
'state_id' => 209,
'name' => 'Lathlain'
],[
'state_id' => 209,
'name' => 'Laverton'
],[
'state_id' => 209,
'name' => 'Leda'
],[
'state_id' => 209,
'name' => 'Leederville'
],[
'state_id' => 209,
'name' => 'Leeming'
],[
'state_id' => 209,
'name' => 'Leinster'
],[
'state_id' => 209,
'name' => 'Leonora'
],[
'state_id' => 209,
'name' => 'Leschenault'
],[
'state_id' => 209,
'name' => 'Lesmurdie'
],[
'state_id' => 209,
'name' => 'Little Grove'
],[
'state_id' => 209,
'name' => 'Lockridge'
],[
'state_id' => 209,
'name' => 'Lockyer'
],[
'state_id' => 209,
'name' => 'Lower Chittering'
],[
'state_id' => 209,
'name' => 'Lower King'
],[
'state_id' => 209,
'name' => 'Lynwood'
],[
'state_id' => 209,
'name' => 'Maddington'
],[
'state_id' => 209,
'name' => 'Madeley'
],[
'state_id' => 209,
'name' => 'Madora Bay'
],[
'state_id' => 209,
'name' => 'Maida Vale'
],[
'state_id' => 209,
'name' => 'Mandurah'
],[
'state_id' => 209,
'name' => 'Mandurah city centre'
],[
'state_id' => 209,
'name' => 'Manjimup'
],[
'state_id' => 209,
'name' => 'Manning'
],[
'state_id' => 209,
'name' => 'Marangaroo'
],[
'state_id' => 209,
'name' => 'Marble Bar'
],[
'state_id' => 209,
'name' => 'Margaret River'
],[
'state_id' => 209,
'name' => 'Marmion'
],[
'state_id' => 209,
'name' => 'Martin'
],[
'state_id' => 209,
'name' => 'Maylands'
],[
'state_id' => 209,
'name' => 'McKail'
],[
'state_id' => 209,
'name' => 'Meadow Springs'
],[
'state_id' => 209,
'name' => 'Medina'
],[
'state_id' => 209,
'name' => 'Meekatharra'
],[
'state_id' => 209,
'name' => 'Melville'
],[
'state_id' => 209,
'name' => 'Menora'
],[
'state_id' => 209,
'name' => 'Menzies'
],[
'state_id' => 209,
'name' => 'Merredin'
],[
'state_id' => 209,
'name' => 'Merriwa'
],[
'state_id' => 209,
'name' => 'Middle Swan'
],[
'state_id' => 209,
'name' => 'Midland'
],[
'state_id' => 209,
'name' => 'Midvale'
],[
'state_id' => 209,
'name' => 'Millars Well'
],[
'state_id' => 209,
'name' => 'Millbridge'
],[
'state_id' => 209,
'name' => 'Mindarie'
],[
'state_id' => 209,
'name' => 'Mingenew'
],[
'state_id' => 209,
'name' => 'Mira Mar'
],[
'state_id' => 209,
'name' => 'Mirrabooka'
],[
'state_id' => 209,
'name' => 'Moora'
],[
'state_id' => 209,
'name' => 'Morawa'
],[
'state_id' => 209,
'name' => 'Morley'
],[
'state_id' => 209,
'name' => 'Mosman Park'
],[
'state_id' => 209,
'name' => 'Mount Barker'
],[
'state_id' => 209,
'name' => 'Mount Claremont'
],[
'state_id' => 209,
'name' => 'Mount Hawthorn'
],[
'state_id' => 209,
'name' => 'Mount Helena'
],[
'state_id' => 209,
'name' => 'Mount Lawley'
],[
'state_id' => 209,
'name' => 'Mount Magnet'
],[
'state_id' => 209,
'name' => 'Mount Marshall'
],[
'state_id' => 209,
'name' => 'Mount Melville'
],[
'state_id' => 209,
'name' => 'Mount Nasura'
],[
'state_id' => 209,
'name' => 'Mount Pleasant'
],[
'state_id' => 209,
'name' => 'Mount Richon'
],[
'state_id' => 209,
'name' => 'Mount Tarcoola'
],[
'state_id' => 209,
'name' => 'Mukinbudin'
],[
'state_id' => 209,
'name' => 'Mullaloo'
],[
'state_id' => 209,
'name' => 'Mundaring'
],[
'state_id' => 209,
'name' => 'Mundijong'
],[
'state_id' => 209,
'name' => 'Munster'
],[
'state_id' => 209,
'name' => 'Murchison'
],[
'state_id' => 209,
'name' => 'Murdoch'
],[
'state_id' => 209,
'name' => 'Murray'
],[
'state_id' => 209,
'name' => 'Myaree'
],[
'state_id' => 209,
'name' => 'Nannup'
],[
'state_id' => 209,
'name' => 'Narembeen'
],[
'state_id' => 209,
'name' => 'Narrogin'
],[
'state_id' => 209,
'name' => 'Nedlands'
],[
'state_id' => 209,
'name' => 'Newman'
],[
'state_id' => 209,
'name' => 'Ngaanyatjarraku'
],[
'state_id' => 209,
'name' => 'Nickol'
],[
'state_id' => 209,
'name' => 'Nollamara'
],[
'state_id' => 209,
'name' => 'Noranda'
],[
'state_id' => 209,
'name' => 'North Beach'
],[
'state_id' => 209,
'name' => 'North Coogee'
],[
'state_id' => 209,
'name' => 'North Fremantle'
],[
'state_id' => 209,
'name' => 'North Lake'
],[
'state_id' => 209,
'name' => 'North Perth'
],[
'state_id' => 209,
'name' => 'Northam'
],[
'state_id' => 209,
'name' => 'Northampton Shire'
],[
'state_id' => 209,
'name' => 'Northbridge'
],[
'state_id' => 209,
'name' => 'Nullagine'
],[
'state_id' => 209,
'name' => 'Nulsen'
],[
'state_id' => 209,
'name' => 'Nungarin'
],[
'state_id' => 209,
'name' => 'Oakford'
],[
'state_id' => 209,
'name' => 'Ocean Reef'
],[
'state_id' => 209,
'name' => 'Onslow'
],[
'state_id' => 209,
'name' => 'Orana'
],[
'state_id' => 209,
'name' => 'Orelia'
],[
'state_id' => 209,
'name' => 'Osborne Park'
],[
'state_id' => 209,
'name' => 'Padbury'
],[
'state_id' => 209,
'name' => 'Palmyra'
],[
'state_id' => 209,
'name' => 'Paraburdoo'
],[
'state_id' => 209,
'name' => 'Parkerville'
],[
'state_id' => 209,
'name' => 'Parkwood'
],[
'state_id' => 209,
'name' => 'Parmelia'
],[
'state_id' => 209,
'name' => 'Pearce'
],[
'state_id' => 209,
'name' => 'Pearsall'
],[
'state_id' => 209,
'name' => 'Pegs Creek'
],[
'state_id' => 209,
'name' => 'Pemberton'
],[
'state_id' => 209,
'name' => 'Peppermint Grove'
],[
'state_id' => 209,
'name' => 'Perenjori'
],[
'state_id' => 209,
'name' => 'Perth'
],[
'state_id' => 209,
'name' => 'Perth city centre'
],[
'state_id' => 209,
'name' => 'Piara Waters'
],[
'state_id' => 209,
'name' => 'Piccadilly'
],[
'state_id' => 209,
'name' => 'Pingelly'
],[
'state_id' => 209,
'name' => 'Pinjarra'
],[
'state_id' => 209,
'name' => 'Plantagenet Shire'
],[
'state_id' => 209,
'name' => 'Port Denison'
],[
'state_id' => 209,
'name' => 'Port Hedland'
],[
'state_id' => 209,
'name' => 'Port Kennedy'
],[
'state_id' => 209,
'name' => 'Quairading'
],[
'state_id' => 209,
'name' => 'Queens Park'
],[
'state_id' => 209,
'name' => 'Quindalup'
],[
'state_id' => 209,
'name' => 'Quinns Rocks'
],[
'state_id' => 209,
'name' => 'Rangeway'
],[
'state_id' => 209,
'name' => 'Ravensthorpe'
],[
'state_id' => 209,
'name' => 'Ravenswood'
],[
'state_id' => 209,
'name' => 'Redcliffe'
],[
'state_id' => 209,
'name' => 'Ridgewood'
],[
'state_id' => 209,
'name' => 'Riverton'
],[
'state_id' => 209,
'name' => 'Rivervale'
],[
'state_id' => 209,
'name' => 'Rockingham'
],[
'state_id' => 209,
'name' => 'Rockingham city centre'
],[
'state_id' => 209,
'name' => 'Roebuck'
],[
'state_id' => 209,
'name' => 'Roleystone'
],[
'state_id' => 209,
'name' => 'Rossmoyne'
],[
'state_id' => 209,
'name' => 'Safety Bay'
],[
'state_id' => 209,
'name' => 'Salter Point'
],[
'state_id' => 209,
'name' => 'Samson'
],[
'state_id' => 209,
'name' => 'Sandstone'
],[
'state_id' => 209,
'name' => 'Scarborough'
],[
'state_id' => 209,
'name' => 'Secret Harbour'
],[
'state_id' => 209,
'name' => 'Serpentine'
],[
'state_id' => 209,
'name' => 'Serpentine-Jarrahdale'
],[
'state_id' => 209,
'name' => 'Seville Grove'
],[
'state_id' => 209,
'name' => 'Shark Bay'
],[
'state_id' => 209,
'name' => 'Shelley'
],[
'state_id' => 209,
'name' => 'Shenton Park'
],[
'state_id' => 209,
'name' => 'Shoalwater'
],[
'state_id' => 209,
'name' => 'Silver Sands'
],[
'state_id' => 209,
'name' => 'Sinagra'
],[
'state_id' => 209,
'name' => 'Singleton'
],[
'state_id' => 209,
'name' => 'Somerville'
],[
'state_id' => 209,
'name' => 'Sorrento'
],[
'state_id' => 209,
'name' => 'South Bunbury'
],[
'state_id' => 209,
'name' => 'South Carnarvon'
],[
'state_id' => 209,
'name' => 'South Fremantle'
],[
'state_id' => 209,
'name' => 'South Guildford'
],[
'state_id' => 209,
'name' => 'South Hedland'
],[
'state_id' => 209,
'name' => 'South Kalgoorlie'
],[
'state_id' => 209,
'name' => 'South Lake'
],[
'state_id' => 209,
'name' => 'South Perth'
],[
'state_id' => 209,
'name' => 'South Yunderup'
],[
'state_id' => 209,
'name' => 'Southern River'
],[
'state_id' => 209,
'name' => 'Spalding'
],[
'state_id' => 209,
'name' => 'Spearwood'
],[
'state_id' => 209,
'name' => 'Spencer Park'
],[
'state_id' => 209,
'name' => 'St George Ranges'
],[
'state_id' => 209,
'name' => 'St James'
],[
'state_id' => 209,
'name' => 'Stirling'
],[
'state_id' => 209,
'name' => 'Stoneville'
],[
'state_id' => 209,
'name' => 'Strathalbyn'
],[
'state_id' => 209,
'name' => 'Stratton'
],[
'state_id' => 209,
'name' => 'Subiaco'
],[
'state_id' => 209,
'name' => 'Success'
],[
'state_id' => 209,
'name' => 'Sunset Beach'
],[
'state_id' => 209,
'name' => 'Swan'
],[
'state_id' => 209,
'name' => 'Swan View'
],[
'state_id' => 209,
'name' => 'Swanbourne'
],[
'state_id' => 209,
'name' => 'Tammin'
],[
'state_id' => 209,
'name' => 'Tapping'
],[
'state_id' => 209,
'name' => 'Tarcoola Beach'
],[
'state_id' => 209,
'name' => 'Telfer'
],[
'state_id' => 209,
'name' => 'The Vines'
],[
'state_id' => 209,
'name' => 'Thornlie'
],[
'state_id' => 209,
'name' => 'Three Springs'
],[
'state_id' => 209,
'name' => 'Tom Price'
],[
'state_id' => 209,
'name' => 'Toodyay'
],[
'state_id' => 209,
'name' => 'Trayning'
],[
'state_id' => 209,
'name' => 'Trigg'
],[
'state_id' => 209,
'name' => 'Tuart Hill'
],[
'state_id' => 209,
'name' => 'Two Rocks'
],[
'state_id' => 209,
'name' => 'Upper Gascoyne'
],[
'state_id' => 209,
'name' => 'Usher'
],[
'state_id' => 209,
'name' => 'Utakarra'
],[
'state_id' => 209,
'name' => 'Vasse'
],[
'state_id' => 209,
'name' => 'Victoria Park'
],[
'state_id' => 209,
'name' => 'Victoria Plains'
],[
'state_id' => 209,
'name' => 'Vincent'
],[
'state_id' => 209,
'name' => 'Viveash'
],[
'state_id' => 209,
'name' => 'Waggrakine'
],[
'state_id' => 209,
'name' => 'Wagin'
],[
'state_id' => 209,
'name' => 'Waikiki'
],[
'state_id' => 209,
'name' => 'Wandering'
],[
'state_id' => 209,
'name' => 'Wandi'
],[
'state_id' => 209,
'name' => 'Wandina'
],[
'state_id' => 209,
'name' => 'Wannanup'
],[
'state_id' => 209,
'name' => 'Wanneroo'
],[
'state_id' => 209,
'name' => 'Warnbro'
],[
'state_id' => 209,
'name' => 'Waroona'
],[
'state_id' => 209,
'name' => 'Warwick'
],[
'state_id' => 209,
'name' => 'Waterford'
],[
'state_id' => 209,
'name' => 'Watermans Bay'
],[
'state_id' => 209,
'name' => 'Wattle Grove'
],[
'state_id' => 209,
'name' => 'Wellard'
],[
'state_id' => 209,
'name' => 'Wembley'
],[
'state_id' => 209,
'name' => 'Wembley Downs'
],[
'state_id' => 209,
'name' => 'West Arthur'
],[
'state_id' => 209,
'name' => 'West Beach'
],[
'state_id' => 209,
'name' => 'West Busselton'
],[
'state_id' => 209,
'name' => 'West Lamington'
],[
'state_id' => 209,
'name' => 'West Leederville'
],[
'state_id' => 209,
'name' => 'West Perth'
],[
'state_id' => 209,
'name' => 'Westminster'
],[
'state_id' => 209,
'name' => 'Westonia'
],[
'state_id' => 209,
'name' => 'White Gum Valley'
],[
'state_id' => 209,
'name' => 'Wickepin'
],[
'state_id' => 209,
'name' => 'Wickham'
],[
'state_id' => 209,
'name' => 'Willagee'
],[
'state_id' => 209,
'name' => 'Willetton'
],[
'state_id' => 209,
'name' => 'Williams'
],[
'state_id' => 209,
'name' => 'Wilson'
],[
'state_id' => 209,
'name' => 'Wiluna'
],[
'state_id' => 209,
'name' => 'Winthrop'
],[
'state_id' => 209,
'name' => 'Withers'
],[
'state_id' => 209,
'name' => 'Wongan-Ballidu'
],[
'state_id' => 209,
'name' => 'Wonthella'
],[
'state_id' => 209,
'name' => 'Woodanilling'
],[
'state_id' => 209,
'name' => 'Woodbridge'
],[
'state_id' => 209,
'name' => 'Woodvale'
],[
'state_id' => 209,
'name' => 'Wooroloo'
],[
'state_id' => 209,
'name' => 'Woorree'
],[
'state_id' => 209,
'name' => 'Wundowie'
],[
'state_id' => 209,
'name' => 'Wyalkatchem'
],[
'state_id' => 209,
'name' => 'Wyndham-East Kimberley'
],[
'state_id' => 209,
'name' => 'Yakamia'
],[
'state_id' => 209,
'name' => 'Yalgoo'
],[
'state_id' => 209,
'name' => 'Yallingup'
],[
'state_id' => 209,
'name' => 'Yalyalup'
],[
'state_id' => 209,
'name' => 'Yanchep'
],[
'state_id' => 209,
'name' => 'Yangebup'
],[
'state_id' => 209,
'name' => 'Yilgarn'
],[
'state_id' => 209,
'name' => 'Yokine'
],[
'state_id' => 209,
'name' => 'York'
],[
'state_id' => 209,
'name' => 'Malaga'
],[
'state_id' => 209,
'name' => 'Badgingarra'
],[
'state_id' => 209,
'name' => 'Muchea'
],[
'state_id' => 209,
'name' => 'Cervantes'
],[
'state_id' => 209,
'name' => 'Woodridge'
],[
'state_id' => 209,
'name' => 'Leeman'
],[
'state_id' => 209,
'name' => 'Lancelin'
],[
'state_id' => 209,
'name' => 'Green Head'
],[
'state_id' => 209,
'name' => 'Cataby'
],[
'state_id' => 209,
'name' => 'Regans Ford'
],[
'state_id' => 209,
'name' => 'Hill River'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
