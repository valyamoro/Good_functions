<?php
$data = [$newKey => $data[$oldKey]] + array_diff_key($data, [$oldKey => $data[$oldKey]]);
