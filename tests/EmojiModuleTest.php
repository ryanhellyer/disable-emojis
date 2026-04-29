<?php

declare(strict_types=1);

namespace RyanHellyer\DisableEmojis\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use RyanHellyer\DisableEmojis\EmojiModule;

class EmojiModuleTest extends TestCase
{
    private EmojiModule $module;

    protected function setUp(): void
    {
        $this->module = new EmojiModule();
    }

    public function testIdReturnsDisableEmojis(): void
    {
        $this->assertSame('disable-emojis', $this->module->id());
    }

    public function testRunReturnsTrue(): void
    {
        $container = $this->createStub(ContainerInterface::class);
        $this->assertTrue($this->module->run($container));
    }

    public function testDisableEmojisTinymceRemovesWpEmoji(): void
    {
        $plugins = ['wpemoji', 'paste', 'link'];
        $result = $this->module->disableEmojisTinymce($plugins);

        $this->assertIsArray($result);
        $this->assertNotContains('wpemoji', $result);
        $this->assertContains('paste', $result);
        $this->assertContains('link', $result);
    }

    public function testDisableEmojisTinymceWithEmptyPlugins(): void
    {
        $result = $this->module->disableEmojisTinymce([]);
        $this->assertSame([], $result);
    }

    public function testDisableEmojisTinymceWithoutWpEmoji(): void
    {
        $plugins = ['paste', 'link'];
        $result = $this->module->disableEmojisTinymce($plugins);

        $this->assertCount(2, $result);
        $this->assertSame($plugins, $result);
    }

    public function testDisableEmojisRemoveDnsPrefetchStripsEmojiUrls(): void
    {
        $urls = [
            'https://s.w.org/images/core/emoji/14.0.0/',
            'https://example.com/style.css',
        ];
        $result = $this->module->disableEmojisRemoveDnsPrefetch($urls, 'dns-prefetch');

        $this->assertCount(1, $result);
        $this->assertContains('https://example.com/style.css', $result);
        $this->assertNotContains('https://s.w.org/images/core/emoji/14.0.0/', $result);
    }

    public function testDisableEmojisRemoveDnsPrefetchSkipsNonDnsRelation(): void
    {
        $urls = ['https://s.w.org/images/core/emoji/14.0.0/'];
        $result = $this->module->disableEmojisRemoveDnsPrefetch($urls, 'preconnect');

        $this->assertCount(1, $result);
    }

    public function testDisableEmojisRemoveDnsPrefetchWithEmptyUrls(): void
    {
        $result = $this->module->disableEmojisRemoveDnsPrefetch([], 'dns-prefetch');
        $this->assertSame([], $result);
    }

    public function testDisableEmojisRemoveDnsPrefetchIsCaseSensitive(): void
    {
        $urls = ['https://S.W.ORG/images/core/emoji/14.0.0/'];
        $result = $this->module->disableEmojisRemoveDnsPrefetch($urls, 'dns-prefetch');

        $this->assertCount(1, $result);
    }

    public function testDisableEmojisRunsWithoutError(): void
    {
        $this->module->disableEmojis();

        $this->addToAssertionCount(1);
    }
}
