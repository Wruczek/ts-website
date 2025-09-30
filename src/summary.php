<?php

use Wruczek\TSWebsite\Utils\TemplateUtils;
use Wruczek\TSWebsite\CacheManager;
use Wruczek\TSWebsite\Utils\Utils;

require_once __DIR__ . "/private/php/load.php";

$cldbid = (int) (@$_GET["cldbid"] ?? 0);
if (!$cldbid) {
    TemplateUtils::i()->renderErrorTemplate("400", "Bad request", "Missing cldbid");
    exit;
}

$client = null;
$dbinfo = null;

try { $client = CacheManager::i()->getClient($cldbid); } catch (\Throwable $e) {}
try { $dbinfo = CacheManager::i()->getClientDbInfo($cldbid); } catch (\Throwable $e) {}

if (!$client && !$dbinfo) {
    TemplateUtils::i()->renderErrorTemplate("404", "Not found", "User not found in cache");
    exit;
}

$nickname = $client ? (string) $client["client_nickname"] : (string) ($dbinfo["client_nickname"] ?? "User #$cldbid");
$uid = $client ? (string) $client["client_unique_identifier"] : (string) ($dbinfo["client_unique_identifier"] ?? "");
$version = $client ? (string) $client["client_version"] : (string) ($dbinfo["client_version"] ?? "");
$total = (int) ($dbinfo["client_totalconnections"] ?? 0);
$created = (int) ($dbinfo["client_created"] ?? 0);
$last = (int) ($dbinfo["client_lastconnected"] ?? 0);
$country = ($client && !empty($client["client_country"])) ? strtolower((string) $client["client_country"]) : null;

echo '<div class="card card-accent"><div class="card-body">';
echo '<h4 class="mb-3">User summary</h4>';
echo '<div><b>Nickname:</b> ' . Utils::escape($nickname) . '</div>';
echo '<div><b>Unique ID:</b> ' . Utils::escape($uid) . '</div>';
echo '<div><b>Database ID:</b> ' . $cldbid . '</div>';
echo '<div><b>Version:</b> ' . Utils::escape($version) . '</div>';
echo '<div><b>Connections:</b> ' . $total . '</div>';
echo '<div><b>First Connected:</b> ' . date('d/m/Y H:i:s', $created) . '</div>';
echo '<div><b>Last Connected:</b> ' . date('d/m/Y H:i:s', $last) . '</div>';
if ($country) {
    $flag = 'https://reape.rs/flags/' . $country . '.png';
    echo '<div class="mt-2"><img src="' . Utils::escape($flag) . '" alt="' . Utils::escape($country) . '" style="height:16px;width:24px;"> ' . strtoupper($country) . '</div>';
}
echo '</div></div>';

