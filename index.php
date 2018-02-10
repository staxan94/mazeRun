<?php
header("Content-type: text/html; charset=utf-8");
/**
 * Created by PhpStorm.
 * User: Наталья
 * Date: 08.02.2018
 * Time: 18:24
 */


include "head.html";

$maze = [
    [1, 1, 1, 0, 1, 1, 1, 1, 1, 1],
    [1, 0, 0, 0, 0, 1, 0, 1, 0, 1],
    [1, 1, 0, 1, 1, 1, 0, 1, 0, 1],
    [1, 1, 0, 0, 1, 0, 0, 1, 0, 1],
    [1, 1, 1, 0, 1, 0, 1, 0, 0, 1],
    [1, 0, 0, 0, 1, 0, 0, 0, 1, 1],
    [1, 0, 1, 0, 1, 0, 1, 0, 1, 1],
    [1, 0, 1, 0, 1, 0, 1, 0, 1, 1],
    [1, 0, 1, 0, 0, 0, 1, 1, 1, 1],
    [1, 1, 1, 1, 0, 1, 1, 1, 1, 1]
];

$directions = ["up", "right", "down", "left"];

$position = [9,4];
$direction = 0;


function stepUp($direction, &$position) {
    switch ($direction) {
        case 0: $position[0]--; break;
        case 1: $position[1]++; break;
        case 2: $position[0]++; break;
        case 3: $position[1]--; break;
    }
    return $position;
};

function turnLeft(&$direction) {
    if ($direction == 0) {
        return $direction = 3;
    }
    return $direction--;
}

function turnRight(&$direction) {
    if ($direction == 3) {
        return $direction = 0;
    }
    return $direction++;
}

function wallBefore($direction, $position, $maze) {
    switch ($direction) {
        case 0: if ($maze[$position[0] - 1][$position[1]] == 1) return true; break;
        case 1: if ($maze[$position[0]][$position[1] + 1] == 1) return true; break;
        case 2: if ($maze[$position[0] + 1][$position[1]] == 1) return true; break;
        case 3: if ($maze[$position[0]][$position[1] - 1] == 1) return true; break;
        default : return false;
    }
}

function wallRight($direction, $position, $maze) {
    switch ($direction) {
        case 0: if ($maze[$position[0]][$position[1] + 1] == 1) return true; break;
        case 1: if ($maze[$position[0] + 1][$position[1]] == 1) return true; break;
        case 2: if ($maze[$position[0]][$position[1] - 1] == 1) return true; break;
        case 3: if ($maze[$position[0] - 1][$position[1]] == 1) return true; break;
        default : return false;
    }
}

displayMaze($maze, $position, $direction);

while ($position !== [0,3]) {
    if (wallRight($direction, $position, $maze) && wallBefore($direction, $position, $maze)) {
        turnLeft($direction);
        displayMaze($maze, $position, $direction);
    }
    if (!wallRight($direction, $position, $maze)) {
        turnRight($direction);
        displayMaze($maze, $position, $direction);
    }
    if (!wallBefore($direction, $position, $maze)) {
        stepUp($direction, $position);
        displayMaze($maze, $position, $direction);
    }
}

if ($position == [0,3]) {
    displayWin();
}

function displayMaze($maze, $position, $direction) {

    echo "<div class=\"main\">";
        for ($i = 0; $i < 10; $i++){
            for ($j = 0; $j < 10; $j++) {
                if ($maze[$i][$j] == 0) {
                    if ($i == $position[0] && $j == $position[1]) {
                        switch ($direction) {
                            case 0: echo "<div class=\"cell man up\">";
                                    echo "</div>";
                                    break;
                            case 1: echo "<div class=\"cell man right\">";
                                    echo "</div>";
                                    break;
                            case 2: echo "<div class=\"cell man down \">";
                                    echo "</div>";
                                    break;
                            case 3: echo "<div class=\"cell man left\">";
                                    echo "</div>";
                                    break;
                        }
                    } else {
                        echo "<div class=\"cell\">";
                        echo "</div>";
                    }
                } else {
                    echo "<div class=\"cell wall\">";
                    echo "</div>";
                }
            }
        }
    echo "</div>";
    echo "<p> Direction: ";
    switch ($direction) {
        case 0: echo "up"; break;
        case 1: echo "right"; break;
        case 2: echo "down"; break;
        case 3: echo "left"; break;
    }
    echo "<br>Position: ";
    echo "X(" . $position[0] . ")";
    echo "Y(" . $position[1] . ")";

    echo "<br>Wall: ";
    if (wallRight($direction,$position,$maze)) {
        echo "right,";
    }
    if (wallBefore($direction,$position,$maze)) {
        echo "before";
    }
    echo "</p>";
}

function displayWin() {
    echo "<div class=\"win\">";
    echo "<h1>Congratulations!</h1>";
    echo "<p>you are the best maze runner</p>";
    echo "</div>";
}

include "foot.html";

?>



