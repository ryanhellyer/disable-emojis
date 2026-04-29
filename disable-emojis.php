<?php

/*
Plugin Name: Disable Emojis (GDPR friendly)
Plugin URI: https://geek.hellyer.kiwi/plugins/disable-emojis/
Description: Disable Emojis (GDPR friendly)
Version: 1.8
Author: Ryan Hellyer
Author URI: https://geek.hellyer.kiwi/
License: GPL2

------------------------------------------------------------------------
Copyright Ryan Hellyer

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

*/

declare(strict_types=1);

use Inpsyde\Modularity\Package;
use Inpsyde\Modularity\Properties\PluginProperties;
use RyanHellyer\DisableEmojis\EmojiModule;

$autoloader = __DIR__ . '/vendor/autoload.php';
if (! file_exists($autoloader)) {
    return;
}
require_once $autoloader;

$properties = PluginProperties::new(__FILE__);
$package = Package::new($properties);
$package->addModule(new EmojiModule());
$package->boot();
