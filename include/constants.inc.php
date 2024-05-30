<?php

$creditsPerDayNormal = 50;
$creditsPerEuro = 10000;
$InitialCredits = 10000;
$eurosPerCredit = 1 / $creditsPerEuro;
$creditsPerGBPerDay = 20;
$creditsPerSummary = 100;
$exampleGB = 10;

function roundToTwo($number)
{
  return round($number, 2);
}

$CONSTANTS = [
  "CreditsPerEuro" => $creditsPerEuro,
  "InitialCredits" => $InitialCredits,
  "ExampleGB" => $exampleGB,
  "EurosPerCredit" => $eurosPerCredit,
  "CreditsPerSummary" => $creditsPerSummary,
  "CreditsPerDayNormal" => $creditsPerDayNormal,
  "EurosPerMonthNormal" => roundToTwo($creditsPerDayNormal * 30 * $eurosPerCredit),
  "EurosPerYearNormal" => roundToTwo($creditsPerDayNormal * 365 * $eurosPerCredit),
  "EurosPerGBPerMonth" => roundToTwo($creditsPerGBPerDay * 30 * $eurosPerCredit),
  "EurosPerGBPerYear" => roundToTwo($creditsPerGBPerDay * 365 * $eurosPerCredit),
  "CreditsPerGBPerDay" => $creditsPerGBPerDay,
  "EurosPerExampleGBPerMonth" => roundToTwo($creditsPerGBPerDay * $exampleGB * 30 * $eurosPerCredit),
  "EurosPerExampleGBPerYear" => roundToTwo($creditsPerGBPerDay * $exampleGB * 365 * $eurosPerCredit),
  "EurosPerSummary" => roundToTwo($creditsPerSummary * $eurosPerCredit),
];