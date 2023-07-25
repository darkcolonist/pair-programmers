<?php
header("Content-type: text/plain");
function readMemberNames($filename) {
    $memberNames = [];
    $file = fopen($filename, "r");
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $memberNames[] = trim($line);
        }
        fclose($file);
    }
    return $memberNames;
}

function rotateArray(&$arr) {
    $first = array_shift($arr);
    array_push($arr, $first);
}

function generatePairUps($members) {
    $totalMembers = count($members);
    $pairUps = [];

    for ($i = 0; $i < $totalMembers - 1; $i++) {
        rotateArray($members);

        for ($j = 0; $j < $totalMembers / 2; $j++) {
            $pairUps[] = [$members[$j], $members[$j + $totalMembers / 2]];
        }
    }

    return $pairUps;
}

// Input file name
$filename = "members.txt";

// Read member names from the file
$memberNames = readMemberNames($filename);

// Generate the pair-ups
$pairUps = generatePairUps($memberNames);

// Display the results
echo "Pair-ups:\n";
foreach ($pairUps as $pair) {
    echo $pair[0] . " -> " . $pair[1] . "\n";
}
?>