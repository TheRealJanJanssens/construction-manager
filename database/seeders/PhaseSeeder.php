<?php

namespace Database\Seeders;

use App\Models\Phase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phases = [
            "0. Aanneming werf",
            "00. algemene bepalingen",
            "01. aannemingsmodaliteiten",
            "02. bouwplaatsvoorzieningen",
            "03. afbraakwerken",
            "04. gebouwprestaties",
            "05. proeven",
            "1. Onderbouw",
            "10. grondwerken",
            "11. Stut- en ondervangingswerken",
            "12. Funderingen op staal",
            "13. Speciale funderingen",
            "14. Ondergrondse wanden",
            "15. Vloerlagen onderbouw",
            "16. Thermische isolatie onderbouw",
            "17. Ondergrondse leidingen",
            "2. Bovenbouw",
            "20. Metselwerk",
            "21. Spouwmuurisolatie",
            "22. Gevelmetselwerk",
            "23. Dorpels, plinten en dekstenen",
            "24. Ruwbouwkanalen",
            "25. Structuurelementen hout",
            "26. Structuurelementen beton",
            "27. Structuurelementen staal",
            "28. Houtskeletbouw",
            "3. Dakwerken",
            "30. Dakopbouw hellend dak",
            "31. Thermische isolatie hellend dak",
            "32. Dakbedekking hellend dak",
            "33. Dakvloer plat dak",
            "34. Thermische isolatie plat dak",
            "35. Afdichting en afwerking plat dak",
            "36. Daklichtopeningen",
            "37. Dakranden en kroonlijsten",
            "38. Dakwaterafvoer",
            "4. Gevelsluiting",
            "40. Buitenschrijnwerk",
            "41. Poorten & externe zonwering",
            "42. Gevelbekledingen",
            "43. Buitenbepleistering",
            "44. Buitentrappen & borstweringen",
            "5. Binnenafwerking",
            "50. Binnenpleisterwerken",
            "51. Binnenplaatafwerkingen",
            "52. Dek- en bedrijfsvloeren",
            "53. Binnenvloerafwerkingen",
            "54. Binnendeuren en -ramen",
            "55. Binnentrappen en leuningen",
            "56. Vast meubilair",
            "57. Tablet- en wandbekledingen",
            "6. Technieken fluïda",
            "60. Sanitair leidingnet",
            "61. Sanitaire toestellen & toebehoren",
            "62. Sanitaire kranen & kleppen",
            "63. Sanitair warm water",
            "64. Gasinstallaties",
            "65. Verwarming individuele installaties",
            "66. Bijzondere installaties",
            "67. Brandbestrijding",
            "68. Ventilatie",
            "69. Opbouwkanalen rookgas en ventilatie",
            "7. Technieken elektro",
            "70. Elektriciteit binnennet",
            "71. Elektriciteit schakelaars & contactdozen",
            "72. Elektriciteit lichtarmaturen",
            "73. Elektriciteit & parlofoon",
            "74. Elektriciteit telecom & domotica",
            "75. Elektriciteit verwarming",
            "76. Elektromechanica liften",
            "77. Branddetectie & alarmsystemen",
            "8. Schilderwerken",
            "80. Binnenschilderwerken",
            "81. Behangwerken",
            "82. Buitenschilderwerken",
            "9. Omgevingswerken",
            "90. Buitenverhardingen",
            "91. Buitenconstructies en afsluitingen",
            "92. Buitenmeubilair en uitrustingselementen",
            "93. Groenaanleg en -onderhoud"
        ];

        $parent = null;
        foreach($phases as $phase){
            $result = Phase::create([
                "name" => $phase,
                "parent" => substr($phase, 1, 1) == "." ? null : $parent,
            ]);

            if(substr($phase, 1, 1) == ".") {
                //string starts with x. and not xx. which means it is a parent
                $parent = $result->uuid;
            }
        }
    }
}

// Original list

// 0. Aanneming werf
// 00. algemene bepalingen
// 01. aannemingsmodaliteiten
// 02. bouwplaatsvoorzieningen
// 03. afbraakwerken
// 04. gebouwprestaties
// 05. proeven
// 1. Onderbouw
// 10. grondwerken
// 11. Stut- en ondervangingswerken
// 12. Funderingen op staal
// 13. Speciale funderingen
// 14. Ondergrondse wanden
// 15. Vloerlagen onderbouw
// 16. Thermische isolatie onderbouw
// 17. Ondergrondse leidingen
// 2. Bovenbouw
// 20. Metselwerk
// 21. Spouwmuurisolatie
// 22. Gevelmetselwerk
// 23. Dorpels, plinten en dekstenen
// 24. Ruwbouwkanalen
// 25. Structuurelementen hout
// 26. Structuurelementen beton
// 27. Structuurelementen staal
// 28. Houtskeletbouw
// 3. Dakwerken
// 30. Dakopbouw hellend dak
// 31. Thermische isolatie hellend dak
// 32. Dakbedekking hellend dak
// 33. Dakvloer plat dak
// 34. Thermische isolatie plat dak
// 35. Afdichting en afwerking plat dak
// 36. Daklichtopeningen
// 37. Dakranden en kroonlijsten
// 38. Dakwaterafvoer
// 4. Gevelsluiting
// 40. Buitenschrijnwerk
// 41. Poorten & externe zonwering
// 42. Gevelbekledingen
// 43. Buitenbepleistering
// 44. Buitentrappen & borstweringen
// 5. Binnenafwerking
// 50. Binnenpleisterwerken
// 51. Binnenplaatafwerkingen
// 52. Dek- en bedrijfsvloeren
// 53. Binnenvloerafwerkingen
// 54. Binnendeuren en -ramen
// 55. Binnentrappen en leuningen
// 56. Vast meubilair
// 57. Tablet- en wandbekledingen
// 6. Technieken fluïda
// 60. Sanitair leidingnet
// 61. Sanitaire toestellen & toebehoren
// 62. Sanitaire kranen & kleppen
// 63. Sanitair warm water
// 64. Gasinstallaties
// 65. Verwarming individuele installaties
// 66. Bijzondere installaties
// 67. Brandbestrijding
// 68. Ventilatie
// 69. Opbouwkanalen rookgas en ventilatie
// 7. Technieken elektro
// 70. Elektriciteit binnennet
// 71. Elektriciteit schakelaars & contactdozen
// 72. Elektriciteit lichtarmaturen
// 73. Elektriciteit & parlofoon
// 74. Elektriciteit telecom & domotica
// 75. Elektriciteit verwarming
// 76. Elektromechanica liften
// 77. Branddetectie & alarmsystemen
// 8. Schilderwerken
// 80. Binnenschilderwerken
// 81. Behangwerken
// 82. Buitenschilderwerken
// 9. Omgevingswerken
// 90. Buitenverhardingen
// 91. Buitenconstructies en afsluitingen
// 92. Buitenmeubilair en uitrustingselementen
// 93. Groenaanleg en -onderhoud
