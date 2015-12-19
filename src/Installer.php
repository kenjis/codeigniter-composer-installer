<?php
/**
 * Part of CodeIgniter Composer Installer
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/codeigniter-composer-installer
 */

namespace Kenjis\CodeIgniter;

use Composer\Script\Event;

class Installer
{
    const DOCROOT = 'public';

    /**
     * Composer post install script
     *
     * @param Event $event
     */
    public static function postInstall(Event $event = null)
    {
        // Copy CodeIgniter files
        self::recursiveCopy('vendor/codeigniter/framework/application', 'application');
        mkdir(static::DOCROOT, 0755);
        copy('vendor/codeigniter/framework/index.php', static::DOCROOT . '/index.php');
        copy('dot.htaccess', static::DOCROOT . '/.htaccess');

        // Fix paths in index.php
        $file = static::DOCROOT . '/index.php';
        $contents = file_get_contents($file);
        $contents = str_replace(
            '$system_path = \'system\';',
            '$system_path = \'../vendor/codeigniter/framework/system\';',
            $contents
        );
        $contents = str_replace(
            '$application_folder = \'application\';',
            '$application_folder = \'../application\';',
            $contents
        );
        file_put_contents($file, $contents);

        // Enable Composer Autoloader
        $file = 'application/config/config.php';
        $contents = file_get_contents($file);
        $contents = str_replace(
            '$config[\'composer_autoload\'] = FALSE;',
            '$config[\'composer_autoload\'] = realpath(APPPATH . \'../vendor/autoload.php\');',
            $contents
        );

        // Set 'index_page' blank
        $contents = str_replace(
            '$config[\'index_page\'] = \'index.php\';',
            '$config[\'index_page\'] = \'\';',
            $contents
        );
        file_put_contents($file, $contents);

        // Update composer.json
        copy('composer.json.dist', 'composer.json');

        // Run composer update
        self::composerUpdate();

        // Show message
        self::showMessage($event);

        // Delete unneeded files
        self::deleteSelf();
    }

    private static function composerUpdate()
    {
        passthru('composer update');
    }

    /**
     * Composer post install script
     *
     * @param Event $event
     */
    private static function showMessage(Event $event = null)
    {
        $io = $event->getIO();
        $io->write('==================================================');
        $io->write(
            '<info>`public/.htaccess` was installed. If you don\'t need it, please remove it.</info>'
        );
        $io->write(
            '<info>If you want to install translations for system messages or some third party libraries,</info>'
        );
        $io->write('$ cd <codeigniter_project_folder>');
        $io->write('$ php bin/install.php');
        $io->write('<info>Above command will show help message.</info>');
        $io->write('See <https://github.com/kenjis/codeigniter-composer-installer> for details');
        $io->write('==================================================');
    }

    private static function deleteSelf()
    {
        unlink(__FILE__);
        rmdir('src');
        unlink('composer.json.dist');
        unlink('dot.htaccess');
        unlink('LICENSE.md');
    }

    /**
     * Recursive Copy
     *
     * @param string $src
     * @param string $dst
     */
    private static function recursiveCopy($src, $dst)
    {
        mkdir($dst, 0755);
        
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($src, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $file) {
            if ($file->isDir()) {
                mkdir($dst . '/' . $iterator->getSubPathName());
            } else {
                copy($file, $dst . '/' . $iterator->getSubPathName());
            }
        }
    }
}
