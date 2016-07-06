<?php
/**
 * @see https://leetcode.com/problems/russian-doll-envelopes/
 * You have a number of envelopes with widths and heights given as a pair of integers (w, h). One envelope can fit into another if and only if both the width and height of one envelope is greater than the width and height of the other envelope.
 * What is the maximum number of envelopes can you Russian doll? (put one inside other)
 */
error_reporting(E_ALL);
define('DEBUG', 0);

$inputs = array();
$inputs[] = [[5, 4], [6, 4], [6, 7], [2, 3]];
$inputs[] = [[5, 4], [6, 4], [6, 7], [2, 3], [7, 8], [1, 7]];
$inputs[] = [];


foreach ($inputs as $input) {
  echo "\n";
  echo "Input: " , json_encode($input), "\n";

  // old solution -
  // echo "Output: ", russian_dolls($input);

  $solution = array();
  echo "Result: ", russian_dolls2($input, $solution), "\n";
  echo "Solution: ", json_encode($solution), "\n";
  echo "\n";
}


/**
 * O(n^2)
 * @param array $dolls
 * @param array $solution
 * @return int
 */
function russian_dolls2($dolls, &$solution = array()) {
  if (empty($dolls)) return 0;

  // if in recursive call
  if (!empty($solution)) {
    $last = end($solution);
    // remove all dolls that can't fit
    foreach ($dolls as $k => $doll) {
      if (($last[0] >= $doll[0]) or ($last[1] >= $doll[1])) {
        unset($dolls[$k]);
      }
    }
  }

  $best_solution = 0;
  $best_solution_list = null;

  // go through all dolls that can fit
  foreach ($dolls as $k => $doll) {
    $_solution = $solution;
    $_solution[] = $doll;

    $_dolls2 = $dolls;
    unset($_dolls2[$k]);

    // find sub-solution on all other dolls
    russian_dolls2($_dolls2, $_solution);
    if (DEBUG) echo json_encode($_solution), " - " . count($_solution) . "\n";

    // save if it's better than the best
    if (count($_solution) > $best_solution) {
      $best_solution = count($_solution);
      $best_solution_list = $_solution;
    }
  }

  // save
  $solution = $best_solution_list;
  return $best_solution;
}


/**
 * @param $dolls
 * @return array
 * /
function russian_dolls($dolls)
{
  if (empty($dolls)) return 0;

// sort by width
  usort($dolls, function ($a, $b) {
    return ($a[0] <=> $b[0]);
  });
  $solutions = generate_solutions($dolls);


// by height
  usort($dolls, function ($a, $b) {
    return ($a[1] <=> $b[1]);
  });
  $solutions2 = generate_solutions($dolls);

//  // by size
//  usort($_dolls, function($a, $b) {
//    return ($a[0] <=> $b[0]);
//  });
//  $solutions = generate_solutions($_dolls);

  return max(max($solutions), max($solutions2));
}

list($solutions, $solutions2) = russian_dolls($dolls);


function generate_solutions($_dolls)
{
  // generate all possible solutions.
  // pick first doll
  $solutions = array();
  foreach ($_dolls as $k => $doll) {
    $solution = array();
    $solution[] = $doll;

    $_dolls2 = $_dolls;
    unset($_dolls2[$k]);

    foreach ($_dolls2 as $_doll) {
      if (($doll[0] < $_doll[0]) and ($doll[1] < $_doll[1])) {
        $solution[] = $_doll;
        $doll = $_doll;
      }
    }

    $solutions[] = count($solution);
    if (DEBUG) echo json_encode($solution), "\n";
  }
  if (DEBUG) echo "\n";
  return $solutions;
}
*/