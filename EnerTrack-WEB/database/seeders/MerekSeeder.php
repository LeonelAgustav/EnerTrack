<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MerekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mereks = [
            ['nama_merek' => 'Samsung', 'negara_asal' => 'Korea Selatan', 'tahun_berdiri' => 1938, 'website' => 'https://www.samsung.com'],
            ['nama_merek' => 'Apple', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1976, 'website' => 'https://www.apple.com'],
            ['nama_merek' => 'Sony', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1946, 'website' => 'https://www.sony.com'],
            ['nama_merek' => 'LG', 'negara_asal' => 'Korea Selatan', 'tahun_berdiri' => 1947, 'website' => 'https://www.lg.com'],
            ['nama_merek' => 'Panasonic', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1918, 'website' => 'https://www.panasonic.com'],
            ['nama_merek' => 'Xiaomi', 'negara_asal' => 'China', 'tahun_berdiri' => 2010, 'website' => 'https://www.mi.com'],
            ['nama_merek' => 'Huawei', 'negara_asal' => 'China', 'tahun_berdiri' => 1987, 'website' => 'https://www.huawei.com'],
            ['nama_merek' => 'Oppo', 'negara_asal' => 'China', 'tahun_berdiri' => 2004, 'website' => 'https://www.oppo.com'],
            ['nama_merek' => 'Vivo', 'negara_asal' => 'China', 'tahun_berdiri' => 2009, 'website' => 'https://www.vivo.com'],
            ['nama_merek' => 'Lenovo', 'negara_asal' => 'China', 'tahun_berdiri' => 1984, 'website' => 'https://www.lenovo.com'],
            ['nama_merek' => 'HP', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1939, 'website' => 'https://www.hp.com'],
            ['nama_merek' => 'Dell', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1984, 'website' => 'https://www.dell.com'],
            ['nama_merek' => 'Asus', 'negara_asal' => 'Taiwan', 'tahun_berdiri' => 1989, 'website' => 'https://www.asus.com'],
            ['nama_merek' => 'Acer', 'negara_asal' => 'Taiwan', 'tahun_berdiri' => 1976, 'website' => 'https://www.acer.com'],
            ['nama_merek' => 'Microsoft', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1975, 'website' => 'https://www.microsoft.com'],
            ['nama_merek' => 'Philips', 'negara_asal' => 'Belanda', 'tahun_berdiri' => 1891, 'website' => 'https://www.philips.com'],
            ['nama_merek' => 'Toshiba', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1875, 'website' => 'https://www.toshiba.com'],
            ['nama_merek' => 'Sharp', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1912, 'website' => 'https://www.sharp.com'],
            ['nama_merek' => 'Siemens', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 1847, 'website' => 'https://www.siemens.com'],
            ['nama_merek' => 'Hitachi', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1910, 'website' => 'https://www.hitachi.com'],
            ['nama_merek' => 'Bosch', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 1886, 'website' => 'https://www.bosch.com'],
            ['nama_merek' => 'Canon', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1937, 'website' => 'https://www.canon.com'],
            ['nama_merek' => 'Nikon', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1917, 'website' => 'https://www.nikon.com'],
            ['nama_merek' => 'GoPro', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 2002, 'website' => 'https://www.gopro.com'],
            ['nama_merek' => 'JBL', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1946, 'website' => 'https://www.jbl.com'],
            ['nama_merek' => 'Bose', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1964, 'website' => 'https://www.bose.com'],
            ['nama_merek' => 'Harman Kardon', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1953, 'website' => 'https://www.harmankardon.com'],
            ['nama_merek' => 'Intel', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1968, 'website' => 'https://www.intel.com'],
            ['nama_merek' => 'AMD', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1969, 'website' => 'https://www.amd.com'],
            ['nama_merek' => 'Nvidia', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1993, 'website' => 'https://www.nvidia.com'],
            ['nama_merek' => 'Realme', 'negara_asal' => 'China', 'tahun_berdiri' => 2018, 'website' => 'https://www.realme.com'],
            ['nama_merek' => 'Nothing', 'negara_asal' => 'Inggris', 'tahun_berdiri' => 2020, 'website' => 'https://nothing.tech'],
            ['nama_merek' => 'OnePlus', 'negara_asal' => 'China', 'tahun_berdiri' => 2013, 'website' => 'https://www.oneplus.com'],
            ['nama_merek' => 'Poco', 'negara_asal' => 'China', 'tahun_berdiri' => 2018, 'website' => 'https://www.poco.net'],
            ['nama_merek' => 'Infinix', 'negara_asal' => 'China', 'tahun_berdiri' => 2013, 'website' => 'https://www.infinixmobility.com'],
            ['nama_merek' => 'TCL', 'negara_asal' => 'China', 'tahun_berdiri' => 1981, 'website' => 'https://www.tcl.com'],
            ['nama_merek' => 'Haier', 'negara_asal' => 'China', 'tahun_berdiri' => 1984, 'website' => 'https://www.haier.com'],
            ['nama_merek' => 'Hisense', 'negara_asal' => 'China', 'tahun_berdiri' => 1969, 'website' => 'https://www.hisense.com'],
            ['nama_merek' => 'BenQ', 'negara_asal' => 'Taiwan', 'tahun_berdiri' => 1984, 'website' => 'https://www.benq.com'],
            ['nama_merek' => 'Epson', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1942, 'website' => 'https://www.epson.com'],
            ['nama_merek' => 'Meizu', 'negara_asal' => 'China', 'tahun_berdiri' => 2003, 'website' => 'https://www.meizu.com'],
            ['nama_merek' => 'Fairphone', 'negara_asal' => 'Belanda', 'tahun_berdiri' => 2013, 'website' => 'https://www.fairphone.com'],
            ['nama_merek' => 'Vestel', 'negara_asal' => 'Turki', 'tahun_berdiri' => 1984, 'website' => 'https://www.vestel.com'],
            ['nama_merek' => 'Vaio', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 2014, 'website' => 'https://www.vaio.com'],
            ['nama_merek' => 'Shuttle', 'negara_asal' => 'Taiwan', 'tahun_berdiri' => 1983, 'website' => 'https://www.shuttle.eu'],
            ['nama_merek' => 'Archos', 'negara_asal' => 'Prancis', 'tahun_berdiri' => 1988, 'website' => 'https://www.archos.com'],
            ['nama_merek' => 'Blackview', 'negara_asal' => 'China', 'tahun_berdiri' => 2013, 'website' => 'https://www.blackview.hk'],
            ['nama_merek' => 'Teac', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1953, 'website' => 'https://www.teac.com'],
            ['nama_merek' => 'Kobo', 'negara_asal' => 'Kanada', 'tahun_berdiri' => 2009, 'website' => 'https://www.kobo.com'],
            ['nama_merek' => 'Polaroid', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1937, 'website' => 'https://www.polaroid.com'],
            ['nama_merek' => 'Zopo', 'negara_asal' => 'China', 'tahun_berdiri' => 2008, 'website' => 'https://www.zopomobile.com'],
            ['nama_merek' => 'Ulefone', 'negara_asal' => 'China', 'tahun_berdiri' => 2006, 'website' => 'https://www.ulefone.com'],
            ['nama_merek' => 'Doogee', 'negara_asal' => 'China', 'tahun_berdiri' => 2013, 'website' => 'https://www.doogee.cc'],
            ['nama_merek' => 'BLU', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 2009, 'website' => 'https://www.bluproducts.com'],
            ['nama_merek' => 'Wiko', 'negara_asal' => 'Prancis', 'tahun_berdiri' => 2011, 'website' => 'https://www.wikomobile.com'],
            ['nama_merek' => 'Vertu', 'negara_asal' => 'Inggris', 'tahun_berdiri' => 1998, 'website' => 'https://www.vertu.com'],
            ['nama_merek' => 'AGM', 'negara_asal' => 'China', 'tahun_berdiri' => 2011, 'website' => 'https://www.agmmobile.com'],
            ['nama_merek' => 'UMiDIGI', 'negara_asal' => 'China', 'tahun_berdiri' => 2012, 'website' => 'https://www.umidigi.com'],
            ['nama_merek' => 'Cubot', 'negara_asal' => 'China', 'tahun_berdiri' => 2007, 'website' => 'https://www.cubot.net'],
            ['nama_merek' => 'Gionee', 'negara_asal' => 'China', 'tahun_berdiri' => 2002, 'website' => 'https://www.gionee.com'],
            ['nama_merek' => 'Kazam', 'negara_asal' => 'Inggris', 'tahun_berdiri' => 2013, 'website' => null],
            ['nama_merek' => 'Medion', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 1983, 'website' => 'https://www.medion.com'],
            ['nama_merek' => 'Elephone', 'negara_asal' => 'China', 'tahun_berdiri' => 2006, 'website' => 'https://www.elephone.hk'],
            ['nama_merek' => 'Xolo', 'negara_asal' => 'India', 'tahun_berdiri' => 2012, 'website' => 'https://www.xolo.in'],
            ['nama_merek' => 'TP-Link', 'negara_asal' => 'China', 'tahun_berdiri' => 1996, 'website' => 'https://www.tp-link.com'],
            ['nama_merek' => 'Fujitsu', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1935, 'website' => 'https://www.fujitsu.com'],
            ['nama_merek' => 'Razer', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 2005, 'website' => 'https://www.razer.com'],
            ['nama_merek' => 'Oukitel', 'negara_asal' => 'China', 'tahun_berdiri' => 2007, 'website' => 'https://www.oukitel.com'],
            ['nama_merek' => 'MSI', 'negara_asal' => 'Taiwan', 'tahun_berdiri' => 1986, 'website' => 'https://www.msi.com'],
            ['nama_merek' => 'ViewSonic', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1987, 'website' => 'https://www.viewsonic.com'],
            ['nama_merek' => 'Gigabyte', 'negara_asal' => 'Taiwan', 'tahun_berdiri' => 1986, 'website' => 'https://www.gigabyte.com'],
            ['nama_merek' => 'Zotac', 'negara_asal' => 'Hong Kong', 'tahun_berdiri' => 2006, 'website' => 'https://www.zotac.com'],
            ['nama_merek' => 'Getac', 'negara_asal' => 'Taiwan', 'tahun_berdiri' => 1989, 'website' => 'https://www.getac.com'],
            ['nama_merek' => 'EVGA', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1999, 'website' => 'https://www.evga.com'],
            ['nama_merek' => 'LeEco', 'negara_asal' => 'China', 'tahun_berdiri' => 2004, 'website' => null],
            ['nama_merek' => 'General Electric', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1892, 'website' => 'https://www.ge.com'],
            ['nama_merek' => 'Braun', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 1921, 'website' => 'https://www.braunhousehold.com'],
            ['nama_merek' => 'Dyson', 'negara_asal' => 'Inggris', 'tahun_berdiri' => 1991, 'website' => 'https://www.dyson.com'],
            ['nama_merek' => 'iRobot', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1990, 'website' => 'https://www.irobot.com'],
            ['nama_merek' => 'Beko', 'negara_asal' => 'Turki', 'tahun_berdiri' => 1955, 'website' => 'https://www.beko.com'],
            ['nama_merek' => 'Daewoo', 'negara_asal' => 'Korea Selatan', 'tahun_berdiri' => 1967, 'website' => 'https://www.daewoo.com'],
            ['nama_merek' => 'Sanyo', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1947, 'website' => null],
            ['nama_merek' => 'Thomson', 'negara_asal' => 'Prancis', 'tahun_berdiri' => 1893, 'website' => 'https://www.thomson.net'],
            ['nama_merek' => 'Konka', 'negara_asal' => 'China', 'tahun_berdiri' => 1980, 'website' => 'https://www.konka.com'],
            ['nama_merek' => 'Casio', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1946, 'website' => 'https://www.casio.com'],
            ['nama_merek' => 'Olympus', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1919, 'website' => 'https://www.olympus.com'],
            ['nama_merek' => 'Fujifilm', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1934, 'website' => 'https://www.fujifilm.com'],
            ['nama_merek' => 'Pentax', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1919, 'website' => 'https://www.pentax.com'],
            ['nama_merek' => 'Leica', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 1914, 'website' => 'https://www.leica.com'],
            ['nama_merek' => 'Nubia', 'negara_asal' => 'China', 'tahun_berdiri' => 2012, 'website' => 'https://www.nubia.com'],
            ['nama_merek' => 'ZTE', 'negara_asal' => 'China', 'tahun_berdiri' => 1985, 'website' => 'https://www.zte.com.cn'],
            ['nama_merek' => 'Aiwa', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1951, 'website' => 'https://www.aiwa.com'],
            ['nama_merek' => 'Eizo', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1968, 'website' => 'https://www.eizo.com'],
            ['nama_merek' => 'AOC', 'negara_asal' => 'Taiwan', 'tahun_berdiri' => 1967, 'website' => 'https://www.aoc.com'],
            ['nama_merek' => 'iiyama', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1973, 'website' => 'https://www.iiyama.com'],
            ['nama_merek' => 'Loewe', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 1923, 'website' => 'https://www.loewe.tv'],
            ['nama_merek' => 'Grundig', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 1930, 'website' => 'https://www.grundig.com'],
            ['nama_merek' => 'DeWalt', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1924, 'website' => 'https://www.dewalt.com'],
            ['nama_merek' => 'Elekta', 'negara_asal' => 'Swedia', 'tahun_berdiri' => 1972, 'website' => 'https://www.elekta.com'],
            ['nama_merek' => 'Blaupunkt', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 1923, 'website' => 'https://www.blaupunkt.com'],
            ['nama_merek' => 'NAD', 'negara_asal' => 'Kanada', 'tahun_berdiri' => 1972, 'website' => 'https://www.nadelectronics.com'],
            ['nama_merek' => 'Marantz', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1952, 'website' => 'https://www.marantz.com'],
            ['nama_merek' => 'McIntosh', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1949, 'website' => 'https://www.mcintoshlabs.com'],
            ['nama_merek' => 'Denon', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1910, 'website' => 'https://www.denon.com'],
            ['nama_merek' => 'Technics', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1965, 'website' => 'https://www.technics.com'],
            ['nama_merek' => 'Sennheiser', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 1945, 'website' => 'https://www.sennheiser.com'],
            ['nama_merek' => 'Audio-Technica', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1962, 'website' => 'https://www.audio-technica.com'],
            ['nama_merek' => 'AKG', 'negara_asal' => 'Austria', 'tahun_berdiri' => 1947, 'website' => 'https://www.akg.com'],
            ['nama_merek' => 'Beyerdynamic', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 1924, 'website' => 'https://www.beyerdynamic.com'],
            ['nama_merek' => 'Pioneer', 'negara_asal' => 'Jepang', 'tahun_berdiri' => 1938, 'website' => 'https://www.pioneer.com'],
            ['nama_merek' => 'Insignia', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 2004, 'website' => 'https://www.insigniaproducts.com'],
            ['nama_merek' => 'Dynex', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => null, 'website' => 'https://www.dynexproducts.com'],
            ['nama_merek' => 'Croma', 'negara_asal' => 'India', 'tahun_berdiri' => 2006, 'website' => 'https://www.croma.com'],
            ['nama_merek' => 'Venturer', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1988, 'website' => 'https://www.venturer.com'],
            ['nama_merek' => 'Sceptre', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1984, 'website' => 'https://www.sceptre.com'],
            ['nama_merek' => 'Element', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => null, 'website' => 'https://www.elementelectronics.com'],
            ['nama_merek' => 'Westinghouse', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1886, 'website' => 'https://www.westinghouse.com'],
            ['nama_merek' => 'RCA', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1919, 'website' => 'https://www.rca.com'],
            ['nama_merek' => 'Cello', 'negara_asal' => 'Inggris', 'tahun_berdiri' => 2001, 'website' => 'https://www.celloelectronics.com'],
            ['nama_merek' => 'Bush', 'negara_asal' => 'Inggris', 'tahun_berdiri' => 1932, 'website' => null],
            ['nama_merek' => 'Alba', 'negara_asal' => 'Inggris', 'tahun_berdiri' => 1917, 'website' => null],
            ['nama_merek' => 'Logic', 'negara_asal' => 'Inggris', 'tahun_berdiri' => null, 'website' => 'https://www.logikdigital.com'],
            ['nama_merek' => 'Goodmans', 'negara_asal' => 'Inggris', 'tahun_berdiri' => 1923, 'website' => 'https://www.goodmans.co.uk'],
            ['nama_merek' => 'In-lite', 'negara_asal' => 'Belanda', 'tahun_berdiri' => 1991, 'website' => 'https://www.in-lite.com'],
            ['nama_merek' => 'Philips Hue', 'negara_asal' => 'Belanda', 'tahun_berdiri' => 2012, 'website' => 'https://www.philips-hue.com'],
            ['nama_merek' => 'LIFX', 'negara_asal' => 'Australia', 'tahun_berdiri' => 2012, 'website' => 'https://www.lifx.com'],
            ['nama_merek' => 'Nanoleaf', 'negara_asal' => 'Kanada', 'tahun_berdiri' => 2012, 'website' => 'https://nanoleaf.me'],
            ['nama_merek' => 'Lutron', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1961, 'website' => 'https://www.lutron.com'],
            ['nama_merek' => 'Legrand', 'negara_asal' => 'Prancis', 'tahun_berdiri' => 1860, 'website' => 'https://www.legrand.com'],
            ['nama_merek' => 'Osram', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 1919, 'website' => 'https://www.osram.com'],
            ['nama_merek' => 'GE Lighting', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1911, 'website' => 'https://www.gelighting.com'],
            ['nama_merek' => 'Cree Lighting', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1987, 'website' => 'https://www.creelighting.com'],
            ['nama_merek' => 'Current by GE', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 2015, 'website' => 'https://www.currentbyge.com'],
            ['nama_merek' => 'Signify', 'negara_asal' => 'Belanda', 'tahun_berdiri' => 2018, 'website' => 'https://www.signify.com'],
            ['nama_merek' => 'Feit Electric', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1978, 'website' => 'https://www.feit.com'],
            ['nama_merek' => 'Satco', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1966, 'website' => 'https://www.satco.com'],
            ['nama_merek' => 'WAC Lighting', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1984, 'website' => 'https://www.waclighting.com'],
            ['nama_merek' => 'Kichler', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1938, 'website' => 'https://www.kichler.com'],
            ['nama_merek' => 'Progress Lighting', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1906, 'website' => 'https://www.progresslighting.com'],
            ['nama_merek' => 'Sylvania', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1901, 'website' => 'https://www.sylvania.com'],
            ['nama_merek' => 'Maxlite', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1993, 'website' => 'https://www.maxlite.com'],
            ['nama_merek' => 'Acuity Brands', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 2001, 'website' => 'https://www.acuitybrands.com'],
            ['nama_merek' => 'Cooper Lighting', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1956, 'website' => 'https://www.cooperlighting.com'],
            ['nama_merek' => 'Lithonia Lighting', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1946, 'website' => 'https://www.lithonia.com'],
            ['nama_merek' => 'Sengled', 'negara_asal' => 'China', 'tahun_berdiri' => 2012, 'website' => 'https://www.sengled.com'],
            ['nama_merek' => 'Wiz', 'negara_asal' => 'Hong Kong', 'tahun_berdiri' => 2015, 'website' => 'https://www.wizconnected.com'],
            ['nama_merek' => 'TP-Link Kasa', 'negara_asal' => 'China', 'tahun_berdiri' => 2015, 'website' => 'https://www.kasasmart.com'],
            ['nama_merek' => 'Yeelight', 'negara_asal' => 'China', 'tahun_berdiri' => 2012, 'website' => 'https://www.yeelight.com'],
            ['nama_merek' => 'Eve', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 2014, 'website' => 'https://www.evehome.com'],
            ['nama_merek' => 'Govee', 'negara_asal' => 'China', 'tahun_berdiri' => 2017, 'website' => 'https://www.govee.com'],
            ['nama_merek' => 'Minka Group', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1993, 'website' => 'https://www.minkagroup.net'],
            ['nama_merek' => 'Hunter', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1886, 'website' => 'https://www.hunterfan.com'],
            ['nama_merek' => 'Leviton', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1906, 'website' => 'https://www.leviton.com'],
            ['nama_merek' => 'Eaton', 'negara_asal' => 'Irlandia', 'tahun_berdiri' => 1911, 'website' => 'https://www.eaton.com'],
            ['nama_merek' => 'Lightolier', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1904, 'website' => null],
            ['nama_merek' => 'Sea Gull Lighting', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1919, 'website' => 'https://www.seagulllighting.com'],
            ['nama_merek' => 'Juno Lighting', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1976, 'website' => 'https://www.junolighting.com'],
            ['nama_merek' => 'Tech Lighting', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1988, 'website' => 'https://www.techlighting.com'],
            ['nama_merek' => 'EGLO', 'negara_asal' => 'Austria', 'tahun_berdiri' => 1969, 'website' => 'https://www.eglo.com'],
            ['nama_merek' => 'Artemide', 'negara_asal' => 'Italia', 'tahun_berdiri' => 1960, 'website' => 'https://www.artemide.com'],
            ['nama_merek' => 'IKEA Trådfri', 'negara_asal' => 'Swedia', 'tahun_berdiri' => 2016, 'website' => 'https://www.ikea.com'],
            ['nama_merek' => 'Ledger', 'negara_asal' => 'Prancis', 'tahun_berdiri' => 2014, 'website' => 'https://www.ledger.com'],
            ['nama_merek' => 'Lightify', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 2014, 'website' => null],
            ['nama_merek' => 'Aurora', 'negara_asal' => 'Inggris', 'tahun_berdiri' => 1999, 'website' => 'https://www.auroralighting.com'],
            ['nama_merek' => 'Paulmann', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 1982, 'website' => 'https://www.paulmann.com'],
            ['nama_merek' => 'Opple Lighting', 'negara_asal' => 'China', 'tahun_berdiri' => 1996, 'website' => 'https://www.opple.com'],
            ['nama_merek' => 'Crompton', 'negara_asal' => 'India', 'tahun_berdiri' => 1937, 'website' => 'https://www.crompton.co.in'],
            ['nama_merek' => 'Havells', 'negara_asal' => 'India', 'tahun_berdiri' => 1958, 'website' => 'https://www.havells.com'],
            ['nama_merek' => 'Wipro Lighting', 'negara_asal' => 'India', 'tahun_berdiri' => 1945, 'website' => 'https://www.wiprolighting.com'],
            ['nama_merek' => 'Syska LED', 'negara_asal' => 'India', 'tahun_berdiri' => 2011, 'website' => 'https://www.syska.in'],
            ['nama_merek' => 'Brilliant Lighting', 'negara_asal' => 'Australia', 'tahun_berdiri' => 1973, 'website' => 'https://www.brilliantlighting.com.au'],
            ['nama_merek' => 'Endon', 'negara_asal' => 'Inggris', 'tahun_berdiri' => 1939, 'website' => 'https://www.endon.co.uk'],
            ['nama_merek' => 'Nordlux', 'negara_asal' => 'Denmark', 'tahun_berdiri' => 1977, 'website' => 'https://www.nordlux.com'],
            ['nama_merek' => 'Elgato', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 1992, 'website' => 'https://www.elgato.com'],
            ['nama_merek' => 'Anker', 'negara_asal' => 'China', 'tahun_berdiri' => 2011, 'website' => 'https://www.anker.com'],
            ['nama_merek' => 'Belkin', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1983, 'website' => 'https://www.belkin.com'],
            ['nama_merek' => 'Logitech', 'negara_asal' => 'Swiss', 'tahun_berdiri' => 1981, 'website' => 'https://www.logitech.com'],
            ['nama_merek' => 'Corsair', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1994, 'website' => 'https://www.corsair.com'],
            ['nama_merek' => 'Thrustmaster', 'negara_asal' => 'Prancis', 'tahun_berdiri' => 1990, 'website' => 'https://www.thrustmaster.com'],
            ['nama_merek' => 'Steelseries', 'negara_asal' => 'Denmark', 'tahun_berdiri' => 2001, 'website' => 'https://www.steelseries.com'],
            ['nama_merek' => 'HyperX', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 2002, 'website' => 'https://www.hyperxgaming.com'],
            ['nama_merek' => 'Kingston', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1987, 'website' => 'https://www.kingston.com'],
            ['nama_merek' => 'Western Digital', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1970, 'website' => 'https://www.westerndigital.com'],
            ['nama_merek' => 'Seagate', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1979, 'website' => 'https://www.seagate.com'],
            ['nama_merek' => 'Crucial', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1996, 'website' => 'https://www.crucial.com'],
            ['nama_merek' => 'Netgear', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1996, 'website' => 'https://www.netgear.com'],
            ['nama_merek' => 'D-Link', 'negara_asal' => 'Taiwan', 'tahun_berdiri' => 1986, 'website' => 'https://www.dlink.com'],
            ['nama_merek' => 'Linksys', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1988, 'website' => 'https://www.linksys.com'],
            ['nama_merek' => 'Ubiquiti', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 2005, 'website' => 'https://www.ui.com'],
            ['nama_merek' => 'ASRock', 'negara_asal' => 'Taiwan', 'tahun_berdiri' => 2002, 'website' => 'https://www.asrock.com'],
            ['nama_merek' => 'Thermaltake', 'negara_asal' => 'Taiwan', 'tahun_berdiri' => 1999, 'website' => 'https://www.thermaltake.com'],
            ['nama_merek' => 'NZXT', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 2004, 'website' => 'https://www.nzxt.com'],
            ['nama_merek' => 'be quiet!', 'negara_asal' => 'Jerman', 'tahun_berdiri' => 2002, 'website' => 'https://www.bequiet.com'],
            ['nama_merek' => 'Cooler Master', 'negara_asal' => 'Taiwan', 'tahun_berdiri' => 1992, 'website' => 'https://www.coolermaster.com'],
            ['nama_merek' => 'Fractal Design', 'negara_asal' => 'Swedia', 'tahun_berdiri' => 2007, 'website' => 'https://www.fractal-design.com'],
            ['nama_merek' => 'Creative Technology', 'negara_asal' => 'Singapura', 'tahun_berdiri' => 1981, 'website' => 'https://www.creative.com'],
            ['nama_merek' => 'Turtle Beach', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1975, 'website' => 'https://www.turtlebeach.com'],
            ['nama_merek' => 'Focusrite', 'negara_asal' => 'Inggris', 'tahun_berdiri' => 1985, 'website' => 'https://www.focusrite.com'],
            ['nama_merek' => 'PreSonus', 'negara_asal' => 'Amerika Serikat', 'tahun_berdiri' => 1995, 'website' => 'https://www.presonus.com'],
            ['nama_merek' => 'Cosmos', 'negara_asal' => 'Indonesia', 'tahun_berdiri' => 1975, 'website' => 'https://www.cosmos.id'],
        ];

        foreach ($mereks as $merek) {
            DB::table('merek')->insert($merek);
        }
    }
} 