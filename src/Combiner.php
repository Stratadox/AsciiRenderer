<?php declare(strict_types=1);

namespace Stratadox\AsciiRenderer;

final class Combiner
{
    public function __construct(
        private array $insignificant = [
            ' ',
            '_',
            '.',
        ]
    ) {}

    /**
     * @param array<string, Image> $images
     * @param string $root
     * @param Reference[] $references
     * @return Image
     */
    public function combine(array $images, string $root, array $references = []): Image
    {
        assert(isset($images[$root]));
        $shifted = $this->shiftImages($images[$root], $images);
        $dimensions = new Dimensions(
            new Coordinate(
                min(array_map(function (Image $i): int { return $i->x1(); }, $shifted)),
                min(array_map(function (Image $i): int { return $i->y1(); }, $shifted)),
            ),
            new Coordinate(
                max(array_map(function (Image $i): int { return $i->x2(); }, $shifted)),
                max(array_map(function (Image $i): int { return $i->y2(); }, $shifted)),
            )
        );
        $lines = [];
        $solidity = [];
        for ($y = $dimensions->y1(); $y < $dimensions->y2(); $y++) {
            for ($x = $dimensions->x1(); $x < $dimensions->x2(); $x++) {
                $character = Character::none();
                foreach ($images as $tag => $image) {
                    $character = $shifted[$tag]->characterAt($x, $y)->drawOnto($character, ...$this->insignificant);
                }
                $solidity[$y][$x] = max($solidity[$y][$x] ?? 0, $character->solidity());
                $lines[$y][$x] = $character;
            }
        }
        return new Image(new Mask($dimensions, $solidity, $references), $lines);
    }

    private function shiftImages(Image $root, array $images, int $x = 0, int $y = 0): array
    {
        /** @var Image[] $images */
        foreach ($root->references() as $target => $coordinate) {
            if (!isset($images[$target])) {
                continue;
            }
            $images[$target] = $images[$target]->shifted($x + $coordinate->x(), $y + $coordinate->y());
            $images = $this->shiftImages($images[$target], $images, $x + $coordinate->x(), $y + $coordinate->y());
        }
        return $images;
    }
}
