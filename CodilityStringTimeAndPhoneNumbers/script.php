<?php

$s = '00:01:07,400-234-090 00:05:01,701-080-080 00:05:00,400-234-090';

$stringListTime = [];
$splitstring = explode(' ',$s);

foreach ($splitstring as $rowTime) {
    $splitrowTime = strstr($rowTime,',', true);
    $stringListTime[] = $splitrowTime;
}

$stringListPhone = [];
foreach ($splitstring as $key => $rowPhone) {
            $splitrowPhoneWithComma = str_replace($stringListTime[$key], '', $splitstring[$key]);
            $splitrowPhoneWithoutComma = str_replace(',', '', $splitrowPhoneWithComma);
            $stringListPhone[] = $splitrowPhoneWithoutComma;
}

$count = 0;
$listOfRepeatTimes = [];
for ($i=0; $i<3; $i++) {
    if (substr_count($s, $stringListPhone[$i]) > 1) {
        $repeatedPhone = $stringListPhone[$i];
    }

//static rule
    $fiveMinutesValue = (date('i', strtotime('00:05:00')) * 60);

    for ($i = 0; $i < 3; $i++) {
        $minute = date('i', strtotime($stringListTime[$i]));
        $second = date('s', strtotime($stringListTime[$i]));
        $totalTime = ($minute * 60) + $second;

        //for repeated phones
        if ($stringListTime[$i] . ',' . $repeatedPhone == $splitstring[$i]) {
            //shorter than five minutes rule
            if ((date('i', strtotime($stringListTime[$i])) * 60) < $fiveMinutesValue) {
                $durationPayShorterRepeated = ((date('i', strtotime($stringListTime[$i])) * 60) + $second) * 3;
            }
            //at least five minutes long
            if ((date('i', strtotime($stringListTime[$i])) * 60) >= $fiveMinutesValue) {
                $durationPayAtLeastRepeated = (date('i', strtotime($stringListTime[$i]))) * 150;

                if ((date('i', strtotime($stringListTime[$i])) * 60) > 300) {
                    $timesCentsToPay = $totalTime / 60;
                    if ((int)$timesCentsToPay == 5) {
                        $timesCentsToPay = 6;
                    }
                    $durationPayAtLeastRepeated = $timesCentsToPay * 150;
                }
            }
            $repeatedPhoneTotalPayment = $durationPayShorterRepeated + $durationPayAtLeastRepeated;
            //not reapeated phones
        } else {
            //shorter than five minutes rule
            if ((date('i', strtotime($stringListTime[$i])) * 60) < $fiveMinutesValue) {
                $durationPayShorter = ((date('i', strtotime($stringListTime[$i])) * 60) + $second) * 3;
            }
            //at least five minutes long
            if ((date('i', strtotime($stringListTime[$i])) * 60) >= $fiveMinutesValue) {
                $durationPayAtLeast = (date('i', strtotime($stringListTime[$i]))) * 150;

                if ((date('i', strtotime($stringListTime[$i])) * 60) > 300) {
                    $timesCentsToPay = $totalTime / 60;
                    if ((int)$timesCentsToPay == 5) {
                        $timesCentsToPay = 6;
                    }
                    $durationPayAtLeast = $timesCentsToPay * 150;
                }
            }
            $notRepeatedPhoneTotalPayment = $durationPayShorter + $durationPayAtLeast;
        }

         $totalPayment = $repeatedPhoneTotalPayment + $notRepeatedPhoneTotalPayment;

        if ($stringListTime[$i] < $stringListTime[$i+1]) {
            $smaller = $stringListTime[$i];
        }
        if ($stringListTime[$i] != $smaller) {
            if ($smaller < $stringListTime[$i]) {
                $smaller = $stringListTime[$i];
                $greaterCallTime = $smaller;
            }
        }
        if ($greaterCallTime == $stringListTime[$i]) {
            if($greaterCallTime.','.$stringListPhone[$i] == $splitstring[$i]){
                $rawPhoneNumber = explode('-', $stringListPhone[$i]);
                $rawPhoneNumberToCompare[] = (int) ($rawPhoneNumber[0].$rawPhoneNumber[1].$rawPhoneNumber[2]);
                if ($rawPhoneNumberToCompare[1] < $rawPhoneNumberToCompare[0]) {
                    return $totalPayment = (float) 0;

                }
            }
        }
        if($greaterCallTime.','.$stringListPhone[$i] == $splitstring[$i]){
            return $totalPayment = (float) 0;
        }
    }
}
    return $totalPayment;
