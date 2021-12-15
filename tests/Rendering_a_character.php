<?php declare(strict_types=1);

namespace Stratadox\AsciiRenderer\Test;

use PHPUnit\Framework\TestCase;
use Stratadox\AsciiRenderer\AnimationCombiner;
use Stratadox\AsciiRenderer\Combiner;
use Stratadox\AsciiRenderer\FileLoader;
use Stratadox\AsciiRenderer\ImageFactory;
use Stratadox\AsciiRenderer\MaskFactory;

class Rendering_a_character extends TestCase
{
    private FileLoader $loader;
    private AnimationCombiner $combiner;

    protected function setUp(): void
    {
        $this->loader = new FileLoader(new MaskFactory(), new ImageFactory());
        $this->combiner = new AnimationCombiner(new Combiner());
    }

    /** @test */
    function rendering_the_first_frame_of_a_basic_character()
    {
        $art = $this->combiner->combine(
            [
                'body' => $this->loader->load(__DIR__ . '/Asset/body/default-walk.txt'),
                'head' => $this->loader->load(__DIR__ . '/Asset/head/default.txt'),
            ],
            'body',
        );

        self::assertEquals(
            <<<'EOT'
   ...    
  (' *}   
 /   \    
 |(  V___ 
 \\_____(E
 /   \    
 (   \    
  \\  )   
  ) \ |   
 / /| |   
[__b[__b  
EOT,
            (string) $art->frame(0)
        );
        self::assertEquals(-3, $art->frame(0)->x1());
        self::assertEquals(-10, $art->frame(0)->y1());
        self::assertEquals(8, $art->length());
    }

    /** @test */
    function rendering_the_second_frame_of_a_basic_character()
    {
        $art = $this->combiner->combine(
            [
                'body' => $this->loader->load(__DIR__ . '/Asset/body/default-walk.txt'),
                'head' => $this->loader->load(__DIR__ . '/Asset/head/default.txt'),
            ],
            'body',
        );

        self::assertEquals(
            <<<'EOT'
   ...    
  (' *}   
 /   \    
 |(  V___ 
 \\_____(E
 /   \    
 (   )    
  \  |    
 _/| /    
/ _| |    
\_b[__b   
EOT,
            (string) $art->frame(1)
        );
    }

    /** @test */
    function rendering_the_first_frame_of_a_more_complex_character()
    {
        $art = $this->combiner->combine(
            [
                'item2' => $this->loader->load(__DIR__ . '/Asset/item/kite-shield-back.txt'),
                'body' => $this->loader->load(__DIR__ . '/Asset/body/leather-jacket-walk.txt'),
                'head' => $this->loader->load(__DIR__ . '/Asset/head/default.txt'),
                'headgear' => $this->loader->load(__DIR__ . '/Asset/headgear/cap.txt'),
                'item1' => $this->loader->load(__DIR__ . '/Asset/item/axe.txt'),
            ],
            'body',
        );

        self::assertEquals(
            <<<'EOT'
  ____       
 /   _}      
 \__/*}  ./\ 
 /~^~\--<)+))
 |(  V___|\/ 
 \\_____(| ) 
 /~~~\   |/  
 (   \   o   
  \\  ) /    
  ) \ |/     
 / /| |      
[__b[__b     
EOT,
            (string) $art->frame(0)
        );
        self::assertEquals(-3, $art->frame(0)->x1());
        self::assertEquals(-11, $art->frame(0)->y1());
        self::assertEquals(8, $art->length());
    }

    /** @test */
    function rendering_the_fifth_frame_of_a_more_complex_character()
    {
        $art = $this->combiner->combine(
            [
                'item2' => $this->loader->load(__DIR__ . '/Asset/item/kite-shield-back.txt'),
                'body' => $this->loader->load(__DIR__ . '/Asset/body/leather-jacket-walk.txt'),
                'head' => $this->loader->load(__DIR__ . '/Asset/head/default.txt'),
                'headgear' => $this->loader->load(__DIR__ . '/Asset/headgear/cap.txt'),
                'item1' => $this->loader->load(__DIR__ . '/Asset/item/axe.txt'),
            ],
            'body',
        );

        self::assertEquals(
            <<<'EOT'
  ____        
 /   _}       
 \__/*}./\    
 /~^~\<)+))   
 |  )/_|\/  \ 
 \____(|(E   )
 /~~~\ |    / 
 (   \\o   /  
  \  ))\  /   
  ) / | \/    
 / /| |       
[__b[__b      
EOT,
            (string) $art->frame(4)
        );
    }

    /** @test */
    function rendering_the_first_frame_of_a_yet_more_complex_character()
    {
        $art = $this->combiner->combine(
            [
                'item2' => $this->loader->load(__DIR__ . '/Asset/item/torch.txt'),
                'body' => $this->loader->load(__DIR__ . '/Asset/body/carburised-armour-walk.txt'),
                'head' => $this->loader->load(__DIR__ . '/Asset/head/default.txt'),
                'headgear' => $this->loader->load(__DIR__ . '/Asset/headgear/full-helm.txt'),
                'item1' => $this->loader->load(__DIR__ . '/Asset/item/kite-shield.txt'),
            ],
            'body',
        );

        self::assertEquals(
            <<<'EOT'
         ~    
       ~      
       /")    
  )--.( /     
 (---=]V_     
 |____\_/     
 /:::\ |      
 |(: V_|--.   
 \\__/###   \ 
 /==(###()   )
 (:::\   ###/ 
  \\::\  ##/  
  ):\:|\ #/   
 /:/|:| \/    
[##b[##b      
EOT,
            (string) $art->frame(0)
        );
        self::assertEquals(-3, $art->frame(0)->x1());
        self::assertEquals(-14, $art->frame(0)->y1());
        self::assertEquals(24, $art->length());
    }

    /** @test */
    function rendering_the_ninth_frame_of_a_yet_more_complex_character()
    {
        $art = $this->combiner->combine(
            [
                'item2' => $this->loader->load(__DIR__ . '/Asset/item/torch.txt'),
                'body' => $this->loader->load(__DIR__ . '/Asset/body/carburised-armour-walk.txt'),
                'head' => $this->loader->load(__DIR__ . '/Asset/head/default.txt'),
                'headgear' => $this->loader->load(__DIR__ . '/Asset/headgear/full-helm.txt'),
                'item1' => $this->loader->load(__DIR__ . '/Asset/item/kite-shield.txt'),
            ],
            'body',
        );

        self::assertEquals(
            <<<'EOT'
            ~ 
       ~ .    
      \"(     
  )--. ))     
 (---=]V_     
 |____\_/     
 /:::\ |      
 |(: V_|--.   
 \\__/###   \ 
 /==(###()   )
 (:::\   ###/ 
  \\::\  ##/  
  ):\:|\ #/   
 /:/|:| \/    
[##b[##b      
EOT,
            (string) $art->frame(8)
        );
        self::assertEquals(-3, $art->frame(0)->x1());
        self::assertEquals(-14, $art->frame(0)->y1());
        self::assertEquals(24, $art->length());
    }
}
