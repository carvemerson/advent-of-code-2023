<?php
$cache = [];

function count_cfg_num($cfg, $nums) {
    global $cache;

    if ($cfg === "") {
        return empty($nums) ? 1 : 0;
    }

    if (empty($nums)) {
        return strpos($cfg, "#") !== false ? 0 : 1;
    }

    $key = [$cfg, implode(",", $nums)];

    if (array_key_exists(implode(",", $key), $cache)) {
        return $cache[implode(",", $key)];
    }

    $result = 0;

    if (strpos(".?", $cfg[0]) !== false) {
        $result += count_cfg_num(substr($cfg, 1), $nums);
    }

    if (strpos("#?", $cfg[0]) !== false) {
        if ($nums[0] <= strlen($cfg) && strpos(substr($cfg, 0, $nums[0]), ".") === false &&
            ($nums[0] === strlen($cfg) || $cfg[$nums[0]] !== "#")) {
            $result += count_cfg_num(substr($cfg, $nums[0] + 1), array_slice($nums, 1));
        }
    }

    $cache[implode(",", $key)] = $result;
    return $result;
}

$total = 0;


while ($line = fgets(STDIN)) {
    list($cfg, $nums) = explode(" ", $line);
    $nums = array_map('intval', explode(",", $nums));

    $cfg = $cfg . "?".$cfg . "?".$cfg . "?".$cfg . "?".$cfg;
    $nums = array_merge($nums, $nums, $nums, $nums, $nums);  // Multiply array by 5

    $total += count_cfg_num($cfg, $nums);
}

echo $total;

