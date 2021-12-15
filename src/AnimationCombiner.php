<?php declare(strict_types=1);

namespace Stratadox\AsciiRenderer;

final class AnimationCombiner
{
    public function __construct(
        private Combiner $combiner
    ) {}

    /**
     * @param array<string, Animation> $animations
     * @param string $root
     * @param Reference[] $references
     * @return Animation
     */
    public function combine(array $animations, string $root, array $references = []): Animation
    {
        $length = 1;
        foreach ($animations as $animation) {
            $length *= $animation->length();
        }
        $frames = [];
        for ($i = 0; $i < $length; $i++) {
            $frames[] = $this->combiner->combine(array_map(function (Animation $a) use ($i): Image {
                return $a->frame($i);
            }, $animations), $root, $references);
        }
        return new Animation(...$frames);
    }
}
