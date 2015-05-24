#!/usr/bin/env php
<?php

$installer = new Installer();

if ($argc === 3) {
    $package = $argv[1];
    $version = $argv[2];
    echo $installer->install($package, $version);
} else {
    echo $installer->usage($argv[0]);
}


class Installer
{
    protected $tmp_dir;
    protected $packages = array();

    public function __construct() {
        $this->tmp_dir = __DIR__ . '/tmp';
        @mkdir($this->tmp_dir);
        
        $this->packages = [
            'translations' => array(
                'repos' => 'github',
                'user'  => 'bcit-ci',
                'repos' => 'codeigniter3-translations',
                'name'  => 'Translations for CodeIgniter System Messages',
                'dir'   => 'language',
             ),
            'matches-cli' => array(
                'repos' => 'github',
                'user'  => 'avenirer',
                'repos' => 'codeigniter-matches-cli',
                'name'  => 'Codeigniter Matches CLI',
                'dir'   => array('config', 'controllers', 'views'),
                'msg'   => 'See http://avenirer.github.io/codeigniter-matches-cli/',
            ),
            'hmvc-modules' => array(
                'repos' => 'github',
                'user'  => 'jenssegers',
                'repos' => 'codeigniter-hmvc-modules',
                'name'  => 'CodeIgniter HMVC Modules (jenssegers)',
                'dir'   => array('core', 'third_party'),
                'msg'   => 'See https://github.com/jenssegers/codeigniter-hmvc-modules#installation',
            ),
        ];
    }

    public function usage($self)
    {
        $msg = 'You can install:' . PHP_EOL;
        
        foreach ($this->packages as $key => $value) {
            $msg .= '  ' . $value['name'] . ' (' . $key . ')' . PHP_EOL;
        }
        
        $msg .= PHP_EOL;
        $msg .= 'Usage:' . PHP_EOL;
        $msg .= '  php install.php <package> <version/branch>'  . PHP_EOL;
        $msg .= PHP_EOL;
        $msg .= 'Examples:' . PHP_EOL;
        $msg .= "  php $self translations 3.0.0"  . PHP_EOL;
        $msg .= "  php $self translations develop"  . PHP_EOL;
        $msg .= "  php $self matches-cli master"  . PHP_EOL;
        $msg .= "  php $self hmvc-modules master"  . PHP_EOL;

        return $msg;
    }

    public function install($package, $version)
    {
        if (! isset($this->packages[$package]))
        {
            return 'Error! no such package: ' . $package . PHP_EOL;
        }

        // github
        list($src, $dst) = $this->downloadFromGithub($package, $version);

        $this->recursiveCopy($src, $dst);
        $this->recursiveUnlink($this->tmp_dir);

        $msg = 'Installed: ' . $package .PHP_EOL;
        if (isset($this->packages[$package]['msg'])) {
            $msg .= $this->packages[$package]['msg'] . PHP_EOL;
        }
        return $msg;
    }

    private function downloadFromGithub($package, $version)
    {
        $user = $this->packages[$package]['user'];
        $repos = $this->packages[$package]['repos'];
        $url = "https://github.com/$user/$repos/archive/$version.zip";
        $filepath = $this->download($url);
        $this->unzip($filepath);

        $dir = $this->packages[$package]['dir'];
        
        if (is_string($dir)) {
            $src = realpath(dirname($filepath) . "/$repos-$version/$dir");
            $dst = realpath(__DIR__ . "/../application/$dir");
            return [$src, $dst];
        }
        
        foreach ($dir as $directory) {
            $src[] = realpath(dirname($filepath) . "/$repos-$version/$directory");
            $dst[] = realpath(__DIR__ . "/../application/$directory");
        }
        return [$src, $dst];
    }

    private function download($url)
    {
        $file = file_get_contents($url);
        if ($file === false) {
            throw new RuntimeException("Can't download: $url");
        }
        echo 'Downloaed: ' . $url . PHP_EOL;
        
        $urls = parse_url($url);
        $filepath = $this->tmp_dir . '/' . basename($urls['path']);
        file_put_contents($filepath, $file);
        
        return $filepath;
    }

    private function unzip($filepath)
    {
        $zip = new ZipArchive();
        if ($zip->open($filepath) === TRUE) {
            $zip->extractTo($this->tmp_dir . '/');
            $zip->close();
        } else {
            throw new RuntimeException('Failed to unzip: ' . $filepath);
        }
    }

    /**
     * Recursive Copy
     *
     * @param string $src
     * @param string $dst
     */
    private function recursiveCopy($src, $dst)
    {
        if (is_array($src)) {
            foreach ($src as $key => $source) {
                $this->recursiveCopy($source, $dst[$key]);
            }
            
            return;
        }

        @mkdir($dst, 0755);
        
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($src, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $file) {
            if ($file->isDir()) {
                @mkdir($dst . '/' . $iterator->getSubPathName());
            } else {
                $success = copy($file, $dst . '/' . $iterator->getSubPathName());
                if ($success) {
                    echo 'copied: ' . $dst . '/' . $iterator->getSubPathName() . PHP_EOL;
                }
            }
        }
    }

    /**
     * Recursive Unlink
     *
     * @param string $dir
     */
    private function recursiveUnlink($dir)
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        
        foreach ($iterator as $file) {
            if ($file->isDir()) {
                rmdir($file);
            } else {
                unlink($file);
            }
        }
        
        rmdir($dir);
    }
}
