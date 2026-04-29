<?php

declare(strict_types=1);

namespace RyanHellyer\DisableEmojis;

use Inpsyde\Modularity\Module\ExecutableModule;
use Psr\Container\ContainerInterface;

class EmojiModule implements ExecutableModule
{
    public function id(): string
    {
        return 'disable-emojis';
    }

    public function run(ContainerInterface $container): bool
    {
        add_action('init', [$this, 'disableEmojis']);
        return true;
    }

    public function disableEmojis(): void
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('tiny_mce_plugins', [$this, 'disableEmojisTinymce']);
        add_filter('wp_resource_hints', [$this, 'disableEmojisRemoveDnsPrefetch'], 10, 2);
    }

    public function disableEmojisTinymce(array $plugins): array
    {
        if (is_array($plugins)) {
            return array_diff($plugins, ['wpemoji']);
        }

        return [];
    }

    public function disableEmojisRemoveDnsPrefetch(array $urls, string $relation_type): array
    {
        if ($relation_type === 'dns-prefetch') {
            $emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
            foreach ($urls as $key => $url) {
                if (strpos($url, $emoji_svg_url_bit) !== false) {
                    unset($urls[$key]);
                }
            }
        }

        return $urls;
    }
}
