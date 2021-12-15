# Ascii Renderer
A tiny rendering engine for ascii art.

## What is this
Ascii Renderer is made to facilitate ascii art projects by loading partial artworks and combining them into a 
(potentially animated) result.

## What can it do
The module can load a custom file format into animations with masked frames.

By including references to potential other animations, a sort-of skeletal system can be used.

## How to use it?

To load files:
```php
use Stratadox\AsciiRenderer\FileLoader;
use Stratadox\AsciiRenderer\ImageFactory;
use Stratadox\AsciiRenderer\MaskFactory;

$loader = new FileLoader(new MaskFactory(), new ImageFactory());
$animation = $loader->load('file/name.ext');
```

To combine animations:
```php
use Stratadox\AsciiRenderer\AnimationCombiner;
use Stratadox\AsciiRenderer\Combiner;
use Stratadox\AsciiRenderer\FileLoader;
use Stratadox\AsciiRenderer\ImageFactory;
use Stratadox\AsciiRenderer\MaskFactory;

$loader = new FileLoader(new MaskFactory(), new ImageFactory());
$combiner = new AnimationCombiner(new Combiner());

$animation = $combiner->combine(
    [
        'item2' => $this->loader->load('/Asset/item/kite-shield-back.txt'),
        'body' => $this->loader->load('/Asset/body/leather-jacket-walk.txt'),
        'head' => $this->loader->load('/Asset/head/default.txt'),
        'headgear' => $this->loader->load('/Asset/headgear/cap.txt'),
        'item1' => $this->loader->load('/Asset/item/axe.txt'),
    ],
    'body'
);

assert(8 === $animation->length())
assert((string) $animation->frame(0)) === <<<'EOT'
  ____       
 /   _}      
 \__/*}  ./\ 
 /~^~\--<)+))
 |(  V   |\/ 
 \\_____(| ) 
 /~~~\   |/  
 (   \   o   
  \\  ) /    
  ) \ |/     
 / /| |      
[__b[__b     
EOT
);
```

## What do the files look like?

For example, the cap of the character above:
```
mask:
width: 6
height: 3
origin-x: 2
origin-y: 2

mask-frames:
1
 ....
######
####

frames:
1
 ____
/   _}
\__/
```

Their axe:
````
mask:
origin-x: 1
origin-y: 3
width: 5
height: 6

mask-frames:
1
 .##
#####
 ###
 #
 #
 #

frames:
1
 ./\
<)+))
 |\/
 |
 |
 o
````

For more examples, see [the test assets](/tests/Asset).
