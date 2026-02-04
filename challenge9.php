<?php

$marks = 85;


echo "Input: " . $marks . "\n";


if ($marks >= 90) {
    $grade = "A";
} elseif ($marks >= 80) {
    $grade = "B";
} elseif ($marks >= 70) {
    $grade = "C";
} elseif ($marks >= 60) {
    $grade = "D";
} else {
    $grade = "F";
}

echo "Output: You got a " . $grade . "!";
?>