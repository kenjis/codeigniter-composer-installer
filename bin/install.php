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
                'site'  => 'github',
                'user'  => 'bcit-ci',
                'repos' => 'codeigniter3-translations',
                'name'  => 'Translations for CodeIgniter System Messages',
                'dir'   => 'language',
             ),
            'matches-cli' => array(
                'site'  => 'github',
                'user'  => 'avenirer',
                'repos' => 'codeigniter-matches-cli',
                'name'  => 'Codeigniter Matches CLI',
                'dir'   => array('config', 'controllers', 'views'),
                'msg'   => 'See http://avenirer.github.io/codeigniter-matches-cli/',
            ),
            'hmvc-modules' => array(
                'site'  => 'github',
                'user'  => 'jenssegers',
                'repos' => 'codeigniter-hmvc-modules',
                'name'  => 'CodeIgniter HMVC Modules (jenssegers)',
                'dir'   => array('core', 'third_party'),
                'msg'   => 'See https://github.com/jenssegers/codeigniter-hmvc-modules#installation',
            ),
            'modular-extensions-hmvc' => array(
                'site'  => 'bitbucket',
                'user'  => 'wiredesignz',
                'repos' => 'codeigniter-modular-extensions-hmvc',
                'name'  => 'Modular Extensions - HMVC (wiredesignz)',
                'dir'   => array('core', 'third_party'),
                'msg'   => 'See https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc',
            ),
            'ion-auth' => array(
                'site'  => 'github',
                'user'  => 'benedmunds',
                'repos' => 'CodeIgniter-Ion-Auth',
                'name'  => 'Codeigniter Matches CLI',
                'dir'   => array(
                    'config', 'controllers', 'language', 'libraries',
                    'migrations', 'models', 'sql', 'views'
                ),
                'msg'   => 'See http://benedmunds.com/ion_auth/',
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
        $msg .= "  php $self modular-extensions-hmvc codeigniter-3.x"  . PHP_EOL;
        $msg .= "  php $self ion-auth 2"  . PHP_EOL;

        return $msg;
    }

    public function install($package, $version)
    {
        if (! isset($this->packages[$package]))
        {
            return 'Error! no such package: ' . $package . PHP_EOL;
        }

        // github
        if ($this->packages[$package]['site'] === 'github') {
            $method = 'downloadFromGithub';
        } elseif ($this->packages[$package]['site'] === 'bitbucket') {
            $method = 'downloadFromBitbucket';
        } else {
            throw new LogicException(
                'Error! no such repos type: ' . $this->packages[$package]['site']
            );
        }
        
        list($src, $dst) = $this->$method($package, $version);

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
            @mkdir(__DIR__ . "/../application/$directory");
            $dst[] = realpath(__DIR__ . "/../application/$directory");
        }
        return [$src, $dst];
    }

    private function downloadFromBitbucket($package, $version)
    {
        $user = $this->packages[$package]['user'];
        $repos = $this->packages[$package]['repos'];
        // https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc/get/codeigniter-3.x.zip
        $url = "https://bitbucket.org/$user/$repos/get/$version.zip";
        $filepath = $this->download($url);
        $dirname = $this->unzip($filepath);

        $dir = $this->packages[$package]['dir'];
        
        if (is_string($dir)) {
            $src = realpath(dirname($filepath) . "/$dirname/$dir");
            $dst = realpath(__DIR__ . "/../application/$dir");
            return [$src, $dst];
        }
        
        foreach ($dir as $directory) {
            $src[] = realpath(dirname($filepath) . "/$dirname/$directory");
            @mkdir(__DIR__ . "/../application/$directory");
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
            $tmp = explode('/', $zip->getNameIndex(0));
            $dirname = $tmp[0];
            $zip->extractTo($this->tmp_dir . '/');
            $zip->close();
        } else {
            throw new RuntimeException('Failed to unzip: ' . $filepath);
        }
        
        return $dirname;
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
