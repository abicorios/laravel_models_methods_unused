<?php
if (count($argv) < 2) {
  echo "Write model name as argument";
  exit(1);
}

$modelName = $argv[1];
echo "Model name: $modelName\n\n";

$used = `grep -rEoh --exclude-dir=vendor '\b$modelName::\w+\s*\(' | sed 's/$modelName::\(\w\+\)\s*(.*/\\1/g' | sort | uniq`;
echo "used:\n";
echo $used;
$defined = `grep 'function' app\Models\\$modelName.php | sed -r 's/.*function\s+(\w+)\s*\(.*/\\1/' | sort | uniq`;
echo "\n\ndefined:\n";
echo $defined;

$used_array = explode("\n", $used);
$defined_array = explode("\n", $defined);
$unused_array = array_diff($defined_array, $used_array);
echo "\n\nunused:\n";
echo implode("\n", $unused_array);
