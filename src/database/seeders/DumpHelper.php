<?php

namespace Database\Seeders;

class DumpHelper {
    public function loadDumpFile(string $filePath): array
    {
        $dumpLines = [];

        $fp = null;
        try {
            $fp = fopen($filePath, "r");
            while ($line = fgets($fp)) {
                $dumpLines[] = $this->parser($line);
            }
        } finally {
            fclose($fp);
        }

        return $dumpLines;
    }

    private function parser(string $text): array {
        $data = [];
        foreach (explode(",", $text) as $d) {
            $replacedText = preg_replace("/\"/", "", $d);
            $data[] = $replacedText;
        }
        return $data;
    }
}