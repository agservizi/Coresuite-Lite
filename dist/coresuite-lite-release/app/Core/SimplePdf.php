<?php
namespace Core;

class SimplePdf {
    private array $pages = [];
    private array $currentPage = [];
    private float $width;
    private float $height;
    private float $fontSize = 12.0;
    private string $fontName = 'F1';

    public function __construct(float $width = 595.28, float $height = 841.89) {
        $this->width = $width;
        $this->height = $height;
    }

    public function addPage(): void {
        if (!empty($this->currentPage)) {
            $this->pages[] = implode("\n", $this->currentPage);
        }
        $this->currentPage = [];
    }

    public function pageWidth(): float {
        return $this->width;
    }

    public function pageHeight(): float {
        return $this->height;
    }

    public function setFont(float $size): void {
        $this->fontSize = $size;
    }

    public function line(float $x1, float $y1, float $x2, float $y2, float $lineWidth = 1.0): void {
        $this->currentPage[] = sprintf('%.2F w %.2F %.2F m %.2F %.2F l S', $lineWidth, $x1, $this->fromTop($y1), $x2, $this->fromTop($y2));
    }

    public function rect(float $x, float $y, float $w, float $h, string $style = 'S'): void {
        $this->currentPage[] = sprintf('%.2F %.2F %.2F %.2F re %s', $x, $this->fromTop($y + $h), $w, $h, $style);
    }

    public function fillColor(int $r, int $g, int $b): void {
        $this->currentPage[] = sprintf('%.3F %.3F %.3F rg', $r / 255, $g / 255, $b / 255);
    }

    public function strokeColor(int $r, int $g, int $b): void {
        $this->currentPage[] = sprintf('%.3F %.3F %.3F RG', $r / 255, $g / 255, $b / 255);
    }

    public function text(float $x, float $y, string $text, ?float $size = null): void {
        $size = $size ?? $this->fontSize;
        $this->currentPage[] = sprintf(
            'BT /%s %.2F Tf 1 0 0 1 %.2F %.2F Tm (%s) Tj ET',
            $this->fontName,
            $size,
            $x,
            $this->fromTop($y),
            $this->escape($text)
        );
    }

    public function wrappedText(float $x, float $y, float $maxWidth, string $text, ?float $size = null, float $lineHeight = 16.0): float {
        $size = $size ?? $this->fontSize;
        $lines = $this->wrapText($text, $maxWidth, $size);
        $cursor = $y;
        foreach ($lines as $line) {
            $this->text($x, $cursor, $line, $size);
            $cursor += $lineHeight;
        }
        return $cursor;
    }

    public function wrapLines(string $text, float $maxWidth, ?float $size = null): array {
        return $this->wrapText($text, $maxWidth, $size ?? $this->fontSize);
    }

    public function estimateWrappedHeight(string $text, float $maxWidth, ?float $size = null, float $lineHeight = 16.0): float {
        $lines = $this->wrapText($text, $maxWidth, $size ?? $this->fontSize);
        return max($lineHeight, count($lines) * $lineHeight);
    }

    public function textWidth(string $text, ?float $size = null): float {
        return $this->estimateWidth($text, $size ?? $this->fontSize);
    }

    public function output(string $filename = 'document.pdf', bool $download = false): void {
        if (!empty($this->currentPage)) {
            $this->pages[] = implode("\n", $this->currentPage);
            $this->currentPage = [];
        }

        if (empty($this->pages)) {
            $this->pages[] = '';
        }

        $objects = [];
        $objects[] = '<< /Type /Catalog /Pages 2 0 R >>';

        $pageObjectIds = [];
        $contentObjectIds = [];
        $fontObjectId = 3 + (count($this->pages) * 2);

        for ($i = 0; $i < count($this->pages); $i++) {
            $pageObjectIds[] = 3 + ($i * 2);
            $contentObjectIds[] = 4 + ($i * 2);
        }

        $kids = [];
        foreach ($pageObjectIds as $pageId) {
            $kids[] = $pageId . ' 0 R';
        }
        $objects[] = sprintf('<< /Type /Pages /Kids [%s] /Count %d >>', implode(' ', $kids), count($kids));

        foreach ($this->pages as $index => $content) {
            $pageId = $pageObjectIds[$index];
            $contentId = $contentObjectIds[$index];
            $objects[$pageId - 1] = sprintf(
                '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 %.2F %.2F] /Resources << /Font << /%s %d 0 R >> >> /Contents %d 0 R >>',
                $this->width,
                $this->height,
                $this->fontName,
                $fontObjectId,
                $contentId
            );
            $stream = "q\n" . $content . "\nQ";
            $objects[$contentId - 1] = sprintf("<< /Length %d >>\nstream\n%s\nendstream", strlen($stream), $stream);
        }

        $objects[$fontObjectId - 1] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>';

        $pdf = "%PDF-1.4\n";
        $offsets = [0];
        foreach ($objects as $index => $object) {
            $offsets[] = strlen($pdf);
            $pdf .= ($index + 1) . " 0 obj\n" . $object . "\nendobj\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";
        for ($i = 1; $i < count($offsets); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }
        $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n" . $xrefOffset . "\n%%EOF";

        header('Content-Type: application/pdf');
        header('Content-Disposition: ' . ($download ? 'attachment' : 'inline') . '; filename="' . basename($filename) . '"');
        header('Content-Length: ' . strlen($pdf));
        echo $pdf;
    }

    private function wrapText(string $text, float $maxWidth, float $fontSize): array {
        $text = str_replace(["\r\n", "\r"], "\n", trim($text));
        if ($text === '') {
            return ['-'];
        }

        $lines = [];
        foreach (explode("\n", $text) as $paragraph) {
            $paragraph = trim(preg_replace('/\s+/', ' ', $paragraph));
            if ($paragraph === '') {
                $lines[] = '';
                continue;
            }

            $line = '';
            foreach (explode(' ', $paragraph) as $word) {
                if ($word === '') {
                    continue;
                }

                if ($this->estimateWidth($word, $fontSize) > $maxWidth) {
                    if ($line !== '') {
                        $lines[] = $line;
                        $line = '';
                    }
                    foreach ($this->splitLongWord($word, $maxWidth, $fontSize) as $chunk) {
                        $lines[] = $chunk;
                    }
                    continue;
                }

                $candidate = $line === '' ? $word : $line . ' ' . $word;
                if ($this->estimateWidth($candidate, $fontSize) <= $maxWidth) {
                    $line = $candidate;
                    continue;
                }

                if ($line !== '') {
                    $lines[] = $line;
                }
                $line = $word;
            }

            if ($line !== '') {
                $lines[] = $line;
            }
        }

        return $lines === [] ? ['-'] : $lines;
    }

    private function splitLongWord(string $word, float $maxWidth, float $fontSize): array {
        $chunks = [];
        $chunk = '';
        $length = strlen($word);
        for ($i = 0; $i < $length; $i++) {
            $character = $word[$i];
            $candidate = $chunk . $character;
            if ($chunk !== '' && $this->estimateWidth($candidate, $fontSize) > $maxWidth) {
                $chunks[] = $chunk;
                $chunk = $character;
                continue;
            }
            $chunk = $candidate;
        }

        if ($chunk !== '') {
            $chunks[] = $chunk;
        }

        return $chunks === [] ? [$word] : $chunks;
    }

    private function estimateWidth(string $text, float $fontSize): float {
        return strlen($this->escape($text)) * ($fontSize * 0.48);
    }

    private function fromTop(float $y): float {
        return $this->height - $y;
    }

    private function escape(string $text): string {
        $converted = @iconv('UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $text);
        if ($converted === false) {
            $converted = $text;
        }
        return str_replace(
            ['\\', '(', ')', "\r", "\n"],
            ['\\\\', '\(', '\)', '', ' '],
            $converted
        );
    }
}
