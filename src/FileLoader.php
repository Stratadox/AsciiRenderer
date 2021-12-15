<?php declare(strict_types=1);

namespace Stratadox\AsciiRenderer;

final class FileLoader
{
    private const REFS = 0;
    private const MASK_FRAMES = 1;
    private const FRAMES = 2;

    public function __construct(
        private MaskFactory $maskFactory,
        private ImageFactory $imageFactory,
    ){}

    public function load(string $filename): Animation
    {
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $masks = [];
        $mode = null;
        $frame = null;
        $frames = [];
        foreach ($lines as $line) {
            if ($line === 'mask:') {
                $masks = $this->loadMasks(...$lines);
                continue;
            }
            if (str_starts_with($line, 'mask: ')) {
                $masks = $this->loadMasks(...file(
                    dirname($filename) . DIRECTORY_SEPARATOR . substr($line, 6),
                    FILE_IGNORE_NEW_LINES
                ));
                continue;
            }
            if ($line === 'frames:') {
                $mode = self::FRAMES;
                continue;
            }
            if ($mode === self::FRAMES) {
                if ($line !== '' && $line === filter_var($line, FILTER_SANITIZE_NUMBER_INT)) {
                    $frame = ((int) $line) - 1;
                    continue;
                }
                assert($frame !== null);
                $frames[$frame][] = $line;
            }
        }
        assert(!empty($masks));
        assert(!empty($frames));
        return new Animation(...array_map(function (array $lines, int $frame) use ($masks): Image {
            return $this->imageFactory->from($lines, $masks[$frame]);
        }, $frames, array_keys($frames)));
    }

    /** @return Mask[] */
    private function loadMasks(string ...$lines): array
    {
        $vars = [
            'origin-x',
            'origin-y',
            'width',
            'height',
        ];
        $coords = [];
        /** @var string[][] $masks */
        $masks = [];
        $refs = [];
        $mode = null;
        $frame = null;
        foreach ($lines as $line) {
            if ($line === 'refs:') {
                $mode = self::REFS;
                continue;
            }
            if ($mode === self::REFS && str_contains($line, ': ')) {
                [$symbol, $target] = explode(': ', $line);
                $refs[] = new Reference(explode(', ', $target)[0], ...explode('|', $symbol));
            }

            if ($line === 'mask-frames:') {
                $mode = self::MASK_FRAMES;
                continue;
            }
            if ($mode === self::MASK_FRAMES) {
                if ($line === filter_var($line, FILTER_SANITIZE_NUMBER_INT)) {
                    $frame = ((int) $line) - 1;
                    continue;
                }
                assert($frame !== null);
                $masks[$frame][] = $line;
                continue;
            }

            foreach ($vars as $var) {
                if (str_starts_with($line, $var)) {
                    $coords[$var] = (int) substr($line, strlen($var) + 2);
                }
            }

            if ($line === 'frames:') {
                break;
            }
        }
        $dimensions = new Dimensions(
            new Coordinate(-$coords['origin-x'], -$coords['origin-y']),
            new Coordinate($coords['width'] - $coords['origin-x'], $coords['height'] - $coords['origin-y']),
        );

        return array_map(function (array $maskLines) use ($dimensions, $refs): Mask {
            return $this->maskFactory->create($dimensions, $maskLines, ...$refs);
        }, $masks);
    }
}
