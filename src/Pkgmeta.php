<?php

namespace WowPkgmeta;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Tests\A;
use Symfony\Component\Yaml\Yaml;

class Pkgmeta {
    protected $dependencies = [];

    public function __construct()
    {
    }

    public function load(string $yaml)
    {
        $yaml = Yaml::parse($yaml);

        if (!is_array($yaml) || !array_key_exists("externals", $yaml)) {
            throw new ParseException("Expected an externals: key");
        }

        $this->dependencies = [];

        foreach ($yaml['externals'] as $directory => $external) {
            $dependency = $this->createDependency($directory, $external);
            if ($dependency) {
                $this->dependencies []= $dependency;
            }
        }
    }

    public function downloadDependencies()
    {
        $zip = new \ZipArchive();
        $file = tmpfile();
        $zip->open($file);

        // TODO: Load the zipfile up with dependencies
    }

    /**
     * @param string $directory
     * @param array $details
     * @return null|Dependency
     * @throws \Exception
     */
    protected function createDependency(string $directory, array $details) : ?Dependency
    {
        $url = $details['url'];

        switch (1) {
            case preg_match("/^git:/", $url):
            case preg_match("/\.git$/", $url):
                return new GitDependency($directory, $details);
            case preg_match("/^svn:/", $url):
                return new SvnDependency($directory, $details);
            default:
                throw new \Exception("Unexpected url type: $url");
        }
    }
}