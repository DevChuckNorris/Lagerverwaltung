<?php

namespace App;

use League\Flysystem\Exception;

class EAN128
{
    public $barColor = Array(0, 0, 0);
    public $bgColor = Array(255, 255, 255);
    public $textColor = Array(0, 0, 0);
    public $font;

    public function __construct()
    {
        $this->font = dirname(__FILE__) . "/../resources/FreeSans.ttf";
    }

    public function generateImage($data, $scale = 1) {
        $encoded = $this->encodeData($data);

        $totalY = 60 * $scale;
        $space = [
            'top' => 2 * $scale,
            'bottom' => 2 * $scale,
            'left' => 2 * $scale,
            'right' => 2 * $scale
        ];

        $xPos = 0;
        for($i = 0, $len = strlen($data); $i<$len; $i++) {
            $xPos+=$scale;
            $width = true;
        }

        $totalX = $xPos + $space['right'] + $space['right'];
        $xPos = $space['left'];
        $im = imagecreate($totalX, $totalY);



        $colorBg = imagecolorallocate($im, $this->bgColor[0], $this->bgColor[1], $this->bgColor[2]);
        $colorBar = imagecolorallocate($im, $this->barColor[0], $this->barColor[1], $this->barColor[2]);
        $colorText = imagecolorallocate($im, $this->textColor[0], $this->textColor[1], $this->textColor[2]);
        $height = round($totalY - $space['bottom']);

        for($i = 0, $len = strlen($encoded); $i < $len; $i++) {
            $val = strtolower($encoded[$i]);
            $h=$height;
            if ($val == "1") {
                imagefilledrectangle($im, $xPos, $space['top'], $xPos, $h, $colorBar);
            }
            $xPos++;
        }

        $fontSize = $scale * 8;
        $fontHeight = $totalY - ($fontSize/2.5) + 2;
        imagettftext($im, $fontSize, 0, ($totalX / 2)-(strlen($data)*$fontSize/2.68), $fontHeight, $colorText, $this->font, $data);

        return $im;
    }

    private function encodeData($data) {
        $codes = [
            "00" => "11011001100",
            "01" => "11001101100",
            "02" => "11001100110",
            "03" => "10010011000",
            "04" => "10010001100",
            "05" => "10001001100",
            "06" => "10011001000",
            "07" => "10011000100",
            "08" => "10001100100",
            "09" => "11001001000",
            "10" => "11001000100",
            "11" => "11000100100",
            "12" => "10110011100",
            "13" => "10011011100",
            "14" => "10011001110",
            "15" => "10111001100",
            "16" => "10011101100",
            "17" => "10011100110",
            "18" => "11001110010",
            "19" => "11001011100",
            "20" => "11001001110",
            "21" => "11011100100",
            "22" => "11001110100",
            "23" => "11101101110",
            "24" => "11101001100",
            "25" => "11100101100",
            "26" => "11100100110",
            "27" => "11101100100",
            "28" => "11100110100",
            "29" => "11100110010",
            "30" => "11011011000",
            "31" => "11011000110",
            "32" => "11000110110",
            "33" => "10100011000",
            "34" => "10001011000",
            "35" => "10001000110",
            "36" => "10110001000",
            "37" => "10001101000",
            "38" => "10001100010",
            "39" => "11010001000",
            "40" => "11000101000",
            "41" => "11000100010",
            "42" => "10110111000",
            "43" => "10110001110",
            "44" => "10001101110",
            "45" => "10111011000",
            "46" => "10111000110",
            "47" => "10001110110",
            "48" => "11101110110",
            "49" => "11010001110",
            "50" => "11000101110",
            "51" => "11011101000",
            "52" => "11011100010",
            "53" => "11011101110",
            "54" => "11101011000",
            "55" => "11101000110",
            "56" => "11100010110",
            "57" => "11101101000",
            "58" => "11101100010",
            "59" => "11100011010",
            "60" => "11101111010",
            "61" => "11001000010",
            "62" => "11110001010",
            "63" => "10100110000",
            "64" => "10100001100",
            "65" => "10010110000",
            "66" => "10010000110",
            "67" => "10000101100",
            "68" => "10000100110",
            "69" => "10110010000",
            "70" => "10110000100",
            "71" => "10011010000",
            "72" => "10011000010",
            "73" => "10000110100",
            "74" => "10000110010",
            "75" => "11000010010",
            "76" => "11001010000",
            "77" => "11110111010",
            "78" => "11000010100",
            "79" => "10001111010",
            "80" => "10100111100",
            "81" => "10010111100",
            "82" => "10010011110",
            "83" => "10111100100",
            "84" => "10011110100",
            "85" => "10011110010",
            "86" => "11110100100",
            "87" => "11110010100",
            "88" => "11110010010",
            "89" => "11011011110",
            "90" => "11011110110",
            "91" => "11110110110",
            "92" => "10101111000",
            "93" => "10100011110",
            "94" => "10001011110",
            "95" => "10111101000",
            "96" => "10111100010",
            "97" => "11110101000",
            "98" => "11110100010",
            "99" => "10111011110",
            "100" => "10111101110",
            "101" => "11101011110",
            "102" => "11110101110",
            "103" => "11010000100",
            "104" => "11010010000",
            "105" => "11010011100",
            "START" => "11010011100",
            "FNC1" => "11110101110",
            "STOP" => "11000111010",
            "TERMINATE" => "11",
            "START_DATA" => "105",
            "FNC1_DATA" => "102"
        ];

        $barcodeData = "";

        $arrData = str_split($data, 2);
        $checksum = (int) $codes['START_DATA'];
        $i = 1;
        foreach($arrData as $pair) {
            $i++;
            $checksum += (int) $pair * $i;

            $transPair = $codes[$pair];
            if($transPair != '') {
                $barcodeData .= $transPair;
            } else {
                throw new Exception("Incorrect barcode data");
            }
        }

        $checksum += (int)$codes['FNC1_DATA'];
        $checksum = $checksum % 103;

        $codeKeys = array_keys($codes);
        $barcodeData .= $codes[$codeKeys[$checksum]];

        $finalBarcode = $codes['START'] . $codes['FNC1'] . $barcodeData . $codes['STOP'] . $codes['TERMINATE'];

        return $finalBarcode;
    }
}