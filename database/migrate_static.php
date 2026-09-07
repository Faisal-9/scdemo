<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("This script must be run from the command line." . PHP_EOL);
}


/*
|--------------------------------------------------------------------------
| PATHS
|--------------------------------------------------------------------------
*/

$root = dirname(__DIR__);

$dataDir = $root
    . DIRECTORY_SEPARATOR
    . 'includes'
    . DIRECTORY_SEPARATOR
    . 'data';


if (!is_dir($dataDir)) {
    exit(
        "ERROR: Data directory not found:" . PHP_EOL
        . $dataDir . PHP_EOL
    );
}


/*
|--------------------------------------------------------------------------
| DATABASE
|--------------------------------------------------------------------------
*/

$dbHost = 'localhost';
$dbName = 'statecorps_db';
$dbUser = 'root';
$dbPass = '';
$dbCharset = 'utf8mb4';


$dsn = "mysql:host={$dbHost};dbname={$dbName};charset={$dbCharset}";


try {

    $pdo = new PDO(
        $dsn,
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );

} catch (PDOException $e) {

    exit(
        "ERROR: Database connection failed." . PHP_EOL
        . $e->getMessage()
        . PHP_EOL
    );
}


/*
|--------------------------------------------------------------------------
| HELPERS
|--------------------------------------------------------------------------
*/

function loadPhpVariables(string $file): array
{
    if (!is_file($file)) {
        throw new RuntimeException(
            "Source file not found: {$file}"
        );
    }

    return (static function (string $file): array {
        require $file;

        return get_defined_vars();
    })($file);
}


function findVariable(
    array $variables,
    array $preferredNames,
    ?callable $validator = null,
    bool $required = true
) {
    foreach ($preferredNames as $name) {

        if (!array_key_exists($name, $variables)) {
            continue;
        }

        $value = $variables[$name];

        if ($validator === null || $validator($value)) {
            return $value;
        }
    }


    /*
     * Fallback:
     * Search every defined variable.
     */
    if ($validator !== null) {

        foreach ($variables as $name => $value) {

            /*
             * Ignore PHP internal variables.
             */
            if (in_array(
                $name,
                [
                    'file',
                    'variables',
                ],
                true
            )) {
                continue;
            }

            if ($validator($value)) {
                return $value;
            }
        }
    }


    if ($required) {

        $available = array_keys($variables);

        throw new RuntimeException(
            "Could not identify required data variable. "
            . "Available variables: "
            . implode(', ', $available)
        );
    }

    return null;
}


function isArrayValue($value): bool
{
    return is_array($value);
}


function looksLikeHeroSlides($value): bool
{
    if (!is_array($value) || $value === []) {
        return false;
    }

    foreach ($value as $item) {

        if (!is_array($item)) {
            continue;
        }

        if (
            isset($item['image'])
            && (
                isset($item['title'])
                || isset($item['subtitle'])
                || isset($item['sub'])
            )
        ) {
            return true;
        }
    }

    return false;
}


function looksLikeStats($value): bool
{
    if (!is_array($value) || $value === []) {
        return false;
    }

    foreach ($value as $item) {

        if (!is_array($item)) {
            continue;
        }

        if (
            array_key_exists('number', $item)
            && (
                isset($item['label'])
                || isset($item['suffix'])
            )
        ) {
            return true;
        }
    }

    return false;
}


function looksLikeHistory($value): bool
{
    if (!is_array($value) || $value === []) {
        return false;
    }

    foreach ($value as $item) {

        if (!is_array($item)) {
            continue;
        }

        if (
            isset($item['year'])
            && isset($item['title'])
        ) {
            return true;
        }
    }

    return false;
}


function looksLikeWhyTabs($value): bool
{
    if (!is_array($value) || $value === []) {
        return false;
    }

    foreach ($value as $item) {

        if (!is_array($item)) {
            continue;
        }

        if (
            isset($item['tabname'])
            || isset($item['tab_name'])
        ) {
            return true;
        }
    }

    return false;
}


function looksLikeProjects($value): bool
{
    if (!is_array($value) || $value === []) {
        return false;
    }

    foreach ($value as $item) {

        if (!is_array($item)) {
            continue;
        }

        if (
            isset($item['id'])
            && isset($item['name'])
            && (
                isset($item['thumbnail'])
                || isset($item['description'])
                || isset($item['scope'])
            )
        ) {
            return true;
        }
    }

    return false;
}


function looksLikeMedia($value): bool
{
    if (!is_array($value) || $value === []) {
        return false;
    }

    $foundKnownType = false;

    foreach ($value as $key => $items) {

        if (
            in_array(
                strtolower((string) $key),
                [
                    'news',
                    'events',
                    'gallery',
                ],
                true
            )
        ) {
            $foundKnownType = true;

            if (is_array($items)) {
                return true;
            }
        }
    }

    return $foundKnownType;
}


function toNullableString($value): ?string
{
    if ($value === null) {
        return null;
    }

    if (is_array($value)) {
        return null;
    }

    $value = (string) $value;

    return $value === ''
        ? null
        : $value;
}


function toText($value): ?string
{
    if ($value === null) {
        return null;
    }

    if (is_array($value)) {

        $parts = [];

        foreach ($value as $part) {

            if (!is_scalar($part)) {
                continue;
            }

            $part = (string) $part;

            if (trim($part) === '') {
                continue;
            }

            $parts[] = $part;
        }

        if ($parts === []) {
            return null;
        }

        return implode(
            PHP_EOL . PHP_EOL,
            $parts
        );
    }

    $value = (string) $value;

    return trim($value) === ''
        ? null
        : $value;
}


function yesNo($value): int
{
    return strtolower(
        trim((string) $value)
    ) === 'yes'
        ? 1
        : 0;
}


function normalizeDate(?string $value): ?string
{
    if ($value === null) {
        return null;
    }

    $value = trim($value);

    if ($value === '') {
        return null;
    }

    $value = preg_replace(
        '/,\s*/',
        ', ',
        $value
    );

    if ($value === null) {
        return null;
    }

    $formats = [
        'j M, Y',
        'd M, Y',
        'j M Y',
        'd M Y',
    ];

    foreach ($formats as $format) {

        $date = DateTime::createFromFormat(
            '!' . $format,
            $value
        );

        if ($date !== false) {
            return $date->format('Y-m-d');
        }
    }

    return null;
}


function insertRow(
    PDO $pdo,
    string $table,
    array $data
): int {

    if ($data === []) {
        throw new RuntimeException(
            "Cannot insert empty row into {$table}."
        );
    }

    $columns = array_keys($data);

    $columnSql = implode(
        ', ',
        array_map(
            static function ($column): string {
                return '`' . $column . '`';
            },
            $columns
        )
    );

    $placeholderSql = implode(
        ', ',
        array_map(
            static function ($column): string {
                return ':' . $column;
            },
            $columns
        )
    );

    $sql =
        "INSERT INTO `{$table}` "
        . "({$columnSql}) "
        . "VALUES ({$placeholderSql})";


    $stmt = $pdo->prepare($sql);


    foreach ($data as $column => $value) {

        $stmt->bindValue(
            ':' . $column,
            $value
        );
    }


    $stmt->execute();


    return (int) $pdo->lastInsertId();
}


function tableExists(
    PDO $pdo,
    string $table
): bool {

    $stmt = $pdo->prepare(
        "SELECT COUNT(*)
         FROM information_schema.tables
         WHERE table_schema = DATABASE()
         AND table_name = :table"
    );

    $stmt->execute([
        ':table' => $table,
    ]);

    return (int) $stmt->fetchColumn() > 0;
}


function tableCount(
    PDO $pdo,
    string $table
): int {

    return (int) $pdo
        ->query(
            "SELECT COUNT(*) FROM `{$table}`"
        )
        ->fetchColumn();
}


function requireEmptyTables(
    PDO $pdo,
    array $tables
): void {

    foreach ($tables as $table) {

        if (!tableExists($pdo, $table)) {
            throw new RuntimeException(
                "Missing database table: {$table}"
            );
        }


        $count = tableCount(
            $pdo,
            $table
        );


        if ($count > 0) {

            throw new RuntimeException(
                "Table '{$table}' already contains "
                . "{$count} row(s). "
                . "Migration stopped to prevent duplicates."
            );
        }
    }
}


/*
|--------------------------------------------------------------------------
| BEGIN
|--------------------------------------------------------------------------
*/

echo PHP_EOL;
echo "============================================================" . PHP_EOL;
echo " STATE CORPS - STATIC DATA MIGRATION" . PHP_EOL;
echo "============================================================" . PHP_EOL;
echo PHP_EOL;

echo "Database: {$dbName}" . PHP_EOL;
echo "Source:   {$dataDir}" . PHP_EOL;
echo PHP_EOL;


/*
|--------------------------------------------------------------------------
| SOURCE FILES
|--------------------------------------------------------------------------
*/

$homeFile = $dataDir
    . DIRECTORY_SEPARATOR
    . 'homedata.php';

$aboutFile = $dataDir
    . DIRECTORY_SEPARATOR
    . 'aboutdata.php';

$projectsFile = $dataDir
    . DIRECTORY_SEPARATOR
    . 'projectsdata.php';

$servicesFile = $dataDir
    . DIRECTORY_SEPARATOR
    . 'servicesdata.php';

$sectorsFile = $dataDir
    . DIRECTORY_SEPARATOR
    . 'sectorsdata.php';

$mediaFile = $dataDir
    . DIRECTORY_SEPARATOR
    . 'mediadata.php';

$policiesFile = $dataDir
    . DIRECTORY_SEPARATOR
    . 'policiesdata.php';

$termsFile = $dataDir
    . DIRECTORY_SEPARATOR
    . 'termsOfServicesData.php';


$files = [
    $homeFile,
    $aboutFile,
    $projectsFile,
    $servicesFile,
    $sectorsFile,
    $mediaFile,
    $policiesFile,
    $termsFile,
];


foreach ($files as $file) {

    if (!is_file($file)) {
        throw new RuntimeException(
            "Missing source file: {$file}"
        );
    }
}


/*
|--------------------------------------------------------------------------
| LOAD EACH SOURCE FILE
|--------------------------------------------------------------------------
|
| This is the important change.
|
| We DO NOT assume the local file contains variables named:
|
|   $heroSlides
|   $projects
|   $services
|   ...
|
| We read the variables that the actual local PHP file defines.
|
*/

echo "Loading source files..." . PHP_EOL;


$homeVars = loadPhpVariables(
    $homeFile
);

$aboutVars = loadPhpVariables(
    $aboutFile
);

$projectVars = loadPhpVariables(
    $projectsFile
);

$serviceVars = loadPhpVariables(
    $servicesFile
);

$sectorVars = loadPhpVariables(
    $sectorsFile
);

$mediaVars = loadPhpVariables(
    $mediaFile
);

$policyVars = loadPhpVariables(
    $policiesFile
);

$termsVars = loadPhpVariables(
    $termsFile
);


echo "Source files loaded." . PHP_EOL;
echo PHP_EOL;


/*
|--------------------------------------------------------------------------
| IDENTIFY HOMEPAGE DATA
|--------------------------------------------------------------------------
*/

$heroSlides = findVariable(
    $homeVars,
    [
        'heroSlides',
        'hero_slides',
        'hero',
        'heroes',
        'homeHero',
        'home_hero',
    ],
    'looksLikeHeroSlides',
    true
);


$stats = findVariable(
    $homeVars,
    [
        'stats',
        'homeStats',
        'home_stats',
    ],
    'looksLikeStats',
    true
);


$history = findVariable(
    $homeVars,
    [
        'history',
        'homeHistory',
        'home_history',
    ],
    'looksLikeHistory',
    true
);


$whySC = findVariable(
    $homeVars,
    [
        'whySC',
        'whySc',
        'whySCData',
        'why',
        'whyStateCorps',
        'why_state_corps',
    ],
    'looksLikeWhyTabs',
    true
);


/*
 * Background is optional.
 *
 * Some local versions may use:
 *
 *   $statsBg
 *
 * while another version may call it something else.
 */
$statsBg = findVariable(
    $homeVars,
    [
        'statsBg',
        'statsBG',
        'stats_background',
        'statsBackground',
        'whyBg',
        'whyBG',
    ],
    static function ($value): bool {
        return is_string($value);
    },
    false
);


/*
|--------------------------------------------------------------------------
| IDENTIFY PROJECTS
|--------------------------------------------------------------------------
*/

$projects = findVariable(
    $projectVars,
    [
        'projects',
        'projectData',
        'projectsData',
        'project_data',
    ],
    'looksLikeProjects',
    true
);


/*
|--------------------------------------------------------------------------
| IDENTIFY MEDIA
|--------------------------------------------------------------------------
*/

$media = findVariable(
    $mediaVars,
    [
        'media',
        'mediaData',
        'media_data',
    ],
    'looksLikeMedia',
    true
);


/*
|--------------------------------------------------------------------------
| SERVICES / SECTORS / ABOUT / LEGAL
|--------------------------------------------------------------------------
|
| For these files the names used by the current repository are preferred.
| If the local variable names differ, we search for an array.
|
*/


$services = findVariable(
    $serviceVars,
    [
        'services',
        'serviceData',
        'servicesData',
        'service_data',
    ],
    'isArrayValue',
    true
);


$sectors = findVariable(
    $sectorVars,
    [
        'sectors',
        'sectorData',
        'sectorsData',
        'sector_data',
    ],
    'isArrayValue',
    true
);


$generalInfo = findVariable(
    $aboutVars,
    [
        'generalInfo',
        'general_info',
        'aboutInfo',
        'about_info',
    ],
    'isArrayValue',
    true
);


$missionVision = findVariable(
    $aboutVars,
    [
        'missionVision',
        'mission_vision',
        'missionAndVision',
    ],
    'isArrayValue',
    true
);


$clients = findVariable(
    $aboutVars,
    [
        'clients',
        'clientData',
        'clientsData',
    ],
    'isArrayValue',
    true
);


$certificates = findVariable(
    $aboutVars,
    [
        'certificates',
        'certificateData',
        'certificatesData',
    ],
    'isArrayValue',
    true
);


$awards = findVariable(
    $aboutVars,
    [
        'awards',
        'awardData',
        'awardsData',
    ],
    'isArrayValue',
    true
);


$sisterCompanies = findVariable(
    $aboutVars,
    [
        'sisterCompanies',
        'sister_companies',
        'affiliatedCompanies',
        'affiliated_companies',
    ],
    'isArrayValue',
    true
);


$hse = findVariable(
    $aboutVars,
    [
        'hse',
        'HSE',
        'hseData',
    ],
    'isArrayValue',
    true
);


$cprofile = findVariable(
    $aboutVars,
    [
        'cprofile',
        'companyProfile',
        'company_profile',
    ],
    'isArrayValue',
    true
);


$policies = findVariable(
    $policyVars,
    [
        'policies',
        'policyData',
        'policiesData',
    ],
    'isArrayValue',
    true
);


$TermsOfService = findVariable(
    $termsVars,
    [
        'TermsOfService',
        'termsOfService',
        'terms_of_service',
        'terms',
        'Terms',
    ],
    'isArrayValue',
    true
);


/*
|--------------------------------------------------------------------------
| REPORT IDENTIFIED VARIABLES
|--------------------------------------------------------------------------
*/

echo "Identified data structures:" . PHP_EOL;
echo PHP_EOL;

echo "Homepage:" . PHP_EOL;
echo "  hero slides  : " . count($heroSlides) . PHP_EOL;
echo "  statistics   : " . count($stats) . PHP_EOL;
echo "  history      : " . count($history) . PHP_EOL;
echo "  why tabs     : " . count($whySC) . PHP_EOL;

if ($statsBg !== null) {
    echo "  background   : detected" . PHP_EOL;
} else {
    echo "  background   : not found" . PHP_EOL;
}

echo PHP_EOL;

echo "Projects      : " . count($projects) . PHP_EOL;
echo "Services      : " . count($services) . PHP_EOL;
echo "Sectors       : " . count($sectors) . PHP_EOL;
echo "Media types   : " . count($media) . PHP_EOL;

echo PHP_EOL;


/*
|--------------------------------------------------------------------------
| DATABASE TABLES
|--------------------------------------------------------------------------
*/

$targetTables = [

    'site_settings',

    'home_hero_slides',
    'home_stats',
    'home_history',
    'home_why_tabs',
    'home_why_items',

    'about_page',
    'about_history',
    'about_core_values',
    'about_clients',
    'about_certificates',
    'about_awards',
    'about_affiliated_companies',

    'projects',
    'project_images',
    'project_scope',

    'sectors',
    'sector_stats',
    'sector_why',
    'sector_areas',
    'sector_sections',
    'sector_section_images',
    'sector_section_stats',

    'service_groups',
    'service_categories',
    'service_items',
    'service_features',

    'media_items',
    'media_descriptions',
    'media_tags',
    'media_item_tags',

    'legal_documents',
    'legal_sections',
    'legal_section_items',
];


requireEmptyTables(
    $pdo,
    $targetTables
);


/*
|--------------------------------------------------------------------------
| TRANSACTION
|--------------------------------------------------------------------------
*/

$pdo->beginTransaction();


try {

    /*
    |--------------------------------------------------------------------------
    | HOMEPAGE
    |--------------------------------------------------------------------------
    */

    $heroCount = 0;
    $statsCount = 0;
    $historyCount = 0;
    $whyTabCount = 0;
    $whyItemCount = 0;


    foreach (
        $heroSlides as $order => $slide
    ) {

        if (!is_array($slide)) {
            continue;
        }


        insertRow(
            $pdo,
            'home_hero_slides',
            [
                'legacy_id' =>
                    toNullableString(
                        $slide['id'] ?? null
                    ),

                'title' =>
                    (string) (
                        $slide['title']
                        ?? $slide['subtitle']
                        ?? ''
                    ),

                'description' =>
                    toText(
                        $slide['desc']
                        ?? $slide['description']
                        ?? null
                    ),

                'image_path' =>
                    (string) (
                        $slide['image']
                        ?? ''
                    ),

                'indicator' =>
                    toNullableString(
                        $slide['indicator']
                        ?? null
                    ),

                'sort_order' =>
                    (int) $order,

                'is_active' =>
                    1,
            ]
        );

        $heroCount++;
    }


    foreach (
        $stats as $order => $stat
    ) {

        if (!is_array($stat)) {
            continue;
        }


        insertRow(
            $pdo,
            'home_stats',
            [
                'prefix' =>
                    toNullableString(
                        $stat['prefix']
                        ?? null
                    ),

                'number_value' =>
                    isset($stat['number'])
                        && is_numeric($stat['number'])
                            ? (float) $stat['number']
                            : 0,

                'suffix' =>
                    toNullableString(
                        $stat['suffix']
                        ?? null
                    ),

                'label' =>
                    (string) (
                        $stat['label']
                        ?? ''
                    ),

                'sort_order' =>
                    (int) $order,

                'is_active' =>
                    1,
            ]
        );

        $statsCount++;
    }


    foreach (
        $history as $order => $item
    ) {

        if (!is_array($item)) {
            continue;
        }


        insertRow(
            $pdo,
            'home_history',
            [
                'year' =>
                    (string) (
                        $item['year']
                        ?? ''
                    ),

                'title' =>
                    (string) (
                        $item['title']
                        ?? ''
                    ),

                'sort_order' =>
                    (int) $order,

                'is_active' =>
                    1,
            ]
        );

        $historyCount++;
    }


    foreach (
        $whySC as $legacyId => $tab
    ) {

        if (!is_array($tab)) {
            continue;
        }


        $tabId = insertRow(
            $pdo,
            'home_why_tabs',
            [
                'legacy_id' =>
                    (string) $legacyId,

                'tab_name' =>
                    (string) (
                        $tab['tabname']
                        ?? $tab['tab_name']
                        ?? $tab['name']
                        ?? ''
                    ),

                'title' =>
                    toNullableString(
                        $tab['title']
                        ?? null
                    ),

                'image_path' =>
                    toNullableString(
                        $tab['image']
                        ?? null
                    ),

                'sort_order' =>
                    $whyTabCount,

                'is_active' =>
                    1,
            ]
        );

        $whyTabCount++;


        $items =
            isset($tab['text'])
            && is_array($tab['text'])
                ? $tab['text']
                : [];


        foreach (
            $items as $itemOrder => $text
        ) {

            if (
                trim((string) $text) === ''
            ) {
                continue;
            }


            insertRow(
                $pdo,
                'home_why_items',
                [
                    'tab_id' =>
                        $tabId,

                    'item_text' =>
                        (string) $text,

                    'sort_order' =>
                        (int) $itemOrder,
                ]
            );

            $whyItemCount++;
        }
    }


    /*
     * Save background only when detected.
     */
    if ($statsBg !== null) {

        insertRow(
            $pdo,
            'site_settings',
            [
                'setting_key' =>
                    'homepage_why_background',

                'setting_value' =>
                    $statsBg,

                'setting_type' =>
                    'image',

                'description' =>
                    'Homepage Why State Corps background image',

                'updated_by' =>
                    null,
            ]
        );

    }


    /*
    |--------------------------------------------------------------------------
    | ABOUT
    |--------------------------------------------------------------------------
    */

    $missionTitle =
        $missionVision['title']
        ?? 'Mission & Vision';


    insertRow(
        $pdo,
        'about_page',
        [
            'id' =>
                1,

            'overview_title' =>
                (string) (
                    $generalInfo['title']
                    ?? 'Overview'
                ),

            'overview_content' =>
                toText(
                    $generalInfo['content']
                    ?? ''
                ) ?? '',

            'mission_title' =>
                (string) $missionTitle,

            'mission' =>
                toText(
                    $missionVision['mission']
                    ?? $missionVision['text']
                    ?? ''
                ) ?? '',

            'mission_image' =>
                toNullableString(
                    $missionVision['mission_img']
                    ?? (
                        isset($missionVision['mission'])
                        && is_array($missionVision['mission'])
                            ? null
                            : null
                    )
                ),

            'vision' =>
                toText(
                    $missionVision['vision']
                    ?? ''
                ) ?? '',

            'vision_image' =>
                toNullableString(
                    $missionVision['vision_img']
                    ?? null
                ),

            'core_values_image' =>
                toNullableString(
                    $missionVision['core_values_img']
                    ?? null
                ),

            'clients_title' =>
                toNullableString(
                    $clients['title']
                    ?? null
                ),

            'certificates_title' =>
                toNullableString(
                    $certificates['title']
                    ?? null
                ),

            'awards_title' =>
                toNullableString(
                    $awards['title']
                    ?? null
                ),

            'affiliated_companies_title' =>
                toNullableString(
                    $sisterCompanies['title']
                    ?? null
                ),

            'hse_title' =>
                toNullableString(
                    $hse['title']
                    ?? null
                ),

            'hse_content' =>
                toText(
                    $hse['content']
                    ?? null
                ),

            'company_profile_title' =>
                toNullableString(
                    $cprofile['title']
                    ?? null
                ),

            'company_profile_content' =>
                toText(
                    $cprofile['content']
                    ?? null
                ),

            'company_profile_file' =>
                toNullableString(
                    $cprofile['link']
                    ?? null
                ),
        ]
    );


    $count = 0;

    $historyItems =
        isset($generalInfo['items'])
        && is_array($generalInfo['items'])
            ? $generalInfo['items']
            : [];


    foreach (
        $historyItems as $order => $item
    ) {

        if (!is_array($item)) {
            continue;
        }


        insertRow(
            $pdo,
            'about_history',
            [
                'year' =>
                    (string) (
                        $item['year']
                        ?? ''
                    ),

                'title' =>
                    (string) (
                        $item['title']
                        ?? ''
                    ),

                'description' =>
                    toText(
                        $item['description']
                        ?? null
                    ),

                'image_path' =>
                    toNullableString(
                        $item['img']
                        ?? $item['image']
                        ?? null
                    ),

                'sort_order' =>
                    (int) $order,
            ]
        );

        $count++;
    }


    $coreValues =
        isset($missionVision['core_values'])
        && is_array($missionVision['core_values'])
            ? $missionVision['core_values']
            : [];


    $countCore = 0;


    foreach (
        $coreValues as $order => $value
    ) {

        insertRow(
            $pdo,
            'about_core_values',
            [
                'value_text' =>
                    (string) $value,

                'sort_order' =>
                    (int) $order,
            ]
        );

        $countCore++;
    }


    $clientItems =
        isset($clients['items'])
        && is_array($clients['items'])
            ? $clients['items']
            : [];


    $countClients = 0;


    foreach (
        $clientItems as $order => $client
    ) {

        /*
         * Some versions contain clients as plain strings.
         */
        if (is_string($client)) {

            $name = null;
            $logo = $client;

        } else {

            $name =
                isset($client['name'])
                    ? toNullableString(
                        $client['name']
                    )
                    : null;

            $logo =
                (string) (
                    $client['logo']
                    ?? $client['image']
                    ?? ''
                );
        }


        insertRow(
            $pdo,
            'about_clients',
            [
                'name' =>
                    $name,

                'logo_path' =>
                    $logo,

                'sort_order' =>
                    (int) $order,

                'is_active' =>
                    1,
            ]
        );

        $countClients++;
    }


    $certificateItems =
        isset($certificates['items'])
        && is_array($certificates['items'])
            ? $certificates['items']
            : [];


    $countCertificates = 0;


    foreach (
        $certificateItems as $order => $certificate
    ) {

        insertRow(
            $pdo,
            'about_certificates',
            [
                'name' =>
                    (string) (
                        $certificate['name']
                        ?? ''
                    ),

                'logo_path' =>
                    (string) (
                        $certificate['logo']
                        ?? $certificate['image']
                        ?? ''
                    ),

                'sort_order' =>
                    (int) $order,

                'is_active' =>
                    1,
            ]
        );

        $countCertificates++;
    }


    $awardItems =
        isset($awards['items'])
        && is_array($awards['items'])
            ? $awards['items']
            : [];


    $countAwards = 0;


    foreach (
        $awardItems as $order => $award
    ) {

        insertRow(
            $pdo,
            'about_awards',
            [
                'name' =>
                    (string) (
                        $award['name']
                        ?? ''
                    ),

                'logo_path' =>
                    (string) (
                        $award['logo']
                        ?? $award['image']
                        ?? ''
                    ),

                'sort_order' =>
                    (int) $order,

                'is_active' =>
                    1,
            ]
        );

        $countAwards++;
    }


    $companyItems =
        isset($sisterCompanies['items'])
        && is_array($sisterCompanies['items'])
            ? $sisterCompanies['items']
            : [];


    $countCompanies = 0;


    foreach (
        $companyItems as $order => $company
    ) {

        insertRow(
            $pdo,
            'about_affiliated_companies',
            [
                'name' =>
                    (string) (
                        $company['name']
                        ?? ''
                    ),

                'logo_path' =>
                    toNullableString(
                        $company['logo']
                        ?? $company['image']
                        ?? null
                    ),

                'sort_order' =>
                    (int) $order,

                'is_active' =>
                    1,
            ]
        );

        $countCompanies++;
    }


    /*
    |--------------------------------------------------------------------------
    | PROJECTS
    |--------------------------------------------------------------------------
    */

    $countProjects = 0;
    $countImages = 0;
    $countScope = 0;


    foreach (
        $projects as $order => $project
    ) {

        if (!is_array($project)) {
            continue;
        }


        $legacyId =
            toNullableString(
                $project['id']
                ?? null
            );


        $name =
            (string) (
                $project['name']
                ?? ''
            );


        /*
         * Preserve existing ID as initial slug.
         */
        $slug =
            $legacyId;


        if ($slug === null || $slug === '') {

            $slug = strtolower(
                trim(
                    (string) preg_replace(
                        '/[^a-zA-Z0-9]+/',
                        '-',
                        $name
                    ),
                    '-'
                )
            );


            if ($slug === '') {
                $slug =
                    'project-' . ((int) $order + 1);
            }
        }


        $projectId = insertRow(
            $pdo,
            'projects',
            [
                'legacy_id' =>
                    $legacyId,

                'name' =>
                    $name,

                'slug' =>
                    $slug,

                'sector_name' =>
                    toNullableString(
                        $project['sector']
                        ?? null
                    ),

                'category' =>
                    toNullableString(
                        $project['category']
                        ?? null
                    ),

                'status' =>
                    toNullableString(
                        $project['status']
                        ?? null
                    ),

                'completion_year' =>
                    isset(
                        $project['completion-year']
                    )
                    && is_numeric(
                        $project['completion-year']
                    )
                        ? (int) $project['completion-year']
                        : null,

                'location' =>
                    toNullableString(
                        $project['location']
                        ?? null
                    ),

                'client' =>
                    toNullableString(
                        $project['client']
                        ?? null
                    ),

                'description' =>
                    toText(
                        $project['description']
                        ?? null
                    ),

                'show_on_home' =>
                    yesNo(
                        $project['inhome']
                        ?? 'no'
                    ),

                'show_in_category_image' =>
                    yesNo(
                        $project['catimage']
                        ?? 'no'
                    ),

                'thumbnail_path' =>
                    toNullableString(
                        $project['thumbnail']
                        ?? null
                    ),

                'published' =>
                    1,

                'sort_order' =>
                    (int) $order,
            ]
        );


        $countProjects++;


        $images =
            isset($project['images'])
            && is_array($project['images'])
                ? $project['images']
                : [];


        foreach (
            $images as $imageOrder => $image
        ) {

            $image = trim(
                (string) $image
            );


            if ($image === '') {
                continue;
            }


            insertRow(
                $pdo,
                'project_images',
                [
                    'project_id' =>
                        $projectId,

                    'image_path' =>
                        $image,

                    'alt_text' =>
                        $name,

                    'caption' =>
                        null,

                    'sort_order' =>
                        (int) $imageOrder,
                ]
            );


            $countImages++;
        }


        $scope =
            isset($project['scope'])
            && is_array($project['scope'])
                ? $project['scope']
                : [];


        foreach (
            $scope as $scopeOrder => $scopeText
        ) {

            $scopeText =
                (string) $scopeText;


            if (
                trim($scopeText) === ''
            ) {
                continue;
            }


            insertRow(
                $pdo,
                'project_scope',
                [
                    'project_id' =>
                        $projectId,

                    'scope_text' =>
                        $scopeText,

                    'sort_order' =>
                        (int) $scopeOrder,
                ]
            );


            $countScope++;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SECTORS
    |--------------------------------------------------------------------------
    */

    $countSectors = 0;
    $countSectorStats = 0;
    $countSectorWhy = 0;
    $countSectorAreas = 0;
    $countSectorSections = 0;
    $countSectorImages = 0;
    $countSectorSectionStats = 0;


    foreach (
        $sectors as $sectorKey => $sector
    ) {

        if (!is_array($sector)) {
            continue;
        }


        $hero =
            isset($sector['hero'])
            && is_array($sector['hero'])
                ? $sector['hero']
                : [];


        $featured =
            isset($sector['project'])
            && is_array($sector['project'])
                ? $sector['project']
                : [];


        $sectorId = insertRow(
            $pdo,
            'sectors',
            [
                'sector_key' =>
                    (string) $sectorKey,

                'title' =>
                    (string) (
                        $sector['title']
                        ?? ''
                    ),

                'description' =>
                    toText(
                        $sector['description']
                        ?? null
                    ),

                'hero_tag' =>
                    toNullableString(
                        $hero['tag']
                        ?? null
                    ),

                'hero_headline' =>
                    toNullableString(
                        $hero['headline']
                        ?? null
                    ),

                'hero_subtitle' =>
                    toNullableString(
                        $hero['sub']
                        ?? null
                    ),

                'hero_cta_text' =>
                    toNullableString(
                        $hero['cta_text']
                        ?? null
                    ),

                'hero_cta_link' =>
                    toNullableString(
                        $hero['cta_link']
                        ?? null
                    ),

                'hero_image' =>
                    toNullableString(
                        $hero['image']
                        ?? null
                    ),

                'featured_project_name' =>
                    toNullableString(
                        $featured['name']
                        ?? null
                    ),

                'featured_project_image' =>
                    toNullableString(
                        $featured['image']
                        ?? null
                    ),

                'featured_project_cta_text' =>
                    toNullableString(
                        $featured['cta_text']
                        ?? null
                    ),

                'featured_project_cta_link' =>
                    toNullableString(
                        $featured['cta_link']
                        ?? null
                    ),

                'sort_order' =>
                    $countSectors,

                'is_active' =>
                    1,
            ]
        );


        $countSectors++;


        $statsItems =
            isset($sector['stats'])
            && is_array($sector['stats'])
                ? $sector['stats']
                : [];


        foreach (
            $statsItems as $order => $stat
        ) {

            if (!is_array($stat)) {
                continue;
            }


            insertRow(
                $pdo,
                'sector_stats',
                [
                    'sector_id' =>
                        $sectorId,

                    'value_text' =>
                        (string) (
                            $stat['value']
                            ?? ''
                        ),

                    'label' =>
                        (string) (
                            $stat['label']
                            ?? ''
                        ),

                    'sort_order' =>
                        (int) $order,
                ]
            );


            $countSectorStats++;
        }


        $whyItems =
            isset($sector['why'])
            && is_array($sector['why'])
                ? $sector['why']
                : [];


        foreach (
            $whyItems as $order => $why
        ) {

            insertRow(
                $pdo,
                'sector_why',
                [
                    'sector_id' =>
                        $sectorId,

                    'text_content' =>
                        (string) $why,

                    'sort_order' =>
                        (int) $order,
                ]
            );


            $countSectorWhy++;
        }


        $areas =
            isset($sector['areas'])
            && is_array($sector['areas'])
                ? $sector['areas']
                : [];


        foreach (
            $areas as $order => $area
        ) {

            insertRow(
                $pdo,
                'sector_areas',
                [
                    'sector_id' =>
                        $sectorId,

                    'title' =>
                        (string) $area,

                    'sort_order' =>
                        (int) $order,
                ]
            );


            $countSectorAreas++;
        }


        $sections =
            isset($sector['sections'])
            && is_array($sector['sections'])
                ? $sector['sections']
                : [];


        foreach (
            $sections as $sectionOrder => $section
        ) {

            if (!is_array($section)) {
                continue;
            }


            $sectionId = insertRow(
                $pdo,
                'sector_sections',
                [
                    'sector_id' =>
                        $sectorId,

                    'legacy_id' =>
                        toNullableString(
                            $section['id']
                            ?? null
                        ),

                    'title' =>
                        (string) (
                            $section['title']
                            ?? ''
                        ),

                    'category' =>
                        toNullableString(
                            $section['category']
                            ?? null
                        ),

                    'content' =>
                        toText(
                            $section['content']
                            ?? null
                        ),

                    'sort_order' =>
                        (int) $sectionOrder,

                    'is_active' =>
                        1,
                ]
            );


            $countSectorSections++;


            $images =
                isset($section['image'])
                    ? $section['image']
                    : [];


            if (!is_array($images)) {
                $images = [
                    $images
                ];
            }


            foreach (
                $images as $imageOrder => $image
            ) {

                $image =
                    trim((string) $image);


                if ($image === '') {
                    continue;
                }


                insertRow(
                    $pdo,
                    'sector_section_images',
                    [
                        'section_id' =>
                            $sectionId,

                        'image_path' =>
                            $image,

                        'sort_order' =>
                            (int) $imageOrder,
                    ]
                );


                $countSectorImages++;
            }


            $sectionStats =
                isset($section['stats'])
                && is_array($section['stats'])
                    ? $section['stats']
                    : [];


            foreach (
                $sectionStats as $statOrder => $stat
            ) {

                if (!is_array($stat)) {
                    continue;
                }


                insertRow(
                    $pdo,
                    'sector_section_stats',
                    [
                        'section_id' =>
                            $sectionId,

                        'value_text' =>
                            (string) (
                                $stat['value']
                                ?? ''
                            ),

                        'label' =>
                            (string) (
                                $stat['label']
                                ?? ''
                            ),

                        'sort_order' =>
                            (int) $statOrder,
                    ]
                );


                $countSectorSectionStats++;
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SERVICES
    |--------------------------------------------------------------------------
    */

    $countServiceGroups = 0;
    $countServiceCategories = 0;
    $countServiceItems = 0;
    $countServiceFeatures = 0;


    foreach (
        $services as $serviceKey => $group
    ) {

        if (!is_array($group)) {
            continue;
        }


        $groupId = insertRow(
            $pdo,
            'service_groups',
            [
                'service_key' =>
                    (string) $serviceKey,

                'title' =>
                    (string) (
                        $group['title']
                        ?? ''
                    ),

                'hero_image' =>
                    toNullableString(
                        $group['hero_image']
                        ?? $group['image']
                        ?? null
                    ),

                'hero_text' =>
                    toText(
                        $group['hero_text']
                        ?? $group['text']
                        ?? null
                    ),

                'sort_order' =>
                    $countServiceGroups,

                'is_active' =>
                    1,
            ]
        );


        $countServiceGroups++;


        $categories =
            isset($group['sub_services'])
            && is_array($group['sub_services'])
                ? $group['sub_services']
                : [];


        foreach (
            $categories as $categoryOrder => $category
        ) {

            if (!is_array($category)) {
                continue;
            }


            $categoryId = insertRow(
                $pdo,
                'service_categories',
                [
                    'group_id' =>
                        $groupId,

                    'category_key' =>
                        toNullableString(
                            $category['id']
                            ?? null
                        ),

                    'title' =>
                        (string) (
                            $category['title']
                            ?? ''
                        ),

                    'sort_order' =>
                        (int) $categoryOrder,

                    'is_active' =>
                        1,
                ]
            );


            $countServiceCategories++;


            $items =
                isset($category['items'])
                && is_array($category['items'])
                    ? $category['items']
                    : [];


            foreach (
                $items as $itemOrder => $item
            ) {

                if (!is_array($item)) {
                    continue;
                }


                $itemId = insertRow(
                    $pdo,
                    'service_items',
                    [
                        'category_id' =>
                            $categoryId,

                        'parent_id' =>
                            null,

                        'service_key' =>
                            toNullableString(
                                $item['id']
                                ?? null
                            ),

                        'title' =>
                            (string) (
                                $item['title']
                                ?? ''
                            ),

                        'image_path' =>
                            toNullableString(
                                $item['image']
                                ?? null
                            ),

                        'short_description' =>
                            toText(
                                $item['short_desc']
                                ?? null
                            ),

                        'why_description' =>
                            toText(
                                $item['why']
                                ?? null
                            ),

                        'sort_order' =>
                            (int) $itemOrder,

                        'is_active' =>
                            1,
                    ]
                );


                $countServiceItems++;


                $features =
                    isset($item['features'])
                    && is_array($item['features'])
                        ? $item['features']
                        : [];


                foreach (
                    $features as $featureOrder => $feature
                ) {

                    $feature = trim(
                        (string) $feature
                    );


                    if ($feature === '') {
                        continue;
                    }


                    insertRow(
                        $pdo,
                        'service_features',
                        [
                            'service_item_id' =>
                                $itemId,

                            'feature_text' =>
                                $feature,

                            'sort_order' =>
                                (int) $featureOrder,
                        ]
                    );


                    $countServiceFeatures++;
                }


                $subItems =
                    isset($item['subitems'])
                    && is_array($item['subitems'])
                        ? $item['subitems']
                        : [];


                foreach (
                    $subItems as $subOrder => $subItem
                ) {

                    if (!is_array($subItem)) {
                        continue;
                    }


                    $subImage =
                        $subItem['image']
                        ?? null;


                    if (is_array($subImage)) {

                        $subImage =
                            isset($subImage[0])
                                ? $subImage[0]
                                : null;
                    }


                    $childId = insertRow(
                        $pdo,
                        'service_items',
                        [
                            'category_id' =>
                                $categoryId,

                            'parent_id' =>
                                $itemId,

                            'service_key' =>
                                toNullableString(
                                    $subItem['id']
                                    ?? null
                                ),

                            'title' =>
                                (string) (
                                    $subItem['title']
                                    ?? ''
                                ),

                            'image_path' =>
                                toNullableString(
                                    $subImage
                                ),

                            'short_description' =>
                                toText(
                                    $subItem['short_desc']
                                    ?? $subItem['text']
                                    ?? null
                                ),

                            'why_description' =>
                                toText(
                                    $subItem['why']
                                    ?? null
                                ),

                            'sort_order' =>
                                (int) $subOrder,

                            'is_active' =>
                                1,
                        ]
                    );


                    $countServiceItems++;


                    $childFeatures =
                        isset($subItem['features'])
                        && is_array($subItem['features'])
                            ? $subItem['features']
                            : [];


                    foreach (
                        $childFeatures
                        as $featureOrder => $feature
                    ) {

                        $feature = trim(
                            (string) $feature
                        );


                        if ($feature === '') {
                            continue;
                        }


                        insertRow(
                            $pdo,
                            'service_features',
                            [
                                'service_item_id' =>
                                    $childId,

                                'feature_text' =>
                                    $feature,

                                'sort_order' =>
                                    (int) $featureOrder,
                            ]
                        );


                        $countServiceFeatures++;
                    }
                }
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | MEDIA
    |--------------------------------------------------------------------------
    */

    $countMedia = 0;
    $countMediaDescriptions = 0;
    $countMediaTags = 0;
    $countMediaLinks = 0;

    $tagMap = [];


    foreach (
        $media as $mediaType => $records
    ) {

        $mediaType =
            strtolower(
                trim((string) $mediaType)
            );


        if (
            !in_array(
                $mediaType,
                [
                    'news',
                    'events',
                    'gallery',
                ],
                true
            )
        ) {
            continue;
        }


        if (!is_array($records)) {
            continue;
        }


        foreach (
            $records as $order => $item
        ) {

            if (!is_array($item)) {
                continue;
            }


            $date =
                isset($item['date'])
                    ? (string) $item['date']
                    : null;


            $mediaId = insertRow(
                $pdo,
                'media_items',
                [
                    'legacy_id' =>
                        toNullableString(
                            $item['id']
                            ?? null
                        ),

                    'media_type' =>
                        $mediaType,

                    'media_date' =>
                        toNullableString($date),

                    'media_date_sort' =>
                        normalizeDate($date),

                    'title' =>
                        (string) (
                            $item['title']
                            ?? ''
                        ),

                    'image_path' =>
                        toNullableString(
                            $item['image']
                            ?? null
                        ),

                    'external_link' =>
                        toNullableString(
                            $item['link']
                            ?? null
                        ),

                    'sort_order' =>
                        (int) $order,

                    'is_active' =>
                        1,
                ]
            );


            $countMedia++;


            $descriptions =
                isset($item['description'])
                    ? $item['description']
                    : [];


            if (!is_array($descriptions)) {
                $descriptions = [
                    $descriptions
                ];
            }


            foreach (
                $descriptions
                as $descriptionOrder => $description
            ) {

                $description =
                    trim((string) $description);


                if ($description === '') {
                    continue;
                }


                insertRow(
                    $pdo,
                    'media_descriptions',
                    [
                        'media_item_id' =>
                            $mediaId,

                        'description_text' =>
                            $description,

                        'sort_order' =>
                            (int) $descriptionOrder,
                    ]
                );


                $countMediaDescriptions++;
            }


            $tags =
                isset($item['tags'])
                && is_array($item['tags'])
                    ? $item['tags']
                    : [];


            foreach ($tags as $tag) {

                $tag =
                    trim((string) $tag);


                if ($tag === '') {
                    continue;
                }


                if (
                    isset($tagMap[$tag])
                ) {

                    $tagId =
                        $tagMap[$tag];

                } else {

                    $stmt = $pdo->prepare(
                        "SELECT id
                         FROM media_tags
                         WHERE tag_name = :tag
                         LIMIT 1"
                    );


                    $stmt->execute([
                        ':tag' => $tag,
                    ]);


                    $existing =
                        $stmt->fetchColumn();


                    if ($existing !== false) {

                        $tagId =
                            (int) $existing;

                    } else {

                        $tagId = insertRow(
                            $pdo,
                            'media_tags',
                            [
                                'tag_name' =>
                                    $tag,
                            ]
                        );


                        $countMediaTags++;
                    }


                    $tagMap[$tag] =
                        $tagId;
                }


                insertRow(
                    $pdo,
                    'media_item_tags',
                    [
                        'media_item_id' =>
                            $mediaId,

                        'tag_id' =>
                            $tagId,
                    ]
                );


                $countMediaLinks++;
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | POLICIES + TERMS
    |--------------------------------------------------------------------------
    */

    $countDocuments = 0;
    $countSections = 0;
    $countLegalItems = 0;


    $legalSets = [
        'policies' =>
            $policies,

        'terms' =>
            $TermsOfService,
    ];


    foreach (
        $legalSets as $sourceName => $documents
    ) {

        if (!is_array($documents)) {
            continue;
        }


        foreach (
            $documents as $documentKey => $document
        ) {

            /*
             * Support the case where TermsOfService itself is a single
             * document rather than an array of documents.
             */
            if (
                isset($document['sections'])
            ) {

                /*
                 * Normal document.
                 */

            } else {

                continue;
            }


            $dbDocumentKey =
                $sourceName
                . '_'
                . (string) $documentKey;


            $documentId = insertRow(
                $pdo,
                'legal_documents',
                [
                    'document_key' =>
                        $dbDocumentKey,

                    'title' =>
                        (string) (
                            $document['title']
                            ?? ''
                        ),

                    'sort_order' =>
                        $countDocuments,

                    'is_active' =>
                        1,
                ]
            );


            $countDocuments++;


            $sections =
                isset($document['sections'])
                && is_array($document['sections'])
                    ? $document['sections']
                    : [];


            foreach (
                $sections as $sectionOrder => $section
            ) {

                if (!is_array($section)) {
                    continue;
                }


                $isList =
                    isset($section['list'])
                    && is_array($section['list']);


                $sectionId = insertRow(
                    $pdo,
                    'legal_sections',
                    [
                        'document_id' =>
                            $documentId,

                        'title' =>
                            (string) (
                                $section['title']
                                ?? ''
                            ),

                        'content' =>
                            toText(
                                $section['content']
                                ?? null
                            ),

                        'section_type' =>
                            $isList
                                ? 'list'
                                : 'content',

                        'sort_order' =>
                            (int) $sectionOrder,
                    ]
                );


                $countSections++;


                if ($isList) {

                    foreach (
                        $section['list']
                        as $itemOrder => $item
                    ) {

                        insertRow(
                            $pdo,
                            'legal_section_items',
                            [
                                'section_id' =>
                                    $sectionId,

                                'item_text' =>
                                    (string) $item,

                                'sort_order' =>
                                    (int) $itemOrder,
                            ]
                        );


                        $countLegalItems++;
                    }
                }
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | COMMIT
    |--------------------------------------------------------------------------
    */

    $pdo->commit();


    /*
    |--------------------------------------------------------------------------
    | SUCCESS
    |--------------------------------------------------------------------------
    */

    echo PHP_EOL;
    echo "============================================================" . PHP_EOL;
    echo " MIGRATION SUCCESSFUL" . PHP_EOL;
    echo "============================================================" . PHP_EOL;
    echo PHP_EOL;

    echo "Homepage" . PHP_EOL;
    echo "  Hero slides       : {$heroCount}" . PHP_EOL;
    echo "  Statistics        : {$statsCount}" . PHP_EOL;
    echo "  History           : {$historyCount}" . PHP_EOL;
    echo "  Why tabs          : {$whyTabCount}" . PHP_EOL;
    echo "  Why items         : {$whyItemCount}" . PHP_EOL;
    echo PHP_EOL;

    echo "About" . PHP_EOL;
    echo "  History           : {$count}" . PHP_EOL;
    echo "  Core values       : {$countCore}" . PHP_EOL;
    echo "  Clients           : {$countClients}" . PHP_EOL;
    echo "  Certificates      : {$countCertificates}" . PHP_EOL;
    echo "  Awards            : {$countAwards}" . PHP_EOL;
    echo "  Affiliated        : {$countCompanies}" . PHP_EOL;
    echo PHP_EOL;

    echo "Projects            : {$countProjects}" . PHP_EOL;
    echo "Project images      : {$countImages}" . PHP_EOL;
    echo "Project scope       : {$countScope}" . PHP_EOL;
    echo PHP_EOL;

    echo "Sectors             : {$countSectors}" . PHP_EOL;
    echo "Sector stats        : {$countSectorStats}" . PHP_EOL;
    echo "Sector why          : {$countSectorWhy}" . PHP_EOL;
    echo "Sector areas        : {$countSectorAreas}" . PHP_EOL;
    echo "Sector sections     : {$countSectorSections}" . PHP_EOL;
    echo "Section images      : {$countSectorImages}" . PHP_EOL;
    echo "Section stats       : {$countSectorSectionStats}" . PHP_EOL;
    echo PHP_EOL;

    echo "Service groups      : {$countServiceGroups}" . PHP_EOL;
    echo "Service categories  : {$countServiceCategories}" . PHP_EOL;
    echo "Service items       : {$countServiceItems}" . PHP_EOL;
    echo "Service features    : {$countServiceFeatures}" . PHP_EOL;
    echo PHP_EOL;

    echo "Media items         : {$countMedia}" . PHP_EOL;
    echo "Media descriptions  : {$countMediaDescriptions}" . PHP_EOL;
    echo "Media tags          : {$countMediaTags}" . PHP_EOL;
    echo "Media tag links     : {$countMediaLinks}" . PHP_EOL;
    echo PHP_EOL;

    echo "Legal documents     : {$countDocuments}" . PHP_EOL;
    echo "Legal sections      : {$countSections}" . PHP_EOL;
    echo "Legal list items    : {$countLegalItems}" . PHP_EOL;
    echo PHP_EOL;

    echo "Original source files were not modified." . PHP_EOL;
    echo "Frontend files were not modified." . PHP_EOL;
    echo PHP_EOL;


} catch (Throwable $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }


    echo PHP_EOL;
    echo "============================================================" . PHP_EOL;
    echo " MIGRATION FAILED - ROLLED BACK" . PHP_EOL;
    echo "============================================================" . PHP_EOL;
    echo PHP_EOL;

    echo $e->getMessage() . PHP_EOL;
    echo PHP_EOL;

    exit(1);
}