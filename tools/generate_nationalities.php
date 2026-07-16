<?php

declare(strict_types=1);

$source = __DIR__ . '/../services/portal-service/database/data/countries.json';
$destination = __DIR__ . '/../services/portal-service/database/data/nationalities.json';

if (! file_exists($source)) {
    exit("Source file not found:\n{$source}\n");
}

$countries = json_decode(file_get_contents($source), true);

if (! is_array($countries)) {
    exit("Failed to parse countries.json\n");
}

$nationalities = [];

foreach ($countries as $country) {
    $code = $country['cca2'] ?? null;
    $countryName = $country['name']['common'] ?? null;

    $demonyms = $country['demonyms']['eng'] ?? null;

    if (! $code || ! $countryName || ! is_array($demonyms)) {
        continue;
    }

    $nationality = $demonyms['m'] ?? $demonyms['f'] ?? null;

    if (! $nationality) {
        continue;
    }

    $nationalities[] = [
        'code' => $code,
        'country_name' => $countryName,
        'name' => $nationality,
    ];
}

usort(
    $nationalities,
    fn ($a, $b) => strcmp($a['name'], $b['name'])
);

file_put_contents(
    $destination,
    json_encode(
        $nationalities,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    )
);

echo "Generated " . count($nationalities) . " nationalities.\n";
echo "Output: {$destination}\n";